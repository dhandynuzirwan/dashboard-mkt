<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Holiday; 
use Carbon\Carbon;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- HITUNG HARI KERJA (FULL BULAN & BERJALAN) ---
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        // Ambil daftar libur bulan ini dari database
        $daftarLibur = Holiday::whereBetween('tanggal', [
            $startOfMonth->format('Y-m-d'), 
            $endOfMonth->format('Y-m-d')
        ])->pluck('tanggal')->toArray();

        $hariEfektifSebulan = 0;
        $hariEfektifBerjalan = 0;
        
        // Batas akhir perhitungan berjalan adalah Hari Ini (Jika $end melewati hari ini)
        $batasAkhirBerjalan = min($end, Carbon::now()->format('Y-m-d'));

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                // Hitung total hari efektif sebulan penuh
                $hariEfektifSebulan++;
                
                // Hitung hari efektif yang sudah dilewati (berjalan)
                if ($date->format('Y-m-d') <= $batasAkhirBerjalan) {
                    $hariEfektifBerjalan++;
                }
            }
        }

        // 3. 🔐 FILTER ROLE & MARKETING
        $query = User::where('role', 'marketing');
        if ($authUser->role === 'marketing') {
            $query->where('id', $authUser->id);
        } elseif ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        $users = $query->get();

        // 4. --- MAPPING DATA KPI ---
        // 🔥 PASTIKAN $hariEfektifBerjalan MASUK KE DALAM "use" 🔥
        $marketings = $users->map(function ($user) use ($hariEfektifSebulan, $hariEfektifBerjalan, $start, $end) {

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $user->id)->first();
            $target_call = $penggajian->target_call ?? 0;
            $target_revenue = $penggajian->target ?? 0;

            // 🔥 OPSI: Batasan Maksimal KPI 
            // (Jika true, achievement mentok 100%, sehingga Skor KPI max 10/30/60)
            $kpiCapped = true;

            // ================= ABSENSI (HADIR + IZIN APPROVED) =================
            $user->absensi_jadwal = $hariEfektifSebulan;
            
            $hadirMesin = AbsensiLog::where('user_id', $user->id)
                ->where('tipe', 'in')
                ->whereBetween('tanggal', [$start, $end])
                ->distinct('tanggal')
                ->count();

            $izinApproved = Perizinan::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereBetween('tanggal', [$start, $end])
                ->count();

            // 🔥 TAMPILAN VISUAL JUJUR: Tampilkan kehadiran apa adanya (Misal: 19)
            $user->absensi_hadir = $hadirMesin + $izinApproved;

            // 🔥 RUMUS PINTAR: Hitung Achievement dari HARI BERJALAN
            // Misal: Hadir 19 hari / 19 Hari Berjalan = 100% (Meskipun jadwal fullnya 21)
            $user->absensi_ach = ($hariEfektifBerjalan > 0)
                ? ($user->absensi_hadir / $hariEfektifBerjalan) * 100
                : 0;

            // Eksekusi Limit (Cap) Absensi agar tidak tembus > 100% jika ada anomali
            $hitungAbsensiAch = $kpiCapped ? min(100, $user->absensi_ach) : $user->absensi_ach;
            
            // Bobot Absensi 10%
            $user->absensi_kpi = ($hitungAbsensiAch / 100) * 10; 

            // ================= PROGRESS (CTA / PENAWARAN) =================
            $user->progress_target = $target_call * 23;

            $baseCtaQuery = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]); 
            });

            $jumlahCtaBase = (clone $baseCtaQuery)->count();
            $jumlahCtaBerstatus = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->count();

            $user->progress_real = $jumlahCtaBase + $jumlahCtaBerstatus;

            // Achievement Progress (Murni)
            $user->progress_ach = ($user->progress_target > 0)
                ? ($user->progress_real / $user->progress_target) * 100
                : 0;

            // Eksekusi Limit (Cap) Progress
            $hitungProgressAch = $kpiCapped ? min(100, $user->progress_ach) : $user->progress_ach;
            
            // Bobot Progress 30%
            $user->progress_kpi = ($hitungProgressAch / 100) * 30;

            // ================= REVENUE (DEAL) =================
            $user->revenue_target = $target_revenue;

            $user->revenue_actual = Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                    $q->where('marketing_id', $user->id)
                      ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
                })
                ->where('status_penawaran', 'deal')
                ->get() 
                ->sum(fn($item) => $item->harga_penawaran * $item->jumlah_peserta); 

            // Achievement Revenue (Murni)
            $user->revenue_ach = ($user->revenue_target > 0)
                ? ($user->revenue_actual / $user->revenue_target) * 100
                : 0;

            // Eksekusi Limit (Cap) Revenue
            $hitungRevenueAch = $kpiCapped ? min(100, $user->revenue_ach) : $user->revenue_ach;
            
            // Bobot Revenue 60%
            $user->revenue_kpi = ($hitungRevenueAch / 100) * 60;

            // ================= TOTAL KPI (FINAL SCORE) =================
            $user->total_kpi = $user->absensi_kpi + $user->progress_kpi + $user->revenue_kpi;

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        return view('data-kpi', compact('marketings', 'start', 'end', 'all_marketing', 'hariEfektifSebulan'));
    }
}
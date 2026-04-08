<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Holiday; // 1. PASTIKAN MODEL HOLIDAY DIPANGGIL
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

        // 2. --- HITUNG HARI KERJA (FULL 1 BULAN + DETEKSI LIBUR) ---
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        // Ambil daftar libur bulan ini dari database
        $daftarLibur = Holiday::whereBetween('tanggal', [
            $startOfMonth->format('Y-m-d'), 
            $endOfMonth->format('Y-m-d')
        ])->pluck('tanggal')->toArray();

        $hariEfektifSebulan = 0;
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            // Logika: Hari kerja (Senin-Jumat) DAN tidak ada di daftarLibur
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektifSebulan++;
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
        $marketings = $users->map(function ($user) use ($hariEfektifSebulan, $start, $end) {

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $user->id)->first();
            $target_call = $penggajian->target_call ?? 0;
            $target_revenue = $penggajian->target ?? 0;

            // ================= ABSENSI (HADIR + IZIN APPROVED) =================
            // Target Jadwal: Diambil dari sebulan penuh (dikurangi libur)
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

            $user->absensi_hadir = $hadirMesin + $izinApproved;

            // Achievement vs JADWAL SEBULAN
            $user->absensi_ach = ($hariEfektifSebulan > 0)
                ? min(100, ($user->absensi_hadir / $hariEfektifSebulan) * 100)
                : 0;

            // Bobot Absensi 10%
            $user->absensi_kpi = ($user->absensi_ach / 100) * 0.1 * 100; 

            // ================= PROGRESS (CTA / PENAWARAN) =================
            // Target: target harian x JADWAL SEBULAN (dikurangi libur)
            $user->progress_target = $target_call * $hariEfektifSebulan;

            // Buat Base Query agar tidak perlu menulis ulang whereHas berulang kali
            $baseCtaQuery = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"]);

            // 1. Hitung JUMLAH SEMUA CTA
            $jumlahCtaBase = (clone $baseCtaQuery)->count();

            // 2. Hitung JUMLAH CTA YANG MEMILIKI STATUS
            $jumlahCtaBerstatus = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->count();

            // 3. RUMUS BARU: Total CTA + Total CTA Berstatus
            $user->progress_real = $jumlahCtaBase + $jumlahCtaBerstatus;

            $user->progress_ach = ($user->progress_target > 0)
                ? ($user->progress_real / $user->progress_target) * 100
                : 0;

            // Bobot Progress 30%
            $user->progress_kpi = ($user->progress_ach / 100) * 0.3 * 100;

            // ================= REVENUE (DEAL) =================
            $user->revenue_target = $target_revenue;

            // FIX: Hitung Nilai Deal = Harga Penawaran x Jumlah Peserta
            $user->revenue_actual = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->where('status_penawaran', 'deal')
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                ->get() // Ambil collection dulu
                ->sum(fn($item) => $item->harga_penawaran * $item->jumlah_peserta); // Lakukan perkalian

            $user->revenue_ach = ($user->revenue_target > 0)
                ? ($user->revenue_actual / $user->revenue_target) * 100
                : 0;

            // Bobot Revenue 60%
            $user->revenue_kpi = ($user->revenue_ach / 100) * 0.6 * 100;

            // ================= TOTAL KPI (FINAL SCORE) =================
            $user->total_kpi = $user->absensi_kpi + $user->progress_kpi + $user->revenue_kpi;

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        return view('data-kpi', compact('marketings', 'start', 'end', 'all_marketing', 'hariEfektifSebulan'));
    }
}
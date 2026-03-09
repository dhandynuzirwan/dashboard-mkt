<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Holiday;
use App\Models\Perizinan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- HITUNG HARI KERJA (FULL 1 BULAN) ---
        // 1. Tentukan rentang awal dan akhir bulan berdasarkan filter $start
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        // 2. Ambil daftar tanggal merah bulan ini dari database
        $daftarLibur = \App\Models\Holiday::whereBetween('tanggal', [
                $startOfMonth->format('Y-m-d'), 
                $endOfMonth->format('Y-m-d')
            ])->pluck('tanggal')->toArray();

        // 3. Hitung Hari Efektif (Hanya Senin-Jumat & Bukan Tanggal Merah)
        $hariEfektif = 0; 

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            // Logika: Jika hari biasa (Senin-Jumat) DAN tidak terdaftar di tabel Holiday
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektif++;
            }
        }

        // 3. 🔐 FILTER USER
        $query = User::where('role', 'marketing');
        if ($authUser->role === 'marketing') {
            $query->where('id', $authUser->id);
        } elseif ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        $users = $query->get();

        $marketings = $users->map(function ($user) use ($hariEfektif, $start, $end) {

            // ================= DATA GAJI DASAR =================
            $gaji = Penggajian::where('user_id', $user->id)->first();
            $gapokDasar        = $gaji->gaji_pokok ?? 0;
            $tunjangan         = $gaji->tunjangan ?? 0;
            $targetCallHarian  = $gaji->target_call ?? 0;
            $targetRevenue     = $gaji->target ?? 0;

            // ================= KPI 1: ABSENSI (10%) =================
            $hadirMesin = AbsensiLog::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start, $end])->distinct()->count('tanggal');

            $izinApproved = Perizinan::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start, $end])->where('status', 'approved')->count();

            $totalHadirKpi = $hadirMesin + $izinApproved;
            $absensiAch = ($hariEfektif > 0) ? min(100, ($totalHadirKpi / $hariEfektif) * 100) : 0;
            $absensiKpi = $absensiAch * 0.1; 

            // ================= KPI 2: PROGRESS (30%) =================
            $progressReal = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                ->count();
                
            $progressTarget = $targetCallHarian * $hariEfektif;
            $progressAch = ($progressTarget > 0) ? ($progressReal / $progressTarget) * 100 : 0;
            $progressKpi = $progressAch * 0.3; 

            // ================= KPI 3: REVENUE (60%) =================
            $incomeDeal = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->where('status_penawaran', 'deal')
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                ->get()
                ->sum(fn($item) => $item->harga_penawaran * $item->jumlah_peserta);

            $revenueAch = ($targetRevenue > 0) ? ($incomeDeal / $targetRevenue) * 100 : 0;
            $revenueKpi = $revenueAch * 0.6;

            $totalKpiPersen = ($absensiKpi + $progressKpi + $revenueKpi);

            // ================= ASSIGN KE OBJECT (SESUAI 10:30:60) =================
            $user->income = $incomeDeal;
            $user->kpi_persen = $totalKpiPersen;
            
            // KEMBALIKAN KE NILAI KPI (Bukan Achievement Mentah)
            $user->ach_absensi  = $absensiKpi;  // Misal: 10.0%
            $user->ach_progress = $progressKpi; // Misal: 30.0%
            $user->ach_revenue  = $revenueKpi;  // Misal: 60.0%

            // ================= PERHITUNGAN GAJI =================
            $user->gapok_hitung = ($hariEfektif > 0) ? ($totalHadirKpi / $hariEfektif) * $gapokDasar : 0;

            $nilai_revenueKpi = $user->income * 0.6; 
            $user->weighted_revenue_rp = $nilai_revenueKpi;
            $multiplier = ($totalKpiPersen < 70) ? 0.025 : 0.05;
            $user->fee_marketing = $nilai_revenueKpi * $multiplier;

            $user->progress_val = $gapokDasar * ($progressKpi / 100);
            
            $user->tunj_kemahalan = ($tunjangan / $hariEfektif) * $totalHadirKpi;
            $user->total_gaji = $user->gapok_hitung + $user->fee_marketing + $user->progress_val + $user->tunj_kemahalan;

            // Variabel detail untuk label di Blade
            $user->absensi_hadir_real = $totalHadirKpi;
            $user->target_penawaran    = $progressTarget;
            $user->real_penawaran      = $progressReal;

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();
        // Pakai nama $hariEfektif agar Blade tidak error "Undefined variable"
        return view('simulasi-gaji', compact('marketings', 'hariEfektif', 'start', 'end', 'all_marketing'));
    }
}
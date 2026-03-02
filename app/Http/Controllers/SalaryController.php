<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan; // Tambahkan ini
use Carbon\Carbon;
use Illuminate\Http\Request; // Pastikan ini ada

class SalaryController extends Controller
{
    public function index(Request $request) // Tambahkan parameter Request
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        // Default: Awal bulan ini sampai hari ini
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- HITUNG HARI KERJA EFEKTIF (Senin-Jumat) BERDASARKAN RENTANG ---
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $hariEfektif = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) { 
                $hariEfektif++;
            }
        }

        // 3. 🔐 FILTER USER BERDASARKAN ROLE & INPUT
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

            // ================= KPI ABSENSI (HADIR + IZIN APPROVED) =================
            // 1. Hitung Hadir Real dari Mesin
            $hadirMesin = AbsensiLog::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start, $end])
                ->distinct()
                ->count('tanggal');

            // 2. Hitung Izin yang 'Approved'
            $izinApproved = Perizinan::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start, $end])
                ->where('status', 'approved')
                ->count();

            $totalHadirKpi = $hadirMesin + $izinApproved;

            // Cap kehadiran maksimal 100% dari hari efektif agar KPI tidak jebol
            $absensiAch = ($hariEfektif > 0) ? min(100, ($totalHadirKpi / $hariEfektif) * 100) : 0;
            $absensiKpi = $absensiAch * 0.1; // Bobot 10%

            // ================= KPI PROGRESS (Closing Penawaran / CTA) =================
            // Sesuai permintaanmu: Pencapaian dihitung dari yang sudah CTA (Penawaran)
            $progressReal = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                ->count();
                
            $progressTarget = $targetCallHarian * $hariEfektif;
            $progressAch = ($progressTarget > 0) ? ($progressReal / $progressTarget) * 100 : 0;
            $progressKpi = $progressAch * 0.3; // Bobot 30%

            // ================= KPI REVENUE (DEAL) =================
            $incomeDeal = Cta::whereHas('prospek', function ($q) use ($user) {
                    $q->where('marketing_id', $user->id);
                })
                ->where('status_penawaran', 'deal')
                ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
                ->sum('harga_penawaran');

            $revenueAch = ($targetRevenue > 0) ? ($incomeDeal / $targetRevenue) * 100 : 0;
            $revenueKpi = $revenueAch * 0.6; // Bobot 60%

            // TOTAL KPI %
            $totalKpiPersen = ($absensiKpi + $progressKpi + $revenueKpi);

            // ================= PERHITUNGAN GAJI FINAL =================
            $user->income = $incomeDeal;
            $user->kpi_persen = $totalKpiPersen;

            // Masukkan variabel KPI ke dalam objek user agar bisa dipanggil di Blade
            $user->ach_absensi  = $absensiKpi;  // <--- TAMBAHKAN INI
            $user->ach_progress = $progressKpi; // <--- TAMBAHKAN INI
            $user->ach_revenue  = $revenueKpi;  // <--- TAMBAHKAN INI

            // Gaji Pokok Proporsional
            $user->gapok_hitung = ($hariEfektif > 0) 
                ? ($totalHadirKpi / $hariEfektif) * $gapokDasar 
                : 0;

            // Fee Marketing (Gunakan revenueKpi sebagai pengali sesuai logika tabel)
            $multiplier = ($totalKpiPersen < 70) ? 0.025 : 0.05;
            $user->fee_marketing = $user->income * ($revenueKpi / 100) * $multiplier;

            // Bonus dari kedisiplinan (Progress Value)
            $user->progress_val = ($absensiKpi / 100) * $user->gapok_hitung;
            
            $user->tunj_kemahalan = $tunjangan;
            $user->total_gaji = $user->gapok_hitung + $user->fee_marketing + $user->progress_val + $user->tunj_kemahalan;

            // Data pendukung lainnya
            $user->absensi_hadir_real = $hadirMesin;
            $user->izin_approved = $izinApproved;
            $user->target_penawaran = $progressTarget;
            $user->real_penawaran = $progressReal;

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        return view('simulasi-gaji', compact('marketings', 'hariEfektif', 'start', 'end', 'all_marketing'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini

class SalaryController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $authUser = auth()->user();

        // 1. --- HITUNG HARI KERJA EFEKTIF (Senin-Jumat) BULAN INI ---
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $hariEfektif = 0;

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday()) { 
                $hariEfektif++;
            }
        }

        // 2. 🔐 FILTER BERDASARKAN ROLE
        if ($authUser->role === 'marketing') {
            $users = User::where('id', $authUser->id)->get();
        } else {
            $users = User::where('role', 'marketing')->get();
        }

        $marketings = $users->map(function ($user) use ($hariEfektif, $now) {

            // ================= DATA GAJI DARI SETTING PENGGAJIAN =================
            $gaji = Penggajian::where('user_id', $user->id)->first();

            $gapokDasar = $gaji->gaji_pokok ?? 0;
            $tunjanganKemahalan = $gaji->tunjangan ?? 0;
            $targetCallHarian = $gaji->target_call ?? 0;
            $targetRevenue = $gaji->target ?? 0;

            // ================= KPI ABSENSI (DINAMIS) =================
            // Hitung hadir real dari AbsensiLog bulan ini
            $absensiHadir = AbsensiLog::where('user_id', $user->id)
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->distinct()
                ->count('tanggal');

            $absensiAch = ($hariEfektif > 0)
                ? ($absensiHadir / $hariEfektif) * 100
                : 0;

            // Bobot Absensi 10%
            $absensiKpi = $absensiAch * 0.1;

            // ================= KPI PROGRESS (PROSPEK) =================
            // Hanya hitung prospek yang dibuat di bulan ini
            $progressReal = Prospek::where('marketing_id', $user->id)
                ->whereMonth('created_at', $now->month)
                ->count();
                
            $progressTarget = $targetCallHarian * $hariEfektif;

            $progressAch = ($progressTarget > 0)
                ? ($progressReal / $progressTarget) * 100
                : 0;

            $progressKpi = $progressAch * 0.3;

            // ================= KPI REVENUE (DEAL) =================
            // Hanya hitung closing/deal yang terjadi di bulan ini
            $incomeDeal = Cta::whereHas('prospek', function ($q) use ($user, $now) {
                $q->where('marketing_id', $user->id)
                  ->whereMonth('created_at', $now->month);
            })
                ->where('status_penawaran', 'deal')
                ->sum('harga_penawaran');

            $revenueAch = ($targetRevenue > 0)
                ? ($incomeDeal / $targetRevenue) * 100
                : 0;

            $revenueKpi = $revenueAch * 0.6;

            // TOTAL KPI % (Maksimal 100%)
            $totalKpiPersen = ($absensiKpi + $progressKpi + $revenueKpi);

            // ================= SIMULASI GAJI FINAL =================
            $user->income = $incomeDeal;
            $user->kpi_persen = $totalKpiPersen;

            // GAPOK dihitung proporsional berdasarkan kehadiran (Prerata)
            $user->gapok_hitung = ($hariEfektif > 0)
                ? ($absensiHadir / $hariEfektif) * $gapokDasar
                : 0;

            // Fee Marketing (Multiplier berubah jika KPI di bawah 70%)
            $multiplier = ($totalKpiPersen < 70) ? 0.025 : 0.05;
            $user->fee_marketing = $user->income * ($totalKpiPersen / 100) * $multiplier;

            // Progress value (Bonus dari kedisiplinan absensi)
            $user->progress_val = ($absensiKpi / 100) * $user->gapok_hitung;

            $user->tunj_kemahalan = $tunjanganKemahalan;
            $user->absensi_hadir_real = $absensiHadir; // Untuk ditampilkan di blade

            // TOTAL GAJI BERSIH
            $user->total_gaji =
                $user->gapok_hitung +
                $user->fee_marketing +
                $user->progress_val +
                $user->tunj_kemahalan;

            // Simpan breakdown KPI untuk tampilan
            $user->ach_absensi = $absensiKpi;
            $user->ach_progress = $progressKpi;
            $user->ach_revenue = $revenueKpi;

            return $user;
        });

        return view('simulasi-gaji', compact('marketings', 'hariEfektif'));
    }
}
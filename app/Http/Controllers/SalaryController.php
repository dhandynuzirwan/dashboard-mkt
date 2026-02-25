<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;

class SalaryController extends Controller
{
    public function index()
    {
        $hariEfektif = 22;
        $authUser = auth()->user();

        // 🔐 FILTER BERDASARKAN ROLE
        if ($authUser->role === 'marketing') {
            $users = User::where('id', $authUser->id)->get();
        } else {
            $users = User::where('role', 'marketing')->get();
        }

        $marketings = $users->map(function ($user) use ($hariEfektif) {

            // ================= DATA GAJI =================
            $gaji = Penggajian::where('user_id', $user->id)->first();

            $gapokDasar = $gaji->gaji_pokok ?? 0;
            $tunjanganKemahalan = $gaji->tunjangan ?? 0;
            $targetCallHarian = $gaji->target_call ?? 0;
            $targetRevenue = $gaji->target ?? 0;

            // ================= KPI =================
            $absensiHadir = 20; // sementara statis
            $absensiAch = ($hariEfektif > 0)
                ? ($absensiHadir / $hariEfektif) * 100
                : 0;

            $absensiKpi = $absensiAch * 0.1;

            $progressReal = Prospek::where('marketing_id', $user->id)->count();
            $progressTarget = $targetCallHarian * $hariEfektif;

            $progressAch = ($progressTarget > 0)
                ? ($progressReal / $progressTarget) * 100
                : 0;

            $progressKpi = $progressAch * 0.3;

            $incomeDeal = Cta::whereHas('prospek', function ($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })
                ->where('status_penawaran', 'deal')
                ->sum('harga_penawaran');

            $revenueAch = ($targetRevenue > 0)
                ? ($incomeDeal / $targetRevenue) * 100
                : 0;

            $revenueKpi = $revenueAch * 0.6;

            // TOTAL KPI %
            $totalKpiPersen = ($absensiKpi + $progressKpi + $revenueKpi);

            // ================= SIMULASI GAJI =================
            $user->income = $incomeDeal;
            $user->kpi_persen = $totalKpiPersen;

            // GAPOK berdasarkan kehadiran
            $user->gapok_hitung = ($hariEfektif > 0)
                ? ($absensiHadir / $hariEfektif) * $gapokDasar
                : 0;

            // Fee Marketing
            $multiplier = ($totalKpiPersen < 70) ? 0.025 : 0.05;
            $user->fee_marketing = $user->income * ($totalKpiPersen / 100) * $multiplier;

            // Progress value
            $user->progress_val = ($absensiKpi / 100) * $user->gapok_hitung;

            $user->tunj_kemahalan = $tunjanganKemahalan;

            // TOTAL GAJI
            $user->total_gaji =
                $user->gapok_hitung +
                $user->fee_marketing +
                $user->progress_val +
                $user->tunj_kemahalan;

            // KPI Breakdown
            $user->ach_absensi = $absensiKpi;
            $user->ach_progress = $progressKpi;
            $user->ach_revenue = $revenueKpi;

            return $user;
        });

        return view('simulasi-gaji', compact('marketings'));
    }
}

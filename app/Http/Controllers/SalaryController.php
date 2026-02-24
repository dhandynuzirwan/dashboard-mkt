<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cta;
use App\Models\Prospek;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $hariEfektif = 22; 

        $marketings = User::where('role', 'marketing')->get()->map(function($user) use ($hariEfektif) {
            // 1. DATA DASAR DARI PENGGAJIAN
            $gaji = Penggajian::where('user_id', $user->id)->first();
            $gapokDasar = $gaji->gaji_pokok ?? 0;
            $tunjanganKemahalan = $gaji->tunjangan ?? 0;
            $targetCallHarian = $gaji->target_call_harian ?? 0;
            $targetRevenue = $gaji->target_revenue ?? 0;

            // 2. HITUNG KPI (Sama seperti halaman Data KPI)
            $absensiHadir = 20; // Placeholder nanti ambil dari tabel Absensi
            $absensiAch = ($absensiHadir / $hariEfektif) * 100;

            $progressReal = Prospek::where('marketing_id', $user->id)->count();
            $progressTarget = $targetCallHarian * $hariEfektif;
            $progressAch = ($progressTarget > 0) ? ($progressReal / $progressTarget) * 100 : 0;

            $incomeDeal = Cta::whereHas('prospek', function($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })->where('status_penawaran', 'Deal')->sum('harga_penawaran');
            
            $revenueAch = ($targetRevenue > 0) ? ($incomeDeal / $targetRevenue) * 100 : 0;

            // TOTAL KPI (Rata-rata)
            $totalKpiPersen = ($absensiAch + $progressAch + $revenueAch) / 3;

            // 3. LOGIKA SIMULASI GAJI
            $user->income = $incomeDeal;
            $user->kpi_persen = $totalKpiPersen;

            // GAPOK (Berdasarkan jumlah kehadiran dalam bentuk nominal)
            // User minta ditulis dalam bentuk presentasi kehadiran terhadap Gapok Dasar
            $user->gapok_hitung = ($absensiHadir / $hariEfektif) * $gapokDasar;

            // FEE MARKETING: income * KPI * (2.5 atau 5)
            // Asumsi: 2.5% jika KPI < 70%, 5% jika >= 70%
            $multiplier = ($totalKpiPersen < 70) ? 0.025 : 0.05;
            $user->fee_marketing = $user->income * ($totalKpiPersen / 100) * $multiplier;

            // PROGRESS: Persen Absensi * GAPOK
            $user->progress_val = ($absensiAch / 100) * $user->gapok_hitung;

            $user->tunj_kemahalan = $tunjanganKemahalan;

            // TOTAL: Gapok + Fee Marketing + Progress + Tunj Kemahalan
            $user->total_gaji = $user->gapok_hitung + $user->fee_marketing + $user->progress_val + $user->tunj_kemahalan;

            // Data untuk kolom "Sesuai KPI" (Hanya nilai Ach)
            $user->ach_absensi = $absensiAch;
            $user->ach_progress = $progressAch;
            $user->ach_revenue = $revenueAch;

            return $user;
        });

        return view('simulasi-gaji', compact('marketings'));
    }
}
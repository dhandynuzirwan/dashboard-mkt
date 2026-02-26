<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini

class KpiController extends Controller
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

        // 2. 🔐 FILTER ROLE
        if ($authUser->role === 'marketing') {
            $users = User::where('id', $authUser->id)->get();
        } else {
            $users = User::where('role', 'marketing')->get();
        }

        $marketings = $users->map(function ($user) use ($hariEfektif, $now) {

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $user->id)->first();

            $target_call = $penggajian->target_call ?? 0;
            $target = $penggajian->target ?? 0;

            // ================= ABSENSI (DINAMIS) =================
            $user->absensi_jadwal = $hariEfektif;
            
            // Hitung hadir real dari AbsensiLog
            $user->absensi_hadir = AbsensiLog::where('user_id', $user->id)
                ->where('tipe', 'in')
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->distinct('tanggal')
                ->count();

            $user->absensi_ach = ($hariEfektif > 0)
                ? ($user->absensi_hadir / $hariEfektif) * 100
                : 0;

            // Bobot Absensi 10%
            $user->absensi_kpi = ($user->absensi_ach / 100) * 0.1 * 100; 

            // ================= PROGRESS (PROSPEK) =================
            $user->progress_target = $target_call * $hariEfektif;

            $user->progress_real = Prospek::where('marketing_id', $user->id)
                ->whereMonth('created_at', $now->month) // Filter bulan ini
                ->count();

            $user->progress_ach = ($user->progress_target > 0)
                ? ($user->progress_real / $user->progress_target) * 100
                : 0;

            // Bobot Progress 30%
            $user->progress_kpi = ($user->progress_ach / 100) * 0.3 * 100;

            // ================= REVENUE (DEAL) =================
            $user->revenue_target = $target;

            $user->revenue_actual = Cta::whereHas('prospek', function ($q) use ($user, $now) {
                $q->where('marketing_id', $user->id)
                  ->whereMonth('created_at', $now->month);
            })
                ->where('status_penawaran', 'deal')
                ->sum('harga_penawaran');

            $user->revenue_ach = ($user->revenue_target > 0)
                ? ($user->revenue_actual / $user->revenue_target) * 100
                : 0;

            // Bobot Revenue 60%
            $user->revenue_kpi = ($user->revenue_ach / 100) * 0.6 * 100;

            // ================= TOTAL KPI (FINAL SCORE) =================
            // Hasil akhir adalah nilai 1-100
            $user->total_kpi = $user->absensi_kpi + $user->progress_kpi + $user->revenue_kpi;

            return $user;
        });

        return view('data-kpi', compact('marketings'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;

class KpiController extends Controller
{
    public function index()
    {
        $hariEfektif = 22;
        $authUser = auth()->user();

        // 🔐 FILTER ROLE
        if ($authUser->role === 'marketing') {
            $users = User::where('id', $authUser->id)->get();
        } else {
            $users = User::where('role', 'marketing')->get();
        }

        $marketings = $users->map(function ($user) use ($hariEfektif) {

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $user->id)->first();

            $target_call = $penggajian->target_call ?? 0;
            $target = $penggajian->target ?? 0;

            // ================= ABSENSI =================
            $user->absensi_jadwal = $hariEfektif;
            $user->absensi_hadir = 20; // sementara statis
            $user->absensi_ach = ($hariEfektif > 0)
                ? ($user->absensi_hadir / $hariEfektif) * 100
                : 0;

            $user->absensi_kpi = $user->absensi_ach * 0.1;

            // ================= PROGRESS =================
            $user->progress_target = $target_call * $hariEfektif;

            $user->progress_real = Prospek::where('marketing_id', $user->id)->count();

            $user->progress_ach = ($user->progress_target > 0)
                ? ($user->progress_real / $user->progress_target) * 100
                : 0;

            $user->progress_kpi = $user->progress_ach * 0.3;

            // ================= REVENUE =================
            $user->revenue_target = $target;

            $user->revenue_actual = Cta::whereHas('prospek', function ($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })
                ->where('status_penawaran', 'deal') // kecil semua biar konsisten
                ->sum('harga_penawaran');

            $user->revenue_ach = ($user->revenue_target > 0)
                ? ($user->revenue_actual / $user->revenue_target) * 100
                : 0;

            $user->revenue_kpi = $user->revenue_ach * 0.6;

            // ================= TOTAL KPI =================
            $user->total_kpi =
                ($user->absensi_ach * 0.1) +
                ($user->progress_ach * 0.3) +
                ($user->revenue_ach * 0.6);

            return $user;
        });

        return view('data-kpi', compact('marketings'));
    }
}

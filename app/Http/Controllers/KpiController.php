<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cta;
use App\Models\Prospek;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function index()
    {
        $hariEfektif = 22; // Bisa dibuat dinamis nanti

        $marketings = User::where('role', 'marketing')->get()->map(function($user) use ($hariEfektif) {
            // 1. AMBIL TARGET DARI TABEL PENGGAJIAN
            $penggajian = Penggajian::where('user_id', $user->id)->first();
            
            $target_call = $penggajian->target_call ?? 0;
            $target    = $penggajian->target ?? 0;

            // 2. LOGIKA ABSENSI (Placeholder karena tabel belum ada)
            $user->absensi_jadwal = $hariEfektif;
            $user->absensi_hadir  = 20; // Contoh statis
            $user->absensi_ach    = ($user->absensi_jadwal > 0) ? ($user->absensi_hadir / $user->absensi_jadwal) * 100 : 0;

            // 3. LOGIKA PROGRESS (Berdasarkan jumlah Prospek/Call)
            $user->progress_target = $target_call * $hariEfektif;
            $user->progress_real   = Prospek::where('marketing_id', $user->id)->count(); // Ganti marketing_id sesuai kolom asli
            $user->progress_ach    = ($user->progress_target > 0) ? ($user->progress_real / $user->progress_target) * 100 : 0;

            // 4. LOGIKA REVENUE (Berdasarkan Deal di CTA)
            $user->revenue_target = $target;
            $user->revenue_actual = Cta::whereHas('prospek', function($q) use ($user) {
                $q->where('marketing_id', $user->id); // Sesuaikan nama kolom di prospeks
            })->where('status_penawaran', 'Deal')->sum('harga_penawaran');
            
            $user->revenue_ach = ($user->revenue_target > 0) ? ($user->revenue_actual / $user->revenue_target) * 100 : 0;

            // 5. TOTAL PENCAPAIAN KPI (Rata-rata dari 3 poin)
            // Kamu bisa memberikan bobot di sini, misal Revenue lebih besar bobotnya
            $user->total_kpi = ($user->absensi_ach + $user->progress_ach + $user->revenue_ach) / 3;

            return $user;
        });

        return view('data-kpi', compact('marketings'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi Filter
        $start = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', now()->endOfMonth()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');
        $hariEfektif = 22; // Bisa dibuat dinamis jika ada inputnya

        // 2. Ambil Data Marketing
        $query = User::where('role', 'marketing');
        if ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        
        $marketings = $query->get()->map(function($user) use ($start, $end, $hariEfektif) {
            // Ambil data penggajian untuk target
            $gaji = \App\Models\Penggajian::where('user_id', $user->id)->first();
            $targetCallHarian = $gaji->target_call ?? 0;

            // Tabel Progress Marketing
            $user->target_total = $targetCallHarian * $hariEfektif;
            $user->pencapaian = \App\Models\Prospek::where('marketing_id', $user->id)
                                ->whereBetween('created_at', [$start, $end])->count();
            $user->ach_persen = ($user->target_total > 0) ? ($user->pencapaian / $user->target_total) * 100 : 0;

            // Tabel Update Penawaran (Data dari CTA)
            $cta = \App\Models\Cta::whereHas('prospek', function($q) use ($user) {
                        $q->where('marketing_id', $user->id);
                    })->whereBetween('created_at', [$start, $end])->get();

            $user->total_penawaran = $cta->count();
            $user->deal = $cta->where('status_penawaran', 'deal')->count();
            $user->hold = $cta->where('status_penawaran', 'hold')->count();
            $user->kalah = $cta->where('status_penawaran', 'kalah_harga')->count();
            $user->review = $cta->where('status_penawaran', 'under_review')->count();

            // Ambil semua data prospek marketing ini dalam rentang tanggal
            $prospeks = \App\Models\Prospek::where('marketing_id', $user->id) // Sesuaikan kolom marketing_id
                        ->whereBetween('created_at', [$start, $end])
                        ->get();

            // Hitung masing-masing status secara dinamis
            $user->count_perpanjangan = $prospeks->where('status', 'Perpanjangan Sertifikat')->count();
            $user->count_invalid      = $prospeks->where('status', 'Data Tidak Valid & Tidak Terhubung')->count();
            $user->count_email        = $prospeks->where('status', 'Dapat Email')->count();
            $user->count_wa           = $prospeks->where('status', 'Dapat No WA HRD')->count();
            $user->count_compro       = $prospeks->where('status', 'Request Compro')->count();
            $user->count_manja        = $prospeks->where('status', 'Manja')->count();
            $user->count_manja_ulang  = $prospeks->where('status', 'Manja Ulang')->count();
            $user->count_pelatihan    = $prospeks->where('status', 'Request Permintaan Pelatihan')->count();

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get(); // Untuk dropdown filter

        return view('dashboard-progress', compact('marketings', 'all_marketing', 'start', 'end'));
    }

    public function getDetail(Request $request, $id)
    {
        // Ambil filter tanggal dari request (agar detailnya sinkron dengan filter di dashboard)
        $start = $request->query('start');
        $end = $request->query('end');

        // Cari data penawaran (CTA) yang dimiliki oleh marketing tersebut lewat Prospek
        $details = \App\Models\Cta::whereHas('prospek', function($q) use ($id) {
                        // Pastikan 'marketing_id' sesuai dengan nama kolom di tabel prospeks kamu
                        $q->where('marketing_id', $id); 
                    })
                    ->with('prospek') // Load data prospek agar bisa ambil nama perusahaannya
                    ->whereBetween('created_at', [$start, $end])
                    ->get();

        // Mengembalikan view khusus (partial) yang hanya berisi tabel untuk modal
        return view('partials.modal-detail-penawaran', compact('details'));
    }
}

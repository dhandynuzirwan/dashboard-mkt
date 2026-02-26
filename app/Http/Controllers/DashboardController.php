<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi Filter Tanggal & Marketing
        $start = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', now()->endOfMonth()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');
        $hariEfektif = 22; 

        // 2. Ambil User Marketing
        $query = \App\Models\User::where('role', 'marketing');
        if ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        $users = $query->get();

        // 3. MAPPING DATA UNTUK TABEL PROGRESS & TABEL STATUS AKHIR
        $marketings = $users->map(function ($user) use ($start, $end, $hariEfektif) {
            $gaji = \App\Models\Penggajian::where('user_id', $user->id)->first();
            $targetCallHarian = $gaji->target_call ?? 0;

            $user->target_total = $targetCallHarian * $hariEfektif;
            
            // Ambil semua prospek user ini dalam range tanggal
            $prospeks = \App\Models\Prospek::where('marketing_id', $user->id)
                        ->whereBetween('created_at', [$start, $end])->get();

            $user->pencapaian = $prospeks->count();
            $user->ach_persen = ($user->target_total > 0) ? ($user->pencapaian / $user->target_total) * 100 : 0;

            // --- LOGIKA UNTUK TABEL STATUS AKHIR DATA ---
            // Pastikan string status di bawah ini sama persis dengan yang ada di database/Faker
            $user->count_perpanjangan = $prospeks->where('status', 'REQUES PERPANJANGAN SERTIFIKAT')->count();
            $user->count_invalid      = $prospeks->where('status', 'DATA TIDAK VALID & TIDAK TERHUBUNG')->count();
            $user->count_email        = $prospeks->where('status', 'DAPAT EMAIL')->count();
            $user->count_wa           = $prospeks->where('status', 'DAPAT NO WA HRD')->count();
            $user->count_compro       = $prospeks->where('status', 'KIRIM COMPRO')->count(); // atau 'REQUEST COMPRO'
            $user->count_manja        = $prospeks->where('status', 'MANJA')->count();
            $user->count_manja_ulang  = $prospeks->where('status', 'MANJA ULANG')->count();
            $user->count_pelatihan    = $prospeks->where('status', 'REQUEST PERMINTAAN PELATIHAN')->count();
            // --------------------------------------------

            $cta = \App\Models\Cta::whereHas('prospek', function ($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })->whereBetween('created_at', [$start, $end])->get();

            $user->total_penawaran = $cta->count();
            $user->deal = $cta->where('status_penawaran', 'deal')->count();
            $user->hold = $cta->where('status_penawaran', 'hold')->count();
            $user->kalah = $cta->where('status_penawaran', 'kalah_harga')->count();
            $user->review = $cta->where('status_penawaran', 'under_review')->count();

            return $user;
        });

        // 4. LOGIKA PIE CHART (Total Nominal RUPIAH dari Status DEAL)
        $pieLabels = [];
        $pieData = [];
        foreach ($users as $user) {
            $pieLabels[] = $user->name;
            $totalNominalDeal = \App\Models\Cta::whereHas('prospek', fn($q) => $q->where('marketing_id', $user->id))
                ->where('status_penawaran', 'deal') // Hanya yang Deal
                ->whereBetween('created_at', [$start, $end])
                ->sum('harga_penawaran'); // Jumlahkan Rupiahnya
            $pieData[] = $totalNominalDeal;
        }

        // 5. LOGIKA LINE CHART (Total NOMINAL PENAWARAN - Walau Gagal/Hold)
        $lineLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $lineLabels[] = now()->subMonths($i)->format('M Y');
        }

        $lineDatasets = [];
        $colors = ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2'];

        foreach ($users as $index => $user) {
            $monthlyOfferNominals = [];
            for ($i = 5; $i >= 0; $i--) {
                $loopStart = now()->subMonths($i)->startOfMonth();
                $loopEnd = now()->subMonths($i)->endOfMonth();
                
                // Menjumlahkan SUM harga_penawaran TANPA filter status (semua penawaran masuk)
                $sumNominal = \App\Models\Cta::whereHas('prospek', fn($q) => $q->where('marketing_id', $user->id))
                    ->whereBetween('created_at', [$loopStart, $loopEnd])
                    ->sum('harga_penawaran'); 
                    
                $monthlyOfferNominals[] = $sumNominal;
            }

            $lineDatasets[] = [
                'label' => $user->name,
                'borderColor' => $colors[$index] ?? '#000',
                'backgroundColor' => 'transparent',
                'data' => $monthlyOfferNominals,
                'fill' => false,
                'borderWidth' => 2,
                'tension' => 0.3
            ];
        }

        $all_marketing = \App\Models\User::where('role', 'marketing')->get(); 

        return view('dashboard-progress', compact(
            'marketings', 'all_marketing', 'start', 'end', 
            'pieLabels', 'pieData', 'lineLabels', 'lineDatasets'
        ));
    }

    public function getDetail(Request $request, $id)
    {
        $authUser = auth()->user();

        // 🔐 Kalau marketing, hanya boleh akses detail miliknya sendiri
        if ($authUser->role === 'marketing' && $authUser->id != $id) {
            abort(403, 'Unauthorized access');
        }

        $start = $request->query('start');
        $end = $request->query('end');

        $details = \App\Models\Cta::whereHas('prospek', function ($q) use ($id) {
            $q->where('marketing_id', $id);
        })
            ->with('prospek')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        return view('partials.modal-detail-penawaran', compact('details'));
    }
}

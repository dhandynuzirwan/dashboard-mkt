<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Sesuaikan dengan model Marketing kamu

class MonitorController extends Controller
{
    // Menampilkan halaman Blade (kosongan, hanya kerangka tabel)
    public function index()
    {
        return view('performance.monitor');
    }

    // Mengembalikan data format JSON untuk dibaca oleh JavaScript (Realtime AJAX)
    public function getData()
    {
        // Ambil rentang waktu bulan ini (Bisa disesuaikan jika ingin filter lain)
        $startOfMonth = now()->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d 23:59:59');

        $marketings = \App\Models\User::where('role', 'marketing')->get()->map(function ($m) use ($startOfMonth, $endOfMonth) {
            
            // 1. QUERY DASAR: Ambil CTA milik Marketing ini di bulan berjalan
            $baseCtaQuery = \App\Models\Cta::whereHas('prospek', function ($q) use ($m, $startOfMonth, $endOfMonth) {
                $q->where('marketing_id', $m->id)
                  ->whereBetween('tanggal_prospek', [$startOfMonth, $endOfMonth]);
            });

            // 2. TOTAL PENAWARAN (Semua CTA yang sudah masuk penawaran)
            $total_penawaran = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

            // 3. TOTAL DEAL
            $total_deal = (clone $baseCtaQuery)
                ->where('status_penawaran', 'deal')
                ->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

            // 4. TOTAL KPI (Menggunakan rumus pencapaian dari DashboardController)
            $jumlahCtaBase = (clone $baseCtaQuery)->count();
            $jumlahCtaBerstatus = (clone $baseCtaQuery)->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '')->count();
            $total_kpi = $jumlahCtaBase + $jumlahCtaBerstatus;

            // 5. TARGET OMSET (Default sementara)
            // Di DashboardController hanya ada target_call dari tabel Penggajian, bukan target omset (Rp).
            $target = $m->target_omset ?? 100000000; 
            
            // 6. PERSENTASE PENCAPAIAN
            $persentase = $target > 0 ? ($total_deal / $target) * 100 : 0;

            return [
                'nama'            => $m->name,
                'target'          => $target,
                'total_penawaran' => $total_penawaran,
                'total_deal'      => $total_deal,
                'tercapai_omset'  => $total_deal,
                'prosentase'      => round($persentase, 1),
                'total_kpi'       => $total_kpi,
            ];
        });

        // Urutkan berdasarkan persentase tertinggi
        $marketings = $marketings->sortByDesc('prosentase')->values();

        return response()->json([
            'status' => 'success',
            'data'   => $marketings,
            'waktu'  => now()->format('d M Y H:i:s')
        ]);
    }
}
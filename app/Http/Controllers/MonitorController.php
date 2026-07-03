<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\KpiCalculationTrait;
use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Holiday; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    use KpiCalculationTrait;

    // Menampilkan halaman Blade (kosongan, hanya kerangka tabel)
    public function index()
    {
        return view('performance.monitor');
    }

    // Mengembalikan data format JSON untuk dibaca oleh JavaScript (Realtime AJAX)
    public function getData()
    {
        // 1. --- HITUNG HARI KERJA (FULL BULAN & BERJALAN) ---
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $hariIni = Carbon::now()->format('Y-m-d');

        // Ambil daftar libur bulan ini dari database
        $daftarLibur = Holiday::whereBetween('tanggal', [
            $startOfMonth->format('Y-m-d'), 
            $endOfMonth->format('Y-m-d')
        ])->pluck('tanggal')->toArray();

        $hariEfektifSebulan = 0;
        $hariEfektifBerjalan = 0;
        
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektifSebulan++;
                // Batas akhir perhitungan berjalan adalah Hari Ini
                if ($date->format('Y-m-d') <= $hariIni) {
                    $hariEfektifBerjalan++;
                }
            }
        }

        // 2. --- MAPPING DATA MARKETING & KPI ---
        $marketings = User::where('role', 'marketing')->get()->map(function ($m) use ($startOfMonth, $endOfMonth, $hariEfektifSebulan, $hariEfektifBerjalan) {

            $startStr = $startOfMonth->format('Y-m-d');
            $endStr = $endOfMonth->format('Y-m-d');

            // Hitung KPI secara tersentralisasi
            $m = $this->calculateKpi($m, $startStr, $endStr, $hariEfektifSebulan, $hariEfektifBerjalan);

            // ================= NOMINAL TABEL =================
            // Kita butuh variabel tambahan untuk layar monitoring yang tidak ada di KPI biasa (seperti total nominal penawaran keseluruhan)
            $baseCtaQuery = Cta::whereHas('prospek', function ($q) use ($m, $startStr, $endStr) {
                $q->where('marketing_id', $m->id)
                  ->whereBetween('tanggal_prospek', [$startStr . ' 00:00:00', $endStr . ' 23:59:59']); 
            });

            $total_penawaran = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->sum(DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

            // Mengembalikan format untuk dirender Javascript di Layar
            return [
                'nama'            => $m->name,
                'nama_lengkap'    => $m->nama_lengkap ?? $m->name,
                'target'          => $m->revenue_target,
                'total_penawaran' => $total_penawaran,
                'total_deal'      => $m->revenue_actual,
                'tercapai_omset'  => $m->revenue_actual,
                'prosentase'      => round($m->revenue_ach, 1), // Persentase yang tampil di layar adalah pencapaian Revenue
                'total_kpi'       => round($m->total_kpi, 2),  // Menampilkan angka desimal 2 di belakang koma (misal: 98.50)
                'foto'            => $m->foto_profil ? asset('storage/' . $m->foto_profil) : null,
            ];
        });

        // Urutkan berdasarkan persentase pencapaian tertinggi ke terendah
        $marketings = $marketings->sortByDesc('prosentase')->values();

        \Carbon\Carbon::setLocale('id');
        $param = \App\Models\ParameterFinansial::where('bulan_tahun', now()->format('Y-m'))->first();
        $target_minimal = $param ? $param->target_minimal : 0;

        return response()->json([
            'status' => 'success',
            'data'   => $marketings,
            'target_minimal' => $target_minimal,
            'waktu'  => now()->format('d M Y H:i:s'),
            'bulan_tahun' => strtoupper(now()->translatedFormat('F Y'))
        ]);
    }
}
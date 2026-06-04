<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Holiday; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

            $startStr = $startOfMonth->format('Y-m-d 00:00:00');
            $endStr = $endOfMonth->format('Y-m-d 23:59:59');

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $m->id)->first();
            $target_call = $penggajian->target_call ?? 0;
            $target_revenue = $penggajian->target ?? 0; // Mengambil target omset dari DB

            $kpiCapped = true; // Batasan Maksimal KPI 100%

            // ================= ABSENSI (10%) =================
            $hadirMesin = AbsensiLog::where('user_id', $m->id)
                ->where('tipe', 'in')
                ->whereBetween('tanggal', [$startStr, $endStr])
                ->distinct('tanggal')
                ->count();

            $izinApproved = Perizinan::where('user_id', $m->id)
                ->where('status', 'approved')
                ->whereBetween('tanggal', [$startStr, $endStr])
                ->count();

            $absensi_hadir = $hadirMesin + $izinApproved;
            $absensi_ach = ($hariEfektifBerjalan > 0) ? ($absensi_hadir / $hariEfektifBerjalan) * 100 : 0;
            $hitungAbsensiAch = $kpiCapped ? min(100, $absensi_ach) : $absensi_ach;
            $absensi_kpi = ($hitungAbsensiAch / 100) * 10; 

            // ================= PROGRESS CTA (30%) =================
            $progress_target = $target_call * 23;

            $baseCtaQuery = Cta::whereHas('prospek', function ($q) use ($m, $startStr, $endStr) {
                $q->where('marketing_id', $m->id)
                  ->whereBetween('tanggal_prospek', [$startStr, $endStr]); 
            });

            $jumlahCtaBase = (clone $baseCtaQuery)->count();
            $jumlahCtaBerstatus = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->count();

            $progress_real = $jumlahCtaBase + $jumlahCtaBerstatus;
            $progress_ach = ($progress_target > 0) ? ($progress_real / $progress_target) * 100 : 0;
            $hitungProgressAch = $kpiCapped ? min(100, $progress_ach) : $progress_ach;
            $progress_kpi = ($hitungProgressAch / 100) * 30;

            // ================= REVENUE (60%) & NOMINAL TABEL =================
            $total_penawaran = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->sum(DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

            $total_deal = (clone $baseCtaQuery)
                ->where('status_penawaran', 'deal')
                ->sum(DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

            $revenue_ach = ($target_revenue > 0) ? ($total_deal / $target_revenue) * 100 : 0;
            $hitungRevenueAch = $kpiCapped ? min(100, $revenue_ach) : $revenue_ach;
            $revenue_kpi = ($hitungRevenueAch / 100) * 60;

            // ================= TOTAL KPI FINAL =================
            $total_kpi = $absensi_kpi + $progress_kpi + $revenue_kpi;

            // Mengembalikan format untuk dirender Javascript di Layar
            return [
                'nama'            => $m->name,
                'target'          => $target_revenue,
                'total_penawaran' => $total_penawaran,
                'total_deal'      => $total_deal,
                'tercapai_omset'  => $total_deal,
                'prosentase'      => round($revenue_ach, 1), // Persentase yang tampil di layar adalah pencapaian Revenue
                'total_kpi'       => round($total_kpi, 2),  // Menampilkan angka desimal 2 di belakang koma (misal: 98.50)
            ];
        });

        // Urutkan berdasarkan persentase pencapaian tertinggi ke terendah
        $marketings = $marketings->sortByDesc('prosentase')->values();

        return response()->json([
            'status' => 'success',
            'data'   => $marketings,
            'waktu'  => now()->format('d M Y H:i:s')
        ]);
    }
}
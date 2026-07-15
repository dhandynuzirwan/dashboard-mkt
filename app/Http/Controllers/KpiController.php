<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Traits\KpiCalculationTrait;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Holiday; 
use Carbon\Carbon;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    use KpiCalculationTrait;

    public function index(Request $request)
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- HITUNG HARI KERJA (FULL BULAN & BERJALAN) ---
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        // Ambil daftar libur bulan ini dari database
        $daftarLibur = Holiday::whereBetween('tanggal', [
            $startOfMonth->format('Y-m-d'), 
            $endOfMonth->format('Y-m-d')
        ])->pluck('tanggal')->toArray();

        $hariEfektifSebulan = 0;
        $hariEfektifBerjalan = 0;
        
        // Batas akhir perhitungan berjalan adalah Hari Ini (Jika $end melewati hari ini)
        $batasAkhirBerjalan = min($end, Carbon::now()->format('Y-m-d'));

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                // Hitung total hari efektif sebulan penuh
                $hariEfektifSebulan++;
                
                // Hitung hari efektif yang sudah dilewati (berjalan)
                if ($date->format('Y-m-d') <= $batasAkhirBerjalan) {
                    $hariEfektifBerjalan++;
                }
            }
        }

        // 3. 🔐 FILTER ROLE & MARKETING
        $query = User::where('role', 'marketing');
        if ($authUser->role === 'marketing') {
            $query->where('id', $authUser->id);
        } elseif ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        $users = $query->get();

        // 4. --- MAPPING DATA KPI ---
        // 🔥 PASTIKAN $hariEfektifBerjalan MASUK KE DALAM "use" 🔥
        $marketings = $users->map(function ($user) use ($hariEfektifSebulan, $hariEfektifBerjalan, $start, $end) {

            // ================= TARGET DARI PENGGAJIAN =================
            $penggajian = Penggajian::where('user_id', $user->id)->first();
            $target_call = $penggajian->target_call ?? 0;
            $target_revenue = $penggajian->target ?? 0;

            // 🔥 OPSI: Batasan Maksimal KPI 
            // (Jika true, achievement mentok 100%, sehingga Skor KPI max 10/30/60)
            $kpiCapped = true;

            // ================= ABSENSI (HADIR + IZIN APPROVED) =================
            $user->absensi_jadwal = $hariEfektifSebulan;
            
            $hadirMesin = AbsensiLog::where('user_id', $user->id)
                ->where('tipe', 'in')
                ->whereBetween('tanggal', [$start, $end])
                ->distinct('tanggal')
                ->count();

            $izinApproved = Perizinan::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereBetween('tanggal', [$start, $end])
                ->count();

            // 🔥 TAMPILAN VISUAL JUJUR: Tampilkan kehadiran apa adanya (Misal: 19)
            $user->absensi_hadir = $hadirMesin + $izinApproved;

            // 🔥 RUMUS PINTAR: Hitung Achievement dari HARI BERJALAN
            // Misal: Hadir 19 hari / 19 Hari Berjalan = 100% (Meskipun jadwal fullnya 21)
            $user->absensi_ach = ($hariEfektifBerjalan > 0)
                ? ($user->absensi_hadir / $hariEfektifBerjalan) * 100
                : 0;

            // Eksekusi Limit (Cap) Absensi agar tidak tembus > 100% jika ada anomali
            $hitungAbsensiAch = $kpiCapped ? min(100, $user->absensi_ach) : $user->absensi_ach;
            
            // Bobot Absensi 10%
            $user->absensi_kpi = ($hitungAbsensiAch / 100) * 10; 

            // ================= PROGRESS (NEW LOGIC 3 KOMPONEN) =================
            $prospeks = \App\Models\Prospek::where('marketing_id', $user->id)
                ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"])->get();

            $ctasCount = \App\Models\Cta::whereIn('prospek_id', $prospeks->pluck('id'))
                ->selectRaw('prospek_id, count(*) as total')
                ->groupBy('prospek_id')
                ->pluck('total', 'prospek_id');

            // 1. UPDATE DATA (Jumlah Prospek + CTA) -> dari DashboardController
            $hitungStatus = function($statusName) use ($prospeks, $ctasCount) {
                return $prospeks->where('status', $statusName)->sum(function ($p) use ($ctasCount) {
                    $jmlCta = $ctasCount[$p->id] ?? 0;
                    return $jmlCta > 0 ? $jmlCta : 1; 
                });
            };

            // 1. UPDATE DATA
            $statusUpdateData = [
                'BELUM ADA KEBUTUHAN', 
                'TIDAK RESPON', 
                'DATA TIDAK VALID & TIDAK TERHUBUNG'
            ];
            $totalUpdateData = 0;
            foreach($statusUpdateData as $st) {
                $totalUpdateData += $hitungStatus($st);
            }
            
            // 2. STATUS AKHIR PEROLEHAN DATA
            $statusAkhirData = [
                'DAPAT NO WA HRD',
                'KIRIM COMPRO',
                'MANJA',
                'MANJA ULANG',
                'REQUEST PERMINTAAN PELATIHAN',
                'PENAWARAN HARDFILE',
                'TIDAK MENERIMA PENAWARAN',
                'SUDAH ADA VENDOR KERJASAMA',
                'DAPAT EMAIL'
            ];
            $totalAkhirData = 0;
            foreach($statusAkhirData as $st) {
                $totalAkhirData += $hitungStatus($st);
            }

            // 3. UPDATE PENAWARAN
            $cta = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]); 
            })->get();
            $totalPenawaranBase = $cta->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '')->count();
            $tambahanMasukPenawaran = $hitungStatus('MASUK PENAWARAN');
            $totalPenawaran = $totalPenawaranBase + $tambahanMasukPenawaran;

            // PEMBOBOTAN
            $maxDataUpdate = 115;
            $maxDataAkhir = 172;
            $maxDataPenawaran = 287;

            $bobotUpdate = 20;
            $bobotAkhir = 30;
            $bobotPenawaran = 50;

            // Dibagi 100, tetapi hasil tidak boleh melebihi bobot masing-masing
            // $skorUpdate = min((($totalUpdateData / 100) * $bobotUpdate), $bobotUpdate);
            // $skorAkhir = min((($totalAkhirData / 100) * $bobotAkhir), $bobotAkhir);
            // $skorPenawaran = min((($totalPenawaran / 100) * $bobotPenawaran), $bobotPenawaran);

            // Atau batasi dulu jumlah datanya
            $skorUpdate = min((min($totalUpdateData, $maxDataUpdate) / 100) * $bobotUpdate, $bobotUpdate);
            $skorAkhir = min((min($totalAkhirData, $maxDataAkhir) / 100) * $bobotAkhir, $bobotAkhir);
            $skorPenawaran = min((min($totalPenawaran, $maxDataPenawaran) / 100) * $bobotPenawaran, $bobotPenawaran);

            $user->progress_ach = $skorUpdate + $skorAkhir + $skorPenawaran; // Skala 100%
            
            // Simpan detail untuk ditampilkan di view
            $user->detail_update_data = $totalUpdateData;
            $user->detail_akhir_data = $totalAkhirData;
            $user->detail_penawaran = $totalPenawaran;
            $user->skor_update = $skorUpdate;
            $user->skor_akhir = $skorAkhir;
            $user->skor_penawaran = $skorPenawaran;

            // Bobot Progress 30% dari Total KPI
            $user->progress_kpi = ($user->progress_ach / 100) * 30;

            // ================= REVENUE (DEAL) =================
            $user->revenue_target = $target_revenue;

            $user->revenue_actual = Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                    $q->where('marketing_id', $user->id)
                      ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
                })
                ->where('status_penawaran', 'deal')
                ->get() 
                ->sum(fn($item) => $item->harga_penawaran * $item->jumlah_peserta); 

            // Achievement Revenue (Murni)
            $user->revenue_ach = ($user->revenue_target > 0)
                ? ($user->revenue_actual / $user->revenue_target) * 100
                : 0;

            // Eksekusi Limit (Cap) Revenue
            $hitungRevenueAch = $kpiCapped ? min(100, $user->revenue_ach) : $user->revenue_ach;
            
            // Bobot Revenue 60%
            $user->revenue_kpi = ($hitungRevenueAch / 100) * 60;

            // ================= TOTAL KPI (FINAL SCORE) =================
            $user->total_kpi = $user->absensi_kpi + $user->progress_kpi + $user->revenue_kpi;

            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        // 5. --- STATS KHUSUS SUPERADMIN & SPV ---
        $total_kpi_avg = 0;
        $hpp_percent = 0;
        $total_income_keseluruhan = 0;
        $hpp_per_bulan = 0;
        $komisi_spv = 0;

        if (in_array(auth()->user()->role, ['superadmin', 'spv_marketing'])) {
            $total_kpi_avg = $marketings->count() > 0 ? $marketings->avg('total_kpi') : 0;
            $total_income_keseluruhan = $marketings->sum('revenue_actual');
            
            // Hitung Fee Marketing untuk Komisi SPV
            $total_fee_marketing = 0;
            foreach ($marketings as $m) {
                $income = $m->revenue_actual;
                $kpi_rp = ($income < 60000000) ? ($income * 0.40) : ($income * 0.60);
                if ($income >= 30000000) {
                    $fee_mkt = ($m->total_kpi < 70) ? ($kpi_rp * 0.02) : ($kpi_rp * 0.05);
                    $total_fee_marketing += $fee_mkt;
                }
            }
            // Komisi SPV (5% jika avg kpi < 70, 10% jika >= 70)
            $komisi_spv = ($total_kpi_avg < 70) ? ($total_fee_marketing * 0.05) : ($total_fee_marketing * 0.10);
            
            $bulan_tahun = \Carbon\Carbon::parse($start)->format('Y-m');
            $parameterFinansial = \App\Models\ParameterFinansial::where('bulan_tahun', $bulan_tahun)->first();
            $hpp_per_bulan = $parameterFinansial ? $parameterFinansial->hpp_per_bulan : 0;

            if ($total_income_keseluruhan > 0) {
                $hpp_percent = ($hpp_per_bulan / $total_income_keseluruhan) * 100;
            }
        }

        return view('data-kpi', compact('marketings', 'start', 'end', 'all_marketing', 'hariEfektifSebulan', 'total_kpi_avg', 'hpp_percent', 'hpp_per_bulan', 'total_income_keseluruhan', 'komisi_spv'));
    }
}
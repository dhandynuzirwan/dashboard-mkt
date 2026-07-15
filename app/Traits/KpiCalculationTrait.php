<?php

namespace App\Traits;

use App\Models\Penggajian;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Prospek;
use App\Models\Cta;
use Carbon\Carbon;

trait KpiCalculationTrait
{
    public function calculateKpi($user, $start, $end, $hariEfektifSebulan, $hariEfektifBerjalan)
    {
        $penggajian = Penggajian::where("user_id", $user->id)->first();
        $target_call = $penggajian->target_call ?? 0;
        $target_revenue = $penggajian->target ?? 0;

        $kpiCapped = true;

        $user->absensi_jadwal = $hariEfektifSebulan;
        
        $hadirMesin = AbsensiLog::where("user_id", $user->id)
            ->where("tipe", "in")
            ->whereBetween("tanggal", [$start, $end])
            ->distinct("tanggal")
            ->count();

        $izinApproved = Perizinan::where("user_id", $user->id)
            ->where("status", "approved")
            ->whereBetween("tanggal", [$start, $end])
            ->count();

        $user->absensi_hadir = $hadirMesin + $izinApproved;

        $user->absensi_ach = ($hariEfektifBerjalan > 0)
            ? ($user->absensi_hadir / $hariEfektifBerjalan) * 100
            : 0;

        $hitungAbsensiAch = $kpiCapped ? min(100, $user->absensi_ach) : $user->absensi_ach;
        $user->absensi_kpi = ($hitungAbsensiAch / 100) * 10; 

        $prospeks = Prospek::where("marketing_id", $user->id)
            ->whereBetween("tanggal_prospek", [$start . " 00:00:00", $end . " 23:59:59"])->get();

        $ctasCount = Cta::whereIn("prospek_id", $prospeks->pluck("id"))
            ->selectRaw("prospek_id, count(*) as total")
            ->groupBy("prospek_id")
            ->pluck("total", "prospek_id");

        $baseCtaQuery = Cta::whereHas("prospek", function ($q) use ($user, $start, $end) {
            $q->where("marketing_id", $user->id)
              ->whereBetween("tanggal_prospek", [$start . " 00:00:00", $end . " 23:59:59"]); 
        });
        $jumlahCtaBase = (clone $baseCtaQuery)->count();
        $jumlahCtaBerstatus = (clone $baseCtaQuery)
            ->whereNotNull("status_penawaran")
            ->where("status_penawaran", "!=", "")
            ->count();
        $totalUpdateData = $jumlahCtaBase + $jumlahCtaBerstatus;
        
        $hitungStatus = function($statusName) use ($prospeks, $ctasCount) {
            return $prospeks->where("status", $statusName)->sum(function ($p) use ($ctasCount) {
                $jmlCta = $ctasCount[$p->id] ?? 0;
                return $jmlCta > 0 ? $jmlCta : 1; 
            });
        };
        
        $statusResmi = [
            "DATA TIDAK VALID & TIDAK TERHUBUNG", "TIDAK RESPON", "DAPAT NO WA HRD",
            "KIRIM COMPRO", "MANJA", "MANJA ULANG", "REQUEST PERMINTAAN PELATIHAN",
            "MASUK PENAWARAN", "BELUM ADA KEBUTUHAN", "REQUES PERPANJANGAN SERTIFIKAT",
            "PENAWARAN HARDFILE", "TIDAK MENERIMA PENAWARAN", "DAPAT NO TELP",
            "SUDAH ADA VENDOR KERJASAMA", "HOLD", "DAPAT EMAIL"
        ];
        
        $totalAkhirData = 0;
        foreach($statusResmi as $st) {
            $totalAkhirData += $hitungStatus($st);
        }

        $cta = Cta::whereHas("prospek", function ($q) use ($user, $start, $end) {
            $q->where("marketing_id", $user->id)
              ->whereBetween("tanggal_prospek", [$start . " 00:00:00", $end . " 23:59:59"]); 
        })->get();
        $totalPenawaran = $cta->whereNotNull("status_penawaran")->where("status_penawaran", "!=", "")->count();

        $maxDataUpdate = 115;
        $maxDataAkhir = 172;
        $maxDataPenawaran = 287;

        $bobotUpdate = 20;
        $bobotAkhir = 30;
        $bobotPenawaran = 50;

        $skorUpdate = (min($totalUpdateData, $maxDataUpdate) / 100) * $bobotUpdate;
        $skorAkhir = (min($totalAkhirData, $maxDataAkhir) / 100) * $bobotAkhir;
        $skorPenawaran = (min($totalPenawaran, $maxDataPenawaran) / 100) * $bobotPenawaran;

        $user->progress_ach = $skorUpdate + $skorAkhir + $skorPenawaran;
        
        $user->detail_update_data = $totalUpdateData;
        $user->detail_akhir_data = $totalAkhirData;
        $user->detail_penawaran = $totalPenawaran;
        $user->skor_update = $skorUpdate;
        $user->skor_akhir = $skorAkhir;
        $user->skor_penawaran = $skorPenawaran;

        $user->progress_kpi = ($user->progress_ach / 100) * 30;

        $user->revenue_target = $target_revenue;

        $user->revenue_actual = Cta::whereHas("prospek", function ($q) use ($user, $start, $end) {
            $q->where("marketing_id", $user->id)
              ->whereBetween("tanggal_prospek", [$start . " 00:00:00", $end . " 23:59:59"]); 
        })
        ->where("status_penawaran", "DEAL")
        ->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * COALESCE(jumlah_peserta, 1)'));

        $user->revenue_ach = ($target_revenue > 0) 
            ? ($user->revenue_actual / $target_revenue) * 100 
            : 0;
            
        $hitungRevenueAch = $kpiCapped ? min(100, $user->revenue_ach) : $user->revenue_ach;
        $user->revenue_kpi = ($hitungRevenueAch / 100) * 60;

        $user->total_kpi = $user->absensi_kpi + $user->progress_kpi + $user->revenue_kpi;

        // Untuk backwards compatibility ke MonitorController/SalaryController
        $user->kpi_persen = $user->total_kpi;

        return $user;
    }
}


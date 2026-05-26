<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Penggajian;
use App\Models\Holiday; // 1. TAMBAHKAN INI
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- LOGIKA HARI KERJA + TANGGAL MERAH ---
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        
        // 2a. Tarik daftar libur dari database berdasarkan rentang filter
        $daftarLibur = Holiday::whereBetween('tanggal', [$start, $end])
                        ->pluck('tanggal')
                        ->toArray();

        $hariEfektif = 0;

        // 2b. Hitung hari kerja (Senin-Jumat) yang BUKAN tanggal merah
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Syarat: Hari kerja (Senin-Jumat) DAN tidak ada di daftarLibur
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektif++;
            }
        }

        // 3. 🔐 FILTER USER
        $queryUser = User::where('role', 'marketing');
        if ($authUser->role === 'marketing') {
            $queryUser->where('id', $authUser->id);
        } elseif ($marketing_filter) {
            $queryUser->where('id', $marketing_filter);
        }
        $users = $queryUser->get();

        // 4. --- MAPPING DATA ---
        $marketings = $users->map(function ($m) use ($start, $end, $hariEfektif) {
            
            // =========================================================
            // 1. DATA PENAWARAN (Acuan disamakan: tanggal_prospek)
            // =========================================================
            $ctaDibuat = Cta::whereHas('prospek', function ($query) use ($m, $start, $end) {
                $query->where('marketing_id', $m->id)
                      ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
            })->get();

            $m->rp_pen_kemenaker = $ctaDibuat->filter(fn($i) => in_array(strtolower($i->sertifikasi), ['kemnaker', 'kemenaker']))->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_pen_bnsp      = $ctaDibuat->filter(fn($i) => strtolower($i->sertifikasi) == 'bnsp')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_pen_internal  = $ctaDibuat->filter(fn($i) => strtolower($i->sertifikasi) == 'internal')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_pen_ppsio     = $ctaDibuat->filter(fn($i) => in_array(strtolower($i->sertifikasi), ['sio', 'ppsio']))->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_pen_riksa     = $ctaDibuat->filter(fn($i) => strtolower($i->sertifikasi) == 'riksa')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            
            $m->total_rp_pen     = $ctaDibuat->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));

            // =========================================================
            // 2. DATA DEAL / REVENUE (Acuan disamakan: tanggal_prospek)
            // =========================================================
            $ctaDeal = Cta::whereHas('prospek', function ($query) use ($m, $start, $end) {
                $query->where('marketing_id', $m->id)
                      ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
            })->where('status_penawaran', 'deal')->get();

            $m->rp_deal_kemenaker = $ctaDeal->filter(fn($i) => in_array(strtolower($i->sertifikasi), ['kemnaker', 'kemenaker']))->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_deal_bnsp      = $ctaDeal->filter(fn($i) => strtolower($i->sertifikasi) == 'bnsp')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_deal_internal  = $ctaDeal->filter(fn($i) => strtolower($i->sertifikasi) == 'internal')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_deal_ppsio     = $ctaDeal->filter(fn($i) => in_array(strtolower($i->sertifikasi), ['sio', 'ppsio']))->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            $m->rp_deal_riksa     = $ctaDeal->filter(fn($i) => strtolower($i->sertifikasi) == 'riksa')->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));
            
            $m->total_rp_deal     = $ctaDeal->sum(fn($i) => ($i->harga_penawaran ?? 0) * ($i->jumlah_peserta ?? 1));

            // Absensi & Izin
            $countHadir = AbsensiLog::where('user_id', $m->id)
                ->where('tipe', 'in')
                ->whereBetween('tanggal', [$start, $end])
                ->distinct('tanggal')
                ->count();

            $countIzin = Perizinan::where('user_id', $m->id)
                ->where('status', 'approved')
                ->whereBetween('tanggal', [$start, $end])
                ->count();

            $m->hari_efektif = $hariEfektif;
            $m->count_hadir  = $countHadir;
            $m->count_izin   = $countIzin;
            
            $m->count_alpa   = max(0, $hariEfektif - ($countHadir + $countIzin));
            $m->total_potongan = $m->count_alpa * 100000;

            // Target & Achievement
            $penggajian = Penggajian::where('user_id', $m->id)->first();
            $m->target = $penggajian->target ?? 100000000; 
            
            $m->achieve = $m->total_rp_deal;
            $m->avg = $m->target > 0 ? ($m->achieve / $m->target) * 100 : 0;

            return $m;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        return view('revenue', compact('marketings', 'start', 'end', 'all_marketing', 'hariEfektif'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use App\Models\Penggajian;
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

        // 2. --- HITUNG HARI KERJA EFEKTIF (Senin-Jumat) BERDASARKAN RENTANG ---
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $hariEfektif = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) { 
                $hariEfektif++;
            }
        }

        // 3. 🔐 FILTER USER BERDASARKAN ROLE & INPUT
        $queryUser = User::where('role', 'marketing');
        if ($authUser->role === 'marketing') {
            $queryUser->where('id', $authUser->id);
        } elseif ($marketing_filter) {
            $queryUser->where('id', $marketing_filter);
        }
        $users = $queryUser->get();

        // 4. --- MAPPING DATA (REVENUE + ABSENSI + IZIN) ---
        $marketings = $users->map(function ($m) use ($start, $end, $hariEfektif) {
            
            // Ambil data penawaran (CTA) dalam rentang waktu terpilih
            $cta = Cta::whereHas('prospek', function ($query) use ($m) {
                $query->where('marketing_id', $m->id);
            })->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->get();

            // ================= TOTAL PENAWARAN (Berdasarkan Sertifikasi) =================
            $m->rp_pen_kemenaker = $cta->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
            $m->rp_pen_bnsp      = $cta->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
            $m->rp_pen_internal  = $cta->where('sertifikasi', 'internal')->sum('harga_penawaran');
            $m->rp_pen_ppsio     = $cta->where('sertifikasi', 'sio')->sum('harga_penawaran');
            $m->rp_pen_riksa     = $cta->where('sertifikasi', 'riksa')->sum('harga_penawaran');
            $m->total_rp_pen     = $cta->sum('harga_penawaran');

            // ================= TOTAL DEAL (Status Deal) =================
            $deal = $cta->where('status_penawaran', 'deal');

            $m->rp_deal_kemenaker = $deal->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
            $m->rp_deal_bnsp      = $deal->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
            $m->rp_deal_internal  = $deal->where('sertifikasi', 'internal')->sum('harga_penawaran');
            $m->rp_deal_ppsio     = $deal->where('sertifikasi', 'sio')->sum('harga_penawaker');
            $m->rp_deal_riksa     = $deal->where('sertifikasi', 'riksa')->sum('harga_penawaran');
            $m->total_rp_deal     = $deal->sum('harga_penawaran');

            // ================= DATA ABSENSI & IZIN =================
            // Hadir Real (Tap Mesin)
            $countHadir = AbsensiLog::where('user_id', $m->id)
                ->where('tipe', 'in')
                ->whereBetween('tanggal', [$start, $end])
                ->distinct('tanggal')
                ->count();

            // Izin Approved (Biar Gak Dianggap Alpa)
            $countIzin = Perizinan::where('user_id', $m->id)
                ->where('status', 'approved')
                ->whereBetween('tanggal', [$start, $end])
                ->count();

            $m->hari_efektif = $hariEfektif;
            $m->count_hadir  = $countHadir;
            $m->count_izin   = $countIzin;
            
            // Alpa = Hari Efektif - (Hadir + Izin)
            $m->count_alpa   = max(0, $hariEfektif - ($countHadir + $countIzin));
            $m->total_potongan = $m->count_alpa * 100000;

            // ================= TARGET & ACHIEVEMENT =================
            // Ambil target revenue dari setting penggajian marketing terkait
            $penggajian = Penggajian::where('user_id', $m->id)->first();
            $m->target = $penggajian->target ?? 100000000; // Default 100jt jika tidak diatur
            
            $m->achieve = $m->total_rp_deal;
            $m->avg = $m->target > 0 ? ($m->achieve / $m->target) * 100 : 0;

            return $m;
        });

        $all_marketing = User::where('role', 'marketing')->get();

        return view('revenue', compact('marketings', 'start', 'end', 'all_marketing', 'hariEfektif'));
    }
}
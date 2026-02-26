<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\User;
use App\Models\AbsensiLog; // Jangan lupa import ini
use Illuminate\Http\Request;
use Carbon\Carbon; // Jangan lupa import ini

class RevenueController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = Carbon::now();

        // 1. --- HITUNG HARI KERJA EFEKTIF (Senin-Jumat) BULAN INI ---
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $hariEfektif = 0;

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday()) { 
                $hariEfektif++;
            }
        }

        // 2. --- FILTER USER BERDASARKAN ROLE ---
        if ($user->role === 'marketing') {
            $marketings = User::where('id', $user->id)->get();
        } else {
            $marketings = User::where('role', 'marketing')->get();
        }

        // 3. --- MAPPING DATA (REVENUE + ABSENSI DALAM SATU LOOP) ---
        $marketings = $marketings->map(function ($m) use ($now, $hariEfektif) {
            
            // Ambil data CTA terkait marketing ini
            $cta = Cta::whereHas('prospek', function ($query) use ($m) {
                $query->where('marketing_id', $m->id);
            })->get();

            // ================= TOTAL PENAWARAN =================
            $m->rp_pen_kemenaker = $cta->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
            $m->rp_pen_bnsp      = $cta->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
            $m->rp_pen_internal  = $cta->where('sertifikasi', 'internal')->sum('harga_penawaran');
            $m->rp_pen_ppsio     = $cta->where('sertifikasi', 'sio')->sum('harga_penawaran');
            $m->rp_pen_riksa     = $cta->where('sertifikasi', 'riksa')->sum('harga_penawaran');
            $m->total_rp_pen     = $cta->sum('harga_penawaran');

            // ================= TOTAL DEAL =================
            $deal = $cta->where('status_penawaran', 'deal');

            $m->rp_deal_kemenaker = $deal->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
            $m->rp_deal_bnsp      = $deal->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
            $m->rp_deal_internal  = $deal->where('sertifikasi', 'internal')->sum('harga_penawaran');
            $m->rp_deal_ppsio     = $deal->where('sertifikasi', 'sio')->sum('harga_penawaran');
            $m->rp_deal_riksa     = $deal->where('sertifikasi', 'riksa')->sum('harga_penawaran');
            $m->total_rp_deal     = $deal->sum('harga_penawaran');

            // ================= DATA ABSENSI =================
            // Hitung berapa hari dia masuk (Tap In)
            $m->count_hadir = AbsensiLog::where('user_id', $m->id)
                ->where('tipe', 'in')
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->distinct('tanggal')
                ->count();

            $m->hari_efektif = $hariEfektif;
            $m->count_alpa   = max(0, $m->hari_efektif - $m->count_hadir);
            $m->total_potongan = $m->count_alpa * 100000; // Contoh potongan 100rb/alpa

            // ================= TARGET & ACHIEVEMENT =================
            $m->target = 100000000; // 100 Juta
            $m->achieve = $m->total_rp_deal;
            $m->avg = $m->target > 0 ? ($m->achieve / $m->target) * 100 : 0;

            return $m;
        });

        return view('revenue', compact('marketings'));
    }
}
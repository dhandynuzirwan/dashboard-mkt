<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\User;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        $user = auth()->user();

    // 🔐 Kalau marketing → ambil dirinya sendiri saja
    if ($user->role === 'marketing') {
        $marketings = User::where('id', $user->id)->get();
    } else {
        // Admin & Superadmin → ambil semua marketing
        $marketings = User::where('role', 'marketing')->get();
    }

    $marketings = $marketings->map(function ($user) {

        $cta = Cta::whereHas('prospek', function ($query) use ($user) {
            $query->where('marketing_id', $user->id);
        })->get();

        // ================= TOTAL PENAWARAN =================
        $user->rp_pen_kemenaker = $cta->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
        $user->rp_pen_bnsp      = $cta->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
        $user->rp_pen_internal  = $cta->where('sertifikasi', 'internal')->sum('harga_penawaran');
        $user->rp_pen_ppsio     = $cta->where('sertifikasi', 'sio')->sum('harga_penawaran');
        $user->rp_pen_riksa     = $cta->where('sertifikasi', 'riksa')->sum('harga_penawaran');
        $user->total_rp_pen     = $cta->sum('harga_penawaran');

        // ================= TOTAL DEAL =================
        $deal = $cta->where('status_penawaran', 'deal');

        $user->rp_deal_kemenaker = $deal->where('sertifikasi', 'kemnaker')->sum('harga_penawaran');
        $user->rp_deal_bnsp      = $deal->where('sertifikasi', 'bnsp')->sum('harga_penawaran');
        $user->rp_deal_internal  = $deal->where('sertifikasi', 'internal')->sum('harga_penawaran');
        $user->rp_deal_ppsio     = $deal->where('sertifikasi', 'sio')->sum('harga_penawaran');
        $user->rp_deal_riksa     = $deal->where('sertifikasi', 'riksa')->sum('harga_penawaran');
        $user->total_rp_deal     = $deal->sum('harga_penawaran');

        // ================= TARGET =================
        $user->target = 100000000;
        $user->achieve = $user->total_rp_deal;
        $user->avg = $user->target > 0 ? ($user->achieve / $user->target) * 100 : 0;

        return $user;
    });

    return view('revenue', compact('marketings'));
    }
}

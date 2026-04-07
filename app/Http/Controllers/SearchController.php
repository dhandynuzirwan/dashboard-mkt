<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospek;
use App\Models\Cta;
use App\Models\User;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $q = trim($request->input('q'));
    
        if (empty($q)) {
            return back()->with('error', 'Masukkan kata kunci pencarian terlebih dahulu.');
        }
    
        $qLower = strtolower($q);
    
        // 1. CARI DATA PROSPEK (Gunakan page_prospek)
        $prospeks = \App\Models\Prospek::with('marketing')
            ->where(function($query) use ($qLower) {
                $query->whereRaw('LOWER(perusahaan) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(nama_pic) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(email) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(telp) LIKE ?', ["%{$qLower}%"]);
            })
            ->paginate(5, ['*'], 'page_prospek')
            ->withQueryString(); // withQueryString agar parameter ?q=... tidak hilang saat pindah halaman
    
        // 2. CARI DATA PENAWARAN / CTA (Gunakan page_cta)
        $ctas = \App\Models\Cta::with('prospek.marketing')
            ->where(function($query) use ($qLower) {
                $query->whereRaw('LOWER(judul_permintaan) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(sertifikasi) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(skema) LIKE ?', ["%{$qLower}%"])
                      ->orWhereHas('prospek', function ($subQuery) use ($qLower) {
                          $subQuery->whereRaw('LOWER(perusahaan) LIKE ?', ["%{$qLower}%"]);
                      });
            })
            ->paginate(5, ['*'], 'page_cta')
            ->withQueryString();
    
        // 3. CARI DATA MARKETING (Gunakan page_marketing)
        $marketings = \App\Models\User::whereIn('role', ['marketing'])
            ->where(function($query) use ($qLower) {
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$qLower}%"])
                      ->orWhereRaw('LOWER(email) LIKE ?', ["%{$qLower}%"]);
            })
            ->paginate(5, ['*'], 'page_marketing')
            ->withQueryString();
    
        // Hitung total dari method ->total() bawaan paginator
        $totalResults = $prospeks->total() + $ctas->total() + $marketings->total();
    
        return view('search-results', compact('q', 'prospeks', 'ctas', 'marketings', 'totalResults'));
    }
}
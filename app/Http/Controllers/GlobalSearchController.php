<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\Cta;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->back();
        }

        // 1. Cari di tabel Prospek (Nama Perusahaan)
        $prospeks = Prospek::where('perusahaan', 'LIKE', "%{$query}%")
                    ->orWhere('nama_pic', 'LIKE', "%{$query}%")
                    ->get();

        // 2. Cari di tabel CTA (Judul Permintaan atau Sertifikasi)
        $ctas = Cta::where('judul_permintaan', 'LIKE', "%{$query}%")
                ->orWhere('sertifikasi', 'LIKE', "%{$query}%")
                ->with('prospek')
                ->get();

        // 3. Cari di tabel User (Nama Marketing)
        $marketings = User::where('role', 'marketing')
                    ->where('name', 'LIKE', "%{$query}%")
                    ->get();

        return view('search-results', compact('prospeks', 'ctas', 'marketings', 'query'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\AkunAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
// 🔥 Tambahkan dua baris use ini untuk Laravel 11+ 🔥
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Tambahkan "implements HasMiddleware" di nama class
class AkunAksesController extends Controller implements HasMiddleware
{
    // 🔥 Ganti __construct menjadi public static function middleware() 🔥
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                // Ambil nama user yang sedang login
                $userName = auth()->user()->name;

                // Cek apakah namanya diizinkan
                $allowedNames = ['direktur', 'desainer grafis'];
                
                if (!in_array(strtolower($userName), $allowedNames)) {
                    abort(403, 'Maaf, Brankas Akun hanya boleh diakses oleh Direktur dan Desainer Grafis.');
                }

                return $next($request);
            }),
        ];
    }

    // ================= INDEX =================
    public function index(Request $request)
    {
        $query = AkunAkses::query();
    
        // Fitur Pencarian Nama/Username
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('platform', 'LIKE', "%{$search}%")
                  ->orWhere('username_email', 'LIKE', "%{$search}%");
            });
        }
    
        // Fitur Filter Kategori Tab
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
    
        $akuns = $query->orderBy('platform', 'asc')->get();
        return view('akun.index', compact('akuns'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required',
            'username_email' => 'required',
            'password' => 'required',
            'kategori' => 'required',
            'url_login' => 'nullable|url',
            'catatan' => 'nullable'
        ]);

        // Enkripsi password
        $data['password'] = Crypt::encryptString($request->password);

        AkunAkses::create($data);
        return back()->with('success', 'Akun berhasil disimpan ke Brankas.');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        $akun = AkunAkses::findOrFail($id);
        $akun->delete();
        
        return back()->with('success', 'Kredensial akun berhasil dihapus dari Vault.');
    }
}
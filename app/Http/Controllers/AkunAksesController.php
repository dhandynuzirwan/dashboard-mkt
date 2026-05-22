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
                $allowedNames = ['direktur pt arsa jaya prima', 'desainer grafis'];
                
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
    
    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $akun = AkunAkses::findOrFail($id);

        $request->validate([
            'platform'       => 'required',
            'username_email' => 'required',
            'kategori'       => 'required',
            'url_login'      => 'nullable|url',
            'catatan'        => 'nullable',
            // Password dibuat nullable (tidak wajib) agar bisa pakai password lama jika dikosongkan
            'password'       => 'nullable' 
        ]);

        // Siapkan data dasar yang akan diupdate
        $updateData = [
            'platform'       => $request->platform,
            'username_email' => $request->username_email,
            'kategori'       => $request->kategori,
            'url_login'      => $request->url_login,
            'catatan'        => $request->catatan,
        ];

        // Cek jika form password diisi teks baru, maka enkripsi dan masukkan ke data update
        if ($request->filled('password')) {
            $updateData['password'] = Crypt::encryptString($request->password);
        }

        // Eksekusi update
        $akun->update($updateData);

        return back()->with('success', 'Data kredensial akun berhasil diperbarui.');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        $akun = AkunAkses::findOrFail($id);
        $akun->delete();
        
        return back()->with('success', 'Kredensial akun berhasil dihapus dari Vault.');
    }
}
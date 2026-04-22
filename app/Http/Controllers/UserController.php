<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('user', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        return view('form-tambah-pengguna'); 
    }

    /**
     * Menyimpan data user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',        
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:superadmin,admin,marketing,rnd,digitalmarketing,operasional,team_leader,web_dev',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id',
        ]);

        User::create([
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap, 
            'no_hp' => $request->no_hp,               
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('form-edit-pengguna', compact('user')); 
    }

    /**
     * Menyimpan perubahan data user
     */
    public function update(Request $request, $id)
    {
        // dd($request->all()); 
        
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:superadmin,admin,marketing,rnd,digitalmarketing,operasional,team_leader,web_dev',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id,' . $id,
        ]);

        // Siapkan array data untuk diupdate (KOSONGKAN FOTO PROFIL DULU DI SINI)
        $data = [
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap, 
            'no_hp' => $request->no_hp,                
            'email' => $request->email,
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
        ];

        // Jika user mengetikkan password baru, masukkan ke array $data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // JIKA ADA UPLOAD FOTO BARU
        if ($request->hasFile('foto_profil')) {
            // 1. Hapus foto lama jika ada di server
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
    
            // 2. Simpan foto baru ke folder 'profiles'
            $path = $request->file('foto_profil')->store('profiles', 'public');
            
            // 3. Masukkan nama file (path) yang baru ke array $data agar ikut tersimpan ke database
            $data['foto_profil'] = $path;
        }

        // Jalankan perintah update
        $user->update($data);

        return redirect()->route('user')->with('success', 'Data Pengguna berhasil diperbarui');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah hapus akun yang sedang login (diri sendiri)
        if (auth()->id() == $id) {
            return redirect()->route('user')->with('error', 'Peringatan: Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.');
        }

        // HAPUS FOTO PROFIL DARI SERVER JIKA USER DIHAPUS
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return redirect()->route('user')->with('success', 'Pengguna berhasil dihapus');
    }
}
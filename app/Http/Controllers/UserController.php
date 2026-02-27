<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        // Saya asumsikan kamu pakai pagination seperti di tabel marketing tadi
        $users = User::latest()->paginate(10);
        return view('user', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Menyimpan data user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:superadmin,admin,marketing',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Lebih aman di-hash di sini jika model tidak otomatis
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Diarahkan ke file form-edit-pengguna.blade.php
        return view('form-edit-pengguna', compact('user')); 
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // 'unique' harus mengabaikan ID user yang sedang di-edit
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:superadmin,admin,marketing',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id,' . $id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
        ];

        // Password hanya di-update jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: Cegah hapus diri sendiri
        if (auth()->id() == $id) {
            return redirect()->route('user')->with('error', 'Anda tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('user')->with('success', 'User berhasil dihapus');
    }
}
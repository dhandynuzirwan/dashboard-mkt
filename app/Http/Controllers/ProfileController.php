<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validasi input sesuai kebutuhan
        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Tampung data yang boleh diupdate
        $dataToUpdate = [
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
        ];

        // Logika Upload Foto Profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada dan bukan foto default
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru ke folder storage/app/public/profile_photos
            $path = $request->file('foto_profil')->store('profile_photos', 'public');
            $dataToUpdate['foto_profil'] = $path;
        }

        // Update ke database
        // @phpstan-ignore-next-line
        $user->update($dataToUpdate);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
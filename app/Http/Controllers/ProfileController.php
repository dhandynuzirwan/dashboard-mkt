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
            'nik'          => 'nullable|string|max:50',
            'tanggal_lahir'=> 'nullable|date',
            'tanggal_kontrak_baru' => 'nullable|date',
            'tanggal_kontrak_berakhir' => 'nullable|date',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deal_sound'   => 'nullable|file|mimes:mp3,wav|max:5120', // Maks 5MB
        ]);

        // Tampung data yang boleh diupdate
        $dataToUpdate = [
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'nik'          => $request->nik,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'tanggal_kontrak_baru' => $request->tanggal_kontrak_baru,
            'tanggal_kontrak_berakhir' => $request->tanggal_kontrak_berakhir,
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

        // Logika Upload Deal Sound (Hanya untuk marketing)
        if ($user->role === 'marketing' && $request->hasFile('deal_sound')) {
            if ($user->deal_sound_path && Storage::disk('public')->exists($user->deal_sound_path)) {
                Storage::disk('public')->delete($user->deal_sound_path);
            }

            $file = $request->file('deal_sound');
            $originalName = $file->getClientOriginalName();
            // Bersihkan nama file dari spasi atau karakter aneh
            $safeName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $originalName);
            $filename = time() . '_' . $safeName;
            
            $soundPath = $file->storeAs('deal_sounds', $filename, 'public');
            $dataToUpdate['deal_sound_path'] = $soundPath;
        }

        // Update ke database
        // @phpstan-ignore-next-line
        $user->update($dataToUpdate);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
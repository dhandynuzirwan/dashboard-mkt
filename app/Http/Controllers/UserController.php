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
        $allUsers = User::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
        $perPage = 10;
        $page = request()->get('page', 1);
        
        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $allUsers->forPage($page, $perPage),
            $allUsers->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

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
            'role' => 'required|in:superadmin,admin,marketing,rnd,digitalmarketing,operasional,team_leader,web_dev,spv_marketing,pic,hrd,graphic,finance,performance',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id',
            'nik' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_bergabung' => 'nullable|date',
            'tanggal_kontrak_baru' => 'nullable|date',
            'tanggal_kontrak_berakhir' => 'nullable|date',
            'nama_lengkap_ktp' => 'nullable|string|max:255',
            'jobdesk_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
            'sop_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
            'ktp_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'ijasah_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'pas_foto_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'kk_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'kontrak_kerja' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'pakta_integritas_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap, 
            'nama_lengkap_ktp' => $request->nama_lengkap_ktp,
            'no_hp' => $request->no_hp,               
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'tanggal_kontrak_baru' => $request->tanggal_kontrak_baru,
            'tanggal_kontrak_berakhir' => $request->tanggal_kontrak_berakhir,
        ];

        if ($request->hasFile('jobdesk_file')) {
            $data['jobdesk_file'] = $request->file('jobdesk_file')->store('users/jobdesk', 'public');
        }
        if ($request->hasFile('sop_file')) {
            $data['sop_file'] = $request->file('sop_file')->store('users/sop', 'public');
        }
        if ($request->hasFile('ktp_file')) {
            $data['ktp_file'] = $request->file('ktp_file')->store('users/ktp', 'public');
        }
        if ($request->hasFile('ijasah_file')) {
            $data['ijasah_file'] = $request->file('ijasah_file')->store('users/ijasah', 'public');
        }
        if ($request->hasFile('pas_foto_file')) {
            $data['pas_foto_file'] = $request->file('pas_foto_file')->store('users/pas_foto', 'public');
        }
        if ($request->hasFile('kk_file')) {
            $data['kk_file'] = $request->file('kk_file')->store('users/kk', 'public');
        }
        if ($request->hasFile('kontrak_kerja')) {
            $data['kontrak_kerja'] = $request->file('kontrak_kerja')->store('users/kontrak_kerja', 'public');
        }
        if ($request->hasFile('pakta_integritas_file')) {
            $data['pakta_integritas_file'] = $request->file('pakta_integritas_file')->store('users/pakta_integritas', 'public');
        }

        User::create($data);

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
            'role' => 'required|in:superadmin,admin,marketing,rnd,digitalmarketing,operasional,team_leader,web_dev,spv_marketing,pic,hrd,graphic,finance,performance',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fingerspot_id' => 'nullable|string|unique:users,fingerspot_id,' . $id,
            'nik' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_bergabung' => 'nullable|date',
            'tanggal_kontrak_baru' => 'nullable|date',
            'tanggal_kontrak_berakhir' => 'nullable|date',
            'nama_lengkap_ktp' => 'nullable|string|max:255',
            'jobdesk_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
            'sop_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
            'ktp_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'ijasah_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'pas_foto_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'kk_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'kontrak_kerja' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'pakta_integritas_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        // Siapkan array data untuk diupdate (KOSONGKAN FOTO PROFIL DULU DI SINI)
        $data = [
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap, 
            'nama_lengkap_ktp' => $request->nama_lengkap_ktp,
            'no_hp' => $request->no_hp,                
            'email' => $request->email,
            'role' => $request->role,
            'fingerspot_id' => $request->fingerspot_id,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'tanggal_kontrak_baru' => $request->tanggal_kontrak_baru,
            'tanggal_kontrak_berakhir' => $request->tanggal_kontrak_berakhir,
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

        if ($request->hasFile('jobdesk_file')) {
            if ($user->jobdesk_file && Storage::disk('public')->exists($user->jobdesk_file)) {
                Storage::disk('public')->delete($user->jobdesk_file);
            }
            $data['jobdesk_file'] = $request->file('jobdesk_file')->store('users/jobdesk', 'public');
        }

        if ($request->hasFile('sop_file')) {
            if ($user->sop_file && Storage::disk('public')->exists($user->sop_file)) {
                Storage::disk('public')->delete($user->sop_file);
            }
            $data['sop_file'] = $request->file('sop_file')->store('users/sop', 'public');
        }

        if ($request->hasFile('ktp_file')) {
            if ($user->ktp_file && Storage::disk('public')->exists($user->ktp_file)) {
                Storage::disk('public')->delete($user->ktp_file);
            }
            $data['ktp_file'] = $request->file('ktp_file')->store('users/ktp', 'public');
        }

        if ($request->hasFile('ijasah_file')) {
            if ($user->ijasah_file && Storage::disk('public')->exists($user->ijasah_file)) {
                Storage::disk('public')->delete($user->ijasah_file);
            }
            $data['ijasah_file'] = $request->file('ijasah_file')->store('users/ijasah', 'public');
        }

        if ($request->hasFile('pas_foto_file')) {
            if ($user->pas_foto_file && Storage::disk('public')->exists($user->pas_foto_file)) {
                Storage::disk('public')->delete($user->pas_foto_file);
            }
            $data['pas_foto_file'] = $request->file('pas_foto_file')->store('users/pas_foto', 'public');
        }

        if ($request->hasFile('kk_file')) {
            if ($user->kk_file && Storage::disk('public')->exists($user->kk_file)) {
                Storage::disk('public')->delete($user->kk_file);
            }
            $data['kk_file'] = $request->file('kk_file')->store('users/kk', 'public');
        }

        if ($request->hasFile('kontrak_kerja')) {
            if ($user->kontrak_kerja && Storage::disk('public')->exists($user->kontrak_kerja)) {
                Storage::disk('public')->delete($user->kontrak_kerja);
            }
            $data['kontrak_kerja'] = $request->file('kontrak_kerja')->store('users/kontrak_kerja', 'public');
        }

        if ($request->hasFile('pakta_integritas_file')) {
            if ($user->pakta_integritas_file && Storage::disk('public')->exists($user->pakta_integritas_file)) {
                Storage::disk('public')->delete($user->pakta_integritas_file);
            }
            $data['pakta_integritas_file'] = $request->file('pakta_integritas_file')->store('users/pakta_integritas', 'public');
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
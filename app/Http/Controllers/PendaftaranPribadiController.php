<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranPribadi;
use App\Models\MasterTraining;
use Illuminate\Support\Facades\Storage;

class PendaftaranPribadiController extends Controller
{
    public function create()
    {
        $trainings = MasterTraining::orderBy('nama_training', 'asc')->get();
        return view('portal.pendaftaran', compact('trainings'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            //data diri
            'nama_lengkap'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'no_wa'              => 'required|string|max:20',
            'master_training_id' => 'required|exists:master_trainings,id',
            'perusahaan'         => 'nullable|string|max:255',
            'alamat_perusahaan'  => 'nullable|string|max:255',
            'opsi_ppn'           => 'required|in:tanpa_ppn,dengan_ppn',
            'npwp'               => 'required_if:opsi_ppn,dengan_ppn|nullable|string|size:16',
            
            //data berkas
            'file_ktp'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_foto'    => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'file_cv'      => 'required|file|mimes:pdf|max:2048',
            'file_sk'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'file_sop'     => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // 2. Proses Upload File
        // Kita simpan di folder storage/app/public/berkas_pribadi
        $files = ['file_ktp', 'file_ijazah', 'file_foto', 'file_cv', 'file_sk', 'file_laporan', 'file_sop'];
        $paths = [];

        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $paths[$fileKey] = $request->file($fileKey)->store('berkas_pribadi', 'public');
            }
        }

        // 🔥 3. AUTO-GENERATE ID PENDAFTARAN 🔥
        $tahun = date('Y');
        // Cari data pendaftaran terakhir di tahun ini
        $lastRecord = PendaftaranPribadi::whereYear('created_at', $tahun)
                                        ->orderBy('id', 'desc')
                                        ->first();

        // Jika ada, ambil 3 digit terakhir lalu tambah 1. Jika belum ada, mulai dari 1.
        $urutan = $lastRecord ? intval(substr($lastRecord->id_pendaftaran, -3)) + 1 : 1;
        
        // Format: PLT-2026-001
        $idPendaftaran = 'PRB-' . $tahun . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // 4. Simpan ke Database
        PendaftaranPribadi::create(array_merge($validated, $paths, [
            'id_pendaftaran' => $idPendaftaran // Masukkan ID yang digenerate
        ]));

        // 5. Redirect ke halaman sukses dengan membawa ID Pendaftaran
        return redirect()->route('portal.pendaftaran.sukses')->with([
            'success' => 'Pendaftaran berhasil!',
            'id_pendaftaran' => $idPendaftaran // Kirim ID ini ke halaman sukses
        ]);
    }

    public function sukses()
    {
        return view('portal.sukses'); // Buat view sederhana untuk halaman sukses nanti
    }

    public function cekStatus(Request $request)
    {
        $pendaftaran = null;

        // Jika user mencari berdasarkan ID Pendaftaran
        if ($request->filled('id_pendaftaran')) {
            $pendaftaran = PendaftaranPribadi::with('training')
                ->where('id_pendaftaran', $request->id_pendaftaran)
                ->first();
        } 
        // ATAU Jika user mencari berdasarkan Nama & Tanggal Lahir
        elseif ($request->filled('nama_lengkap') && $request->filled('tanggal_lahir')) {
            $pendaftaran = PendaftaranPribadi::with('training')
                ->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%')
                ->where('tanggal_lahir', $request->tanggal_lahir)
                ->first();
        }

        // Jika form disubmit tapi data tidak ditemukan
        if ($request->anyFilled(['id_pendaftaran', 'nama_lengkap']) && !$pendaftaran) {
            return redirect()->route('portal.cek-status')->with('error', 'Data tidak ditemukan. Pastikan ID Pendaftaran atau Data Diri sesuai.');
        }

        // Kirim data ke view (jika $pendaftaran kosong, maka akan menampilkan form pencarian)
        return view('portal.cek-status', compact('pendaftaran'));
    }

    public function updateRevisi(Request $request, $id)
    {
        $pendaftaran = PendaftaranPribadi::findOrFail($id);
        $fields = ['ktp', 'ijazah', 'foto', 'cv', 'sk', 'laporan', 'sop'];
        $updates = [];

        foreach ($fields as $field) {
            $fileInputName = 'file_' . $field;
            // Cek apakah user mengupload file baru untuk field ini
            if ($request->hasFile($fileInputName)) {
                // Simpan file baru
                $path = $request->file($fileInputName)->store('berkas_pribadi', 'public');
                $updates[$fileInputName] = $path;
                
                // Ubah statusnya kembali menjadi pending
                $updates['status_'.$field] = 'pending';
                $updates['catatan_'.$field] = null;
            }
        }

        if (!empty($updates)) {
            // Ubah status utama menjadi pending lagi
            $updates['status'] = 'pending';
            $pendaftaran->update($updates);
            return redirect()->route('portal.cek-status')->with('success', 'Berkas revisi berhasil diunggah! Silakan tunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Anda belum memilih berkas revisi apa pun.');
    }
}
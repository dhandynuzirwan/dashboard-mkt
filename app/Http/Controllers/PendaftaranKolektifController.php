<?php

namespace App\Http\Controllers;

use App\Models\MasterTraining;
use App\Models\PendaftaranKolektif;
use App\Models\PendaftaranPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranKolektifController extends Controller
{
    public function create(Request $request)
    {
        // Tangkap data dari URL
        $cta_id = $request->query('cta_id');
        $training_id = $request->query('training_id');
        $perusahaan_default = $request->query('perusahaan');

        // Mengambil data training spesifik jika dikirim dari link deal
        $selected_training = null;
        if ($training_id) {
            $selected_training = \App\Models\MasterTraining::find($training_id);
        }
        
        // Ambil semua training untuk kondisi pendaftaran normal tanpa link deal
        $all_trainings = \App\Models\MasterTraining::all();

        return view('portal.pendaftaran-kolektif', compact('cta_id', 'selected_training', 'all_trainings', 'perusahaan_default'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Data Master (Perusahaan)
        $request->validate([
            'perusahaan'        => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'nama_pic'          => 'required|string|max:255',
            'wa_pic'            => 'required|string|max:20',
            'opsi_ppn'          => 'required|in:tanpa_ppn,dengan_ppn',
            'npwp'              => 'required_if:opsi_ppn,dengan_ppn|nullable|string|max:16',
            'file_zip'          => 'required|mimes:zip,rar|max:20480', // Maksimal 20MB
            'peserta'           => 'required|array|min:1', // Wajib ada minimal 1 peserta
            'peserta.*.nama_lengkap' => 'required|string',
            'peserta.*.nik'          => 'required|string|max:16',
            'peserta.*.training_id'  => 'required',
        ]);

        // 2. Upload File ZIP
        $zipPath = $request->file('file_zip')->store('berkas_kolektif', 'public');

        // 3. Generate ID Kolektif & Hitung Jumlah Peserta
        $idKolektif = 'KLT-' . date('Y') . '-' . strtoupper(Str::random(4));
        $jumlahPeserta = count($request->peserta);

        // 4. Simpan Data Master (Kolektif)
        $kolektif = PendaftaranKolektif::create([
            'id_pendaftaran'    => $idKolektif,
            'cta_id'            => $request->cta_id, // Terisi jika dari Magic Link
            'perusahaan'        => $request->perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'nama_pic'          => $request->nama_pic,
            'wa_pic'            => $request->wa_pic,
            'opsi_ppn'          => $request->opsi_ppn,
            'npwp'              => $request->npwp,
            'file_zip'          => $zipPath, // Menggunakan path yang sudah di-upload
        ]);

        // 5. Looping & Simpan Data Anak (Peserta)
        foreach ($request->peserta as $p) {
            PendaftaranPribadi::create([
                'id_pendaftaran'   => 'KOL-' . date('Y') . '-' . strtoupper(Str::random(4)),
                'tipe_pendaftaran' => 'kolektif',
                'kolektif_id'      => $kolektif->id,
                'cta_id'           => $request->cta_id, // Hubungkan juga ke Deal untuk Tracking
                'nama_lengkap'     => $p['nama_lengkap'],
                'nik'              => $p['nik'],
                'tempat_lahir'     => $p['tempat_lahir'] ?? null,
                'tanggal_lahir'    => $p['tanggal_lahir'] ?? null,
                'no_wa'            => $p['no_wa'] ?? null,
                'alamat'           => $p['alamat'] ?? null,
                'master_training_id' => $p['training_id'] ?? null, 
                'status'           => 'pending',
            ]);
        }

        // 6. Redirect ke Halaman Sukses Kolektif
        return redirect()->route('portal.pendaftaran.sukses')->with([
            'success' => true,
            'id_reg' => $idKolektif, // ID Kolektif (KLT-...)
            'jumlah' => $jumlahPeserta,
            'tipe' => 'kolektif' // 🔥 Tambahkan penanda tipe
        ]);
    }

    public function cekStatusPerusahaan(Request $request)
    {
        $kolektif = null;
        $id = $request->input('id_kolektif');

        if ($id) {
            // Mencari kolektif berdasarkan ID Registrasi (KLT-...)
            $kolektif = PendaftaranKolektif::with('pesertas.training')
                            ->where('id_pendaftaran', $id)
                            ->first();

            if (!$kolektif) {
                return back()->with('error', 'ID Registrasi tidak ditemukan.');
            }
        }

        return view('portal.cek-status-perusahaan', compact('kolektif'));
    }
}
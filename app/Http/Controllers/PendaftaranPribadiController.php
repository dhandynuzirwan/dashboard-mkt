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
        // Tarik data training untuk dropdown
        $trainings = MasterTraining::orderBy('nama_training', 'asc')->get();
        return view('portal.pendaftaran', compact('trainings'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'no_wa'              => 'required|string|max:20',
            'master_training_id' => 'required|exists:master_trainings,id',
            'perusahaan'         => 'nullable|string|max:255',
            'alamat_perusahaan'  => 'nullable|string|max:255',
            'opsi_ppn'           => 'required|in:tanpa_ppn,dengan_ppn',
            'npwp'               => 'required_if:opsi_ppn,dengan_ppn|nullable|string|size:16',
            
            // Validasi File
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

        // 3. Simpan ke Database
        PendaftaranPribadi::create(array_merge($validated, $paths));

        // 4. Redirect ke halaman sukses
        return redirect()->route('portal.pendaftaran.sukses')->with('success', 'Data pendaftaran berhasil dikirim dan sedang dalam verifikasi.');
    }

    public function sukses()
    {
        return view('portal.sukses'); // Buat view sederhana untuk halaman sukses nanti
    }
}
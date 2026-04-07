<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\MasterTraining;
use App\Models\Prospek;
use Illuminate\Http\Request;

class CtaController extends Controller
{
    // Membuka form CTA berdasarkan ID Prospek
    public function create($prospek_id)
    {
        $prospek = Prospek::with('marketing')->findOrFail($prospek_id);
        $trainings = MasterTraining::orderBy('nama_training')->get();
        $authUser = auth()->user();

        // 🔐 Jika marketing, hanya boleh buka prospek miliknya
        if ($authUser->role === 'marketing' && $prospek->marketing_id != $authUser->id) {
            abort(403, 'Unauthorized');
        }

        return view('form-cta', compact('prospek', 'trainings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prospek_id' => 'required|exists:prospeks,id',
            'catatan_prospek' => 'required|string', // 🚨 WAJIB DIISI sebagai Keterangan Akhir Data
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable|url',
            'status_penawaran' => 'nullable',
            'keterangan' => 'nullable|string', // Sekarang bisa diatur nullable jika catatan sudah mewakili
        ]);
    
        // Update Catatan di Tabel Prospek
        $prospek = Prospek::findOrFail($validated['prospek_id']);
        $prospek->update(['catatan' => $validated['catatan_prospek']]);
    
        // Hapus dari array sebelum simpan ke tabel CTA
        unset($validated['catatan_prospek']);
    
        // Logika Auto Multiply
        $jumlah = $validated['jumlah_peserta'] ?? null;
        $hargaPenawaran = $validated['harga_penawaran'] ?? null;
        $hargaVendor = $validated['harga_vendor'] ?? null;
    
        $validated['total_penawaran'] = ($jumlah && $hargaPenawaran) ? $jumlah * $hargaPenawaran : null;
        $validated['total_vendor'] = ($jumlah && $hargaVendor) ? $jumlah * $hargaVendor : null;
    
        Cta::create($validated);
        
        // AMBIL URL DARI SESSION (Jika kosong, kembali ke route default)
        $url_kembali = session('url_pipeline_terakhir', route('prospek.index'));
    
        return redirect($url_kembali)->with('success', 'Data CTA berhasil disimpan!');
    }
    
    public function update(Request $request, $id)
    {
        $cta = Cta::findOrFail($id);
    
        $validated = $request->validate([
            'catatan_prospek' => 'required|string', // 🚨 WAJIB saat edit
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable|url',
            'status_penawaran' => 'nullable',
            'keterangan' => 'nullable|string',
        ]);
    
        // Update Catatan di Tabel Prospek lewat relasi
        $cta->prospek->update(['catatan' => $validated['catatan_prospek']]);
        unset($validated['catatan_prospek']);
    
        // Recalculate
        $validated['total_penawaran'] = $validated['jumlah_peserta'] * $validated['harga_penawaran'];
        $validated['total_vendor'] = $validated['jumlah_peserta'] * $validated['harga_vendor'];
    
        $cta->update($validated);
    
        return redirect()->route('pipeline')->with('success', 'Data berhasil diperbarui!');
    }

    public function edit($id)
    {
        $cta = Cta::with('prospek')->findOrFail($id);
        $trainings = MasterTraining::orderBy('nama_training')->get();
        return view('form-cta-edit', compact('cta','trainings'));
    }

    // public function update(Request $request, $id)
    // {
    //     $cta = Cta::findOrFail($id);

    //     $validated = $request->validate([
    //         'judul_permintaan' => 'nullable',
    //         'jumlah_peserta' => 'nullable|numeric|min:1',
    //         'sertifikasi' => 'nullable',
    //         'skema' => 'nullable',
    //         'harga_penawaran' => 'nullable|numeric|min:0',
    //         'harga_vendor' => 'nullable|numeric|min:0',
    //         'proposal_link' => 'nullable|url',
    //         'status_penawaran' => 'nullable',
    //         'keterangan' => 'required|string',
    //     ]);

    //     // 🔥 AUTO RECALCULATE
    //     $validated['total_penawaran'] = $validated['jumlah_peserta'] * $validated['harga_penawaran'];
    //     $validated['total_vendor'] = $validated['jumlah_peserta'] * $validated['harga_vendor'];

    //     $cta->update($validated);

    //     return redirect()->route('pipeline')
    //         ->with('success', 'CTA berhasil diupdate!');
    // }
    
    public function storeMassal(Request $request)
    {
        $rows = $request->input('rows');
    
        if (!$rows) {
            return redirect()->back()->withErrors('Tidak ada data yang dikirim.');
        }
    
        $countSuccess = 0;
        $countFailed = 0;
        $countSkipped = 0; // Tambahan: Menghitung data yang dilewati
    
        foreach ($rows as $row) {
            // 🚨 LOGIKA BARU: Lewati baris jika Perusahaan, Lokasi, ATAU Catatan Prospek kosong
            if (empty($row['perusahaan']) || empty($row['lokasi']) || empty($row['catatan_prospek'])) {
                $countSkipped++;
                continue; // Langsung lompat ke baris berikutnya, tidak ada yang disimpan
            }
    
            $prospek = Prospek::where('perusahaan', 'LIKE', '%' . trim($row['perusahaan']) . '%')
                              ->where('lokasi', 'LIKE', '%' . trim($row['lokasi']) . '%')
                              ->first();
    
            if ($prospek) {
                // Update Catatan (Pasti tereksekusi karena sudah lolos pengecekan empty di atas)
                $prospek->update([
                    'catatan' => $row['catatan_prospek']
                ]);
    
                // Auto Multiply
                $jumlah = !empty($row['jumlah_peserta']) ? (int)$row['jumlah_peserta'] : null;
                $hargaPenawaran = !empty($row['harga_penawaran']) ? (float)$row['harga_penawaran'] : null;
                $hargaVendor = !empty($row['harga_vendor']) ? (float)$row['harga_vendor'] : null;
    
                $totalPenawaran = ($jumlah && $hargaPenawaran) ? $jumlah * $hargaPenawaran : null;
                $totalVendor = ($jumlah && $hargaVendor) ? $jumlah * $hargaVendor : null;
    
                $keterangan = !empty($row['keterangan']) ? $row['keterangan'] : '-';
    
                Cta::create([
                    'prospek_id'       => $prospek->id,
                    'judul_permintaan' => $row['judul_permintaan'] ?? null,
                    'jumlah_peserta'   => $jumlah,
                    'sertifikasi'      => $row['sertifikasi'] ?? null,
                    'skema'            => $row['skema'] ?? null,
                    'harga_penawaran'  => $hargaPenawaran,
                    'harga_vendor'     => $hargaVendor,
                    'total_penawaran'  => $totalPenawaran,
                    'total_vendor'     => $totalVendor,
                    'proposal_link'    => $row['proposal_link'] ?? null,
                    'status_penawaran' => $row['status_penawaran'] ?? null,
                    'keterangan'       => $keterangan,
                ]);
    
                $countSuccess++;
            } else {
                $countFailed++;
            }
        }
    
        // Buat pesan notifikasi yang detail
        $pesan = "$countSuccess Data CTA berhasil ditambahkan.";
        
        if ($countFailed > 0) {
            $pesan .= " Ada $countFailed gagal masuk karena Perusahaan/Lokasi tidak cocok.";
        }
        
        if ($countSkipped > 0) {
            $pesan .= " Dan $countSkipped baris dilewati karena Catatan (Keterangan Akhir Data) kosong.";
        }
    
        return redirect()->back()->with('success', $pesan);
    }
}

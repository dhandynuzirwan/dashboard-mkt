<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\MasterTraining;
use App\Models\Prospek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CtaController extends Controller
{
    // 1. UPDATE METHOD CREATE (Untuk Form Tambah CTA)
   // 1. UPDATE METHOD CREATE (Untuk Form Tambah CTA)
    public function create($prospek_id)
    {
        $prospek = Prospek::with('marketing')->findOrFail($prospek_id);
        $trainings = MasterTraining::orderBy('nama_training')->get();
        $authUser = auth()->user();

        // 🔐 Jika marketing, hanya boleh buka prospek miliknya
        if ($authUser->role === 'marketing' && $prospek->marketing_id != $authUser->id) {
            abort(403, 'Unauthorized');
        }

        // 🔥 CEK APAKAH PROSPEK INI SUDAH PUNYA CTA SEBELUMNYA 🔥
        $existingCtaCount = Cta::where('prospek_id', $prospek_id)->count();

        // --- LOGIKA NEXT & PREVIOUS PROSPEK (SESUAI FILTER PIPELINE) ---
        $query = Prospek::query();

        // 1. Filter Role
        if ($authUser->role === 'marketing') {
            $query->where('marketing_id', $authUser->id);
        }

        // 2. Ambil URL Session Terakhir
        $lastUrl = session('url_pipeline_terakhir');
        $filters = [];
        if ($lastUrl) {
            $queryString = parse_url($lastUrl, PHP_URL_QUERY); 
            if ($queryString) {
                parse_str($queryString, $filters); 
            }
        }

        // 3. Terapkan Filter Tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('tanggal_prospek', [$filters['start_date'], $filters['end_date']]);
        }

        // 4. Terapkan Filter Marketing
        if (!empty($filters['marketing_id'])) {
            $query->where('marketing_id', $filters['marketing_id']);
        }

        // 5. Terapkan Filter TAHAP (Pending / Done)
        if (!empty($filters['cta_status'])) {
            if ($filters['cta_status'] == 'pending') {
                $query->whereDoesntHave('cta'); 
            } elseif ($filters['cta_status'] == 'done') {
                $query->whereHas('cta'); 
            }
        }

        // 6. Terapkan Filter Status Akhir Data (Catatan)
        if (!empty($filters['status_akhir'])) {
            if ($filters['status_akhir'] === 'belum_ada_status') {
                $query->where(function($q) {
                    $q->whereNull('status')->orWhere('status', '');
                });
            } else {
                $query->where('status', $filters['status_akhir']);
            }
        }

        // 7. Terapkan Filter Status Penawaran CTA
        if (!empty($filters['status'])) {
            $query->whereHas('cta', function ($q) use ($filters) {
                $q->where('status_penawaran', $filters['status']);
            });
        }

        // 8. Terapkan Filter Pencarian
        if (!empty($filters['search_perusahaan'])) {
            $query->where('perusahaan', 'LIKE', '%' . $filters['search_perusahaan'] . '%');
        }
        
        // 9. Eksekusi Next & Prev
        $prevProspek = (clone $query)->where('id', '<', $prospek_id)->orderBy('id', 'desc')->first();
        $nextProspek = (clone $query)->where('id', '>', $prospek_id)->orderBy('id', 'asc')->first();
        // --------------------------------------

        return view('form-cta', compact('prospek', 'trainings', 'prevProspek', 'nextProspek', 'existingCtaCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prospek_id' => 'required|exists:prospeks,id',
            'catatan_prospek' => 'required|string',
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable|url',
            'file_proposal' => 'nullable|mimes:pdf|max:5120',
            'status_penawaran' => 'nullable',
            'keterangan' => 'nullable|string',
        ]);
    
        $prospek = Prospek::findOrFail($validated['prospek_id']);
        $prospek->update(['catatan' => $validated['catatan_prospek']]);
        unset($validated['catatan_prospek']);
    
        $jumlah = $validated['jumlah_peserta'] ?? null;
        $hargaPenawaran = $validated['harga_penawaran'] ?? null;
        $hargaVendor = $validated['harga_vendor'] ?? null;
    
        $validated['total_penawaran'] = ($jumlah && $hargaPenawaran) ? $jumlah * $hargaPenawaran : null;
        $validated['total_vendor'] = ($jumlah && $hargaVendor) ? $jumlah * $hargaVendor : null;
        
        // 🔥 TAMBAHAN: LOGIKA UPLOAD FILE BARU
        if ($request->hasFile('file_proposal')) {
            $path = $request->file('file_proposal')->store('proposals', 'public');
            $validated['file_proposal'] = $path;
        }
        
        // 1. Eksekusi Simpan
        Cta::create($validated);
        
        // 2. Jika status langsung deal
        if ($request->status_penawaran == 'deal') {
            // Gunakan back() agar tetap di Form Tambah (Bisa langsung tambah judul ke-2)
            return back()->with('deal_congrats', 'Closing Mantap! Selamat atas Project barunya!');
        }

        // Gunakan back() agar tetap di Form Tambah
        return back()->with('success', 'Data CTA berhasil disimpan! Silakan input judul lain jika ada.');
    }
    
    public function update(Request $request, $id)
    {
        // 1. Cari data CTA dan simpan status lamanya
        $cta = Cta::findOrFail($id);
        $statusLama = $cta->status_penawaran;
    
        // 2. Validasi (Pastikan semua field yang ingin diupdate ada di sini)
        $validated = $request->validate([
            'catatan_prospek' => 'required|string', 
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable|url',
            'file_proposal' => 'nullable|mimes:pdf|max:5120',
            'status_penawaran' => 'nullable|string', // Pastikan ini terkirim dari form
            'keterangan' => 'nullable|string',
        ]);
    
        // 3. Update Catatan di tabel Prospek (pake id_prospek dari data cta)
        \App\Models\Prospek::where('id', $cta->prospek_id)->update([
            'catatan' => $request->catatan_prospek
        ]);
    
        // 4. Hitung ulang total (Pakai logika null-safe biar nggak error kalau kosong)
        $jumlah = $request->jumlah_peserta ?? 0;
        $hargaP = $request->harga_penawaran ?? 0;
        $hargaV = $request->harga_vendor ?? 0;
    
        $dataUpdate = $request->except(['_token', '_method', 'catatan_prospek']);
        $dataUpdate['total_penawaran'] = $jumlah * $hargaP;
        $dataUpdate['total_vendor'] = $jumlah * $hargaV;
        
        // 🔥 TAMBAHAN: LOGIKA UPDATE FILE
        if ($request->hasFile('file_proposal')) {
            // Hapus file lama dari storage jika sebelumnya sudah ada
            if ($cta->file_proposal && Storage::disk('public')->exists($cta->file_proposal)) {
                Storage::disk('public')->delete($cta->file_proposal);
            }
            // Simpan file baru
            $path = $request->file('file_proposal')->store('proposals', 'public');
            $dataUpdate['file_proposal'] = $path;
        }
        
        // 1. Eksekusi Update
        $cta->update($dataUpdate);

        // 2. Jika status berubah jadi deal
        if ($request->status_penawaran == 'deal' && $statusLama != 'deal') {
            // Gunakan back() agar tetap di Form Edit
            return back()->with('deal_congrats', 'Gokil! Project Deal baru berhasil diamankan!');
        }

        // Gunakan back() agar tetap di Form Edit
        return back()->with('success', 'Perubahan data penawaran berhasil disimpan!');
    }

    // 2. UPDATE METHOD EDIT (Untuk Form Edit CTA)
    public function edit($id)
    {
        $cta = Cta::with('prospek')->findOrFail($id);
        $trainings = MasterTraining::orderBy('nama_training')->get();
        $authUser = auth()->user();
        
        // Ambil penawaran LAINNYA dari perusahaan yang sama
        $penawaranLainnya = Cta::where('prospek_id', $cta->prospek_id)
                                ->where('id', '!=', $id)
                                ->latest()
                                ->get();

        // --- LOGIKA NEXT & PREVIOUS CTA (SESUAI FILTER PIPELINE) ---
        $query = Cta::with('prospek');

        // 1. Filter Role
        if ($authUser->role === 'marketing') {
            $query->whereHas('prospek', function($q) use ($authUser) {
                $q->where('marketing_id', $authUser->id);
            });
        }

        // 2. Ambil URL Session Terakhir
        $lastUrl = session('url_pipeline_terakhir');
        $filters = [];
        if ($lastUrl) {
            $queryString = parse_url($lastUrl, PHP_URL_QUERY);
            if ($queryString) {
                parse_str($queryString, $filters);
            }
        }

        // 3. Terapkan Filter Tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereHas('prospek', function($q) use ($filters) {
                $q->whereBetween('tanggal_prospek', [$filters['start_date'], $filters['end_date']]);
            });
        }

        // 4. Terapkan Filter Marketing 
        if (!empty($filters['marketing_id'])) {
            $query->whereHas('prospek', function($q) use ($filters) {
                $q->where('marketing_id', $filters['marketing_id']);
            });
        }

        // 5. Terapkan Filter Status Penawaran CTA (Deal, Hold, dll)
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'not_null') {
                $query->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '');
            } else {
                $query->where('status_penawaran', $filters['status']);
            }
        }

        // 6. Terapkan Filter Status Akhir Data (Manja, Dapat Email, dll)
        if (!empty($filters['status_akhir'])) {
            $query->whereHas('prospek', function($q) use ($filters) {
                if ($filters['status_akhir'] === 'belum_ada_status') {
                    $q->where(function($subQ) {
                        $subQ->whereNull('status')->orWhere('status', '');
                    });
                } else {
                    $q->where('status', $filters['status_akhir']);
                }
            });
        }

        // 7. Terapkan Filter Pencarian Nama Perusahaan
        if (!empty($filters['search_perusahaan'])) {
            $query->whereHas('prospek', function($q) use ($filters) {
                $q->where('perusahaan', 'LIKE', '%' . $filters['search_perusahaan'] . '%');
            });
        }

        // 8. Eksekusi Next & Prev!
        $prevCta = (clone $query)->where('id', '<', $id)->orderBy('id', 'desc')->first();
        $nextCta = (clone $query)->where('id', '>', $id)->orderBy('id', 'asc')->first();
        // -------------------------------------------------------------

        return view('form-cta-edit', compact('cta', 'trainings', 'penawaranLainnya', 'prevCta', 'nextCta'));
    }
    
    public function destroy($id)
    {
        // ==========================================
        // TRAP DEBUGGING (Hapus tanda // di bawah ini jika masih gagal)
        // dd("TOMBOL HAPUS BERHASIL DITEKAN! ID DATA: " . $id);
        // ==========================================

        $cta = Cta::with('prospek')->findOrFail($id);

        // 🔐 KEAMANAN EKSTRA: Pastikan marketing hanya bisa hapus data miliknya
        if (auth()->user()->role === 'marketing' && $cta->prospek->marketing_id != auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus data ini.');
        }

        // 🔥 EKSEKUSI HAPUS PERMANEN (Bypass SoftDeletes)
        $cta->forceDelete();

        // Redirect ke Pipeline karena datanya sudah tidak ada
        return redirect()->route('prospek.index')->with('success', 'Data Penawaran (CTA) berhasil dihapus permanen!');
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
        $countSkipped = 0;
    
        foreach ($rows as $row) {
            // 1. Lewati baris jika Perusahaan, Lokasi, ATAU Catatan kosong
            if (empty($row['perusahaan']) || empty($row['lokasi']) || empty($row['catatan_prospek'])) {
                $countSkipped++;
                continue; 
            }
    
            // 2. CARI PROSPEK (Ini bagian yang mungkin terhapus sebelumnya)
            $prospek = Prospek::where('perusahaan', 'LIKE', '%' . trim($row['perusahaan']) . '%')
                              ->where('lokasi', 'LIKE', '%' . trim($row['lokasi']) . '%')
                              ->first();
    
            // 3. JIKA PROSPEK DITEMUKAN
            if ($prospek) {
                // Update Catatan 
                $prospek->update([
                    'catatan' => $row['catatan_prospek']
                ]);
    
                // Hitung-hitungan Angka
                $jumlah = !empty($row['jumlah_peserta']) ? (int)$row['jumlah_peserta'] : null;
                $hargaPenawaran = !empty($row['harga_penawaran']) ? (float)$row['harga_penawaran'] : null;
                $hargaVendor = !empty($row['harga_vendor']) ? (float)$row['harga_vendor'] : null;
    
                $totalPenawaran = ($jumlah && $hargaPenawaran) ? $jumlah * $hargaPenawaran : null;
                $totalVendor = ($jumlah && $hargaVendor) ? $jumlah * $hargaVendor : null;
                $keterangan = !empty($row['keterangan']) ? $row['keterangan'] : '-';

                // 🔥 LOGIKA TERJEMAHAN SERTIFIKASI (Pencarian Kata Kunci Kuat)
                $sertifikasiExcel = isset($row['sertifikasi']) ? strtoupper(trim($row['sertifikasi'])) : '';
                $sertifikasiDB = null;
        
                if ($sertifikasiExcel !== '') {
                    if (str_contains($sertifikasiExcel, 'KEMENAKER') || str_contains($sertifikasiExcel, 'KEMNAKER')) {
                        $sertifikasiDB = 'kemnaker';
                    } elseif (str_contains($sertifikasiExcel, 'BNSP')) {
                        $sertifikasiDB = 'bnsp';
                    } elseif (str_contains($sertifikasiExcel, 'INTERNAL')) {
                        $sertifikasiDB = 'internal';
                    } elseif (str_contains($sertifikasiExcel, 'SIO')) {
                        $sertifikasiDB = 'sio';
                    } elseif (str_contains($sertifikasiExcel, 'RIKSA')) {
                        $sertifikasiDB = 'riksa';
                    }
                }
    
                // 4. SIMPAN DATA KE TABEL CTA
                Cta::create([
                    'prospek_id'       => $prospek->id, // <-- Ini tidak akan error lagi
                    'judul_permintaan' => $row['judul_permintaan'] ?? null,
                    'jumlah_peserta'   => $jumlah,
                    'sertifikasi'      => $sertifikasiDB, 
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
    
        // 5. PESAN NOTIFIKASI
        $pesan = "$countSuccess Data CTA berhasil ditambahkan.";
        
        if ($countFailed > 0) {
            $pesan .= " Ada $countFailed gagal masuk karena Perusahaan/Lokasi tidak cocok.";
        }
        
        if ($countSkipped > 0) {
            $pesan .= " Dan $countSkipped baris dilewati karena Catatan (Keterangan Akhir Data) kosong.";
        }
    
        return redirect()->back()->with('success', $pesan);
    }
    
    // ================= DELETE MASSAL CTA (DUPLIKAT) =================
    public function massDelete(Request $request)
    {
        if (!in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Unauthorized Access');
        }

        $selectedIds = $request->input('selected_cta');

        if (empty($selectedIds) || !is_array($selectedIds)) {
            return redirect()->back()->withErrors('Gagal! Anda belum memilih data CTA apapun untuk dihapus.');
        }

        // Ambil data dan hapus file proposalnya jika ada
        $ctas = Cta::whereIn('id', $selectedIds)->get();
        foreach($ctas as $cta) {
            if ($cta->file_proposal && Storage::disk('public')->exists($cta->file_proposal)) {
                Storage::disk('public')->delete($cta->file_proposal);
            }
            $cta->forceDelete(); // Hapus permanen
        }

        return redirect()->back()->with('success', "Berhasil menghapus " . count($selectedIds) . " data penawaran (CTA) duplikat secara permanen.");
    }
}

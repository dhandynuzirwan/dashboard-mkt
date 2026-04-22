<?php

namespace App\Http\Controllers;

use App\Models\PengirimanPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// --- TAMBAHAN UNTUK IMPORT EXCEL ---
use App\Imports\PengirimanPaketImport;
use Maatwebsite\Excel\Facades\Excel;

class PengirimanPaketController extends Controller
{
    // ================= INDEX & FILTER =================
    public function index(Request $request)
    {
        $query = PengirimanPaket::query();

        // 1. Filter Pencarian (Nama, Instansi, Resi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_penerima', 'LIKE', "%{$search}%")
                  ->orWhere('instansi', 'LIKE', "%{$search}%")
                  ->orWhere('no_resi', 'LIKE', "%{$search}%");
            });
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status_pengiriman', $request->status);
        }

        // 3. Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kirim', [$request->start_date, $request->end_date]);
        }

        // Ambil Data untuk Tabel
        $data_pengiriman = $query->orderBy('tanggal_kirim', 'desc')->paginate(10)->withQueryString();

        // --- HITUNG STATISTIK (Untuk Card di Atas) ---
        $stats = [
            'total'      => PengirimanPaket::count(),
            'diproses'   => PengirimanPaket::where('status_pengiriman', 'Diproses')->count(),
            'dikirim'    => PengirimanPaket::where('status_pengiriman', 'Dikirim')->count(),
            'diterima'   => PengirimanPaket::where('status_pengiriman', 'Diterima')->count(),
        ];

        return view('operational.monitoring-paket', compact('data_pengiriman', 'stats'));
    }

    // ================= STORE DATA BARU =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi'          => 'required|string',
            'nama_penerima'     => 'required|string',
            'no_hp'             => 'required',
            'alamat_pengiriman' => 'required',
            'jenis_paket'       => 'required',
            'isi_paket'         => 'required|array', // Harus array karena dari checkbox
            'isi_paket_lainnya' => 'nullable|string',
            'ekspedisi'         => 'required',
            'no_resi'           => 'nullable',
            'biaya_pengiriman'  => 'required|numeric',
            'status_pengiriman' => 'required',
            'tanggal_kirim'     => 'required|date',
            'tanggal_diterima'  => 'nullable|date',
            'catatan_teks'      => 'nullable',
            'catatan_file'      => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        // Handle Upload File Bukti/Resi
        if ($request->hasFile('catatan_file')) {
            $path = $request->file('catatan_file')->store('bukti_pengiriman', 'public');
            $validated['catatan_file'] = $path;
        }

        PengirimanPaket::create($validated);

        return redirect()->back()->with('success', 'Data pengiriman paket berhasil disimpan!');
    }

    // ================= UPDATE DATA =================
    public function update(Request $request, $id)
    {
        $paket = PengirimanPaket::findOrFail($id);
        
        $validated = $request->validate([
            'instansi'          => 'required',
            'nama_penerima'     => 'required',
            'status_pengiriman' => 'required',
            'no_resi'           => 'nullable',
            'tanggal_diterima'  => 'nullable|date',
            // ... tambahkan validasi lain sesuai kebutuhan
        ]);

        // Handle Ganti File Jika ada upload baru
        if ($request->hasFile('catatan_file')) {
            // Hapus file lama
            if ($paket->catatan_file) {
                Storage::disk('public')->delete($paket->catatan_file);
            }
            $path = $request->file('catatan_file')->store('bukti_pengiriman', 'public');
            $validated['catatan_file'] = $path;
        }

        $paket->update($validated);

        return redirect()->back()->with('success', 'Data pengiriman berhasil diperbarui!');
    }

    // ================= DELETE DATA =================
    public function destroy($id)
    {
        $paket = PengirimanPaket::findOrFail($id);
        
        // Hapus file dari storage jika ada sebelum datanya dihapus
        if ($paket->catatan_file) {
            Storage::disk('public')->delete($paket->catatan_file);
        }
        
        $paket->delete();
        return redirect()->route('operational.monitoring-paket')->with('success', 'Paket berhasil dihapus!');
    }

    // ================= IMPORT EXCEL DATA =================
    public function import(Request $request)
    {
        // Validasi file yang diupload harus excel/csv
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120', // Maks 5MB
        ], [
            'file_excel.required' => 'Silakan pilih file Excel terlebih dahulu.',
            'file_excel.mimes' => 'Format file harus berupa Excel (.xlsx, .xls) atau CSV.',
            'file_excel.max' => 'Ukuran file terlalu besar (Maksimal 5MB).'
        ]);

        try {
            // Eksekusi import
            Excel::import(new PengirimanPaketImport, $request->file('file_excel'));
            
            return redirect()->back()->with('success', 'Data spreadsheet paket berhasil dimigrasi ke sistem!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Gagal import data. Pastikan format kolom Excel sesuai. Error: ' . $e->getMessage());
        }
    }
}
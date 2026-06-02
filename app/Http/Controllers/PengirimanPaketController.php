<?php

namespace App\Http\Controllers;

use App\Models\PengirimanPaket;
use App\Models\User;
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
        // Gunakan with('marketing') agar query lebih ringan (Eager Loading)
        $query = PengirimanPaket::with('marketing');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_penerima', 'LIKE', "%{$search}%")
                  ->orWhere('instansi', 'LIKE', "%{$search}%")
                  ->orWhere('no_resi', 'LIKE', "%{$search}%")
                  // Mencari berdasarkan nama marketing di tabel users
                  ->orWhereHas('marketing', function($qM) use ($search) {
                      $qM->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_pengiriman', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_kirim', [$request->start_date, $request->end_date]);
        }

        $data_pengiriman = $query->orderByRaw("CASE WHEN status_pengiriman = 'Diterima' THEN 1 ELSE 0 END ASC")
                                 ->orderBy('tanggal_kirim', 'desc')
                                 ->paginate(10)
                                 ->withQueryString();

        $stats = [
            'total'      => PengirimanPaket::count(),
            'diproses'   => PengirimanPaket::where('status_pengiriman', 'Diproses')->count(),
            'dikirim'    => PengirimanPaket::where('status_pengiriman', 'Dikirim')->count(),
            'diterima'   => PengirimanPaket::where('status_pengiriman', 'Diterima')->count(),
        ];

        // Tarik data user marketing untuk Dropdown Form
        $marketings = User::where('role', 'marketing')->get();

        return view('operational.monitoring-paket', compact('data_pengiriman', 'stats', 'marketings'));
    }

    // ================= STORE DATA BARU =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'marketing_id'      => 'nullable|exists:users,id', // 🔥 Ganti pj_marketing jadi ini
            'instansi'          => 'required|string',
            'nama_penerima'     => 'required|string',
            'no_hp'             => 'required',
            'alamat_pengiriman' => 'required',
            'jenis_paket'       => 'required',
            'isi_paket'         => 'required|array',
            'isi_paket_lainnya' => 'nullable|string',
            'ekspedisi'         => 'required',
            'no_resi'           => 'nullable',
            'foto_resi'         => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'biaya_pengiriman'  => 'required|numeric',
            'status_pengiriman' => 'required',
            'tanggal_kirim'     => 'required|date',
            'tanggal_diterima'  => 'nullable|date',
            'catatan_teks'      => 'nullable',
            'catatan_file'      => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        // Proses Upload Bukti Diterima
        if ($request->hasFile('catatan_file')) {
            $path = $request->file('catatan_file')->store('bukti_pengiriman', 'public');
            $validated['catatan_file'] = $path;
        }

        // 🔥 Proses Upload Bukti Resi
        if ($request->hasFile('foto_resi')) {
            $resiPath = $request->file('foto_resi')->store('bukti_resi', 'public');
            $validated['foto_resi'] = $resiPath;
        }

        PengirimanPaket::create($validated);
        return redirect()->back()->with('success', 'Data pengiriman paket berhasil disimpan!');
    }

    // ================= UPDATE DATA =================
    public function update(Request $request, $id)
    {
        $paket = PengirimanPaket::findOrFail($id);
        
        $validated = $request->validate([
            'marketing_id'      => 'nullable|exists:users,id', // 🔥 Ganti pj_marketing jadi ini
            'instansi'          => 'required|string',
            'nama_penerima'     => 'required|string',
            'no_hp'             => 'required',
            'alamat_pengiriman' => 'required',
            'jenis_paket'       => 'required',
            'isi_paket'         => 'required|array',
            'isi_paket_lainnya' => 'nullable|string',
            'ekspedisi'         => 'required',
            'no_resi'           => 'nullable',
            'foto_resi'         => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'biaya_pengiriman'  => 'required|numeric',
            'status_pengiriman' => 'required',
            'tanggal_kirim'     => 'required|date',
            'tanggal_diterima'  => 'nullable|date',
            'catatan_teks'      => 'nullable',
            'catatan_file'      => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('catatan_file')) {
            if ($paket->catatan_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($paket->catatan_file);
            }
            $path = $request->file('catatan_file')->store('bukti_pengiriman', 'public');
            $validated['catatan_file'] = $path;
        }

        // 🔥 Proses Update Bukti Resi
        if ($request->hasFile('foto_resi')) {
            // Hapus resi lama jika ada
            if ($paket->foto_resi) {
                Storage::disk('public')->delete($paket->foto_resi);
            }
            $resiPath = $request->file('foto_resi')->store('bukti_resi', 'public');
            $validated['foto_resi'] = $resiPath;
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

        // 🔥 Hapus file foto_resi dari storage
        if ($paket->foto_resi) {
            Storage::disk('public')->delete($paket->foto_resi);
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
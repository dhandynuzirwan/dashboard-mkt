<?php

namespace App\Http\Controllers;

use App\Models\ResourceLink; // Pastikan model di-import
use App\Models\KontakPenting; // Import model baru
use Illuminate\Http\Request;

class OperationalController extends Controller
{
    // 1. Menampilkan Halaman Utama (Index)
    public function index(Request $request)
    {
        // --- Logika untuk Resource Links (Dokumen) ---
        $queryLinks = ResourceLink::query();
        
        if ($request->filled('search')) {
            $queryLinks->where('nama_dokumen', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->filled('kategori') && $request->kategori != 'all') {
            $queryLinks->where('kategori', $request->kategori);
        }
        
        $resource_links = $queryLinks->latest()->get();

        // --- Logika untuk Kontak Penting ---
        $kontaks = KontakPenting::latest()->get();

        // Mengirim kedua data tersebut ke view 'operational' (atau nama view kamu)
        return view('operational', compact('resource_links', 'kontaks'));
    }
    
    // 2. Fungsi Simpan Kontak Baru
    public function storeKontak(Request $request)
    {
        $request->validate([
            'kategori'      => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'nama_pic'      => 'required|string|max:255',
            'nomor_wa'      => 'required|string|max:20',
        ]);

        KontakPenting::create([
            'kategori'      => $request->kategori,
            'nama_instansi' => $request->nama_instansi,
            'nama_pic'      => $request->nama_pic,
            'nomor_wa'      => $request->nomor_wa,
        ]);

        return back()->with('success', 'Kontak penting berhasil ditambahkan!');
    }

    // 3. Fungsi Hapus Kontak
    public function destroyKontak($id)
    {
        $kontak = KontakPenting::findOrFail($id);
        $kontak->delete();

        return back()->with('success', 'Kontak berhasil dihapus!');
    }

    // Memproses form tambah link kerja
    public function storeResource(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'url_link' => 'required|url',
            'kategori' => 'required|in:spreadsheet,document,folder,other'
        ]);

        ResourceLink::create([
            'nama_dokumen' => $request->nama_dokumen,
            'url_link' => $request->url_link,
            'kategori' => $request->kategori,
        ]);

        // Redirect kembali ke halaman operational dengan pesan sukses
        return redirect()->route('operational')->with('success', 'Resource Link berhasil ditambahkan!');
    }
    
    // Memproses update link (EDIT)
    public function updateResource(Request $request, $id)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'url_link' => 'required|url',
            'kategori' => 'required|in:spreadsheet,document,folder,other'
        ]);

        $link = ResourceLink::findOrFail($id);
        
        $link->update([
            'nama_dokumen' => $request->nama_dokumen,
            'url_link' => $request->url_link,
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Resource Link berhasil diperbarui!');
    }

    // Memproses hapus link (DELETE)
    public function destroyResource($id)
    {
        $link = ResourceLink::findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Resource Link berhasil dihapus!');
    }
}
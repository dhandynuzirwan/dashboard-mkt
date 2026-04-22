<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\Item;
use App\Models\ItemLog;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    // ================= 1. TAMPILKAN HALAMAN INVENTARIS =================
    public function index(Request $request)
    {
        // Query untuk Aset Tetap (Tab 1)
        $queryAset = Aset::query();
        if ($request->filled('search')) {
            $queryAset->where('nama', 'like', '%' . $request->search . '%')
                      ->orWhere('kode', 'like', '%' . $request->search . '%');
        }
        $asets = $queryAset->orderBy('id', 'desc')->get();

        // Query untuk Barang Persediaan (Tab 2)
        $queryItem = Item::query();
        if ($request->filled('search_stok')) {
            $queryItem->where('nama', 'like', '%' . $request->search_stok . '%');
        }
        $items = $queryItem->orderBy('id', 'desc')->get();

        // Hitung Statistik untuk Card di atas
        $stats = [
            'total_aset'   => Aset::count(),
            'jenis_item'   => Item::count(),
            // Cek item yang stoknya kurang dari atau sama dengan batas minimum
            'stok_menipis' => Item::whereColumn('stok', '<=', 'min_stok')->count(),
            // Cek aset yang statusnya Rusak
            'aset_rusak'   => Aset::where('kondisi', 'like', '%Rusak%')->count(),
        ];

        return view('operational.inventaris', compact('asets', 'items', 'stats'));
    }

    // ================= 2. SIMPAN ASET TETAP BARU =================
    public function storeAset(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'kategori'   => 'required|string',
            'tgl_masuk'  => 'required|date',
            'lokasi'     => 'required|string',
            'pic'        => 'nullable|string',
            'harga_beli' => 'nullable|numeric',
            'kondisi'    => 'required|string',
            'foto_aset'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Auto-Generate Kode Aset (Contoh: INV-2404-001)
        $tahunBulan = date('ym');
        $urutanTerakhir = Aset::where('kode', 'like', "INV-{$tahunBulan}-%")->count() + 1;
        $kodeAset = "INV-{$tahunBulan}-" . str_pad($urutanTerakhir, 3, '0', STR_PAD_LEFT);

        // Handle Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto_aset')) {
            $fotoPath = $request->file('foto_aset')->store('foto_aset', 'public');
        }

        Aset::create([
            'kode'       => $kodeAset,
            'nama'       => $validated['nama'],
            'kategori'   => $validated['kategori'],
            'tgl_masuk'  => $validated['tgl_masuk'],
            'lokasi'     => $validated['lokasi'],
            'pic'        => $validated['pic'],
            'harga'      => $validated['harga_beli'],
            'kondisi'    => $validated['kondisi'],
            'foto'       => $fotoPath,
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->back()->with('success', 'Aset Tetap baru berhasil ditambahkan!');
    }

    // ================= 3. SIMPAN BARANG PERSEDIAAN BARU =================
    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'kategori'      => 'required|string',
            'satuan'        => 'required|string',
            'stok_awal'     => 'required|integer|min:0',
            'batas_minimum' => 'required|integer|min:1',
        ]);

        // Simpan Master Barang
        $item = Item::create([
            'nama'     => $validated['nama_barang'],
            'kategori' => $validated['kategori'],
            'satuan'   => $validated['satuan'],
            'stok'     => $validated['stok_awal'],
            'min_stok' => $validated['batas_minimum'],
        ]);

        // Jika stok awalnya lebih dari 0, otomatis catat di Log sebagai saldo awal
        if ($validated['stok_awal'] > 0) {
            ItemLog::create([
                'item_id'    => $item->id,
                'user_id'    => auth()->id(), // Mencatat siapa yg input
                'tipe'       => 'in',
                'qty'        => $validated['stok_awal'],
                'keterangan' => 'Stok Awal Sistem',
            ]);
        }

        return redirect()->back()->with('success', 'Barang Persediaan baru berhasil didaftarkan!');
    }

    // ================= 4. MUTASI STOK (IN / OUT) =================
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'tipe'       => 'required|in:in,out',
            'qty'        => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $item = Item::findOrFail($id);

        // Jika barang KELUAR (Pemakaian), pastikan stoknya cukup!
        if ($request->tipe == 'out' && $request->qty > $item->stok) {
            return redirect()->back()->withErrors("Gagal! Stok {$item->nama} tidak mencukupi. Sisa stok saat ini hanya {$item->stok} {$item->satuan}.");
        }

        // Catat ke Log Histori
        ItemLog::create([
            'item_id'    => $item->id,
            'user_id'    => auth()->id(),
            'tipe'       => $request->tipe,
            'qty'        => $request->qty,
            'keterangan' => $request->keterangan ?? ($request->tipe == 'in' ? 'Restock / Penambahan' : 'Pemakaian Operasional'),
        ]);

        // Update jumlah stok di tabel Master
        if ($request->tipe == 'in') {
            $item->increment('stok', $request->qty); // Tambah
        } else {
            $item->decrement('stok', $request->qty); // Kurang
        }

        return redirect()->back()->with('success', 'Stok berhasil diupdate!');
    }
}
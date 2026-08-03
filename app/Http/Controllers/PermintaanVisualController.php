<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermintaanVisualController extends Controller
{
    public function biasaIndex(Request $request)
    {
        $query = \App\Models\PermintaanBiasa::with(['user', 'pic'])->orderBy('created_at', 'desc');

        // Filter
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $permintaans = $query->get();

        // Stat Cards (Menunggu, Dalam Proses, Review, Selesai)
        $statMenunggu = \App\Models\PermintaanBiasa::where('status', 'Menunggu')->count();
        $statProses = \App\Models\PermintaanBiasa::where('status', 'Dalam Proses')->count();
        $statReview = \App\Models\PermintaanBiasa::where('status', 'Review')->count();
        $statSelesai = \App\Models\PermintaanBiasa::where('status', 'Selesai')->count();

        return view('operational.permintaan-visual.biasa.index', compact('permintaans', 'statMenunggu', 'statProses', 'statReview', 'statSelesai'));
    }

    public function biasaCreate()
    {
        return view('operational.permintaan-visual.biasa.create');
    }

    public function biasaStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deadline' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'referensi' => 'nullable|file|mimes:png,jpg,jpeg,pdf,ai,psd|max:20480',
            'catatan' => 'nullable|string'
        ]);

        // Hitung prioritas
        $deadline = \Carbon\Carbon::parse($request->deadline);
        $today = \Carbon\Carbon::now()->startOfDay();
        $diffDays = $today->diffInDays($deadline, false); // false = izinkan nilai negatif jika sudah lewat

        if ($diffDays <= 2) {
            $prioritas = 'Tinggi';
        } elseif ($diffDays >= 3 && $diffDays <= 6) {
            $prioritas = 'Sedang';
        } else {
            $prioritas = 'Rendah';
        }

        $referensi_file = null;
        if ($request->hasFile('referensi')) {
            $file = $request->file('referensi');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $referensi_file = $file->storeAs('permintaan_biasa/referensi', $filename, 'public');
        }

        \App\Models\PermintaanBiasa::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deadline' => $request->deadline,
            'tujuan' => $request->tujuan,
            'deskripsi' => $request->deskripsi,
            'referensi_file' => $referensi_file,
            'catatan' => $request->catatan,
            'prioritas' => $prioritas,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('operational.permintaan-visual.biasa')->with('success', 'Permintaan berhasil diajukan dengan prioritas ' . $prioritas . '.');
    }

    public function trainingIndex()
    {
        return view('operational.permintaan-visual.training.index');
    }
}

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
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable',
            'status_penawaran' => 'nullable',
            'keterangan' => 'required|string',
        ]);

        // 🔥 AUTO MULTIPLY (AMAN DARI NULL)
        $jumlah = $validated['jumlah_peserta'] ?? null;
        $hargaPenawaran = $validated['harga_penawaran'] ?? null;
        $hargaVendor = $validated['harga_vendor'] ?? null;

        $validated['total_penawaran'] = ($jumlah && $hargaPenawaran)
            ? $jumlah * $hargaPenawaran
            : null;

        $validated['total_vendor'] = ($jumlah && $hargaVendor)
            ? $jumlah * $hargaVendor
            : null;

        Cta::create($validated);

        return redirect()->route('pipeline')
            ->with('success', 'Data CTA berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $cta = Cta::with('prospek')->findOrFail($id);

        return view('form-cta-edit', compact('cta'));
    }

    public function update(Request $request, $id)
    {
        $cta = Cta::findOrFail($id);

        $validated = $request->validate([
            'judul_permintaan' => 'nullable',
            'jumlah_peserta' => 'nullable|numeric|min:1',
            'sertifikasi' => 'nullable',
            'skema' => 'nullable',
            'harga_penawaran' => 'nullable|numeric|min:0',
            'harga_vendor' => 'nullable|numeric|min:0',
            'proposal_link' => 'nullable|url',
            'status_penawaran' => 'nullable',
            'keterangan' => 'required|string',
        ]);

        // 🔥 AUTO RECALCULATE
        $validated['total_penawaran'] = $validated['jumlah_peserta'] * $validated['harga_penawaran'];
        $validated['total_vendor'] = $validated['jumlah_peserta'] * $validated['harga_vendor'];

        $cta->update($validated);

        return redirect()->route('pipeline')
            ->with('success', 'CTA berhasil diupdate!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Prospek;
use Illuminate\Http\Request;

class CtaController extends Controller
{
    // Membuka form CTA berdasarkan ID Prospek
    public function create($prospek_id)
    {
        $prospek = Prospek::with('marketing')->findOrFail($prospek_id);
        $authUser = auth()->user();

        // 🔐 Jika marketing, hanya boleh buka prospek miliknya
        if ($authUser->role === 'marketing' && $prospek->marketing_id != $authUser->id) {
            abort(403, 'Unauthorized');
        }

        return view('form-cta', compact('prospek'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prospek_id' => 'required|exists:prospeks,id',
            'judul_permintaan' => 'required',
            'jumlah_peserta' => 'required|numeric',
            'harga_penawaran' => 'required|numeric',
            'harga_vendor' => 'required|numeric',
        ]);

        Cta::create($request->all());

        return redirect()->route('pipeline')->with('success', 'Data CTA berhasil ditambahkan!');
    }

public function edit($id)
{
    $cta = Cta::with('prospek')->findOrFail($id);

    return view('form-cta-edit', compact('cta'));
}

public function update(Request $request, $id)
{
    $cta = Cta::findOrFail($id);

    $request->validate([
        'judul_permintaan' => 'required',
        'jumlah_peserta' => 'required|numeric',
        'sertifikasi' => 'required',
        'skema' => 'required',
        'harga_penawaran' => 'required|numeric',
        'harga_vendor' => 'required|numeric',
        'proposal_link' => 'nullable|url',
        'status_penawaran' => 'required',
        'keterangan' => 'nullable',
    ]);

    $cta->update($request->all());

    return redirect()->route('pipeline')
        ->with('success', 'CTA berhasil diupdate!');
}
}

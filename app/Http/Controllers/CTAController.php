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
}
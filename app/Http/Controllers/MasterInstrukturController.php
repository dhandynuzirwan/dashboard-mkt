<?php

namespace App\Http\Controllers;

use App\Models\MasterInstruktur;
use Illuminate\Http\Request;

class MasterInstrukturController extends Controller
{
    public function index()
    {
        $instrukturs = MasterInstruktur::with('user')->latest()->get();
        return view('rnd.master-instruktur.index', compact('instrukturs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instruktur' => 'required|string|max:255',
            'wilayah_instansi' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'required|numeric',
            'no_rek' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'link_cv' => 'nullable|url',
        ]);

        MasterInstruktur::create([
            'nama_instruktur' => $request->nama_instruktur,
            'wilayah_instansi' => $request->wilayah_instansi,
            'no_telepon' => $request->no_telepon,
            'bidang_ahli' => $request->bidang_ahli,
            'rate_harga' => $request->rate_harga,
            'no_rek' => $request->no_rek,
            'bank' => $request->bank,
            'link_cv' => $request->link_cv,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_instruktur' => 'required|string|max:255',
            'wilayah_instansi' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'bidang_ahli' => 'required|string|max:255',
            'rate_harga' => 'required|numeric',
            'no_rek' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'link_cv' => 'nullable|url',
        ]);

        $instruktur = MasterInstruktur::findOrFail($id);
        $instruktur->update([
            'nama_instruktur' => $request->nama_instruktur,
            'wilayah_instansi' => $request->wilayah_instansi,
            'no_telepon' => $request->no_telepon,
            'bidang_ahli' => $request->bidang_ahli,
            'rate_harga' => $request->rate_harga,
            'no_rek' => $request->no_rek,
            'bank' => $request->bank,
            'link_cv' => $request->link_cv,
        ]);

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil diupdate.');
    }

    public function destroy($id)
    {
        $instruktur = MasterInstruktur::findOrFail($id);
        $instruktur->delete();

        return redirect()->route('master-instruktur.index')->with('success', 'Data Instruktur berhasil dihapus.');
    }
}

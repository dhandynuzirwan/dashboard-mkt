<?php

namespace App\Http\Controllers;

use App\Models\JenisIzin;
use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::with('user')->get();
        $jenis_izins = JenisIzin::all(); // Ambil data master izin

        return view('penggajian', compact('penggajians', 'jenis_izins'));
    }

    public function create()
    {
        $marketings = User::where('role', 'marketing')->get();

        return view('form-penggajian', compact('marketings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:penggajians,user_id',
            'target_call' => 'required|integer',
            'target' => 'required|numeric',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'required|numeric',
        ]);

        Penggajian::create($request->all());

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $marketings = User::where('role', 'marketing')->get();

        return view('form-penggajian-edit', compact('penggajian', 'marketings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:penggajians,user_id,'.$id,
            'target_call' => 'required|integer',
            'target' => 'required|numeric',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'required|numeric',
        ]);

        $penggajian = Penggajian::findOrFail($id);
        $penggajian->update($request->all());

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil diupdate');
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil dihapus');
    }

    public function storeJenisIzin(Request $request)
    {
        $request->validate([
            'nama_izin' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
        ]);

        JenisIzin::create($request->all());

        return redirect()->back()->with('success', 'Aturan potongan izin berhasil ditambahkan');
    }

    public function updateJenisIzin(Request $request, $id)
    {
        $request->validate([
            'nama_izin' => 'required|string|max:255',
            'potongan' => 'required|numeric|min:0',
        ]);

        $izin = JenisIzin::findOrFail($id);
        $izin->update($request->all());

        return redirect()->back()->with('success', 'Aturan potongan izin berhasil diperbarui');
    }

    public function destroyJenisIzin($id)
    {
        JenisIzin::destroy($id);
        return redirect()->back()->with('success', 'Aturan potongan izin berhasil dihapus');
    }
}

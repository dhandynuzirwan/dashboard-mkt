<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::with('user')->get();
        return view('penggajian', compact('penggajians'));
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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermintaanVisualController extends Controller
{
    public function biasaIndex()
    {
        return view('operational.permintaan-visual.biasa.index');
    }

    public function biasaCreate()
    {
        return view('operational.permintaan-visual.biasa.create');
    }

    public function biasaStore(Request $request)
    {
        // Handle store logic here
        return redirect()->route('operational.permintaan-visual.biasa')->with('success', 'Permintaan berhasil dibuat.');
    }

    public function trainingIndex()
    {
        return view('operational.permintaan-visual.training.index');
    }
}

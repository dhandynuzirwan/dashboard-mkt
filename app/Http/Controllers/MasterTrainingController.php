<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTraining;

class MasterTrainingController extends Controller
{
    public function index()
{
    $sort = request('sort', 'created_at');
    $order = request('order', 'desc');

    $trainings = MasterTraining::orderBy($sort, $order)->paginate(15);

    return view('master-training.index', compact('trainings'));
}

public function store(Request $request)
{
    $request->validate([
        'nama_training' => 'required|unique:master_trainings'
    ]);

    MasterTraining::create([
        'nama_training' => $request->nama_training
    ]);

    return back()->with('success', 'Training berhasil ditambahkan');
}
}

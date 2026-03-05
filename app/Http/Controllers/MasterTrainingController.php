<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTraining;

class MasterTrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterTraining::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $query->where('nama_training', 'like', '%' . $request->search . '%');
        }

        // Urutkan A-Z
        $trainings = $query->orderBy('nama_training', 'asc')
                        ->paginate(15)
                        ->withQueryString();

        // Hitung total judul untuk statistik
        $totalTitles = MasterTraining::count();

        return view('master-training', compact('trainings', 'totalTitles'));
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

    public function bulkStore(Request $request)
    {
        $request->validate([
            'trainings' => 'required|array',
            'trainings.*.nama_training' => 'required|distinct'
        ]);

        $count = 0;
        foreach ($request->trainings as $row) {
            if (!empty($row['nama_training'])) {
                // updateOrCreate agar tidak error jika data sudah ada
                MasterTraining::updateOrCreate(
                    ['nama_training' => $row['nama_training']]
                );
                $count++;
            }
        }

        return back()->with('success', "$count Judul Pelatihan berhasil disimpan.");
    }

    // Tambahkan method delete jika diperlukan
    public function destroy($id)
    {
        MasterTraining::findOrFail($id)->delete();
        return back()->with('success', 'Judul pelatihan dihapus.');
    }
}

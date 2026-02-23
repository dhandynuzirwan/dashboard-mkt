<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspekController extends Controller
{
    // Menampilkan Pipeline (Hasil Data)
    public function index() {
        $prospeks = Prospek::with('marketing')->latest()->get();
        return view('pipeline', compact('prospeks'));
    }

    // Menampilkan Form Input Massal
    public function create() {
        // Ambil user yang rolenya marketing
        $marketings = User::where('role', 'marketing')->get();
        return view('form-prospek', compact('marketings'));
    }

    // Proses Simpan Massal
    public function store(Request $request) {
        $request->validate([
            'marketing_id' => 'required',
            'tanggal_prospek' => 'required|date',
            'rows' => 'required|array',
            'rows.*.perusahaan' => 'required'
        ]);

        try {
            DB::beginTransaction();
            
            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) continue;

                Prospek::create([
                    'marketing_id' => $request->marketing_id,
                    'tanggal_prospek' => $request->tanggal_prospek,
                    'perusahaan' => $row['perusahaan'],
                    'telp' => $row['telp'],
                    'email' => $row['email'],
                    'jabatan' => $row['jabatan'],
                    'nama_pic' => $row['nama_pic'],
                    'wa_pic' => $row['wa_pic'],
                    'wa_baru' => $row['wa_baru'],
                    'lokasi' => $row['lokasi'],
                    'sumber' => $row['sumber'],
                    'update_terakhir' => $row['update_terakhir'],
                    'status' => $row['status'],
                    'deskripsi' => $row['deskripsi'],
                    'catatan' => $row['catatan'],
                ]);
            }

            DB::commit();
            return redirect()->route('prospek.index')->with('success', 'Data Prospek berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

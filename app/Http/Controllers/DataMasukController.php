<?php

namespace App\Http\Controllers;

use App\Models\DataMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DataMasukController extends Controller
{
    // Menampilkan daftar database data
    public function index()
    {
        $allData = DataMasuk::with('marketing')->latest()->get();
        return view('data-masuk', compact('allData'));
    }

    // Menampilkan form input data baru
    public function create()
    {
        $marketings = User::where('role', 'marketing')->get();
        return view('form-data-masuk', compact('marketings'));
    }

    // Menyimpan data
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'marketing_id' => 'required',
            'rows' => 'required|array',
        ]);

        try {
            // 2. Proses Simpan Massal
            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) continue;

                \App\Models\DataMasuk::create([
                    'marketing_id'  => $request->marketing_id,
                    'perusahaan'    => $row['perusahaan'],
                    'telp'          => $row['telp'],
                    'unit_bisnis'   => $row['unit_bisnis'],
                    'email'         => $row['email'],
                    'status_email'  => $row['status_email'],
                    'wa_pic'        => $row['wa_pic'],
                    'wa_baru'       => $row['wa_baru'],
                    'lokasi'        => $row['alamat_perusahaan'] ?? $row['lokasi'], // Sesuaikan dengan key di blade
                    'sumber'        => $row['source'] ?? $row['sumber'], // Sesuaikan dengan key di blade
                ]);
            }

            // 3. KEMBALI KE HALAMAN DATA MASUK
            // Pastikan nama route ini sesuai dengan yang ada di web.php (tadi kita pakai 'data-masuk')
            return redirect()->route('data-masuk')->with('success', 'Data Masuk Berhasil Disimpan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\DataMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DataMasukController extends Controller
{
    // Menampilkan daftar database data
    public function index(Request $request)
    {

    // 1. Tangkap parameter filter & sort
    $search = $request->input('search');
    $marketing_id = $request->input('marketing_id');
    $sumber = $request->input('sumber');
    $sort_field = $request->input('sort', 'created_at'); // default sort by date
    $sort_direction = $request->input('direction', 'desc');



    // 2. Query Data dengan Filter
    $allData = DataMasuk::with('marketing')
        ->when($search, function ($query, $search) {
            return $query->where('perusahaan', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        ->when($marketing_id, function ($query, $marketing_id) {
            return $query->where('marketing_id', $marketing_id);
        })
        ->when($sumber, function ($query, $sumber) {
            return $query->where('sumber', $sumber);
        })
        ->orderBy($sort_field, $sort_direction)
        ->paginate(10)
        ->withQueryString(); // Menjaga parameter filter saat pindah halaman

    // 3. Data Pendukung Filter & Statistik
    $marketings = User::where('role', 'marketing')->get();

    // Total semua data
    $totalData = DataMasuk::count();

    // Data ADS (case insensitive)
    $dataAds = DataMasuk::whereRaw("LOWER(sumber) = ?", ['ads'])->count();

    // Data Manual = selain ADS
    $dataManual = DataMasuk::whereRaw("LOWER(sumber) != ?", ['ads'])->count();

    // Hitung total hari ini
    $totalToday = DataMasuk::whereDate('created_at', now())->count();

    // Hitung email yang valid (berdasarkan status_email yang Anda miliki)
    $dataValid = DataMasuk::where('status_email', 'Valid')->count();
    $validPercentage = $totalData > 0 ? round(($dataValid / $totalData) * 100, 1) : 0;

    // Hitung data yang sudah dikonversi ke tabel Prospeks
    // (Asumsi: kita cek apakah nama perusahaan di DataMasuk sudah ada di tabel Prospeks)
    $dataConverted = \App\Models\Prospek::count(); // Atau logika filter spesifik lainnya

    return view('data-masuk', compact(
        'allData',
        'totalData',
        'dataAds',
        'dataManual',
        'marketings',
        'totalToday',      // Tambahkan ini
        'dataValid',       // Tambahkan ini
        'validPercentage', // Tambahkan ini
        'dataConverted',    // Tambahkan ini
    ));
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
                if (empty($row['perusahaan'])) {
                    continue;
                }

                \App\Models\DataMasuk::create([
                    'marketing_id' => $request->marketing_id,
                    'perusahaan' => $row['perusahaan'],
                    'telp' => $row['telp'],
                    'unit_bisnis' => $row['unit_bisnis'],
                    'email' => $row['email'],
                    'status_email' => $row['status_email'],
                    'wa_pic' => $row['wa_pic'],
                    'wa_baru' => $row['wa_baru'],
                    'lokasi' => $row['alamat_perusahaan'] ?? $row['lokasi'], // Sesuaikan dengan key di blade
                    'sumber' => $row['source'] ?? $row['sumber'], // Sesuaikan dengan key di blade
                ]);
            }

            // 3. KEMBALI KE HALAMAN DATA MASUK
            // Pastikan nama route ini sesuai dengan yang ada di web.php (tadi kita pakai 'data-masuk')
            return redirect()->route('data-masuk')->with('success', 'Data Masuk Berhasil Disimpan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data = DataMasuk::findOrFail($id);
        $marketings = User::where('role', 'marketing')->get();

        return view('form-data-masuk-edit', compact('data', 'marketings'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'marketing_id' => 'required',
            'perusahaan' => 'required',
        ]);

        $data = DataMasuk::findOrFail($id);

        $data->update([
            'marketing_id' => $request->marketing_id,
            'perusahaan' => $request->perusahaan,
            'telp' => $request->telp,
            'unit_bisnis' => $request->unit_bisnis,
            'email' => $request->email,
            'status_email' => $request->status_email,
            'wa_pic' => $request->wa_pic,
            'wa_baru' => $request->wa_baru,
            'lokasi' => $request->lokasi,
            'sumber' => $request->sumber,
        ]);

        return redirect()->route('data-masuk.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $data = DataMasuk::findOrFail($id);
        $data->delete();

        return redirect()->route('data-masuk.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
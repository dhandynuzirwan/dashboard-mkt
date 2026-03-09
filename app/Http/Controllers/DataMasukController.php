<?php

namespace App\Http\Controllers;

use App\Models\AdsLead;
use App\Models\DataMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DataMasukController extends Controller
{
    // Menampilkan daftar database data
    public function index(Request $request)
    {
        // 1. Tangkap parameter filter
        $search = $request->input('search');
        $marketing_id = $request->input('marketing_id');
        $sumber = $request->input('sumber');
        $status_deliver = $request->input('status_deliver'); // Parameter baru

        // 2. Query Data dengan Filter
        $query = DataMasuk::with('marketing');

        // Filter Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('perusahaan', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Marketing Assignment
        if ($marketing_id) {
            $query->where('marketing_id', $marketing_id);
        }

        // Filter Sumber
        if ($sumber) {
            $query->where('sumber', $sumber);
        }

        // LOGIKA FILTER DELIVER (PENTING)
        if ($status_deliver) {
            if ($status_deliver == 'undelivered') {
                $query->whereNull('marketing_id'); // Data mentah dari RnD
            } elseif ($status_deliver == 'delivered') {
                $query->whereNotNull('marketing_id'); // Sudah ada marketingnya
            }
        }
        // Ambil data Ads
        $adsData = AdsLead::orderBy('created_at', 'desc')->paginate(10, ['*'], 'ads_page');

        $allData = $query->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        // Data Pendukung (Tetap sama seperti sebelumnya)
        $marketings = User::where('role', 'marketing')->get();
        $totalData = DataMasuk::count();
        $totalToday = DataMasuk::whereDate('created_at', now())->count();
        $dataValid = DataMasuk::where('status_email', 'Valid')->count();
        $validPercentage = $totalData > 0 ? round(($dataValid / $totalData) * 100, 1) : 0;
        $dataConverted = \App\Models\Prospek::count();

        return view('data-masuk', compact(
            'allData', 'totalData','marketings', 'adsData',
            'totalToday', 'dataValid', 'validPercentage', 'dataConverted'
        ));
    }

    // Menampilkan form input data baru
    public function create()
    {
        $marketings = User::where('role', 'marketing')->get();

        return view('form-data-masuk', compact('marketings'));
    }

    // Menyimpan data

    // --- PROSES SIMPAN (DENGAN NULLABLE VALIDATION) ---
    public function store(Request $request)
    {
        $user = auth()->user();
        $isRnD = in_array($user->role, ['rnd', 'digitalmarketing']);

        $request->validate([
            'marketing_id' => $isRnD ? 'nullable' : 'required',
            'rows' => 'required|array',
            'rows.*.perusahaan' => 'required',
        ]);

        $successCount = 0;
        $duplicates = [];

        try {
            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) continue;

                $nama = trim($row['perusahaan']);
                $lokasi = isset($row['lokasi']) ? trim($row['lokasi']) : null;

                // Cek kombinasi Perusahaan + Lokasi
                $isDuplicate = DataMasuk::where('perusahaan', $nama)
                    ->where('lokasi', $lokasi)
                    ->exists();

                if ($isDuplicate) {
                    // Kumpulkan nama perusahaan yang duplikat
                    $duplicates[] = $nama . ($lokasi ? " ($lokasi)" : "");
                    continue;
                }

                // Simpan data yang valid
                DataMasuk::create([
                    'marketing_id' => $isRnD ? null : $request->marketing_id,
                    'perusahaan'   => $nama,
                    'lokasi'       => $lokasi,
                    'telp'         => $row['telp'] ?? null,
                    'unit_bisnis'  => $row['unit_bisnis'] ?? null,
                    'email'        => $row['email'] ?? null,
                    'status_email' => $row['status_email'] ?? null,
                    'wa_pic'       => $row['wa_pic'] ?? null,
                    'sumber'       => $row['sumber'] ?? null,
                    'is_ads'       => $row['is_ads'] ?? false,
                ]);

                $successCount++;
            }

            // Siapkan pesan sukses
            $message = "Berhasil menginput {$successCount} data baru.";
            
            // Jika ada duplikat, buat pesan error terpisah
            if (!empty($duplicates)) {
                $errorMsg = "Gagal input " . count($duplicates) . " data karena duplikat: " . implode(', ', $duplicates);
                return redirect()->route('data-masuk.index')
                    ->with('success', $message)
                    ->with('error', $errorMsg);
            }

            return redirect()->route('data-masuk.index')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('data-masuk.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi Baru: Deliver ke Prospek (Khusus Admin)
    public function deliver(Request $request, $id)
    {
        $request->validate(['marketing_id' => 'required']);
        $data = DataMasuk::findOrFail($id);

        // CEK: Jika data sudah punya marketing_id, batalkan proses
        if ($data->marketing_id) {
            return back()->with('error', 'Gagal! Data ini sudah di-assign ke Marketing lain.');
        }

        // Salin ke Tabel Prospek
        \App\Models\Prospek::create([
            'marketing_id'    => $request->marketing_id,
            'tanggal_prospek' => now(),
            'perusahaan'      => $data->perusahaan,
            'lokasi'          => $data->lokasi,
            'email'           => $data->email,
            'wa_pic'          => $data->wa_pic,
            'sumber'          => $data->sumber,
        ]);

        // Tandai data ini sudah terkirim (Update marketing_id agar tombol hilang di UI)
        $data->update(['marketing_id' => $request->marketing_id]); 

        return back()->with('success', "Data {$data->perusahaan} berhasil di-deliver!");
    }
    
    // Fungsi Deliver Khusus Ads
    public function deliverAds(Request $request, $id)
    {
        $request->validate(['marketing_id' => 'required']);
        $ad = AdsLead::findOrFail($id);

        \App\Models\Prospek::create([
            'marketing_id'    => $request->marketing_id,
            'tanggal_prospek' => now(),
            'perusahaan'      => $ad->nama_perusahaan ?? 'Pribadi/No Name',
            'lokasi'          => $ad->lokasi,
            'email'           => $ad->email,
            'wa_pic'          => $ad->wa_hrd,
            'sumber'          => 'Ads - ' . $ad->channel_akuisisi,
        ]);

        // Update status atau hapus data ads setelah deliver (opsional)
        // Untuk saat ini kita simpan siapa yang menghandle
        $ad->update(['marketing_id' => $request->marketing_id]); 

        return back()->with('success', "Data Ads {$ad->nama_perusahaan} berhasil di-deliver!");
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
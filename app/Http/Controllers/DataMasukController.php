<?php

namespace App\Http\Controllers;

use App\Models\AdsLead;
use App\Models\DataMasuk;
use App\Models\Prospek; // Pastikan model Prospek di-import
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataMasukController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $search = $request->input('search');
        $marketing_id = $request->input('marketing_id');
        $sumber = $request->input('sumber');
        $status_deliver = $request->input('status_deliver');
        
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = DataMasuk::with('marketing'); 
        $queryAds = AdsLead::query();          

        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
            $queryAds->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
            $queryAds->whereDate('created_at', '<=', $end_date);
        }

        if ($marketing_id) {
            $query->where('marketing_id', $marketing_id);
        }

        if ($sumber) {
            $query->where('sumber', $sumber);
        }

        if ($status_deliver) {
            if ($status_deliver == 'undelivered') {
                $query->whereNull('marketing_id'); 
            } elseif ($status_deliver == 'delivered') {
                $query->whereNotNull('marketing_id'); 
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('wa_pic', 'LIKE', "%{$search}%"); 
            });

            $queryAds->where(function($q) use ($search) {
                $q->where('nama_perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_hrd', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $allData = $query->orderBy('created_at', 'desc')
                         ->paginate(10, ['*'], 'page_umum')
                         ->withQueryString();

        $adsData = $queryAds->orderBy('created_at', 'desc')
                            ->paginate(10, ['*'], 'page_ads')
                            ->withQueryString();

        $marketings = User::where('role', 'marketing')->get();
        $totalData = DataMasuk::count();
        $totalToday = DataMasuk::whereDate('created_at', now())->count();
        $dataValid = DataMasuk::whereNotNull('status_email')->count();
        $validPercentage = $totalData > 0 ? round(($dataValid / $totalData) * 100, 1) : 0;
        $dataConverted = DataMasuk::whereNotNull('marketing_id')->count();

        $prospekList = Prospek::pluck('perusahaan')->toArray();
        
        $unsyncedCompanies = DataMasuk::whereNull('marketing_id')
                                ->whereIn('perusahaan', $prospekList)
                                ->pluck('perusahaan')
                                ->unique() 
                                ->toArray();

        return view('data-masuk', compact(
            'allData', 'totalData','marketings', 'adsData',
            'totalToday', 'dataValid', 'validPercentage', 'dataConverted',
            'prospekList',  'unsyncedCompanies' 
        ));
    }

    public function create()
    {
        $marketings = User::where('role', 'marketing')->get();
        return view('form-data-masuk', compact('marketings'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $user = auth()->user();
        $isRnD = in_array($user->role, ['rnd', 'digitalmarketing']);

        $request->validate([
            'marketing_id' => $isRnD ? 'nullable' : 'required',
            'tanggal_input' => 'nullable|date', // Validasi inputan tanggal RnD
            'rows' => 'required|array',
            'rows.*.perusahaan' => 'required',
        ]);

        $successCount = 0;
        $duplicates = [];

        // Atur Waktu Input: Jika ada inputan tanggal (dari RnD), gunakan itu. Jika tidak, gunakan waktu sekarang.
        // Kita tambahkan jam saat ini agar tidak ter-set jam 00:00:00
        $waktuInput = $request->tanggal_input 
            ? Carbon::parse($request->tanggal_input)->format('Y-m-d ' . now()->format('H:i:s')) 
            : now();

        try {
            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) continue;

                $nama = trim($row['perusahaan']);
                $lokasi = isset($row['lokasi']) ? trim($row['lokasi']) : null;

                $isDuplicate = DataMasuk::where('perusahaan', $nama)
                    ->where('lokasi', $lokasi)
                    ->exists();

                // ... kode sebelumnya di dalam foreach ...
                if ($isDuplicate) {
                    $duplicates[] = $nama . ($lokasi ? " ($lokasi)" : "");
                    continue;
                }

                // ================= GANTI BAGIAN INI =================
                $dataBaru = new DataMasuk();
                
                // 1. Isi data normal (yang diizinkan fillable)
                $dataBaru->fill([
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

                // 2. PAKSA ubah tanggalnya (Bypass perlindungan Laravel)
                $dataBaru->created_at = $waktuInput;
                $dataBaru->updated_at = $waktuInput;
                
                // 3. Simpan ke database
                $dataBaru->save();
                // ====================================================

                $successCount++;
            }

            $message = "Berhasil menginput {$successCount} data baru.";
            
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

    // ================= DELIVER SATUAN (DATA UMUM) =================
    public function deliver(Request $request, $id)
    {
        $request->validate([
            'marketing_id'   => 'required',
            'tanggal_assign' => 'required|date', // Validasi tanggal
        ]);

        $data = DataMasuk::findOrFail($id);

        if ($data->marketing_id) {
            return back()->with('error', 'Gagal! Data ini sudah di-assign ke Marketing lain.');
        }

        // Salin ke Tabel Prospek dengan Tanggal Custom
        Prospek::create([
            'marketing_id'    => $request->marketing_id,
            'tanggal_prospek' => $request->tanggal_assign,
            'perusahaan'      => $data->perusahaan,
            'lokasi'          => $data->lokasi,
            'email'           => $data->email,
            'wa_pic'          => $data->wa_pic,
            'sumber'          => $data->sumber,
            'created_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
            'updated_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
        ]);

        // Simpan jejak tanggal assign di tabel data masuk
        $data->update([
            'marketing_id'   => $request->marketing_id,
            'tanggal_assign' => $request->tanggal_assign 
        ]); 

        $tglFormat = Carbon::parse($request->tanggal_assign)->format('d M Y');
        return back()->with('success', "Data {$data->perusahaan} berhasil di-deliver untuk tanggal {$tglFormat}!");
    }
    
    // ================= DELIVER SATUAN (DATA ADS) =================
    public function deliverAds(Request $request, $id)
    {
        $request->validate([
            'marketing_id'   => 'required',
            'tanggal_assign' => 'required|date', // Validasi tanggal
        ]);

        $ad = AdsLead::findOrFail($id);

        Prospek::create([
            'marketing_id'    => $request->marketing_id,
            'tanggal_prospek' => $request->tanggal_assign,
            'perusahaan'      => $ad->nama_perusahaan ?? 'Pribadi/No Name',
            'lokasi'          => $ad->lokasi,
            'email'           => $ad->email,
            'wa_pic'          => $ad->wa_hrd,
            'sumber'          => 'Ads - ' . $ad->channel_akuisisi,
            'created_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
            'updated_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
        ]);

        $ad->update(['marketing_id' => $request->marketing_id]); 

        $tglFormat = Carbon::parse($request->tanggal_assign)->format('d M Y');
        return back()->with('success', "Data Ads {$ad->nama_perusahaan} berhasil di-deliver untuk tanggal {$tglFormat}!");
    }
    
    // ================= DELIVER MASSAL =================
    public function deliverMassal(Request $request)
    {
        $request->validate([
            'marketing_id'   => 'required',
            'tanggal_assign' => 'required|date', 
            'ids'            => 'required|array', 
            'ids.*'          => 'exists:data_masuks,id' 
        ]);
    
        try {
            $dataToDeliver = DataMasuk::whereIn('id', $request->ids)
                                      ->whereNull('marketing_id')
                                      ->get();
            
            $count = 0;
            foreach ($dataToDeliver as $data) {
                // Salin eksplisit ke Prospek agar tanggalnya ter-mapping dengan benar
                Prospek::create([
                    'marketing_id'    => $request->marketing_id,
                    'tanggal_prospek' => $request->tanggal_assign,
                    'perusahaan'      => $data->perusahaan,
                    'lokasi'          => $data->lokasi,
                    'email'           => $data->email,
                    'wa_pic'          => $data->wa_pic,
                    'sumber'          => $data->sumber,
                    'created_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
                    'updated_at'      => $request->tanggal_assign . ' ' . now()->format('H:i:s'),
                ]);

                // Update data masuknya
                $data->update([
                    'marketing_id'   => $request->marketing_id,
                    'tanggal_assign' => $request->tanggal_assign
                ]);
                
                $count++;
            }
    
            if ($count > 0) {
                $tglFormat = Carbon::parse($request->tanggal_assign)->format('d M Y');
                return redirect()->back()->with('success', "Berhasil me-deliver {$count} data ke Pipeline Prospek untuk tanggal {$tglFormat}!");
            } else {
                return redirect()->back()->with('error', 'Gagal: Data yang dipilih mungkin sudah di-assign sebelumnya.');
            }
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
    
    // ================= DELETE BY DATE =================
    public function destroyByDate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';

        try {
            $deletedCount = DataMasuk::whereBetween('created_at', [$startDate, $endDate])->delete();

            if ($deletedCount > 0) {
                return redirect()->route('data-masuk.index')
                    ->with('success', "Berhasil menghapus {$deletedCount} data dari tanggal {$request->start_date} s/d {$request->end_date}.");
            } else {
                return redirect()->route('data-masuk.index')
                    ->with('error', 'Tidak ada data yang ditemukan pada rentang tanggal tersebut.');
            }
        } catch (\Exception $e) {
            return redirect()->route('data-masuk.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
    
    // ================= AUTO-SYNC DATA NYANGKUT =================
    public function autoSyncProspek()
    {
        try {
            $prospekList = Prospek::whereNotNull('marketing_id')
                            ->get()
                            ->unique('perusahaan');
            
            $count = 0;

            foreach ($prospekList as $prospek) {
                $updated = DataMasuk::whereNull('marketing_id')
                            ->where('perusahaan', $prospek->perusahaan)
                            ->update(['marketing_id' => $prospek->marketing_id]);
                
                $count += $updated; 
            }

            if ($count > 0) {
                return redirect()->back()->with('success', "Auto-Sync Sukses! Sebanyak {$count} data berhasil disinkronkan dengan database Prospek.");
            } else {
                return redirect()->back()->with('info', 'Tidak ada data yang perlu disinkronkan.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat Auto-Sync: ' . $e->getMessage());
        }
    }
}
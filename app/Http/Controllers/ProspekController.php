<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ProspekCtaImport;
use App\Exports\ProspekCtaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class ProspekController extends Controller
{
    // Menampilkan Pipeline (Hasil Data)
    public function index(Request $request)
    {
        // 1. SIMPAN URL SAAT INI KE SESSION
        // Ini akan mengingat filter apa saja yang sedang aktif
        session(['url_pipeline_terakhir' => request()->fullUrl()]);
        
        $user = auth()->user();
        $marketings = User::where('role', 'marketing')->get();

        // 1. --- INISIALISASI TANGGAL (Default: Awal bulan ini - Akhir bulan ini) ---
        $start = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $start = $request->filled('start_date') 
                    ? $request->start_date 
                    : now()->startOfMonth()->format('Y-m-d');
        
        $end   = $request->filled('end_date') 
                    ? $request->end_date 
                    : now()->endOfMonth()->format('Y-m-d');
        // 1. Tentukan Pakem Status Resmi Perusahaan
        $statusResmi = [
            'BELUM ADA KEBUTUHAN', 'DAPAT EMAIL', 'DAPAT NO TELP', 'DAPAT NO WA HRD',
            'HOLD', 'DATA TIDAK VALID & TIDAK TERHUBUNG', 'KIRIM COMPRO', 'MANJA',
            'MANJA ULANG', 'MASUK PENAWARAN', 'PENAWARAN HARDFILE', 'REQUES PERPANJANGAN SERTIFIKAT',
            'REQUEST PERMINTAAN PELATIHAN', 'TIDAK MENERIMA PENAWARAN', 'TIDAK RESPON', 'SUDAH ADA VENDOR KERJASAMA'
        ];

        // 2. Ambil status unik yang benar-benar ADA DATANYA di bulan ini
        $statusDbBulanIni = Prospek::whereBetween('tanggal_prospek', [$start, $end])
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->distinct()
            ->pluck('status')
            ->toArray();

        // 3. Gabungkan Pakem Resmi + Status di DB, lalu hilangkan duplikat dan urutkan abjad
        // array_filter untuk membuang string kosong
        $all_status_akhir = collect(array_merge($statusResmi, $statusDbBulanIni))
                            ->filter()
                            ->unique()
                            ->sort()
                            ->values();

        $query = Prospek::with(['marketing', 'cta']);
        
        // Tambahkan logika sorting ini
        $sortBy = $request->get('sort_by', 'created_at'); // Default urutkan berdasar tgl dibuat
        $sortOrder = $request->get('sort_order', 'desc'); // Default terbaru di atas
    
        // Pastikan hanya kolom tertentu yang boleh di-sort untuk keamanan
        $allowedSortColumns = ['perusahaan', 'tanggal_prospek', 'id'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        if ($user->role === 'marketing') {
            $query->where('marketing_id', $user->id);
        } else {
            if ($request->filled('marketing_id')) {
                $query->where('marketing_id', $request->marketing_id);
            }
        }
        
        if ($request->filled('search_perusahaan')) {
            $search = $request->search_perusahaan;
            $query->where(function($q) use ($search) {
                $q->where('perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('telp', 'LIKE', "%{$search}%")
                  ->orWhere('wa_pic', 'LIKE', "%{$search}%")
                  ->orWhere('wa_baru', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pic', 'LIKE', "%{$search}%");
            });
        } else {
            // ================= APPLY FILTER KETIKA TIDAK SEDANG SEARCHING =================
            $query->whereBetween('tanggal_prospek', [$start, $end]);

            // TAMBAHAN: FILTER SUMBER ADS / ORGANIK
            if ($request->filled('sumber_tipe')) {
                if ($request->sumber_tipe == 'ads') {
                    // Mencari yang kolom sumbernya mengandung kata 'Ads'
                    $query->where('sumber', 'LIKE', '%Ads%');
                } elseif ($request->sumber_tipe == 'organik') {
                    // Mencari yang kolom sumbernya TIDAK mengandung 'Ads' atau Kosong
                    $query->where(function($q) {
                        $q->where('sumber', 'NOT LIKE', '%Ads%')
                          ->orWhereNull('sumber');
                    });
                }
            }

            // A. FILTER TAHAP (Ini yang tadi hilang, Lang!)
            if ($request->filled('cta_status')) {
                if ($request->cta_status == 'pending') {
                    $query->whereDoesntHave('cta'); // Belum input penawaran
                } elseif ($request->cta_status == 'done') {
                    $query->whereHas('cta'); // Sudah ada penawaran
                }
            }

            // Filter Status Akhir Data (Catatan Prospek)
            if ($request->filled('status_akhir')) {
                if ($request->status_akhir === 'belum_ada_status') {
                    // 🔥 Jika mencari yang belum ada status (Null atau Kosong)
                    $query->where(function($q) {
                        $q->whereNull('status')->orWhere('status', '');
                    });
                } else {
                    // Pencarian normal sesuai nama status
                    $query->where('status', $request->status_akhir);
                }
            }

            // FIX: Filter Status Penawaran (Ini filter untuk kolom 'status_penawaran' di tabel CTA)
            // Di Blade kamu menggunakan name="status", jadi kita tangkap $request->status
            if ($request->status) {
                $query->whereHas('cta', function ($q) use ($request) {
                    $q->where('status_penawaran', $request->status);
                });
            }

            if ($request->status_penawaran) {
                $query->whereHas('cta', function ($q) use ($request) {
                    $q->where('status_penawaran', $request->status_penawaran);
                });
            }

            // 🔥 BARU: FILTER KELENGKAPAN HARGA PENAWARAN 🔥
            if ($request->filled('status_harga')) {
                if ($request->status_harga == 'sudah_diisi') {
                    // Mencari prospek yang di form CTA-nya kolom harga_penawaran sudah terisi (Tidak Null & Bukan 0)
                    $query->whereHas('cta', function ($q) {
                        $q->whereNotNull('harga_penawaran')->where('harga_penawaran', '!=', 0)->where('harga_penawaran', '!=', '');
                    });
                } elseif ($request->status_harga == 'belum_diisi') {
                    // Mencari prospek yang SUDAH PUNYA CTA, tapi harga penawarannya belum diisi (Null atau 0)
                    $query->whereHas('cta', function ($q) {
                        $q->whereNull('harga_penawaran')->orWhere('harga_penawaran', 0)->orWhere('harga_penawaran', '');
                    });
                }
            }
        }
        
        if (!$request->has('sort_by')) {
            $query->orderBy('id', 'desc');
        }

        // 2. HITUNG STATS
        // a. Ambil daftar ID prospek yang sudah difilter
        $prospekIds = (clone $query)->pluck('id');

        // b. Hitung statistik langsung dari database (Jauh lebih cepat, mencegah memory leak / loading lama)
        $jumlahProspekUnik = $prospekIds->count();
        $jumlahProspekPunyaCta = \App\Models\Cta::whereIn('prospek_id', $prospekIds)->distinct('prospek_id')->count('prospek_id');
        $totalCta = \App\Models\Cta::whereIn('prospek_id', $prospekIds)->count();
        
        // Kalkulasi: (Prospek yang belum ada CTA) + (Total seluruh form CTA)
        $totalProspekDihitung = ($jumlahProspekUnik - $jumlahProspekPunyaCta) + $totalCta;

        // Menghitung Nilai Pipeline (Harga Penawaran x Jumlah Peserta) dari SEMUA judul
        $totalNilai = \App\Models\Cta::whereIn('prospek_id', $prospekIds)
            ->selectRaw('SUM(COALESCE(harga_penawaran, 0) * COALESCE(jumlah_peserta, 1)) as total')
            ->value('total') ?? 0;

        // Total Project Deal (Berdasarkan jumlah CTA/Penawaran yang statusnya 'deal')
        $totalDeal = \App\Models\Cta::whereIn('prospek_id', $prospekIds)
            ->where('status_penawaran', 'deal')->count();

        // c. Output Statistik
        $stats = [
            'total_prospek' => $totalProspekDihitung,
            'total_cta'     => $totalCta, 
            'total_nilai'   => $totalNilai,
            'total_deal'    => $totalDeal,
        ];

        // 3. PAGINATION
        $prospeks = (clone $query)->paginate(10, ['*'], 'page_pipeline')->withQueryString();
        // Untuk CTA Prospeks, kita juga samakan agar sortingnya konsisten
        $ctaProspeks = (clone $query)->whereHas('cta')
            ->paginate(10, ['*'], 'page_cta')
            ->withQueryString();
        
        // ================= 🔥 DETEKSI DATA DUPLIKAT 🔥 =================
        // Hanya dijalankan jika user adalah admin / superadmin
        $duplicateGroups = collect();
        if (in_array($user->role, ['admin', 'superadmin'])) {
            // 1. Cari kombinasi Perusahaan & Lokasi yang jumlahnya > 1
            $rawDuplicates = Prospek::select('perusahaan', 'lokasi', DB::raw('COUNT(*) as count'))
                ->groupBy('perusahaan', 'lokasi')
                ->havingRaw('COUNT(*) > 1')
                ->get();

            // 2. Jika ada duplikat, ambil detail datanya
            if ($rawDuplicates->count() > 0) {
                $perusahaanList = $rawDuplicates->pluck('perusahaan')->filter()->unique()->toArray();
                
                if (!empty($perusahaanList)) {
                    // Gunakan whereIn yang sangat efisien dibanding ribuan OR WHERE
                    $duplicates = Prospek::with('marketing')
                        ->whereIn('perusahaan', $perusahaanList)
                        ->orderBy('perusahaan')
                        ->orderBy('created_at', 'asc')
                        ->get();
                        
                    $duplicateGroups = $duplicates->filter(function($item) use ($rawDuplicates) {
                        return $rawDuplicates->contains(function($dup) use ($item) {
                            return $dup->perusahaan === $item->perusahaan && $dup->lokasi === $item->lokasi;
                        });
                    })->groupBy(function($item) {
                        return $item->perusahaan . ' - (' . ($item->lokasi ?? 'Tanpa Lokasi') . ')';
                    });
                }
            }
        }
        // ================= 🔥 END DETEKSI DUPLIKAT 🔥 =================
        
        // ================= 🔥 DETEKSI DATA DUPLIKAT CTA 🔥 =================
        $duplicateCtaGroups = collect();
        if (in_array($user->role, ['admin', 'superadmin'])) {
            // 1. Cari kombinasi Perusahaan, Lokasi, dan Judul CTA
            $rawCtaDuplicates = \App\Models\Cta::join('prospeks', 'ctas.prospek_id', '=', 'prospeks.id')
                ->select('prospeks.perusahaan', 'prospeks.lokasi', 'ctas.judul_permintaan')
                ->groupBy('prospeks.perusahaan', 'prospeks.lokasi', 'ctas.judul_permintaan')
                ->havingRaw('COUNT(ctas.id) > 1')
                ->get();

            if ($rawCtaDuplicates->count() > 0) {
                $judulList = $rawCtaDuplicates->pluck('judul_permintaan')->filter()->unique()->toArray();
                $perusahaanList = $rawCtaDuplicates->pluck('perusahaan')->filter()->unique()->toArray();
                
                if (!empty($judulList) && !empty($perusahaanList)) {
                    $ctaDuplicates = \App\Models\Cta::with('prospek.marketing')
                        ->whereIn('judul_permintaan', $judulList)
                        ->whereHas('prospek', function($q) use ($perusahaanList) {
                            $q->whereIn('perusahaan', $perusahaanList);
                        })
                        ->orderBy('created_at', 'asc')
                        ->get();

                    $duplicateCtaGroups = $ctaDuplicates->filter(function($item) use ($rawCtaDuplicates) {
                        if (!$item->prospek) return false;
                        return $rawCtaDuplicates->contains(function($dup) use ($item) {
                            return $dup->judul_permintaan === $item->judul_permintaan &&
                                   $dup->perusahaan === $item->prospek->perusahaan &&
                                   $dup->lokasi === $item->prospek->lokasi;
                        });
                    })->groupBy(function($item) {
                        return $item->prospek->perusahaan . ' - (' . ($item->prospek->lokasi ?? 'Tanpa Lokasi') . ') | Judul CTA: ' . ($item->judul_permintaan ?? 'Tanpa Judul');
                    });
                }
            }
        }
        // ================= 🔥 END DETEKSI DUPLIKAT CTA 🔥 =================

        // Kirim $start dan $end ke view
        return view('pipeline', compact('prospeks', 'ctaProspeks', 'marketings', 'stats', 'all_status_akhir', 'start', 'end', 'duplicateGroups', 'duplicateCtaGroups'));
    }

    // Menampilkan Form Input Massal
    public function create()
    {
        // Ambil user yang rolenya marketing
        $marketings = User::where('role', 'marketing')->get();

        return view('form-prospek', compact('marketings'));
    }

    // Proses Simpan Massal
    public function store(Request $request)
    {
        $request->validate([
            'marketing_id' => 'required',
            'tanggal_prospek' => 'required|date',
            'rows' => 'required|array',
            'rows.*.perusahaan' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) {
                    continue;
                }

                Prospek::create([
                    'marketing_id' => $request->marketing_id,
                    'tanggal_prospek' => $request->tanggal_prospek,
                    'perusahaan' => $row['perusahaan'],
                    'telp' => $row['telp'] ?? null,
                    'telp_baru' => $row['telp_baru'] ?? null,
                    'email' => $row['email'] ?? null,
                    'jabatan' => $row['jabatan'],
                    'nama_pic' => $row['nama_pic'],
                    'wa_pic' => $row['wa_pic'] ?? null,
                    'wa_baru' => $row['wa_baru'] ?? null,
                    'lokasi' => $row['lokasi'] ?? null,
                    'sumber' => $row['sumber'] ?? null,
                    'update_terakhir' => $row['update_terakhir'] ?? null,
                    'status' => $row['status'] ?? null,
                    'deskripsi' => $row['deskripsi'] ?? null,
                    'catatan' => $row['catatan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('prospek.index')->with('success', 'Data Prospek berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $prospek = \App\Models\Prospek::findOrFail($id);
        $marketings = \App\Models\User::where('role', 'marketing')->get();
        $user = auth()->user();
        
        // --- LOGIKA NEXT & PREVIOUS BERDASARKAN FILTER SESSION PIPELINE ---
        $query = \App\Models\Prospek::query();

        // 1. Aturan Wajib: Marketing hanya boleh lihat data miliknya
        if ($user->role === 'marketing') {
            $query->where('marketing_id', $user->id);
        }

        // 2. Ambil URL terakhir dari session dan bedah isinya
        $lastUrl = session('url_pipeline_terakhir');
        $filters = [];
        
        if ($lastUrl) {
            $queryString = parse_url($lastUrl, PHP_URL_QUERY); 
            if ($queryString) {
                parse_str($queryString, $filters); 
            }
        }

        // 3. Terapkan Filter Tanggal
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('tanggal_prospek', [$filters['start_date'], $filters['end_date']]);
        }

        // 4. Terapkan Filter Marketing 
        if (!empty($filters['marketing_id'])) {
            $query->where('marketing_id', $filters['marketing_id']);
        }

        // 5. Terapkan Filter TAHAP (Sudah di-CTA / Belum)
        if (!empty($filters['cta_status'])) {
            if ($filters['cta_status'] == 'pending') {
                $query->whereDoesntHave('cta'); 
            } elseif ($filters['cta_status'] == 'done') {
                $query->whereHas('cta'); 
            }
        }

        // 6. Terapkan Filter Status Akhir Data (Catatan Prospek)
        if (!empty($filters['status_akhir'])) {
            if ($filters['status_akhir'] === 'belum_ada_status') {
                $query->where(function($q) {
                    $q->whereNull('status')->orWhere('status', '');
                });
            } else {
                $query->where('status', $filters['status_akhir']);
            }
        }

        // 7. Terapkan Filter Status Penawaran (Deal, Hold, dll) - Kolom CTA
        if (!empty($filters['status'])) {
            $query->whereHas('cta', function ($q) use ($filters) {
                $q->where('status_penawaran', $filters['status']);
            });
        }

        // 8. Terapkan Filter Pencarian Nama Perusahaan
        if (!empty($filters['search_perusahaan'])) {
            $query->where('perusahaan', 'LIKE', '%' . $filters['search_perusahaan'] . '%');
        }

        // 🔥 TAMBAHAN: 8b. Terapkan Filter Sumber (Ads / Organik) 🔥
        if (!empty($filters['sumber_tipe'])) {
            if ($filters['sumber_tipe'] === 'ads') {
                $query->where('sumber', 'LIKE', '%Ads%');
            } elseif ($filters['sumber_tipe'] === 'organik') {
                $query->where(function($q) {
                    $q->where('sumber', 'NOT LIKE', '%Ads%')
                      ->orWhereNull('sumber');
                });
            }
        }

        // 9. Cari ID Sebelumnya & Selanjutnya sesuai filter
        $previous = (clone $query)->where('id', '<', $prospek->id)->orderBy('id', 'desc')->first();
        $next = (clone $query)->where('id', '>', $prospek->id)->orderBy('id', 'asc')->first();
        // ------------------------------------------------------------------

        return view('form-prospek-edit', compact('prospek', 'marketings', 'previous', 'next'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'marketing_id' => 'required',
            'perusahaan' => 'required',
        ]);

        $prospek = \App\Models\Prospek::findOrFail($id);

        $prospek->update([
            'marketing_id' => $request->marketing_id,
            'tanggal_prospek' => $request->tanggal_prospek,
            'perusahaan' => $request->perusahaan,
            'telp' => $request->telp,
            'telp_baru' => $request->telp_baru,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'nama_pic' => $request->nama_pic,
            'wa_pic' => $request->wa_pic,
            'wa_baru' => $request->wa_baru,
            'lokasi' => $request->lokasi,
            'sumber' => $request->sumber,
            'update_terakhir' => $request->update_terakhir,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Data prospek berhasil disimpan!');
    }
    
    public function massDelete(Request $request)
    {
        // 1. Keamanan Ekstra: Pastikan hanya admin/superadmin yang bisa akses
        if (!in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Unauthorized Access');
        }

        // 2. Ambil array ID dari checkbox
        $selectedIds = $request->input('selected_prospek');

        // 3. Validasi
        if (empty($selectedIds) || !is_array($selectedIds)) {
            return redirect()->back()->withErrors('Gagal! Anda belum memilih data apapun untuk dihapus.');
        }

        $jumlahData = count($selectedIds);

        // 4. EKSEKUSI HAPUS
        // Hapus file proposal fisik (Jika ada)
        $fileProposals = \App\Models\Cta::whereIn('prospek_id', $selectedIds)
                                        ->whereNotNull('file_proposal')
                                        ->pluck('file_proposal');
                                        
        foreach($fileProposals as $file) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($file)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
            }
        }

        // Hapus CTA yang terhubung
        \App\Models\Cta::whereIn('prospek_id', $selectedIds)->delete();
        
        // Hapus Data Prospek Utama
        \App\Models\Prospek::whereIn('id', $selectedIds)->delete();

        return redirect()->route('prospek.index')->with('success', "Berhasil menghapus {$jumlahData} data prospek pilihan beserta penawarannya secara permanen.");
    }
    
    public function showCheckData()
    {
        return view('prospek-check'); // Kita akan buat view-nya di langkah 3
    }
    
    public function processCheckMassal(Request $request)
    {
        $request->validate([
            'data_excel' => 'required|string',
        ]);

        $inputRaw = preg_split('/\r\n|\r|\n/', $request->data_excel);
        
        $inputData = [];
        $uniqueDates = [];
        $excelOccurrence = []; // Untuk menghitung baris keberapa perusahaan muncul

        // 1. BACA DATA EXCEL (MENGHITUNG DUPLIKAT SEBAGAI ENTITAS BERBEDA)
        foreach ($inputRaw as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = explode("\t", $line); 
            
            if (count($parts) >= 2) {
                $rawTanggal = trim($parts[0]);
                $perusahaan = trim($parts[1]);
                
                try {
                    $safeDate = str_replace('/', '-', $rawTanggal);
                    $formattedDate = \Carbon\Carbon::parse($safeDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDate = $rawTanggal;
                }

                if (!in_array($formattedDate, $uniqueDates)) {
                    $uniqueDates[] = $formattedDate;
                }

                // Logika Index Kemunculan (Misal: pt_maju_1, pt_maju_2)
                $baseKey = $formattedDate . '_' . strtolower(trim($perusahaan));
                $excelOccurrence[$baseKey] = ($excelOccurrence[$baseKey] ?? 0) + 1;
                $finalKey = $baseKey . '_item_' . $excelOccurrence[$baseKey];

                $inputData[] = [
                    'tanggal' => $formattedDate, 
                    'perusahaan' => $perusahaan,
                    'marketing' => '-', // <-- TAMBAHKAN BARIS INI KEMBALI
                    'key' => $finalKey
                ];
            }
        }

        // 2. AMBIL DATA DARI DB (PROSPEK + JUMLAH CTA)
        if (count($uniqueDates) > 0) {
            $dbData = \App\Models\Prospek::with('marketing', 'cta')
                ->where(function($query) use ($uniqueDates) {
                    foreach($uniqueDates as $date) {
                        $query->orWhereDate('tanggal_prospek', $date);
                    }
                })->get();
        } else {
            $dbData = collect();
        }
        
        $dbProspeksStructured = [];
        $dbKeys = [];
        $dbOccurrence = [];

        foreach($dbData as $db) {
            $dbDate = \Carbon\Carbon::parse($db->tanggal_prospek)->format('Y-m-d');
            $baseKey = $dbDate . '_' . strtolower(trim($db->perusahaan));
            
            // --- FIX ERROR: LOGIKA AMAN UNTUK MENGHITUNG CTA ---
            $ctaCount = 0;
            if ($db->cta) {
                // Jika hasilnya Collection (banyak data), hitung jumlahnya. 
                // Jika hasilnya Model tunggal (1 data), tetapkan nilainya 1.
                $ctaCount = $db->cta instanceof \Illuminate\Database\Eloquent\Collection ? $db->cta->count() : 1;
            }
            
            $iterations = $ctaCount > 0 ? $ctaCount : 1;
            // ---------------------------------------------------

            for ($i = 1; $i <= $iterations; $i++) {
                $dbOccurrence[$baseKey] = ($dbOccurrence[$baseKey] ?? 0) + 1;
                $finalKey = $baseKey . '_item_' . $dbOccurrence[$baseKey];
                
                $dbKeys[] = $finalKey;
                $dbProspeksStructured[] = [
                    'tanggal' => $dbDate,
                    'perusahaan' => $db->perusahaan,
                    'marketing' => $db->marketing ? $db->marketing->name : 'Tidak Diketahui',
                    'key' => $finalKey
                ];
            }
        }

        // 3. KOMPARASI (MENGGUNAKAN UNIQUE KEY BERBASIS INDEX)
        $inputKeys = collect($inputData)->pluck('key')->toArray();
        
        // Data Kurang di Sistem
        $missingInSystem = [];
        foreach ($inputData as $data) {
            if (!in_array($data['key'], $dbKeys)) {
                $missingInSystem[] = $data;
            }
        }

        // Data Berlebih di Sistem
        $missingInInput = [];
        foreach ($dbProspeksStructured as $data) {
            if (!in_array($data['key'], $inputKeys)) {
                $missingInInput[] = $data;
            }
        }

        return view('prospek-check', [
            'missingInSystemGrouped' => collect($missingInSystem)->groupBy('tanggal')->sortKeysDesc(),
            'missingInInputGrouped' => collect($missingInInput)->groupBy('tanggal')->sortKeysDesc(),
            'totalMissingInSystem' => count($missingInSystem),
            'totalMissingInInput' => count($missingInInput),
            'totalInput' => count($inputData),
            'totalDb' => count($dbKeys), // Total baris yang terdeteksi (Prospek + CTA)
            'jumlahTanggalUnik' => count($uniqueDates),
            'oldInput' => $request->data_excel
        ]);
    }
    
    // public function getDetailStatusAjax(Request $request)
    // {
    //     $marketing_id = $request->marketing_id;
    //     $status = $request->status;
    //     $start = $request->start_date;
    //     $end = $request->end_date;

    //     $query = Prospek::where('marketing_id', $marketing_id)
    //                     ->whereBetween('tanggal_prospek', [$start, $end])
    //                     ->orderBy('tanggal_prospek', 'desc');

    //     // Daftar status resmi (Sama persis seperti yang ada di Index)
    //     $statusResmi = [
    //         'DATA TIDAK VALID & TIDAK TERHUBUNG', 'TIDAK RESPON', 'DAPAT NO WA HRD', 'KIRIM COMPRO',
    //         'MANJA', 'MANJA ULANG', 'REQUEST PERMINTAAN PELATIHAN', 'MASUK PENAWARAN',
    //         'BELUM ADA KEBUTUHAN', 'REQUES PERPANJANGAN SERTIFIKAT', 'PENAWARAN HARDFILE',
    //         'TIDAK MENERIMA PENAWARAN', 'DAPAT NO TELP', 'SUDAH ADA VENDOR KERJASAMA', 'HOLD', 'DAPAT EMAIL'
    //     ];

    //     // Terapkan filter berdasarkan status yang diklik
    //     if ($status === 'tanpa_status') {
    //         $query->where(function($q) use ($statusResmi) {
    //             $q->whereNull('status')->orWhere('status', '')->orWhereNotIn('status', $statusResmi);
    //         });
    //     } elseif ($status !== 'semua') {
    //         $query->where('status', $status);
    //     }
    //     // Jika status == 'semua', query biarkan saja agar mengambil semua data

    //     $data = $query->get();

    //     // Susun HTML untuk disuntikkan ke dalam Modal
    //     $html = '';
    //     if ($data->count() > 0) {
    //         foreach ($data as $index => $d) {
    //             $tgl = \Carbon\Carbon::parse($d->tanggal_prospek)->format('d/m/Y');
    //             $wa = $d->wa_pic ? "<a href='https://wa.me/".preg_replace('/[^0-9]/', '', $d->wa_pic)."' target='_blank' class='btn btn-xs btn-success'><i class='fab fa-whatsapp'></i> Hubungi</a>" : '-';
                
    //             $html .= "<tr>
    //                 <td class='text-center'>".($index + 1)."</td>
    //                 <td class='text-center'>{$tgl}</td>
    //                 <td class='fw-bold text-dark'>{$d->perusahaan}</td>
    //                 <td>{$d->nama_pic} <br><small class='text-muted'>{$d->jabatan}</small></td>
    //                 <td class='text-center'>{$wa}</td>
    //             </tr>";
    //         }
    //     } else {
    //         $html = "<tr><td colspan='5' class='text-center text-muted py-4'>Tidak ada data ditemukan.</td></tr>";
    //     }

    //     $nama_marketing = \App\Models\User::find($marketing_id)->name ?? 'Marketing';
    //     $judul_status = $status === 'semua' ? 'Semua Status' : ($status === 'tanpa_status' ? 'Belum Ada Status' : $status);

    //     return response()->json([
    //         'title' => "Data Prospek: {$nama_marketing} - {$judul_status}",
    //         'html' => $html
    //     ]);
    // }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $import = new ProspekCtaImport;
            Excel::import($import, $request->file('file_excel'));

            // Simpan ke session untuk tombol Batal (Undo)
            session([
                'last_import_prospek_ids' => $import->createdProspekIds,
                'last_import_cta_ids'     => $import->createdCtaIds,
            ]);

            $countNewProspek = count($import->createdProspekIds);
            $countUpdatedProspek = $import->updatedProspekCount;
            $countNewCta = count($import->createdCtaIds);
            $countUpdatedCta = $import->updatedCtaCount;
            $countFailures = count($import->failures);
            $countSkipped = $import->skippedEmptyRowsCount;

            $totalRows = $countNewProspek + $countUpdatedProspek + $countFailures + $countSkipped;

            $message = "Import data Excel selesai! Berhasil memproses {$totalRows} baris data (berhasil ditambahkan: {$countNewProspek} prospek baru, {$countNewCta} CTA baru).";

            $importStats = [
                'new_prospek' => $countNewProspek,
                'updated_prospek' => $countUpdatedProspek,
                'new_cta' => $countNewCta,
                'updated_cta' => $countUpdatedCta,
                'skipped' => $countSkipped,
                'failures' => $countFailures
            ];

            if ($request->ajax()) {
                session()->flash('success', $message);
                session()->flash('import_stats', $importStats);
                session()->flash('import_failures', $import->failures);
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'redirect' => route('prospek.index')
                ]);
            }

            return redirect()->back()
                ->with('success', $message)
                ->with('import_stats', $importStats)
                ->with('import_failures', $import->failures);
        } catch (\Exception $e) {
            $errorMessage = 'Gagal meng-import data! Pastikan format kolom sesuai. Error: ' . $e->getMessage();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }
            
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function undoImport()
    {
        $prospekIds = session('last_import_prospek_ids', []);
        $ctaIds = session('last_import_cta_ids', []);

        if (empty($prospekIds) && empty($ctaIds)) {
            return redirect()->back()->with('error', 'Tidak ada data import terbaru yang dapat dibatalkan.');
        }

        try {
            DB::beginTransaction();

            // Hapus CTA yang dibuat saat import terbaru
            if (!empty($ctaIds)) {
                \App\Models\Cta::whereIn('id', $ctaIds)->delete();
            }

            // Hapus Prospek yang dibuat saat import terbaru
            if (!empty($prospekIds)) {
                \App\Models\Prospek::whereIn('id', $prospekIds)->delete();
            }

            DB::commit();

            $deletedProspekCount = count($prospekIds);
            $deletedCtaCount = count($ctaIds);

            // Bersihkan session
            session()->forget(['last_import_prospek_ids', 'last_import_cta_ids']);

            return redirect()->back()->with('success', "Berhasil membatalkan import terbaru! {$deletedProspekCount} Prospek baru dan {$deletedCtaCount} CTA baru telah dihapus secara permanen.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProspekCtaTemplateExport, 'template_import_prospek_cta.xlsx');
    }
}

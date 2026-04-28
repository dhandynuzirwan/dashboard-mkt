<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Prospek;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // 1. --- INISIALISASI FILTER ---
        $start = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $marketing_filter = $request->query('marketing_id');

        // 2. --- HITUNG HARI KERJA (FULL 1 BULAN) ---
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        $daftarLibur = \App\Models\Holiday::whereBetween('tanggal', [
                $startOfMonth->format('Y-m-d'), 
                $endOfMonth->format('Y-m-d')
            ])->pluck('tanggal')->toArray();

        $hariEfektif = 0; 

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektif++;
            }
        }

        // 2. Ambil User Marketing
        $query = \App\Models\User::where('role', 'marketing');
        if ($marketing_filter) {
            $query->where('id', $marketing_filter);
        }
        $users = $query->get();

        // --- 3a. LOGIKA STATISTIK RINGKASAN (UNTUK CARD DI ATAS) ---
        // FIX: Pindahkan filter tanggal ke dalam relasi prospek dan gunakan tanggal_prospek
        $statsQuery = Cta::whereHas('prospek', function ($q) use ($start, $end, $marketing_filter) {
            $q->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
            if ($marketing_filter) {
                $q->where('marketing_id', $marketing_filter);
            }
        });

        $stat_total_qty = (clone $statsQuery)->count();
        $stat_deal_qty = (clone $statsQuery)->where('status_penawaran', 'deal')->count();
        $stat_total_nilai = (clone $statsQuery)->get()->sum(fn ($item) => $item->harga_penawaran * $item->jumlah_peserta);
        $stat_deal_nilai = (clone $statsQuery)->where('status_penawaran', 'deal')->get()->sum(fn ($item) => $item->harga_penawaran * $item->jumlah_peserta);
        
        // 3. MAPPING DATA UNTUK TABEL PROGRESS & TABEL STATUS AKHIR
        $marketings = $users->map(function ($user) use ($start, $end, $hariEfektif) {
            $gaji = \App\Models\Penggajian::where('user_id', $user->id)->first();
            $targetCallHarian = $gaji->target_call ?? 0;

            $user->target_total = $targetCallHarian * $hariEfektif;

            // ================= PERHITUNGAN PROGRESS / PENCAPAIAN (VERSI LAMA) =================
            $baseCtaQuery = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]); 
            });

            $jumlahCtaBase = (clone $baseCtaQuery)->count();

            $jumlahCtaBerstatus = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->count();

            // 🔥 Rumus Lama: Menghitung total base CTA + CTA yang ada statusnya
            $user->pencapaian = $jumlahCtaBase + $jumlahCtaBerstatus;
            $user->ach_persen = ($user->target_total > 0) ? ($user->pencapaian / $user->target_total) * 100 : 0;

            // ================== 1. AMBIL DATA PROSPEK & CTA (UNTUK TABEL BAWAH) ==================
            $prospeks = \App\Models\Prospek::where('marketing_id', $user->id)
                ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"])->get();

            $ctasCount = \App\Models\Cta::whereIn('prospek_id', $prospeks->pluck('id'))
                ->selectRaw('prospek_id, count(*) as total')
                ->groupBy('prospek_id')
                ->pluck('total', 'prospek_id');

            $hitungStatus = function($statusName) use ($prospeks, $ctasCount) {
                return $prospeks->where('status', $statusName)->sum(function ($p) use ($ctasCount) {
                    $jmlCta = $ctasCount[$p->id] ?? 0;
                    return $jmlCta > 0 ? $jmlCta : 1; 
                });
            };

            // ================== 2. HITUNG STATUS AKHIR DATA ==================
            // Urutan variabel disesuaikan dengan urutan visual di foto (atas ke bawah)
            
            $user->count_invalid            = $hitungStatus('DATA TIDAK VALID & TIDAK TERHUBUNG');
            $user->count_tidak_respon       = $hitungStatus('TIDAK RESPON');
            $user->count_wa                 = $hitungStatus('DAPAT NO WA HRD');
            $user->count_compro             = $hitungStatus('KIRIM COMPRO');
            $user->count_manja              = $hitungStatus('MANJA');
            $user->count_manja_ulang        = $hitungStatus('MANJA ULANG');
            $user->count_pelatihan          = $hitungStatus('REQUEST PERMINTAAN PELATIHAN');
            $user->count_penawaran          = $hitungStatus('MASUK PENAWARAN');
            $user->count_belum_ada_kebutuhan = $hitungStatus('BELUM ADA KEBUTUHAN');
            $user->count_perpanjangan       = $hitungStatus('REQUES PERPANJANGAN SERTIFIKAT');
            $user->count_penawaran_hardfile  = $hitungStatus('PENAWARAN HARDFILE');
            $user->count_tidak_menerima_penawaran = $hitungStatus('TIDAK MENERIMA PENAWARAN');
            $user->count_dapat_telp         = $hitungStatus('DAPAT NO TELP'); // baru sesuai foto
            $user->count_sudah_ada_vendor_kerjasama = $hitungStatus('SUDAH ADA VENDOR KERJASAMA');
            
            // Status tambahan (untuk jaga-jaga jika ada data lama di database)
            $user->count_hold               = $hitungStatus('HOLD');
            $user->count_email              = $hitungStatus('DAPAT EMAIL');
            
            // ================== 🔥 LOGIKA SAPU JAGAT (Data Kosong / Typo) 🔥 ==================
            // Pastikan semua string status di atas masuk ke sini agar tidak terhitung sebagai "Tanpa Status"
            
            $statusResmi = [
                'DATA TIDAK VALID & TIDAK TERHUBUNG',
                'TIDAK RESPON',
                'DAPAT NO WA HRD',
                'KIRIM COMPRO',
                'MANJA',
                'MANJA ULANG',
                'REQUEST PERMINTAAN PELATIHAN',
                'MASUK PENAWARAN',
                'BELUM ADA KEBUTUHAN',
                'REQUES PERPANJANGAN SERTIFIKAT',
                'PENAWARAN HARDFILE',
                'TIDAK MENERIMA PENAWARAN',
                'DAPAT NO TELP',
                'SUDAH ADA VENDOR KERJASAMA',
                'HOLD',
                'DAPAT EMAIL'
            ];
            
            $user->count_tanpa_status = $prospeks->filter(function($p) use ($statusResmi) {
                // Jika status NULL, Kosong, atau Isinya tidak ada di daftar $statusResmi
                return empty($p->status) || !in_array($p->status, $statusResmi);
            })->sum(function ($p) use ($ctasCount) {
                $jmlCta = $ctasCount[$p->id] ?? 0;
                return $jmlCta > 0 ? $jmlCta : 1; 
            });

            // ================== 3. HITUNG STATUS PENAWARAN (DEAL, HOLD, DLL) ==================
            $cta = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]); 
            })->get();

            $user->total_penawaran = $cta->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '')->count();
            $user->deal = $cta->where('status_penawaran', 'deal')->count();
            $user->hold = $cta->where('status_penawaran', 'hold')->count();
            $user->kalah = $cta->where('status_penawaran', 'kalah_harga')->count();
            $user->review = $cta->where('status_penawaran', 'under_review')->count();

            return $user;
        });

        // ================= 4. LOGIKA PIE CHART & KAMUS WARNA MARKETING =================
        $pieLabels = [];
        $pieData = [];
        // Daftar warna yang SAMA PERSIS dengan konfigurasi Pie Chart di Blade
        $warnaPieChart = ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2', '#fd7e14', '#20c997'];
        $kamusWarnaMarketing = [];

        foreach ($users as $index => $user) {
            $pieLabels[] = $user->name;
            // Catat warna per marketing ke dalam kamus
            $kamusWarnaMarketing[$user->name] = $warnaPieChart[$index % count($warnaPieChart)];

            $totalNominalDeal = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]); 
            })
            ->where('status_penawaran', 'deal')
            ->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * jumlah_peserta'));
            
            $pieData[] = $totalNominalDeal;
        }

        // ================= 5. LOGIKA LINE CHART (DIBAGI 2 PAKET: 6 BULAN & BULAN INI) =================
        $colors = ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2'];

        // --- PAKET A: DATA 6 BULAN TERAKHIR ---
        $lineLabels6Months = [];
        for ($i = 5; $i >= 0; $i--) {
            $lineLabels6Months[] = now()->subMonths($i)->format('M Y');
        }
        $lineDatasets6Months = [];

        // --- PAKET B: DATA HARIAN (BULAN INI) ---
        $lineLabelsThisMonth = [];
        $daysInMonth = now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $lineLabelsThisMonth[] = $i . ' ' . now()->format('M');
        }
        $lineDatasetsThisMonth = [];

        // Eksekusi Query untuk kedua paket
        foreach ($users as $index => $user) {
            
            // Query 6 Bulan
            $data6Months = [];
            for ($i = 5; $i >= 0; $i--) {
                $startStr = now()->subMonths($i)->startOfMonth()->format('Y-m-d 00:00:00');
                $endStr = now()->subMonths($i)->endOfMonth()->format('Y-m-d 23:59:59');
                $data6Months[] = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $startStr, $endStr) {
                    $q->where('marketing_id', $user->id)->whereBetween('tanggal_prospek', [$startStr, $endStr]);
                })->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * jumlah_peserta'));
            }
            $lineDatasets6Months[] = [
                'label' => $user->name, 'borderColor' => $colors[$index] ?? '#000', 'backgroundColor' => 'transparent',
                'data' => $data6Months, 'fill' => false, 'borderWidth' => 2, 'tension' => 0.3,
            ];

            // Query Harian (Bulan Ini)
            $dataThisMonth = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dateStr = now()->format('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT);
                $dataThisMonth[] = \App\Models\Cta::whereHas('prospek', function ($q) use ($user, $dateStr) {
                    $q->where('marketing_id', $user->id)->whereBetween('tanggal_prospek', [$dateStr . " 00:00:00", $dateStr . " 23:59:59"]);
                })->sum(\Illuminate\Support\Facades\DB::raw('harga_penawaran * jumlah_peserta'));
            }
            $lineDatasetsThisMonth[] = [
                'label' => $user->name, 'borderColor' => $colors[$index] ?? '#000', 'backgroundColor' => 'transparent',
                'data' => $dataThisMonth, 'fill' => false, 'borderWidth' => 2, 'tension' => 0.3,
            ];
        }
        // ==============================================================================================

        $all_marketing = \App\Models\User::where('role', 'marketing')->get();
        $dataMasukToday = \App\Models\DataMasuk::whereDate('created_at', now())->count();
        $targetDataMasuk = 100;
        $isAdmin = auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin';
        $showReminder = $isAdmin && now()->hour < 16 && $dataMasukToday < $targetDataMasuk;
        $showSuccessReminder = $isAdmin && now()->hour < 16 && $dataMasukToday >= $targetDataMasuk;
        
        // ================= 🔥 DATA UNTUK PETA (DENGAN WARNA MARKETING DOMINAN) 🔥 =================
        // 1. Ambil semua prospek yang ada CTA dan lokasinya (ambil ID marketingnya juga)
        $semuaProspekMap = Prospek::whereHas('cta')
            ->whereBetween('tanggal_prospek', [$start, $end])
            ->whereNotNull('lokasi')
            ->get(['lokasi', 'marketing_id']); // Optimasi memori

        $mapDataMentah = [];

        // 2. Mapping lokasi ke kode provinsi dan hitung skor marketing
        foreach ($semuaProspekMap as $p) {
            $lokasiUpper = strtoupper(trim($p->lokasi));
            $marketingData = $users->firstWhere('id', $p->marketing_id);
            $namaMarketing = $marketingData ? $marketingData->name : 'Unknown';
            $code = '';

            if (str_contains($lokasiUpper, 'JAKARTA') || $lokasiUpper == 'DKI') $code = 'ID-JK';
            elseif (str_contains($lokasiUpper, 'JAWA BARAT') || $lokasiUpper == 'JABAR') $code = 'ID-JB';
            elseif (str_contains($lokasiUpper, 'JAWA TENGAH') || $lokasiUpper == 'JATENG') $code = 'ID-JT';
            elseif (str_contains($lokasiUpper, 'JAWA TIMUR') || $lokasiUpper == 'JATIM') $code = 'ID-JI';
            elseif (str_contains($lokasiUpper, 'YOGYAKARTA') || $lokasiUpper == 'JOGJA' || $lokasiUpper == 'DIY') $code = 'ID-YO';
            elseif (str_contains($lokasiUpper, 'BANTEN')) $code = 'ID-BT';
            elseif (str_contains($lokasiUpper, 'BALI')) $code = 'ID-BA';
            elseif (str_contains($lokasiUpper, 'SUMATERA UTARA') || $lokasiUpper == 'SUMUT') $code = 'ID-SU';
            elseif (str_contains($lokasiUpper, 'SUMATERA BARAT') || $lokasiUpper == 'SUMBAR') $code = 'ID-SB';
            elseif (str_contains($lokasiUpper, 'SUMATERA SELATAN') || $lokasiUpper == 'SUMSEL') $code = 'ID-SS';
            elseif (str_contains($lokasiUpper, 'RIAU')) $code = 'ID-RI';
            elseif (str_contains($lokasiUpper, 'KEPULAUAN RIAU') || $lokasiUpper == 'KEPRI') $code = 'ID-KR';
            elseif (str_contains($lokasiUpper, 'JAMBI')) $code = 'ID-JA';
            elseif (str_contains($lokasiUpper, 'BENGKULU')) $code = 'ID-BE';
            elseif (str_contains($lokasiUpper, 'LAMPUNG')) $code = 'ID-LA';
            elseif (str_contains($lokasiUpper, 'BANGKA BELITUNG') || $lokasiUpper == 'BABEL') $code = 'ID-BB';
            elseif (str_contains($lokasiUpper, 'ACEH')) $code = 'ID-AC';
            elseif (str_contains($lokasiUpper, 'KALIMANTAN BARAT') || $lokasiUpper == 'KALBAR') $code = 'ID-KB';
            elseif (str_contains($lokasiUpper, 'KALIMANTAN TENGAH') || $lokasiUpper == 'KALTENG') $code = 'ID-KT';
            elseif (str_contains($lokasiUpper, 'KALIMANTAN SELATAN') || $lokasiUpper == 'KALSEL') $code = 'ID-KS';
            elseif (str_contains($lokasiUpper, 'KALIMANTAN TIMUR') || $lokasiUpper == 'KALTIM') $code = 'ID-KI';
            elseif (str_contains($lokasiUpper, 'KALIMANTAN UTARA') || $lokasiUpper == 'KALTARA') $code = 'ID-KU';
            elseif (str_contains($lokasiUpper, 'SULAWESI UTARA') || $lokasiUpper == 'SULUT') $code = 'ID-SA';
            elseif (str_contains($lokasiUpper, 'SULAWESI TENGAH') || $lokasiUpper == 'SULTENG') $code = 'ID-ST';
            elseif (str_contains($lokasiUpper, 'SULAWESI SELATAN') || $lokasiUpper == 'SULSEL') $code = 'ID-SN';
            elseif (str_contains($lokasiUpper, 'SULAWESI TENGGARA') || $lokasiUpper == 'SULTRA') $code = 'ID-SG';
            elseif (str_contains($lokasiUpper, 'SULAWESI BARAT') || $lokasiUpper == 'SULBAR') $code = 'ID-SR';
            elseif (str_contains($lokasiUpper, 'GORONTALO')) $code = 'ID-GO';
            elseif (str_contains($lokasiUpper, 'MALUKU UTARA') || $lokasiUpper == 'MALUT') $code = 'ID-MU';
            elseif (str_contains($lokasiUpper, 'MALUKU')) $code = 'ID-MA';
            elseif (str_contains($lokasiUpper, 'PAPUA BARAT')) $code = 'ID-PB';
            elseif (str_contains($lokasiUpper, 'PAPUA')) $code = 'ID-PA';
            elseif (str_contains($lokasiUpper, 'NUSA TENGGARA BARAT') || $lokasiUpper == 'NTB') $code = 'ID-NB';
            elseif (str_contains($lokasiUpper, 'NUSA TENGGARA TIMUR') || $lokasiUpper == 'NTT') $code = 'ID-NT';

            if ($code != '') {
                if(!isset($mapDataMentah[$code])) {
                    $mapDataMentah[$code] = [
                        'total' => 0,
                        'marketing_counts' => [] // Menyimpan siapa dapat berapa di provinsi ini
                    ];
                }
                
                $mapDataMentah[$code]['total'] += 1;
                
                if (!isset($mapDataMentah[$code]['marketing_counts'][$namaMarketing])) {
                    $mapDataMentah[$code]['marketing_counts'][$namaMarketing] = 0;
                }
                $mapDataMentah[$code]['marketing_counts'][$namaMarketing] += 1;
            }
        }

        // 3. Rakit Data Akhir untuk Highcharts
        $mapData = [];
        foreach ($mapDataMentah as $code => $data) {
            // Cari nama marketing dengan angka tertinggi di provinsi tersebut
            $marketingDominan = array_keys($data['marketing_counts'], max($data['marketing_counts']))[0];
            
            // Ambil warna dari kamus (fallback ke oranye kalau tidak ada)
            $warnaHover = $kamusWarnaMarketing[$marketingDominan] ?? '#ff9e27';

            $mapData[$code] = [
                'total' => $data['total'],
                'warna' => $warnaHover
            ];
        }
        // ================= 🔥 END DATA PETA 🔥 =================

        return view('dashboard-progress', compact(
            'marketings', 'all_marketing', 'start', 'end',
            'pieLabels', 'pieData', 
            'lineLabels6Months', 'lineDatasets6Months', 'lineLabelsThisMonth', 'lineDatasetsThisMonth',
            'stat_total_qty', 'stat_deal_qty', 'stat_total_nilai', 'stat_deal_nilai', 
            'showReminder', 'showSuccessReminder', 'dataMasukToday', 'targetDataMasuk', 'mapData'
        ));
    }

    public function getDetail(Request $request, $id)
    {
        $authUser = auth()->user();

        if ($authUser->role === 'marketing' && $authUser->id != $id) {
            abort(403, 'Unauthorized access');
        }

        $start = $request->query('start');
        $end = $request->query('end');

        // FIX: Tambahkan jam agar akurat saat di-klik detailnya
        $details = \App\Models\Cta::whereHas('prospek', function ($q) use ($id, $start, $end) {
            $q->where('marketing_id', $id)
              ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
        })
            ->with('prospek')
            ->get();

        return view('partials.modal-detail-penawaran', compact('details'));
    }
}
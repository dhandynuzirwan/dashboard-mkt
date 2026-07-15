<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Traits\KpiCalculationTrait;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Holiday;
use App\Models\Perizinan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    use KpiCalculationTrait;

    private function getSalaryCalculation($user, $start, $end)
    {
        // A. Setup Tanggal & Libur
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();
        $daftarLibur = Holiday::whereBetween('tanggal', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
                        ->pluck('tanggal')->toArray();

        // B1. Hitung TOTAL Hari Efektif Sebulan Penuh (Untuk penentuan Gaji Per Hari & Target Bulanan)
        $hariEfektif = 0; 
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektif++;
            }
        }

        // B2. Hitung Hari Efektif BERJALAN (Maksimal sampai hari ini agar tidak ada potongan siluman)
        // Jika filter tanggal akhir ($end) melebihi hari ini, maka mentok di hari ini.
        $batasAkhir = min($end, now()->format('Y-m-d'));
        $hariEfektifBerjalan = 0;
        for ($date = $startOfMonth->copy(); $date->lte(Carbon::parse($batasAkhir)); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektifBerjalan++;
            }
        }

        // C. Data Dasar Gaji
        $gaji = Penggajian::where('user_id', $user->id)->first();
        $gapokDasar = $gaji->gaji_pokok ?? 0;
        $tunjangan = $gaji->tunjangan ?? 0;
        $tunjBpjs = $gaji->tunjangan_bpjs ?? 0;
        $iuranBpjs = $gaji->iuran_bpjs ?? 0;
        $targetCall = $gaji->target_call ?? 0;
        $targetRev = $gaji->target ?? 0;

        // D. Hitung Hadir & Izin
        $hadir = AbsensiLog::where('user_id', $user->id)->whereBetween('tanggal', [$start, $end])->distinct()->count('tanggal');
        $izin = Perizinan::where('user_id', $user->id)->whereBetween('tanggal', [$start, $end])->where('status', 'approved')->count();
        $totalHadir = $hadir + $izin;
        
        // E. Kalkulasi CTA & Revenue
        $baseCta = Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
            });

        $progReal = (clone $baseCta)->count() + (clone $baseCta)->whereNotNull('status_penawaran')->where('status_penawaran','!=','')->count();
        // $progTarget = $targetCall * $hariEfektif; // Target tetap dihitung full sebulan
        $progTarget = $targetCall * 23;
        $income = (clone $baseCta)->where('status_penawaran', 'deal')->get()->sum(fn($i) => $i->harga_penawaran * $i->jumlah_peserta);

        // ================= 🔥 LOGIKA POTONGAN ALPA & IZIN 🔥 =================
        // 1. Hitung jumlah hari tidak masuk (Alpa) berdasarkan hari yang SUDAH BERJALAN
        $hariAlpa = max(0, $hariEfektifBerjalan - $totalHadir);

        // 2. Hitung potongan per hari (Gaji Pokok dibagi Total Hari Efektif Sebulan)
        $potonganPerHari = ($hariEfektif > 0) ? ($gapokDasar / $hariEfektif) : 0;
        
        // 3. Eksekusi nominal potongan Alpa
        $potonganAlpa = $hariAlpa * $potonganPerHari;

        // 4. Potongan dari Form Izin (Misal: Izin telat, pulang awal)
        $potIzinForm = Perizinan::where('perizinans.user_id', $user->id)
                    ->whereBetween('perizinans.tanggal', [$start, $end])
                    ->where('perizinans.status', 'approved')
                    ->join('jenis_izins', 'perizinans.jenis', '=', 'jenis_izins.nama_izin')
                    ->sum('jenis_izins.potongan') ?? 0;

        // 5. Total semua potongan kehadiran
        $totalPotonganKehadiran = $potIzinForm + $potonganAlpa;
        // ======================================================================

        // F. Hitung KPI (Absensi, Progress, Revenue)
        $kpiCapped = true; 

        // Agar KPI Absensi juga fair, kita hitung persentasenya menggunakan Hari Berjalan, bukan Hari Full Sebulan
        $persenAbsensi = ($hariEfektifBerjalan > 0) ? ($totalHadir / $hariEfektifBerjalan) * 100 : 0;
        $persenRev = ($targetRev > 0) ? ($income / $targetRev) * 100 : 0;

        if ($kpiCapped) {
            $persenAbsensi = min(100, $persenAbsensi); 
            $persenRev = min(100, $persenRev);         
        }

        $absensiKpi = $persenAbsensi * 0.1;
        $revKpi = $persenRev * 0.6;

        // ------------------ PROGRESS 3 KOMPONEN ------------------
        $prospeks = \App\Models\Prospek::where('marketing_id', $user->id)
            ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"])->get();

        // Ambil ctacount dengan baseCtaQuery agar filter prospek berlaku
        $ctasCount = \App\Models\Cta::whereIn('prospek_id', $prospeks->pluck('id'))
                ->selectRaw('prospek_id, count(*) as total')
                ->groupBy('prospek_id')
                ->pluck('total', 'prospek_id');

        // 1. UPDATE DATA
        $totalUpdateData = $progReal; 

        // 2. STATUS AKHIR PEROLEHAN DATA
        $hitungStatus = function($statusName) use ($prospeks, $ctasCount) {
            return $prospeks->where('status', $statusName)->sum(function ($p) use ($ctasCount) {
                $jmlCta = $ctasCount[$p->id] ?? 0;
                return $jmlCta > 0 ? $jmlCta : 1; 
            });
        };
        $statusResmi = [
            'DATA TIDAK VALID & TIDAK TERHUBUNG', 'TIDAK RESPON', 'DAPAT NO WA HRD',
            'KIRIM COMPRO', 'MANJA', 'MANJA ULANG', 'REQUEST PERMINTAAN PELATIHAN',
            'MASUK PENAWARAN', 'BELUM ADA KEBUTUHAN', 'REQUES PERPANJANGAN SERTIFIKAT',
            'PENAWARAN HARDFILE', 'TIDAK MENERIMA PENAWARAN', 'DAPAT NO TELP',
            'SUDAH ADA VENDOR KERJASAMA', 'HOLD', 'DAPAT EMAIL'
        ];
        $totalAkhirData = 0;
        foreach($statusResmi as $st) {
            $totalAkhirData += $hitungStatus($st);
        }

        // 3. UPDATE PENAWARAN
        $totalPenawaranBase = (clone $baseCta)->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '')->count();
        $tambahanMasukPenawaran = $hitungStatus('MASUK PENAWARAN');
        $totalPenawaran = $totalPenawaranBase + $tambahanMasukPenawaran;

         // PEMBOBOTAN
        $maxDataUpdate = 115;
        $maxDataAkhir = 172;
        $maxDataPenawaran = 287;

        $bobotUpdate = 20;
        $bobotAkhir = 30;
        $bobotPenawaran = 50;

        // Dibagi 100, tetapi hasil tidak boleh melebihi bobot masing-masing
        // $skorUpdate = min((($totalUpdateData / 100) * $bobotUpdate), $bobotUpdate);
        // $skorAkhir = min((($totalAkhirData / 100) * $bobotAkhir), $bobotAkhir);
        // $skorPenawaran = min((($totalPenawaran / 100) * $bobotPenawaran), $bobotPenawaran);

        // Atau batasi dulu jumlah datanya
        $skorUpdate = min((min($totalUpdateData, $maxDataUpdate) / 100) * $bobotUpdate, $bobotUpdate);
        $skorAkhir = min((min($totalAkhirData, $maxDataAkhir) / 100) * $bobotAkhir, $bobotAkhir);
        $skorPenawaran = min((min($totalPenawaran, $maxDataPenawaran) / 100) * $bobotPenawaran, $bobotPenawaran);

        $persenProg = $skorUpdate + $skorAkhir + $skorPenawaran; // Skala 100%
        $progKpi = ($persenProg / 100) * 30;

        $totalKpi = $absensiKpi + $progKpi + $revKpi;

        // G. Hitung Nominal Gaji Akhir (NEW LOGIC)
        $kpi_rp = ($income < 60000000) ? ($income * 0.40) : ($income * 0.60);

        if ($income < 30000000) {
            $fee_mkt = 0;
        } else {
            if ($totalKpi < 70) {
                $fee_mkt = $kpi_rp * 0.02;
            } else {
                $fee_mkt = $kpi_rp * 0.05;
            }
        }

        // THP = Gaji Pokok + Fee Marketing + Tunjangan BPJS
        $total_gaji = $gapokDasar + $fee_mkt + $tunjBpjs;

        // H. Kembalikan Object
        return (object) [
            'gapok_hitung' => $gapokDasar,
            'fee_marketing' => $fee_mkt,
            'tunjangan_bpjs' => $tunjBpjs,
            'total_gaji' => $total_gaji,
            
            'income' => $income,
            'kpi_rp' => $kpi_rp,
            'kpi_persen' => $totalKpi,
            
            'ach_absensi' => $absensiKpi,
            'ach_progress' => $progKpi,
            'ach_revenue' => $revKpi,
            
            'totalHadir' => $totalHadir,
            'hari_efektif' => $hariEfektif,
            
            'detail_update_data' => $totalUpdateData,
            'detail_akhir_data' => $totalAkhirData,
            'detail_penawaran' => $totalPenawaran,
            'skor_update' => $skorUpdate,
            'skor_akhir' => $skorAkhir,
            'skor_penawaran' => $skorPenawaran,
            
            'target_penawaran' => $progTarget,
            'real_penawaran' => $progReal,
            'hari_efektif_berjalan' => $hariEfektifBerjalan,
        ];
    }
    
    public function index(Request $request)
    {
        $start = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', now()->format('Y-m-d'));
        
        $query = User::where('role', 'marketing');
        if (auth()->user()->role === 'marketing') {
            $query->where('id', auth()->id());
        } elseif ($request->marketing_id) {
            $query->where('id', $request->marketing_id);
        }
        
        $marketings = $query->get()->map(function ($user) use ($start, $end) {
            // Panggil Mesin Penghitung
            $calc = $this->getSalaryCalculation($user, $start, $end);
            
            // Gabungkan hasil hitungan ke object user
            foreach ($calc as $key => $value) { $user->$key = $value; }
            return $user;
        });

        $all_marketing = User::where('role', 'marketing')->get();
        $hariEfektif = $marketings->first()->hari_efektif ?? 0;

        // KALKULASI STATS SUPERADMIN
        $total_kpi_avg = 0;
        $total_fee_marketing = 0;
        $komisi_spv = 0;
        $komisi_tl = 0;
        $total_fee_dikeluarkan = 0;
        $rasio_fee_revenue = 0;
        $rasio_gaji_revenue = 0;

        if (auth()->user()->role === 'superadmin') {
            $total_kpi_avg = $marketings->count() > 0 ? $marketings->avg('kpi_persen') : 0;
            $total_fee_marketing = $marketings->sum('fee_marketing');
            $total_income = $marketings->sum('income');
            $total_thp = $marketings->sum('total_gaji');
            
            // Komisi SPV
            $komisi_spv = ($total_kpi_avg < 70) ? ($total_fee_marketing * 0.05) : ($total_fee_marketing * 0.10);
            
            // Komisi TL
            $komisi_tl = ($total_kpi_avg < 70) ? ($total_fee_marketing * 0.025) : ($total_fee_marketing * 0.05);
            
            $total_fee_dikeluarkan = $total_fee_marketing + $komisi_spv + $komisi_tl;
            
            if ($total_income > 0) {
                $rasio_fee_revenue = ($total_fee_dikeluarkan / $total_income) * 100;
                $rasio_gaji_revenue = ($total_thp / $total_income) * 100;
            }
        }

        return view('simulasi-gaji', compact(
            'marketings', 'hariEfektif', 'start', 'end', 'all_marketing',
            'total_kpi_avg', 'total_fee_marketing', 'komisi_spv', 'komisi_tl',
            'total_fee_dikeluarkan', 'rasio_fee_revenue', 'rasio_gaji_revenue'
        ));
    }
    
    public function previewSlip($id)
    {
        // 1. Cari User berdasarkan ID (Marketing)
        $user = User::findOrFail($id);
        
        // 2. Ambil juga data Penggajian dasarnya agar variabel $penggajian tersedia di Blade
        $penggajian = Penggajian::where('user_id', $user->id)->firstOrFail();
        
        // 3. Ambil range bulan sekarang untuk slip
        $now = now();
        $start = $now->copy()->startOfMonth()->format('Y-m-d');
        $end = $now->copy()->format('Y-m-d');
    
        // 4. Panggil Mesin Penghitung
        $calc = $this->getSalaryCalculation($user, $start, $end);
    
        // 5. Logic Nomor Referensi & Jabatan
        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $noReferensi = str_pad($now->month, 3, '0', STR_PAD_LEFT) . "/AJP/GJ/" . $romawi[$now->month] . "/" . $now->year;
        $jabatan = stripos($user->name, 'arsa') !== false ? 'Marketing' : ($user->nama_lengkap ? 'Staff' : 'Karyawan');
    
        // 6. Breakdown BPJS untuk tampilan slip
        $jht_karyawan = $calc->iuran_bpjs - $calc->tunjangan_bpjs;
        $jkk = round((0.24 / 4.24) * $calc->tunjangan_bpjs);
        $jkm = round((0.30 / 4.24) * $calc->tunjangan_bpjs);
        $jht_kantor = $calc->tunjangan_bpjs - $jkk - $jkm;
    
        // 7. Kirim semua data ke View (Pastikan 'penggajian' masuk ke array)
        return view('penggajian.slip_print', array_merge((array)$calc, [
            'user' => $user,
            'penggajian' => $penggajian, 
            'noReferensi' => $noReferensi,
            'jabatan' => $jabatan,
            'now' => $now,
            'jkk' => $jkk,
            'jkm' => $jkm,
            'jht_kantor' => $jht_kantor,
            'jht_karyawan' => $jht_karyawan
        ]));
    }
}
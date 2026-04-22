<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\Penggajian;
use App\Models\Prospek;
use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Holiday;
use App\Models\Perizinan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private function getSalaryCalculation($user, $start, $end)
    {
        // A. Hitung Hari Efektif
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();
        $daftarLibur = Holiday::whereBetween('tanggal', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
                        ->pluck('tanggal')->toArray();

        $hariEfektif = 0; 
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isWeekday() && !in_array($date->format('Y-m-d'), $daftarLibur)) { 
                $hariEfektif++;
            }
        }

        // B. Data Dasar Gaji
        $gaji = Penggajian::where('user_id', $user->id)->first();
        $gapokDasar = $gaji->gaji_pokok ?? 0;
        $tunjangan = $gaji->tunjangan ?? 0;
        $tunjBpjs = $gaji->tunjangan_bpjs ?? 0;
        $iuranBpjs = $gaji->iuran_bpjs ?? 0;
        $targetCall = $gaji->target_call ?? 0;
        $targetRev = $gaji->target ?? 0;

        // C. Hitung KPI (Absensi, Progress, Revenue)
        $hadir = AbsensiLog::where('user_id', $user->id)->whereBetween('tanggal', [$start, $end])->distinct()->count('tanggal');
        $izin = Perizinan::where('user_id', $user->id)->whereBetween('tanggal', [$start, $end])->where('status', 'approved')->count();
        $totalHadir = $hadir + $izin;
        
        $absensiKpi = (($hariEfektif > 0) ? min(100, ($totalHadir / $hariEfektif) * 100) : 0) * 0.1;

        // FIX: Pindahkan filter tanggal ke dalam prospek dan gunakan tanggal_prospek
        $baseCta = Cta::whereHas('prospek', function ($q) use ($user, $start, $end) {
                $q->where('marketing_id', $user->id)
                  ->whereBetween('tanggal_prospek', [$start . " 00:00:00", $end . " 23:59:59"]);
            });

        $progReal = (clone $baseCta)->count() + (clone $baseCta)->whereNotNull('status_penawaran')->where('status_penawaran','!=','')->count();
        $progTarget = $targetCall * $hariEfektif;
        $progKpi = (($progTarget > 0) ? ($progReal / $progTarget) * 100 : 0) * 0.3;

        $income = (clone $baseCta)->where('status_penawaran', 'deal')->get()->sum(fn($i) => $i->harga_penawaran * $i->jumlah_peserta);
        $revKpi = (($targetRev > 0) ? ($income / $targetRev) * 100 : 0) * 0.6;

        $totalKpi = $absensiKpi + $progKpi + $revKpi;

        // D. Hitung Nominal Rupiah (Ikuti rumus Dashboard)
        $gapok_hitung = ($hariEfektif > 0) ? ($totalHadir / $hariEfektif) * $gapokDasar : 0;
        $fee_mkt = ($income * 0.6) * (($totalKpi < 70) ? 0.025 : 0.05);
        $prog_val = $gapokDasar * ($progKpi / 100);
        
        // Potongan Izin (Berdasarkan tabel jenis_izins)
        $potIzin = Perizinan::where('perizinans.user_id', $user->id)
                    ->whereBetween('perizinans.tanggal', [$start, $end])
                    ->where('perizinans.status', 'approved')
                    ->join('jenis_izins', 'perizinans.jenis', '=', 'jenis_izins.nama_izin')
                    ->sum('jenis_izins.potongan') ?? 0;

        $total_gaji = $gapok_hitung + $fee_mkt + $prog_val + $tunjangan + $tunjBpjs - $iuranBpjs - $potIzin;

        // E. Kembalikan semua hasil dalam satu object
        return (object) [
            'gapok_hitung' => $gapok_hitung,
            'fee_marketing' => $fee_mkt,
            'progress_val' => $prog_val,
            'tunj_kemahalan' => $tunjangan,
            'tunjangan_bpjs' => $tunjBpjs,
            'iuran_bpjs' => $iuranBpjs,
            'potonganIzin' => $potIzin,
            'total_gaji' => $total_gaji,
            'absensi_hadir_real' => $totalHadir,
            'hari_efektif' => $hariEfektif,
            'income' => $income,
            'kpi_persen' => $totalKpi,
            'ach_absensi' => $absensiKpi,
            'ach_progress' => $progKpi,
            'ach_revenue' => $revKpi,
            'target_penawaran' => $progTarget,
            'real_penawaran' => $progReal
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

        return view('simulasi-gaji', compact('marketings', 'hariEfektif', 'start', 'end', 'all_marketing'));
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
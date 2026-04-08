<?php

namespace App\Http\Controllers;

use App\Models\Cta;
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
        // 1. Tentukan rentang awal dan akhir bulan berdasarkan filter $start
        $startDate = Carbon::parse($start);
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();

        // 2. Ambil daftar tanggal merah bulan ini dari database
        $daftarLibur = \App\Models\Holiday::whereBetween('tanggal', [
                $startOfMonth->format('Y-m-d'), 
                $endOfMonth->format('Y-m-d')
            ])->pluck('tanggal')->toArray();

        // 3. Hitung Hari Efektif (Hanya Senin-Jumat & Bukan Tanggal Merah)
        $hariEfektif = 0; 

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            // Logika: Jika hari biasa (Senin-Jumat) DAN tidak terdaftar di tabel Holiday
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
        $statsQuery = Cta::whereBetween('created_at', [$start, $end]);

        // Jika ada filter marketing, filter juga statistik globalnya
        if ($marketing_filter) {
            $statsQuery->whereHas('prospek', function ($q) use ($marketing_filter) {
                $q->where('marketing_id', $marketing_filter);
            });
        }

        // Kita gunakan clone agar query builder tidak tercampur antara count dan sum
        $stat_total_qty = (clone $statsQuery)->count();
        $stat_deal_qty = (clone $statsQuery)->where('status_penawaran', 'deal')->count();
        // FIX: Hitung Nilai Berdasarkan (Harga x Qty)
        $stat_total_nilai = (clone $statsQuery)->get()->sum(fn ($item) => $item->harga_penawaran * $item->jumlah_peserta);
        $stat_deal_nilai = (clone $statsQuery)->where('status_penawaran', 'deal')->get()->sum(fn ($item) => $item->harga_penawaran * $item->jumlah_peserta);
        // 3. MAPPING DATA UNTUK TABEL PROGRESS & TABEL STATUS AKHIR
        $marketings = $users->map(function ($user) use ($start, $end, $hariEfektif) {
            $gaji = \App\Models\Penggajian::where('user_id', $user->id)->first();
            $targetCallHarian = $gaji->target_call ?? 0;

            $user->target_total = $targetCallHarian * $hariEfektif;

            // ================= PERHITUNGAN PROGRESS / PENCAPAIAN =================
            // Kita ambil data CTA sebagai Base Query (menggunakan query, BUKAN get())
            $baseCtaQuery = \App\Models\Cta::whereHas('prospek', function ($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"]);

            // 1. Hitung JUMLAH SEMUA CTA yang dibuat
            $jumlahCtaBase = (clone $baseCtaQuery)->count();

            // 2. Hitung JUMLAH CTA YANG MEMILIKI STATUS (Update / Follow Up)
            $jumlahCtaBerstatus = (clone $baseCtaQuery)
                ->whereNotNull('status_penawaran')
                ->where('status_penawaran', '!=', '')
                ->count();

            // 3. RUMUS PROGRESS: Total Form Dibuat + Total Form Diupdate Statusnya
            $user->pencapaian = $jumlahCtaBase + $jumlahCtaBerstatus;
            
            // Hitung persentase pencapaian
            $user->ach_persen = ($user->target_total > 0) ? ($user->pencapaian / $user->target_total) * 100 : 0;
            // =====================================================================

            // Ambil semua prospek user ini dalam range tanggal
            $prospeks = \App\Models\Prospek::where('marketing_id', $user->id)
                ->whereBetween('created_at', [$start, $end])->get();

            // ================== LOGIKA BARU: MENGHITUNG CTA PER PROSPEK ==================
            // Kita cari tahu setiap prospek itu punya berapa CTA
            $ctasCount = \App\Models\Cta::whereIn('prospek_id', $prospeks->pluck('id'))
                ->selectRaw('prospek_id, count(*) as total')
                ->groupBy('prospek_id')
                ->pluck('total', 'prospek_id');

            // Fungsi cerdas: Kalau ada CTA hitung CTA-nya, kalau belum ada hitung 1 prospek
            $hitungStatus = function($statusName) use ($prospeks, $ctasCount) {
                return $prospeks->where('status', $statusName)->sum(function ($p) use ($ctasCount) {
                    $jmlCta = $ctasCount[$p->id] ?? 0;
                    return $jmlCta > 0 ? $jmlCta : 1; 
                });
            };

            // --- LOGIKA UNTUK TABEL STATUS AKHIR DATA ---
            $user->count_perpanjangan = $hitungStatus('REQUES PERPANJANGAN SERTIFIKAT');
            $user->count_invalid      = $hitungStatus('DATA TIDAK VALID & TIDAK TERHUBUNG');
            $user->count_email        = $hitungStatus('DAPAT EMAIL');
            $user->count_wa           = $hitungStatus('DAPAT NO WA HRD');
            $user->count_compro       = $hitungStatus('KIRIM COMPRO');
            $user->count_manja        = $hitungStatus('MANJA');
            $user->count_manja_ulang  = $hitungStatus('MANJA ULANG');
            $user->count_pelatihan    = $hitungStatus('REQUEST PERMINTAAN PELATIHAN');
            $user->count_penawaran    = $hitungStatus('MASUK PENAWARAN');

            $cta = \App\Models\Cta::whereHas('prospek', function ($q) use ($user) {
                $q->where('marketing_id', $user->id);
            })->whereBetween('created_at', [$start, $end])->get();

            $user->total_penawaran = $cta->whereNotNull('status_penawaran')->where('status_penawaran', '!=', '')->count();
            $user->deal = $cta->where('status_penawaran', 'deal')->count();
            $user->hold = $cta->where('status_penawaran', 'hold')->count();
            $user->kalah = $cta->where('status_penawaran', 'kalah_harga')->count();
            $user->review = $cta->where('status_penawaran', 'under_review')->count();

            return $user;
        });

        // 4. LOGIKA PIE CHART (Total Nominal RUPIAH dari Status DEAL)
        $pieLabels = [];
        $pieData = [];
        foreach ($users as $user) {
            $pieLabels[] = $user->name;
            $totalNominalDeal = \App\Models\Cta::whereHas('prospek', fn ($q) => $q->where('marketing_id', $user->id))
                ->where('status_penawaran', 'deal') // Hanya yang Deal
                ->whereBetween('created_at', [$start, $end])
                ->sum('harga_penawaran'); // Jumlahkan Rupiahnya
            $pieData[] = $totalNominalDeal;
        }

        // 5. LOGIKA LINE CHART (Total NOMINAL PENAWARAN - Walau Gagal/Hold)
        $lineLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $lineLabels[] = now()->subMonths($i)->format('M Y');
        }

        $lineDatasets = [];
        $colors = ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2'];

        foreach ($users as $index => $user) {
            $monthlyOfferNominals = [];
            for ($i = 5; $i >= 0; $i--) {
                $loopStart = now()->subMonths($i)->startOfMonth();
                $loopEnd = now()->subMonths($i)->endOfMonth();

                // Menjumlahkan SUM harga_penawaran TANPA filter status (semua penawaran masuk)
                $sumNominal = \App\Models\Cta::whereHas('prospek', fn ($q) => $q->where('marketing_id', $user->id))
                    ->whereBetween('created_at', [$loopStart, $loopEnd])
                    ->sum('harga_penawaran');

                $monthlyOfferNominals[] = $sumNominal;
            }

            $lineDatasets[] = [
                'label' => $user->name,
                'borderColor' => $colors[$index] ?? '#000',
                'backgroundColor' => 'transparent',
                'data' => $monthlyOfferNominals,
                'fill' => false,
                'borderWidth' => 2,
                'tension' => 0.3,
            ];
        }

        $all_marketing = \App\Models\User::where('role', 'marketing')->get();

        // ================= REMINDER ADMIN =================
        $dataMasukToday = \App\Models\DataMasuk::whereDate('created_at', now())->count();
        $targetDataMasuk = 100;

        // Cek apakah user yang login adalah admin atau superadmin
        $isAdmin = auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin';

        // Reminder aktif HANYA UNTUK ADMIN, sebelum jam 16:00, jika belum mencapai target
        $showReminder = $isAdmin && now()->hour < 16 && $dataMasukToday < $targetDataMasuk;

        // Success HANYA UNTUK ADMIN, jika target tercapai
        $showSuccessReminder = $isAdmin && now()->hour < 16 && $dataMasukToday >= $targetDataMasuk;

        return view('dashboard-progress', compact(
            'marketings', 'all_marketing', 'start', 'end',
            'pieLabels', 'pieData', 'lineLabels', 'lineDatasets',
            'stat_total_qty', 'stat_deal_qty', 'stat_total_nilai', 'stat_deal_nilai', 
            'showReminder', 'showSuccessReminder', 'dataMasukToday', 'targetDataMasuk'
        ));

        // return view('dashboard-progress', compact(
        //     'marketings', 'all_marketing', 'start', 'end',
        //     'pieLabels', 'pieData', 'lineLabels', 'lineDatasets',
        //     'stat_total_qty', 'stat_deal_qty', 'stat_total_nilai', 'stat_deal_nilai', 'showReminder', 'showSuccessReminder', 'dataMasukToday', 'targetDataMasuk'
        // ));
    }

    public function getDetail(Request $request, $id)
    {
        $authUser = auth()->user();

        // 🔐 Kalau marketing, hanya boleh akses detail miliknya sendiri
        if ($authUser->role === 'marketing' && $authUser->id != $id) {
            abort(403, 'Unauthorized access');
        }

        $start = $request->query('start');
        $end = $request->query('end');

        $details = \App\Models\Cta::whereHas('prospek', function ($q) use ($id) {
            $q->where('marketing_id', $id);
        })
            ->with('prospek')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        return view('partials.modal-detail-penawaran', compact('details'));
    }
}

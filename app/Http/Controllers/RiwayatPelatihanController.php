<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPelatihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RiwayatPelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatPelatihan::query();

        // 1. Filter: Bulan & Tahun
        if ($request->filled('month_year')) {
            $date = Carbon::createFromFormat('Y-m', $request->month_year);
            $query->whereMonth('tanggal_mulai', $date->month)
                  ->whereYear('tanggal_mulai', $date->year);
        }

        // 2. Filter: Jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // 3. Filter: Metode
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        // Data for the table
        $riwayat = (clone $query)->orderBy('tanggal_mulai', 'desc')->paginate(10)->withQueryString();

        // Calculate stats (Filtered)
        $totalSertifikatTerbit = (clone $query)->where('status_sertif', 'Sudah Terbit')->sum('jumlah_peserta');
        $totalSertifikatPending = (clone $query)->where('status_sertif', 'Belum Terbit')->sum('jumlah_peserta');
        $totalPelatihan = (clone $query)->count();

        // Data for Chart 1: 12 months history
        $chartData = [
            'labels' => [],
            'dataPeserta' => [],
            'dataPelatihan' => []
        ];
        
        $baseDate = $request->filled('month_year') ? Carbon::createFromFormat('Y-m', $request->month_year)->endOfMonth() : Carbon::now()->endOfMonth();

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = (clone $baseDate)->startOfMonth()->subMonths($i);
            $monthEnd = (clone $baseDate)->endOfMonth()->subMonths($i);
            
            $monthName = $monthStart->translatedFormat('M Y');
            
            $trendQuery = RiwayatPelatihan::whereBetween('tanggal_mulai', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')]);
            if ($request->filled('jenis')) $trendQuery->where('jenis', $request->jenis);
            if ($request->filled('metode')) $trendQuery->where('metode', $request->metode);

            $chartData['labels'][] = $monthName;
            $chartData['dataPeserta'][] = (clone $trendQuery)->sum('jumlah_peserta');
            $chartData['dataPelatihan'][] = (clone $trendQuery)->count();
        }

        // Data for Chart 2: Proportion by Jenis (Doughnut)
        $jenisStats = (clone $query)->select('jenis', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                   ->whereNotNull('jenis')
                                   ->where('jenis', '!=', '')
                                   ->groupBy('jenis')
                                   ->pluck('total', 'jenis')->toArray();
        
        $chartJenisData = [
            'labels' => array_keys($jenisStats),
            'data' => array_values($jenisStats)
        ];

        // Dropdown Options
        $listJenis = RiwayatPelatihan::whereNotNull('jenis')->where('jenis', '!=', '')->distinct()->pluck('jenis');
        $listMetode = RiwayatPelatihan::whereNotNull('metode')->where('metode', '!=', '')->distinct()->pluck('metode');

        $users = User::all();
        $marketings = User::where('role', 'marketing')->get();

        return view('riwayat-pelatihan', compact(
            'riwayat', 
            'totalSertifikatTerbit', 
            'totalSertifikatPending', 
            'totalPelatihan',
            'chartData',
            'chartJenisData',
            'listJenis',
            'listMetode',
            'users',
            'marketings'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'cv', 'modul', 'laporan_pic', 'scan_sertif', 'foto', 'bukti_kompeten']);

        // Handle file uploads
        $fileFields = ['cv', 'modul', 'laporan_pic', 'scan_sertif', 'foto', 'bukti_kompeten'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                // Save file to storage/app/public/riwayat_pelatihan
                $path = $file->store('riwayat_pelatihan', 'public');
                $data[$field] = $path;
            }
        }

        // Process array inputs for dynamic participant fields
        if (is_array($request->nama_peserta)) {
            $data['nama_peserta'] = json_encode(array_values($request->nama_peserta));
        }
        if (is_array($request->instansi_peserta)) {
            $data['instansi_peserta'] = json_encode(array_values($request->instansi_peserta));
        }
        if (is_array($request->wa_peserta)) {
            $data['wa_peserta'] = json_encode(array_values($request->wa_peserta));
        }
        if (is_array($request->marketing)) {
            $data['marketing'] = json_encode(array_values($request->marketing));
        }

        RiwayatPelatihan::create($data);

        return redirect()->route('riwayat.pelatihan')->with('success', 'Data Riwayat Pelatihan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $riwayat = RiwayatPelatihan::findOrFail($id);
        $data = $request->except(['_token', '_method', 'block']);

        // Handle file uploads if any
        $fileFields = ['cv', 'modul', 'laporan_pic', 'scan_sertif', 'foto', 'bukti_kompeten'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('uploads/riwayat_pelatihan', 'public');
                $data[$field] = $path;
            }
        }

        // Process array inputs for dynamic participant fields (if updating bulk)
        if ($request->has('nama_peserta') && is_array($request->nama_peserta)) {
            $data['nama_peserta'] = json_encode(array_values($request->nama_peserta));
            $data['jumlah_peserta'] = count($request->nama_peserta);
        }
        if ($request->has('instansi_peserta') && is_array($request->instansi_peserta)) {
            $data['instansi_peserta'] = json_encode(array_values($request->instansi_peserta));
        }
        if ($request->has('wa_peserta') && is_array($request->wa_peserta)) {
            $data['wa_peserta'] = json_encode(array_values($request->wa_peserta));
        }
        if ($request->has('marketing') && is_array($request->marketing)) {
            $data['marketing'] = json_encode(array_values($request->marketing));
        }

        $riwayat->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    private function getJsonArray($value)
    {
        if (empty($value)) return [];
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        // Fallback for old comma separated data
        return array_map('trim', explode(',', $value));
    }

    public function updatePeserta(Request $request, $id, $index)
    {
        $riwayat = RiwayatPelatihan::findOrFail($id);

        $pesertas = $this->getJsonArray($riwayat->nama_peserta);
        $instansis = $this->getJsonArray($riwayat->instansi_peserta);
        $was = $this->getJsonArray($riwayat->wa_peserta);
        $mkts = $this->getJsonArray($riwayat->marketing);

        // Pastikan index ada sebelum diupdate
        if (isset($pesertas[$index])) {
            $pesertas[$index] = $request->nama_peserta ?? '';
            
            // Untuk array lain jika ukurannya tidak sama, pad dengan string kosong sampai $index
            if (!isset($instansis[$index])) $instansis = array_pad($instansis, $index + 1, '');
            if (!isset($was[$index])) $was = array_pad($was, $index + 1, '');
            if (!isset($mkts[$index])) $mkts = array_pad($mkts, $index + 1, '');

            $instansis[$index] = $request->instansi_peserta ?? '';
            $was[$index] = $request->wa_peserta ?? '';
            $mkts[$index] = $request->marketing ?? '';

            // Update model & simpan
            $riwayat->nama_peserta = json_encode(array_values($pesertas));
            $riwayat->instansi_peserta = json_encode(array_values($instansis));
            $riwayat->wa_peserta = json_encode(array_values($was));
            $riwayat->marketing = json_encode(array_values($mkts));
            
            $riwayat->save();
        }

        return redirect()->back()->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function tambahPesertaMassal(Request $request, $id)
    {
        $riwayat = RiwayatPelatihan::findOrFail($id);

        $pesertas = $this->getJsonArray($riwayat->nama_peserta);
        $instansis = $this->getJsonArray($riwayat->instansi_peserta);
        $was = $this->getJsonArray($riwayat->wa_peserta);
        $mkts = $this->getJsonArray($riwayat->marketing);

        // Append new items
        if ($request->has('nama_peserta') && is_array($request->nama_peserta)) {
            foreach ($request->nama_peserta as $i => $nama) {
                if (trim($nama) === '') continue;
                
                $pesertas[] = trim($nama);
                $instansis[] = trim($request->instansi_peserta[$i] ?? '');
                $was[] = trim($request->wa_peserta[$i] ?? '');
                $mkts[] = trim($request->marketing[$i] ?? '');
            }
        }

        $riwayat->nama_peserta = json_encode(array_values($pesertas));
        $riwayat->instansi_peserta = json_encode(array_values($instansis));
        $riwayat->wa_peserta = json_encode(array_values($was));
        $riwayat->marketing = json_encode(array_values($mkts));
        
        // Update jumlah_peserta
        $riwayat->jumlah_peserta = count($pesertas);

        $riwayat->save();

        return redirect()->back()->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function hapusPeserta($id, $index)
    {
        $riwayat = RiwayatPelatihan::findOrFail($id);

        $pesertas = $this->getJsonArray($riwayat->nama_peserta);
        $instansis = $this->getJsonArray($riwayat->instansi_peserta);
        $was = $this->getJsonArray($riwayat->wa_peserta);
        $mkts = $this->getJsonArray($riwayat->marketing);

        // Hapus elemen jika index ada
        if (isset($pesertas[$index])) {
            unset($pesertas[$index]);
            
            if (isset($instansis[$index])) unset($instansis[$index]);
            if (isset($was[$index])) unset($was[$index]);
            if (isset($mkts[$index])) unset($mkts[$index]);

            // Re-index dan implode kembali
            $riwayat->nama_peserta = json_encode(array_values($pesertas));
            $riwayat->instansi_peserta = json_encode(array_values($instansis));
            $riwayat->wa_peserta = json_encode(array_values($was));
            $riwayat->marketing = json_encode(array_values($mkts));
            
            // Update jumlah_peserta
            $riwayat->jumlah_peserta = count($pesertas);

            $riwayat->save();
        }

        return redirect()->back()->with('success', 'Data peserta berhasil dihapus.');
    }
}

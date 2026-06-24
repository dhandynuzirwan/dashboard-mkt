<?php

namespace App\Http\Controllers;

use App\Models\ModulPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ModulPelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = ModulPelatihan::with('pengupload');

        // Filter berdasarkan Tab Sertifikasi
        if ($request->filled('sertifikasi')) {
            $query->where('sertifikasi', $request->sertifikasi);
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter Pengajar
        if ($request->filled('pengajar')) {
            $query->where('pengajar', 'like', '%' . $request->pengajar . '%');
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Search (Judul Modul)
        if ($request->filled('search')) {
            $query->where('judul_modul', 'like', '%' . $request->search . '%');
        }

        $moduls = $query->latest()->paginate(10)->withQueryString();

        // Stat Cards Data
        $totalModul = ModulPelatihan::count();
        $totalKemnaker = ModulPelatihan::where('sertifikasi', 'KEMNAKER')->count();
        $totalBnsp = ModulPelatihan::where('sertifikasi', 'BNSP')->count();
        $totalUpskills = ModulPelatihan::where('sertifikasi', 'UPSKILLS')->count();
        $modulBulanIni = ModulPelatihan::whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->count();
                            
        // Tambahan stat dari request user: Total Aktif, Nonaktif, Total Download, Total Ukuran
        $totalAktif = ModulPelatihan::where('status', 'Aktif')->count();
        $totalNonaktif = ModulPelatihan::where('status', 'Nonaktif')->count();
        $totalDownloadAll = ModulPelatihan::sum('total_download');
        $totalUkuranBytes = ModulPelatihan::sum('ukuran_file');
        // Convert to MB
        $totalUkuranMB = $totalUkuranBytes > 0 ? number_format($totalUkuranBytes / 1048576, 2) . ' MB' : '0 MB';

        // Aktivitas Terbaru (Log)
        $aktivitasTerbaru = ModulPelatihan::with('pengupload')->latest()->take(5)->get();

        // Pie Chart Data (Modul per Sertifikasi)
        $sertifikasiStats = ModulPelatihan::selectRaw('sertifikasi, count(*) as total')
            ->groupBy('sertifikasi')
            ->get();
        $pieLabels = $sertifikasiStats->pluck('sertifikasi');
        $pieData = $sertifikasiStats->pluck('total');

        // Untuk Dropdown Filter Dinamis
        $listKategori = ModulPelatihan::select('kategori')->distinct()->pluck('kategori');
        $listPengajar = ModulPelatihan::select('pengajar')->distinct()->pluck('pengajar');
        $listTahun = ModulPelatihan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('modul-pelatihan.index', compact(
            'moduls', 'totalModul', 'totalKemnaker', 'totalBnsp', 'totalUpskills', 'modulBulanIni',
            'totalAktif', 'totalNonaktif', 'totalDownloadAll', 'totalUkuranMB',
            'aktivitasTerbaru', 'pieLabels', 'pieData',
            'listKategori', 'listPengajar', 'listTahun'
        ));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah modul.');
        }

        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'sertifikasi' => 'required|in:KEMNAKER,BNSP,UPSKILLS',
            'kategori' => 'required|string|max:255',
            'pengajar' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'status' => 'required|in:Aktif,Nonaktif',
            'file_modul' => 'required|mimes:pdf|max:10240', // Max 10MB
        ], [
            'file_modul.max' => 'Ukuran file terlalu besar! Maksimal 10MB.',
            'file_modul.mimes' => 'Format file harus PDF.',
        ]);

        if ($request->hasFile('file_modul')) {
            $file = $request->file('file_modul');
            $size = $file->getSize();
            $path = $file->store('modul_pelatihan', 'public');

            ModulPelatihan::create([
                'judul_modul' => $request->judul_modul,
                'sertifikasi' => $request->sertifikasi,
                'kategori' => $request->kategori,
                'pengajar' => $request->pengajar,
                'tahun' => $request->tahun,
                'ukuran_file' => $size,
                'status' => $request->status,
                'file_path' => $path,
                'pengupload_id' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Modul berhasil ditambahkan!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function update(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit modul.');
        }

        $modul = ModulPelatihan::findOrFail($id);

        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'sertifikasi' => 'required|in:KEMNAKER,BNSP,UPSKILLS',
            'kategori' => 'required|string|max:255',
            'pengajar' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'status' => 'required|in:Aktif,Nonaktif',
            'file_modul' => 'nullable|mimes:pdf|max:10240',
        ], [
            'file_modul.max' => 'Ukuran file terlalu besar! Maksimal 10MB.',
            'file_modul.mimes' => 'Format file harus PDF.',
        ]);

        $data = [
            'judul_modul' => $request->judul_modul,
            'sertifikasi' => $request->sertifikasi,
            'kategori' => $request->kategori,
            'pengajar' => $request->pengajar,
            'tahun' => $request->tahun,
            'status' => $request->status,
        ];

        if ($request->hasFile('file_modul')) {
            // Hapus file lama jika ada
            if ($modul->file_path && Storage::disk('public')->exists($modul->file_path)) {
                Storage::disk('public')->delete($modul->file_path);
            }

            $file = $request->file('file_modul');
            $data['ukuran_file'] = $file->getSize();
            $data['file_path'] = $file->store('modul_pelatihan', 'public');
            // Jika ada update file, mungkin kita ingin update pengupload_id juga atau biarkan saja
            // $data['pengupload_id'] = auth()->id();
        }

        $modul->update($data);

        return redirect()->back()->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus modul.');
        }

        $modul = ModulPelatihan::findOrFail($id);

        if ($modul->file_path && Storage::disk('public')->exists($modul->file_path)) {
            Storage::disk('public')->delete($modul->file_path);
        }

        $modul->delete();

        return redirect()->back()->with('success', 'Modul berhasil dihapus!');
    }

    public function download($id)
    {
        $modul = ModulPelatihan::findOrFail($id);
        
        if ($modul->file_path && Storage::disk('public')->exists($modul->file_path)) {
            // Increment download count
            $modul->increment('total_download');
            
            return Storage::disk('public')->download($modul->file_path, $modul->judul_modul . '.pdf');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function preview($id)
    {
        $modul = ModulPelatihan::findOrFail($id);
        
        if ($modul->file_path && Storage::disk('public')->exists($modul->file_path)) {
            // Optional: increment download count on preview? Usually preview isn't a full download, but let's just show it.
            $path = storage_path('app/public/' . $modul->file_path);
            return response()->file($path);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}

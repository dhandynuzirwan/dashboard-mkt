<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermintaanVisualController extends Controller
{
    public function biasaIndex(Request $request)
    {
        $query = \App\Models\PermintaanBiasa::with(['user', 'pic'])->orderBy('created_at', 'desc');

        // Filter
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $permintaans = $query->get();

        // Stat Cards (Menunggu, Dalam Proses, Review, Selesai)
        $statMenunggu = \App\Models\PermintaanBiasa::where('status', 'Menunggu')->count();
        $statProses = \App\Models\PermintaanBiasa::where('status', 'Dalam Proses')->count();
        $statReview = \App\Models\PermintaanBiasa::where('status', 'Review')->count();
        $statSelesai = \App\Models\PermintaanBiasa::where('status', 'Selesai')->count();

        // Chart Data: Prioritas
        $prioritasTinggi = \App\Models\PermintaanBiasa::where('prioritas', 'Tinggi')->count();
        $prioritasSedang = \App\Models\PermintaanBiasa::where('prioritas', 'Sedang')->count();
        $prioritasRendah = \App\Models\PermintaanBiasa::where('prioritas', 'Rendah')->count();

        // Chart Data: History (Mingguan dalam bulan berjalan)
        $now = \Carbon\Carbon::now();
        $minggu1 = \App\Models\PermintaanBiasa::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', '<=', 7)->count();
        $minggu2 = \App\Models\PermintaanBiasa::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', '>', 7)->whereDay('created_at', '<=', 14)->count();
        $minggu3 = \App\Models\PermintaanBiasa::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', '>', 14)->whereDay('created_at', '<=', 21)->count();
        $minggu4 = \App\Models\PermintaanBiasa::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->whereDay('created_at', '>', 21)->count();

        $chartData = [
            'prioritas' => [$prioritasTinggi, $prioritasSedang, $prioritasRendah],
            'history' => [$minggu1, $minggu2, $minggu3, $minggu4]
        ];

        return view('operational.permintaan-visual.biasa.index', compact('permintaans', 'statMenunggu', 'statProses', 'statReview', 'statSelesai', 'chartData'));
    }

    public function biasaCreate()
    {
        return view('operational.permintaan-visual.biasa.create');
    }

    public function biasaStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deadline' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'referensi' => 'nullable|file|mimes:png,jpg,jpeg,pdf,ai,psd|max:20480',
            'catatan' => 'nullable|string'
        ]);

        // Hitung prioritas
        $deadline = \Carbon\Carbon::parse($request->deadline);
        $today = \Carbon\Carbon::now()->startOfDay();
        $diffDays = $today->diffInDays($deadline, false); // false = izinkan nilai negatif jika sudah lewat

        if ($diffDays <= 2) {
            $prioritas = 'Tinggi';
        } elseif ($diffDays >= 3 && $diffDays <= 6) {
            $prioritas = 'Sedang';
        } else {
            $prioritas = 'Rendah';
        }

        $referensi_file = null;
        if ($request->hasFile('referensi')) {
            $file = $request->file('referensi');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $referensi_file = $file->storeAs('permintaan_biasa/referensi', $filename, 'public');
        }

        \App\Models\PermintaanBiasa::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deadline' => $request->deadline,
            'tujuan' => $request->tujuan,
            'deskripsi' => $request->deskripsi,
            'referensi_file' => $referensi_file,
            'catatan' => $request->catatan,
            'prioritas' => $prioritas,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('operational.permintaan-visual.biasa')->with('success', 'Permintaan berhasil diajukan dengan prioritas ' . $prioritas . '.');
    }

    public function biasaUpdateStatus(Request $request, $id)
    {
        $permintaan = \App\Models\PermintaanBiasa::findOrFail($id);
        
        $request->validate([
            'status_update' => 'required|string',
            'catatan_revisi' => 'nullable|string'
        ]);

        $permintaan->status = $request->status_update;
        
        if ($request->status_update === 'Revisi' && $request->has('catatan_revisi')) {
            $permintaan->catatan = $request->catatan_revisi;
        }

        $permintaan->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function biasaUploadHasil(Request $request, $id)
    {
        $permintaan = \App\Models\PermintaanBiasa::findOrFail($id);
        
        $request->validate([
            'hasil_desain' => 'required|file|mimes:png,jpg,jpeg,pdf,ai,psd,zip,rar|max:51200' // 50MB max
        ]);

        if ($request->hasFile('hasil_desain')) {
            $file = $request->file('hasil_desain');
            $filename = time() . '_hasil_' . \Illuminate\Support\Str::slug($permintaan->judul) . '.' . $file->getClientOriginalExtension();
            $hasil_file = $file->storeAs('permintaan_biasa/hasil', $filename, 'public');
            
            $permintaan->hasil_file = $hasil_file;
            $permintaan->status = 'Review'; // otomatis pindah ke Review kalau upload
            $permintaan->save();
        }

        return redirect()->back()->with('success', 'File hasil desain berhasil diunggah.');
    }

    public function biasaEdit($id)
    {
        $permintaan = \App\Models\PermintaanBiasa::findOrFail($id);
        return view('operational.permintaan-visual.biasa.edit', compact('permintaan'));
    }

    public function biasaUpdate(Request $request, $id)
    {
        $permintaan = \App\Models\PermintaanBiasa::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deadline' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'referensi' => 'nullable|file|mimes:png,jpg,jpeg,pdf,ai,psd|max:20480'
        ]);

        // Hitung ulang prioritas
        $deadline = \Carbon\Carbon::parse($request->deadline);
        $today = \Carbon\Carbon::now()->startOfDay();
        $diffDays = $today->diffInDays($deadline, false);

        if ($diffDays <= 2) {
            $prioritas = 'Tinggi';
        } elseif ($diffDays >= 3 && $diffDays <= 6) {
            $prioritas = 'Sedang';
        } else {
            $prioritas = 'Rendah';
        }

        if ($request->hasFile('referensi')) {
            $file = $request->file('referensi');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $referensi_file = $file->storeAs('permintaan_biasa/referensi', $filename, 'public');
            $permintaan->referensi_file = $referensi_file;
        }

        $permintaan->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deadline' => $request->deadline,
            'tujuan' => $request->tujuan,
            'deskripsi' => $request->deskripsi,
            'prioritas' => $prioritas,
        ]);

        return redirect()->route('operational.permintaan-visual.biasa')->with('success', 'Permintaan berhasil diperbarui.');
    }

    public function biasaDestroy($id)
    {
        $permintaan = \App\Models\PermintaanBiasa::findOrFail($id);
        
        // Hapus file referensi jika ada
        if ($permintaan->referensi_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($permintaan->referensi_file);
        }
        
        // Hapus file hasil jika ada
        if ($permintaan->hasil_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($permintaan->hasil_file);
        }

        $permintaan->delete();

        return redirect()->route('operational.permintaan-visual.biasa')->with('success', 'Data permintaan berhasil dihapus secara permanen.');
    }

    public function trainingIndex(Request $request)
    {
        $now = \Carbon\Carbon::now();
        $query = \App\Models\PelatihanBerjalan::with(['training', 'permintaanTraining'])
            ->whereYear('tanggal_pelatihan', $now->year)
            ->whereMonth('tanggal_pelatihan', $now->month)
            ->orderBy('tanggal_pelatihan', 'asc');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('training', function($q) use ($request) {
                $q->where('nama_pelatihan', 'like', '%' . $request->search . '%');
            });
        }

        $pelatihans = $query->get();

        $statSelesai = 0;
        $statProses = 0;
        
        foreach($pelatihans as $pelatihan) {
            $permintaan = $pelatihan->permintaanTraining;
            if ($permintaan) {
                if ($permintaan->status == 'Selesai') {
                    $statSelesai++;
                } else {
                    $statProses++;
                }
            } else {
                $statProses++; // Default if not fully uploaded
            }
        }
        $statTotal = $pelatihans->count();

        return view('operational.permintaan-visual.training.index', compact('pelatihans', 'statTotal', 'statSelesai', 'statProses'));
    }

    public function trainingUpload(Request $request, $id)
    {
        $pelatihan = \App\Models\PelatihanBerjalan::findOrFail($id);
        
        // Find or create PermintaanTraining record
        $permintaan = \App\Models\PermintaanTraining::firstOrCreate(
            ['pelatihan_berjalan_id' => $pelatihan->id],
            ['status' => 'Menunggu']
        );

        $berkasList = [
            'background_zoom' => 'background_zoom_file',
            'banner_kegiatan' => 'banner_kegiatan_file',
            'photo_profil_grup_wa' => 'photo_profil_grup_wa_file',
            'table_name' => 'table_name_file',
            'lanyard' => 'lanyard_file',
            'sertifikat_internal' => 'sertifikat_internal_file',
            'rekap_foto' => 'rekap_foto_file',
            'rekap_video' => 'rekap_video_file',
            'lainnya' => 'lainnya_file'
        ];

        foreach ($berkasList as $inputName => $dbColumn) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = time() . '_' . $inputName . '_' . $pelatihan->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('permintaan_training/' . $pelatihan->id, $filename, 'public');
                
                // Hapus file lama jika ada
                if ($permintaan->$dbColumn) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($permintaan->$dbColumn);
                }

                $permintaan->$dbColumn = $path;
            }
        }
        
        // Update status based on completion
        $uploadedCount = 0;
        foreach ($berkasList as $dbColumn) {
            if (!empty($permintaan->$dbColumn)) {
                $uploadedCount++;
            }
        }

        if ($uploadedCount >= 9) {
            $permintaan->status = 'Selesai';
        } elseif ($uploadedCount > 0) {
            $permintaan->status = 'Dalam Proses';
        } else {
            $permintaan->status = 'Menunggu';
        }

        $permintaan->user_id = \Illuminate\Support\Facades\Auth::id();
        $permintaan->save();

        return redirect()->back()->with('success', 'Berkas visual berhasil diperbarui.');
    }
}

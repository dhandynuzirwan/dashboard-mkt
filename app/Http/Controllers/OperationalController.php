<?php

namespace App\Http\Controllers;

use App\Models\ResourceLink; // Pastikan model di-import
use App\Models\KontakPenting; // Import model baru
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OperationalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            (new Middleware(function ($request, $next) {
                if (!in_array(auth()->user()->email, ['pic1@arsatraining.com', 'pic2@arsatraining.com'])) {
                    abort(403, 'Akses ditolak. Menu ini khusus PIC Portal Back Office.');
                }
                return $next($request);
            }))->only(['index', 'storeResource', 'updateResource', 'destroyResource', 'storeKontak', 'destroyKontak']),
        ];
    }

    // 1. Menampilkan Halaman Utama (Index)
    public function index(Request $request)
    {
        // --- Logika untuk Resource Links (Dokumen) ---
        $queryLinks = ResourceLink::query();
        
        if ($request->filled('search')) {
            $queryLinks->where('nama_dokumen', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->filled('kategori') && $request->kategori != 'all') {
            $queryLinks->where('kategori', $request->kategori);
        }
        
        $resource_links = $queryLinks->latest()->get();

        // --- Logika untuk Kontak Penting ---
        $kontaks = KontakPenting::latest()->get();

        // Mengirim kedua data tersebut ke view 'operational' (atau nama view kamu)
        return view('operational', compact('resource_links', 'kontaks'));
    }
    
    // 2. Fungsi Simpan Kontak Baru
    public function storeKontak(Request $request)
    {
        $request->validate([
            'kategori'      => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'nama_pic'      => 'required|string|max:255',
            'nomor_wa'      => 'required|string|max:20',
        ]);

        KontakPenting::create([
            'kategori'      => $request->kategori,
            'nama_instansi' => $request->nama_instansi,
            'nama_pic'      => $request->nama_pic,
            'nomor_wa'      => $request->nomor_wa,
        ]);

        return back()->with('success', 'Kontak penting berhasil ditambahkan!');
    }

    // 3. Fungsi Hapus Kontak
    public function destroyKontak($id)
    {
        $kontak = KontakPenting::findOrFail($id);
        $kontak->delete();

        return back()->with('success', 'Kontak berhasil dihapus!');
    }

    // Memproses form tambah link kerja
    public function storeResource(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'url_link' => 'required|url',
            'kategori' => 'required|in:spreadsheet,document,folder,other'
        ]);

        ResourceLink::create([
            'nama_dokumen' => $request->nama_dokumen,
            'url_link' => $request->url_link,
            'kategori' => $request->kategori,
        ]);

        // Redirect kembali ke halaman operational dengan pesan sukses
        return redirect()->route('operational')->with('success', 'Resource Link berhasil ditambahkan!');
    }
    
    // Memproses update link (EDIT)
    public function updateResource(Request $request, $id)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'url_link' => 'required|url',
            'kategori' => 'required|in:spreadsheet,document,folder,other'
        ]);

        $link = ResourceLink::findOrFail($id);
        
        $link->update([
            'nama_dokumen' => $request->nama_dokumen,
            'url_link' => $request->url_link,
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Resource Link berhasil diperbarui!');
    }

    // Memproses hapus link (DELETE)
    public function destroyResource($id)
    {
        $link = ResourceLink::findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', 'Resource Link berhasil dihapus!');
    }

    // Menampilkan Halaman Monitoring Pelatihan
    public function monitoringPelatihan()
    {
        $pelatihans = \App\Models\PelatihanBerjalan::with([
            'training', 
            'riwayat',
            'pendaftaranPribadis.cta.prospek.marketing',
            'pendaftaranPribadis.kolektif.cta.prospek.marketing'
        ])
            ->orderBy('tanggal_pelatihan', 'desc')
            ->get();
            
        $users = \App\Models\User::all();
            
        return view('operational.monitoring-pelatihan', compact('pelatihans', 'users'));
    }

    // Menampilkan Halaman Monitoring Pelatihan TV (Display Monitor)
    public function monitorTv()
    {
        return view('operational.monitor-tv');
    }

    // JSON API untuk TV Monitor
    public function monitorTvData()
    {
        $pelatihans = \App\Models\PelatihanBerjalan::with([
            'training', 
            'pendaftaranPribadis.cta.prospek.marketing',
            'pendaftaranPribadis.kolektif.cta.prospek.marketing'
        ])
        ->whereIn('status_kelas', ['persiapan', 'running'])
        ->orderBy('tanggal_pelatihan', 'asc')
        ->get();

        $data = $pelatihans->map(function ($pelatihan) {
            $firstPendaftaran = $pelatihan->pendaftaranPribadis->first();
            $sertifikasi = 'Lainnya';
            if ($firstPendaftaran) {
                if ($firstPendaftaran->tipe_pendaftaran == 'kolektif' && $firstPendaftaran->kolektif && $firstPendaftaran->kolektif->cta) {
                    $sertifikasi = strtoupper($firstPendaftaran->kolektif->cta->sertifikasi);
                } else if ($firstPendaftaran->cta) {
                    $sertifikasi = strtoupper($firstPendaftaran->cta->sertifikasi);
                }
            }

            $checklist = json_decode($pelatihan->checklist_validasi, true) ?? [];
            $progress = count($checklist);
            // Asumsi 21 item total, sesuaikan jika beda
            $percent = $progress > 0 ? round(($progress / 21) * 100) : 0;

            return [
                'id' => $pelatihan->id,
                'judul' => optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan',
                'sertifikasi' => $sertifikasi,
                'tanggal_pelatihan' => $pelatihan->tanggal_pelatihan ? \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->translatedFormat('d M Y') : '-',
                'tanggal_selesai' => $pelatihan->tanggal_selesai ? \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d M Y') : null,
                'lokasi' => $pelatihan->lokasi ?? 'Belum Diset',
                'pic_operasional' => $pelatihan->pic_operasional ?? '-',
                'instruktur' => $pelatihan->instruktur ?? '-',
                'asesor' => $pelatihan->asesor ?? '-',
                'status_kelas' => $pelatihan->status_kelas,
                'progress_persen' => min(100, $percent),
                'progress_count' => $progress
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'waktu' => now()->format('d M Y H:i:s'),
        ]);
    }

    // Update Data Pelatihan Berjalan
    public function updatePelatihanBerjalan(Request $request, $id)
    {
        $pelatihan = \App\Models\PelatihanBerjalan::findOrFail($id);
        
        $request->validate([
            'tanggal_pelatihan' => 'sometimes|required|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_pelatihan',
            'tanggal_asesmen'   => 'nullable|date',
            'lokasi'            => 'nullable|string',
            'instruktur'        => 'nullable|string',
            'wa_trainer'        => 'nullable|string',
            'asesor'            => 'nullable|string',
            'pengawas'          => 'nullable|string',
            'pjk3'              => 'nullable|string',
            'pic_klien'         => 'nullable|string',
            'pic_operasional'   => 'nullable|string',
            'status_kelas'      => 'sometimes|required|in:persiapan,running,selesai,batal',
        ]);
        
        $data = $request->except(['_token', '_method']);

        // Handle File Uploads
        $fileFields = [
            'file_laporan_internal',
            'file_laporan_kemnaker',
            'file_scan_sertifikat',
            'foto_resi',
            'foto_tanda_terima',
            'background_zoom',
            'modul',
            'rundown_pelatihan'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/operasional'), $filename);
                $data[$field] = 'uploads/operasional/' . $filename;
            }
        }

        if (isset($data['checklist_validasi']) && is_array($data['checklist_validasi'])) {
            $data['checklist_validasi'] = json_encode($data['checklist_validasi']);
        }

        $pelatihan->update($data);
        
        // Trigger 2-Way Sync
        $pesertas = $pelatihan->pendaftaranPribadis()->with('cta.prospek.marketing')->get();
        $nama_peserta = [];
        $instansi_peserta = [];
        $wa_peserta = [];
        $marketing = [];

        foreach ($pesertas as $peserta) {
            $nama_peserta[] = $peserta->nama_lengkap;
            $instansi_peserta[] = $peserta->perusahaan ?? 'Pribadi';
            $wa_peserta[] = $peserta->no_wa;
            $marketing[] = ($peserta->cta && $peserta->cta->prospek && $peserta->cta->prospek->marketing) 
                            ? $peserta->cta->prospek->marketing->name 
                            : '-';
        }

        $riwayatData = [
            'judul_pelatihan' => $pelatihan->training->nama_training ?? null,
            'metode' => $pelatihan->lokasi ?? null,
            'tanggal_mulai' => $pelatihan->tanggal_pelatihan,
            'tanggal_selesai' => $pelatihan->tanggal_selesai,
            'tanggal_asesmen' => $pelatihan->tanggal_asesmen,
            'nama_trainer' => $pelatihan->instruktur,
            'wa_trainer' => $pelatihan->wa_trainer,
            'cv' => $pelatihan->cv,
            'modul' => $pelatihan->modul,
            'nama_asesor' => $pelatihan->asesor,
            'wa_asesor' => $pelatihan->wa_asesor,
            'nama_lsp' => $pelatihan->pjk3,
            'kontak_lsp' => $pelatihan->kontak_lsp,
            'pic' => $pelatihan->pic_operasional,
            'status_sertif' => $pelatihan->status_sertifikat ?? 'Belum Terbit',
            'scan_sertif' => $pelatihan->file_scan_sertifikat,
            'nama_penerima' => $pelatihan->nama_penerima,
            'wa_penerima' => $pelatihan->wa_penerima,
            'isi_paket' => $pelatihan->isi_paket,
            'alamat_pengiriman' => $pelatihan->alamat_pengiriman,
            'tanggal_kirim' => $pelatihan->tanggal_kirim,
            'no_resi' => $pelatihan->resi_pengiriman,
            'status_pengiriman' => $pelatihan->status_pengiriman,
            'tanggal_diterima' => $pelatihan->tanggal_diterima,
            'foto' => $pelatihan->foto_tanda_terima ?? $pelatihan->foto_resi,
            'catatan' => $pelatihan->catatan_pengiriman,
            'keterangan_tambahan' => $pelatihan->keterangan_tambahan,
            'pelatihan_berjalan_id' => $pelatihan->id,
        ];

        // Only override participants if this was originally from Registration Flow,
        // to avoid overwriting manually synced JSON participants from Riwayat.
        if ($pesertas->count() > 0 || !$pelatihan->riwayat_pelatihan_id) {
            $riwayatData['jumlah_peserta'] = $pesertas->count();
            $riwayatData['nama_peserta'] = json_encode($nama_peserta);
            $riwayatData['instansi_peserta'] = json_encode($instansi_peserta);
            $riwayatData['wa_peserta'] = json_encode($wa_peserta);
            $riwayatData['marketing'] = json_encode($marketing);
        }

        if ($pelatihan->riwayat_pelatihan_id) {
            \App\Models\RiwayatPelatihan::where('id', $pelatihan->riwayat_pelatihan_id)->update($riwayatData);
        } else {
            $riwayat = \App\Models\RiwayatPelatihan::where('pelatihan_berjalan_id', $pelatihan->id)->first();
            if ($riwayat) {
                $riwayat->update($riwayatData);
                if (!$pelatihan->riwayat_pelatihan_id) {
                    $pelatihan->updateQuietly(['riwayat_pelatihan_id' => $riwayat->id]);
                }
            } else {
                $newRiwayat = \App\Models\RiwayatPelatihan::create($riwayatData);
                $pelatihan->updateQuietly(['riwayat_pelatihan_id' => $newRiwayat->id]);
            }
        }
        
        return redirect()->back()->with('success', 'Data Pelatihan Berjalan berhasil diperbarui!');
    }

    public function destroyPelatihanBerjalan($id)
    {
        $pelatihan = \App\Models\PelatihanBerjalan::findOrFail($id);
        
        // Cek jika masih ada peserta yang terkait dengan pelatihan berjalan ini
        if ($pelatihan->pendaftaranPribadis()->count() > 0) {
            // Bisa dilepas kaitan atau dihapus pelatihannya tergantung aturan bisnis
            // Disini asumsikan kita null-kan pelatihan_berjalan_id di pesertanya
            $pelatihan->pendaftaranPribadis()->update(['pelatihan_berjalan_id' => null]);
        }

        $pelatihan->delete();

        return redirect()->back()->with('success', 'Data Pelatihan Berjalan berhasil dihapus.');
    }
}
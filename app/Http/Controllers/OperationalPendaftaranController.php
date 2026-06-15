<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\PendaftaranPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Pastikan Carbon di-import

class OperationalPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // TAB 1: DATA PROSPEK DEAL (Tracking)
        // ==========================================
        $queryDeals = Cta::with(['prospek.marketing'])->where('status_penawaran', 'deal');
        
        // 1. Filter Pencarian Teks
        if ($request->filled('search_tracking')) {
            $search = $request->search_tracking;
            $queryDeals->whereHas('prospek', function($q) use ($search) {
                $q->where('perusahaan', 'like', '%'.$search.'%')
                  ->orWhere('pic', 'like', '%'.$search.'%');
            });
        }

        // 2. 🔥 PERBAIKAN: Filter Status Kelengkapan (Pakai Subquery SQL)
        if ($request->filled('status_tracking')) {
            if ($request->status_tracking == 'lengkap') {
                // Cari yang jumlah pendaftar (cta_id) >= target peserta
                $queryDeals->whereRaw('(SELECT COUNT(*) FROM pendaftaran_pribadis WHERE pendaftaran_pribadis.cta_id = ctas.id) >= IFNULL(ctas.jumlah_peserta, 1)');
            } elseif ($request->status_tracking == 'kurang') {
                // Cari yang jumlah pendaftar (cta_id) < target peserta
                $queryDeals->whereRaw('(SELECT COUNT(*) FROM pendaftaran_pribadis WHERE pendaftaran_pribadis.cta_id = ctas.id) < IFNULL(ctas.jumlah_peserta, 1)');
            }
        }

        // 3. 🔥 PERBAIKAN: Filter Tanggal (Default: Bulan Ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $queryDeals->whereDate('created_at', '>=', $startDate)
                   ->whereDate('created_at', '<=', $endDate);

        $deals = $queryDeals->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_deal')->withQueryString();

        // 4. 🔥 KALKULASI PROGRESS BAR (WAJIB ADA)
        $deals->getCollection()->transform(function ($deal) {
            $deal->target_peserta = $deal->jumlah_peserta ?? 1;
            $deal->terdaftar = \App\Models\PendaftaranPribadi::where('cta_id', $deal->id)->count();
            $deal->kurang = max(0, $deal->target_peserta - $deal->terdaftar);
            $deal->is_lengkap = $deal->terdaftar >= $deal->target_peserta;

            $persentase = ($deal->target_peserta > 0) ? round(($deal->terdaftar / $deal->target_peserta) * 100) : 0;
            $deal->persentase = $persentase > 100 ? 100 : $persentase;

            return $deal;
        });

        // ==========================================
        // TAB 2: DATA PENDAFTARAN PRIBADI (Verifikasi)
        // ==========================================
        $queryPendaftar = PendaftaranPribadi::with('training');

        if ($request->filled('search')) {
            $searchTab2 = $request->search;
            $queryPendaftar->where(function($q) use ($searchTab2) {
                $q->where('nama_lengkap', 'like', '%'.$searchTab2.'%')
                  ->orWhere('id_pendaftaran', 'like', '%'.$searchTab2.'%');
            });
        }
        if ($request->filled('status')) {
            $queryPendaftar->where('status', $request->status);
        }
        
        $pendaftarans = $queryPendaftar->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_verifikasi')->withQueryString();

        // Statistik
        $stats = [
            'total_pendaftar' => PendaftaranPribadi::count(),
            'menunggu'        => PendaftaranPribadi::where('status', 'pending')->count(),
            'revisi'          => PendaftaranPribadi::where('status', 'revisi')->count(),
            'disetujui'       => PendaftaranPribadi::where('status', 'diterima')->count(),
        ];

        // 🔥 Kirim startDate dan endDate ke view agar tanggal default muncul di form
        return view('operational.data-pendaftaran', compact('deals', 'pendaftarans', 'stats', 'startDate', 'endDate'));
    }

    public function verify(Request $request, $id)
    {
        $pendaftaran = PendaftaranPribadi::findOrFail($id);

        // Ambil semua status yang dikirim form
        $updates = [
            'status_ktp'      => $request->status_ktp,
            'catatan_ktp'     => $request->status_ktp == 'reject' ? $request->catatan_ktp : null,
            'status_ijazah'   => $request->status_ijazah,
            'catatan_ijazah'  => $request->status_ijazah == 'reject' ? $request->catatan_ijazah : null,
            'status_foto'     => $request->status_foto,
            'catatan_foto'    => $request->status_foto == 'reject' ? $request->catatan_foto : null,
            'status_cv'       => $request->status_cv,
            'catatan_cv'      => $request->status_cv == 'reject' ? $request->catatan_cv : null,
            'status_sk'       => $request->status_sk,
            'catatan_sk'      => $request->status_sk == 'reject' ? $request->catatan_sk : null,
            'status_laporan'  => $request->status_laporan,
            'catatan_laporan' => $request->status_laporan == 'reject' ? $request->catatan_laporan : null,
            'status_sop'      => $request->status_sop,
            'catatan_sop'     => $request->status_sop == 'reject' ? $request->catatan_sop : null,
        ];

        // LOGIKA PENENTUAN STATUS UTAMA
        $semuaStatus = [
            $request->status_ktp, $request->status_ijazah, $request->status_foto, 
            $request->status_cv, $request->status_sk, $request->status_laporan, $request->status_sop
        ];

        if (in_array('reject', $semuaStatus)) {
            $updates['status'] = 'revisi';
        } elseif (in_array('pending', $semuaStatus)) {
            $updates['status'] = 'pending';
        } else {
            // Jika tidak ada reject dan pending, berarti approve semua
            $updates['status'] = 'diterima'; 
        }

        // Tanggal Pelatihan & Auto-Create PelatihanBerjalan
        if ($request->filled('tanggal_pelatihan')) {
            $updates['tanggal_pelatihan'] = $request->tanggal_pelatihan;
            
            // Cek apakah ada PelatihanBerjalan dengan training & tanggal yang sama
            $pelatihanBerjalan = \App\Models\PelatihanBerjalan::firstOrCreate(
                [
                    'master_training_id' => $pendaftaran->master_training_id,
                    'tanggal_pelatihan' => $request->tanggal_pelatihan,
                ],
                [
                    'status_kelas' => 'persiapan'
                ]
            );

            $updates['pelatihan_berjalan_id'] = $pelatihanBerjalan->id;
        }

        $pendaftaran->update($updates);

        return redirect()->back()->with('success', 'Verifikasi berkas atas nama '.$pendaftaran->nama_lengkap.' berhasil disimpan.');
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranPribadi::findOrFail($id);
        
        // Hapus file-file terkait jika ada
        $files = ['file_ktp', 'file_ijazah', 'file_foto', 'file_cv', 'file_sk', 'file_laporan', 'file_sop'];
        foreach ($files as $fileKey) {
            if ($pendaftaran->$fileKey) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pendaftaran->$fileKey);
            }
        }

        $nama = $pendaftaran->nama_lengkap;
        $pendaftaran->delete();

        return redirect()->back()->with('success', "Data pendaftaran atas nama $nama berhasil dihapus.");
    }
}
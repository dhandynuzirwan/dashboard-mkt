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
        $queryDeals = \App\Models\Prospek::with(['marketing', 'ctas' => function($q) {
            $q->where('status_penawaran', 'deal');
        }])->whereHas('ctas', function($q) {
            $q->where('status_penawaran', 'deal');
        });
        
        // 1. Filter Pencarian Teks
        if ($request->filled('search_tracking')) {
            $search = $request->search_tracking;
            $queryDeals->where(function($q) use ($search) {
                $q->where('perusahaan', 'like', '%'.$search.'%')
                  ->orWhere('pic', 'like', '%'.$search.'%');
            });
        }

        // 2. 🔥 PERBAIKAN: Filter Status Kelengkapan (Pakai Subquery SQL)
        if ($request->filled('status_tracking')) {
            if ($request->status_tracking == 'lengkap') {
                $queryDeals->whereRaw('(SELECT COUNT(*) FROM pendaftaran_pribadis WHERE pendaftaran_pribadis.cta_id IN (SELECT id FROM ctas WHERE ctas.prospek_id = prospeks.id AND ctas.status_penawaran = "deal")) >= (SELECT SUM(IFNULL(jumlah_peserta, 1)) FROM ctas WHERE ctas.prospek_id = prospeks.id AND ctas.status_penawaran = "deal")');
            } elseif ($request->status_tracking == 'kurang') {
                $queryDeals->whereRaw('(SELECT COUNT(*) FROM pendaftaran_pribadis WHERE pendaftaran_pribadis.cta_id IN (SELECT id FROM ctas WHERE ctas.prospek_id = prospeks.id AND ctas.status_penawaran = "deal")) < (SELECT SUM(IFNULL(jumlah_peserta, 1)) FROM ctas WHERE ctas.prospek_id = prospeks.id AND ctas.status_penawaran = "deal")');
            }
        }

        // 3. 🔥 PERBAIKAN: Filter Tanggal (Default: Bulan Ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $queryDeals->whereDate('tanggal_prospek', '>=', $startDate)
                   ->whereDate('tanggal_prospek', '<=', $endDate);

        $deals = $queryDeals->orderBy('tanggal_prospek', 'desc')->paginate(10, ['*'], 'page_deal')->withQueryString();

        // 4. 🔥 KALKULASI PROGRESS BAR (WAJIB ADA)
        $deals->getCollection()->transform(function ($prospek) {
            // Karena satu prospek bisa punya lebih dari 1 CTA Deal
            $prospek->target_peserta = $prospek->ctas->sum('jumlah_peserta') ?: 1;
            
            $ctaIds = $prospek->ctas->pluck('id')->toArray();
            $prospek->terdaftar = \App\Models\PendaftaranPribadi::whereIn('cta_id', $ctaIds)->count();
            
            $prospek->kurang = max(0, $prospek->target_peserta - $prospek->terdaftar);
            $prospek->is_lengkap = $prospek->terdaftar >= $prospek->target_peserta;

            $persentase = ($prospek->target_peserta > 0) ? round(($prospek->terdaftar / $prospek->target_peserta) * 100) : 0;
            $prospek->persentase = $persentase > 100 ? 100 : $persentase;
            
            // Ambil CTA pertama sebagai perwakilan untuk link kolektif/detail CTA
            $firstCta = $prospek->ctas->first();
            $prospek->first_cta_id = $firstCta ? $firstCta->id : null;
            $prospek->judul_permintaan = $firstCta ? $firstCta->judul_permintaan : null;

            return $prospek;
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
        
        // Filter Tanggal (Default: Bulan Ini)
        $startDateVerifikasi = $request->input('start_date_verifikasi', Carbon::now()->startOfMonth()->toDateString());
        $endDateVerifikasi = $request->input('end_date_verifikasi', Carbon::now()->endOfMonth()->toDateString());

        $queryPendaftar->whereDate('created_at', '>=', $startDateVerifikasi)
                       ->whereDate('created_at', '<=', $endDateVerifikasi);

        $pendaftarans = $queryPendaftar->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_verifikasi')->withQueryString();

        // Statistik (difilter berdasarkan tanggal yang dipilih)
        $baseStatsQuery = PendaftaranPribadi::whereDate('created_at', '>=', $startDateVerifikasi)
                                            ->whereDate('created_at', '<=', $endDateVerifikasi);

        $stats = [
            'total_pendaftar' => (clone $baseStatsQuery)->count(),
            'menunggu'        => (clone $baseStatsQuery)->where('status', 'pending')->count(),
            'revisi'          => (clone $baseStatsQuery)->where('status', 'revisi')->count(),
            'disetujui'       => (clone $baseStatsQuery)->where('status', 'diterima')->count(),
        ];

        // 🔥 Kirim startDate dan endDate ke view agar tanggal default muncul di form
        return view('operational.data-pendaftaran', compact('deals', 'pendaftarans', 'stats', 'startDate', 'endDate', 'startDateVerifikasi', 'endDateVerifikasi'));
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
            $request->status_cv
        ];

        if ($pendaftaran->file_sk) $semuaStatus[] = $request->status_sk;
        if ($pendaftaran->file_laporan) $semuaStatus[] = $request->status_laporan;
        if ($pendaftaran->file_sop) $semuaStatus[] = $request->status_sop;

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
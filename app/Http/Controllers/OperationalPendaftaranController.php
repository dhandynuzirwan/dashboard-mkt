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
        // Tandai notifikasi sudah dibaca saat membuka halaman ini
        if (auth()->check()) {
            auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewDealNotification')->markAsRead();
        }

        // ==========================================
        // TAB 1: DATA PROSPEK DEAL (Tracking)
        // ==========================================
        $queryDeals = \App\Models\Prospek::with(['marketing', 'ctas' => function($q) {
            $q->where('status_penawaran', 'deal');
        }])->whereHas('ctas', function($q) {
            $q->where('status_penawaran', 'deal');
        });
        
        // 1. Filter Pencarian Teks (Unified)
        if ($request->filled('search')) {
            $search = $request->search;
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
            $search = $request->search;
            $queryPendaftar->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%'.$search.'%')
                  ->orWhere('id_pendaftaran', 'like', '%'.$search.'%');
            });
        }
        if ($request->filled('status')) {
            $queryPendaftar->where('status', $request->status);
        }
        
        if ($request->filled('jalur')) {
            $queryPendaftar->where('tipe_pendaftaran', $request->jalur);
        }
        
        // Filter Tanggal (Unified, default: Bulan Ini)
        $queryPendaftar->whereDate('created_at', '>=', $startDate)
                       ->whereDate('created_at', '<=', $endDate);

        $pendaftarans = $queryPendaftar->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_verifikasi')->withQueryString();

        // Statistik (difilter berdasarkan tanggal yang dipilih)
        $baseStatsQuery = PendaftaranPribadi::whereDate('created_at', '>=', $startDate)
                                            ->whereDate('created_at', '<=', $endDate);

        $stats = [
            'total_pendaftar' => (clone $baseStatsQuery)->count(),
            'menunggu'        => (clone $baseStatsQuery)->where('status', 'pending')->count(),
            'revisi'          => (clone $baseStatsQuery)->where('status', 'revisi')->count(),
            'disetujui'       => (clone $baseStatsQuery)->where('status', 'diterima')->count(),
        ];

        return view('operational.data-pendaftaran', compact('deals', 'pendaftarans', 'stats', 'startDate', 'endDate'));
    }

    public function verify(Request $request, $id)
    {
        $pendaftaran = PendaftaranPribadi::findOrFail($id);

        // Gunakan nilai dari request, jika null (karena field disabled), gunakan nilai dari database
        $statusKtp = $request->status_ktp ?? $pendaftaran->status_ktp;
        $statusIjazah = $request->status_ijazah ?? $pendaftaran->status_ijazah;
        $statusFoto = $request->status_foto ?? $pendaftaran->status_foto;
        $statusCv = $request->status_cv ?? $pendaftaran->status_cv;
        $statusSk = $request->status_sk ?? $pendaftaran->status_sk;
        $statusLaporan = $request->status_laporan ?? $pendaftaran->status_laporan;
        $statusSop = $request->status_sop ?? $pendaftaran->status_sop;

        $updates = [
            'status_ktp'      => $statusKtp,
            'catatan_ktp'     => $statusKtp == 'reject' ? $request->catatan_ktp : null,
            'status_ijazah'   => $statusIjazah,
            'catatan_ijazah'  => $statusIjazah == 'reject' ? $request->catatan_ijazah : null,
            'status_foto'     => $statusFoto,
            'catatan_foto'    => $statusFoto == 'reject' ? $request->catatan_foto : null,
            'status_cv'       => $statusCv,
            'catatan_cv'      => $statusCv == 'reject' ? $request->catatan_cv : null,
            'status_sk'       => $statusSk,
            'catatan_sk'      => $statusSk == 'reject' ? $request->catatan_sk : null,
            'status_laporan'  => $statusLaporan,
            'catatan_laporan' => $statusLaporan == 'reject' ? $request->catatan_laporan : null,
            'status_sop'      => $statusSop,
            'catatan_sop'     => $statusSop == 'reject' ? $request->catatan_sop : null,
        ];

        // LOGIKA PENENTUAN STATUS UTAMA
        $semuaStatus = [
            $statusKtp, $statusIjazah, $statusFoto, $statusCv
        ];

        if ($pendaftaran->file_sk) $semuaStatus[] = $statusSk;
        if ($pendaftaran->file_laporan) $semuaStatus[] = $statusLaporan;
        if ($pendaftaran->file_sop) $semuaStatus[] = $statusSop;

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
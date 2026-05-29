<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\PendaftaranPribadi;
use Illuminate\Http\Request;

class OperationalPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // TAB 1: DATA PROSPEK DEAL (Tracking)
        // ==========================================
        $queryDeals = Cta::with(['prospek.marketing'])->where('status_penawaran', 'deal');
        
        // Filter Tab 1
        if ($request->filled('search_tracking')) {
            $queryDeals->whereHas('prospek', function($q) use ($request) {
                $q->where('perusahaan', 'like', '%'.$request->search_tracking.'%')
                  ->orWhere('pic', 'like', '%'.$request->search_tracking.'%');
            });
        }
        $deals = $queryDeals->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_deal')->withQueryString();

        // ==========================================
        // TAB 2: DATA PENDAFTARAN PRIBADI (Verifikasi)
        // ==========================================
        $queryPendaftar = PendaftaranPribadi::with('training');

        // Filter Tab 2
        if ($request->filled('search')) {
            $queryPendaftar->where('nama_lengkap', 'like', '%'.$request->search.'%')
                           ->orWhere('id_pendaftaran', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $queryPendaftar->where('status', $request->status); // pending, revisi, diterima
        }
        $pendaftarans = $queryPendaftar->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_verifikasi')->withQueryString();

        // Hitung statistik untuk cards atas
        $stats = [
            'total_pendaftar' => $pendaftarans->count(),
            'menunggu'        => $pendaftarans->where('status', 'pending')->count(),
            'revisi'          => $pendaftarans->where('status', 'revisi')->count(),
            'disetujui'       => $pendaftarans->where('status', 'diterima')->count(),
        ];

        return view('operational.data-pendaftaran', compact('deals', 'pendaftarans', 'stats'));
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

        $pendaftaran->update($updates);

        return redirect()->back()->with('success', 'Verifikasi berkas atas nama '.$pendaftaran->nama_lengkap.' berhasil disimpan.');
    }
}
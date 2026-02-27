<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspekController extends Controller
{
    // Menampilkan Pipeline (Hasil Data)
    public function index(Request $request)
    {
        $user = auth()->user();
        $marketings = User::where('role', 'marketing')->get();

        // 1. Buat Query Dasar untuk Filter
        $query = Prospek::with(['marketing', 'cta']);

        if ($user->role === 'marketing') {
            $query->where('marketing_id', $user->id);
        }

        // ================= APPLY FILTER =================
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_prospek', [$request->start_date, $request->end_date]);
        }

        if ($request->cta_status) {
            if ($request->cta_status == 'pending') {
                $query->whereDoesntHave('cta');
            } elseif ($request->cta_status == 'done') {
                $query->whereHas('cta');
            }
        }

        if ($request->marketing_id && $user->role !== 'marketing') {
            $query->where('marketing_id', $request->marketing_id);
        }

        if ($request->status) {
            $query->whereHas('cta', function ($q) use ($request) {
                $q->where('status_penawaran', $request->status);
            });
        }

        // 2. HITUNG STATS DARI KESELURUHAN DATA (Sebelum Paginate)
        // Kita clone query agar tidak merusak query utama untuk tabel
        $statsData = (clone $query)->get(); 

        $stats = [
            'total_prospek' => $statsData->count(),
            'total_cta'     => $statsData->whereNotNull('cta')->count(),
            'total_nilai'   => $statsData->sum(fn($item) => $item->cta->harga_penawaran ?? 0),
            'total_deal'    => $statsData->filter(fn($item) => 
                                optional($item->cta)->status_penawaran == 'deal'
                            )->count(),
        ];

        // 3. PAGINATION INDEPENDEN
        // Tabel Pipeline (Semua data sesuai filter)
        $prospeks = (clone $query)
            ->orderBy('id', 'asc')
            ->paginate(10, ['*'], 'page_pipeline') // Nama parameter URL: page_pipeline
            ->withQueryString();

        // Tabel CTA (Hanya data yang memiliki CTA)
        $ctaProspeks = (clone $query)
            ->whereHas('cta')
            ->orderBy('id', 'asc')
            ->paginate(10, ['*'], 'page_cta') // Nama parameter URL: page_cta
            ->withQueryString();

        return view('pipeline', compact('prospeks', 'ctaProspeks', 'marketings', 'stats'));
    }

    // Menampilkan Form Input Massal
    public function create()
    {
        // Ambil user yang rolenya marketing
        $marketings = User::where('role', 'marketing')->get();

        return view('form-prospek', compact('marketings'));
    }

    // Proses Simpan Massal
    public function store(Request $request)
    {
        $request->validate([
            'marketing_id' => 'required',
            'tanggal_prospek' => 'required|date',
            'rows' => 'required|array',
            'rows.*.perusahaan' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->rows as $row) {
                if (empty($row['perusahaan'])) {
                    continue;
                }

                Prospek::create([
                    'marketing_id' => $request->marketing_id,
                    'tanggal_prospek' => $request->tanggal_prospek,
                    'perusahaan' => $row['perusahaan'],
                    'telp' => $row['telp'],
                    'telp_baru' => $row['telp_baru'],
                    'email' => $row['email'],
                    'jabatan' => $row['jabatan'],
                    'nama_pic' => $row['nama_pic'],
                    'wa_pic' => $row['wa_pic'],
                    'wa_baru' => $row['wa_baru'],
                    'lokasi' => $row['lokasi'],
                    'sumber' => $row['sumber'],
                    'update_terakhir' => $row['update_terakhir'],
                    'status' => $row['status'],
                    'deskripsi' => $row['deskripsi'],
                    'catatan' => $row['catatan'],
                ]);
            }

            DB::commit();

            return redirect()->route('prospek.index')->with('success', 'Data Prospek berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $prospek = \App\Models\Prospek::findOrFail($id);
        $marketings = \App\Models\User::where('role', 'marketing')->get();

        return view('form-prospek-edit', compact('prospek', 'marketings'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'marketing_id' => 'required',
            'perusahaan' => 'required',
        ]);

        $prospek = \App\Models\Prospek::findOrFail($id);

        $prospek->update([
            'marketing_id' => $request->marketing_id,
            'tanggal_prospek' => $request->tanggal_prospek,
            'perusahaan' => $request->perusahaan,
            'telp' => $request->telp,
            'telp_baru' => $request->telp_baru,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'nama_pic' => $request->nama_pic,
            'wa_pic' => $request->wa_pic,
            'wa_baru' => $request->wa_baru,
            'lokasi' => $request->lokasi,
            'sumber' => $request->sumber,
            'update_terakhir' => $request->update_terakhir,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('prospek.index')
            ->with('success', 'Data Prospek berhasil diupdate');
    }
}

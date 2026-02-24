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
        // Ambil data marketing untuk dropdown filter
        $marketings = \App\Models\User::where('role', 'marketing')->get();

        // Query dasar dengan relasi
        $query = \App\Models\Prospek::with(['marketing', 'cta']);

        // 1. Filter Rentang Waktu
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_prospek', [$request->start_date, $request->end_date]);
        }

        // 2. Filter Status CTA (Sudah di-CTA atau Belum)
        if ($request->cta_status) {
            if ($request->cta_status == 'pending') {
                $query->whereDoesntHave('cta');
            } elseif ($request->cta_status == 'done') {
                $query->whereHas('cta');
            }
        }

        // 3. Filter Marketing
        if ($request->marketing_id) {
            $query->where('marketing_id', $request->marketing_id);
        }

        // 4. FILTER STATUS (Sekarang mengambil dari tabel CTA kolom status_penawaran)
        if ($request->status) {
            $query->whereHas('cta', function ($q) use ($request) {
                $q->where('status_penawaran', $request->status);
            });
        }

        $prospeks = $query->latest()->get();

        // --- LOGIKA UNTUK CARD STATS (Tetap Sama) ---
        $stats = [
            'total_prospek' => $prospeks->count(),
            'total_cta' => $prospeks->whereNotNull('cta')->count(),
            'total_nilai' => $prospeks->sum(function ($item) {
                return $item->cta ? $item->cta->harga_penawaran : 0;
            }),
            'total_deal' => $prospeks->filter(function ($item) {
                return $item->cta && $item->cta->status_penawaran == 'deal';
            })->count(),
        ];

        return view('pipeline', compact('prospeks', 'marketings', 'stats'));
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

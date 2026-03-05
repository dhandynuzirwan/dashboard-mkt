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

        // 1. --- INISIALISASI TANGGAL (Default: Awal bulan ini - Akhir bulan ini) ---
        $start = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Ambil semua daftar status unik untuk pilihan filter
        $all_status_akhir = Prospek::select('status')
            ->whereNotNull('status')
            ->distinct()
            ->pluck('status');

        $query = Prospek::with(['marketing', 'cta']);

        if ($user->role === 'marketing') {
            $query->where('marketing_id', $user->id);
        }

        // ================= APPLY FILTER =================
        
        // Gunakan variabel $start dan $end yang sudah diinisialisasi
        $query->whereBetween('tanggal_prospek', [$start, $end]);

        // A. FILTER TAHAP (Ini yang tadi hilang, Lang!)
        if ($request->filled('cta_status')) {
            if ($request->cta_status == 'pending') {
                $query->whereDoesntHave('cta'); // Belum input penawaran
            } elseif ($request->cta_status == 'done') {
                $query->whereHas('cta'); // Sudah ada penawaran
            }
        }

        // Filter Status Akhir (Ini filter untuk kolom 'status' di tabel Prospek)
        if ($request->status_akhir) {
            $query->where('status', $request->status_akhir);
        }

        // FIX: Filter Status Penawaran (Ini filter untuk kolom 'status_penawaran' di tabel CTA)
        // Di Blade kamu menggunakan name="status", jadi kita tangkap $request->status
        if ($request->status) {
            $query->whereHas('cta', function ($q) use ($request) {
                $q->where('status_penawaran', $request->status);
            });
        }

        if ($request->marketing_id && $user->role !== 'marketing') {
            $query->where('marketing_id', $request->marketing_id);
        }

        if ($request->status_penawaran) {
            $query->whereHas('cta', function ($q) use ($request) {
                $q->where('status_penawaran', $request->status_penawaran);
            });
        }

        // 2. HITUNG STATS
        $statsData = (clone $query)->get(); 
        $stats = [
            'total_prospek' => $statsData->count(),
            'total_cta'     => $statsData->whereNotNull('cta')->count(),
            
            // FIX: Menghitung Nilai Pipeline (Harga Penawaran x Jumlah Peserta)
            'total_nilai'   => $statsData->sum(function($item) {
                return optional($item->cta)->harga_penawaran * optional($item->cta)->jumlah_peserta ?? 0;
            }),
            
            'total_deal'    => $statsData->filter(fn($item) => 
                                optional($item->cta)->status_penawaran == 'deal'
                            )->count(),
        ];

        // 3. PAGINATION
        $prospeks = (clone $query)->orderBy('id', 'asc')->paginate(10, ['*'], 'page_pipeline')->withQueryString();
        $ctaProspeks = (clone $query)->whereHas('cta')->orderBy('id', 'asc')->paginate(10, ['*'], 'page_cta')->withQueryString();

        // Kirim $start dan $end ke view
        return view('pipeline', compact('prospeks', 'ctaProspeks', 'marketings', 'stats', 'all_status_akhir', 'start', 'end'));
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
                    'telp' => $row['telp'] ?? null,
                    'telp_baru' => $row['telp_baru'] ?? null,
                    'email' => $row['email'] ?? null,
                    'jabatan' => $row['jabatan'],
                    'nama_pic' => $row['nama_pic'],
                    'wa_pic' => $row['wa_pic'] ?? null,
                    'wa_baru' => $row['wa_baru'] ?? null,
                    'lokasi' => $row['lokasi'] ?? null,
                    'sumber' => $row['sumber'] ?? null,
                    'update_terakhir' => $row['update_terakhir'] ?? null,
                    'status' => $row['status'] ?? null,
                    'deskripsi' => $row['deskripsi'] ?? null,
                    'catatan' => $row['catatan'] ?? null,
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

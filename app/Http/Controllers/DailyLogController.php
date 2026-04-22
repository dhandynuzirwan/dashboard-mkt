<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyLog; // Pastikan nama Model kamu disesuaikan (AktivitasHarian / DailyLog)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DailyLogController extends Controller
{
    /**
     * Menampilkan halaman Aktivitas Harian beserta Filter & Statistik
     */
    public function index(Request $request)
    {
        // 1. Tangkap parameter filter (Default: Hari ini & Semua Pegawai)
        $filter_date = $request->input('filter_date', date('Y-m-d'));
        $pegawai_id = $request->input('pegawai_id', 'all');

        // 2. Siapkan Query Dasar (Ambil data berdasarkan tanggal)
        $query = DailyLog::with('user')->whereDate('tanggal_aktivitas', $filter_date);

        // 3. Aplikasikan Filter Pegawai (Jika atasan memilih nama spesifik)
        if ($pegawai_id != 'all') {
            $query->where('user_id', $pegawai_id);
        }

        // 4. Eksekusi Query (Urutkan dari yang terbaru)
        $aktivitas = $query->latest()->get();

        // ==========================================
        // KALKULASI STATISTIK UNTUK 4 CARD DI ATAS
        // ==========================================
        
        $totalAktivitas = $aktivitas->count();
        
        // Hitung total jam (Menit dibagi 60, bulatkan 1 angka di belakang koma)
        $totalMenit = $aktivitas->sum('durasi_menit');
        $totalJamKerja = round($totalMenit / 60, 1);
        
        // Hitung berapa orang yang mengunggah evidence (file atau link)
        $adaEvidence = $aktivitas->filter(function($item) {
            return !empty($item->file_evidence) || !empty($item->link_evidence);
        })->count();
        
        // Ambil daftar user untuk dropdown filter (Hanya role operasional & team_leader)
        $pegawaiOperasional = User::whereIn('role', ['operasional', 'team_leader','web_dev'])->get();

        // 5. Kirim semua variabel ke Blade
        return view('operational.aktivitas-harian', compact(
            'aktivitas', 
            'filter_date', 
            'pegawai_id', 
            'totalAktivitas', 
            'totalJamKerja', 
            'pegawaiOperasional'
        ));
    }

    /**
     * Memproses penyimpanan aktivitas harian baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            // Tgl tidak boleh melebihi hari ini, dan batas mundur maksimal H-3
            'tanggal_aktivitas' => 'required|date|before_or_equal:today|after_or_equal:' . Carbon::today()->subDays(3)->toDateString(),
            'nama_kegiatan'     => 'required|string|max:255',
            
            // Durasi dan Deskripsi opsional (nullable)
            'durasi_menit'      => 'nullable|integer|min:1',
            'deskripsi'         => 'nullable|string',
            
            // File bukti maksimal 2MB (Opsional)
            'file_evidence'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_evidence'     => 'nullable|url'
        ]);

        $filePath = null;

        // 2. Cek dan Simpan File Gambar (Jika ada)
        if ($request->hasFile('file_evidence')) {
            $file = $request->file('file_evidence');
            // Simpan gambar ke folder: storage/app/public/evidence_aktivitas
            $filePath = $file->store('evidence_aktivitas', 'public');
        }
        
        // Hitung total menit dari input Jam dan Menit
        $totalKalkulasiMenit = null;
        if ($request->filled('durasi_jam') || $request->filled('durasi_menit')) {
            $jam = $request->durasi_jam ? (int)$request->durasi_jam : 0;
            $menit = $request->durasi_menit ? (int)$request->durasi_menit : 0;
            
            $totalKalkulasiMenit = ($jam * 60) + $menit;
            
            // Jika hasilnya 0 menit, kembalikan ke null (dianggap tidak diisi)
            if ($totalKalkulasiMenit === 0) {
                $totalKalkulasiMenit = null;
            }
        }

        // 3. Simpan Data ke Database (Tabel daily_logs)
        DailyLog::create([
            'user_id'           => auth()->id(), // Otomatis terisi ID pegawai yang sedang login
            'tanggal_aktivitas' => $request->tanggal_aktivitas,
            'nama_kegiatan'     => $request->nama_kegiatan,
            // Validasi lainnya tetap ada...
            'durasi_menit'      => $totalKalkulasiMenit,
            'deskripsi'         => $request->deskripsi,
            'file_evidence'     => $filePath,
            'link_evidence'     => $request->link_evidence,
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Aktivitas harian berhasil dicatat!');
    }
    
    /**
     * Memproses Update Data (Edit)
     */
    public function update(Request $request, $id)
    {
        $log = \App\Models\DailyLog::findOrFail($id);

        // Kunci Keamanan: Hanya pemilik log atau atasan yang bisa edit
        if (auth()->id() !== $log->user_id) {
            return redirect()->back()->with('error', 'Akses Ditolak: Anda hanya bisa mengubah data aktivitas milik Anda sendiri.');
        }

        $request->validate([
            'tanggal_aktivitas' => 'required|date|before_or_equal:today',
            'nama_kegiatan'     => 'required|string|max:255',
            // Validasi lainnya tetap ada...
            'durasi_jam'        => 'nullable|integer|min:0',
            'durasi_menit'      => 'nullable|integer|min:0|max:59',
            'deskripsi'         => 'nullable|string',
            'file_evidence'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_evidence'     => 'nullable|url'
        ]);

        $filePath = $log->file_evidence; // Default path lama

        // Jika upload file baru
        if ($request->hasFile('file_evidence')) {
            // Hapus file lama jika ada
            if ($log->file_evidence && \Illuminate\Support\Facades\Storage::disk('public')->exists($log->file_evidence)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($log->file_evidence);
            }
            // Simpan file baru
            $filePath = $request->file('file_evidence')->store('evidence_aktivitas', 'public');
        }
        
        // Hitung total menit dari input Jam dan Menit
        $totalKalkulasiMenit = null;
        if ($request->filled('durasi_jam') || $request->filled('durasi_menit')) {
            $jam = $request->durasi_jam ? (int)$request->durasi_jam : 0;
            $menit = $request->durasi_menit ? (int)$request->durasi_menit : 0;
            
            $totalKalkulasiMenit = ($jam * 60) + $menit;
            
            // Jika hasilnya 0 menit, kembalikan ke null (dianggap tidak diisi)
            if ($totalKalkulasiMenit === 0) {
                $totalKalkulasiMenit = null;
            }
        }

        $log->update([
            'tanggal_aktivitas' => $request->tanggal_aktivitas,
            'nama_kegiatan'     => $request->nama_kegiatan,
            'durasi_menit'      => $totalKalkulasiMenit,
            'deskripsi'         => $request->deskripsi,
            'file_evidence'     => $filePath,
            'link_evidence'     => $request->link_evidence,
        ]);

        return redirect()->back()->with('success', 'Aktivitas harian berhasil diperbarui!');
    }

    /**
     * Memproses Hapus Data (Delete)
     */
    public function destroy($id)
    {
        $log = DailyLog::findOrFail($id);
        $user = auth()->user();
    
        // 🔥 PERBAIKAN LOGIKA: Izinkan pemilik asli ATAU Role tertentu (Leader/Admin)
        $isOwner = ($log->user_id == $user->id);
        $isAuthorizedRole = in_array($user->role, ['team_leader', 'web_dev', 'superadmin', 'admin']);
    
        if (!$isOwner && !$isAuthorizedRole) {
            return back()->with('error', 'Gagal! Akses Ditolak: Anda hanya bisa menghapus data aktivitas milik Anda sendiri.');
        }
    
        $log->delete();
        return back()->with('success', 'Aktivitas harian berhasil dihapus.');
    }
}
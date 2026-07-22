<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanLemburController extends Controller
{
    // ==========================================
    // BAGIAN KARYAWAN (PENGAJUAN)
    // ==========================================

    public function index()
    {
        $user = Auth::user();
        $pengajuans = PengajuanLembur::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('pengajuan-lembur.index', compact('pengajuans'));
    }

    public function create()
    {
        return view('pengajuan-lembur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'tugas' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'dukungan_fasilitas' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        PengajuanLembur::create($data);

        return redirect()->route('pengajuan-lembur.index')->with('success', 'Pengajuan lembur berhasil dibuat dan sedang menunggu persetujuan.');
    }

    // ==========================================
    // BAGIAN APPROVAL (SPV, HRD, DIREKTUR)
    // ==========================================

    public function approvalIndex()
    {
        $user = Auth::user();
        $role = $user->role;

        $pengajuans = collect();

        // Logika query berdasarkan Role
        if (in_array($role, ['spv_marketing', 'team_leader'])) {
            // SPV melihat yang status_spv = pending
            // Idealnya SPV hanya melihat bawahan mereka, namun sementara kita tampilkan semua yang butuh approval SPV
            $pengajuans = PengajuanLembur::where('status_spv', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();
        } elseif ($role === 'hrd') {
            // HRD melihat yang SPV sudah approve, tapi HRD belum
            $pengajuans = PengajuanLembur::where('status_spv', 'approved')
                            ->where('status_hrd', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();
        } elseif ($role === 'superadmin') {
            // Direktur/Superadmin melihat yang HRD sudah approve, tapi Direktur belum
            $pengajuans = PengajuanLembur::where('status_hrd', 'approved')
                            ->where('status_direktur', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return view('pengajuan-lembur.approval', compact('pengajuans', 'role'));
    }

    public function approve(Request $request, $id)
    {
        $lembur = PengajuanLembur::findOrFail($id);
        $user = Auth::user();
        $role = $user->role;

        if (in_array($role, ['spv_marketing', 'team_leader'])) {
            $lembur->status_spv = 'approved';
            $lembur->spv_id = $user->id;
        } elseif ($role === 'hrd') {
            $lembur->status_hrd = 'approved';
            $lembur->hrd_id = $user->id;
        } elseif ($role === 'superadmin') {
            $lembur->status_direktur = 'approved';
            $lembur->direktur_id = $user->id;
            
            // Jika direktur sudah approve, maka status akhir menjadi approved
            $lembur->status_akhir = 'approved';
        }

        $lembur->save();

        return redirect()->back()->with('success', 'Pengajuan lembur berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $lembur = PengajuanLembur::findOrFail($id);
        $user = Auth::user();
        $role = $user->role;

        if (in_array($role, ['spv_marketing', 'team_leader'])) {
            $lembur->status_spv = 'rejected';
            $lembur->spv_id = $user->id;
        } elseif ($role === 'hrd') {
            $lembur->status_hrd = 'rejected';
            $lembur->hrd_id = $user->id;
        } elseif ($role === 'superadmin') {
            $lembur->status_direktur = 'rejected';
            $lembur->direktur_id = $user->id;
        }
        
        $lembur->status_akhir = 'rejected';
        $lembur->save();

        return redirect()->back()->with('success', 'Pengajuan lembur telah ditolak.');
    }

    // ==========================================
    // BAGIAN CETAK PDF
    // ==========================================

    public function printPdf($id)
    {
        $lembur = PengajuanLembur::where('id', $id)
                    ->where('status_akhir', 'approved')
                    ->firstOrFail();

        // Kita gunakan view yang akan di print via window.print() di browser
        return view('pengajuan-lembur.pdf', compact('lembur'));
    }
}

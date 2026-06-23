<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perizinan;

class ApprovalIzinController extends Controller
{
    public function index()
    {
        $izins = Perizinan::with('user')
            ->where('external_id', 'like', 'SYS-IZIN-%')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $riwayatIzins = Perizinan::with('user')
            ->where('external_id', 'like', 'SYS-IZIN-%')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('approval-izin.index', compact('izins', 'riwayatIzins'));
    }

    public function approve($id)
    {
        $izin = Perizinan::findOrFail($id);
        $izin->status = 'approved';
        $izin->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject($id)
    {
        $izin = Perizinan::findOrFail($id);
        $izin->status = 'rejected';
        $izin->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\ProspekExport;
use App\Models\DownloadRequest;
use App\Models\User;
use App\Notifications\DownloadApprovedNotification;
use App\Notifications\NewDownloadRequestNotification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownloadRequestController extends Controller
{
    // ================= 1. SUBMIT REQUEST =================
    public function store(Request $request)
    {
        $requestData = DownloadRequest::create([
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'marketing_id' => $request->marketing_id,
            'status_akhir' => $request->status_akhir,
            'status_penawaran' => $request->status,
            'cta_status' => $request->cta_status,
            'reason' => $request->reason,
        ]);

        $superadmins = User::where('role', 'superadmin')->get();

        foreach ($superadmins as $admin) {
            $admin->notify(new NewDownloadRequestNotification($requestData));
        }

        return back()->with('success', 'Request download berhasil dikirim.');
    }

    // ================= 2. HALAMAN GABUNGAN (APPROVAL & MY REQUEST) =================
    public function index()
    {
        $user = auth()->user();

        // Tandai notifikasi sudah dibaca saat membuka halaman ini
        $user->unreadNotifications->markAsRead();

        // Logika Pintar: Jika Superadmin/Admin -> Tampilkan Semua. Jika User -> Tampilkan miliknya.
        if (in_array($user->role, ['superadmin'])) {
            $requests = DownloadRequest::with('user')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $requests = DownloadRequest::with('user')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        // Kita arahkan ke satu view saja
        return view('download-approval', compact('requests'));
    }

    // ================= 3. APPROVE REQUEST =================
    public function approve($id)
    {
        $req = DownloadRequest::findOrFail($id);

        $req->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        $req->user->notify(new DownloadApprovedNotification($req));

        return back()->with('success', 'Request disetujui.');
    }

    // ================= 4. REJECT REQUEST =================
    public function reject($id)
    {
        $req = DownloadRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('success', 'Request ditolak.');
    }

    // ================= 5. DOWNLOAD FILE EXCEL =================
    public function download($id)
    {
        $req = DownloadRequest::findOrFail($id);

        if ($req->status !== 'approved') {
            abort(403, 'File belum di-approve.');
        }

        // Superadmin/Admin bisa download semua. User hanya bisa download miliknya.
        if ($req->user_id != auth()->id() && !in_array(auth()->user()->role, ['superadmin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mendownload file ini.');
        }

        return Excel::download(new ProspekExport($req), 'pipeline.xlsx');
    }
}
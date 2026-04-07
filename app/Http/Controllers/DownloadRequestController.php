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
    // Submit Request
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

    // Halaman Pending (Superadmin)
    public function index()
    {
        // $requests = DownloadRequest::where('status', 'pending')->latest()->get();
        // Ganti ini (yang kemungkinan menyembunyikan data approved):
        $requests = DownloadRequest::where('status', 'pending')->get();

        // Menjadi ini (agar semua data tampil dengan yang terbaru di atas):
        $requests = DownloadRequest::orderBy('created_at', 'desc')->paginate(10); // Atau gunakan ->paginate(10)

        return view('download-approval', compact('requests'));
    }

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

    public function reject($id)
    {
        $req = DownloadRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('success', 'Request ditolak.');
    }

    public function download($id)
    {
        $req = DownloadRequest::findOrFail($id);

        if ($req->status !== 'approved') {
            abort(403, 'File belum di-approve.');
        }

        // PERBAIKAN DI SINI: Pakai != (bukan !==) agar tidak sensitif tipe data.
        // Jika Admin boleh mendownload semua file layaknya superadmin, gunakan in_array
        if ($req->user_id != auth()->id() && !in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mendownload file ini.');
        }

        return Excel::download(new ProspekExport($req), 'pipeline.xlsx');
    }

    public function myRequests()
    {
        $requests = DownloadRequest::where('user_id', auth()->id())
            ->latest()
            ->get();
        auth()->user()->unreadNotifications->markAsRead();

        return view('download-my-requests', compact('requests'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perizinan;
use App\Models\JenisIzin;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        // Tampilkan riwayat pengajuan izin user login
        // Menampilkan semua baris yang diajukan oleh sistem.
        $izins = Perizinan::where('user_id', auth()->id())
            ->where('external_id', 'like', 'SYS-IZIN-%')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('pengajuan-izin.index', compact('izins'));
    }

    public function create()
    {
        $jenisIzins = JenisIzin::all();
        return view('pengajuan-izin.create', compact('jenisIzins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'jenis_izin' => 'required|string',
            'keterangan' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Validasi Cuti H-20
        $isCuti = strtolower($request->jenis_izin) === 'cuti' || str_contains(strtolower($request->jenis_izin), 'cuti');
        
        if ($isCuti) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $batasCuti = Carbon::now()->startOfDay()->addDays(20);
            
            if ($startDate->lt($batasCuti)) {
                return redirect()->back()->with('error', 'Pengajuan Cuti harus dilakukan minimal H-20 (20 hari sebelum tanggal mulai).')->withInput();
            }
        }

        // Upload file jika ada
        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $file = $request->file('file_bukti');
            $fileName = 'izin_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('perizinan', $fileName, 'public');
        }

        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        $batchId = time();

        foreach ($period as $date) {
            // Kita buat record terpisah per harinya
            $tanggal = $date->format('Y-m-d');
            
            // Generate unique external ID untuk sistem
            $externalId = 'SYS-IZIN-' . auth()->id() . '-' . $tanggal . '-' . $batchId;
            
            // Cek apakah sudah pernah mengajukan di hari yang sama
            $existing = Perizinan::where('user_id', auth()->id())->where('tanggal', $tanggal)->first();
            if ($existing) {
                // Jangan ditimpa jika sudah ada data lama (misal dari fingerspot)
                continue;
            }

            Perizinan::create([
                'user_id' => auth()->id(),
                'external_id' => $externalId,
                'tanggal' => $tanggal,
                'jenis' => $request->jenis_izin,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
                'file_path' => $filePath
            ]);
        }

        return redirect()->route('pengajuan-izin.index')->with('success', 'Pengajuan Izin berhasil dikirim dan menunggu persetujuan.');
    }
}

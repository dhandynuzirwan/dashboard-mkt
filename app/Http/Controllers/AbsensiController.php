<?php

namespace App\Http\Controllers;

// Panggil library di paling atas, di luar class
if (file_exists(app_path('Helpers/SimpleXLSX.php'))) {
    require_once app_path('Helpers/SimpleXLSX.php');
}

use App\Models\User;
use App\Models\AbsensiLog;
use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleXLSX; // Pastikan ini ada jika SimpleXLSX tidak pakai namespace

class AbsensiController extends Controller
{

    public function index(Request $request) 
    {
        $query = AbsensiLog::with('user');

        // Filter Berdasarkan Rentang Tanggal
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        // Filter Berdasarkan Karyawan (Opsional, tapi berguna karena data $users sudah ada)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->paginate(10);
        $users = User::all();
        $perizinans = Perizinan::with('user')->latest()->get();
        
        return view('absensi', compact('absensi', 'users', 'perizinans'));
    }

    public function mapping()
    {
        $users = User::all();
        return view('absensi.mapping', compact('users'));
    }

    public function storeMapping(Request $request)
    {
        $request->validate([
            'fingerspot_id' => 'required|array',
        ]);

        foreach ($request->fingerspot_id as $userId => $pin) {
            // Gunakan updateQuietly jika tidak ingin memicu event/observer (opsional)
            User::where('id', $userId)->update([
                'fingerspot_id' => $pin
            ]);
        }

        return back()->with('success', 'Mapping User ID berhasil diperbarui!');
    }

    public function importManual(Request $request)
    {
        $request->validate(['file_absensi' => 'required']);

        $file = $request->file('file_absensi');
        $handle = fopen($file->getRealPath(), "r");
        
        $currentUserId = null;
        $successCount = 0;
        $auditLogs = []; 

        $rowNum = 0;
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNum++;
            
            // Membersihkan karakter aneh/spasi
            $row = array_map(function($val) {
                return trim($val, " \t\n\r\0\x0B\"");
            }, $row);

            // LOG DEBUG: Kita rekam apa yang ada di baris 5 dan 6 (tempat ID berada)
            if ($rowNum == 5 || $rowNum == 6) {
                $col0 = $row[0] ?? 'KOSONG';
                $col1 = $row[1] ?? 'KOSONG';
                $auditLogs[] = "🔍 Info Baris $rowNum: Kolom[0] isinya '$col0', Kolom[1] isinya '$col1'";
            }

            // 1. Deteksi Baris ID/NIK
            if (isset($row[0]) && (str_contains($row[0], 'ID/NIK') || str_contains($row[0], 'ID'))) {
                if (isset($row[1])) {
                    $idRaw = explode('/', $row[1]); 
                    $idDariFile = trim($idRaw[0]); // Ini yang diambil: ADM.001

                    $user = \App\Models\User::where('fingerspot_id', $idDariFile)->first();
                    
                    if ($user) {
                        $currentUserId = $user->id;
                        $auditLogs[] = "✅ KETEMU! ID '$idDariFile' cocok dengan user: $user->name";
                    } else {
                        $currentUserId = null;
                        $auditLogs[] = "❌ GAGAL! ID '$idDariFile' ada di file, tapi GAK ADA di database kamu.";
                    }
                }
                continue;
            }

            // 2. Proses Tanggal
            if ($currentUserId && isset($row[0]) && preg_match('/\d{4}-\d{2}-\d{2}/', $row[0], $matches)) {
                $tanggal = $matches[0];
                $jamMasuk = $row[4] ?? '-';
                $jamPulang = $row[5] ?? '-';

                if ($jamMasuk !== '-' && !empty($jamMasuk)) {
                    \App\Models\AbsensiLog::updateOrCreate(
                        ['user_id' => $currentUserId, 'tanggal' => $tanggal, 'tipe' => 'in'],
                        ['jam' => $jamMasuk, 'source' => 'manual']
                    );
                    $successCount++;
                }
                
                if ($jamPulang !== '-' && !empty($jamPulang)) {
                    \App\Models\AbsensiLog::updateOrCreate(
                        ['user_id' => $currentUserId, 'tanggal' => $tanggal, 'tipe' => 'out'],
                        ['jam' => $jamPulang, 'source' => 'manual']
                    );
                    $successCount++;
                }
            }
        }
        fclose($handle);

        return back()->with('success', "Proses selesai. $successCount data masuk.")
                    ->with('audit_ids', $auditLogs);
    }

    public function importIzin(Request $request)
    {
        $request->validate(['file_izin' => 'required']);

        $file = $request->file('file_izin');
        $handle = fopen($file->getRealPath(), "r");
        
        $successCount = 0;
        $rowNum = 0;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNum++;
            if ($rowNum == 1) continue; // Lewati baris header

            // Mapping kolom berdasarkan file CSV Fingerspot kamu
            $idFingerspot = trim($row[2]); // Kolom ID (ADM.001, dsb)
            $namaIzin     = $row[5];       // Kolom Nama Izin
            $tanggalRaw   = $row[6];       // Kolom Tanggal Izin (19 Feb 2026)
            $statusRaw    = $row[8];       // Kolom Status Persetujuan (Diterima)
            $catatan      = $row[9];       // Kolom Catatan

            // Cari User berdasarkan ID Fingerspot
            $user = \App\Models\User::where('fingerspot_id', $idFingerspot)->first();

            if ($user && !empty($tanggalRaw)) {
                try {
                    // Konversi tanggal "19 Feb 2026" menjadi "2026-02-19"
                    $tanggal = \Carbon\Carbon::parse($tanggalRaw)->format('Y-m-d');

                    // Mapping status: Fingerspot "Diterima" -> Database "approved"
                    $statusMap = [
                        'Diterima' => 'approved',
                        'Ditolak'  => 'rejected',
                        'Pending'  => 'pending'
                    ];
                    $status = $statusMap[$statusRaw] ?? 'pending';

                    // Membuat external_id unik (gabungan ID + Tanggal + Jenis Izin)
                    // Ini untuk mencegah data ganda jika file diupload ulang
                    $extId = md5($idFingerspot . $tanggal . $namaIzin);

                    \App\Models\Perizinan::updateOrCreate(
                        ['external_id' => $extId],
                        [
                            'user_id'    => $user->id,
                            'tanggal'    => $tanggal,
                            'jenis'      => $namaIzin,
                            'keterangan' => $catatan == '-' ? null : $catatan,
                            'status'     => $status,
                        ]
                    );
                    $successCount++;
                } catch (\Exception $e) {
                    continue; // Lewati jika ada format tanggal yang rusak
                }
            }
        }
        fclose($handle);

        return back()->with('success', "Berhasil mengimpor $successCount data izin karyawan.");
    }
}
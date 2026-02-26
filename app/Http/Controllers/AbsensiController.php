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
    public function index() 
    {
        // Gunakan 'absensi.index' jika filenya ada di folder resources/views/absensi/index.blade.php
        $absensi = AbsensiLog::with('user')->orderBy('tanggal', 'desc')->paginate(10);
        $users = User::all();
        
        return view('absensi', compact('absensi', 'users'));
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
}
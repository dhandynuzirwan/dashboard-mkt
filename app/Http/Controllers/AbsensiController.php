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
        // 1. --- INISIALISASI FILTER (Default: Awal bulan ini - Hari ini) ---
        $start = $request->query('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end = $request->query('end_date', \Carbon\Carbon::now()->format('Y-m-d'));
        $userId = $request->query('user_id');

        $query = AbsensiLog::with('user');

        // 2. --- APPLY FILTER ---
        if ($start) {
            $query->where('tanggal', '>=', $start);
        }
        if ($end) {
            $query->where('tanggal', '<=', $end);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // 3. --- AMBIL DATA ---
        $absensi = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        $users = User::all();
        $perizinans = Perizinan::with('user')->latest()->get();
        // $holidays = \App\Models\Holiday::orderBy('tanggal', 'desc')->get();
        // UPDATE INI: Gunakan paginate dengan nama parameter unik
        $holidays = \App\Models\Holiday::orderBy('tanggal', 'desc')
                ->paginate(10, ['*'], 'page_libur') 
                ->withQueryString();

        // Kirim $start, $end, dan $userId ke view agar filter tetap terisi
        return view('absensi', compact('absensi', 'users', 'perizinans', 'holidays', 'start', 'end', 'userId'));
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

    public function destroyAbsensiRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $count = AbsensiLog::whereBetween('tanggal', [$request->start_date, $request->end_date])->delete();

        return back()->with('success', "Berhasil menghapus $count data log absensi dari tanggal $request->start_date sampai $request->end_date.");
    }

    public function destroyIzinRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $count = Perizinan::whereBetween('tanggal', [$request->start_date, $request->end_date])->delete();

        return back()->with('success', "Berhasil menghapus $count data perizinan dari tanggal $request->start_date sampai $request->end_date.");
    }

    // Method Simpan Hari Libur
    public function storeHoliday(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        $startDate = \Carbon\Carbon::parse($request->tanggal);
        $keterangan = $request->keterangan;
        $successCount = 0;

        // Jika ada tanggal akhir, lakukan looping
        if ($request->filled('tanggal_akhir')) {
            $endDate = \Carbon\Carbon::parse($request->tanggal_akhir);

            // Pastikan tanggal akhir tidak lebih kecil dari tanggal mulai
            if ($endDate->lt($startDate)) {
                return back()->with('error', 'Tanggal akhir tidak boleh sebelum tanggal mulai!');
            }

            // Looping dari start ke end
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                \App\Models\Holiday::updateOrCreate(
                    ['tanggal' => $date->format('Y-m-d')],
                    ['keterangan' => $keterangan]
                );
                $successCount++;
            }
        } else {
            // Jika cuma 1 hari
            \App\Models\Holiday::updateOrCreate(
                ['tanggal' => $startDate->format('Y-m-d')],
                ['keterangan' => $keterangan]
            );
            $successCount = 1;
        }

        return back()->with('success', "Berhasil menyimpan $successCount hari libur.");
    }

    // Method Hapus Hari Libur
    public function destroyHoliday($id)
    {
        \App\Models\Holiday::findOrFail($id)->delete();
        return back()->with('success', 'Hari libur berhasil dihapus!');
    }
}
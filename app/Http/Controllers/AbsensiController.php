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
        // Validasi ekstensi file (Boleh CSV atau Excel)
        $request->validate([
            'file_absensi' => 'required|mimes:csv,txt,xlsx,xls,vnd.openxmlformats-officedocument.spreadsheetml.sheet,vnd.ms-excel'
        ]);

        $file = $request->file('file_absensi');
        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();

        $allRows = [];

        // 1. EKSTRAKSI DATA BERDASARKAN FORMAT FILE
        if ($extension === 'csv' || $extension === 'txt') {
            // Jika CSV, baca pakai fungsi bawaan PHP
            $handle = fopen($filePath, "r");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $allRows[] = $row;
            }
            fclose($handle);
        } elseif ($extension === 'xlsx' || $extension === 'xls') {
            
            // 1. Paksa load file helper secara langsung di sini
            if (file_exists(app_path('Helpers/SimpleXLSX.php'))) {
                require_once app_path('Helpers/SimpleXLSX.php');
            } else {
                return back()->with('error', 'File Helper SimpleXLSX tidak ditemukan di app/Helpers/');
            }

            // 2. Cek apakah menggunakan namespace Shuchkin atau tidak
            if (class_exists('\Shuchkin\SimpleXLSX')) {
                $xlsx = \Shuchkin\SimpleXLSX::parse($filePath);
                $parseError = \Shuchkin\SimpleXLSX::parseError();
            } else {
                $xlsx = \SimpleXLSX::parse($filePath);
                $parseError = \SimpleXLSX::parseError();
            }

            // 3. Ekstrak barisnya
            if ($xlsx) {
                $allRows = $xlsx->rows();
            } else {
                return back()->with('error', 'Gagal membaca file Excel: ' . $parseError);
            }
            
        } else {
            return back()->with('error', 'Format file tidak didukung! Gunakan CSV atau Excel.');
        }


        $successCount = 0;
        $auditLogs = []; 
        $scansData = [];

        // 2. MEMBACA BARIS DATA (Berlaku untuk CSV maupun Excel)
        foreach ($allRows as $index => $row) {
            // Lewati baris pertama (Header)
            if ($index == 0) continue;

            // Pastikan baris memiliki data yang cukup
            if (count($row) < 5) continue;

            // Membersihkan spasi berlebih dari setiap kolom
            $row = array_map('trim', $row);

            $idFingerspot = $row[1]; // Contoh: WD.002
            $tanggal = $row[3];      // Contoh: 2026-04-07
            $jam = $row[4];          // Contoh: 07:34

            if (empty($idFingerspot) || empty($tanggal) || empty($jam)) continue;

            $user = \App\Models\User::where('fingerspot_id', $idFingerspot)->first();
            
            if ($user) {
                // Simpan jam ke array sementara
                $scansData[$user->id][$tanggal][] = $jam;
            } else {
                $auditLogs[] = "❌ ID Mesin '$idFingerspot' tidak ditemukan di database.";
            }
        }

        // 3. MENYIMPAN DATA (Logika Anti-Duplikat & Auto In/Out)
        foreach ($scansData as $userId => $dates) {
            foreach ($dates as $tanggal => $times) {
                $times = array_unique($times);
                sort($times);

                $jamMasuk = $times[0]; // Jam paling pagi
                $jamPulang = count($times) > 1 ? end($times) : null; // Jam paling sore

                // Simpan Masuk
                \App\Models\AbsensiLog::updateOrCreate(
                    ['user_id' => $userId, 'tanggal' => $tanggal, 'tipe' => 'in'],
                    ['jam' => $jamMasuk, 'source' => 'import']
                );
                $successCount++;

                // Simpan Pulang
                if ($jamPulang) {
                    \App\Models\AbsensiLog::updateOrCreate(
                        ['user_id' => $userId, 'tanggal' => $tanggal, 'tipe' => 'out'],
                        ['jam' => $jamPulang, 'source' => 'import']
                    );
                    $successCount++;
                }

                $auditLogs[] = "✅ Terproses: ID User $userId pada $tanggal (Masuk: $jamMasuk" . ($jamPulang ? " | Pulang: $jamPulang" : "") . ")";
            }
        }

        $auditLogs = array_slice(array_unique($auditLogs), 0, 20);

        return back()->with('success', "Proses selesai. $successCount log absensi berhasil dimasukkan ke database.")
                     ->with('audit_ids', $auditLogs);
    }

    public function importIzin(Request $request)
    {
        // 1. Validasi ekstensi file (Boleh CSV atau Excel)
        $request->validate([
            'file_izin' => 'required|mimes:csv,txt,xlsx,xls,vnd.openxmlformats-officedocument.spreadsheetml.sheet,vnd.ms-excel'
        ]);

        $file = $request->file('file_izin');
        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();

        $allRows = [];

        // 2. EKSTRAKSI DATA BERDASARKAN FORMAT FILE
        if ($extension === 'csv' || $extension === 'txt') {
            // Jika CSV
            $handle = fopen($filePath, "r");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $allRows[] = $row;
            }
            fclose($handle);
        } elseif ($extension === 'xlsx' || $extension === 'xls') {
            
            // Jika Excel, Paksa load helper
            if (file_exists(app_path('Helpers/SimpleXLSX.php'))) {
                require_once app_path('Helpers/SimpleXLSX.php');
            } else {
                return back()->with('error', 'File Helper SimpleXLSX tidak ditemukan!');
            }

            // Cek Namespace Shuchkin
            if (class_exists('\Shuchkin\SimpleXLSX')) {
                $xlsx = \Shuchkin\SimpleXLSX::parse($filePath);
                $parseError = \Shuchkin\SimpleXLSX::parseError();
            } else {
                $xlsx = \SimpleXLSX::parse($filePath);
                $parseError = \SimpleXLSX::parseError();
            }

            if ($xlsx) {
                $allRows = $xlsx->rows();
            } else {
                return back()->with('error', 'Gagal membaca file Excel Izin: ' . $parseError);
            }
            
        } else {
            return back()->with('error', 'Format file tidak didukung! Gunakan CSV atau Excel.');
        }

        $successCount = 0;

        // 3. PROSES DATA IZIN
        foreach ($allRows as $index => $row) {
            // Lewati baris header (baris pertama)
            if ($index == 0) continue; 

            // Pastikan baris memiliki jumlah kolom yang cukup agar tidak error "Undefined offset"
            if (count($row) < 10) continue;

            // Mapping kolom berdasarkan file Fingerspot kamu
            $idFingerspot = trim($row[2]); // Kolom ID (ADM.001, dsb)
            $namaIzin     = trim($row[5]); // Kolom Nama Izin
            $tanggalRaw   = trim($row[6]); // Kolom Tanggal Izin (19 Feb 2026)
            $statusRaw    = trim($row[8]); // Kolom Status Persetujuan (Diterima)
            $catatan      = trim($row[9]); // Kolom Catatan

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
                    continue; // Lewati baris ini jika ada format tanggal yang tidak lazim
                }
            }
        }

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
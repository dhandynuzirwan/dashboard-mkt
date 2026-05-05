<?php

namespace App\Imports;

use App\Models\DailyLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class DailyLogImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $userId = auth()->id();
        
        // Kamus untuk menerjemahkan bulan Indonesia ke Inggris agar Carbon tidak bingung
        $bulanIndo = [
            'Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March',
            'April' => 'April', 'Mei' => 'May', 'Juni' => 'June', 'Juli' => 'July',
            'Agustus' => 'August', 'September' => 'September', 'Oktober' => 'October',
            'November' => 'November', 'Desember' => 'December'
        ];

        foreach ($rows as $row) {
            // Jika kolom activity di Excel kosong, lewati baris ini
            if (empty($row['activity'])) continue;

            // ================= 1. PARSING TANGGAL =================
            $tanggalAktivitas = now()->format('Y-m-d');
            if (!empty($row['date'])) {
                if (is_numeric($row['date'])) {
                    $tanggalAktivitas = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
                } else {
                    try {
                        $rawDate = preg_replace('/^[a-zA-Z]+,\s*/', '', $row['date']);
                        $rawDate = strtr($rawDate, $bulanIndo);
                        $tanggalAktivitas = Carbon::parse($rawDate)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $tanggalAktivitas = now()->format('Y-m-d');
                    }
                }
            }

            // ================= 2. PARSING DURASI JAM =================
            $totalMenit = null;
            if (!empty($row['total_time'])) {
                if (str_contains($row['total_time'], ':')) {
                    $timeParts = explode(':', $row['total_time']);
                    $jam = isset($timeParts[0]) ? (int)$timeParts[0] : 0;
                    $menit = isset($timeParts[1]) ? (int)$timeParts[1] : 0;
                    $totalMenit = ($jam * 60) + $menit;
                } elseif (is_numeric($row['total_time'])) {
                    $totalMenit = round((float)$row['total_time'] * 24 * 60);
                } else {
                    $totalMenit = (int)$row['total_time']; 
                }
            }

            // ================= 3. DESKRIPSI (NOTES) =================
            // Sekarang Status sudah tidak lagi numpang di sini ya!
            $deskripsiGabung = "";
            if (!empty($row['notes'])) {
                $deskripsiGabung .= $row['notes'] . "\n";
            }

            // ================= 4. HANDLING EVIDENCE =================
            $linkEvidence = null;
            if (!empty($row['work_evidence'])) {
                if (filter_var($row['work_evidence'], FILTER_VALIDATE_URL)) {
                    $linkEvidence = $row['work_evidence'];
                } else {
                    $deskripsiGabung .= "Evidence File: " . $row['work_evidence'];
                }
            }

            // ================= 5. TENTUKAN STATUS =================
            // Ambil dari excel, jika kosong jadikan 'Not Started'
            // Gunakan ucwords agar huruf depannya kapital (contoh: "in progress" -> "In Progress")
            $statusAktivitas = !empty($row['status']) ? ucwords(trim($row['status'])) : 'Not Started';

            // ================= 6. SIMPAN KE DATABASE =================
            DailyLog::create([
                'user_id'           => $userId,
                'tanggal_aktivitas' => $tanggalAktivitas,
                'nama_kegiatan'     => $row['activity'],
                'status'            => $statusAktivitas, // 🔥 SEKARANG MASUK KE SINI
                'durasi_menit'      => $totalMenit,
                'deskripsi'         => trim($deskripsiGabung),
                'link_evidence'     => $linkEvidence,
            ]);
        }
    }
}
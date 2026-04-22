<?php

namespace App\Imports;

use App\Models\PengirimanPaket;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Untuk convert tanggal excel

class PengirimanPaketImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Tangani Kolom Array (isi_paket)
        // Kalau di excel diisi "Buku, Sertifikat", kita pecah jadi array ["Buku", "Sertifikat"]
        $isiPaketArray = null;
        if (!empty($row['isi_paket'])) {
            $isiPaketArray = array_map('trim', explode(',', $row['isi_paket']));
        }

        // 2. Gunakan updateOrCreate untuk mencegah duplikat
        
        $namaPenerima = $row['nama_penerima'] ?? $row['instansi'] ?? 'Tanpa Nama';
        $instansi = $row['instansi'] ?? '-';

        return PengirimanPaket::updateOrCreate(
            // KOTAK 1: Kriteria Pencarian (Yang bikin data dianggap duplikat)
            [
                'nama_penerima'     => $namaPenerima,
                'instansi'          => $instansi,
            ],
            // KOTAK 2: Data yang di-update (jika ketemu) atau di-insert (jika baru)
            [
                'no_hp'             => $row['no_hp'] ?? '-',
                'alamat_pengiriman' => $row['alamat_pengiriman'] ?? '-',
                'jenis_paket'       => $row['jenis_paket'] ?? null,
                'isi_paket'         => $isiPaketArray, // Memasukkan hasil pecahan array
                'isi_paket_lainnya' => $row['isi_paket_lainnya'] ?? null,
                'ekspedisi'         => $row['ekspedisi'] ?? null,
                'no_resi'           => $row['no_resi'] ?? null,
                'biaya_pengiriman'  => $row['biaya_pengiriman'] ?? 0,
                'status_pengiriman' => $row['status_pengiriman'] ?? 'Pending',
                'tanggal_kirim'     => $this->formatTanggal($row['tanggal_kirim'] ?? null),
                'tanggal_diterima'  => $this->formatTanggal($row['tanggal_diterima'] ?? null),
                'catatan_teks'      => $row['catatan_teks'] ?? null,
            ]
        );
    }

    /**
     * Fungsi bantuan untuk mengubah tanggal Excel jadi format Database (Y-m-d)
     */
    private function formatTanggal($value)
    {
        if (!$value) return null;

        // Jika Excel mengirim format angka serial (cth: 44123)
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        // Jika Excel mengirim teks (cth: "2026-04-22")
        return date('Y-m-d', strtotime($value));
    }
}
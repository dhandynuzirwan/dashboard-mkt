<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProspekCtaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        // Menyediakan contoh data yang urutannya sama persis dengan form prospek massal
        return [
            [
                'PT Maju Bersama',               // Perusahaan
                '021-123456',                    // Telp
                '021-654321',                    // Telp Baru
                'budi@majubersama.com',          // Email
                'HR Manager',                    // Jabatan
                'Budi',                          // Nama HRD/PIC
                '081234567890',                  // WA HRD/PIC
                'Jakarta',                       // Lokasi
                'Google Ads',                    // Sumber
                '2026-06-11',                    // Update FU
                'KIRIM COMPRO',                  // Status Akhir Data
                'Tertarik dengan program K3 Umum, minta dikirimkan profile perusahaan.', // Catatan
                '2026-06-11',                    // Tanggal Prospek
                'Nama Marketing Anda',           // Nama Marketing
                'Pelatihan K3 Umum',             // Judul Permintaan CTA
                '10',                            // Jumlah Peserta CTA
                'Kemnaker',                      // Sertifikasi CTA
                'Ahli K3 Umum',                  // Skema CTA
                '5000000',                       // Harga Penawaran CTA
                '3500000',                       // Harga Vendor CTA
                'https://drive.google.com/proposal-k3', // Link Proposal CTA
                'under_review',                  // Status Penawaran CTA
                'Penawaran dikirim, menunggu keputusan dari direksi mereka.' // Keterangan CTA
            ]
        ];
    }

    public function headings(): array
    {
        // 12 Kolom pertama disamakan persis dengan urutan tabel Form Prospek Massal
        return [
            'Perusahaan',
            'Telp',
            'Telp Baru',
            'Email',
            'Jabatan',
            'Nama HRD/PIC',
            'WA HRD/PIC',
            'Lokasi',
            'Sumber',
            'Update FU',
            'Status Akhir Data',
            'Catatan',
            'Tanggal Prospek',
            'Nama Marketing',
            'Judul Permintaan CTA',
            'Jumlah Peserta CTA',
            'Sertifikasi CTA',
            'Skema CTA',
            'Harga Penawaran CTA',
            'Harga Vendor CTA',
            'Link Proposal CTA',
            'Status Penawaran CTA',
            'Keterangan CTA'
        ];
    }
}

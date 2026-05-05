<?php

namespace App\Exports;

use App\Models\Prospek;
use App\Models\Cta;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProspekExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $request;

    // Menangkap request filter dari Controller
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array(): array
    {
        // 1. Siapkan Query Prospek
        $query = Prospek::query()->with('marketing');

        // --- APLIKASIKAN FILTER DARI REQUEST ---
        if ($this->request->start_date && $this->request->end_date) {
            $query->whereBetween('tanggal_prospek', [$this->request->start_date, $this->request->end_date]);
        }
        if ($this->request->marketing_id) {
            $query->where('marketing_id', $this->request->marketing_id);
        }
        if ($this->request->status_akhir) {
            $query->where('status', $this->request->status_akhir);
        }

        $prospeks = $query->get();
        $data = [];

        // 2. Looping Data untuk Dibentuk Menjadi Baris Excel
        foreach ($prospeks as $prospek) {
            // Ambil SEMUA CTA milik prospek ini
            $semuaCta = Cta::where('prospek_id', $prospek->id)->get();

            // Jika prospek INI PUNYA CTA (Bisa 1 atau lebih)
            if ($semuaCta->count() > 0) {
                // Looping setiap CTA menjadi baris baru
                foreach ($semuaCta as $cta) {
                    // Terapkan Filter Status CTA jika ada
                    if ($this->request->cta_status == 'pending' && $cta) continue; 
                    if ($this->request->status_penawaran && $cta->status_penawaran != $this->request->status_penawaran) continue;

                    $data[] = $this->mapRow($prospek, $cta);
                }
            } 
            // Jika prospek INI BELUM PUNYA CTA SAMA SEKALI
            else {
                // Jangan tampilkan jika filter meminta hanya yang "Sudah di-CTA"
                if ($this->request->cta_status == 'done') continue;
                if ($this->request->status_penawaran) continue; // Skip jika ada filter status deal/hold tapi dia gak punya CTA

                // Masukkan prospek dengan kolom CTA dikosongkan
                $data[] = $this->mapRow($prospek, null);
            }
        }

        return $data;
    }

    /**
     * Format struktur baris Excel
     */
    private function mapRow($prospek, $cta)
    {
        return [
            $prospek->tanggal_prospek,
            $prospek->perusahaan,
            $prospek->nama_pic,
            $prospek->jabatan,
            $prospek->telp,
            $prospek->email,
            $prospek->lokasi,
            $prospek->sumber,
            $prospek->status,
            strip_tags($prospek->catatan), // Hapus tag HTML jika pake rich text
            $prospek->marketing->name ?? 'Belum Diassign',
            
            // --- BAGIAN CTA (Jika null, kembalikan strip "-") ---
            $cta ? $cta->judul_permintaan : '-',
            $cta ? strtoupper($cta->sertifikasi) : '-',
            $cta ? $cta->skema : '-',
            $cta ? $cta->jumlah_peserta : '-',
            $cta ? $cta->harga_penawaran : '-',
            $cta ? $cta->harga_vendor : '-',
            $cta ? ($cta->jumlah_peserta * $cta->harga_penawaran) : '-', // Total Omzet
            $cta ? strtoupper($cta->status_penawaran) : '-',
            $cta ? strip_tags($cta->keterangan) : '-',
        ];
    }

    /**
     * Judul Kolom di Baris 1
     */
    public function headings(): array
    {
        return [
            'Tanggal', 
            'Perusahaan', 
            'Nama PIC', 
            'Jabatan', 
            'Telp/WA', 
            'Email',
            'Lokasi', 
            'Sumber', 
            'Status Prospek', 
            'Catatan Prospek', 
            'Marketing PIC',
            
            // Kolom CTA
            'Judul CTA', 
            'Sertifikasi', 
            'Skema', 
            'Jml Peserta', 
            'Harga Jual', 
            'Harga Modal',
            'Total Potensi Omzet', 
            'Status CTA', 
            'Keterangan CTA'
        ];
    }
}
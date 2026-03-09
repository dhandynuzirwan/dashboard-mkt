<?php

namespace App\Exports;

use App\Models\Prospek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Number;
class ProspekExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    protected $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

public function collection()
{
    $query = Prospek::with(['marketing','cta']);

    // FILTER TANGGAL
    if ($this->requestData->start_date && $this->requestData->end_date) {
        $query->whereBetween('tanggal_prospek', [
            $this->requestData->start_date,
            $this->requestData->end_date
        ]);
    }

    // FILTER MARKETING
    if ($this->requestData->marketing_id) {
        $query->where('marketing_id', $this->requestData->marketing_id);
    }

    // FILTER STATUS AKHIR
    if ($this->requestData->status_akhir) {
        $query->where('status', $this->requestData->status_akhir);
    }

    // FILTER STATUS PENAWARAN
    if ($this->requestData->status_penawaran) {
        $query->whereHas('cta', function ($q) {
            $q->where('status_penawaran', $this->requestData->status_penawaran);
        });
    }

    // FILTER CTA STATUS
    if ($this->requestData->cta_status == 'pending') {
        $query->whereDoesntHave('cta');
    }

    if ($this->requestData->cta_status == 'done') {
        $query->whereHas('cta');
    }

    return $query->orderBy('id','asc')->get();
}

    public function headings(): array
    {
        return [
            'Tanggal Prospek',
            'Nama Marketing',
            'Perusahaan',
            'Nama PIC',
            'WA PIC',
            'Email',
            'Lokasi',
            'Sumber',
            'Status Prospek',

            'Judul Permintaan',
            'Jumlah Peserta',
            'Sertifikasi',
            'Skema',
            'Harga Penawaran',
            'Harga Vendor',
            'Status Penawaran',
        ];
    }

    public function map($prospek): array
    {
        return [
            $prospek->tanggal_prospek,
            optional($prospek->marketing)->name, // 🔥 NAMA bukan ID
            $prospek->perusahaan,
            $prospek->nama_pic,
            $prospek->wa_pic,
            $prospek->email,
            $prospek->lokasi,
            $prospek->sumber,
            $prospek->status,

            optional($prospek->cta)->judul_permintaan,
            optional($prospek->cta)->jumlah_peserta,
            optional($prospek->cta)->sertifikasi,
            optional($prospek->cta)->skema,
            optional($prospek->cta)->harga_penawaran,
            optional($prospek->cta)->harga_vendor,
            optional($prospek->cta)->status_penawaran,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'N' => '"Rp" #,##0', // Harga Penawaran
            'O' => '"Rp" #,##0', // Harga Vendor
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMasuk extends Model
{
    protected $fillable = [
        'marketing_id', 'perusahaan', 'telp', 'unit_bisnis', 
        'email', 'status_email', 'wa_pic', 'wa_baru', 
        'lokasi', 'sumber'
    ];

    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }
    
    // =========================================================
    // TAMBAHKAN KODE INI UNTUK OTOMATISASI DELIVER KE PROSPEK
    // =========================================================
    protected static function booted()
    {
        // 1. Saat data BARU ditambahkan (Insert/Create)
        static::created(function ($dataMasuk) {
            // Jika saat dibuat langsung di-assign ke marketing
            if (!is_null($dataMasuk->marketing_id)) {
                self::autoDeliverToProspek($dataMasuk);
            }
        });

        // 2. Saat data LAMA diubah (Update)
        static::updated(function ($dataMasuk) {
            // Cek apakah kolom marketing_id baru saja diubah dan isinya tidak kosong
            if ($dataMasuk->wasChanged('marketing_id') && !is_null($dataMasuk->marketing_id)) {
                self::autoDeliverToProspek($dataMasuk);
            }
        });
    }

    // Fungsi bantuan agar kode lebih rapi dan tidak berulang
    private static function autoDeliverToProspek($data)
    {
        // Cek agar tidak terjadi double insert di tabel prospek untuk perusahaan & email yang sama
        $sudahAda = Prospek::where('perusahaan', $data->perusahaan)
            ->where('email', $data->email)
            ->exists();

        if (!$sudahAda) {
            Prospek::create([
                'marketing_id'    => $data->marketing_id,
                'tanggal_prospek' => now(),
                'perusahaan'      => $data->perusahaan,
                'lokasi'          => $data->lokasi,
                'telp'            => $data->telp,
                'email'           => $data->email,
                'wa_pic'          => $data->wa_baru ?? $data->wa_pic, // Prioritaskan wa_baru
                'sumber'          => $data->sumber,
            ]);
        }
    }
}
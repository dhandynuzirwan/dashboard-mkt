<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsLead extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'ads_leads';

    /**
     * Properti fillable untuk mengizinkan Mass Assignment.
     * Semua kolom yang dibuat nullable sebelumnya dimasukkan ke sini.
     */
    protected $fillable = [
        'marketing_id',        // Kolom baru yang baru saja kita tambahkan
        'nama_hrd',
        'email',
        'wa_hrd',
        'kebutuhan_program',
        'jenis_sertifikasi',
        'nama_perusahaan',
        'lokasi',
        'jenis_klien',
        'channel_akuisisi',
    ];

    /**
     * Relasi ke Model User (Marketing).
     * Digunakan untuk menampilkan nama marketing di tabel UI.
     */
    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }
}
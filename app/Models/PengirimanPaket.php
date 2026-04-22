<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanPaket extends Model
{
    use HasFactory;

    // Tambahkan semua nama field agar bisa diisi massal (Mass Assignment)
    protected $fillable = [
        'instansi',
        'nama_penerima',
        'no_hp',
        'alamat_pengiriman',
        'jenis_paket',
        'isi_paket',
        'isi_paket_lainnya',
        'ekspedisi',
        'no_resi',
        'biaya_pengiriman',
        'status_pengiriman',
        'tanggal_kirim',
        'tanggal_diterima',
        'catatan_teks',
        'catatan_file',
    ];

    // 🔥 FITUR WAJIB UNTUK CHECKBOX 🔥
    // Otomatis mengubah JSON di database menjadi Array di PHP
    protected $casts = [
        'isi_paket' => 'array', 
    ];
}
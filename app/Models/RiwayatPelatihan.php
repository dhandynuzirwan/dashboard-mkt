<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pelatihans';

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis',
        'metode',
        'judul_pelatihan',
        'jumlah_peserta',
        'nama_peserta',
        'instansi_peserta',
        'wa_peserta',
        'syarat_peserta',
        'ket_syarat',
        'nama_trainer',
        'wa_trainer',
        'cv',
        'modul',
        'nama_lsp',
        'kontak_lsp',
        'tanggal_asesmen',
        'laporan_pic',
        'nama_asesor',
        'wa_asesor',
        'marketing',
        'pic',
        'status_kompeten',
        'status_sertif',
        'scan_sertif',
        'keterangan_tambahan',
        'nama_penerima',
        'wa_penerima',
        'isi_paket',
        'alamat_pengiriman',
        'tanggal_kirim',
        'no_resi',
        'status_pengiriman',
        'tanggal_diterima',
        'foto',
        'catatan'
    ];
}

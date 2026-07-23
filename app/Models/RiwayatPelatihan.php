<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pelatihans';

    protected $fillable = [
        'pelatihan_berjalan_id',
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
        'bukti_kompeten',
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
        'catatan',
        'dokumentasi'
    ];

    protected $casts = [
        'dokumentasi' => 'array',
    ];

    public function getNamaPesertaArrayAttribute()
    {
        return $this->decodeArray($this->nama_peserta);
    }

    public function getInstansiPesertaArrayAttribute()
    {
        return $this->decodeArray($this->instansi_peserta);
    }

    public function getWaPesertaArrayAttribute()
    {
        return $this->decodeArray($this->wa_peserta);
    }

    public function getMarketingArrayAttribute()
    {
        return $this->decodeArray($this->marketing);
    }

    private function decodeArray($value)
    {
        if (empty($value)) return [];
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        return array_map('trim', explode(',', $value));
    }

    public function pelatihanBerjalan()
    {
        return $this->belongsTo(PelatihanBerjalan::class, 'pelatihan_berjalan_id');
    }
}

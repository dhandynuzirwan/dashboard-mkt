<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanBerjalan extends Model
{
    protected $fillable = [
        'master_training_id',
        'tanggal_pelatihan',
        'tanggal_asesmen',
        'lokasi',
        'instruktur',
        'asesor',
        'pengawas',
        'pjk3',
        'pic_klien',
        'status_kelas',
        'evaluasi',
        'status_laporan_internal',
        'status_laporan_kemnaker',
        'file_laporan_internal',
        'file_laporan_kemnaker',
        'resi_pengiriman',
        'foto_resi',
        'foto_tanda_terima',
        'checklist_validasi',
        'status_sertifikat',
        'estimasi_terbit',
        'tgl_terima_lembaga',
        'tgl_kirim_klien',
        'file_scan_sertifikat',
        'nama_penerima',
        'wa_penerima',
        'isi_paket',
        'alamat_pengiriman',
        'tanggal_kirim',
        'status_pengiriman',
        'tanggal_diterima',
        'ekspedisi',
        'catatan_pengiriman',
        'tanggal_selesai',
        'wa_trainer',
        'cv',
        'modul',
        'nama_lsp',
        'kontak_lsp',
        'wa_asesor',
        'keterangan_tambahan'
    ];

    public function training()
    {
        return $this->belongsTo(MasterTraining::class, 'master_training_id');
    }

    public function pendaftaranPribadis()
    {
        return $this->hasMany(PendaftaranPribadi::class, 'pelatihan_berjalan_id');
    }
}

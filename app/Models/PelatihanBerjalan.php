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
        'foto_tanda_terima'
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

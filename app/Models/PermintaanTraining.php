<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanTraining extends Model
{
    protected $fillable = [
        'pelatihan_berjalan_id',
        'status',
        'background_zoom_file',
        'banner_kegiatan_file',
        'photo_profil_grup_wa_file',
        'table_name_file',
        'lanyard_file',
        'sertifikat_internal_file',
        'rekap_foto_file',
        'rekap_video_file',
        'lainnya_file',
    ];

    public function pelatihanBerjalan()
    {
        return $this->belongsTo(PelatihanBerjalan::class, 'pelatihan_berjalan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranPribadi extends Model
{
    protected $guarded = ['id']; // Membiarkan semua kolom bisa diisi kecuali ID

    public function training()
    {
        return $this->belongsTo(MasterTraining::class, 'master_training_id');
    }

    public function kolektif()
    {
        return $this->belongsTo(PendaftaranKolektif::class, 'kolektif_id');
    }

    public function pelatihanBerjalan()
    {
        return $this->belongsTo(PelatihanBerjalan::class, 'pelatihan_berjalan_id');
    }

    public function cta()
    {
        return $this->belongsTo(Cta::class, 'cta_id');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            \App\Models\ActivityLog::log('insert_pendaftaran', 'Operasional', 'warning', 'Terdapat {count} pendaftaran peserta baru');
        });
    }
}
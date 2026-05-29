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
}
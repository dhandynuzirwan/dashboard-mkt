<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranKolektif extends Model
{
    protected $guarded = ['id'];

    public function pesertas()
    {
        return $this->hasMany(PendaftaranPribadi::class, 'kolektif_id');
    }

    public function cta()
    {
        return $this->belongsTo(Cta::class, 'cta_id');
    }
}
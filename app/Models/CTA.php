<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    protected $fillable = [
        'prospek_id', 'judul_permintaan', 'jumlah_peserta', 'sertifikasi', 
        'skema', 'harga_penawaran', 'harga_vendor', 'proposal_link', 
        'status_penawaran', 'keterangan'
    ];

    public function prospek()
    {
        return $this->belongsTo(Prospek::class, 'prospek_id');
    }
    // app/Models/Cta.php
}
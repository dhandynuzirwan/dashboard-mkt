<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterInstruktur extends Model
{
    protected $fillable = [
        'nama_instruktur',
        'wilayah_instansi',
        'no_telepon',
        'bidang_ahli',
        'rate_harga',
        'no_rek',
        'bank',
        'link_cv',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

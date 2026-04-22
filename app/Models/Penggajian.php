<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'user_id', 'gaji_pokok', 'tunjangan', 'tunjangan_bpjs', 'iuran_bpjs', 'target_call', 'target',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

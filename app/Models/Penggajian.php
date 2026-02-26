<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'user_id',
        'target_call',
        'target',
        'gaji_pokok',
        'tunjangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

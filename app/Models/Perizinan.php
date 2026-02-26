<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    protected $fillable = ['user_id', 'external_id', 'tanggal', 'jenis', 'keterangan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
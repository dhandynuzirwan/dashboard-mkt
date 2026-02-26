<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiLog extends Model
{
    protected $table = 'absensi_logs';
    
    protected $fillable = ['user_id', 'tanggal', 'jam', 'tipe', 'source'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
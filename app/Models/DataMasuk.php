<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMasuk extends Model
{
    protected $fillable = [
        'marketing_id', 'perusahaan', 'telp', 'unit_bisnis', 
        'email', 'status_email', 'wa_pic', 'wa_baru', 
        'lokasi', 'sumber'
    ];

    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakPenting extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk diisi
    protected $fillable = [
        'kategori',
        'nama_instansi',
        'nama_pic',
        'nomor_wa',
    ];
}
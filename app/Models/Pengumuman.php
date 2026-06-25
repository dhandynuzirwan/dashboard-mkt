<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'kategori',
        'judul',
        'deskripsi',
        'tanggal_event',
        'is_active',
    ];

    protected $casts = [
        'tanggal_event' => 'date',
        'is_active' => 'boolean',
    ];
}

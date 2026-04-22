<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    // Daftar kolom yang boleh diisi secara massal lewat form
    protected $fillable = [
        'kode', 
        'nama', 
        'kategori', 
        'tgl_masuk', 
        'lokasi', 
        'pic', 
        'harga', 
        'kondisi', 
        'foto', 
        'keterangan'
    ];
}
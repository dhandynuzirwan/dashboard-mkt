<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunAkses extends Model
{
    use HasFactory;

    // 🔥 TAMBAHKAN KODE INI 🔥
    // Beri tahu Laravel kolom apa saja yang diizinkan untuk diisi
    protected $fillable = [
        'platform',
        'kategori',
        'username_email',
        'password',
        'url_login',
        'catatan',
    ];
}
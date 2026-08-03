<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBiasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'deadline',
        'tujuan',
        'deskripsi',
        'referensi_file',
        'hasil_file',
        'catatan',
        'prioritas',
        'status',
        'pic_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}

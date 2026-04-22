<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;

    // Arahkan ke tabel yang benar
    protected $table = 'daily_logs';

    protected $fillable = [
        'user_id',
        'tanggal_aktivitas',
        'nama_kegiatan',
        'durasi_menit',
        'deskripsi',
        'file_evidence',
        'link_evidence',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
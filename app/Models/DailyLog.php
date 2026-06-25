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
        'user_id', 'tanggal_aktivitas', 'nama_kegiatan', 
        'status', 'durasi_menit', 'deskripsi', 'file_evidence', 'link_evidence'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $user = \Illuminate\Support\Facades\Auth::user()->name ?? 'Sistem';
            \App\Models\ActivityLog::log('insert_dailylog', 'Aktivitas', 'success', "{$user} mencatat {count} aktivitas harian");
        });
    }
}
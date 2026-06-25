<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulPelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_modul',
        'sertifikasi',
        'kategori',
        'pengajar',
        'tahun',
        'ukuran_file',
        'status',
        'total_download',
        'file_path',
        'pengupload_id',
    ];

    public function pengupload()
    {
        return $this->belongsTo(User::class, 'pengupload_id');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $user = \Illuminate\Support\Facades\Auth::user()->name ?? 'Sistem';
            \App\Models\ActivityLog::log('insert_modul', 'Admin', 'info', "{$user} mengunggah {count} modul pelatihan baru");
        });
    }
}

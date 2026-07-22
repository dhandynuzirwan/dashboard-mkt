<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'divisi',
        'tugas',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'dukungan_fasilitas',
        'catatan',
        'status_spv',
        'status_hrd',
        'status_direktur',
        'status_akhir',
        'spv_id',
        'hrd_id',
        'direktur_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spv()
    {
        return $this->belongsTo(User::class, 'spv_id');
    }

    public function hrd()
    {
        return $this->belongsTo(User::class, 'hrd_id');
    }

    public function direktur()
    {
        return $this->belongsTo(User::class, 'direktur_id');
    }
}

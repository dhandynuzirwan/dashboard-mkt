<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospek extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_id', 'tanggal_prospek', 'perusahaan', 'telp', 'email', 
        'jabatan', 'nama_pic', 'wa_pic', 'wa_baru', 'lokasi', 
        'sumber', 'update_terakhir', 'status', 'deskripsi', 'catatan'
    ];

    // Relasi ke user (Marketing)
    public function marketing() {
        return $this->belongsTo(User::class, 'marketing_id');
    }
    // Relasi ke CTA    public function cta() {
    public function cta() {
        return $this->hasOne(Cta::class);
    }
}
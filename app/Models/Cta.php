<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    protected $fillable = [
        'prospek_id',
        'judul_permintaan',
        'jumlah_peserta',
        'sertifikasi',
        'skema',
        'harga_penawaran',
        'harga_vendor',
        'total_penawaran',
        'total_vendor',
        'proposal_link',
        'file_proposal',
        'status_penawaran',
        'keterangan',
        'tanggal_pelaksanaan',
    ];

    public function prospek()
    {
        return $this->belongsTo(Prospek::class, 'prospek_id');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $user = \Illuminate\Support\Facades\Auth::user()->name ?? 'Sistem';
            \App\Models\ActivityLog::log('insert_cta', 'Marketing', 'warning', "{$user} menambahkan {count} CTA (Call to Action) baru");
        });
    }
}

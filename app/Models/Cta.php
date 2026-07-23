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
        'tanggal_selesai',
        'status_registrasi_manual',
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

        static::updated(function ($cta) {
            // We only care about tracking if it's currently a deal or was a deal
            if ($cta->getOriginal('status_penawaran') === 'deal' || $cta->status_penawaran === 'deal') {
                $fieldsToTrack = ['harga_penawaran', 'harga_vendor', 'status_penawaran'];
                $userId = \Illuminate\Support\Facades\Auth::id();

                foreach ($fieldsToTrack as $field) {
                    if ($cta->isDirty($field)) {
                        \App\Models\CtaHistory::create([
                            'cta_id' => $cta->id,
                            'user_id' => $userId,
                            'field' => $field,
                            'old_value' => $cta->getOriginal($field),
                            'new_value' => $cta->$field,
                        ]);
                    }
                }
            }
        });
    }
}

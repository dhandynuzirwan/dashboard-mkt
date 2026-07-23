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
            $userId = \Illuminate\Support\Facades\Auth::id();

            // Check status_penawaran: Only log if changed FROM 'deal' TO something else
            if ($cta->isDirty('status_penawaran')) {
                $oldStatus = $cta->getOriginal('status_penawaran');
                $newStatus = $cta->status_penawaran;
                
                if ($oldStatus === 'deal' && $newStatus !== 'deal') {
                    \App\Models\CtaHistory::create([
                        'cta_id' => $cta->id,
                        'user_id' => $userId,
                        'field' => 'status_penawaran',
                        'old_value' => $oldStatus,
                        'new_value' => $newStatus,
                    ]);
                }
            }

            // For prices, only log if the data is currently 'deal' or was 'deal'
            if ($cta->getOriginal('status_penawaran') === 'deal' || $cta->status_penawaran === 'deal') {
                $priceFields = ['harga_penawaran', 'harga_vendor'];
                foreach ($priceFields as $field) {
                    if ($cta->isDirty($field)) {
                        $oldPrice = (float) $cta->getOriginal($field);
                        
                        // Only log if old price is > 0 (ignore change from 0 or null)
                        if ($oldPrice > 0) {
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
            }
        });
    }
}

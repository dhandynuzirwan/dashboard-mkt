<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadRequest extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'marketing_id',
        'status_akhir',
        'status_penawaran',
        'cta_status',
        'reason',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

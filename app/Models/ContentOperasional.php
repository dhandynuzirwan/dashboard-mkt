<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentOperasional extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'tanggal_brief',
        'target_deadline',
        'tanggal_selesai',
        'status_deadline',
        'platform',
        'format_konten',
        'judul_konten',
        'jumlah_revisi',
        'link_aset',
    ];

    public function metric()
    {
        return $this->hasOne(ContentMetric::class, 'content_id', 'content_id');
    }

    public function evaluation()
    {
        return $this->hasOne(ContentEvaluation::class, 'content_id', 'content_id');
    }
}

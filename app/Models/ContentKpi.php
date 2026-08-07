<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_bulan',
        'total_target_konten',
        'total_realisasi_konten',
        'on_time_rate',
        'avg_revision_rate',
        'avg_engagement_rate',
        'total_saves_shares',
        'skor_pencapaian_kpi',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'skor_brand_guideline',
        'jumlah_template_baru',
        'laporan_riset_status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'tanggal_tayang',
        'total_impressions',
        'total_reach',
        'total_likes',
        'total_comments',
        'total_saves',
        'total_shares',
        'calculated_er',
    ];
}

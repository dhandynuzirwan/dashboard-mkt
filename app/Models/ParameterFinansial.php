<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterFinansial extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan_tahun',
        'hpp_per_bulan',
        'target_minimal',
    ];
}

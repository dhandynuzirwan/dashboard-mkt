<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterFinansial extends Model
{
    use HasFactory;

    protected $fillable = ['bulan_tahun', 'target_minimal'];
}

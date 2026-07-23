<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtaHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'cta_id',
        'user_id',
        'field',
        'old_value',
        'new_value',
    ];

    public function cta()
    {
        return $this->belongsTo(Cta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

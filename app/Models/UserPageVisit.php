<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPageVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'route_name',
        'visits',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterArtikel extends Model
{
    protected $fillable = [
        'kategori_artikel',
        'judul_artikel',
        'naskah_artikel',
        'status_publish',
        'link_publikasi',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

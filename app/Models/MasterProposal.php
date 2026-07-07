<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProposal extends Model
{
    protected $fillable = [
        'lembaga',
        'kategori',
        'judul_proposal',
        'file_proposal_path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

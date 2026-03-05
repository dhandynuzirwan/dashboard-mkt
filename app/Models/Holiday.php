<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    /**
     * Properti yang dapat diisi melalui mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal', 
        'keterangan'
    ];
}
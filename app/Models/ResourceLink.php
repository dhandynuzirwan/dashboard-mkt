<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceLink extends Model
{
    use HasFactory;

    protected $table = 'resource_links';
    protected $fillable = ['nama_dokumen', 'url_link', 'kategori'];
}
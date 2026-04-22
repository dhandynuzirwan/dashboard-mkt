<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 
        'kategori', 
        'satuan', 
        'stok', 
        'min_stok'
    ];

    // Relasi: 1 Barang bisa memiliki banyak Log Mutasi (Histori in/out)
    public function logs()
    {
        return $this->hasMany(ItemLog::class, 'item_id');
    }
}
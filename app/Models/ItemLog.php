<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 
        'user_id', 
        'tipe', // 'in' atau 'out'
        'qty', 
        'keterangan'
    ];

    // Relasi: Log ini milik Barang yang mana?
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Relasi: Log ini dibuat oleh Pegawai siapa?
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $tipeStr = $model->tipe == 'in' ? 'masuk' : 'keluar';
            $user = \Illuminate\Support\Facades\Auth::user()->name ?? 'Sistem';
            \App\Models\ActivityLog::log('insert_itemlog_'.$model->tipe, 'Inventory', 'warning', "{$user} mencatat {count} stok barang {$tipeStr}");
        });
    }
}
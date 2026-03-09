<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdsLeadController; // Pastikan namespace-nya benar

// Tambahkan baris ini
Route::post('/v1/sync-ads', [AdsLeadController::class, 'store']);
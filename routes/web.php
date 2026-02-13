<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/revenue', function () {
    return view('revenue');
});

Route::get('/progress', function () {
    return view('dashboard-progress');
});

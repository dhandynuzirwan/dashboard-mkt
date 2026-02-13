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

Route::get('/data-kpi', function () {
    return view('Data-KPI');
});

Route::get('/simulasi-gaji', function () {
    return view('simulasi-gaji');
});

Route::get('/pipeline', function () {
    return view('pipeline');
});
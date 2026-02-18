<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/revenue', function () {
    return view('revenue');
})->name ('revenue');

Route::get('/dashboard-progress', function () {
    return view('dashboard-progress');
})->name('dashboard.progress');

Route::get('/data-kpi', function () {
    return view('Data-KPI');
})->name ('data-kpi');

Route::get('/simulasi-gaji', function () {
    return view('simulasi-gaji');
})-> name ('simulasi-gaji');

Route::get('/pipeline', function () {
    return view('pipeline');
})-> name ('pipeline');

Route::get('/user', function () {
    return view('user');
})-> name ('user');

Route::get('/absensi', function () {
    return view('absensi');
})->name('absensi');

Route::get('/data-prospek', function () {
    return view('data-prospek');
})->name('data-prospek');
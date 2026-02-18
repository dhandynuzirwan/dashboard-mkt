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

Route::get('/penggajian', function () {
    return view('penggajian');
})-> name ('penggajian');

Route::get('/pipeline', function () {
    return view('pipeline');
})-> name ('pipeline');

Route::get('/user', function () {
    return view('user');
})-> name ('user');

Route::get('/absensi', function () {
    return view('absensi');
})->name('absensi');

//form input data prospek
Route::get('/form-prospek', function () {
    return view('form-prospek');
})->name('form-prospek');

Route::get('/form-cta', function () {
    return view('form-cta');
})->name('form-cta');

Route::get('/form-tambah-pengguna', function () {
    return view('form-tambah-pengguna');
})->name('form-tambah-pengguna');

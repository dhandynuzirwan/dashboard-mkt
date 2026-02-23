<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    return back()->with('error', 'Email atau password salah');

})->name('login.process');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/dashboard-progress', function () {
        return view('dashboard-progress');
    })->name('dashboard.progress');

    Route::get('/revenue', function () {
        return view('revenue');
    })->name('revenue');

    Route::get('/data-kpi', function () {
        return view('Data-KPI');
    })->name('data-kpi');

    Route::get('/simulasi-gaji', function () {
        return view('simulasi-gaji');
    })->name('simulasi-gaji');

//HUMAN RESOURCES superadmin only
    Route::middleware('role:superadmin')->group(function () {

        Route::get('/user', function () {
            return view('user');
        })->name('user');

        Route::get('/penggajian', function () {
            return view('penggajian');
        })->name('penggajian');

        Route::get('/absensi', function () {
            return view('absensi');
        })->name('absensi');

    });

 // MARKETING & SALES superadmin + admin
Route::middleware('role:superadmin,admin,marketing')->group(function () {

    Route::get('/form-prospek', function () {
        return view('form-prospek');
    })->name('form-prospek');

    Route::get('/pipeline', function () {
        return view('pipeline');
    })->name('pipeline');

});

});
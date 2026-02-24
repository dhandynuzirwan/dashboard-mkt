<?php

use App\Http\Controllers\CtaController;
use App\Http\Controllers\DataMasukController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\PenggajianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Login / Logout)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard.progress');
    }
    return back()->with('error', 'Email atau password salah');
})->name('login.process');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // --- DASHBOARD & UMUM ---
    Route::get('/', function () {
        return view('dashboard-progress');
    })->name('dashboard.progress');

    Route::get('/dashboard-progress', function () {
        return view('dashboard-progress');
    });

    Route::get('/revenue', function () {
        return view('revenue');
    })->name('revenue');

    Route::get('/data-kpi', function () {
        return view('Data-KPI');
    })->name('data-kpi');

    Route::get('/simulasi-gaji', function () {
        return view('simulasi-gaji');
    })->name('simulasi-gaji');


    /*
    |--------------------------------------------------------------------------
    | AKSES BERSAMA (SUPERADMIN, ADMIN, MARKETING)
    |--------------------------------------------------------------------------
    | Route di sini bisa diakses & difilter oleh semua role
    */
    Route::middleware('role:superadmin,admin,marketing')->group(function () {
        
        // Halaman Pipeline Utama & Fitur Filter
        Route::get('/pipeline', [ProspekController::class, 'index'])->name('prospek.index');
        Route::get('/pipeline-alias', [ProspekController::class, 'index'])->name('pipeline'); // Tambahan ini
        
    });


    /*
    |--------------------------------------------------------------------------
    | KHUSUS SUPERADMIN & ADMIN
    |--------------------------------------------------------------------------
    | Izin untuk melakukan input data awal (Prospek & Data Masuk)
    */
    Route::middleware('role:superadmin,admin')->group(function () {

        // Pengelolaan Prospek
        Route::get('/form-prospek', [ProspekController::class, 'create'])->name('form-prospek');
        Route::post('/prospek/store', [ProspekController::class, 'store'])->name('prospek.store');

        // Pengelolaan Data Masuk
        Route::get('/form-data-masuk', [DataMasukController::class, 'create'])->name('form-data-masuk');
        Route::post('/data-masuk/store', [DataMasukController::class, 'store'])->name('data-masuk.store');
        
    });


    /*
    |--------------------------------------------------------------------------
    | KHUSUS MARKETING
    |--------------------------------------------------------------------------
    | Izin untuk melanjutkan prospek ke tahap penawaran (CTA)
    */
    Route::middleware('role:marketing')->group(function () {
        
        Route::get('/form-cta/{prospek_id}', [CtaController::class, 'create'])->name('form-cta');
        Route::post('/cta/store', [CtaController::class, 'store'])->name('cta.store');
        
    });


    /*
    |--------------------------------------------------------------------------
    | KHUSUS SUPERADMIN (Human Resources & User Management)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:superadmin')->group(function () {

        // User Management
        Route::get('/user', function () {
            $users = \App\Models\User::all();
            return view('user', compact('users'));
        })->name('user');

        Route::get('/form-tambah-pengguna', function () {
            return view('form-tambah-pengguna');
        })->name('form-tambah-pengguna');

        Route::post('/user/store', function (Request $request) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:superadmin,admin,marketing',
            ]);

            \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password, // Auto hash jika diatur di model
                'role' => $request->role,
            ]);
            return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
        })->name('user.store');

        // Penggajian & Absensi
        Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
        Route::get('/form-penggajian', [PenggajianController::class, 'create'])->name('form-penggajian');
        Route::post('/penggajian/store', [PenggajianController::class, 'store'])->name('penggajian.store');

        Route::get('/absensi', function () {
            return view('absensi');
        })->name('absensi');

        Route::get('/form-absensi', function () {
            return view('form-absensi');
        })->name('form-absensi');
    });

});
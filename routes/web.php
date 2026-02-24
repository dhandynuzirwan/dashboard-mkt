<?php

use App\Http\Controllers\CtaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMasukController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SalaryController;
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

    // --- DASHBOARD UTAMA ---
    // Arahkan root (/) dan /dashboard-progress ke Controller yang sama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.progress');
    Route::get('/dashboard-progress', [DashboardController::class, 'index']);
    Route::get('/search', [GlobalSearchController::class, 'index'])->name('search.global');

    // Route untuk AJAX Detail Popup (Modal) di Dashboard
    Route::get('/marketing-detail/{id}', [DashboardController::class, 'getDetail'])->name('marketing.detail');

    Route::get('/revenue', [RevenueController::class, 'index'])
        ->name('revenue');

    Route::get('/data-kpi', [KpiController::class, 'index'])->name('data-kpi');

    Route::get('/simulasi-gaji', [SalaryController::class, 'index'])->name('simulasi-gaji');

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
        Route::get('/data-masuk', [DataMasukController::class, 'index'])->name('data-masuk'); // Tambahkan ini!
        Route::get('/form-data-masuk', [DataMasukController::class, 'create'])->name('form-data-masuk');
        Route::post('/data-masuk/store', [DataMasukController::class, 'store'])->name('data-masuk.store');

        // ================= EDIT =================
        Route::get('/data-masuk/{id}/edit', [DataMasukController::class, 'edit'])
            ->name('data-masuk.edit');

        Route::put('/data-masuk/{id}', [DataMasukController::class, 'update'])
            ->name('data-masuk.update');

        // ================= DELETE =================
        Route::delete('/data-masuk/{id}', [DataMasukController::class, 'destroy'])
            ->name('data-masuk.destroy');

        // ================= EDIT PROSPEK =================
        Route::get('/prospek/{id}/edit', [ProspekController::class, 'edit'])
            ->name('prospek.edit');

        Route::put('/prospek/{id}', [ProspekController::class, 'update'])
            ->name('prospek.update');
        
        Route::get('/penggajian', [PenggajianController::class, 'index'])
        ->name('penggajian.index');

    Route::get('/form-penggajian', [PenggajianController::class, 'create'])
        ->name('form-penggajian');

    Route::post('/penggajian/store', [PenggajianController::class, 'store'])
        ->name('penggajian.store');

    //  TAMBAHAN CRUD
    Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])
        ->name('penggajian.edit');

    Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])
        ->name('penggajian.update');

    Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])
        ->name('penggajian.destroy');
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

    // ================= EDIT CTA =================
    Route::get('/cta/{id}/edit', [CtaController::class, 'edit'])->name('cta.edit');
    Route::put('/cta/{id}', [CtaController::class, 'update'])->name('cta.update');

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

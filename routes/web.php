<?php

use App\Http\Controllers\CTAController;
use App\Http\Controllers\DataMasukController;
use App\Http\Controllers\ProspekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggajianController;

/*
|--------------------------------------------------------------------------
| AUTH
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

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

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
    | SUPERADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:superadmin')->group(function () {

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
                'password' => $request->password, // auto hash via cast di model
                'role' => $request->role,
            ]);

            return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
        })->name('user.store');

        Route::get('/penggajian', function () {
            return view('penggajian');
        })->name('penggajian');

        Route::get('/absensi', function () {
            return view('absensi');
        })->name('absensi');

        Route::get('/form-penggajian', function () {
            return view('form-penggajian');
        })->name('form-penggajian');

        Route::get('/form-absensi', function () {
            return view('form-absensi');
        })->name('form-absensi');

        Route::get('/penggajian', [PenggajianController::class, 'index'])
            ->name('penggajian.index');

        Route::get('/form-penggajian', [PenggajianController::class, 'create'])
            ->name('form-penggajian');

        Route::post('/penggajian/store', [PenggajianController::class, 'store'])
            ->name('penggajian.store');
    });

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN + ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:superadmin,admin')->group(function () {

        Route::get('/pipeline', [ProspekController::class, 'index'])->name('pipeline');

        Route::get('/prospek', [ProspekController::class, 'index'])->name('prospek.index');

        Route::get('/form-prospek', [ProspekController::class, 'create'])->name('form-prospek');

        Route::get('/prospek/create', [ProspekController::class, 'create'])->name('prospek.create');

        Route::post('/prospek/store', [ProspekController::class, 'store'])->name('prospek.store');

        Route::get('/data-masuk', [DataMasukController::class, 'index'])->name('data-masuk');

        Route::get('/form-data-masuk', [DataMasukController::class, 'create'])->name('form-data-masuk');

        Route::post('/data-masuk/store', [DataMasukController::class, 'store'])->name('data-masuk.store');
    });

    /*
    |--------------------------------------------------------------------------
    | MARKETING ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:marketing')->group(function () {

        Route::get('/form-cta/{prospek_id}', [CTAController::class, 'create'])->name('form-cta');

        Route::post('/cta/store', [CTAController::class, 'store'])->name('cta.store');
    });
});

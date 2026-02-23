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
        return view('dashboard-progress');
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

Route::get('/form-penggajian', function () {
    return view('form-penggajian');
})->name('form-penggajian');

Route::get('/form-absensi', function () {
    return view('form-absensi');
})->name('form-absensi');

Route::get('/data-masuk', function () {
    return view('data-masuk');
})->name('data-masuk');

Route::get('/form-data-masuk', function () {
    return view('form-data-masuk');
})->name('form-data-masuk');

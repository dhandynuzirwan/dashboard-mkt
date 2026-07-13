<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Api\AdsLeadController;
use App\Http\Controllers\CtaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMasukController;
use App\Http\Controllers\DownloadRequestController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\MasterTrainingController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperationalController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\PengirimanPaketController;
use App\Http\Controllers\RiwayatPelatihanController;
use App\Http\Controllers\AkunAksesController;
use App\Http\Controllers\OperationalPendaftaranController;
use App\Http\Controllers\PendaftaranKolektifController;
use App\Http\Controllers\PendaftaranPribadiController;
use App\Http\Controllers\ParameterFinansialController;
use App\Http\Controllers\MonitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Login / Logout / Portal Public)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// --- PROSES LOGIN ---
Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        
        // 🔥 Ubah arah redirect ke halaman Landing Page Pembuka (home) 🔥
        return redirect()->intended(route('home'));
    }
    
    return back()->with('error', 'Email atau password salah');
})->name('login.process');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Route untuk Mockup Portal Peserta
Route::prefix('portal')->group(function () {
    Route::get('/', function () { return view('portal.index'); });

    // Pendaftaran Pribadi
    Route::get('/pendaftaran-pribadi', [PendaftaranPribadiController::class, 'create'])->name('portal.pendaftaran.create');
    Route::post('/pendaftaran-pribadi', [PendaftaranPribadiController::class, 'store'])->name('portal.pendaftaran.store');
    
    // Pendaftaran Kolektif
    Route::get('/pendaftaran-instansi', [PendaftaranKolektifController::class, 'create'])->name('portal.pendaftaran.kolektif');
    Route::post('/pendaftaran-instansi', [PendaftaranKolektifController::class, 'store'])->name('portal.pendaftaran.kolektif.store');

    // 🔥 SATU HALAMAN SUKSES UNTUK KEDUANYA 🔥
    Route::get('/pendaftaran-sukses', function () {
        if (!session('success')) return redirect()->route('portal.index');
        return view('portal.sukses');
    })->name('portal.pendaftaran.sukses');

    // Cek Status
    Route::get('/cek-status', [PendaftaranPribadiController::class, 'cekStatus'])->name('portal.cek-status');
    Route::post('/cek-status/{id}/revisi', [PendaftaranPribadiController::class, 'updateRevisi'])->name('portal.pendaftaran.revisi');
    Route::get('/cek-status-perusahaan', [PendaftaranKolektifController::class, 'cekStatusPerusahaan'])->name('portal.cek-status-perusahaan');
    Route::post('/cek-status-perusahaan/{id}/revisi', [PendaftaranKolektifController::class, 'updateRevisi'])->name('portal.kolektif.revisi');
    Route::get('/download-modul/{id}', [PendaftaranPribadiController::class, 'downloadModul'])->name('portal.download-modul');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware('auth')->group(function () {

    // --- DASHBOARD & GLOBAL (Semua yang login bisa akses) ---
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard.progress');
    // Route::get('/dashboard-progress', [DashboardController::class, 'index']);
    Route::get('/marketing-detail/{id}', [DashboardController::class, 'getDetail'])->name('marketing.detail');
    Route::get('/search-global', [SearchController::class, 'globalSearch'])->name('search.global');
    Route::get('/penggajian/slip-preview/{id}', [SalaryController::class, 'previewSlip'])->name('penggajian.preview');

    // Route Khusus Edit Profil Sendiri
    Route::get('/my-profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('my-profile.edit');
    Route::post('/my-profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('my-profile.update');
    
    // ================= RUTE PENGAJUAN IZIN & CUTI (Semua Karyawan) =================
    Route::get('/pengajuan-izin', [\App\Http\Controllers\PengajuanIzinController::class, 'index'])->name('pengajuan-izin.index');
    Route::get('/pengajuan-izin/create', [\App\Http\Controllers\PengajuanIzinController::class, 'create'])->name('pengajuan-izin.create');
    Route::post('/pengajuan-izin', [\App\Http\Controllers\PengajuanIzinController::class, 'store'])->name('pengajuan-izin.store');
    
    // ================= RUTE BRANKAS AKUN =================
    // Menggunakan Route::resource agar otomatis membuat rute index, store, dan destroy
    Route::resource('akun-vault', AkunAksesController::class)->names([
        'index'   => 'akun.index',
        'store'   => 'akun.store',
        'update'  => 'akun.update',
        'destroy' => 'akun.destroy',
    ])->except(['create', 'show', 'edit']); // Kita kecualikan yang tidak dipakai

    // ================= RUTE MODUL PELATIHAN =================
    Route::get('/modul-pelatihan', [\App\Http\Controllers\ModulPelatihanController::class, 'index'])->name('modul.index');
    Route::post('/modul-pelatihan', [\App\Http\Controllers\ModulPelatihanController::class, 'store'])->name('modul.store');
    Route::put('/modul-pelatihan/{id}', [\App\Http\Controllers\ModulPelatihanController::class, 'update'])->name('modul.update');
    Route::delete('/modul-pelatihan/{id}', [\App\Http\Controllers\ModulPelatihanController::class, 'destroy'])->name('modul.destroy');
    Route::get('/modul-pelatihan/{id}/download', [\App\Http\Controllers\ModulPelatihanController::class, 'download'])->name('modul.download');
    Route::get('/modul-pelatihan/{id}/preview', [\App\Http\Controllers\ModulPelatihanController::class, 'preview'])->name('modul.preview');

    Route::get('/absensi-online', [AbsensiController::class, 'indexKamera'])->name('pegawai.absensi.index');
    
    // Proses Simpan Data Absen & Foto Selfie
    Route::post('/absensi-online', [AbsensiController::class, 'storeKamera'])->name('pegawai.absensi.store');

    /*
    |--------------------------------------------------------------------------
    | AKSES BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */
    // --- MENU PERFORMANCE (Khusus Superadmin, Webdev, SPV) ---
    // Asumsi kamu menggunakan middleware 'role' (sesuaikan jika menggunakan middleware/penamaan lain)
    Route::middleware('role:superadmin,web_dev,spv_marketing,admin,rnd')->group(function () {
        Route::get('/dashboard-progress', [DashboardController::class, 'index'])->name('dashboard.progress');
        // Placeholder untuk On Display Monitor
        // Route On Display Monitor
        Route::get('/on-display-monitor', [MonitorController::class, 'index'])->name('performance.display');
        Route::get('/api/monitor-data', [MonitorController::class, 'getData'])->name('api.monitor.data');
    });

    // 0. KHUSUS MENU OPERASIONAL (Superadmin, Web Developer, Operasional, Team Leader, SPV)
    Route::middleware('role:superadmin,web_dev,operasional,team_leader,spv_marketing,graphic')->group(function () {
        
        // Portal Back Office (Links)
        Route::get('/operational', [OperationalController::class, 'index'])->name('operational');
        Route::post('/operational/store-link', [OperationalController::class, 'storeResource'])->name('operational.store-link');
        Route::put('/operational/update-link/{id}', [OperationalController::class, 'updateResource'])->name('operational.update-link');
        Route::delete('/operational/destroy-link/{id}', [OperationalController::class, 'destroyResource'])->name('operational.destroy-link');
        Route::post('/operational/kontak', [OperationalController::class, 'storeKontak'])->name('operational.store-kontak');
        Route::delete('/operational/kontak/{id}', [OperationalController::class, 'destroyKontak'])->name('operational.destroy-kontak');
        Route::get('/monitoring-pelatihan', [OperationalController::class, 'monitoringPelatihan'])->name('monitoring.pelatihan');
        Route::get('/monitoring-pelatihan/tv', [OperationalController::class, 'monitorTv'])->name('monitoring.pelatihan.tv');
        Route::get('/api/monitoring-pelatihan/tv-data', [OperationalController::class, 'monitorTvData'])->name('api.monitoring.pelatihan.tv-data');
        Route::put('/monitoring-pelatihan/{id}', [OperationalController::class, 'updatePelatihanBerjalan'])->name('monitoring.pelatihan.update');
        Route::delete('/monitoring-pelatihan/{id}', [OperationalController::class, 'destroyPelatihanBerjalan'])->name('operational.pelatihan-berjalan.destroy');

        Route::middleware('role:superadmin,web_dev,team_leader,operasional,spv_marketing,graphic')->group(function () {
            Route::get('/riwayat-pelatihan', [RiwayatPelatihanController::class, 'index'])->name('riwayat.pelatihan');
            Route::post('/riwayat-pelatihan', [RiwayatPelatihanController::class, 'store'])->name('riwayat.pelatihan.store');
            Route::put('/riwayat-pelatihan/{id}', [RiwayatPelatihanController::class, 'update'])->name('riwayat.pelatihan.update');

            Route::put('/riwayat-pelatihan/{id}/peserta/{index}', [RiwayatPelatihanController::class, 'updatePeserta'])->name('riwayat.pelatihan.updatePeserta');
            Route::post('/riwayat-pelatihan/{id}/tambah-peserta-massal', [RiwayatPelatihanController::class, 'tambahPesertaMassal'])->name('riwayat.pelatihan.tambahPesertaMassal');
            Route::delete('/riwayat-pelatihan/{id}/peserta/{index}', [RiwayatPelatihanController::class, 'hapusPeserta'])->name('riwayat.pelatihan.hapusPeserta');
        });


        Route::prefix('operational')->group(function () {
            Route::get('/data-pendaftaran', [OperationalPendaftaranController::class, 'index'])->name('operational.data-pendaftaran');
            Route::post('/data-pendaftaran/verify/{id}', [OperationalPendaftaranController::class, 'verify'])->name('operational.pendaftaran.verify');
            Route::delete('/data-pendaftaran/{id}', [OperationalPendaftaranController::class, 'destroy'])->name('operational.pendaftaran.destroy');
        });

        // Aktivitas Harian
        Route::get('/aktivitas-harian', [DailyLogController::class, 'index'])->name('operational.aktivitas-harian');
        Route::post('/aktivitas-harian', [DailyLogController::class, 'store'])->name('operational.aktivitas-harian.store');
        
        // TAMBAHAN UNTUK EDIT & HAPUS:
        Route::put('/aktivitas-harian/{id}', [DailyLogController::class, 'update'])->name('operational.aktivitas-harian.update');
        Route::delete('/aktivitas-harian/{id}', [DailyLogController::class, 'destroy'])->name('operational.aktivitas-harian.destroy');
        
        Route::post('/aktivitas-harian/import', [\App\Http\Controllers\DailyLogController::class, 'importExcel'])->name('aktivitas-harian.import');
        // Aset & Monitoring
        // Route::get('/aset-inventaris', function () {
        //     return view('operational.inventaris');
        // })->name('operational.inventaris');
        
        // --- ROUTE INVENTARIS & ASET ---
        Route::get('/inventaris', [App\Http\Controllers\InventoryController::class, 'index'])->name('operational.inventaris');
        Route::post('/inventaris/aset', [App\Http\Controllers\InventoryController::class, 'storeAset'])->name('inventaris.aset.store');
        Route::post('/inventaris/item', [App\Http\Controllers\InventoryController::class, 'storeItem'])->name('inventaris.item.store');
        Route::post('/inventaris/mutasi/{id}', [App\Http\Controllers\InventoryController::class, 'updateStok'])->name('inventaris.mutasi');
        Route::put('/inventaris/item/{id}', [App\Http\Controllers\InventoryController::class, 'updateItem'])->name('inventaris.item.update');
        Route::delete('/inventaris/item/{id}', [App\Http\Controllers\InventoryController::class, 'destroyItem'])->name('inventaris.item.destroy');
        Route::put('/inventaris/aset/{id}', [App\Http\Controllers\InventoryController::class, 'updateAset'])->name('inventaris.aset.update');
        Route::delete('/inventaris/aset/{id}', [App\Http\Controllers\InventoryController::class, 'destroyAset'])->name('inventaris.aset.destroy');
        
        Route::resource('monitoring-paket', PengirimanPaketController::class)->names([
            'index' => 'operational.monitoring-paket',
        ]);
        Route::put('/monitoring-paket/{id}', [PengirimanPaketController::class, 'update'])->name('monitoring-paket.update');
        Route::post('/monitoring-paket/import', [App\Http\Controllers\PengirimanPaketController::class, 'import'])->name('operational.monitoring-paket.import');
    });

    // 1. FITUR UMUM (Superadmin, Web Dev, Admin, Marketing, RnD, Digital Marketing)
    Route::middleware('role:superadmin,web_dev,spv_marketing,admin,marketing,rnd,digitalmarketing,operasional,team_leader,graphic')->group(function () {
        
        
        Route::post('/download-request', [DownloadRequestController::class, 'store'])->name('download.request');
        Route::get('/download-file/{id}', [DownloadRequestController::class, 'download'])->name('download.file');
        Route::get('/my-downloads', [DownloadRequestController::class, 'myRequests'])->name('download.my');
        
        Route::get('/panduan', [App\Http\Controllers\PanduanController::class, 'index'])->name('panduan.index');
    });

    // 2. ANALYTICS & REPORTING
    Route::middleware('role:superadmin,web_dev,spv_marketing,marketing')->group(function () {
        Route::get('/data-kpi', [KpiController::class, 'index'])->name('data-kpi');
    });

    Route::middleware('role:superadmin,web_dev,marketing')->group(function () {
        Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue');
        Route::get('/simulasi-gaji', [SalaryController::class, 'index'])->name('simulasi-gaji');
    });

    // 2. MONITORING BISNIS (Superadmin, Web Dev, Admin, Marketing)
    Route::middleware('role:superadmin,web_dev,spv_marketing,admin,marketing')->group(function () {
        Route::get('/pipeline', [ProspekController::class, 'index'])->name('prospek.index');
        Route::get('/pipeline-alias', [ProspekController::class, 'index'])->name('pipeline');
        
        Route::get('/form-cta/{prospek_id}', [CtaController::class, 'create'])->name('form-cta');
        Route::post('/cta/store', [CtaController::class, 'store'])->name('cta.store');
        Route::get('/cta/{id}/edit', [CtaController::class, 'edit'])->name('cta.edit');
        Route::put('/cta/{id}', [CtaController::class, 'update'])->name('cta.update');
        Route::delete('/cta/{id}', [CtaController::class, 'destroy'])->name('cta.destroy');
    });

    // 3. PENGELOLAAN DATA & TRAINING (Superadmin, Web Dev, Admin, RnD, Digital Marketing)
    Route::middleware('role:superadmin,web_dev,spv_marketing,admin,rnd,digitalmarketing')->group(function () {
        Route::get('/data-masuk', [DataMasukController::class, 'index'])->name('data-masuk.index');
        Route::get('/form-data-masuk', [DataMasukController::class, 'create'])->name('form-data-masuk');
        Route::post('/data-masuk/store', [DataMasukController::class, 'store'])->name('data-masuk.store');
        Route::post('/data-masuk/auto-sync', [DataMasukController::class, 'autoSyncProspek'])->name('data-masuk.auto-sync');
        
        Route::post('/cta/store-massal', [CtaController::class, 'storeMassal'])->name('cta.store_massal');
        Route::get('/cta/form-massal', function () {
            return view('form-cta-massal'); 
        })->name('form-cta-massal');
        Route::post('/cta/mass-delete', [CtaController::class, 'massDelete'])->name('cta.massDelete');
        
        Route::post('/data-masuk/delete-by-date', [DataMasukController::class, 'destroyByDate'])->name('data-masuk.destroy-by-date');
        Route::get('/data-masuk/{id}/edit', [DataMasukController::class, 'edit'])->name('data-masuk.edit');
        Route::put('/data-masuk/{id}', [DataMasukController::class, 'update'])->name('data-masuk.update');
        Route::delete('/data-masuk/{id}', [DataMasukController::class, 'destroy'])->name('data-masuk.destroy');
        
        Route::prefix('ads')->group(function () {
            Route::post('/deliver/{id}', [DataMasukController::class, 'deliverAds'])->name('ads.deliver');
            Route::get('/edit/{id}', [DataMasukController::class, 'editAds'])->name('ads.edit');
            Route::delete('/destroy/{id}', [DataMasukController::class, 'destroyAds'])->name('ads.destroy');
        });

        Route::get('/master-training', [MasterTrainingController::class, 'index'])->name('master-training.index');
        Route::post('/master-training/bulk-store', [MasterTrainingController::class, 'bulkStore'])->name('master-training.bulk_store');
        Route::delete('/master-training/{id}', [MasterTrainingController::class, 'destroy'])->name('master-training.destroy');

        Route::post('/v1/sync-ads', [AdsLeadController::class, 'store']);
    });

    // 4. KHUSUS ADMIN & SUPERADMIN/WEB DEV (Prospek & Penggajian Dasar)
    Route::middleware('role:superadmin,web_dev,spv_marketing,admin')->group(function () {
        Route::get('/form-prospek', [ProspekController::class, 'create'])->name('form-prospek');
        Route::post('/prospek/store', [ProspekController::class, 'store'])->name('prospek.store');
        Route::get('/prospek/{id}/edit', [ProspekController::class, 'edit'])->name('prospek.edit');
        Route::put('/prospek/{id}', [ProspekController::class, 'update'])->name('prospek.update');
        Route::delete('/prospek/mass-delete', [ProspekController::class, 'massDelete'])->name('prospek.massDelete');
        Route::get('/prospek/check', [ProspekController::class, 'showCheckData'])->name('prospek.check');
        Route::post('/prospek/check-massal', [ProspekController::class, 'processCheckMassal'])->name('prospek.processCheckMassal');
        Route::post('/prospek/import-excel', [ProspekController::class, 'importExcel'])->name('prospek.import');
        Route::get('/prospek/download-template', [ProspekController::class, 'downloadTemplate'])->name('prospek.download-template');
        Route::post('/prospek/undo-import', [ProspekController::class, 'undoImport'])->name('prospek.undo-import');
     
        Route::get('/dashboard/detail-prospek-ajax', [DashboardController::class, 'getDetailStatusAjax'])->name('prospek.detailAjax');
        Route::get('/prospek/map-detail-ajax', [DashboardController::class, 'getMapDetailAjax'])->name('prospek.mapAjax');

        Route::post('/data-masuk/deliver/{id}', [DataMasukController::class, 'deliver'])->name('data-masuk.deliver');
        Route::post('/data-masuk/deliver-massal', [DataMasukController::class, 'deliverMassal'])->name('data-masuk.deliver-massal');
    });

    // 5. KHUSUS SUPERADMIN & WEB DEV (User Management, Approval, Absensi, Advanced Payroll)
    Route::middleware('role:superadmin,web_dev')->group(function () {
        // Approval Download
        Route::get('/download-approval', [DownloadRequestController::class, 'index'])->name('download.approval');
        Route::post('/download-approve/{id}', [DownloadRequestController::class, 'approve'])->name('download.approve');
        Route::post('/download-reject/{id}', [DownloadRequestController::class, 'reject'])->name('download.reject');

        // User Management
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user-list-manual', function () { 
             $users = \App\Models\User::all();
             return view('user', compact('users'));
        });
        Route::get('/form-tambah-pengguna', function () {
            return view('form-tambah-pengguna');
        })->name('form-tambah-pengguna');
        
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Advanced Payroll (Prefix Penggajian)
        Route::prefix('penggajian')->group(function () {
            Route::post('/jenis-izin/store', [PenggajianController::class, 'storeJenisIzin'])->name('jenis-izin.store');
            Route::post('/jenis-izin/update/{id}', [PenggajianController::class, 'updateJenisIzin'])->name('jenis-izin.update');
            Route::delete('/jenis-izin/destroy/{id}', [PenggajianController::class, 'destroyJenisIzin'])->name('jenis-izin.destroy');
            
            Route::get('/edit-v2/{id}', [PenggajianController::class, 'edit'])->name('penggajian.edit_v2');
            Route::post('/update-v2/{id}', [PenggajianController::class, 'update'])->name('penggajian.update_v2');
            Route::delete('/destroy-v2/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy_v2');
        });
        
        Route::get('/penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
        Route::get('/form-penggajian', [PenggajianController::class, 'create'])->name('form-penggajian');
        Route::post('/penggajian/store', [PenggajianController::class, 'store'])->name('penggajian.store');
        Route::post('/penggajian/mass-update', [PenggajianController::class, 'massUpdate'])->name('penggajian.mass_update');
        Route::get('/penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
        Route::put('/penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
        Route::delete('/penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

        // Absensi Management
        Route::prefix('absensi')->group(function () {
            Route::get('/', [AbsensiController::class, 'index'])->name('absensi');
            Route::get('/mapping', [AbsensiController::class, 'mapping'])->name('absensi.mapping');
            Route::post('/mapping', [AbsensiController::class, 'storeMapping'])->name('absensi.store_mapping');
            Route::post('/sync', [AbsensiController::class, 'syncFingerspot'])->name('absensi.sync');
            Route::post('/import', [AbsensiController::class, 'importManual'])->name('absensi.import');
            Route::post('/import-izin', [AbsensiController::class, 'importIzin'])->name('absensi.import_izin');
            Route::delete('/delete-range', [AbsensiController::class, 'destroyAbsensiRange'])->name('absensi.delete_range');
            Route::delete('/izin/delete-range', [AbsensiController::class, 'destroyIzinRange'])->name('absensi.delete_izin_range');
            Route::delete('/izin/{id}', [AbsensiController::class, 'destroyIzin'])->name('absensi.destroy_izin');
            Route::put('/izin/{id}/status', [AbsensiController::class, 'updateIzinStatus'])->name('absensi.update_izin_status');
            Route::post('/holiday', [AbsensiController::class, 'storeHoliday'])->name('absensi.store_holiday');
            Route::delete('/holiday/{id}', [AbsensiController::class, 'destroyHoliday'])->name('absensi.destroy_holiday');
            Route::delete('/kamera/{id}', [AbsensiController::class, 'destroyKamera'])->name('absensi.destroy');
        });
        
        Route::post('/panduan/update', [App\Http\Controllers\PanduanController::class, 'update'])->name('panduan.update');
    });

    // ================= RUTE APPROVAL IZIN & CUTI (HRD & Superadmin) =================
    Route::middleware('role:superadmin,hrd')->group(function () {
        Route::get('/approval-izin', [\App\Http\Controllers\ApprovalIzinController::class, 'index'])->name('approval-izin.index');
        Route::post('/approval-izin/{id}/approve', [\App\Http\Controllers\ApprovalIzinController::class, 'approve'])->name('approval-izin.approve');
        Route::post('/approval-izin/{id}/reject', [\App\Http\Controllers\ApprovalIzinController::class, 'reject'])->name('approval-izin.reject');
        
        // Papan Pengumuman
        Route::resource('pengumuman', \App\Http\Controllers\PengumumanController::class);
    });

    // Parameter Finansial / Nilai Target Omset
    Route::middleware('role:superadmin,spv_marketing')->group(function () {
        Route::get('/parameter-finansial', [ParameterFinansialController::class, 'index'])->name('parameter-finansial.index');
    });
    
    Route::middleware('role:superadmin')->group(function () {
        Route::post('/parameter-finansial/update', [ParameterFinansialController::class, 'update'])->name('parameter-finansial.update');
    });

    // ================== RND MODULES ==================
    Route::middleware('role:superadmin,rnd,spv_marketing,admin')->group(function () {
        // Master Artikel
        Route::get('/master-artikel', [\App\Http\Controllers\MasterArtikelController::class, 'index'])->name('master-artikel.index');
        Route::post('/master-artikel', [\App\Http\Controllers\MasterArtikelController::class, 'store'])->name('master-artikel.store');
        Route::put('/master-artikel/{id}', [\App\Http\Controllers\MasterArtikelController::class, 'update'])->name('master-artikel.update');
        Route::delete('/master-artikel/{id}', [\App\Http\Controllers\MasterArtikelController::class, 'destroy'])->name('master-artikel.destroy');

        // Master Instruktur
        Route::get('/master-instruktur', [\App\Http\Controllers\MasterInstrukturController::class, 'index'])->name('master-instruktur.index');
        Route::post('/master-instruktur', [\App\Http\Controllers\MasterInstrukturController::class, 'store'])->name('master-instruktur.store');
        Route::put('/master-instruktur/{id}', [\App\Http\Controllers\MasterInstrukturController::class, 'update'])->name('master-instruktur.update');
        Route::delete('/master-instruktur/{id}', [\App\Http\Controllers\MasterInstrukturController::class, 'destroy'])->name('master-instruktur.destroy');

        // Master Proposal
        Route::get('/master-proposal', [\App\Http\Controllers\MasterProposalController::class, 'index'])->name('master-proposal.index');
        Route::post('/master-proposal', [\App\Http\Controllers\MasterProposalController::class, 'store'])->name('master-proposal.store');
        Route::put('/master-proposal/{id}', [\App\Http\Controllers\MasterProposalController::class, 'update'])->name('master-proposal.update');
        Route::delete('/master-proposal/{id}', [\App\Http\Controllers\MasterProposalController::class, 'destroy'])->name('master-proposal.destroy');
    });
});
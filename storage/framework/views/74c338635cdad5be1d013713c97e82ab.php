<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="<?php echo e(route('home')); ?>" class="logo">
                <img src="<?php echo e(asset('assets/img/arsa/arsa_logo_white.png')); ?>" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <?php
                $role = auth()->user()->role;
                $pendingCount = $role === 'superadmin' 
                    ? \App\Models\DownloadRequest::where('status', 'pending')->count() 
                    : 0;

                $approvedCount = $role !== 'superadmin' 
                    ? auth()->user()->unreadNotifications->where('type', 'App\Notifications\DownloadApprovedNotification')->count() 
                    : 0;
                    
                $dealCount = in_array($role, ['team_leader', 'operasional'])
                    ? auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewDealNotification')->count()
                    : 0;

                $lemburPendingCount = 0;
                if (in_array($role, ['spv_marketing', 'team_leader'])) {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_spv', 'pending')->count();
                } elseif ($role === 'hrd') {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_spv', 'approved')
                        ->where('status_hrd', 'pending')->count();
                } elseif ($role === 'superadmin') {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_hrd', 'approved')
                        ->where('status_direktur', 'pending')->count();
                }
            ?>
            
            <ul class="nav nav-secondary">
                
                
                <?php $isDashboard = request()->routeIs(['home', 'pegawai.absensi.index', 'pengajuan-izin.index', 'pengajuan-izin.create']); ?>
                <li class="nav-item <?php echo e($isDashboard ? 'active' : ''); ?>">
                    <a data-bs-toggle="collapse" href="#dashboard" class="<?php echo e($isDashboard ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isDashboard ? 'true' : 'false'); ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php echo e($isDashboard ? 'show' : ''); ?>" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('home')); ?>">
                                    <span class="sub-item">Home</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('pegawai.absensi.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('pegawai.absensi.index')); ?>">
                                    <span class="sub-item">Absensi Online</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('pengajuan-izin.*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('pengajuan-izin.index')); ?>">
                                    <span class="sub-item">Pengajuan Izin / Cuti</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('pengajuan-lembur.*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('pengajuan-lembur.index')); ?>">
                                    <span class="sub-item">Pengajuan Lembur</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                                
                <?php if(in_array($role, ['superadmin', 'web_dev', 'spv_marketing', 'admin', 'rnd', 'marketing', 'performance'])): ?>
                    <?php $isPerformance = request()->routeIs(['dashboard.progress', 'performance.display', 'revenue', 'data-kpi', 'simulasi-gaji', 'parameter-finansial.*', 'master-artikel.*', 'master-instruktur.*', 'master-proposal.*']); ?>
                    <li class="nav-item <?php echo e($isPerformance ? 'active' : ''); ?>">
                        <a data-bs-toggle="collapse" href="#performance" class="<?php echo e($isPerformance ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isPerformance ? 'true' : 'false'); ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Performance</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo e($isPerformance ? 'show' : ''); ?>" id="performance">
                            <ul class="nav nav-collapse">
                                <?php if(in_array($role, ['superadmin', 'spv_marketing', 'admin', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('dashboard.progress') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('dashboard.progress')); ?>">
                                        <span class="sub-item">Dashboard Progress</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['superadmin', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('performance.display') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('performance.display') ?? '#'); ?>"> 
                                        <span class="sub-item">On Display Monitor</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['superadmin', 'marketing', 'web_dev', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('revenue') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('revenue')); ?>">
                                        <span class="sub-item">Revenue</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['superadmin', 'spv_marketing', 'marketing', 'web_dev', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('data-kpi') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('data-kpi')); ?>">
                                        <span class="sub-item">Data KPI</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['superadmin', 'marketing', 'web_dev', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('simulasi-gaji') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('simulasi-gaji')); ?>">
                                        <span class="sub-item">Skema Penggajian</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['superadmin', 'spv_marketing', 'performance'])): ?>
                                <li class="<?php echo e(request()->routeIs('parameter-finansial.*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('parameter-finansial.index')); ?>">
                                        <span class="sub-item">Nilai Target Omset</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if(in_array($role, ['rnd', 'superadmin', 'spv_marketing', 'admin'])): ?>
                                <li class="<?php echo e(request()->routeIs('master-artikel.*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('master-artikel.index')); ?>">
                                        <span class="sub-item">Master Artikel</span>
                                    </a>
                                </li>
                                <li class="<?php echo e(request()->routeIs('master-instruktur.*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('master-instruktur.index')); ?>">
                                        <span class="sub-item">Master Instruktur/Narasumber</span>
                                    </a>
                                </li>
                                <li class="<?php echo e(request()->routeIs('master-proposal.*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('master-proposal.index')); ?>">
                                        <span class="sub-item">Master Proposal Penawaran</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                                <?php if(in_array($role, ['superadmin', 'web_dev', 'hrd'])): ?>

                <?php $isHR = request()->routeIs(['user', 'penggajian.index', 'absensi', 'approval-izin.index', 'pengumuman.*']); ?>
                <li class="nav-item <?php echo e($isHR ? 'active' : ''); ?>">
                    <a data-bs-toggle="collapse" href="#human-resources" class="<?php echo e($isHR ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isHR ? 'true' : 'false'); ?>">
                        <i class="fas fa-users"></i>
                        <p>Human Resources</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php echo e($isHR ? 'show' : ''); ?>" id="human-resources">
                        <ul class="nav nav-collapse">
                            <li class="<?php echo e(request()->routeIs('user') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('user')); ?>">
                                    <span class="sub-item">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('penggajian.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('penggajian.index')); ?>">
                                    <span class="sub-item">Penggajian</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('absensi') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('absensi')); ?>">
                                    <span class="sub-item">Data Absensi Internal</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('approval-izin.*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('approval-izin.index')); ?>">
                                    <span class="sub-item">Approval Izin / Cuti</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('pengumuman.*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('pengumuman.index')); ?>">
                                    <span class="sub-item">Papan Pengumuman</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                
                <?php if($role !== 'finance'): ?>

                
                <?php if(in_array($role, ['superadmin', 'web_dev', 'spv_marketing', 'admin', 'marketing', 'rnd', 'digitalmarketing', 'performance'])): ?>
                <?php $isMarketing = request()->routeIs(['pipeline', 'form-prospek', 'form-cta-massal', 'data-masuk.index', 'master-training.index']); ?>
                <li class="nav-item <?php echo e($isMarketing ? 'active' : ''); ?>">
                    <a data-bs-toggle="collapse" href="#marketing-sales" class="<?php echo e($isMarketing ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isMarketing ? 'true' : 'false'); ?>">
                        <i class="fas fa-chart-line"></i>
                        <p>Marketing & Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php echo e($isMarketing ? 'show' : ''); ?>" id="marketing-sales">
                        <ul class="nav nav-collapse">
                            <li class="<?php echo e(request()->routeIs('pipeline') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('pipeline')); ?>">
                                    <span class="sub-item">Pipeline Marketing</span>
                                </a>
                            </li>

                            <?php if($role !== 'performance'): ?>
                            <li class="<?php echo e(request()->routeIs('form-prospek') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('form-prospek')); ?>">
                                    <span class="sub-item">Tambah Data Prospek</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('form-cta-massal') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('form-cta-massal')); ?>">
                                    <span class="sub-item">Tambah Data CTA Massal</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="<?php echo e(request()->routeIs('data-masuk.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('data-masuk.index')); ?>">
                                    <span class="sub-item">Database Masuk</span>
                                </a>
                            </li>
                            <li class="<?php echo e(request()->routeIs('master-training.index') ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('master-training.index')); ?>">
                                    <span class="sub-item">Master Pelatihan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php endif; ?>

                
                <?php if(in_array($role, ['superadmin','operasional','team_leader','web_dev','spv_marketing','graphic','performance'])): ?>
                    <?php $isOperational = request()->routeIs(['operational.aktivitas-harian', 'operational.data-pendaftaran', 'operational.inventaris', 'operational.monitoring-paket', 'monitoring.pelatihan', 'riwayat.pelatihan']); ?>
                    <li class="nav-item <?php echo e($isOperational ? 'active' : ''); ?>">
                        <a data-bs-toggle="collapse" href="#operasional" class="<?php echo e($isOperational ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isOperational ? 'true' : 'false'); ?>">
                            <i class="fas fa-tasks"></i>
                            <p>Operational</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo e($isOperational ? 'show' : ''); ?>" id="operasional">
                            <ul class="nav nav-collapse">
                                <?php if(in_array($role, ['superadmin', 'operasional', 'team_leader', 'web_dev', 'graphic'])): ?>
                                <li class="<?php echo e(request()->routeIs('operational.aktivitas-harian') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('operational.aktivitas-harian')); ?>">
                                        <span class="sub-item">Aktivitas Harian</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                        
                                <?php if(in_array(auth()->user()->role, ['admin', 'operasional', 'team_leader', 'superadmin', 'web_dev', 'spv_marketing', 'graphic'])): ?>
                                    <li class="<?php echo e(request()->routeIs('operational.data-pendaftaran') ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route('operational.data-pendaftaran')); ?>">
                                            <span class="sub-item">Registrasi Peserta</span>
                                            <?php if($dealCount > 0): ?>
                                                <span class="badge badge-success"><?php echo e($dealCount); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <li class="<?php echo e(request()->routeIs('monitoring.pelatihan') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('monitoring.pelatihan')); ?>">
                                        <span class="sub-item">Pelatihan Berjalan</span>
                                        <span class="badge badge-dark">Beta</span>
                                    </a>
                                </li>
                                <li class="<?php echo e(request()->routeIs('riwayat.pelatihan') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(Route::has('riwayat.pelatihan') ? route('riwayat.pelatihan') : '#'); ?>">
                                        <span class="sub-item">Riwayat Pelatihan</span>
                                        <span class="badge badge-dark">Beta</span>
                                    </a>
                                </li>
                        
                                <?php if(in_array(auth()->user()->role, ['team_leader', 'superadmin', 'web_dev', 'operasional', 'graphic'])): ?>
                                    <li class="<?php echo e(request()->routeIs('operational.inventaris') ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route('operational.inventaris')); ?>">
                                            <span class="sub-item">Aset & Inventaris</span>
                                        </a>
                                    </li>
                                    
                                    <li class="<?php echo e(request()->routeIs('operational.monitoring-paket') ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route('operational.monitoring-paket')); ?>">
                                            <span class="sub-item">Monitoring Paket</span>
                                        </a>
                                    </li>
                                <?php endif; ?>


                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                
                
                <?php $isPermintaanVisual = request()->routeIs(['operational.permintaan-visual.*']); ?>
                <li class="nav-item <?php echo e($isPermintaanVisual ? 'active' : ''); ?>">
                        <a data-bs-toggle="collapse" href="#permintaanVisual" class="<?php echo e($isPermintaanVisual ? '' : 'collapsed'); ?>" aria-expanded="<?php echo e($isPermintaanVisual ? 'true' : 'false'); ?>">
                            <i class="fas fa-palette"></i>
                            <p>Permintaan Visual</p>
                            <span class="badge badge-dark">Beta</span>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo e($isPermintaanVisual ? 'show' : ''); ?>" id="permintaanVisual">
                            <ul class="nav nav-collapse">
                                <li class="<?php echo e(request()->routeIs('operational.permintaan-visual.biasa*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('operational.permintaan-visual.biasa')); ?>">
                                        <span class="sub-item">Permintaan Biasa</span>
                                    </a>
                                </li>
                                <li class="<?php echo e(request()->routeIs('operational.permintaan-visual.training*') ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('operational.permintaan-visual.training')); ?>">
                                        <span class="sub-item">Permintaan Training</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                
                
                <?php $isDownload = request()->routeIs(['download.approval', 'download.my']); ?>
                <li class="nav-item <?php echo e($isDownload ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('download.approval')); ?>">
                        <i class="fas fa-file-download"></i>
                        <p><?php echo e(in_array($role, ['superadmin']) ? 'Download Approval' : 'Riwayat Download'); ?></p>
                        <?php if($pendingCount > 0 && in_array($role, ['superadmin'])): ?>
                            <span class="badge badge-danger"><?php echo e($pendingCount); ?></span>
                        <?php endif; ?>
                        <?php if($approvedCount > 0 && $role !== 'superadmin'): ?>
                            <span class="badge badge-success"><?php echo e($approvedCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                
                
                <?php if(in_array($role, ['team_leader', 'spv_marketing', 'hrd', 'superadmin'])): ?>
                <li class="nav-item <?php echo e(request()->routeIs('approval-lembur.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('approval-lembur.index')); ?>">
                        <i class="fas fa-clock"></i>
                        <p>Approval Lembur</p>
                        <?php if($lemburPendingCount > 0): ?>
                            <span class="badge badge-warning"><?php echo e($lemburPendingCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if(in_array($role, ['superadmin', 'graphic', 'team_leader', 'admin', 'rnd'])): ?>
                <?php $isModul = request()->routeIs(['modul.index']); ?>
                <li class="nav-item <?php echo e($isModul ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('modul.index')); ?>">
                        <i class="fas fa-book"></i>
                        <p>Modul Pelatihan</p>
                    </a>
                </li>
                <?php endif; ?>
                
                
                <?php if(in_array(auth()->user()->email, ['pic1@arsatraining.com', 'pic2@arsatraining.com'])): ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Back Office</h4>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('operational') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('operational')); ?>">
                            <i class="fas fa-layer-group"></i>
                            <p>Portal Back Office</p>
                            <span class="badge badge-dark">Internal</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                
                <?php
                    $allowedNames = ['Direktur PT Arsa Jaya Prima', 'Desainer Grafis'];
                ?>
                
                <?php if(in_array(auth()->user()->name, $allowedNames)): ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Privasi</h4>
                    </li>
                
                    <li class="nav-item <?php echo e(request()->routeIs('akun.index') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('akun.index')); ?>">
                            <i class="fas fa-key"></i>
                            <p>Brankas Akun</p>
                            <span class="badge badge-dark">Private</span>
                        </a>
                    </li>
                <?php endif; ?>

                
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Bantuan</h4>
                </li>
                <li class="nav-item <?php echo e(request()->routeIs('panduan.index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('panduan.index')); ?>">
                        <i class="fas fa-info-circle"></i>
                        <p>Panduan Dashboard</p>
                    </a>
                </li>
                
            <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<style>
    /* =========================================================
       ANIMASI MODERN SIDEBAR KAIADMIN (Tanpa merusak layout)
       ========================================================= */
       
    /* 1. Transisi dasar agar pergerakan halus */
    .sidebar .nav > .nav-item > a,
    .sidebar .nav-collapse li > a {
        transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease !important;
    }

    /* 2. Efek Hover Utama: Bergeser halus ke kanan (Smooth Slide) */
    .sidebar .nav > .nav-item > a:hover {
        transform: translateX(6px);
    }

    /* 3. Efek Hover Sub-menu: Bergeser sedikit lebih kecil */
    .sidebar .nav-collapse li > a:hover {
        transform: translateX(4px);
    }

    /* 4. Efek 'ditekan' (scale down) saat menu sedang aktif */
    .sidebar .nav > .nav-item.active > a {
        animation: popClick 0.4s ease forwards;
    }

    @keyframes popClick {
        0% { transform: scale(1); }
        50% { transform: scale(0.97); }
        100% { transform: scale(1); }
    }
</style><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>
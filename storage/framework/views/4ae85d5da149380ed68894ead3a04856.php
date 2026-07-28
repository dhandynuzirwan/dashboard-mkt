<?php
    // 1. Hitung jumlah penawaran (CTA) yang SUDAH memiliki status penawaran hari ini
    $notifCount = \App\Models\Cta::whereDate('created_at', \Carbon\Carbon::today())
                    ->whereNotNull('status_penawaran') // Pastikan ada statusnya
                    ->count();
    
    // 2. Ambil 5 penawaran terbaru yang memiliki status hari ini
    $recentCtas = \App\Models\Cta::with('prospek')
                    ->whereDate('created_at', \Carbon\Carbon::today())
                    ->whereNotNull('status_penawaran')
                    ->latest()
                    ->take(5)
                    ->get();
?>

<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
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

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">

            
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <form action="<?php echo e(route('search.global')); ?>" method="GET" class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari prospek, penawaran..." class="form-control" autocomplete="off" />
                </form>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                
                
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        
                        <form action="<?php echo e(route('search.global')); ?>" method="GET" class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Ketik pencarian..." class="form-control" autocomplete="off" />
                                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                            </div>
                        </form>
                    </ul>
                </li>

                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <?php if($notifCount > 0): ?>
                            <span class="notification"><?php echo e($notifCount); ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                <?php echo e($notifCount); ?> Update Penawaran Hari Ini
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <?php $__empty_1 = true; $__currentLoopData = $recentCtas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            // Logika penentuan warna & ikon yang lebih singkat
                                            $status = strtolower($cta->status_penawaran ?? 'pending');
                                            $theme = match($status) {
                                                'deal' => ['color' => 'success', 'icon' => 'fa-check'],
                                                'cancel', 'kalah_harga' => ['color' => 'danger', 'icon' => 'fa-times'],
                                                'hold' => ['color' => 'warning', 'icon' => 'fa-pause'],
                                                'under_review' => ['color' => 'info', 'icon' => 'fa-search'],
                                                default => ['color' => 'primary', 'icon' => 'fa-bell'],
                                            };
                                        ?>

                                        <a href="<?php echo e(route('pipeline', ['search_perusahaan' => $cta->prospek->perusahaan])); ?>" class="d-flex align-items-center py-2 px-3"> 
                                            
                                            <div class="notif-content w-100">
                                                
                                                <span class="block fw-bold text-dark text-truncate d-block" style="max-width: 100%;">
                                                    <?php echo e($cta->prospek->perusahaan ?? 'Perusahaan Baru'); ?>

                                                </span>
                                                
                                                
                                                <span class="text-muted d-block text-truncate mb-1" style="max-width: 100%; font-size: 0.8rem;">
                                                    <?php echo e($cta->judul_permintaan ?: 'Menunggu Judul'); ?>

                                                    
                                                    
                                                    <span class="d-block text-primary mt-1" style="font-size: 0.75rem;">
                                                        <i class="fas fa-user-tie me-1"></i> <?php echo e($cta->prospek->marketing->name ?? 'Belum ada PIC'); ?>

                                                    </span>
                                                </span>
                                                
                                                
                                                <span class="time text-<?php echo e($theme['color']); ?> fw-bold m-0 p-0 d-block" style="font-size: 0.75rem;">
                                                    <?php echo e(str_replace('_', ' ', ucwords($status))); ?> &bull; <span class="text-muted fw-normal"><?php echo e($cta->created_at->diffForHumans()); ?></span>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="text-center p-4 text-muted">
                                            <small>Belum ada update penawaran.</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            
                            <a class="see-all" href="<?php echo e(route('pipeline', [
                                'start_date' => now()->format('Y-m-d'), 
                                'end_date' => now()->format('Y-m-d'),
                                'cta_status' => 'done' 
                            ])); ?>">
                                Lihat Semua Progress Hari Ini <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php
                    $userRole = Auth::user()->role;
                    if ($userRole == 'superadmin') {
                        $badgeClass = 'badge-danger';
                    } elseif ($userRole == 'admin') {
                        $badgeClass = 'badge-primary';
                    } else {
                        $badgeClass = 'badge-success';
                    }
                ?>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        
                        <div class="avatar-sm">
                            <?php if(Auth::user()->foto_profil): ?>
                                <img src="<?php echo e(asset('storage/' . Auth::user()->foto_profil)); ?>" alt="profile" class="avatar-img rounded-circle object-fit-cover" />
                            <?php else: ?>
                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold text-white">
                                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold"><?php echo e(Auth::user()->name); ?></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    
                                    <div class="avatar-lg">
                                        <?php if(Auth::user()->foto_profil): ?>
                                            <img src="<?php echo e(asset('storage/' . Auth::user()->foto_profil)); ?>" alt="profile image" class="avatar-img rounded object-fit-cover" />
                                        <?php else: ?>
                                            <span class="avatar-title rounded bg-primary-gradient fw-bold text-white fs-3">
                                                <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="u-text">
                                        <h4><?php echo e(Auth::user()->name); ?></h4>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(strtoupper($userRole)); ?></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>

                                
                                <a class="dropdown-item" href="<?php echo e(route('my-profile.edit')); ?>">
                                    <i class="fas fa-user-cog me-2 text-primary opacity-75"></i> Edit Profil
                                </a>
                                
                                <div class="dropdown-divider"></div>

                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger fw-bold">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/layouts/header.blade.php ENDPATH**/ ?>
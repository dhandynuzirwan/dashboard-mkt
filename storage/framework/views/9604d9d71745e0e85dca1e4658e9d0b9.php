

<?php $__env->startSection('content'); ?>
<div class="page-wrapper-modern fade-in">
    <div class="container-fluid py-4 px-3 px-md-4">
    <div class="page-inner">
        
        
        <?php if(session('success_login') || true): ?> 
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4 fade-in" role="alert" style="background-color: #d1fae5; color: #065f46;">
            <div class="d-flex align-items-center">
                <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <strong>Selamat Datang, <?php echo e(Auth::user()->name); ?>!</strong> Anda telah berhasil masuk ke dalam sistem.
                </div>
            </div>
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if(isset($statusHariIni) && $statusHariIni): ?>
        <div class="alert alert-<?php echo e($statusHariIni['color']); ?> alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4 fade-in" role="alert" style="background-color: var(--bs-<?php echo e($statusHariIni['color']); ?>-bg-subtle, #fef3c7);">
            <div class="d-flex align-items-center">
                <div class="icon-sm bg-white text-<?php echo e($statusHariIni['color']); ?> rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                    <i class="<?php echo e($statusHariIni['icon']); ?>"></i>
                </div>
                <div>
                    <strong>Pemberitahuan:</strong> Anda sedang berstatus <strong><?php echo e($statusHariIni['tipe']); ?></strong> hari ini. (Keterangan: <?php echo e($statusHariIni['keterangan'] ?? '-'); ?>)
                </div>
            </div>
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row g-4">
            
            <div class="col-lg-8 col-md-12">
                
                
                <div class="glass-card mb-4 fade-in" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative overflow-hidden">
                        <i class="fas fa-chart-line position-absolute" style="font-size: 150px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
                        <div class="row align-items-center position-relative z-1">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">Halo, <?php echo e(Auth::user()->name); ?>! 👋</h2>
                                <p class="opacity-75 mb-4">Siap untuk menyelesaikan tugas hebat hari ini? Cek jadwal dan progres kamu di bawah ini.</p>
                                
                                <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-2" style="backdrop-filter: blur(5px);">
                                    <i class="fas fa-clock me-2"></i>
                                    <span id="realtime-clock" class="fw-semibold" style="letter-spacing: 0.5px;">Memuat waktu...</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end d-none d-md-block">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow ms-auto" style="width: 80px; height: 80px;">
                                    <i class="fas fa-building text-primary fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <h5 class="fw-bold mb-3 fade-in" style="animation-delay: 0.1s;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h5>
                <div class="row g-3 mb-4 fade-in" style="animation-delay: 0.2s;">
                    <?php $__currentLoopData = $quickAccess; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-sm-3">
                        <a href="<?php echo e($item['route']); ?>" class="text-decoration-none">
                            <div class="glass-card glass-hover text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-<?php echo e($item['color']); ?>-subtle text-<?php echo e($item['color']); ?> rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="<?php echo e($item['icon']); ?> fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small"><?php echo e($item['title']); ?></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="glass-card mb-4 fade-in" style="animation-delay: 0.3s; height: 100%;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 ">
                                <h5 class="fw-bold mb-0"><i class="fas fa-bullhorn text-danger me-2"></i> Papan Pengumuman</h5>
                            </div>
                            <div class="card-body p-4">
                                <?php $__empty_1 = true; $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $icon = 'fas fa-info-circle';
                                        $color = 'primary';
                                        $badgeText = 'Pengumuman';
                                        if($p->kategori == 'hari_besar') {
                                            $icon = 'fas fa-calendar-day';
                                            $color = 'success';
                                            $badgeText = 'Hari Besar';
                                        } elseif($p->kategori == 'urgent') {
                                            $icon = 'fas fa-exclamation-triangle';
                                            $color = 'danger';
                                            $badgeText = '<i class="fas fa-fire me-1"></i> Urgent';
                                        } elseif($p->kategori == 'pencapaian') {
                                            $icon = 'fas fa-trophy';
                                            $color = 'primary';
                                            $badgeText = 'Pencapaian';
                                        }
                                    ?>
                                    <div class="d-flex mb-3 pb-3 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                                        <div class="flex-shrink-0">
                                            <div class="bg-<?php echo e($color); ?>-subtle text-<?php echo e($color); ?> rounded p-2 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="<?php echo e($icon); ?> fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="mb-1">
                                                <span class="badge badge-<?php echo e($color); ?> rounded-pill px-2" style="font-size: 10px;"><?php echo $badgeText; ?></span>
                                                <small class="text-muted" style="font-size: 11px;"><i class="fas fa-clock me-1"></i><?php echo e($p->tanggal_event ? \Carbon\Carbon::parse($p->tanggal_event)->format('d M Y') : $p->created_at->diffForHumans()); ?></small>
                                            </div>
                                            <h6 class="fw-bold mb-1"><?php echo e($p->judul); ?></h6>
                                            <p class="text-muted small mb-0"><?php echo e($p->deskripsi); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-bell-slash fs-1 text-light mb-2 d-block"></i>
                                        <span class="small">Belum ada pengumuman saat ini.</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <?php if(Auth::user()->role === 'superadmin'): ?>
                        
                        <div class="glass-card mb-4 fade-in" style="animation-delay: 0.4s; height: 100%;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center ">
                                <h5 class="fw-bold mb-0"><i class="fas fa-tasks text-primary me-2"></i> Permintaan Perizinan</h5>
                                <span class="badge bg-danger rounded-pill"><?php echo e(count($pendingPerizinan)); ?> Pending</span>
                            </div>
                            <div class="card-body p-4 pt-3">
                                <ul class="list-unstyled mb-0 position-relative">
                                    <?php if(count($pendingPerizinan) > 0): ?>
                                        <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 5px; z-index: 1;"></div>
                                        
                                        <?php $__currentLoopData = $pendingPerizinan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="position-relative ps-4 mb-4 z-2">
                                            <div class="position-absolute bg-<?php echo e($p['color']); ?> border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                            <div class="small text-muted mb-1"><?php echo e(\Carbon\Carbon::parse($p['waktu'])->diffForHumans()); ?> &bull; <span class="fw-semibold text-dark"><?php echo e($p['tipe']); ?></span></div>
                                            <div class="small fw-semibold text-dark">Diajukan oleh: <?php echo e($p['nama']); ?></div>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <li class="text-center py-4 text-muted">
                                            <i class="fas fa-check-circle fs-1 text-light mb-2 d-block"></i>
                                            <span class="small">Tidak ada permintaan yang pending.</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php else: ?>
                        
                        <div class="glass-card mb-4 fade-in" style="animation-delay: 0.4s; height: 100%;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 ">
                                <h5 class="fw-bold mb-0"><i class="fas fa-list text-info me-2"></i> Aktivitas Feed</h5>
                            </div>
                            <div class="card-body p-4 pt-3">
                                <ul class="list-unstyled mb-0 position-relative">
                                    <?php if($feed->count() > 0): ?>
                                        
                                        <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 5px; z-index: 1;"></div>
                                        
                                        <?php $__currentLoopData = $feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="position-relative ps-4 mb-4 z-2">
                                            <div class="position-absolute bg-<?php echo e($f['color']); ?> border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                            <div class="small text-muted mb-1"><?php echo e(\Carbon\Carbon::parse($f['time'])->diffForHumans()); ?> &bull; <span class="fw-semibold text-dark"><?php echo e($f['type']); ?></span></div>
                                            <div class="small fw-semibold text-dark"><?php echo e($f['title']); ?></div>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <li class="text-center py-4 text-muted">
                                            <i class="fas fa-history fs-1 text-light mb-2 d-block"></i>
                                            <span class="small">Belum ada aktivitas terekam.</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            
            <div class="col-lg-4 col-md-12 fade-in" style="animation-delay: 0.5s;">
                
                
                <div class="glass-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-container position-relative me-3">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center overflow-hidden" style="width: 60px; height: 60px;">
                                    <?php if(Auth::user()->foto_profil): ?>
                                        <img src="<?php echo e(asset('storage/' . Auth::user()->foto_profil)); ?>" alt="Profile Picture" class="w-100 h-100" style="object-fit: cover;">
                                    <?php else: ?>
                                        <i class="fas fa-user text-secondary fs-3"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" style="transform: translate(-2px, -2px);" title="Online"></span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1"><?php echo e(Auth::user()->name); ?></h5>
                                <p class="text-muted small mb-0 text-capitalize"><i class="fas fa-user-shield me-1"></i> <?php echo e(str_replace('_', ' ', Auth::user()->role ?? 'Karyawan')); ?></p>
                            </div>
                            <div class="ms-auto dropdown">
                                <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item" href="<?php echo e(route('my-profile.edit')); ?>"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="bg-light rounded p-3 mb-3">
                            <h6 class="fw-bold mb-3 small text-muted"><i class="fas fa-id-card me-1"></i> DATA DIRI</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Nama Lengkap</span>
                                <span class="fw-semibold small text-end"><?php echo e(Auth::user()->nama_lengkap ?? '-'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">NIK</span>
                                <span class="fw-semibold small text-end"><?php echo e(Auth::user()->nik ?? '-'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Tanggal Lahir</span>
                                <span class="fw-semibold small text-end"><?php echo e(Auth::user()->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->translatedFormat('d F Y') : '-'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Kontrak Baru</span>
                                <span class="fw-semibold small text-end"><?php echo e(Auth::user()->tanggal_kontrak_baru ? \Carbon\Carbon::parse(Auth::user()->tanggal_kontrak_baru)->translatedFormat('d M Y') : '-'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Kontrak Berakhir</span>
                                <span class="fw-bold small text-danger text-end"><?php echo e(Auth::user()->tanggal_kontrak_berakhir ? \Carbon\Carbon::parse(Auth::user()->tanggal_kontrak_berakhir)->translatedFormat('d M Y') : '-'); ?></span>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-primary btn-sm flex-fill fw-semibold"><i class="fas fa-briefcase me-1"></i> Jobdesk</a>
                            <a href="#" class="btn btn-info btn-sm flex-fill fw-semibold text-white"><i class="fas fa-sitemap me-1"></i> Struktur</a>
                        </div>
                    </div>
                </div>

                
                <div class="glass-card mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 ">
                        <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt text-primary me-2"></i> Kalender Agenda</h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-sm btn-light rounded-circle" onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                            <h6 class="fw-bold mb-0" id="calendar-month-year">...</h6>
                            <button class="btn btn-sm btn-light rounded-circle" onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        
                        
                        <div class="text-center calendar-wrapper mb-3">
                            <div class="d-flex text-muted small fw-bold mb-2">
                                <div style="width: 14.28%">M</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">R</div>
                                <div style="width: 14.28%">K</div>
                                <div style="width: 14.28%">J</div>
                                <div style="width: 14.28%">S</div>
                            </div>
                            <div id="calendar-days" class="d-flex flex-wrap small">
                                <!-- JS Populated -->
                            </div>
                        </div>
                        
                        <hr class="opacity-10">
                        
                        
                        <h6 class="fw-semibold small mb-3 text-muted text-uppercase">Agenda Mendatang</h6>
                        <?php $__empty_1 = true; $__currentLoopData = $upcomingAgendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="d-flex mb-2 align-items-center">
                                <div class="bg-<?php echo e($agenda['color']); ?> rounded-circle me-2" style="width:10px; height:10px;"></div>
                                <div class="small fw-semibold text-dark"><?php echo e($agenda['title']); ?> <span class="badge bg-light text-muted ms-2 fw-normal"><?php echo e(\Carbon\Carbon::parse($agenda['date'])->format('d M')); ?></span></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="small text-muted text-center py-2">Tidak ada agenda mendatang.</div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="glass-card mb-4">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3 text-start"><i class="fas fa-clipboard-check text-success me-2"></i> Kehadiran Bulan Ini</h6>
                        
                        <div class="position-relative mx-auto" style="width: 140px; height: 140px; margin-bottom: 20px;">
                            <canvas id="attendanceChart"></canvas>
                            <div class="position-absolute top-50 start-50 translate-middle text-center" style="margin-top: 2px;">
                                <span class="d-block fw-bold fs-4 text-dark line-height-1" style="margin-bottom: -5px;"><?php echo e($attendanceRate); ?>%</span>
                                <span class="text-muted" style="font-size: 10px;">Tingkat Kehadiran</span>
                            </div>
                        </div>

                        <div class="row text-center g-2 mt-2 border-top pt-3">
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-success"><?php echo e($hadir); ?></span>
                                <span class="d-block text-muted" style="font-size: 11px;">Hadir</span>
                            </div>
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-warning"><?php echo e($telat); ?></span>
                                <span class="d-block text-muted" style="font-size: 11px;">Telat</span>
                            </div>
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-danger"><?php echo e($absen); ?></span>
                                <span class="d-block text-muted" style="font-size: 11px;">Absen/Alpha</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Modern CSS */
    .page-wrapper-modern {
        background-color: #f8f9fc;
        min-height: 100vh;
        font-family: 'Nunito', 'Segoe UI', sans-serif;
    }
    .glass-card {
        background: #ffffff;
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }
    .glass-hover {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }
    .glass-hover:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(15px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    .line-height-1 { line-height: 1; }
    
    /* Calendar styles */
    .calendar-day { 
        width: 14.28%; padding: 6px 0; border-radius: 6px; cursor: pointer; position: relative;
    }
    .calendar-day:hover:not(.empty) { background-color: #eff6ff; color: #0d6efd; font-weight: 600; }
    .calendar-day.today { background-color: #0d6efd; color: white; font-weight: bold; }
    .calendar-label { 
        position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%);
        width: 20px; height: 5px; border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- JAM REALTIME ---
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
        
        // Render Initial Calendar
        renderCalendar();
        
        // Render Doughnut Chart
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Telat', 'Absen'],
                datasets: [{
                    data: [<?php echo e($hadir); ?>, <?php echo e($telat); ?>, <?php echo e($absen); ?>],
                    backgroundColor: ['#22c55e', '#eab308', '#ef4444'], // Tailwind Green, Yellow, Red
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                maintainAspectRatio: false
            }
        });
    });

    // --- KALENDER DINAMIS ---
    let currentDate = new Date();
    
    // Server-side events injected to JS
    const events = <?php echo json_encode($calendarEvents, 15, 512) ?>;

    function renderCalendar() {
        const monthYearEl = document.getElementById('calendar-month-year');
        const daysEl = document.getElementById('calendar-days');
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Format Nama Bulan
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        monthYearEl.innerText = `${monthNames[month]} ${year}`;
        
        // Kalkulasi hari
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        const today = new Date();
        const isCurrentMonth = (today.getMonth() === month && today.getFullYear() === year);
        
        daysEl.innerHTML = '';
        
        // Empty slots sebelum tgl 1
        for(let i=0; i<firstDay; i++) {
            daysEl.innerHTML += `<div class="calendar-day empty"></div>`;
        }
        
        // Tanggal
        for(let i=1; i<=daysInMonth; i++) {
            let classes = "calendar-day";
            if(isCurrentMonth && i === today.getDate()) {
                classes += " today shadow-sm";
            }
            
            // Cek apakah ada event di tgl ini
            let dotHtml = '';
            // Only show events for current server month if we are viewing the current server month, 
            // since $calendarEvents is generated only for the server's current month.
            // For a fully dynamic calendar, we'd need to fetch events via AJAX. For now, this is static per month load.
            const serverDate = new Date();
            const isViewingServerMonth = (serverDate.getMonth() === month && serverDate.getFullYear() === year);

            if(isViewingServerMonth && events[i]) {
                if(!(isCurrentMonth && i === today.getDate())) {
                    dotHtml = `<div class="calendar-label bg-${events[i]} shadow-sm"></div>`;
                }
            }
            
            daysEl.innerHTML += `<div class="${classes}">${i}${dotHtml}</div>`;
        }
    }

    function changeMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        renderCalendar();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/home.blade.php ENDPATH**/ ?>
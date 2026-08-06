<?php $__env->startSection('content'); ?>

<style>
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-secondary { background-color: #f8fafc; color: #475569; }
    
    .table-modern th { 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 0.5px; 
        color: #64748b; 
        padding: 16px; 
        border-bottom: 2px solid #e2e8f0;
    }
    .table-modern td { 
        padding: 16px; 
        border-bottom: 1px solid #f1f5f9; 
    }
    
    /* Bento Card UI */
    .bento-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .bento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .bento-card-no-hover {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
        border-radius: 24px;
        overflow: hidden;
    }
    
    .fade-in {
        animation: fadeIn 0.8s ease forwards;
        opacity: 0;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-3">
            <div>
                <h3 class="fw-bold mb-1">Monitoring Absensi</h3>
                <h6 class="op-7 mb-2">Log absensi karyawan terintegrasi Fingerspot</h6>
                <div class="badge badge-info">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        
        <div class="card bento-card p-3 mb-4 shadow-none border">
            <form action="<?php echo e(route('absensi')); ?>" method="GET" class="d-flex flex-wrap gap-2">
                
                <div class="form-group p-0 m-0">
                    <input type="date" name="start_date" class="form-control form-control-sm"
                        value="<?php echo e($start); ?>" title="Tanggal Mulai">
                </div>

                
                <div class="form-group p-0 m-0">
                    <input type="date" name="end_date" class="form-control form-control-sm"
                        value="<?php echo e($end); ?>" title="Tanggal Akhir">
                </div>

                
                <div class="form-group p-0 m-0">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Semua Karyawan</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($u->id); ?>" <?php echo e(request('user_id') == $u->id ? 'selected' : ''); ?>>
                                <?php echo e($u->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="form-group p-0 m-0">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted" id="basic-addon1">Telat ></span>
                        <input type="time" name="late_threshold" class="form-control form-control-sm"
                            value="<?php echo e($lateThreshold ?? '07:30'); ?>" title="Batas Jam Telat">
                    </div>
                </div>

                
                <button type="submit" class="btn btn-primary btn-sm btn-round">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="<?php echo e(route('absensi')); ?>" class="btn btn-border btn-round btn-sm">Reset</a>
            </form>
        </div>

        <div class="row">
            
            <div class="col-sm-6 col-md-3">
                <div class="card bento-card card-stats card-round card-animate shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Karyawan Aktif</p>
                                    <h4 class="card-title"><?php echo e($totalKaryawan); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-sm-6 col-md-3">
                <div class="card bento-card card-stats card-round card-animate shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Hadir Hari Ini</p>
                                    <h4 class="card-title text-success"><?php echo e($hadirHariIni); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-sm-6 col-md-3">
                <div class="card bento-card card-stats card-round card-animate shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Telat Hari Ini</p>
                                    <h4 class="card-title text-warning"><?php echo e($telatHariIni); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-sm-6 col-md-3">
                <div class="card bento-card card-stats card-round card-animate shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-pills"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Izin/Sakit Hari Ini</p>
                                    <h4 class="card-title text-info"><?php echo e($izinHariIni); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="card bento-card border-0 shadow-sm mb-4" style="height: 350px;">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3 text-start"><i class="fas fa-chart-pie text-primary me-2"></i> Proporsi Filter</h6>
                        <div class="position-relative mx-auto" style="width: 180px; height: 180px;">
                            <canvas id="filterDoughnutChart"></canvas>
                        </div>
                        <div class="row text-center g-2 mt-3 pt-2">
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalDoughnutHadir" class="text-decoration-none d-block btn btn-light btn-sm px-0 rounded-3">
                                    <span class="d-block fw-bold fs-5 text-success"><?php echo e($doughnutHadir); ?></span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Hadir</span>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalDoughnutTelat" class="text-decoration-none d-block btn btn-light btn-sm px-0 rounded-3">
                                    <span class="d-block fw-bold fs-5 text-warning"><?php echo e($doughnutTelat); ?></span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Telat</span>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalDoughnutAbsen" class="text-decoration-none d-block btn btn-light btn-sm px-0 rounded-3">
                                    <span class="d-block fw-bold fs-5 text-danger"><?php echo e($doughnutAbsen); ?></span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Absen</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card bento-card border-0 shadow-sm mb-4" style="height: 350px;">
                    <div class="bg-transparent border-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-chart-line text-info me-2"></i> Tren Kehadiran (6 Bulan Terakhir)</h6>
                    </div>
                    <div class="card-body p-4">
                        <div style="height: 250px;">
                            <canvas id="trendLineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mb-3 d-flex gap-2 flex-wrap">
            <form action="<?php echo e(route('absensi.sync')); ?>" method="POST" class="m-0 p-0 d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary btn-sm btn-round" onclick="return confirm('Tarik data absensi terbaru dari mesin Fingerspot secara langsung?')">
                    <i class="fas fa-sync me-1"></i> Tarik Data Mesin
                </button>
            </form>
            <button class="btn btn-success btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modalImport">
                <i class="fas fa-file-import me-1"></i> Import Absensi
            </button>
            <button class="btn btn-info btn-sm btn-round text-white" data-bs-toggle="modal" data-bs-target="#modalImportIzin">
                <i class="fas fa-file-import me-1"></i> Import Perizinan
            </button>

            <button class="btn btn-danger btn-sm btn-round text-white ms-auto" data-bs-toggle="modal" data-bs-target="#modalDeleteAbsensi">
                <i class="fas fa-trash-alt me-1"></i> Hapus Log Absensi
            </button>
            <button class="btn btn-danger btn-sm btn-round text-white" data-bs-toggle="modal" data-bs-target="#modalDeleteIzin">
                <i class="fas fa-trash-alt me-1"></i> Hapus Data Izin
            </button>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-1"></i> <?php echo session('error'); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('debug_logs')): ?>
                    <div class="alert alert-info border-left-info shadow-sm">
                        <h6 class="fw-bold"><i class="fas fa-search"></i> Hasil Analisa Import:</h6>
                        <ul class="mb-0 small" style="max-height: 150px; overflow-y: auto;">
                            <?php $__currentLoopData = session('debug_logs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($log); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('audit_ids')): ?>
                    <div class="alert alert-info shadow-sm border-left-primary">
                        <h6 class="fw-bold"><i class="fas fa-fingerprint"></i> Hasil Audit ID File:</h6>
                        <ul class="mb-0 small" style="max-height: 150px; overflow-y: auto;">
                            <?php $__currentLoopData = session('audit_ids'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mb-1"><?php echo e($log); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card bento-card shadow-sm mb-4">
                    <div class="bg-transparent border-0 pb-0 pt-3 px-4">
                        <div class="d-flex align-items-center">
                            <h4 class="fw-bold mb-0 text-dark">Data Absensi & Perizinan</h4>
                            <ul class="nav nav-pills nav-secondary ms-auto" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active btn-sm" id="pills-log-tab" data-bs-toggle="pill" href="#pills-log" role="tab">Log Absensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-sm" id="pills-izin-tab" data-bs-toggle="pill" href="#pills-izin" role="tab">Data Perizinan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-sm" id="pills-mapping-tab" data-bs-toggle="pill" href="#pills-mapping" role="tab">Mapping User ID</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-sm" id="pills-libur-tab" data-bs-toggle="pill" href="#pills-libur" role="tab">Daftar Hari Libur</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-log" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-modern table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">TANGGAL</th>
                                                <th class="text-center">FOTO</th>
                                                <th class="text-start">KARYAWAN</th>
                                                <th>JAM</th>
                                                <th>LOKASI</th>
                                                <th class="text-center">STATUS</th>
                                                <th class="text-center">VIA</th>
                                                <th class="text-center pe-4" width="120">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="ps-4 text-muted small fw-bold"><?php echo e(\Carbon\Carbon::parse($log->tanggal)->format('d/m/Y')); ?></td>
                                                
                                                
                                                <td class="text-center">
                                                    <div style="width: 48px; height: 48px; border-radius: 12px; overflow: hidden; margin: 0 auto; border: 2px solid #eef2f7; cursor: pointer;" 
                                                        class="hover-lift shadow-sm"
                                                        onclick="showFoto('<?php echo e(asset('storage/' . $log->foto_path)); ?>', '<?php echo e($log->user->nama_lengkap ?? $log->user->name); ?>')"
                                                        data-bs-toggle="modal" data-bs-target="#modalViewFoto">
                                                        
                                                        <?php if($log->foto_path): ?>
                                                            <img src="<?php echo e(asset('storage/' . $log->foto_path)); ?>" alt="Foto Absen" style="width: 100%; height: 100%; object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-start">
                                                    <div class="fw-bolder text-dark" style="font-size: 14px;"><?php echo e($log->user->nama_lengkap ?? $log->user->name); ?></div>
                                                    <small class="text-muted"><?php echo e($log->user->email ?? '-'); ?></small>
                                                </td>
                                                
                                                <td>
                                                    <div class="fw-bolder text-dark" style="font-size: 14px;"><?php echo e($log->jam); ?></div>
                                                </td>

                                                <td>
                                                    <?php if($log->latitude && $log->longitude): ?>
                                                        <a href="https://www.google.com/maps?q=<?php echo e($log->latitude); ?>,<?php echo e($log->longitude); ?>" target="_blank" class="badge bg-light text-primary border border-primary-subtle text-decoration-none shadow-sm hover-lift px-2 py-1 d-inline-flex align-items-center">
                                                            <i class="fas fa-map-marker-alt text-danger me-1"></i> Cek Peta
                                                        </a>
                                                        <div class="text-muted mt-1" style="font-size: 9px; font-family: monospace;">
                                                            <?php echo e($log->latitude); ?>,<br><?php echo e($log->longitude); ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted opacity-50 small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <span class="badge <?php echo e($log->tipe == 'in' ? 'badge-soft-success border border-success' : 'badge-soft-danger border border-danger'); ?> px-3 py-1 rounded-pill">
                                                        <?php echo e(strtoupper($log->tipe)); ?>

                                                    </span>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <span class="badge badge-soft-secondary border text-muted px-2" style="font-size: 10px;">
                                                        <?php echo e(strtoupper($log->source)); ?>

                                                    </span>
                                                </td>
                                                
                                                <td class="text-center pe-4">
                                                    <?php if($log->source == 'web_kamera'): ?>
                                                        <form action="<?php echo e(route('absensi.destroy', $log->id)); ?>" method="POST" class="d-inline form-hapus">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-light border text-danger btn-round shadow-sm hover-lift px-2" title="Tolak Data" onclick="return confirm('Yakin ingin menolak/menghapus data absensi ini?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="text-muted opacity-50">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">
                                                    <i class="fas fa-user-clock fs-1 mb-3 text-light opacity-50"></i><br>
                                                    Belum ada data absensi.
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <?php echo e($absensi->links('partials.pagination')); ?>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-izin" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-info text-white">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jenis Izin</th>
                                                <th>Keterangan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center" width="80">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $perizinans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $izin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e(\Carbon\Carbon::parse($izin->tanggal)->format('d/m/Y')); ?></td>
                                                <td>
                                                    <div class="small text-muted fw-bold"><?php echo e($izin->user->name); ?></div>
                                                    <div class="text-dark"><?php echo e($izin->user->nama_lengkap ?? '-'); ?></div>
                                                </td>
                                                <td><?php echo e($izin->jenis); ?></td>
                                                <td><small><?php echo e($izin->keterangan ?? '-'); ?></small></td>
                                                <td class="text-center">
                                                    <?php if($izin->status == 'approved'): ?>
                                                        <span class="badge badge-success">Diterima</span>
                                                    <?php elseif($izin->status == 'pending'): ?>
                                                        <span class="badge badge-warning">Pending</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <button type="button" class="btn btn-sm btn-light border text-primary btn-round shadow-sm hover-lift px-2 btn-edit-izin" 
                                                            data-id="<?php echo e($izin->id); ?>" 
                                                            data-status="<?php echo e($izin->status); ?>" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditIzin" 
                                                            title="Ubah Status">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('absensi.destroy_izin', $izin->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perizinan ini?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-light border text-danger btn-round shadow-sm hover-lift" data-bs-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr><td colspan="6" class="text-center py-4">Belum ada data perizinan.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <?php echo e($perizinans->links('pagination::bootstrap-5')); ?>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-mapping" role="tabpanel">
                                <form action="<?php echo e(route('absensi.store_mapping')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mt-2">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>Nama Karyawan</th>
                                                    <th width="350">ID Fingerspot (PIN)</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div class="small text-muted fw-bold"><?php echo e($user->name); ?></div>
                                                        <div class="text-dark"><?php echo e($user->nama_lengkap ?? '-'); ?></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="fingerspot_id[<?php echo e($user->id); ?>]" 
                                                               value="<?php echo e($user->fingerspot_id); ?>" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Contoh: ADM.001">
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($user->fingerspot_id): ?>
                                                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                                        <?php else: ?>
                                                            <span class="text-warning"><i class="fas fa-exclamation-circle"></i></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary btn-round">
                                            <i class="fas fa-save me-1"></i> Simpan Mapping
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="tab-pane fade" id="pills-libur" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">Manajemen Hari Libur Nasional</h5>
                                    <button class="btn btn-primary btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modalAddHoliday">
                                        <i class="fas fa-plus me-1"></i> Tambah Hari Libur
                                    </button>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th width="200">Tanggal</th>
                                                <th>Keterangan</th>
                                                <th width="100" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e(\Carbon\Carbon::parse($h->tanggal)->format('d/m/Y')); ?></td>
                                                <td><?php echo e($h->keterangan); ?></td>
                                                <td class="text-center">
                                                    <form action="<?php echo e(route('absensi.destroy_holiday', $h->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-link btn-danger p-0" onclick="return confirm('Hapus hari libur ini?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-4">Belum ada daftar hari libur yang diinput.</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <?php echo e($holidays->links('partials.pagination')); ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo e(route('absensi.import')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Import Data Flashdisk (Absensi)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group p-0">
                        <label class="mb-2">Pilih File Laporan Detail (CSV/EXCEL)</label>
                        <input type="file" name="file_absensi" class="form-control" required>
                        <small class="form-text text-muted">Gunakan file <b>Laporan Detail Kehadiran</b> dari mesin.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round">Mulai Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalImportIzin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo e(route('absensi.import_izin')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-info">Import Laporan Izin (CSV/EXCEL)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group p-0">
                        <label class="mb-2">Pilih File Laporan Izin (CSV/EXCEL)</label>
                        <input type="file" name="file_izin" class="form-control" required>
                        <small class="form-text text-muted">Gunakan file <b>Laporan Izin Karyawan</b> dari Fingerspot.io</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info btn-round text-white">Mulai Import Izin</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDeleteAbsensi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo e(route('absensi.delete_range')); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-danger">Hapus Log Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Pilih rentang tanggal data <b>Absensi (Log Mesin)</b> yang ingin dihapus secara permanen.</p>
                    <div class="row">
                        <div class="col-6">
                            <label class="small fw-bold">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data absensi pada rentang tanggal tersebut?')">Hapus Permanen</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDeleteIzin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo e(route('absensi.delete_izin_range')); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-danger">Hapus Data Perizinan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Pilih rentang tanggal data <b>Perizinan</b> yang ingin dihapus secara permanen.</p>
                    <div class="row">
                        <div class="col-6">
                            <label class="small fw-bold">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data perizinan pada rentang tanggal tersebut?')">Hapus Permanen</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalAddHoliday" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo e(route('absensi.store_holiday')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Tambah Hari Libur Nasional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group p-0 mb-3">
                                <label class="mb-2 small fw-bold">Mulai Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group p-0 mb-3">
                                <label class="mb-2 small fw-bold">Sampai (Opsional)</label>
                                <input type="date" name="tanggal_akhir" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group p-0">
                        <label class="mb-2 small fw-bold">Keterangan / Nama Libur</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Libur Hari Raya" required>
                    </div>
                    <small class="text-muted mt-2 d-block">* Kosongkan 'Sampai' jika hanya libur 1 hari.</small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round">Simpan Libur</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalViewFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0 text-center">
                <img src="" id="modal-foto-src" class="img-fluid rounded-4" style="width: 100%; object-fit: contain;">
                <p class="text-muted mt-3 mb-0 fw-bold" id="modal-nama-karyawan"></p>
            </div>
        </div>
    </div>
    </div>
</div>


<div class="modal fade" id="modalEditIzin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="formEditIzin" method="POST" action="">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Ubah Status Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">Jika status diubah menjadi <strong>Diterima</strong>, maka absensi akan dihitung "Hadir" dan gaji tidak akan terpotong. Jika <strong>Ditolak</strong>, maka tetap dihitung "Tidak Hadir".</p>
                    <div class="form-group p-0">
                        <label class="mb-2 small fw-bold">Status Persetujuan</label>
                        <select name="status" id="edit_izin_status" class="form-select form-control" required>
                            <option value="approved">Diterima (Dihitung Hadir)</option>
                            <option value="pending">Pending (Menunggu Persetujuan)</option>
                            <option value="rejected">Ditolak (Dihitung Tidak Hadir)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalDoughnutHadir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-round">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success"><i class="fas fa-check-circle me-2"></i>Detail Kehadiran Tepat Waktu</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Role</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $listDoughnutHadir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo e($log->user->nama_lengkap ?? $log->user->name ?? 'Unknown'); ?></span>
                                    </td>
                                    <td><span class="badge badge-primary"><?php echo e($log->user->name ?? '-'); ?></span></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y')); ?></td>
                                    <td><span class="text-success fw-bold"><?php echo e(substr($log->jam, 0, 5)); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDoughnutTelat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-round">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Detail Keterlambatan</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Role</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $listDoughnutTelat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo e($log->user->nama_lengkap ?? $log->user->name ?? 'Unknown'); ?></span>
                                    </td>
                                    <td><span class="badge badge-primary"><?php echo e($log->user->name ?? '-'); ?></span></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y')); ?></td>
                                    <td><span class="text-danger fw-bold"><?php echo e(substr($log->jam, 0, 5)); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDoughnutAbsen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-round">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger"><i class="fas fa-times-circle me-2"></i>Detail Absen (Tanpa Keterangan)</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Role</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $listDoughnutAbsen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo e($log->user->nama_lengkap ?? $log->user->name ?? 'Unknown'); ?></span>
                                    </td>
                                    <td><span class="badge badge-primary"><?php echo e($log->user->name ?? '-'); ?></span></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($log->tanggal)->translatedFormat('d M Y')); ?></td>
                                    <td><span class="text-danger fw-bold"><?php echo e($log->keterangan); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-animate { transition: transform 0.3s ease; }
    .card-animate:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .nav-pills.nav-secondary .nav-link.active { background: #6861ce !important; }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // AJAX Pagination untuk menghindari refresh halaman dan lompat tab
        $(document).on('click', '.tab-pane .pagination a', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var targetTab = $(this).closest('.tab-pane');
            
            // Tambahkan overlay loading sederhana
            var originalContent = targetTab.html();
            targetTab.html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Memuat data...</p></div>');
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var newContent = $(data).find('#' + targetTab.attr('id')).html();
                    targetTab.html(newContent);
                    // Update URL browser tanpa refresh (opsional, tapi bagus untuk share link)
                    window.history.pushState("", "", url);
                },
                error: function() {
                    targetTab.html(originalContent);
                    alert('Terjadi kesalahan saat memuat data. Silakan coba lagi.');
                }
            });
        });
        
        // Ingat Tab Aktif saat reload (sebagai fallback backup)
        $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeAbsensiTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeAbsensiTab');
        if(activeTab){
            var triggerEl = document.querySelector('a[href="' + activeTab + '"]');
            if(triggerEl) {
                var tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        let tabToActivate = null;

        // 1. Prioritaskan parameter paginasi dari URL
        if (urlParams.has('page_libur')) {
            tabToActivate = document.querySelector('#pills-libur-tab');
        } else if (urlParams.has('page_izin')) {
            tabToActivate = document.querySelector('#pills-izin-tab');
        } else if (urlParams.has('page_absen')) {
            tabToActivate = document.querySelector('#pills-log-tab');
        } else {
            // 2. Fallback ke Local Storage jika tidak ada parameter paginasi
            let activeTabId = localStorage.getItem('activeTabAbsensi');
            if (activeTabId) {
                tabToActivate = document.querySelector(activeTabId);
            }
        }

        // Buka tab
        if (tabToActivate) {
            new bootstrap.Tab(tabToActivate).show();
        }

        // Simpan ID tab ke Local Storage saat tab diklik/berubah
        const tabElements = document.querySelectorAll('a[data-bs-toggle="pill"]');
        tabElements.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeTabAbsensi', '#' + event.target.id);
            });
        });
    });
</script>

<script>
    function showFoto(url, nama) {
        document.getElementById('modal-foto-src').src = url;
        document.getElementById('modal-nama-karyawan').innerText = nama;
    }

    document.addEventListener("DOMContentLoaded", function() {
        const editIzinButtons = document.querySelectorAll('.btn-edit-izin');
        const formEditIzin = document.getElementById('formEditIzin');
        const selectStatus = document.getElementById('edit_izin_status');

        editIzinButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const status = this.getAttribute('data-status');
                
                // Set the action URL dynamically
                formEditIzin.action = `/absensi/izin/${id}/status`;
                
                // Set the current status
                selectStatus.value = status;
            });
        });
    });

    // --- CHART DASHBOARD ABSENSI ---
    document.addEventListener("DOMContentLoaded", function() {
        // Doughnut Chart (Proporsi Filter)
        const doughnutCtx = document.getElementById('filterDoughnutChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Telat', 'Absen'],
                datasets: [{
                    data: [<?php echo e($doughnutHadir); ?>, <?php echo e($doughnutTelat); ?>, <?php echo e($doughnutAbsen); ?>],
                    backgroundColor: ['#22c55e', '#eab308', '#ef4444'], // Tailwind colors
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

        // Line Chart (Tren 6 Bulan Terakhir)
        const lineCtx = document.getElementById('trendLineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($lineLabels); ?>,
                datasets: [
                    {
                        label: 'Hadir Tepat Waktu',
                        data: <?php echo json_encode($lineHadir); ?>,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Telat',
                        data: <?php echo json_encode($lineTelat); ?>,
                        borderColor: '#eab308',
                        backgroundColor: 'rgba(234, 179, 8, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 10 }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/absensi.blade.php ENDPATH**/ ?>
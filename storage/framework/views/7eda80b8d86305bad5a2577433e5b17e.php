 

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">
        
        
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Monitoring Operasional Pelatihan</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau jadwal, personil, administrasi, dan distribusi sertifikat klien</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="<?php echo e(route('monitoring.pelatihan.tv')); ?>" target="_blank" class="btn btn-dark btn-round fw-bold shadow-sm hover-lift px-4">
                    <i class="fas fa-tv me-2 text-warning"></i> TV Monitor Mode
                </a>
            </div>
        </div>

        
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card glass-card h-100 border-0">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-gradient-primary shadow-sm me-3">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Pelatihan Running</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1"><?php echo e($statRunning ?? 0); ?> <span style="font-size: 14px;" class="text-muted fw-medium">Kelas</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card glass-card h-100 border-0">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-gradient-warning shadow-sm me-3">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Validasi Admin</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1"><?php echo e($statValidasi ?? 0); ?> <span style="font-size: 14px;" class="text-muted fw-medium">Kelas</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card glass-card h-100 border-0">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-gradient-info shadow-sm me-3">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat OGP</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1"><?php echo e($statOgp ?? 0); ?> <span style="font-size: 14px;" class="text-muted fw-medium">Batch</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card glass-card h-100 border-0">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="stat-icon-wrapper bg-gradient-success shadow-sm me-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat Dikirim</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1"><?php echo e($statDikirim ?? 0); ?> <span style="font-size: 14px;" class="text-muted fw-medium">Resi</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav nav-pills nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex overflow-auto" id="pills-tab" role="tablist" style="max-width: 100%;">
                <button class="nav-link active text-nowrap" id="pills-pelaksanaan-tab" data-bs-toggle="tab" data-bs-target="#pills-pelaksanaan" type="button" role="tab">
                    <i class="fas fa-chalkboard-teacher me-1"></i> 1. Pelaksanaan & Jadwal
                </button>
                <?php
                    $totalKomentar = $pelatihans->filter(function($p) {
                        return !empty($p->komentar_superadmin) || !empty($p->komentar_spv_marketing) || !empty($p->komentar_team_leader);
                    })->count();
                ?>
                <button class="nav-link text-nowrap" id="pills-administrasi-tab" data-bs-toggle="tab" data-bs-target="#pills-administrasi" type="button" role="tab">
                    <i class="fas fa-file-signature me-1"></i> 2. Administrasi & Evaluasi
                    <?php if($totalKomentar > 0): ?>
                        <span class="badge bg-danger rounded-pill ms-1 pulse" style="font-size: 10px;"><?php echo e($totalKomentar); ?></span>
                    <?php endif; ?>
                </button>
                <button class="nav-link text-nowrap" id="pills-sertifikat-tab" data-bs-toggle="tab" data-bs-target="#pills-sertifikat" type="button" role="tab">
                    <i class="fas fa-award me-1"></i> 3. Monitoring Sertifikat
                </button>
            </div>
        </div>

        
        <div class="tab-content fade-in" id="pills-tabContent">
            
            
            <div class="tab-pane fade show active" id="pills-pelaksanaan" role="tabpanel">
                <div class="glass-card mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Data Kelas (Sertifikasi, Jadwal, Tim Pengajar, Kelembagaan)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Program Pelatihan & Sertifikasi</th>
                                        <th width="200">Jadwal Pelaksanaan</th>
                                        <th width="300">Tim Lapangan (Pengajar & Pengawas)</th>
                                        <th width="250">Kelembagaan & PIC</th>
                                        <th class="text-center pe-4" width="150">Status Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $pesertaList = $pelatihan->pendaftaranPribadis;
                                            $marketingData = [];
                                            $sertifikasi = 'Lainnya';
                                            $isSyncRiwayat = false;
                                            
                                            if ($pesertaList->isEmpty() && $pelatihan->riwayat) {
                                                $isSyncRiwayat = true;
                                                $sertifikasi = $pelatihan->training->nama_training ?? 'Lainnya';
                                                
                                                $marketingJson = json_decode($pelatihan->riwayat->marketing, true);
                                                if (is_array($marketingJson)) {
                                                    foreach($marketingJson as $mkt) {
                                                        $mktName = $mkt ?: 'Unknown';
                                                        if(!isset($marketingData[$mktName])) {
                                                            $marketingData[$mktName] = 0;
                                                        }
                                                        $marketingData[$mktName]++;
                                                    }
                                                }
                                            } else {
                                                foreach($pesertaList as $p) {
                                                    if ($p->tipe_pendaftaran == 'kolektif' && $p->kolektif && $p->kolektif->cta && $p->kolektif->cta->prospek) {
                                                        $mktName = $p->kolektif->cta->prospek->marketing->name ?? 'Unknown';
                                                    } else if ($p->cta && $p->cta->prospek) {
                                                        $mktName = $p->cta->prospek->marketing->name ?? 'Unknown';
                                                    } else {
                                                        $mktName = 'Unknown';
                                                    }
                                                    
                                                    if(!isset($marketingData[$mktName])) {
                                                        $marketingData[$mktName] = 0;
                                                    }
                                                    $marketingData[$mktName]++;
                                                }
                                            }

                                            $firstPendaftaran = $pesertaList->first();
                                            $skema = '';
                                            if ($firstPendaftaran) {
                                                if ($firstPendaftaran->tipe_pendaftaran == 'kolektif' && $firstPendaftaran->kolektif && $firstPendaftaran->kolektif->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->kolektif->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->kolektif->cta->skema);
                                                } else if ($firstPendaftaran->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->cta->skema);
                                                }
                                            }

                                            if (empty($skema) && strtolower($pelatihan->lokasi) == 'titip vendor lain') {
                                                $skema = 'titip vendor lain';
                                            }

                                            // Badge Status Kelas
                                            $statusBadgeMap = [
                                                'persiapan' => ['class' => 'bg-warning text-dark', 'text' => 'Persiapan'],
                                                'running' => ['class' => 'bg-primary', 'text' => 'Running'],
                                                'selesai' => ['class' => 'bg-success', 'text' => 'Selesai'],
                                                'batal' => ['class' => 'bg-danger', 'text' => 'Batal'],
                                            ];
                                            $badgeInfo = $statusBadgeMap[$pelatihan->status_kelas] ?? $statusBadgeMap['persiapan'];
                                        ?>
                                    <tr>
                                        <td class="ps-4 cell-relative">
                                            <?php if($isSyncRiwayat): ?>
                                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary border border-secondary text-white" style="font-size: 9px;"><i class="fas fa-sync-alt me-1"></i> Hasil Sync Riwayat</span>
                                                <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Judul & Sertifikasi" data-bs-toggle="modal" data-bs-target="#modalUpdateInfoRiwayat-<?php echo e($pelatihan->id); ?>"><i class="fas fa-pen"></i></button>
                                            </div>
                                            <?php endif; ?>
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">
                                                <?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->judul_pelatihan ?? (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')) : (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')); ?>

                                                <?php if($isSyncRiwayat): ?> <span class="badge bg-light text-secondary border ms-1" style="font-size: 10px;">Input Manual</span> <?php endif; ?>
                                            </div>
                                            <div class="fw-bold text-primary mt-1 mb-2" style="font-size: 13px;">
                                                <i class="fas fa-certificate me-1"></i> 
                                                <?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->jenis ?? (optional($pelatihan->training)->nama_training ?? 'Lainnya')) : $sertifikasi); ?>

                                            </div>
                                            
                                            <div class="d-flex flex-column gap-1 bg-light p-2 rounded border border-light">
                                                <?php $__empty_2 = true; $__currentLoopData = $marketingData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <span class="text-dark fw-bold" style="font-size: 10px;">
                                                    <i class="fas fa-user-tie text-muted me-1"></i> <?php echo e($mkt); ?> <span class="badge bg-white text-primary border px-1 ms-1"><?php echo e($count); ?> org</span>
                                                </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <span class="text-muted" style="font-size: 10px;">
                                                    <i class="fas fa-user-tie me-1"></i> Belum ada peserta
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <button class="btn btn-sm btn-light border shadow-sm btn-round text-primary hover-lift mt-2 w-100" style="font-size: 10px; max-width: 180px;" data-bs-toggle="modal" data-bs-target="#modalDetailPeserta-<?php echo e($pelatihan->id); ?>">
                                                <i class="fas fa-users me-1"></i> Lihat Detail Peserta
                                            </button>
                                        </td>
                                        
                                        
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper d-flex flex-column gap-1">
                                                <div class="bg-light p-2 rounded border">
                                                    <small class="text-muted d-block" style="font-size: 9px;">TGL PELATIHAN</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">
                                                        <?php echo e($pelatihan->tanggal_pelatihan ? \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->translatedFormat('d M Y') : 'Belum Diset'); ?>

                                                        <?php if($pelatihan->tanggal_selesai): ?>
                                                            - <?php echo e(\Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d M Y')); ?>

                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                                <div class="bg-danger-subtle p-2 rounded border border-danger-subtle">
                                                    <small class="text-danger d-block" style="font-size: 9px;">TGL ASESMEN</small>
                                                    <span class="fw-bold text-danger" style="font-size: 11px;">
                                                        <?php echo e($pelatihan->tanggal_asesmen ? \Carbon\Carbon::parse($pelatihan->tanggal_asesmen)->translatedFormat('d M Y') : 'Belum Diset'); ?>

                                                    </span>
                                                </div>
                                                <div class="bg-info-subtle p-2 rounded border border-info-subtle mb-1">
                                                    <small class="text-info d-block" style="font-size: 9px;">LOKASI / VENUE</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">
                                                        <i class="fas fa-map-marker-alt text-muted me-1"></i> <?php echo e($pelatihan->lokasi ?? 'Belum Diset'); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Jadwal & Lokasi" data-bs-toggle="modal" data-bs-target="#modalUpdateJadwal-<?php echo e($pelatihan->id); ?>"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                <?php if($skema == 'titip vendor lain'): ?>
                                                <div class="mb-2">
                                                    <span class="badge badge-soft-warning border border-warning text-dark px-2 py-1 mb-2 d-inline-block" style="font-size: 10px;">Titip Vendor</span>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 12px;"><i class="fas fa-building text-primary me-1"></i> <?php echo e($pelatihan->instruktur ?? '-'); ?></span>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fas fa-user text-success me-1"></i> PIC: <?php echo e($pelatihan->asesor ?? '-'); ?></span>
                                                    <?php if($pelatihan->wa_trainer): ?>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fab fa-whatsapp text-success me-1"></i> WA: <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $pelatihan->wa_trainer)); ?>" target="_blank" class="text-success text-decoration-none"><?php echo e($pelatihan->wa_trainer); ?></a></span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php else: ?>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Instruktur & Asesor</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 12px;"><i class="fas fa-chalkboard-teacher text-primary me-1"></i> Inst: <?php echo e($pelatihan->instruktur ?? '-'); ?></span>
                                                    <?php if($pelatihan->wa_trainer): ?>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fab fa-whatsapp text-success me-1"></i> WA: <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $pelatihan->wa_trainer)); ?>" target="_blank" class="text-success text-decoration-none"><?php echo e($pelatihan->wa_trainer); ?></a></span>
                                                    <?php endif; ?>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 12px;"><i class="fas fa-user-check text-success me-1"></i> Asr: <?php echo e($pelatihan->asesor ?? '-'); ?></span>
                                                </div>
                                                <div class="bg-gray-50 p-2 rounded border mb-0">
                                                    <small class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Pengawas (Wasnaker)</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 11px;"><?php echo e($pelatihan->pengawas ?? 'Belum Diset'); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Tim" data-bs-toggle="modal" data-bs-target="#modalUpdateTim-<?php echo e($pelatihan->id); ?>"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                <?php if($skema == 'titip vendor lain'): ?>
                                                <div class="mb-2" style="font-size: 11px;">
                                                    <span class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Nama Lembaga</span>
                                                    <span class="fw-bold text-dark d-block"><i class="fas fa-building text-info me-1"></i> <?php echo e($pelatihan->pjk3 ?? 'Belum Diset'); ?></span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <span class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">PIC Internal</span>
                                                    <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                        <i class="fas fa-user-shield text-success me-1"></i> <?php echo e($pelatihan->pic_operasional ?? 'Belum Diset'); ?>

                                                    </span>
                                                </div>
                                                <?php else: ?>
                                                <div class="mb-2" style="font-size: 11px;">
                                                    <span class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Lembaga & PJK3</span>
                                                    <span class="fw-bold text-dark d-block"><i class="fas fa-building text-info me-1"></i> <?php echo e($pelatihan->pjk3 ?? 'Belum Diset'); ?></span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <span class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Penanggung Jawab (PIC)</span>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-user-tie text-primary me-1"></i> Eksternal: <?php echo e($pelatihan->pic_klien ?? 'Belum Diset'); ?>

                                                        </span>
                                                        <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-user-shield text-success me-1"></i> Internal: <?php echo e($pelatihan->pic_operasional ?? 'Belum Diset'); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Lembaga & PIC" data-bs-toggle="modal" data-bs-target="#modalUpdateLembaga-<?php echo e($pelatihan->id); ?>"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        <td class="text-center pe-4">
                                            <span class="badge <?php echo e($badgeInfo['class']); ?> rounded-pill px-3 py-2 shadow-sm d-block mb-2 w-100"><?php echo e($badgeInfo['text']); ?></span>
                                            <button class="btn btn-sm btn-light border btn-round text-muted d-block w-100 hover-lift px-3 mb-1" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusKelas-<?php echo e($pelatihan->id); ?>">Ubah Status</button>
                                            <button class="btn btn-sm btn-danger btn-round text-white d-block w-100 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalHapusPelatihan-<?php echo e($pelatihan->id); ?>">Hapus Data</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data pelatihan berjalan.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="tab-pane fade" id="pills-administrasi" role="tabpanel">
                <div class="glass-card mb-4">
                    <div class="card-header bg-light border-bottom p-3 d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Pemberkasan Laporan, Validasi & Evaluasi Lapangan</h6>
                    </div>
                    <div class="card-body p-0">
                        
                        
                        <div class="alert bg-warning-subtle border-0 text-warning-dark m-3 py-2 px-3 rounded-3 d-flex align-items-center shadow-sm">
                            <i class="fas fa-bullhorn fs-5 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 13px;">SOP Upload Laporan Lembaga</h6>
                                <p class="mb-0 small opacity-75" style="font-size: 11px;">Maksimal <b>H+2</b> setelah pelatihan selesai untuk sertifikasi <b>BNSP</b>, dan maksimal <b>H+7</b> untuk sertifikasi <b>KEMNAKER</b>.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0" style="min-width: 2000px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="300">Sertifikasi, Judul & Klien</th>
                                        <th width="250">Validasi Administrasi</th>
                                        <th width="350">Link Laporan (Internal & Lembaga)</th>
                                        <th width="350">Evaluasi Pelaksanaan</th>
                                        <th width="300">Komentar / Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $firstPendaftaran = $pelatihan->pendaftaranPribadis->first();
                                            $sertifikasi = 'Lainnya';
                                            $skema = '';
                                            if ($firstPendaftaran) {
                                                if ($firstPendaftaran->tipe_pendaftaran == 'kolektif' && $firstPendaftaran->kolektif && $firstPendaftaran->kolektif->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->kolektif->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->kolektif->cta->skema);
                                                } else if ($firstPendaftaran->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->cta->skema);
                                                }
                                            }
                                            
                                            if (empty($skema) && strtolower($pelatihan->lokasi) == 'titip vendor lain') {
                                                $skema = 'titip vendor lain';
                                            }

                                            $checklist = json_decode($pelatihan->checklist_validasi, true) ?? [];
                                            $progress = count($checklist);
                                            $percent = $progress > 0 ? round(($progress / 21) * 100) : 0;
                                            $percentColor = $percent == 100 ? 'primary' : 'warning';
                                            $isSyncRiwayat = $pelatihan->pendaftaranPribadis->isEmpty() && $pelatihan->riwayat;
                                        ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">
                                                    <?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->judul_pelatihan ?? (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')) : (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')); ?>

                                                    <?php if($isSyncRiwayat): ?> <span class="badge bg-light text-secondary border ms-1" style="font-size: 10px;">Input Manual</span> <?php endif; ?>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <span class="text-primary fw-bold" style="font-size: 13px;"><i class="fas fa-certificate me-1"></i> <?php echo e($sertifikasi); ?></span>
                                                    <?php if($pelatihan->komentar_superadmin || $pelatihan->komentar_spv_marketing || $pelatihan->komentar_team_leader): ?>
                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 10px;"><i class="fas fa-comment-dots me-1"></i> Ada Komentar</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <?php if($skema == 'titip vendor lain'): ?>
                                            <td colspan="4" class="text-center bg-gray-50 border-start">
                                                <div class="py-3">
                                                    <span class="badge badge-soft-warning border border-warning text-dark px-3 py-2" style="font-size: 13px;">
                                                        <i class="fas fa-building me-2"></i> Titip Vendor Lain
                                                    </span>
                                                    <p class="text-muted small mt-2 mb-0">Administrasi dan evaluasi dikelola oleh vendor terkait.</p>
                                                </div>
                                            </td>
                                            <?php else: ?>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                    <span class="text-<?php echo e($percentColor); ?> fw-bolder" style="font-size: 11px;"><?php echo e($percent); ?>% (<?php echo e($progress); ?>/21)</span>
                                                </div>
                                                <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                    <div class="progress-bar bg-<?php echo e($percentColor); ?> <?php echo e($percent == 100 ? 'rounded-pill' : ''); ?>" style="width: <?php echo e($percent); ?>%"></div>
                                                </div>
                                                <div class="d-flex gap-2 mt-2">
                                                    <button class="btn btn-sm btn-light border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi-<?php echo e($pelatihan->id); ?>" style="font-size: 11px;">
                                                        <i class="fas fa-check-square me-1"></i> Update Checklist
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    <?php if($pelatihan->file_laporan_internal): ?>
                                                    <div class="d-flex gap-2">
                                                        <a href="<?php echo e(asset($pelatihan->file_laporan_internal)); ?>" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1" style="color: #0ea5e9;">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Internal
                                                        </a>
                                                        <button class="btn btn-sm btn-light border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-<?php echo e($pelatihan->id); ?>"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    <?php else: ?>
                                                    <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-<?php echo e($pelatihan->id); ?>">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Internal
                                                    </button>
                                                    <?php endif; ?>

                                                    <?php if($pelatihan->file_laporan_kemnaker): ?>
                                                    <div class="d-flex gap-2">
                                                        <a href="<?php echo e(asset($pelatihan->file_laporan_kemnaker)); ?>" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1 text-success">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Instansi
                                                        </a>
                                                        <button class="btn btn-sm btn-light border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-<?php echo e($pelatihan->id); ?>"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    <?php else: ?>
                                                    <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-<?php echo e($pelatihan->id); ?>">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Instansi
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($pelatihan->evaluasi): ?>
                                                <div class="bg-gray-50 border p-3 rounded-4 position-relative">
                                                    <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.6;">
                                                        <i class="fas fa-comment-dots text-muted me-1"></i> <?php echo e(Str::limit($pelatihan->evaluasi, 100)); ?>

                                                    </p>
                                                    <button class="btn btn-sm btn-link text-muted position-absolute top-0 end-0 mt-1 me-1 p-1" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-<?php echo e($pelatihan->id); ?>">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                </div>
                                                <?php else: ?>
                                                <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                    <p class="mb-2 text-muted small fw-bold">Belum ada evaluasi pelaksanaan.</p>
                                                    <button class="btn btn-sm btn-light border btn-round shadow-sm hover-lift text-dark fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-<?php echo e($pelatihan->id); ?>">
                                                        <i class="fas fa-pen me-1"></i> Tulis Evaluasi
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    <?php if($pelatihan->komentar_superadmin || $pelatihan->komentar_spv_marketing || $pelatihan->komentar_team_leader): ?>
                                                        <?php
                                                            // Helper to extract JSON or fallback to raw string
                                                            $parseKomentar = function($raw) {
                                                                if (!$raw) return null;
                                                                $decoded = json_decode($raw, true);
                                                                if (is_array($decoded) && isset($decoded['text'])) {
                                                                    return (object) $decoded;
                                                                }
                                                                return (object) ['name' => null, 'text' => $raw];
                                                            };
                                                            $k_sa = $parseKomentar($pelatihan->komentar_superadmin);
                                                            $k_spv = $parseKomentar($pelatihan->komentar_spv_marketing);
                                                            $k_tl = $parseKomentar($pelatihan->komentar_team_leader);
                                                        ?>
                                                    
                                                        <?php if($k_sa): ?>
                                                        <div class="bg-primary-subtle border border-primary-subtle p-2 rounded-3">
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <span class="badge bg-primary px-2 py-1"><i class="fas fa-user-shield me-1"></i> <?php echo e($k_sa->name ?? 'Superadmin'); ?></span>
                                                            </div>
                                                            <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.4;"><?php echo e($k_sa->text); ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($k_spv): ?>
                                                        <div class="bg-warning-subtle border border-warning-subtle p-2 rounded-3">
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-bullhorn me-1"></i> <?php echo e($k_spv->name ?? 'SPV Marketing'); ?></span>
                                                            </div>
                                                            <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.4;"><?php echo e($k_spv->text); ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($k_tl): ?>
                                                        <div class="bg-info-subtle border border-info-subtle p-2 rounded-3">
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <span class="badge bg-info px-2 py-1"><i class="fas fa-users me-1"></i> <?php echo e($k_tl->name ?? 'Team Leader'); ?></span>
                                                            </div>
                                                            <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.4;"><?php echo e($k_tl->text); ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                        
                                                        <button class="btn btn-sm btn-light border shadow-sm fw-bold w-100 text-dark mt-1" data-bs-toggle="modal" data-bs-target="#modalUpdateKomentar-<?php echo e($pelatihan->id); ?>">
                                                            <i class="fas fa-pen me-1"></i> Edit Komentar
                                                        </button>
                                                    <?php else: ?>
                                                        <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                            <p class="mb-2 text-muted small fw-bold">Belum ada komentar.</p>
                                                            <button class="btn btn-sm btn-light border btn-round shadow-sm hover-lift text-dark fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalUpdateKomentar-<?php echo e($pelatihan->id); ?>">
                                                                <i class="fas fa-plus me-1"></i> Tambah
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="tab-pane fade" id="pills-sertifikat" role="tabpanel">
                <div class="glass-card mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Status Penerbitan, Pengiriman & Logistik</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0" style="min-width: 1600px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Program Pelatihan & Sertifikasi</th>
                                        <th class="text-center" width="180">Status Sertifikat</th>
                                        <th width="250">Timeline Sertifikat (Tgl)</th>
                                        <th width="150" class="text-center">Scan Sertifikat</th>
                                        <th width="280">Ekspedisi & Resi Foto</th>
                                        <th class="text-center pe-4" width="180">Tanda Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $firstPendaftaran = $pelatihan->pendaftaranPribadis->first();
                                            $sertifikasi = ($firstPendaftaran && $firstPendaftaran->cta) ? strtoupper($firstPendaftaran->cta->sertifikasi) : 'Lainnya';
                                            $picInfo = $pelatihan->pic_klien ?? 'Belum ditentukan';
                                            
                                            $badgeSertif = 'secondary';
                                            $iconSertif = 'hourglass-half';
                                            if($pelatihan->status_sertifikat == 'Terbit') { $badgeSertif = 'success'; $iconSertif = 'check-circle'; }
                                            elseif($pelatihan->status_sertifikat == 'Delay') { $badgeSertif = 'warning'; $iconSertif = 'exclamation-triangle'; }
                                            elseif($pelatihan->status_sertifikat == 'OGP') { $badgeSertif = 'primary'; $iconSertif = 'cog fa-spin'; }
                                            
                                            $isSyncRiwayat = $pelatihan->pendaftaranPribadis->isEmpty() && $pelatihan->riwayat;
                                        ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">
                                                    <?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->judul_pelatihan ?? (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')) : (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')); ?>

                                                    <?php if($isSyncRiwayat): ?> <span class="badge bg-light text-secondary border ms-1" style="font-size: 10px;">Input Manual</span> <?php endif; ?>
                                                </div>
                                                <div class="text-primary fw-bold mt-1" style="font-size: 13px;"><i class="fas fa-certificate me-1"></i> <?php echo e($sertifikasi); ?></div>
                                                <div class="text-primary small fw-bold mt-1"><i class="fas fa-user-tie me-1"></i> PIC: <?php echo e($picInfo); ?></div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-soft-<?php echo e($badgeSertif); ?> border border-<?php echo e($badgeSertif); ?> text-<?php echo e($badgeSertif == 'warning' ? 'dark' : $badgeSertif); ?> px-4 py-2 rounded-pill shadow-sm" style="font-size: 11px;">
                                                    <i class="fas fa-<?php echo e($iconSertif); ?> me-1"></i> <?php echo e($pelatihan->status_sertifikat ?? 'OGP'); ?>

                                                </span>
                                                <button class="btn btn-sm btn-light border btn-round text-muted d-block mx-auto mt-2 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusSertif-<?php echo e($pelatihan->id); ?>">Ubah Status</button>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Estimasi Terbit:</span>
                                                        <span class="fw-bold text-dark"><?php echo e($pelatihan->estimasi_terbit ? \Carbon\Carbon::parse($pelatihan->estimasi_terbit)->format('d M Y') : '-'); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Terima Dr Lembaga:</span>
                                                        <?php if($pelatihan->tgl_terima_lembaga): ?>
                                                            <span class="fw-bold text-success"><?php echo e(\Carbon\Carbon::parse($pelatihan->tgl_terima_lembaga)->format('d M Y')); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Kirim Ke Klien:</span>
                                                        <?php if($pelatihan->tgl_kirim_klien): ?>
                                                            <span class="fw-bold text-primary"><?php echo e(\Carbon\Carbon::parse($pelatihan->tgl_kirim_klien)->format('d M Y')); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($pelatihan->file_scan_sertifikat): ?>
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="<?php echo e(asset($pelatihan->file_scan_sertifikat)); ?>" target="_blank" class="btn btn-sm btn-light border text-info fw-bold btn-round shadow-sm hover-lift w-100">
                                                        <i class="fas fa-file-pdf me-1"></i> Lihat Scan
                                                    </a>
                                                    <button class="btn btn-sm btn-light border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-<?php echo e($pelatihan->id); ?>">Ganti File</button>
                                                </div>
                                                <?php else: ?>
                                                <button class="btn btn-sm btn-white text-info fw-bold btn-round shadow-sm hover-lift w-100" style="border: 1.5px dashed #7dd3fc;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-<?php echo e($pelatihan->id); ?>">
                                                    <i class="fas fa-cloud-upload-alt me-1"></i> Upload Scan
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($pelatihan->resi_pengiriman): ?>
                                                <div class="bg-gray-50 border p-2 rounded-3 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <span class="badge badge-soft-danger border border-danger mb-1 fw-bold"><?php echo e($pelatihan->ekspedisi ?? 'EKSPEDISI'); ?></span>
                                                            <span class="fw-bolder text-dark d-block" style="letter-spacing: 1px; font-size: 13px;"><?php echo e($pelatihan->resi_pengiriman); ?></span>
                                                        </div>
                                                        <button class="btn btn-sm btn-light border text-muted px-2 py-1 hover-lift" title="Edit Resi" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-<?php echo e($pelatihan->id); ?>"><i class="fas fa-pen"></i></button>
                                                    </div>
                                                    <?php if($pelatihan->foto_resi): ?>
                                                    <a href="<?php echo e(asset($pelatihan->foto_resi)); ?>" target="_blank" class="badge bg-white text-primary border border-primary text-decoration-none shadow-sm px-2 py-1 w-100 text-center hover-lift">
                                                        <i class="fas fa-camera me-1"></i> Foto Resi Fisik
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <?php else: ?>
                                                <button class="btn btn-sm btn-white text-primary fw-bold rounded-3 shadow-sm hover-lift w-100 py-3" style="border: 1.5px dashed #93c5fd;" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-<?php echo e($pelatihan->id); ?>">
                                                    <i class="fas fa-truck-loading me-1"></i> Input Resi
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center pe-4">
                                                <?php if($pelatihan->foto_tanda_terima): ?>
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="<?php echo e(asset($pelatihan->foto_tanda_terima)); ?>" target="_blank" class="btn btn-sm btn-success text-white btn-round shadow-sm hover-lift w-100 fw-bold">
                                                        <i class="fas fa-image me-1"></i> TTD
                                                    </a>
                                                    <button class="btn btn-sm btn-light border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-<?php echo e($pelatihan->id); ?>">Ganti Foto</button>
                                                </div>
                                                <?php else: ?>
                                                <button class="btn btn-sm btn-white text-success fw-bold btn-round shadow-sm hover-lift w-100 py-2" style="border: 1.5px dashed #86efac;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-<?php echo e($pelatihan->id); ?>">
                                                    <i class="fas fa-upload me-1"></i> Upload Bukti
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>




<?php $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade" id="modalUpdateInfoRiwayat-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-edit text-warning me-2"></i> Edit Judul & Sertifikasi</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="alert alert-info border-info bg-light-info text-info p-3 rounded" style="font-size: 13px;">
                    <i class="fas fa-info-circle me-2"></i> Perubahan di sini akan otomatis mengubah data di <b>Riwayat Pelatihan</b>.
                </div>
                <div class="row g-3">
                    <div class="col-12 mt-3">
                        <label class="label-modern">Judul Pelatihan <span class="text-danger">*</span></label>
                        <input type="text" name="judul_pelatihan" value="<?php echo e($pelatihan->riwayat->judul_pelatihan ?? optional($pelatihan->training)->nama_training); ?>" class="form-control input-modern shadow-none" required placeholder="Masukkan judul pelatihan">
                    </div>
                    <div class="col-12 mt-3">
                        <label class="label-modern">Sertifikasi / Jenis</label>
                        <input type="text" name="jenis" value="<?php echo e($pelatihan->riwayat->jenis ?? ''); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Sertifikat KEMNAKER / Sertifikat BNSP">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-premium btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Data</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateJadwal-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="status_kelas" value="<?php echo e($pelatihan->status_kelas); ?>">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-calendar-alt text-warning me-2"></i> Set Jadwal & Lokasi Kelas</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-6 mt-3">
                        <label class="label-modern">Mulai Pelatihan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pelatihan" value="<?php echo e($pelatihan->tanggal_pelatihan); ?>" class="form-control input-modern shadow-none" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="label-modern">Selesai Pelatihan</label>
                        <input type="date" name="tanggal_selesai" value="<?php echo e($pelatihan->tanggal_selesai); ?>" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-12 mt-3">
                        <label class="label-modern text-danger">Tanggal Asesmen / Ujian</label>
                        <input type="date" name="tanggal_asesmen" value="<?php echo e($pelatihan->tanggal_asesmen); ?>" class="form-control input-modern shadow-none border-danger text-danger">
                    </div>
                    
                    <div class="col-12 mt-3">
                        <label class="label-modern">Lokasi Pelaksanaan</label>
                        <input type="text" name="lokasi" value="<?php echo e($pelatihan->lokasi); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Virtual (Zoom) / Hotel Grand Rohan Jogja">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-premium btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Data</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateTim-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="status_kelas" value="<?php echo e($pelatihan->status_kelas); ?>">
            <input type="hidden" name="tanggal_pelatihan" value="<?php echo e($pelatihan->tanggal_pelatihan); ?>">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-users-cog text-warning me-2"></i> Set Tim Pengajar & Pengawas</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Nama Instruktur / Trainer</label>
                    <input type="text" name="instruktur" value="<?php echo e($pelatihan->instruktur); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ahmad Fauzi">
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor WA Instruktur</label>
                    <input type="text" name="wa_trainer" value="<?php echo e($pelatihan->wa_trainer); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: 081234567890">
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nama Asesor / Evaluator</label>
                    <input type="text" name="asesor" value="<?php echo e($pelatihan->asesor); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ridwan R.">
                </div>
                
                <hr class="border-light my-4">
                <h6 class="fw-bolder text-dark mb-3" style="font-size: 13px;">Pengawas Kemnaker (Wasnaker) <span class="text-muted fw-normal fst-italic">opsional</span></h6>
                
                <div class="mb-3">
                    <label class="label-modern">Nama Wasnaker</label>
                    <input type="text" name="pengawas" value="<?php echo e($pelatihan->pengawas); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Sudarsono">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success text-white btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Tim</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateLembaga-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="status_kelas" value="<?php echo e($pelatihan->status_kelas); ?>">
            <input type="hidden" name="tanggal_pelatihan" value="<?php echo e($pelatihan->tanggal_pelatihan); ?>">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-building text-warning me-2"></i> Set Kelembagaan & PIC</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="label-modern">PJK3 / Lembaga Penyelenggara</label>
                        <input type="text" name="pjk3" value="<?php echo e($pelatihan->pjk3); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: PT Arsa Safety">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="label-modern">PIC Eksternal (Lembaga Sertifikasi)</label>
                        <input type="text" name="pic_klien" value="<?php echo e($pelatihan->pic_klien); ?>" class="form-control input-modern shadow-none" placeholder="Contoh: Ibu Vina (HRD)">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="label-modern">PIC Internal (Operasional)</label>
                        <select name="pic_operasional" class="form-select input-modern shadow-none">
                            <option value="">-- Pilih PIC Operasional --</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->name); ?>" <?php echo e($pelatihan->pic_operasional == $user->name ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-premium btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Data</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateStatusKelas-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="tanggal_pelatihan" value="<?php echo e($pelatihan->tanggal_pelatihan); ?>">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-flag text-warning me-2"></i> Update Status Kelas</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih Status Baru</label>
                <select name="status_kelas" class="form-select input-modern shadow-none" style="height: 45px;">
                    <option value="persiapan" <?php echo e($pelatihan->status_kelas == 'persiapan' ? 'selected' : ''); ?>>🟡 Persiapan (Setup Kelas)</option>
                    <option value="running" <?php echo e($pelatihan->status_kelas == 'running' ? 'selected' : ''); ?>>🔵 Running (Sedang Berjalan)</option>
                    <option value="selesai" <?php echo e($pelatihan->status_kelas == 'selesai' ? 'selected' : ''); ?>>🟢 Selesai (Menunggu Sertifikat)</option>
                    <option value="batal" <?php echo e($pelatihan->status_kelas == 'batal' ? 'selected' : ''); ?>>🔴 Batal</option>
                </select>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-premium btn-round fw-bold w-100 shadow-sm hover-lift">Simpan Status</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalDetailPeserta-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-users text-warning me-2"></i> Detail Peserta Pelatihan</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-custom align-middle mb-0" style="min-width: 1000px;">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4" width="200">Nama Peserta</th>
                                <th width="150">Tanggal Lahir</th>
                                <th width="200">Alamat Perusahaan</th>
                                <th width="150">Nomor WA</th>
                                <th width="200">Nama Perusahaan</th>
                                <th class="pe-4" width="150">Marketing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($pelatihan->pendaftaranPribadis->isEmpty() && $pelatihan->riwayat): ?>
                                <?php
                                    $namaArray = json_decode($pelatihan->riwayat->nama_peserta, true) ?? [];
                                    $instansiArray = json_decode($pelatihan->riwayat->instansi_peserta, true) ?? [];
                                    $waArray = json_decode($pelatihan->riwayat->wa_peserta, true) ?? [];
                                    $mktArray = json_decode($pelatihan->riwayat->marketing, true) ?? [];
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $namaArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark" style="font-size: 13px;"><?php echo e($nama); ?></td>
                                        <td style="font-size: 12px;">-</td>
                                        <td style="font-size: 12px;" class="text-truncate" style="max-width: 200px;">-</td>
                                        <td style="font-size: 12px;"><a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $waArray[$index] ?? '')); ?>" target="_blank" class="text-success fw-bold text-decoration-none"><i class="fab fa-whatsapp me-1"></i> <?php echo e($waArray[$index] ?? '-'); ?></a></td>
                                        <td style="font-size: 12px;"><?php echo e($instansiArray[$index] ?? '-'); ?></td>
                                        <td class="pe-4" style="font-size: 12px;"><span class="badge bg-light text-dark border"><?php echo e($mktArray[$index] ?? 'Unknown'); ?></span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data peserta.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php $__empty_1 = true; $__currentLoopData = $pelatihan->pendaftaranPribadis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        if ($p->tipe_pendaftaran == 'kolektif' && $p->kolektif && $p->kolektif->cta && $p->kolektif->cta->prospek) {
                                            $mktName = $p->kolektif->cta->prospek->marketing->name ?? 'Unknown';
                                        } else if ($p->cta && $p->cta->prospek) {
                                            $mktName = $p->cta->prospek->marketing->name ?? 'Unknown';
                                        } else {
                                            $mktName = 'Unknown';
                                        }
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark" style="font-size: 13px;"><?php echo e($p->nama_lengkap); ?></td>
                                        <td style="font-size: 12px;"><?php echo e($p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d M Y') : '-'); ?></td>
                                        <td style="font-size: 12px;" class="text-truncate" style="max-width: 200px;" title="<?php echo e($p->alamat_perusahaan); ?>"><?php echo e(Str::limit($p->alamat_perusahaan, 30)); ?></td>
                                        <td style="font-size: 12px;"><a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $p->no_wa)); ?>" target="_blank" class="text-success fw-bold text-decoration-none"><i class="fab fa-whatsapp me-1"></i> <?php echo e($p->no_wa); ?></a></td>
                                        <td style="font-size: 12px;"><?php echo e($p->perusahaan); ?></td>
                                        <td class="pe-4" style="font-size: 12px;"><span class="badge bg-light text-dark border"><?php echo e($mktName); ?></span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data peserta.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade" id="modalUpdateValidasi-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern" >
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-white mb-0">Update Validasi Checklist</h5>
                        <?php $isSyncRiwayat = $pelatihan->pendaftaranPribadis->isEmpty() && $pelatihan->riwayat; ?>
                        <p class="text-muted mb-0" style="font-size: 12px;">Program: <strong class="text-dark"><?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->judul_pelatihan ?? (optional($pelatihan->training)->nama_training ?? '-')) : (optional($pelatihan->training)->nama_training ?? '-')); ?></strong></p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body px-4 px-md-5 pt-4 pb-4" style="background-color: #f8fafc; overflow-y: auto; max-height: calc(100vh - 120px);">
                    <?php $checklist = json_decode($pelatihan->checklist_validasi, true) ?? []; ?>
                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-folder-open text-warning me-2"></i> 1. Administrasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Persyaratan Peserta" <?php echo e(in_array('Persyaratan Peserta', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Persyaratan Peserta</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="E Certificate" <?php echo e(in_array('E Certificate', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">E Certificate</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Form Evaluasi" <?php echo e(in_array('Form Evaluasi', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Form Evaluasi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Review Google" <?php echo e(in_array('Review Google', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Review Google</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-laptop-house text-info me-2"></i> 2. Online Support / Fasilitas</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Materi" <?php echo e(in_array('Link Zoom Materi', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Materi</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="url" name="link_zoom_pelatihan" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Zoom Materi" value="<?php echo e($pelatihan->link_zoom_pelatihan); ?>">
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Asesment" <?php echo e(in_array('Link Zoom Asesment', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Asesment</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="url" name="link_zoom_asesmen" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Zoom Asesmen" value="<?php echo e($pelatihan->link_zoom_asesmen); ?>">
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Background Zoom" <?php echo e(in_array('Background Zoom', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Background Zoom / Banner</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="file" name="background_zoom" class="form-control form-control-sm shadow-none" accept=".jpg,.jpeg,.png">
                                        <?php if($pelatihan->background_zoom): ?>
                                        <div class="mt-2">
                                            <a href="<?php echo e(asset($pelatihan->background_zoom)); ?>" target="_blank" class="badge badge-soft-info text-decoration-none px-3 py-2 border border-info rounded-pill" style="font-size: 10px;">
                                                <i class="fas fa-image me-1"></i> <?php echo e(basename($pelatihan->background_zoom)); ?>

                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Profil Grup WA" <?php echo e(in_array('Foto Profil Grup WA', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Foto Profil Grup WA</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Modul Pelatihan" <?php echo e(in_array('Modul Pelatihan', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Modul Pelatihan (Maks 5MB)</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="file" name="modul" class="form-control form-control-sm shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                                        <?php if($pelatihan->modul): ?>
                                        <div class="mt-2">
                                            <a href="<?php echo e(asset($pelatihan->modul)); ?>" target="_blank" class="badge badge-soft-info text-decoration-none px-3 py-2 border border-info rounded-pill" style="font-size: 10px;">
                                                <i class="fas fa-file-pdf me-1"></i> <?php echo e(basename($pelatihan->modul)); ?>

                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    
                                    <?php
                                        $latestModul = null;
                                        if($pelatihan->modul) {
                                            $latestModul = \App\Models\ModulPelatihan::where('file_path', $pelatihan->modul)->orderBy('id', 'desc')->first();
                                        }
                                        $valJudul = $latestModul ? $latestModul->judul_modul : ($pelatihan->training->nama_training ?? ($pelatihan->riwayat->judul_pelatihan ?? ''));
                                        $valSertifikasi = $latestModul ? $latestModul->sertifikasi : '';
                                        $valKategori = $latestModul ? $latestModul->kategori : '';
                                    ?>
                                    <div class="bg-light p-2 rounded-3 border mb-3 mt-2" style="font-size: 11px;">
                                        <div class="fw-bold text-dark mb-2"><i class="fas fa-sync text-info me-1"></i> Sinkronisasi ke Modul Pelatihan</div>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <input type="text" name="judul_modul_sync" class="form-control form-control-sm" placeholder="Judul Modul" value="<?php echo e($valJudul); ?>">
                                            </div>
                                            <div class="col-6">
                                                <select name="sertifikasi_modul_sync" class="form-select form-select-sm">
                                                    <option value="KEMNAKER" <?php echo e($valSertifikasi == 'KEMNAKER' ? 'selected' : ''); ?>>KEMNAKER</option>
                                                    <option value="BNSP" <?php echo e($valSertifikasi == 'BNSP' ? 'selected' : ''); ?>>BNSP</option>
                                                    <option value="UPSKILLS" <?php echo e($valSertifikasi == 'UPSKILLS' ? 'selected' : ''); ?>>UPSKILLS</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="kategori_modul_sync" class="form-control form-control-sm" placeholder="Kategori (Mis. K3)" value="<?php echo e($valKategori); ?>">
                                            </div>
                                            <div class="col-12">
                                                <small class="text-muted d-block mt-1">Isi form di atas agar Modul Pelatihan tersimpan ke perpustakaan Modul.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Rundown Pelatihan" <?php echo e(in_array('Rundown Pelatihan', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Rundown Pelatihan</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="file" name="rundown_pelatihan" class="form-control form-control-sm shadow-none" accept=".pdf,.doc,.docx">
                                        <?php if($pelatihan->rundown_pelatihan): ?>
                                        <div class="mt-2">
                                            <a href="<?php echo e(asset($pelatihan->rundown_pelatihan)); ?>" target="_blank" class="badge badge-soft-info text-decoration-none px-3 py-2 border border-info rounded-pill" style="font-size: 10px;">
                                                <i class="fas fa-file-alt me-1"></i> <?php echo e(basename($pelatihan->rundown_pelatihan)); ?>

                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-comments text-success me-2"></i> 3. Komunikasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Peserta" <?php echo e(in_array('Hubungi Peserta', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Hubungi Peserta</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Instruktur" <?php echo e(in_array('Hubungi Instruktur', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Hubungi Instruktur</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Asesor" <?php echo e(in_array('Hubungi Asesor', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Hubungi Asesor</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Buat Grup WA" <?php echo e(in_array('Buat Grup WA', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Buat Grup WA</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Materi" <?php echo e(in_array('Share Link Zoom Materi', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Materi</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Asesment" <?php echo e(in_array('Share Link Zoom Asesment', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Asesment</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Form Evaluasi" <?php echo e(in_array('Share Form Evaluasi', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Share Form Evaluasi</label></div>
                                            <div class="form-check custom-checkbox mb-0"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Sertifikat" <?php echo e(in_array('Share Sertifikat', $checklist) ? 'checked' : ''); ?>><label class="form-check-label text-dark small fw-medium">Share Sertifikat</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-camera text-danger me-2"></i> 4. Dokumentasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Kompeten" <?php echo e(in_array('Foto Kompeten', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Foto Kompeten</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto K3" <?php echo e(in_array('Foto K3', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Foto K3</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Formal" <?php echo e(in_array('Foto Formal', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Foto Formal</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Materi" <?php echo e(in_array('Foto Materi', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Foto Materi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Record Zoom" <?php echo e(in_array('Record Zoom', $checklist) ? 'checked' : ''); ?>>
                                        <label class="form-check-label text-dark small fw-medium">Record Zoom / Daftar Hadir</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top px-4 px-md-5 py-3 bg-white" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-light border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-premium fw-bold px-4 btn-round shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Simpan Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalUploadLaporan-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div><h5 class="modal-title fw-bolder text-white mb-0">Upload Laporan</h5></div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Laporan Internal <span class="text-danger">*</span></label>
                    <input type="file" name="file_laporan_internal" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Laporan Instansi Kemnaker/BNSP</label>
                    <input type="file" name="file_laporan_kemnaker" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-premium fw-bold btn-round w-100 shadow-sm">Upload File</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateEvaluasi-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-comment-dots text-warning me-2"></i> Catatan Evaluasi</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Evaluasi Pelaksanaan</label>
                <textarea name="evaluasi" class="form-control input-modern shadow-none" rows="4" placeholder="Masukkan catatan evaluasi pelaksanaan kelas ini..."><?php echo e($pelatihan->evaluasi); ?></textarea>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-warning text-dark fw-bold btn-round w-100 shadow-sm">Simpan Evaluasi</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateKomentar-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-comments text-warning me-2"></i> Komentar / Feedback</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <?php 
                    $userRole = auth()->user()->role; 
                    
                    $parseKomentarText = function($raw) {
                        if (!$raw) return '';
                        $decoded = json_decode($raw, true);
                        return (is_array($decoded) && isset($decoded['text'])) ? $decoded['text'] : $raw;
                    };
                ?>
                
                <?php if($userRole == 'superadmin'): ?>
                <div class="mb-3">
                    <label class="label-modern text-primary"><i class="fas fa-user-shield me-1"></i> Komentar Superadmin</label>
                    <textarea name="komentar_superadmin" class="form-control input-modern shadow-none border-primary-subtle" rows="3" placeholder="Tambahkan komentar superadmin..."><?php echo e($parseKomentarText($pelatihan->komentar_superadmin)); ?></textarea>
                </div>
                <?php elseif($userRole == 'spv_marketing'): ?>
                <div class="mb-3">
                    <label class="label-modern text-warning-dark"><i class="fas fa-bullhorn me-1"></i> Komentar SPV Marketing</label>
                    <textarea name="komentar_spv_marketing" class="form-control input-modern shadow-none border-warning-subtle" rows="3" placeholder="Tambahkan komentar SPV Marketing..."><?php echo e($parseKomentarText($pelatihan->komentar_spv_marketing)); ?></textarea>
                </div>
                <?php elseif($userRole == 'team_leader'): ?>
                <div class="mb-0">
                    <label class="label-modern text-info"><i class="fas fa-users me-1"></i> Komentar Team Leader</label>
                    <textarea name="komentar_team_leader" class="form-control input-modern shadow-none border-info-subtle" rows="3" placeholder="Tambahkan komentar Team Leader..."><?php echo e($parseKomentarText($pelatihan->komentar_team_leader)); ?></textarea>
                </div>
                <?php else: ?>
                <div class="alert alert-warning mb-0 text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i> Hanya pimpinan yang dapat mengubah komentar.
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <?php if(in_array($userRole, ['superadmin', 'spv_marketing', 'team_leader'])): ?>
                    <button type="submit" class="btn btn-premium fw-bold btn-round w-100 shadow-sm hover-lift">Simpan Komentar</button>
                <?php else: ?>
                    <button type="button" class="btn btn-secondary fw-bold btn-round w-100 shadow-sm" data-bs-dismiss="modal">Tutup</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateStatusSertif-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-award text-warning me-2"></i> Update Status Sertifikat</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Status Saat Ini</label>
                    <select name="status_sertifikat" class="form-select input-modern shadow-none">
                        <option value="OGP" <?php echo e($pelatihan->status_sertifikat == 'OGP' ? 'selected' : ''); ?>>⚙️ On Going Process (OGP)</option>
                        <option value="Delay" <?php echo e($pelatihan->status_sertifikat == 'Delay' ? 'selected' : ''); ?>>⚠️ Delay / Terhambat</option>
                        <option value="Terbit" <?php echo e($pelatihan->status_sertifikat == 'Terbit' ? 'selected' : ''); ?>>✅ Terbit / Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Estimasi Terbit</label>
                    <input type="date" name="estimasi_terbit" value="<?php echo e($pelatihan->estimasi_terbit); ?>" class="form-control input-modern shadow-none">
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern text-success">Tanggal Terima Real</label>
                        <input type="date" name="tgl_terima_lembaga" value="<?php echo e($pelatihan->tgl_terima_lembaga); ?>" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-6">
                        <label class="label-modern text-primary">Tanggal Kirim Klien</label>
                        <input type="date" name="tgl_kirim_klien" value="<?php echo e($pelatihan->tgl_kirim_klien); ?>" class="form-control input-modern shadow-none">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Status</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUploadScanSertif-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-file-pdf text-warning me-2"></i> Upload Scan Sertifikat</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih File (PDF/Zip)</label>
                <input type="file" name="file_scan_sertifikat" class="form-control input-modern shadow-none" accept=".pdf,.zip,.rar" required>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-premium fw-bold btn-round w-100 shadow-sm">Upload Scan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUpdateResi-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-truck-loading text-warning me-2"></i> Input Resi & Pengiriman</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Kurir / Ekspedisi</label>
                    <select name="ekspedisi" class="form-select input-modern shadow-none">
                        <option value="JNE" <?php echo e($pelatihan->ekspedisi == 'JNE' ? 'selected' : ''); ?>>JNE</option>
                        <option value="J&T" <?php echo e($pelatihan->ekspedisi == 'J&T' ? 'selected' : ''); ?>>J&T</option>
                        <option value="SiCepat" <?php echo e($pelatihan->ekspedisi == 'SiCepat' ? 'selected' : ''); ?>>SiCepat</option>
                        <option value="Pos Indonesia" <?php echo e($pelatihan->ekspedisi == 'Pos Indonesia' ? 'selected' : ''); ?>>Pos Indonesia</option>
                        <option value="Kurir Internal" <?php echo e($pelatihan->ekspedisi == 'Kurir Internal' ? 'selected' : ''); ?>>Kurir Internal ARSA</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor Resi / Pelacakan</label>
                    <input type="text" name="resi_pengiriman" value="<?php echo e($pelatihan->resi_pengiriman); ?>" class="form-control input-modern shadow-none fw-bold">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Upload Foto Resi Fisik (Opsional)</label>
                    <input type="file" name="foto_resi" class="form-control input-modern shadow-none" accept="image/*">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-premium text-white fw-bold btn-round w-100 shadow-sm">Simpan Resi</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalUploadTandaTerima-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('monitoring.pelatihan.update', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data" class="modal-content modal-content-modern">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder text-warning"><i class="fas fa-file-signature text-warning me-2"></i> Upload Tanda Terima</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-0">
                    <label class="label-modern">Upload Foto / Scan TTD</label>
                    <input type="file" name="foto_tanda_terima" class="form-control input-modern shadow-none" accept="image/*,.pdf" required>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Tanda Terima</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modalHapusPelatihan-<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern" >
                <h5 class="modal-title fw-bolder"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white btn-close btn-close-white-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger">
                    <i class="fas fa-trash-alt fa-3x"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Hapus Pelatihan Berjalan ini?</h6>
                <?php $isSyncRiwayat = $pelatihan->pendaftaranPribadis->isEmpty() && $pelatihan->riwayat; ?>
                <p class="text-muted small mb-0">Apakah Anda yakin ingin menghapus data pelatihan <strong><?php echo e($isSyncRiwayat ? ($pelatihan->riwayat->judul_pelatihan ?? (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')) : (optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan')); ?></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-end" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                <form action="<?php echo e(route('operational.pelatihan-berjalan.destroy', $pelatihan->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-round fw-bold px-4">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<style>
    /* Base UI / Premium Modern CSS */
    .page-wrapper-modern { background-color: #f8f9fc; min-height: 100vh; font-family: 'Nunito', 'Segoe UI', sans-serif; }
    .glass-card { background: #ffffff; border: 1px solid rgba(227, 230, 240, 0.8); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); border-radius: 20px; transition: all 0.3s ease; }
    .glass-card:hover { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06); }
    .stat-icon-wrapper { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }

    /* Tables */
    .table-custom { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px;}
    .table-custom tr { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 16px; transition: all 0.2s ease; border: 1px solid #f1f3f9;}
    .table-custom tr:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
    .table-custom td { padding: 18px 22px; border: none; vertical-align: middle;}
    .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-custom th { border: none; padding: 10px 22px; color: #858796; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; background: transparent;}

    /* Badges */
    .badge-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #258391; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }

    /* Buttons */
    .btn-premium { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); transition: all 0.3s; }
    .btn-premium:hover { box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4); color: white;}
    .btn-outline-premium { border: 2px solid #4e73df; color: #4e73df; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: all 0.3s; background: white;}
    .btn-outline-premium:hover { background: #4e73df; color: white; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); }

    /* MODAL STYLES */
    .modal-content-modern { border-radius: 24px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);}
    .modal-header-modern { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;}

    /* Tabs */
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Custom Elements */
    .alert-modern-danger { background-color: #fef2f2; border-radius: 8px; border-left: 3px solid #ef4444 !important; }
    .bg-gray-50 { background-color: #f8fafc; }

    /* Animation */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* CSS BARU UNTUK TOMBOL EDIT DI POJOK ATAS CELL */
    .cell-relative {
        position: relative; /* Menjadikan cell sebagai patokan posisi */
    }

    .btn-edit-absolute {
        position: absolute; /* Posisi melayang terhadap cell-relative */
        top: 8px;           /* Jarak dari atas cell */
        right: 8px;         /* Jarak dari kanan cell */
        z-index: 5;         /* Memastikan tombol di atas konten */
        
        /* Desain tombol agar lebih bersih & samar */
        padding: 4px 8px !important;
        border-radius: 6px !important;
        background: rgba(255, 255, 255, 0.7) !important; /* Semi transparan */
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 10px !important;
        opacity: 0.5; /* Samar saat diam */
        transition: all 0.2s ease;
    }

    /* Efek hover agar tombol terlihat jelas saat cell disorot */
    tr:hover .btn-edit-absolute,
    .btn-edit-absolute:hover {
        opacity: 1; /* Terlihat penuh */
        background: #fff !important; /* Latar putih pekat */
        border-color: #cbd5e1 !important;
        color: #3b82f6 !important; /* Warna primary */
    }

    /* Menambahkan padding kanan pada konten agar tidak tertabrak tombol */
    .cell-content-wrapper {
        padding-right: 25px; /* Beri ruang untuk tombol absolute */
    }
</style>

<script>
    // Fungsi untuk mengganti input Link Drive vs Upload File
    function toggleMethod(selectElement, idPrefix) {
        const linkInput = document.getElementById(idPrefix + '_link');
        const fileInput = document.getElementById(idPrefix + '_file');
        
        if (selectElement.value === 'link') {
            linkInput.classList.remove('d-none');
            fileInput.classList.add('d-none');
        } else {
            linkInput.classList.add('d-none');
            fileInput.classList.remove('d-none');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/operational/monitoring-pelatihan.blade.php ENDPATH**/ ?>
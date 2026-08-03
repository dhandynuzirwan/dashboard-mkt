<?php $__env->startSection('content'); ?>
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
    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }
    
    .table-custom { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px;}
    .table-custom tr { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 16px; transition: all 0.2s ease; border: 1px solid #f1f3f9;}
    .table-custom tr:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
    .table-custom td { padding: 18px 22px; border: none; vertical-align: middle;}
    .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-custom th { border: none; padding: 10px 22px; color: #858796; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; background: transparent;}

    .badge-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #258391; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    
    .btn-premium { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); transition: all 0.3s; }
    .btn-premium:hover { box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4); color: white;}
    
    .btn-outline-premium { border: 2px solid #4e73df; color: #4e73df; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: all 0.3s; background: white;}
    .btn-outline-premium:hover { background: #4e73df; color: white; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); }

    .form-control-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-control-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    /* MODAL STYLES */
    .modal-content-modern { border-radius: 24px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);}
    .modal-header-modern { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;}
    .file-item-card { background: white; border: 1px solid #edf2f9; border-radius: 16px; transition: all 0.3s; padding: 20px;}
    .file-item-card:hover { border-color: #bac8f3; box-shadow: 0 5px 15px rgba(78, 115, 223, 0.08); }
    .file-icon-box { width: 50px; height: 50px; border-radius: 14px; background: rgba(78, 115, 223, 0.1); color: #4e73df; display: flex; align-items: center; justify-content: center; font-size: 24px;}
</style>

<div class="container">
    <div class="page-inner">
        
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">Permintaan Training</h2>
                <p class="text-muted mb-0" style="font-size: 15px;">Manajemen kebutuhan desain khusus untuk materi dan operasional pelatihan.</p>
            </div>
        </div>

        
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-primary me-3 shadow-sm">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Total Training</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;"><?php echo e($statTotal); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-warning me-3 shadow-sm">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Menunggu</p>
                        <div class="d-flex align-items-end gap-2">
                            <h3 class="fw-black text-dark mb-0" style="font-size: 28px;"><?php echo e($statTotal - $statProses - $statSelesai); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-info me-3 shadow-sm">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Dalam Proses</p>
                        <div class="d-flex align-items-end gap-2">
                            <h3 class="fw-black text-dark mb-0" style="font-size: 28px;"><?php echo e($statProses); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-success me-3 shadow-sm">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Lengkap</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;"><?php echo e($statSelesai); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="glass-card p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-chalkboard text-primary me-2"></i> Data Pelatihan Bulan Ini</h5>
                
                
                <form action="#" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <input type="text" name="search" class="form-control-modern" placeholder="Cari pelatihan..." style="width: 250px;">
                    <input type="date" name="tanggal" class="form-control-modern" style="width: 150px;">
                    <button type="submit" class="btn btn-premium px-4"><i class="fas fa-filter me-1"></i> Filter</button>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom w-100">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="40%">Informasi Pelatihan</th>
                            <th width="35%">Status Kelengkapan Berkas</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $permintaan = $pelatihan->permintaanTraining;
                            $status = $permintaan ? $permintaan->status : 'Menunggu';
                            
                            $berkasList = [
                                'background_zoom_file' => 'Background Zoom',
                                'banner_kegiatan_file' => 'Banner Kegiatan',
                                'photo_profil_grup_wa_file' => 'Photo Profil Grup WA',
                                'table_name_file' => 'Table Name',
                                'lanyard_file' => 'Lanyard',
                                'sertifikat_internal_file' => 'Sertifikat Internal',
                                'rekap_foto_file' => 'Rekap Foto',
                                'rekap_video_file' => 'Rekap Video',
                                'lainnya_file' => 'Lainnya'
                            ];

                            $uploadedCount = 0;
                            $uploadedNames = [];
                            if($permintaan) {
                                foreach($berkasList as $col => $name) {
                                    if(!empty($permintaan->$col)) {
                                        $uploadedCount++;
                                        $uploadedNames[] = $name;
                                    }
                                }
                            }
                        ?>
                        <tr>
                            <td class="text-center text-muted fw-bold fs-5"><?php echo e($index + 1); ?></td>
                            <td>
                                <div class="fw-bold text-dark mb-2" style="font-size: 16px;"><?php echo e($pelatihan->training->nama_pelatihan ?? 'Pelatihan Custom'); ?></div>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="text-muted small fw-bold"><i class="fas fa-calendar-alt text-primary me-1"></i> <?php echo e(\Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d M Y')); ?></div>
                                    <div class="text-muted small fw-bold"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo e($pelatihan->lokasi ?? 'N/A'); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3 d-flex align-items-center gap-3">
                                    <?php if($status == 'Selesai'): ?>
                                        <span class="badge-soft-success">Selesai</span>
                                    <?php elseif($status == 'Dalam Proses'): ?>
                                        <span class="badge-soft-info">Dalam Proses</span>
                                    <?php else: ?>
                                        <span class="badge-soft-warning">Menunggu</span>
                                    <?php endif; ?>
                                    <span class="<?php echo e($uploadedCount > 0 ? 'text-primary' : 'text-muted'); ?> fw-bolder" style="font-size: 13px;"><?php echo e($uploadedCount); ?>/9 Berkas Terunggah</span>
                                </div>
                                <div class="text-dark small text-start mt-2" style="font-size: 13px;">
                                    <?php echo e($uploadedCount > 0 ? implode(', ', array_slice($uploadedNames, 0, 3)) . ($uploadedCount > 3 ? '...' : '') : 'Belum ada berkas yang diunggah'); ?>

                                </div>
                                <?php if($permintaan): ?>
                                <div class="text-muted mt-2" style="font-size: 11px;">
                                    Terakhir diubah: <i class="far fa-clock"></i> <?php echo e($permintaan->updated_at->format('d M Y, H:i')); ?>

                                </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-premium" data-bs-toggle="modal" data-bs-target="#modalDetailBerkas<?php echo e($pelatihan->id); ?>">
                                    <i class="fas fa-folder-open me-1"></i> Kelola Berkas
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                Belum ada data pelatihan berjalan di bulan ini.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<?php $__currentLoopData = $pelatihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelatihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $permintaan = $pelatihan->permintaanTraining;
    $status = $permintaan ? $permintaan->status : 'Menunggu';
    $berkasList = [
        'background_zoom' => 'Background Zoom',
        'banner_kegiatan' => 'Banner Kegiatan',
        'photo_profil_grup_wa' => 'Photo Profil Grup WA',
        'table_name' => 'Table Name',
        'lanyard' => 'Lanyard',
        'sertifikat_internal' => 'Sertifikat Internal',
        'rekap_foto' => 'Rekap Foto',
        'rekap_video' => 'Rekap Video',
        'lainnya' => 'Lainnya'
    ];
?>
<div class="modal fade" id="modalDetailBerkas<?php echo e($pelatihan->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bolder mb-1"><i class="fas fa-folder-open me-2 text-white-50"></i> Manajemen Berkas Desain Training</h4>
                    <p class="mb-0 text-white-50 fw-bold" style="font-size: 13px;"><?php echo e($pelatihan->training->nama_pelatihan ?? 'Pelatihan Custom'); ?> &bull; <?php echo e(\Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d M Y')); ?> &bull; <?php echo e($pelatihan->lokasi ?? 'N/A'); ?></p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-primary px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                        <?php echo e($status); ?>

                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="modal-body p-4 p-md-5" style="background-color: #f8f9fc;">
                <form action="<?php echo e(route('operational.permintaan-visual.training.upload', $pelatihan->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="d-flex justify-content-end mb-4">
                        <button type="submit" class="btn btn-premium px-4"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                    </div>
                    <div class="row g-4">
                        <?php $__currentLoopData = $berkasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inputName => $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $dbColumn = $inputName . '_file';
                            $hasFile = $permintaan && !empty($permintaan->$dbColumn);
                            $filePath = $hasFile ? $permintaan->$dbColumn : null;
                            $ext = $hasFile ? pathinfo($filePath, PATHINFO_EXTENSION) : null;
                        ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="file-item-card h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="file-icon-box">
                                            <?php if($berkas == 'Rekap Video'): ?> <i class="fas fa-video"></i>
                                            <?php elseif($berkas == 'Background Zoom' || $berkas == 'Rekap Foto' || $berkas == 'Banner Kegiatan' || $berkas == 'Photo Profil Grup WA'): ?> <i class="fas fa-image"></i>
                                            <?php else: ?> <i class="fas fa-file-alt"></i> <?php endif; ?>
                                        </div>
                                        <h6 class="fw-bolder text-dark mb-0"><?php echo e($berkas); ?></h6>
                                    </div>
                                    <?php if($hasFile): ?> 
                                        <span class="badge-soft-success"><i class="fas fa-check"></i> Ada</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border">Kosong</span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-grow-1">
                                    <?php if($hasFile): ?>
                                        <div class="position-relative rounded-3 overflow-hidden mb-3 border shadow-sm">
                                            <?php if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])): ?>
                                                <img src="<?php echo e(Storage::url($filePath)); ?>" alt="Thumbnail" class="w-100 object-fit-cover" style="height: 140px;">
                                            <?php else: ?>
                                                <div class="w-100 d-flex align-items-center justify-content-center bg-light" style="height: 140px;">
                                                    <i class="fas fa-file-alt fs-1 text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if(in_array(strtolower($ext), ['mp4', 'mov', 'avi'])): ?>
                                            <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-play text-white fs-5 ms-1"></i>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <div class="position-absolute bottom-0 w-100 p-2 d-flex justify-content-between align-items-end" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                                <div class="text-white overflow-hidden text-truncate pe-2">
                                                    <div class="fw-bold text-truncate" style="font-size: 12px;"><?php echo e(basename($filePath)); ?></div>
                                                </div>
                                                <a href="<?php echo e(Storage::url($filePath)); ?>" target="_blank" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Unduh">
                                                    <i class="fas fa-download" style="font-size: 12px;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if(in_array(auth()->user()->role ?? 'graphic', ['graphic', 'superadmin', 'web_dev'])): ?>
                                <div class="mt-auto border-top pt-3">
                                    <div class="input-group input-group-sm mb-2 rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                        <input type="file" class="form-control form-control-sm border-0 py-2 px-3 bg-white" name="<?php echo e($inputName); ?>">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-white border-top-0 py-4 px-5">
                <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/operational/permintaan-visual/training/index.blade.php ENDPATH**/ ?>
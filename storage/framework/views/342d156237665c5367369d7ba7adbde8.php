<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Pengajuan Izin & Cuti</h4>
                <p class="text-muted small">Kelola dan pantau status permohonan ketidakhadiran Anda.</p>
            </div>
            <div>
                <a href="<?php echo e(route('pengajuan-izin.create')); ?>" class="btn btn-primary fw-bold btn-round shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Buat Pengajuan Baru
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-3 fs-6 fw-bold" id="pengajuanTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-primary" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                            Sedang Diproses
                            <?php if($pendingIzins->count() > 0): ?>
                                <span class="badge bg-warning text-dark ms-2 rounded-circle"><?php echo e($pendingIzins->count()); ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-muted" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">
                            Riwayat Selesai
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="pengajuanTabsContent">
                    
                    <!-- TAB PENDING -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">ID Pengajuan</th>
                                        <th>Tanggal Izin</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Lampiran</th>
                                        <th class="text-center">Status</th>
                                        <th>Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pendingIzins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $izin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="px-4"><span class="badge bg-light text-dark border"><?php echo e($izin->external_id); ?></span></td>
                                            <td class="fw-bold text-primary"><?php echo e(\Carbon\Carbon::parse($izin->tanggal)->format('d M Y')); ?></td>
                                            <td><?php echo e($izin->jenis); ?></td>
                                            <td><?php echo e($izin->keterangan ?? '-'); ?></td>
                                            <td>
                                                <?php if($izin->file_path): ?>
                                                    <a href="<?php echo e(asset('storage/' . $izin->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-file-download"></i> Lihat Bukti
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-clock"></i> Menunggu</span>
                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fs-1 text-light mb-3 d-block"></i>
                                                Anda tidak memiliki pengajuan izin yang sedang diproses.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB RIWAYAT -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">ID Pengajuan</th>
                                        <th>Tanggal Izin</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Lampiran</th>
                                        <th class="text-center">Status</th>
                                        <th>Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $riwayatIzins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $izin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="px-4"><span class="badge bg-light text-dark border"><?php echo e($izin->external_id); ?></span></td>
                                            <td class="fw-bold text-primary"><?php echo e(\Carbon\Carbon::parse($izin->tanggal)->format('d M Y')); ?></td>
                                            <td><?php echo e($izin->jenis); ?></td>
                                            <td><?php echo e($izin->keterangan ?? '-'); ?></td>
                                            <td>
                                                <?php if($izin->file_path): ?>
                                                    <a href="<?php echo e(asset('storage/' . $izin->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-file-download"></i> Lihat Bukti
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($izin->status == 'approved'): ?>
                                                    <span class="badge bg-success px-3 py-2"><i class="fas fa-check"></i> Disetujui</span>
                                                <?php elseif($izin->status == 'rejected'): ?>
                                                    <span class="badge bg-danger px-3 py-2"><i class="fas fa-times"></i> Ditolak</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(\Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fs-1 text-light mb-3 d-block"></i>
                                                Belum ada riwayat pengajuan izin yang disetujui / ditolak.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($riwayatIzins->hasPages()): ?>
                            <div class="card-footer bg-white border-0 py-3">
                                <?php echo e($riwayatIzins->links('pagination::bootstrap-5')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/pengajuan-izin/index.blade.php ENDPATH**/ ?>
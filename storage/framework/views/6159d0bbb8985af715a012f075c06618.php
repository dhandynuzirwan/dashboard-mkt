<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Approval Lembur</h4>
                <p class="text-muted small">Daftar pengajuan lembur yang membutuhkan persetujuan Anda.</p>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama (User)</th>
                                <th>Jabatan & Divisi</th>
                                <th>Waktu Lembur</th>
                                <th>Tugas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pengajuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lembur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold text-dark"><?php echo e($lembur->nama); ?></div>
                                        <div class="small text-muted">Akun: <?php echo e($lembur->user->name ?? '-'); ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo e($lembur->jabatan); ?></div>
                                        <div class="small text-muted"><?php echo e($lembur->divisi); ?></div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary"><?php echo e(\Carbon\Carbon::parse($lembur->tanggal_mulai)->format('d M Y')); ?></span>
                                        <?php if($lembur->tanggal_selesai && $lembur->tanggal_selesai != $lembur->tanggal_mulai): ?>
                                            <small class="text-muted"> s/d <?php echo e(\Carbon\Carbon::parse($lembur->tanggal_selesai)->format('d M Y')); ?></small>
                                        <?php endif; ?>
                                        <br>
                                        <span class="badge bg-light text-dark border mt-1">
                                            <i class="fas fa-clock"></i> <?php echo e(\Carbon\Carbon::parse($lembur->jam_mulai)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($lembur->jam_selesai)->format('H:i')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDetail<?php echo e($lembur->id); ?>">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </button>
                                        
                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="modalDetail<?php echo e($lembur->id); ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Detail Pengajuan Lembur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-3">
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-muted small mb-1">Tugas yang Dikerjakan</h6>
                                                            <p class="mb-0 bg-light p-3 rounded text-dark"><?php echo e($lembur->tugas); ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-muted small mb-1">Dukungan Fasilitas</h6>
                                                            <p class="mb-0"><?php echo e($lembur->dukungan_fasilitas ?: '-'); ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold text-muted small mb-1">Catatan Lainnya</h6>
                                                            <p class="mb-0"><?php echo e($lembur->catatan ?: '-'); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?php echo e(route('approval-lembur.approve', $lembur->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm shadow-sm" onclick="return confirm('Setujui pengajuan lembur ini?')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('approval-lembur.reject', $lembur->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Tolak pengajuan lembur ini?')">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-circle fs-1 text-light mb-3 d-block"></i>
                                        Tidak ada pengajuan lembur yang perlu disetujui saat ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/pengajuan-lembur/approval.blade.php ENDPATH**/ ?>
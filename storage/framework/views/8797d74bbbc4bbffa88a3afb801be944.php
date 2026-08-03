<?php $__env->startSection('content'); ?>
<style>
    /* Modern UI Styles for Download Approval */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .table-modern {
        border-collapse: separate;
        border-spacing: 0 12px;
        margin-top: -12px;
    }
    .table-modern tr {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border-radius: 16px;
        transition: all 0.2s ease;
        border: 1px solid #f1f3f9;
    }
    .table-modern tr:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .table-modern td {
        padding: 18px 22px;
        border: none;
        vertical-align: middle;
    }
    .table-modern td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-modern td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-modern th {
        border: none;
        padding: 10px 22px;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        background: transparent;
    }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-success { background-color: rgba(28, 200, 138, 0.15); color: #1cc88a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.15); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .btn-action {
        width: 35px; height: 35px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; transition: all 0.2s;
    }
    .btn-action:hover { transform: scale(1.05); }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bolder text-dark mb-1">Riwayat & Approval Download</h3>
            <p class="text-muted mb-0">Kelola riwayat permintaan unduh data Anda.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="glass-card p-4">
        <div class="table-responsive" style="min-height: 400px; overflow-y: visible;">
            <table class="table table-modern w-100">
                <thead>
                    <tr>
                        <th width="15%">Waktu Request</th>
                        <th width="15%">Nama Pegawai</th>
                        <th width="35%">Alasan Request</th>
                        <th width="15%">Status</th>
                        <th class="text-center" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($req->created_at->format('d M Y')); ?></div>
                                <div class="text-muted small"><?php echo e($req->created_at->format('H:i')); ?> WIB</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 14px;"><?php echo e($req->user->name); ?></div>
                                <div class="text-primary small fw-bold"><?php echo e(ucfirst($req->user->role)); ?></div>
                            </td>
                            <td>
                                <div class="text-dark small" style="line-height: 1.5; font-size: 13px;">
                                    <?php echo e($req->reason); ?>

                                </div>
                            </td>
                            <td>
                                <?php
                                    $statusBadge = 'badge-soft-warning';
                                    $statusIcon = 'fa-clock';
                                    $statusLabel = 'Pending';
                                    if($req->status == 'approved') { $statusBadge = 'badge-soft-success'; $statusIcon = 'fa-check-circle'; $statusLabel = 'Disetujui'; }
                                    elseif($req->status == 'rejected') { $statusBadge = 'badge-soft-danger'; $statusIcon = 'fa-times-circle'; $statusLabel = 'Ditolak'; }
                                ?>
                                <span class="<?php echo e($statusBadge); ?> d-inline-flex align-items-center"><i class="fas <?php echo e($statusIcon); ?> me-1"></i> <?php echo e($statusLabel); ?></span>
                            </td>
        
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    
                                    <?php if($req->status == 'pending' && in_array(auth()->user()->role, ['superadmin'])): ?>
                                        <form action="<?php echo e(route('download.approve', $req->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?> 
                                            <button type="submit" class="btn btn-action btn-light text-success shadow-sm" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('download.reject', $req->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?> 
                                            <button type="submit" class="btn btn-action btn-light text-danger shadow-sm" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
            
                                    
                                    <?php if($req->status == 'approved'): ?>
                                        <a href="<?php echo e(route('download.file', $req->id)); ?>" class="btn btn-action btn-primary shadow-sm" title="Download File">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if($req->status == 'pending' && !in_array(auth()->user()->role, ['superadmin'])): ?>
                                        <span class="text-muted small fst-italic me-2 align-self-center"><i class="fas fa-hourglass-half me-1"></i> Menunggu...</span>
                                    <?php endif; ?>

                                    
                                    <?php if(auth()->user()->role === 'superadmin' || $req->user_id === auth()->id()): ?>
                                        <form action="<?php echo e(route('download.destroy', $req->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat request ini?');">
                                            <?php echo csrf_field(); ?> 
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-action btn-light text-danger shadow-sm" title="Hapus Data">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5">
                                <div class="text-center py-5">
                                    <img src="<?php echo e(asset('img/undraw_no_data.svg')); ?>" alt="No Data" class="img-fluid mb-3" style="max-height: 120px; opacity: 0.5;">
                                    <h6 class="text-muted fw-bold">Belum ada riwayat request download.</h6>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        
        <div class="mt-4 d-flex justify-content-end">
            <?php echo e($requests->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/download-approval.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat & Approval Download</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal Request</th>
                            <th>Nama Pegawai</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($req->created_at->format('d M Y, H:i')); ?></td>
                                <td><?php echo e($req->user->name); ?></td>
                                <td><?php echo e($req->reason); ?></td>
                                <td>
                                    
                                    <?php if($req->status == 'pending'): ?> <span class="badge bg-warning text-dark">Pending</span> <?php endif; ?>
                                    <?php if($req->status == 'approved'): ?> <span class="badge bg-success">Approved</span> <?php endif; ?>
                                    <?php if($req->status == 'rejected'): ?> <span class="badge bg-danger">Rejected</span> <?php endif; ?>
                                </td>
            
                                
                                <td class="text-center">
                                    <?php if($req->status == 'pending' && in_array(auth()->user()->role, ['superadmin'])): ?>
                                        <form action="<?php echo e(route('download.approve', $req->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <button class="btn btn-success btn-sm btn-round shadow-sm"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="<?php echo e(route('download.reject', $req->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <button class="btn btn-danger btn-sm btn-round shadow-sm"><i class="fas fa-times"></i></button>
                                        </form>
                                    <?php endif; ?>
            
                                    <?php if($req->status == 'approved'): ?>
                                        <a href="<?php echo e(route('download.file', $req->id)); ?>" class="btn btn-primary btn-sm btn-round shadow-sm fw-bold">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if($req->status == 'pending' && !in_array(auth()->user()->role, ['superadmin'])): ?>
                                        <span class="text-muted small fst-italic"><i class="fas fa-hourglass-half me-1"></i> Menunggu...</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada data request download.</td>
                            </tr>
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
            
            
            <div class="mt-3">
                <?php echo e($requests->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/download-approval.blade.php ENDPATH**/ ?>
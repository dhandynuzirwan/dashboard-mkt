 

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">
        
        
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Penggajian & Aturan Potongan</h3>
                <h6 class="op-7 mb-2">Manajemen Data Gaji Karyawan & Master Potongan Izin</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info px-3 py-2 mt-1" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                <div class="card-title fw-bold m-0">
                    <!--<i class="fas fa-wallet text-success me-2"></i>-->
                     Data Gaji & Tunjangan Karyawan</div>
                <div class="ms-auto d-flex">
                    <button type="button" class="btn btn-primary btn-sm btn-round shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#massUpdateModal">
                        <i class="fa fa-sync me-1"></i> Update Massal Marketing
                    </button>
                    <a href="<?php echo e(route('form-penggajian')); ?>" class="btn btn-success btn-sm btn-round shadow-sm">
                        <i class="fa fa-plus me-1"></i> Tambah Data Individu
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4">KARYAWAN (MARKETING)</th>
                                <th>TARGET KINERJA</th>
                                <th>KOMPONEN PENDAPATAN</th>
                                <th>KOMPONEN BPJS</th>
                                <th class="text-center pe-4" width="160">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $penggajians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-bottom">
                                    
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold"><?php echo e(substr($item->user->name, 0, 1)); ?></span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark" style="font-size: 15px;"><?php echo e($item->user->name); ?></span>
                                            </div>
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Target Call:</span>
                                            <span class="fw-bold text-dark"><?php echo e($item->target_call); ?> Call/Hari</span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Target (Rp):</span>
                                            <span class="fw-bold text-primary">Rp <?php echo e(number_format($item->target, 0, ',', '.')); ?>/Bulan</span>
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Gaji Pokok:</span>
                                            <span class="fw-bold text-dark">Rp <?php echo e(number_format($item->gaji_pokok, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Tunjangan:</span>
                                            <span class="fw-bold text-success">Rp <?php echo e(number_format($item->tunjangan, 0, ',', '.')); ?></span>
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Tunjangan BPJS:</span>
                                            <span class="fw-bold text-success">+ Rp <?php echo e(number_format($item->tunjangan_bpjs, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Iuran (Potongan):</span>
                                            <span class="fw-bold text-danger">- Rp <?php echo e(number_format($item->iuran_bpjs, 0, ',', '.')); ?></span>
                                        </div>
                                    </td>

                                    
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?php echo e(route('penggajian.edit', $item->id)); ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="<?php echo e(route('penggajian.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data gaji ini?')">
                                                    <i class="fa fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($penggajians->isEmpty()): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data gaji karyawan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                <div class="card-title fw-bold m-0">
                    <!--<i class="fas fa-clipboard-list text-secondary me-2"></i>-->
                     Aturan Potongan Gaji per Jenis Izin</div>
                <button class="btn btn-secondary btn-sm btn-round ms-auto shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                    <i class="fa fa-plus me-1"></i> Tambah Aturan
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4" width="60">NO</th>
                                <th>JENIS IZIN (Sesuai Fingerspot)</th>
                                <th>NOMINAL POTONGAN</th>
                                <th class="text-center pe-4" width="160">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jenis_izins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $izin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-bottom">
                                    <td class="ps-4 fw-bold text-muted"><?php echo e($idx + 1); ?></td>
                                    <td>
                                        <span class="fw-bold text-dark fs-6"><?php echo e($izin->nama_izin); ?></span>
                                    </td>
                                    <td>
                                        <div style="background-color: #f8d7da; color: #721c24; font-weight: bold; display: inline-block; padding: 2px 10px; border-radius: 4px; border: 1px solid #f5c6cb;">
                                            - Rp <?php echo e(number_format($izin->potongan, 0, ',', '.')); ?>

                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditIzin<?php echo e($izin->id); ?>">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </button>
                                            
                                            <form action="<?php echo e(route('jenis-izin.destroy', $izin->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus aturan potongan ini?')">
                                                    <i class="fa fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                
                                <div class="modal fade" id="modalEditIzin<?php echo e($izin->id); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="<?php echo e(route('jenis-izin.update', $izin->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-content card-round border-0 shadow-lg">
                                                <div class="modal-header bg-light border-0 py-3 px-4">
                                                    <h5 class="modal-title fw-bold m-0"><i class="fas fa-edit text-warning me-2"></i> Edit Aturan Potongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="form-group p-0 mb-3">
                                                        <label class="fw-bold mb-1">Nama Jenis Izin</label>
                                                        <input type="text" name="nama_izin" class="form-control border-gray-200" value="<?php echo e($izin->nama_izin); ?>" required>
                                                    </div>
                                                    <div class="form-group p-0">
                                                        <label class="fw-bold mb-1">Besar Potongan (Rp)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">Rp</span>
                                                            <input type="number" name="potongan" class="form-control border-gray-200 text-danger fw-bold" value="<?php echo e((int)$izin->potongan); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light py-3 px-4">
                                                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning px-4 shadow-sm">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($jenis_izins->isEmpty()): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada master aturan potongan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modalTambahIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?php echo e(route('jenis-izin.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content card-round border-0 shadow-lg">
                <div class="modal-header bg-light border-0 py-3 px-4">
                    <h5 class="modal-title fw-bold m-0"><i class="fas fa-plus-circle text-secondary me-2"></i> Tambah Aturan Izin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm small p-3 mb-4">
                        <i class="fas fa-info-circle me-1"></i> Pastikan nama izin <b>sama persis</b> dengan penamaan di CSV hasil export mesin Fingerspot.
                    </div>
                    <div class="form-group p-0 mb-3">
                        <label class="fw-bold mb-1">Nama Jenis Izin</label>
                        <input type="text" name="nama_izin" class="form-control border-gray-200" placeholder="Contoh: Sakit Tanpa Surat Dokter" required>
                    </div>
                    <div class="form-group p-0">
                        <label class="fw-bold mb-1">Besar Potongan (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" name="potongan" class="form-control border-gray-200 text-danger fw-bold" placeholder="100000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary px-4 shadow-sm">Simpan Aturan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<!-- Modal Update Massal -->
<div class="modal fade" id="massUpdateModal" tabindex="-1" aria-labelledby="massUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="massUpdateModalLabel"><i class="fas fa-sync text-primary me-2"></i>Update Massal Data Marketing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('penggajian.mass_update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-warning shadow-sm" role="alert" style="font-size: 13px;">
                        <i class="fas fa-exclamation-triangle me-2"></i> Aksi ini akan mengubah target dan pendapatan untuk <strong>SEMUA</strong> karyawan dengan role Marketing.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Call (per hari)</label>
                            <input type="number" class="form-control" name="target_call" required value="<?php echo e($default_penggajian->target_call ?? 40); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Revenue (Rp)</label>
                            <input type="number" class="form-control" name="target" required value="<?php echo e($default_penggajian->target ?? 100000000); ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Gaji Pokok (Rp)</label>
                            <input type="number" class="form-control" name="gaji_pokok" required value="<?php echo e($default_penggajian->gaji_pokok ?? 1500000); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tunjangan Lain (Rp)</label>
                            <input type="number" class="form-control" name="tunjangan" required value="<?php echo e($default_penggajian->tunjangan ?? 0); ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tunjangan BPJS (Rp)</label>
                            <input type="number" class="form-control" name="tunjangan_bpjs" required value="<?php echo e($default_penggajian->tunjangan_bpjs ?? 147614); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Iuran BPJS (Rp)</label>
                            <input type="number" class="form-control" name="iuran_bpjs" required value="<?php echo e($default_penggajian->iuran_bpjs ?? 44284); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-save me-1"></i> Simpan Massal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/penggajian.blade.php ENDPATH**/ ?>
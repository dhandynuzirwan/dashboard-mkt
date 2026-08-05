<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Buat Pengajuan Baru</h4>
                <p class="text-muted small">Isi formulir di bawah ini untuk mengajukan perizinan atau cuti.</p>
            </div>
            <div>
                <a href="<?php echo e(route('pengajuan-izin.index')); ?>" class="btn btn-light fw-bold btn-round shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="<?php echo e(route('pengajuan-izin.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_izin" class="form-label fw-bold">Jenis Perizinan <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis_izin" name="jenis_izin" required>
                                <option value="" disabled selected>Pilih Jenis Izin...</option>
                                <?php $__currentLoopData = $jenisIzins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($j->nama_izin); ?>" <?php echo e(old('jenis_izin') == $j->nama_izin ? 'selected' : ''); ?>>
                                        <?php echo e($j->nama_izin); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(old('start_date')); ?>" required>
                            <small id="cutiHelp" class="form-text text-danger d-none"><i class="fas fa-info-circle"></i> Pengajuan Cuti minimal dilakukan H-20 hari dari hari ini.</small>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="end_date" class="form-label fw-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(old('end_date')); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan / Alasan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan alasan lengkap ketidakhadiran Anda..."><?php echo e(old('keterangan')); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="file_bukti" class="form-label fw-bold">Lampiran Bukti (Opsional)</label>
                        <input class="form-control" type="file" id="file_bukti" name="file_bukti" accept=".jpg,.jpeg,.png,.pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 2MB. (Contoh: Surat keterangan dokter).</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisIzinSelect = document.getElementById('jenis_izin');
    const startDateInput = document.getElementById('start_date');
    const cutiHelp = document.getElementById('cutiHelp');

    // Dapatkan tanggal hari ini + 20 hari
    let today = new Date();
    let minCutiDate = new Date(today);
    minCutiDate.setDate(minCutiDate.getDate() + 20);
    let minCutiStr = minCutiDate.toISOString().split('T')[0];

    function updateMinDate() {
        const selectedVal = jenisIzinSelect.value.toLowerCase();
        if (selectedVal.includes('cuti')) {
            startDateInput.min = minCutiStr;
            cutiHelp.classList.remove('d-none');
            // Jika tanggal yg sudah dipilih kurang dari min date, reset
            if (startDateInput.value && startDateInput.value < minCutiStr) {
                startDateInput.value = '';
            }
        } else {
            startDateInput.min = '';
            cutiHelp.classList.add('d-none');
        }
    }

    jenisIzinSelect.addEventListener('change', updateMinDate);
    // Jalankan sekali saat load (untuk handle validasi failed repopulation)
    updateMinDate();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/pengajuan-izin/create.blade.php ENDPATH**/ ?>
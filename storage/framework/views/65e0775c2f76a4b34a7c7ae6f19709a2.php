

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">

        
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data Pengguna</h3>
                <h6 class="op-7 mb-2">Formulir Tambah Pengguna Baru</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info px-3 py-2 mt-1" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 border-0 shadow-sm">

                    <div class="card-header bg-white border-bottom py-3">
                        <div class="card-title fw-bold m-0">
                            <i class="fas fa-user-plus text-primary me-2"></i> Form Tambah Pengguna
                        </div>
                    </div>

                    <div class="card-body p-4">

                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        
                        <form action="<?php echo e(route('user.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="row">

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="name" class="fw-bold mb-1">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan Username" value="<?php echo e(old('name')); ?>" required>
                                </div>
                                
                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap" class="fw-bold mb-1">Nama Panggilan</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                        value="<?php echo e(old('nama_lengkap')); ?>" 
                                        placeholder="Masukkan Nama Panggilan">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap_ktp" class="fw-bold mb-1">Nama Lengkap (KTP)</label>
                                    <input type="text" class="form-control" id="nama_lengkap_ktp" name="nama_lengkap_ktp" value="<?php echo e(old('nama_lengkap_ktp')); ?>" placeholder="Masukkan Nama Lengkap Sesuai KTP">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="no_hp" class="fw-bold mb-1">No. HP / WhatsApp</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" 
                                        value="<?php echo e(old('no_hp', $user->no_hp ?? '')); ?>" 
                                        placeholder="Contoh: 081234567890">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan Email Aktif" value="<?php echo e(old('email')); ?>" required>
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="password" class="fw-bold mb-1">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Buat Password" required>
                                </div>

                                                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nik" class="fw-bold mb-1">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?php echo e(old('nik')); ?>" placeholder="Masukkan NIK 16 digit">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="fw-bold mb-1">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir')); ?>">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_baru" class="fw-bold mb-1">Tanggal Kontrak Terbaru</label>
                                    <input type="date" class="form-control" id="tanggal_kontrak_baru" name="tanggal_kontrak_baru" value="<?php echo e(old('tanggal_kontrak_baru')); ?>">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_berakhir" class="fw-bold mb-1">Tanggal Kontrak Berakhir</label>
                                    <input type="date" class="form-control" id="tanggal_kontrak_berakhir" name="tanggal_kontrak_berakhir" value="<?php echo e(old('tanggal_kontrak_berakhir')); ?>">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="jobdesk_file" class="fw-bold mb-1">Jobdesk (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control" id="jobdesk_file" name="jobdesk_file">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="sop_file" class="fw-bold mb-1">SOP (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control" id="sop_file" name="sop_file">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="role" class="fw-bold mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select class="form-select form-control" id="role" name="role" required>
                                        <option value="">-- Pilih Hak Akses --</option>
                                        <option value="superadmin" <?php echo e(old('role', $user->role ?? '') == 'superadmin' ? 'selected' : ''); ?>>Super Admin</option>
                                        <option value="admin" <?php echo e(old('role', $user->role ?? '') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        <option value="marketing" <?php echo e(old('role', $user->role ?? '') == 'marketing' ? 'selected' : ''); ?>>Marketing</option>
                                        <option value="rnd" <?php echo e(old('role', $user->role ?? '') == 'rnd' ? 'selected' : ''); ?>>RnD</option>
                                        <option value="digitalmarketing" <?php echo e(old('role', $user->role ?? '') == 'digitalmarketing' ? 'selected' : ''); ?>>Digital Marketing</option>
                                        <option value="spv_marketing" <?php echo e(old('role', $user->role ?? '') == 'spv_marketing' ? 'selected' : ''); ?>>SPV Marketing</option>
                                        <option value="web_dev" <?php echo e(old('role', $user->role ?? '') == 'web_dev' ? 'selected' : ''); ?>>Web Developer</option>
                                        <option value="hrd" <?php echo e(old('role', $user->role ?? '') == 'hrd' ? 'selected' : ''); ?>>HRD</option>
                                        <option value="graphic" <?php echo e(old('role', $user->role ?? '') == 'graphic' ? 'selected' : ''); ?>>Tim Grafis (Graphic)</option>
                                        
                                        
                                        <option value="operasional" <?php echo e(old('role', $user->role ?? '') == 'operasional' ? 'selected' : ''); ?>>Operasional / Backoffice / PIC</option>
                                        <option value="team_leader" <?php echo e(old('role', $user->role ?? '') == 'team_leader' ? 'selected' : ''); ?>>Team Leader / Admin PIC</option>
                                        <option value="pic" <?php echo e(old('role', $user->role ?? '') == 'pic' ? 'selected' : ''); ?>>PIC Khusus</option>
                                        <option value="finance" <?php echo e(old('role', $user->role ?? '') == 'finance' ? 'selected' : ''); ?>>Finance & Tax</option>
                                        <option value="performance" <?php echo e(old('role', $user->role ?? '') == 'performance' ? 'selected' : ''); ?>>Performance</option>
                                    </select>
                                </div>

                                
                                <div class="col-md-12 mt-3 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Submit
                                    </button>
                                    <a href="<?php echo e(route('user')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/form-tambah-pengguna.blade.php ENDPATH**/ ?>
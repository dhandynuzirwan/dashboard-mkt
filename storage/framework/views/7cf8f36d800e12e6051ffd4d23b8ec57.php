

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="page-inner">

        
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data Pengguna</h3>
                <h6 class="op-7 mb-2">Formulir Update Data Pengguna</h6>
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
                        <div class="card-title fw-bold m-0 text-primary">
                            <i class="fas fa-user-edit me-2"></i> Edit Data: <?php echo e($user->name); ?>

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

                        
                        <form action="<?php echo e(route('user.update', $user->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                        
                            <div class="row">
                                
                                <div class="col-md-12 mb-4 pb-3 border-bottom d-flex align-items-center">
                                    <div class="avatar avatar-xxl me-4 flex-shrink-0" style="width: 100px; height: 100px;">
                                        <?php if($user->foto_profil): ?>
                                            <img src="<?php echo e(asset('storage/' . $user->foto_profil)); ?>" alt="Profil" class="avatar-img rounded-circle border border-3 shadow-sm object-fit-cover">
                                        <?php else: ?>
                                            <div class="avatar-title rounded-circle bg-primary-gradient fw-bold text-white shadow-sm fs-2">
                                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <label class="fw-bold mb-1">Ganti Foto Profil (Opsional)</label>
                                        <input type="file" name="foto_profil" class="form-control form-control-sm" accept="image/*">
                                        <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</small>
                                    </div>
                                </div>
                        
                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="name" class="fw-bold mb-1">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                </div>
                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap" class="fw-bold mb-1">Nama Panggilan</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama_lengkap" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $user->nama_lengkap ?? '')); ?>">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap_ktp" class="fw-bold mb-1">Nama Lengkap (KTP)</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['nama_lengkap_ktp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama_lengkap_ktp" name="nama_lengkap_ktp" value="<?php echo e(old('nama_lengkap_ktp', $user->nama_lengkap_ktp ?? '')); ?>">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="no_hp" class="fw-bold mb-1">No. HP / WhatsApp</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="no_hp" name="no_hp" value="<?php echo e(old('no_hp', $user->no_hp ?? '')); ?>">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                </div>
                        
                                                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nik" class="fw-bold mb-1">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nik" name="nik" value="<?php echo e(old('nik', $user->nik)); ?>" placeholder="Masukkan NIK 16 digit">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="fw-bold mb-1">Tanggal Lahir</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir', $user->tanggal_lahir)); ?>">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_bergabung" class="fw-bold mb-1">Tanggal Bergabung</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_bergabung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tanggal_bergabung" name="tanggal_bergabung" value="<?php echo e(old('tanggal_bergabung', $user->tanggal_bergabung)); ?>">
                                </div>

                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_baru" class="fw-bold mb-1">Tanggal Kontrak Terbaru</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_kontrak_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tanggal_kontrak_baru" name="tanggal_kontrak_baru" value="<?php echo e(old('tanggal_kontrak_baru', $user->tanggal_kontrak_baru)); ?>">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_berakhir" class="fw-bold mb-1">Tanggal Kontrak Berakhir</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_kontrak_berakhir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tanggal_kontrak_berakhir" name="tanggal_kontrak_berakhir" value="<?php echo e(old('tanggal_kontrak_berakhir', $user->tanggal_kontrak_berakhir)); ?>">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="jobdesk_file" class="fw-bold mb-1">Jobdesk (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['jobdesk_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="jobdesk_file" name="jobdesk_file">
                                    <?php if($user->jobdesk_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->jobdesk_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat Jobdesk saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="sop_file" class="fw-bold mb-1">SOP (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['sop_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sop_file" name="sop_file">
                                    <?php if($user->sop_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->sop_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat SOP saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="ktp_file" class="fw-bold mb-1">KTP (PDF/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['ktp_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="ktp_file" name="ktp_file">
                                    <?php if($user->ktp_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->ktp_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat KTP saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="ijasah_file" class="fw-bold mb-1">Ijazah (PDF/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['ijasah_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="ijasah_file" name="ijasah_file">
                                    <?php if($user->ijasah_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->ijasah_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat Ijazah saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="pas_foto_file" class="fw-bold mb-1">Pas Foto (PDF/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['pas_foto_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="pas_foto_file" name="pas_foto_file">
                                    <?php if($user->pas_foto_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->pas_foto_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat Pas Foto saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="kk_file" class="fw-bold mb-1">Kartu Keluarga (PDF/Image)</label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['kk_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kk_file" name="kk_file">
                                    <?php if($user->kk_file): ?>
                                        <small class="d-block mt-1"><a href="<?php echo e(asset('storage/' . $user->kk_file)); ?>" target="_blank"><i class="fas fa-file me-1"></i> Lihat KK saat ini</a></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="role" class="fw-bold mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select class="form-select form-control <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role" name="role" required>
                                        <option value="superadmin" <?php echo e(old('role', $user->role) == 'superadmin' ? 'selected' : ''); ?>>Super Admin</option>
                                        <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        <option value="marketing" <?php echo e(old('role', $user->role) == 'marketing' ? 'selected' : ''); ?>>Marketing</option>
                                        <option value="rnd" <?php echo e(old('role', $user->role) == 'rnd' ? 'selected' : ''); ?>>RnD</option>
                                        <option value="digitalmarketing" <?php echo e(old('role', $user->role) == 'digitalmarketing' ? 'selected' : ''); ?>>Digital Marketing</option>
                                        <option value="operasional" <?php echo e(old('role', $user->role) == 'operasional' ? 'selected' : ''); ?>>Operasional / Backoffice / PIC</option>
                                        <option value="team_leader" <?php echo e(old('role', $user->role) == 'team_leader' ? 'selected' : ''); ?>>Team Leader / Admin PIC</option>
                                        <option value="spv_marketing" <?php echo e(old('role', $user->role) == 'spv_marketing' ? 'selected' : ''); ?>>SPV Marketing</option>
                                        <option value="web_dev" <?php echo e(old('role', $user->role) == 'web_dev' ? 'selected' : ''); ?>>Web Developer</option>
                                        <option value="hrd" <?php echo e(old('role', $user->role) == 'hrd' ? 'selected' : ''); ?>>HRD</option>
                                        <option value="graphic" <?php echo e(old('role', $user->role) == 'graphic' ? 'selected' : ''); ?>>Tim Grafis (Graphic)</option>
                                        <option value="pic" <?php echo e(old('role', $user->role) == 'pic' ? 'selected' : ''); ?>>PIC Khusus</option>
                                        <option value="finance" <?php echo e(old('role', $user->role) == 'finance' ? 'selected' : ''); ?>>Finance & Tax</option>
                                        <option value="performance" <?php echo e(old('role', $user->role) == 'performance' ? 'selected' : ''); ?>>Performance</option>
                                    </select>
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="password" class="fw-bold mb-1 text-danger">Ubah Password Baru</label>
                                    <input type="password" class="form-control border-danger border-opacity-50 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <small class="text-muted d-block mt-1">Biarkan kosong jika tetap memakai password lama.</small>
                                </div>
                        
                                
                                <div class="col-md-12 mt-3 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/form-edit-pengguna.blade.php ENDPATH**/ ?>
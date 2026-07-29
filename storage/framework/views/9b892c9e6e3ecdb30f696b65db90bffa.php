 

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            
            <div class="card card-modern border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-5 pb-0 text-center">
                    <h4 class="fw-bolder mb-1 text-dark">Pengaturan Profil</h4>
                    <p class="text-muted small mb-0">Kelola informasi pribadi dan foto profil Anda</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('my-profile.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="d-flex flex-column align-items-center mb-5">
                            <div class="position-relative mb-3">
                                
                                
                                <?php if($user->foto_profil): ?>
                                    <img id="preview-foto" src="<?php echo e(asset('storage/' . $user->foto_profil)); ?>" class="rounded-circle shadow-sm object-fit-cover" style="width: 140px; height: 140px; border: 4px solid #fff;">
                                
                                
                                <?php else: ?>
                                    <div id="preview-foto-container" class="rounded-circle shadow-sm d-flex flex-column align-items-center justify-content-center bg-light border" style="width: 140px; height: 140px; border: 4px solid #fff !important;">
                                        <i class="fas fa-user text-secondary opacity-50 mb-1" style="font-size: 3rem;"></i>
                                        <span class="text-secondary fw-bold" style="font-size: 10px;">Belum ada foto</span>
                                    </div>
                                    
                                    <img id="preview-foto" src="" class="rounded-circle shadow-sm object-fit-cover d-none" style="width: 140px; height: 140px; border: 4px solid #fff;">
                                <?php endif; ?>

                                
                                <label for="foto_profil" class="position-absolute bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow border border-2 border-white transition-all hover-lift" style="width: 38px; height: 38px; bottom: 5px; right: 5px; cursor: pointer;" title="Ubah Foto">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(event)">
                            </div>
                            
                            <?php $__errorArgs = ['foto_profil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 fw-bold" style="font-size: 12px;"><i class="fas fa-exclamation-triangle me-1"></i><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="text-muted text-center" style="font-size: 11px;">Maksimal 2MB (JPG, PNG, WEBP)</div>
                        </div>

                        
                        <div class="form-group mb-4 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Username <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-user-lock text-muted"></i>
                                </span>
                                <input type="text" class="form-control bg-light text-muted ps-5" value="<?php echo e($user->name); ?>" readonly disabled title="Username tidak dapat diubah">
                            </div>
                            <small class="text-muted" style="font-size: 10px;">Hubungi Admin jika ingin mengubah username.</small>
                        </div>

                        <div class="form-group mb-4 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Nama Lengkap</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-id-card text-primary opacity-75"></i>
                                </span>
                                <input type="text" name="nama_lengkap" class="form-control ps-5 <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_lengkap', $user->nama_lengkap)); ?>" placeholder="Masukkan nama lengkap Anda">
                            </div>
                            <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-4 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Nomor HP / WhatsApp</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-phone text-success opacity-75"></i>
                                </span>
                                <input type="text" name="no_hp" class="form-control ps-5 <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_hp', $user->no_hp)); ?>" placeholder="Contoh: 081234567890">
                            </div>
                            <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-4 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Nomor Induk Kependudukan (NIK)</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-id-badge text-secondary opacity-75"></i>
                                </span>
                                <input type="text" name="nik" class="form-control ps-5 <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nik', $user->nik)); ?>" placeholder="Masukkan 16 digit NIK">
                            </div>
                            <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-4 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Tanggal Lahir</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-calendar-day text-warning opacity-75"></i>
                                </span>
                                <input type="date" name="tanggal_lahir" class="form-control ps-5 <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('tanggal_lahir', $user->tanggal_lahir)); ?>">
                            </div>
                            <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-4 px-0">
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Kontrak Baru</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fas fa-file-signature text-success opacity-75"></i>
                                        </span>
                                        <input type="date" name="tanggal_kontrak_baru" class="form-control ps-5 <?php $__errorArgs = ['tanggal_kontrak_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('tanggal_kontrak_baru', $user->tanggal_kontrak_baru)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['tanggal_kontrak_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4 px-0">
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Kontrak Berakhir</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="fas fa-file-excel text-danger opacity-75"></i>
                                        </span>
                                        <input type="date" name="tanggal_kontrak_berakhir" class="form-control ps-5 <?php $__errorArgs = ['tanggal_kontrak_berakhir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('tanggal_kontrak_berakhir', $user->tanggal_kontrak_berakhir)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['tanggal_kontrak_berakhir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <?php if($user->role === 'marketing'): ?>
                        <div class="form-group mb-5 px-0">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 13px;">Suara CTA Deal Kustom (Maks 30 Detik)</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <i class="fas fa-music text-info opacity-75"></i>
                                </span>
                                <input type="file" name="deal_sound" id="deal_sound" class="form-control ps-5 <?php $__errorArgs = ['deal_sound'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="audio/mpeg,audio/wav">
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 10px;">Format: MP3/WAV. Ukuran maks 5MB. Durasi maksimal 30 detik.
                                <?php if($user->deal_sound_path): ?>
                                    <br>
                                    <span class="text-success fw-bold d-inline-block mt-1">
                                        <i class="fas fa-check-circle"></i> Tersimpan: <?php echo e(preg_replace('/^[0-9]+_/', '', basename($user->deal_sound_path))); ?>

                                    </span>
                                <?php endif; ?>
                            </small>
                            <div class="invalid-feedback fw-bold" id="deal_sound_error" style="font-size: 12px; display: none;"></div>
                            <?php $__errorArgs = ['deal_sound'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block fw-bold" style="font-size: 12px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>


<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview-foto');
            var emptyContainer = document.getElementById('preview-foto-container');
            
            // Jika sebelumnya tidak ada foto (container icon aktif), sembunyikan icon dan munculkan tag img
            if (emptyContainer) {
                emptyContainer.classList.add('d-none');
                emptyContainer.classList.remove('d-flex');
                output.classList.remove('d-none');
            }
            
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    <?php if($user->role === 'marketing'): ?>
    // Validasi durasi audio maksimal 30 detik
    document.getElementById('deal_sound').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const errorDiv = document.getElementById('deal_sound_error');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        errorDiv.style.display = 'none';
        submitBtn.disabled = false;
        this.classList.remove('is-invalid');

        if (file) {
            // Check file size (5MB = 5242880 bytes)
            if (file.size > 5242880) {
                this.classList.add('is-invalid');
                errorDiv.innerText = 'Ukuran file melebihi 5MB.';
                errorDiv.style.display = 'block';
                submitBtn.disabled = true;
                return;
            }

            const audio = new Audio();
            audio.preload = 'metadata';
            
            audio.onloadedmetadata = function() {
                window.URL.revokeObjectURL(audio.src);
                if (audio.duration > 30.5) { // 30.5 to allow tiny fractions
                    document.getElementById('deal_sound').classList.add('is-invalid');
                    errorDiv.innerText = `Durasi audio terlalu panjang (${Math.round(audio.duration)} detik). Maksimal 30 detik!`;
                    errorDiv.style.display = 'block';
                    submitBtn.disabled = true;
                }
            }
            
            audio.src = URL.createObjectURL(file);
        }
    });
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/profile/edit.blade.php ENDPATH**/ ?>
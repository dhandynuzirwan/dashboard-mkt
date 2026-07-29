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
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        border-radius: 24px;
        transition: all 0.3s ease;
    }
    .form-control-modern { 
        border-radius: 12px; 
        border: 2px solid #edf2f9; 
        padding: 12px 18px; 
        font-size: 14.5px; 
        background-color: #f8f9fc; 
        transition: all 0.3s;
        color: #333;
    }
    .form-control-modern:focus { 
        background-color: #fff; 
        border-color: #4e73df; 
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1); 
        outline: none;
    }
    .form-select-modern {
        border-radius: 12px; 
        border: 2px solid #edf2f9; 
        padding: 12px 18px; 
        font-size: 14.5px; 
        background-color: #f8f9fc; 
        transition: all 0.3s;
    }
    .form-select-modern:focus {
        background-color: #fff; 
        border-color: #4e73df; 
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1); 
        outline: none;
    }
    .form-label-modern {
        font-weight: 700;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .btn-premium { 
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); 
        color: white; 
        border: none; 
        border-radius: 50px; 
        padding: 12px 28px; 
        font-weight: 700; 
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); 
        transition: all 0.3s; 
    }
    .btn-premium:hover { 
        box-shadow: 0 8px 20px rgba(78, 115, 223, 0.4); 
        color: white;
    }
    .btn-light-modern {
        background: #ffffff;
        color: #6c757d;
        border: 2px solid #edf2f9;
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 700;
        transition: all 0.3s;
    }
    .btn-light-modern:hover {
        background: #f8f9fc;
        color: #4a5568;
        border-color: #d1d3e2;
    }
    .upload-zone {
        border: 2px dashed #bac8f3;
        border-radius: 16px;
        background-color: #f4f7fe;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    .upload-zone:hover {
        background-color: #edf2f9;
        border-color: #4e73df;
    }
    .upload-icon {
        background: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        color: #4e73df;
        font-size: 24px;
        margin-bottom: 15px;
    }
</style>

<div class="page-wrapper-modern fade-in">
    <div class="container-fluid py-5 px-3 px-md-4">
        <div class="row">
            <div class="col-12 col-xl-9 mx-auto">
                
                <div class="d-flex align-items-center mb-4">
                    <a href="<?php echo e(route('operational.permintaan-visual.biasa')); ?>" class="btn btn-light rounded-circle me-3 shadow-sm hover-lift border-0" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: white;">
                        <i class="fas fa-arrow-left text-primary"></i>
                    </a>
                    <div>
                        <h2 class="fw-black text-dark mb-1" style="letter-spacing: -0.5px;">Buat Permintaan Baru</h2>
                        <p class="text-muted mb-0" style="font-size: 14px;">Lengkapi form di bawah ini untuk mengajukan kebutuhan visual.</p>
                    </div>
                </div>

                <div class="glass-card p-4 p-md-5">
                    <form action="<?php echo e(route('operational.permintaan-visual.biasa.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label-modern">Judul Permintaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern w-100" name="judul" placeholder="Contoh: Desain Brosur Promo Kemerdekaan" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-modern">Kategori Desain <span class="text-danger">*</span></label>
                                <select class="form-select-modern w-100" name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Cover Proposal">Cover Proposal</option>
                                    <option value="Flyer/Poster">Flyer/Poster</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Media Sosial">Media Sosial</option>
                                    <option value="Presentasi">Presentasi</option>
                                    <option value="Lainya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-modern">Target Selesai (Deadline) <span class="text-danger">*</span></label>
                                <input type="date" class="form-control-modern w-100" name="deadline" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Tujuan / Kegunaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control-modern w-100" name="tujuan" placeholder="Contoh: Untuk disebar di grup WhatsApp dan Instagram" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Deskripsi Kebutuhan Secara Detail <span class="text-danger">*</span></label>
                                <textarea class="form-control-modern w-100" name="deskripsi" rows="6" placeholder="Jelaskan secara detail tentang visual yang diinginkan, seperti warna dominan, teks yang harus dimasukkan, gaya bahasa, atau gaya visual..." required></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Referensi / Contoh Desain <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="upload-zone" onclick="document.getElementById('file-upload').click()">
                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Klik untuk mengunggah referensi</h6>
                                    <p class="text-muted small mb-3">atau seret dan lepas file di sini</p>
                                    <input type="file" id="file-upload" class="d-none" name="referensi" accept=".png,.jpg,.jpeg,.pdf,.ai,.psd">
                                    <span class="badge bg-white text-primary border px-3 py-2 rounded-pill shadow-sm">Pilih File...</span>
                                    <div class="small text-muted mt-3"><i class="fas fa-info-circle me-1"></i> Format: PNG, JPG, PDF, AI, PSD (Maks. 20MB)</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern">Catatan Tambahan <span class="text-muted fw-normal">(Opsional)</span></label>
                                <textarea class="form-control-modern w-100" name="catatan" rows="3" placeholder="Tambahan informasi jika ada..."></textarea>
                            </div>
                        </div>

                        <hr class="my-5" style="border-color: #edf2f9; opacity: 1;">

                        <div class="d-flex flex-column flex-md-row justify-content-end gap-3">
                            <a href="<?php echo e(route('operational.permintaan-visual.biasa')); ?>" class="btn-light-modern text-center text-decoration-none">Batalkan</a>
                            <button type="submit" class="btn-premium">
                                <i class="fas fa-paper-plane me-2"></i> Submit Permintaan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/operational/permintaan-visual/biasa/create.blade.php ENDPATH**/ ?>
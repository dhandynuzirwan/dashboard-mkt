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
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }
    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }
    
    .table-custom { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px;}
    .table-custom tr { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 16px; transition: all 0.2s ease; border: 1px solid #f1f3f9;}
    .table-custom tr:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
    .table-custom td { padding: 18px 22px; border: none; vertical-align: middle;}
    .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-custom th { border: none; padding: 10px 22px; color: #858796; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; background: transparent;}

    .nav-pills-custom .nav-link {
        border-radius: 50px;
        padding: 10px 24px;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nav-pills-custom .nav-link.active {
        background-color: #4e73df;
        color: #fff;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.35);
    }
    .nav-pills-custom .nav-link:hover:not(.active) {
        background-color: #f1f3f9;
        color: #4e73df;
    }
    .badge-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #258391; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    
    .btn-premium { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); transition: all 0.3s; }
    .btn-premium:hover { box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4); color: white;}
    .form-control-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-control-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    .form-select-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-select-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    .btn-light-modern { background: #ffffff; color: #6c757d; border: 2px solid #edf2f9; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: all 0.3s; }
    .btn-light-modern:hover { background: #f8f9fc; color: #4a5568; border-color: #d1d3e2; }
    
    /* MODAL STYLES */
    .modal-content-modern { border-radius: 24px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);}
    .modal-header-modern { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;}
</style>

<div class="page-wrapper-modern fade-in">
    <div class="container-fluid py-4 px-3 px-md-4">
        
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">Permintaan Biasa</h2>
                <p class="text-muted mb-0" style="font-size: 15px;">Manajemen visual untuk desain umum selain keperluan training.</p>
            </div>
            <a href="<?php echo e(route('operational.permintaan-visual.biasa.create')); ?>" class="btn btn-premium">
                <i class="fas fa-plus me-2"></i> Buat Permintaan
            </a>
        </div>

        
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-warning me-3 shadow-sm">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Menunggu</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">12</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-info me-3 shadow-sm">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Dalam Proses</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">5</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-primary me-3 shadow-sm">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Review</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">3</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-success me-3 shadow-sm">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Selesai</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">24</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                
                <div class="glass-card p-4 h-100">
                    <h6 class="fw-bolder mb-3 text-dark">History Permintaan (Bulan Ini)</h6>
                    <div style="position: relative; height: 220px; width: 100%;">
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                
                <div class="glass-card p-4 h-100">
                    <h6 class="fw-bolder mb-3 text-dark">Prioritas Permintaan</h6>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div style="position: relative; height: 180px; width: 100%;">
                            <canvas id="prioritasChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="d-flex justify-content-center mb-5">
            <div class="glass-card p-2 d-inline-flex">
                <ul class="nav nav-pills-custom mb-0 d-flex flex-wrap gap-2" id="pills-tab-with-icon" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-semua-tab" data-bs-toggle="pill" href="#pills-semua" role="tab">
                        <i class="fas fa-layer-group"></i> Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-proposal-tab" data-bs-toggle="pill" href="#pills-proposal" role="tab">
                        <i class="fas fa-book"></i> Cover Proposal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-flyer-tab" data-bs-toggle="pill" href="#pills-flyer" role="tab">
                        <i class="fas fa-file-image"></i> Flyer/Poster
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-penjualan-tab" data-bs-toggle="pill" href="#pills-penjualan" role="tab">
                        <i class="fas fa-shopping-cart"></i> Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-sosmed-tab" data-bs-toggle="pill" href="#pills-sosmed" role="tab">
                        <i class="fab fa-instagram"></i> Media Sosial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-presentasi-tab" data-bs-toggle="pill" href="#pills-presentasi" role="tab">
                        <i class="fas fa-desktop"></i> Presentasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-lainnya-tab" data-bs-toggle="pill" href="#pills-lainnya" role="tab">
                        <i class="fas fa-ellipsis-h"></i> Lainnya
                    </a>
                </li>
            </ul>
        </div>
    </div>

        
        <div class="glass-card p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-ul text-primary me-2"></i> Daftar Permintaan</h5>
                
                
                <form action="#" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <input type="text" name="search" class="form-control-modern" placeholder="Cari judul..." style="width: 200px;">
                    <select name="status" class="form-control-modern" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dalam Proses">Dalam Proses</option>
                    </select>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background-color: #4e73df; border:none;"><i class="fas fa-filter me-1"></i> Filter</button>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom w-100">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul Permintaan</th>
                            <th>Kategori & Tipe</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Pengerjaan</th>
                            <th>Tanggal</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="text-muted fw-bold">1</td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 15px;">Desain Poster Promo Kemerdekaan</div>
                                <div class="text-muted small mt-1">Dibuat oleh: <span class="text-primary fw-bold">Budi Santoso</span></div>
                            </td>
                            <td>
                                <span class="badge-soft-info d-inline-block mb-1">Flyer/Poster</span><br>
                                <span class="badge bg-secondary text-white rounded-pill px-2" style="font-size:10px;">Baru</span>
                            </td>
                            <td><span class="badge-soft-danger"><i class="fas fa-arrow-up me-1"></i> Tinggi</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-soft-warning"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">-</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">28 Jul 2026</div>
                                <div class="text-muted small">Target: 30 Jul 2026</div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px; border: 1px solid #e3e6f0;">
                                        <i class="fas fa-ellipsis-h text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                        <li><a class="dropdown-item py-2 rounded-3" href="#" data-bs-toggle="modal" data-bs-target="#modalDetailPermintaan"><i class="fas fa-eye text-primary me-2"></i> Detail</a></li>
                                        <li><a class="dropdown-item py-2 rounded-3" href="#"><i class="fas fa-edit text-info me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 rounded-3 text-danger" href="#"><i class="fas fa-trash me-2"></i> Batalkan</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-bold">2</td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 15px;">Cover Proposal Klien BUMN</div>
                                <div class="text-muted small mt-1">Dibuat oleh: <span class="text-primary fw-bold">Siti Aminah</span></div>
                            </td>
                            <td>
                                <span class="badge-soft-primary d-inline-block mb-1">Cover Proposal</span><br>
                                <span class="badge bg-secondary text-white rounded-pill px-2" style="font-size:10px;">Revisi</span>
                            </td>
                            <td><span class="badge-soft-warning"><i class="fas fa-minus me-1"></i> Sedang</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-soft-info"><i class="fas fa-spinner fa-spin me-1"></i> Diproses</span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 13px;"><i class="fas fa-stopwatch text-primary me-1"></i> 2 Hari 4 Jam</div>
                                <div class="text-muted small mt-1">Oleh: <span class="text-primary fw-bold">Alex (Graphic)</span></div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">27 Jul 2026</div>
                                <div class="text-muted small">Target: 01 Ags 2026</div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px; border: 1px solid #e3e6f0;">
                                        <i class="fas fa-ellipsis-h text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                        <li><a class="dropdown-item py-2 rounded-3" href="#" data-bs-toggle="modal" data-bs-target="#modalDetailPermintaan"><i class="fas fa-eye text-primary me-2"></i> Detail</a></li>
                                        <li><a class="dropdown-item py-2 rounded-3" href="#"><i class="fas fa-edit text-info me-2"></i> Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetailPermintaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bolder mb-1"><i class="fas fa-file-invoice me-2 text-white-50"></i> Detail Permintaan Visual</h4>
                    <p class="mb-0 text-white-50 fw-bold" style="font-size: 13px;">Desain Poster Promo Kemerdekaan &bull; Dibuat oleh Budi Santoso</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-danger px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                        <i class="fas fa-arrow-up me-1"></i> Prioritas Tinggi
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="modal-body p-4 p-md-5" style="background-color: #f8f9fc;">
                <div class="row g-4">
                    
                    <div class="col-lg-8">
                        <div class="glass-card p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                <h5 class="fw-bolder text-dark mb-0"><i class="fas fa-info-circle text-primary me-2"></i> Informasi Kebutuhan</h5>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold"><i class="fas fa-edit me-1"></i> Edit</button>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Judul Permintaan</div>
                                <div class="col-sm-8 fw-bold text-dark">Desain Poster Promo Kemerdekaan</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Kategori Desain</div>
                                <div class="col-sm-8"><span class="badge-soft-info px-3 py-1">Flyer/Poster</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Target Selesai</div>
                                <div class="col-sm-8 fw-bold text-dark"><i class="fas fa-calendar-alt text-danger me-1"></i> 30 Jul 2026</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Tujuan/Kegunaan</div>
                                <div class="col-sm-8 text-dark">Untuk disebar di grup WhatsApp dan Instagram feed official perusahaan.</div>
                            </div>
                            
                            <hr class="my-4" style="border-color: #edf2f9; opacity: 1;">
                            
                            <h6 class="fw-bolder text-dark mb-3">Deskripsi Kebutuhan Secara Detail</h6>
                            <div class="p-3 bg-light rounded-3 border mb-4 text-dark" style="font-size: 14px; line-height: 1.6;">
                                Tolong buatkan desain poster kemerdekaan RI ke-81. Dominan warna merah putih, tapi kasih sentuhan modern minimalist (tidak norak). Jangan lupa masukkan logo perusahaan di pojok kanan atas, dan teks promo "MERDEKA SALE 45%" di tengah.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="fw-bolder text-dark mb-2">Referensi Desain</h6>
                                    <div class="d-flex align-items-center p-3 rounded-3" style="background: #f4f7fe; border: 1px dashed #bac8f3;">
                                        <i class="fas fa-file-image text-primary fa-2x me-3"></i>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">referensi_poster_1.jpg</div>
                                            <div class="text-muted small">1.2 MB</div>
                                        </div>
                                        <a href="#" class="btn btn-light rounded-circle text-primary shadow-sm ms-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bolder text-dark mb-0">Komentar</h6>
                                        <button class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-bold" style="font-size: 13px;"><i class="fas fa-edit me-1"></i> Edit/Tambah</button>
                                    </div>
                                    <div class="p-3 bg-light rounded-3 border h-100 text-dark small">
                                        <em>"Tolong sediakan juga versi resolusi tinggi untuk dicetak ukuran A3."</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-4">
                        <div class="glass-card p-4 mb-4">
                            <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-tasks text-warning me-2"></i> Status Pengerjaan</h6>
                            <div class="mb-3">
                                <select class="form-select-modern w-100" name="status_update" id="statusSelect" onchange="toggleRevisiNote()" <?php if(in_array(auth()->user()->role ?? 'graphic', ['karyawan'])): ?> disabled <?php endif; ?>>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Review" selected>Sudah di-upload graphic (Review)</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Revisi">Revisi</option>
                                </select>
                            </div>
                            
                            <div id="revisi-note-area" class="d-none">
                                <label class="form-label fw-bold text-dark small mb-2">Komentar Revisi <span class="text-danger">*</span></label>
                                <textarea class="form-control-modern w-100 mb-3" rows="3" placeholder="Tuliskan bagian mana yang perlu direvisi..."></textarea>
                            </div>

                            <button class="btn btn-premium w-100 py-2">Update Status</button>
                        </div>

                        
                        <div class="glass-card p-4 border-primary border-2">
                            <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-paint-brush text-primary me-2"></i> Hasil Desain (Tim Graphic)</h6>
                            
                            
                            <div class="d-flex align-items-center p-3 rounded-3 mb-3" style="background: #f4f7fe; border: 1px solid #bac8f3;">
                                <i class="fas fa-file-image text-success fa-2x me-3"></i>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">poster_kemerdekaan_final.jpg</div>
                                    <div class="text-muted small">Waktu: 2 Hari 4 Jam</div>
                                </div>
                                <a href="#" download class="btn btn-sm btn-light text-primary rounded-circle shadow-sm ms-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Unduh">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" title="Hapus File"><i class="fas fa-trash-alt"></i></button>
                            </div>

                            <?php if(in_array(auth()->user()->role ?? 'graphic', ['graphic', 'superadmin', 'web_dev'])): ?>
                            <hr class="my-3 opacity-25">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <label class="fw-bold text-dark small mb-2">Upload / Ganti File Hasil</label>
                                <div class="input-group input-group-sm mb-2 rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                    <input type="file" class="form-control form-control-sm border-0 py-2 px-3 bg-white" name="hasil_desain" required>
                                    <button class="btn btn-primary px-3 fw-bold border-0" type="button" style="background: #4e73df;"><i class="fas fa-upload"></i></button>
                                </div>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-white border-top-0 py-3 px-4">
                <button type="button" class="btn btn-light-modern px-4 py-2" data-bs-dismiss="modal">Tutup Modal</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Doughnut Chart (Prioritas)
        var ctxPrioritas = document.getElementById('prioritasChart').getContext('2d');
        var prioritasChart = new Chart(ctxPrioritas, {
            type: 'doughnut',
            data: {
                labels: ['Tinggi', 'Sedang', 'Rendah'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: ['#e74a3b', '#f6c23e', '#36b9cc'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: { size: 12, family: "'Nunito', sans-serif" }
                        }
                    }
                }
            }
        });

        // Line/Bar Chart (History)
        var ctxHistory = document.getElementById('historyChart').getContext('2d');
        var historyChart = new Chart(ctxHistory, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Jumlah Permintaan',
                    data: [12, 19, 15, 24],
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderColor: '#4e73df',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#edf2f9' },
                        ticks: { stepSize: 5 }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });

    // Toggle text area revisi
    function toggleRevisiNote() {
        var status = document.getElementById('statusSelect').value;
        var revisiArea = document.getElementById('revisi-note-area');
        if (status === 'Revisi') {
            revisiArea.classList.remove('d-none');
        } else {
            revisiArea.classList.add('d-none');
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/operational/permintaan-visual/biasa/index.blade.php ENDPATH**/ ?>
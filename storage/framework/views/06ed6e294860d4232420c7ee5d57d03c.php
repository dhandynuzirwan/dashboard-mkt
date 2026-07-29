<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 fade-in" style="background-color: #f8fafc00; min-height: 100vh;">
    <div class="row px-2 px-md-3">
        <div class="col-12">
            
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-black text-dark mb-0"><i class="fas fa-history text-primary me-2"></i> Riwayat Pelatihan</h3>
                    <p class="text-muted mb-0 small">Kelola data pelaksanaan, sertifikasi, dan pengiriman paket pelatihan.</p>
                </div>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold hover-lift" data-bs-toggle="modal" data-bs-target="#addRiwayatModal">
                    <i class="fas fa-plus me-1"></i> Input Data Riwayat
                </button>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm bg-success-subtle mb-4" role="alert">
                    <i class="fas fa-check-circle text-success me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white fade-in">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 13px;">
                            <i class="fas fa-filter"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">Filter Data Pelatihan</h6>
                    </div>
                    
                    <form action="<?php echo e(route('riwayat.pelatihan')); ?>" method="GET" class="row g-3 align-items-end">
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Bulan & Tahun</label>
                            <input type="month" name="month_year" class="form-control form-control-sm rounded-3 px-3 py-2" value="<?php echo e(request('month_year')); ?>">
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Jenis Pelatihan</label>
                            <select name="jenis" class="form-select form-select-sm rounded-3 px-3 py-2">
                                <option value="">Semua Jenis</option>
                                <?php $__currentLoopData = $listJenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($j); ?>" <?php echo e(request('jenis') == $j ? 'selected' : ''); ?>><?php echo e($j); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Metode</label>
                            <select name="metode" class="form-select form-select-sm rounded-3 px-3 py-2">
                                <option value="">Semua Metode</option>
                                <?php $__currentLoopData = $listMetode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e(request('metode') == $m ? 'selected' : ''); ?>><?php echo e($m); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm rounded-pill fw-bold px-4 flex-grow-1 hover-lift">Terapkan</button>
                            <a href="<?php echo e(route('riwayat.pelatihan')); ?>" class="btn btn-light btn-sm border rounded-pill px-3 fw-bold hover-lift text-muted" title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Pelatihan (Batch)</p>
                                <h3 class="fw-black text-dark mb-0"><?php echo e(number_format($totalPelatihan)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Peserta</p>
                                <h3 class="fw-black text-dark mb-0"><?php echo e(isset($totalPeserta) ? number_format($totalPeserta) : 0); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Sertifikat Terbit (Peserta)</p>
                                <h3 class="fw-black text-dark mb-0"><?php echo e(number_format($totalSertifikatTerbit)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-hourglass-half text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Sertifikat Pending (Peserta)</p>
                                <h3 class="fw-black text-dark mb-0"><?php echo e(number_format($totalSertifikatPending)); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row g-3 mb-4 fade-in">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                            <h6 class="fw-bolder mb-0"><i class="fas fa-chart-line text-primary me-2"></i> Grafik Trend (12 Bulan Terakhir)</h6>
                        </div>
                        <div class="card-body px-4 pb-4 pt-3">
                            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                <canvas id="riwayatChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                            <h6 class="fw-bolder mb-0"><i class="fas fa-chart-pie text-success me-2"></i> Proporsi Jenis Pelatihan</h6>
                        </div>
                        <div class="card-body px-4 pb-4 pt-3 d-flex align-items-center justify-content-center">
                            <?php if(count($chartJenisData['labels']) > 0): ?>
                                <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
                                    <canvas id="jenisChart"></canvas>
                                </div>
                            <?php else: ?>
                                <div class="text-muted text-center py-5">
                                    <i class="fas fa-chart-pie fa-3x opacity-25 mb-3"></i>
                                    <p class="mb-0 small">Belum ada data untuk ditampilkan</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
                <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bolder mb-0"><i class="fas fa-list-alt text-primary me-2"></i> Data Riwayat Pelatihan Lengkap</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13px; white-space: nowrap;">
                            <thead class="bg-light sticky-top text-muted" style="z-index: 1;">
                                <tr>
                                    <th width="5%" class="text-center py-3">No</th>
                                    <th class="py-3">Info Pelatihan</th>
                                    <th class="py-3">Instansi & Peserta</th>
                                    <th class="py-3">Tim & PIC</th>
                                    <th class="py-3">Status Sertifikasi</th>
                                    <th class="py-3">Pengiriman</th>
                                    <th width="10%" class="text-center py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <tr>
                                    <td class="text-center fw-bold text-muted"><?php echo e($riwayat->firstItem() + $index); ?></td>
                                    
                                    
                                    <td>
                                        <div class="fw-bolder text-dark mb-1 text-wrap" style="max-width: 250px; font-size: 14px;"><?php echo e($item->judul_pelatihan); ?></div>
                                        <div class="text-muted small mb-1">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i> 
                                            <?php echo e(\Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y')); ?>

                                        </div>
                                        <span class="badge bg-light text-dark border"><?php echo e($item->jenis); ?></span>
                                        <span class="badge bg-light text-dark border"><?php echo e($item->metode); ?></span>
                                    </td>
                                    
                                    
                                    <td>
                                        <?php
                                            $instansiArr = array_filter($item->instansi_peserta_array);
                                            $instansiUnique = array_values(array_unique($instansiArr));
                                            if (count($instansiUnique) > 2) {
                                                $instansiDisplay = $instansiUnique[0] . ', ' . $instansiUnique[1] . ' (dan ' . (count($instansiUnique) - 2) . ' lainnya)';
                                            } else {
                                                $instansiDisplay = implode(', ', $instansiUnique) ?: '-';
                                            }
                                        ?>
                                        <div class="fw-bold text-dark text-wrap" style="max-width: 200px;"><?php echo e($instansiDisplay); ?></div>
                                        <div class="text-muted small my-1">
                                            <i class="fas fa-users text-warning me-1"></i> <b class="text-dark"><?php echo e($item->jumlah_peserta); ?></b> Peserta
                                        </div>
                                        <div class="text-muted small text-truncate" style="max-width: 200px;" title="<?php echo e(implode(', ', $item->nama_peserta_array)); ?>"><?php echo e(implode(', ', $item->nama_peserta_array)); ?></div>
                                    </td>
                                    
                                    
                                    <td>
                                        <div class="small mb-1"><span class="text-muted">Trainer:</span> <span class="fw-bold text-dark"><?php echo e(\Illuminate\Support\Str::limit($item->nama_trainer ?? '-', 15)); ?></span></div>
                                        <div class="small mb-1"><span class="text-muted">LSP:</span> <span class="fw-bold text-dark"><?php echo e(\Illuminate\Support\Str::limit($item->nama_lsp ?? '-', 15)); ?></span></div>
                                        <?php
                                            $mktArr = array_filter($item->marketing_array);
                                            $mktUnique = array_unique($mktArr);
                                            $mktDisplay = implode(', ', $mktUnique) ?: '-';

                                            $picName = '-';
                                            if ($item->pic) {
                                                $picUser = $users->where('name', $item->pic)->first();
                                                $picName = $picUser && $picUser->nama_lengkap ? $picUser->nama_lengkap : $item->pic;
                                            }
                                        ?>
                                        <div class="small"><span class="text-muted">PIC:</span> <span class="text-primary fw-bold"><?php echo e($picName); ?></span> <span class="text-muted">| Mkt:</span> <?php echo e($mktDisplay); ?></div>
                                    </td>
                                    
                                    
                                    <td>
                                        <div class="mb-1">
                                            <?php if($item->status_sertif == 'Sudah Terbit'): ?>
                                                <span class="badge bg-success-subtle text-success px-2 py-1"><i class="fas fa-check-circle me-1"></i>Sertif Terbit</span>
                                            <?php elseif($item->status_sertif == 'Belum Terbit'): ?>
                                                <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1"><i class="fas fa-clock me-1"></i>Sertif Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border px-2 py-1"><i class="fas fa-minus-circle me-1"></i>Belum Diinput</span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if($item->status_kompeten == 'Kompeten'): ?>
                                                <span class="badge bg-info-subtle text-info-emphasis px-2 py-1">Kompeten</span>
                                            <?php elseif($item->status_kompeten == 'Belum'): ?>
                                                <span class="badge bg-danger-subtle text-danger px-2 py-1">Belum Kompeten</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border px-2 py-1">Belum Asesmen</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    
                                    <td>
                                        <div class="mb-1">
                                            <?php if($item->status_pengiriman == 'Dikirim'): ?>
                                                <span class="badge bg-primary-subtle text-primary"><i class="fas fa-truck me-1"></i> Dikirim</span>
                                            <?php elseif($item->status_pengiriman == 'Diterima'): ?>
                                                <span class="badge bg-success-subtle text-success"><i class="fas fa-box-open me-1"></i> Diterima</span>
                                            <?php elseif($item->status_pengiriman == 'Diproses'): ?>
                                                <span class="badge bg-warning-subtle text-warning-emphasis"><i class="fas fa-box me-1"></i> Diproses</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border">Belum Info</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="small text-muted">Resi: <span class="fw-bold text-dark"><?php echo e($item->no_resi ?? '-'); ?></span></div>
                                    </td>
                                    
                                    
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold hover-lift" data-bs-toggle="modal" data-bs-target="#detailModal<?php echo e($item->id); ?>">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                            <h6 class="fw-bold">Belum ada data pelatihan</h6>
                                            <p class="small mb-0">Data riwayat yang ditambahkan akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 bg-white border-top">
                        <?php echo e($riwayat->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>






<div class="modal fade" id="addRiwayatModal" tabindex="-1" aria-labelledby="addRiwayatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form action="<?php echo e(route('riwayat.pelatihan.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
            <h5 class="modal-title fw-bold" id="addRiwayatModalLabel"><i class="fas fa-plus-circle me-2"></i> Input Data Riwayat Pelatihan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto; background-color: #f8fafc;">
              
              
              <div class="card border-0 shadow-sm rounded-4 mb-4">
                  <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                      <h6 class="fw-bold text-primary mb-0">1. Informasi Umum Pelatihan</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="row g-3">
                          <div class="col-md-12">
                              <label class="form-label fw-bold small">Judul Pelatihan <span class="text-danger">*</span></label>
                              <input type="text" name="judul_pelatihan" class="form-control rounded-3" required>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Tgl. Mulai <span class="text-danger">*</span></label>
                              <input type="date" name="tanggal_mulai" class="form-control rounded-3" required>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Tgl. Selesai <span class="text-danger">*</span></label>
                              <input type="date" name="tanggal_selesai" class="form-control rounded-3" required>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Jum. Peserta <span class="text-danger">*</span></label>
                              <input type="number" name="jumlah_peserta" id="inputJumlahPeserta" class="form-control rounded-3" required min="1">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Jenis Pelatihan</label>
                              <select name="jenis" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Sertifikat KEMNAKER">Sertifikat KEMNAKER</option>
                                  <option value="Sertifikat BNSP">Sertifikat BNSP</option>
                                  <option value="UPSKILLS">UPSKILLS</option>
                                  <option value="Sertifikat Internal">Sertifikat Internal</option>
                                  <option value="Pembuatan & Perpanjangan SIO">Pembuatan & Perpanjangan SIO</option>
                                  <option value="Riksa Uji Alat">Riksa Uji Alat</option>
                              </select>
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Metode</label>
                              <select name="metode" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Online Training">Online Training</option>
                                  <option value="Offline Training">Offline Training</option>
                                  <option value="Blended Training">Blended Training</option>
                                  <option value="Inhouse Training">Inhouse Training</option>
                                  <option value="Public Training">Public Training</option>
                                  <option value="Titip Vendor Lain">Titip Vendor Lain</option>
                              </select>
                          </div>
                          <div class="col-12 mt-4">
                              <label class="form-label fw-bold small text-primary"><i class="fas fa-users me-1"></i> Data Peserta (Otomatis dari Jum. Peserta)</label>
                              <div id="pesertaContainer" class="row g-2">
                                  <div class="col-12 text-muted small fst-italic">Silakan isi Jumlah Peserta di atas terlebih dahulu.</div>
                              </div>
                          </div>
                          <div class="col-md-5 mt-3">
                              <label class="form-label fw-bold small">Syarat Peserta (Link Drive)</label>
                              <input type="url" name="syarat_peserta" class="form-control rounded-3" placeholder="https://drive.google.com/...">
                          </div>
                          <div class="col-md-3 mt-3">
                              <label class="form-label fw-bold small">Status Syarat</label>
                              <select name="ket_syarat" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Lengkap">Lengkap</option>
                                  <option value="Belum">Belum</option>
                              </select>
                          </div>
                      </div>
                  </div>
              </div>

              
              <div class="card border-0 shadow-sm rounded-4 mb-4">
                  <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                      <h6 class="fw-bold text-success mb-0">2. Tim Eksekutor (Trainer & LSP)</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="row g-3">
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Nama Trainer</label>
                              <input type="text" name="nama_trainer" class="form-control rounded-3">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">WA Trainer</label>
                              <input type="text" name="wa_trainer" class="form-control rounded-3">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Upload CV Trainer (PDF)</label>
                              <div class="input-group">
                                  <input type="file" name="cv" id="add_cv" class="form-control rounded-start-3" accept=".pdf,.doc,.docx">
                                  <button type="button" class="btn btn-outline-danger rounded-end-3" onclick="document.getElementById('add_cv').value = ''" title="Batal unggah file">
                                      <i class="fas fa-times"></i>
                                  </button>
                              </div>
                          </div>
                          <!-- 
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Upload Modul</label>
                              <input type="file" name="modul" class="form-control rounded-3">
                          </div>
                          -->
                          <div class="col-12"><hr class="text-muted opacity-25"></div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Nama LSP</label>
                              <input type="text" name="nama_lsp" class="form-control rounded-3">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Kontak LSP</label>
                              <input type="text" name="kontak_lsp" class="form-control rounded-3">
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Tanggal Asesmen</label>
                              <input type="date" name="tanggal_asesmen" class="form-control rounded-3">
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Nama Asesor</label>
                              <input type="text" name="nama_asesor" class="form-control rounded-3">
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">WA Asesor</label>
                              <input type="text" name="wa_asesor" class="form-control rounded-3">
                          </div>
                      </div>
                  </div>
              </div>

              
              <div class="card border-0 shadow-sm rounded-4 mb-4">
                  <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                      <h6 class="fw-bold text-warning mb-0" style="color: #d97706 !important;">3. PIC & Status Sertifikasi</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="row g-3">
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">PIC Kegiatan</label>
                              <select name="pic" class="form-select rounded-3">
                                  <option value="">Pilih PIC...</option>
                                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <option value="<?php echo e($user->name); ?>"><?php echo e($user->nama_lengkap ?: $user->name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                          </div>

                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Laporan PIC (File)</label>
                              <div class="input-group">
                                  <input type="file" name="laporan_pic" id="add_laporan_pic" class="form-control rounded-start-3">
                                  <button type="button" class="btn btn-outline-danger rounded-end-3" onclick="document.getElementById('add_laporan_pic').value = ''" title="Batal unggah file">
                                      <i class="fas fa-times"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Status Kompeten</label>
                              <select name="status_kompeten" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Kompeten">Kompeten</option>
                                  <option value="Belum">Belum Kompeten</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Status Sertifikat</label>
                              <select name="status_sertif" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Sudah Terbit">Sudah Terbit</option>
                                  <option value="Belum Terbit">Belum Terbit</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Scan Sertif (File)</label>
                              <div class="input-group">
                                  <input type="file" name="scan_sertif" id="add_scan_sertif" class="form-control rounded-start-3">
                                  <button type="button" class="btn btn-outline-danger rounded-end-3" onclick="document.getElementById('add_scan_sertif').value = ''" title="Batal unggah file">
                                      <i class="fas fa-times"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="col-12">
                              <label class="form-label fw-bold small">Keterangan Tambahan</label>
                              <textarea name="keterangan_tambahan" class="form-control rounded-3" rows="2" placeholder="Catatan tambahan sertifikasi..."></textarea>
                          </div>
                      </div>
                  </div>
              </div>

              
              <div class="card border-0 shadow-sm rounded-4 mb-0">
                  <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                      <h6 class="fw-bold text-info mb-0">4. Informasi Pengiriman Paket</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="row g-3">
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Nama Penerima</label>
                              <input type="text" name="nama_penerima" class="form-control rounded-3">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">WA Penerima</label>
                              <input type="text" name="wa_penerima" class="form-control rounded-3">
                          </div>
                          <div class="col-md-12">
                              <label class="form-label fw-bold small">Alamat Lengkap</label>
                              <textarea name="alamat_pengiriman" class="form-control rounded-3" rows="2"></textarea>
                          </div>
                          <div class="col-md-12">
                              <label class="form-label fw-bold small">Isi Paket</label>
                              <textarea name="isi_paket" class="form-control rounded-3" rows="2" placeholder="Misal: 5 Modul, 5 Tas, Sertifikat Asli..."></textarea>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Status Pengiriman</label>
                              <select name="status_pengiriman" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Diproses">Diproses</option>
                                  <option value="Dikirim">Dikirim</option>
                                  <option value="Diterima">Diterima</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Tgl. Kirim</label>
                              <input type="date" name="tanggal_kirim" class="form-control rounded-3">
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Tgl. Diterima</label>
                              <input type="date" name="tanggal_diterima" class="form-control rounded-3">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Nomor Resi</label>
                              <input type="text" name="no_resi" class="form-control rounded-3" placeholder="Masukkan resi kurir...">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Foto Bukti (Upload)</label>
                              <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                          </div>
                          <div class="col-md-12 mt-4">
                              <label class="form-label fw-bold small">Catatan Akhir / Log</label>
                              <textarea name="catatan" class="form-control rounded-3" rows="2" placeholder="Catatan bebas..."></textarea>
                          </div>
                      </div>
                  </div>
              </div>

          </div>
          <div class="modal-footer bg-white border-top py-3 px-4 rounded-bottom-4">
            <button type="button" class="btn btn-light border rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fas fa-save me-2"></i> Simpan Data</button>
          </div>
      </form>
    </div>
  </div>
</div>


<?php $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $laporanLateText = '';
        if ($item->tanggal_selesai) {
            $tglSelesai = \Carbon\Carbon::parse($item->tanggal_selesai)->startOfDay();
            $uploadTime = \Carbon\Carbon::now();
            
            if ($item->laporan_pic) {
                $path = public_path($item->laporan_pic);
                $storagePath = storage_path('app/public/' . str_replace('storage/', '', $item->laporan_pic));
                
                if (file_exists($path)) {
                    $uploadTime = \Carbon\Carbon::createFromTimestamp(filemtime($path));
                } elseif (file_exists($storagePath)) {
                    $uploadTime = \Carbon\Carbon::createFromTimestamp(filemtime($storagePath));
                }
            }
            $uploadTime = $uploadTime->startOfDay();
            
            if (str_contains(strtoupper($item->jenis), 'BNSP') && $uploadTime->gt($tglSelesai->copy()->addDays(2))) {
                $laporanLateText = 'Terlambat, Laporan BNSP terakhir H+2';
            } elseif (str_contains(strtoupper($item->jenis), 'KEMNAKER') && $uploadTime->gt($tglSelesai->copy()->addDays(7))) {
                $laporanLateText = 'Terlambat, Laporan KEMNAKER terakhir H+7';
            }
        }
    ?>
    
    <div class="modal fade" id="detailModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                
                
                <?php
                    if (!function_exists('getFileUrl')) {
                        function getFileUrl($path) {
                            if (!$path) return '#';
                            if (str_starts_with($path, 'http')) return $path;
                            if (str_starts_with($path, 'uploads/operasional')) return asset($path);
                            if (str_starts_with($path, 'storage/')) return asset($path);
                            return asset('storage/' . $path);
                        }
                    }
                ?>
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-black text-dark"><i class="fas fa-file-invoice me-2 text-primary"></i> Detail Informasi Pelatihan</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                
                <div class="modal-body p-4">
                    
                    
                    <div class="bg-primary-subtle rounded-4 p-4 mb-4 position-relative overflow-hidden">
                        <button type="button" class="btn btn-sm btn-light border position-absolute rounded-pill px-3 shadow-sm" style="top: 15px; right: 15px; z-index: 2;" data-bs-toggle="modal" data-bs-target="#editInfoUmumModal<?php echo e($item->id); ?>"><i class="fas fa-edit text-primary"></i> Edit Info</button>
                        
                        <i class="fas fa-graduation-cap position-absolute text-primary" style="font-size: 8rem; right: -20px; bottom: -20px; opacity: 0.1;"></i>
                        <div class="position-relative z-1 text-start pe-5">
                            
                                <span class="badge bg-primary px-3 py-1 fs-6 rounded-pill shadow-sm"><?php echo e($item->jenis ?? 'N/A'); ?></span>
                                <span class="badge bg-white text-dark px-3 py-1 fs-6 rounded-pill shadow-sm border"><?php echo e($item->metode ?? 'N/A'); ?></span>
                            
                            <h4 class="fw-black text-dark mb-1 mt-2"><?php echo e($item->judul_pelatihan); ?></h4>
                            
                            <p class="text-primary mb-0 fw-bold">
                                <i class="fas fa-calendar-alt me-1"></i> <?php echo e(\Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y')); ?>

                            </p>
                        </div>
                    </div>

                    <div class="row g-4">
                        
                        <div class="col-lg-6">
                            
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-2 pb-2">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-building text-primary me-2"></i> Instansi & Peserta</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-primary py-1 px-2 rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#tambahPesertaModal<?php echo e($item->id); ?>"><i class="fas fa-plus"></i> Tambah</button>
                                        <button type="button" class="btn btn-sm btn-warning py-1 px-2 rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#editSemuaPesertaModal<?php echo e($item->id); ?>"><i class="fas fa-edit"></i> Edit Semua</button>
                                        <button type="button" class="btn btn-sm btn-light border py-1 px-2 rounded-3" data-bs-toggle="modal" data-bs-target="#editSyaratModal<?php echo e($item->id); ?>"><i class="fas fa-edit text-primary"></i> Edit Syarat</button>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="text-muted small fw-bold mb-1">Jumlah Peserta Terdaftar</div>
                                        <div class="fw-bolder text-dark"><span class="badge bg-warning text-dark px-2 py-1 fs-6 me-1"><?php echo e($item->jumlah_peserta ?? 0); ?></span> Orang</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-muted small fw-bold mb-1">Syarat Kelengkapan</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if($item->syarat_peserta): ?>
                                                <a href="<?php echo e($item->syarat_peserta); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3 py-0"><i class="fas fa-link me-1"></i> GDrive</a>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic small">Tidak ada link</span>
                                            <?php endif; ?>
                                            <span class="badge <?php echo e($item->ket_syarat == 'Lengkap' ? 'bg-success' : 'bg-danger'); ?> px-2 py-1 rounded-pill"><?php echo e($item->ket_syarat ?? 'Belum Lengkap'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="table-responsive border rounded-3">
                                            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 13px;">
                                                <thead class="bg-light text-muted">
                                                    <tr>
                                                        <th width="5%" class="text-center py-2">No</th>
                                                        <th class="py-2">Peserta</th>
                                                        <th class="py-2">Perusahaan/Instansi</th>
                                                        <th class="py-2">Marketing</th>
                                                        <th width="10%" class="text-center py-2">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $pesertas = $item->nama_peserta_array;
                                                        $instansis = $item->instansi_peserta_array;
                                                        $was = $item->wa_peserta_array;
                                                        $mkts = $item->marketing_array;
                                                    ?>
                                                    <?php $__empty_1 = true; $__currentLoopData = array_filter($pesertas, 'trim'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $peserta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td class="text-center text-muted"><?php echo e($i + 1); ?></td>
                                                        <td>
                                                            <div class="fw-bold text-dark"><?php echo e(trim($peserta)); ?></div>
                                                            <?php if(!empty(trim($was[$i] ?? ''))): ?>
                                                                <div class="text-success" style="font-size: 11px;"><i class="fab fa-whatsapp me-1"></i><?php echo e(trim($was[$i])); ?></div>
                                                            <?php else: ?>
                                                                <div class="text-muted" style="font-size: 11px;"><i class="fab fa-whatsapp me-1"></i>-</div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-muted"><?php echo e(!empty(trim($instansis[$i] ?? '')) ? trim($instansis[$i]) : '-'); ?></td>
                                                        <td><span class="badge bg-secondary-subtle text-secondary"><?php echo e(!empty(trim($mkts[$i] ?? '')) ? trim($mkts[$i]) : '-'); ?></span></td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center gap-1">
                                                                <button type="button" class="btn btn-sm btn-light border shadow-sm rounded-3 py-1 px-2" title="Edit Peserta" data-bs-toggle="modal" data-bs-target="#editPesertaModal<?php echo e($item->id); ?>_<?php echo e($i); ?>">
                                                                    <i class="fas fa-edit text-primary"></i>
                                                                </button>
                                                                <form action="<?php echo e(route('riwayat.pelatihan.hapusPeserta', ['id' => $item->id, 'index' => $i])); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini?');">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm rounded-3 py-1 px-2" title="Hapus Peserta">
                                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-3 fst-italic">Belum ada rincian data peserta.</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-2 pb-2">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-users-cog text-success me-2"></i> Tim Eksekutor</h6>
                                    <button type="button" class="btn btn-sm btn-light border py-1 px-2 rounded-3" data-bs-toggle="modal" data-bs-target="#editTimModal<?php echo e($item->id); ?>"><i class="fas fa-edit text-success"></i> Edit Tim</button>
                                </div>
                                <div class="bg-light rounded-4 p-4 border">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-bold mb-1">Trainer</div>
                                            <div class="fw-bold text-dark"><?php echo e($item->nama_trainer ?? '-'); ?></div>
                                            <?php if(!empty($item->wa_trainer)): ?>
                                                <div class="text-success small fw-bold mb-1"><i class="fab fa-whatsapp"></i> <?php echo e($item->wa_trainer); ?></div>
                                            <?php endif; ?>
                                            <div class="mt-2 d-flex flex-wrap gap-1">
                                                <?php if($item->cv): ?>
                                                    <a href="<?php echo e(getFileUrl($item->cv)); ?>" target="_blank" class="badge bg-danger text-white text-decoration-none px-2 py-1"><i class="fas fa-file-pdf me-1"></i> CV Trainer</a>
                                                <?php endif; ?>
                                                <!--
                                                <?php if($item->modul): ?>
                                                    <a href="<?php echo e(getFileUrl($item->modul)); ?>" target="_blank" class="badge bg-primary text-white text-decoration-none px-2 py-1"><i class="fas fa-file-download me-1"></i> Modul</a>
                                                <?php endif; ?>
                                                -->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-bold mb-1">LSP & Asesor</div>
                                            <div class="fw-bold text-dark mb-1"><?php echo e($item->nama_asesor ?? '-'); ?>

                                                <?php if(!empty($item->wa_asesor)): ?>
                                                    <span class="text-success small fw-bold ms-1"><i class="fab fa-whatsapp"></i> <?php echo e($item->wa_asesor); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-muted small fw-bold"><i class="fas fa-building"></i> <?php echo e($item->nama_lsp ?? '-'); ?>

                                                <?php if(!empty($item->kontak_lsp)): ?>
                                                    <span class="ms-1 fw-normal">(<?php echo e($item->kontak_lsp); ?>)</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-12 border-top my-2"></div>
                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-bold mb-1">PIC Kegiatan</div>
                                            <div class="fw-bolder text-primary fs-6"><?php echo e(\App\Models\User::where('name', $item->pic)->value('nama_lengkap') ?: ($item->pic ?? '-')); ?></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-bold mb-1">Tanggal Asesmen</div>
                                            <div class="fw-bold text-dark"><?php echo e($item->tanggal_asesmen ? \Carbon\Carbon::parse($item->tanggal_asesmen)->format('d M Y') : '-'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        
                        <div class="col-lg-6">
                            
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-2 pb-2">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-award text-warning me-2"></i> Sertifikasi & Berkas Lengkap</h6>
                                    <button type="button" class="btn btn-sm btn-light border py-1 px-2 rounded-3" data-bs-toggle="modal" data-bs-target="#editSertifikasiModal<?php echo e($item->id); ?>"><i class="fas fa-edit text-warning"></i> Edit Sertifikasi</button>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-4">
                                        <div class="text-muted small fw-bold mb-2">Status Kompetensi</div>
                                        <div>
                                            <?php if($item->status_kompeten == 'Kompeten'): ?>
                                                <span class="badge bg-success-subtle text-success px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-check-circle me-1"></i> Kompeten</span>
                                            <?php elseif($item->status_kompeten == 'Belum'): ?>
                                                <span class="badge bg-danger-subtle text-danger px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-times-circle me-1"></i> Belum Kompeten</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-minus-circle me-1"></i> Belum Asesmen</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="text-muted small fw-bold mb-2">Status Sertifikat</div>
                                        <div>
                                            <?php if($item->status_sertif == 'Sudah Terbit'): ?>
                                                <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-certificate me-1"></i> Telah Terbit</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-clock me-1"></i> Masih Pending</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="text-muted small fw-bold mb-2">Status Pengiriman</div>
                                        <div>
                                            <?php if($item->status_pengiriman == 'Dikirim'): ?>
                                                <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-truck me-1"></i> Dikirim</span>
                                            <?php elseif($item->status_pengiriman == 'Diterima'): ?>
                                                <span class="badge bg-success-subtle text-success px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-box-open me-1"></i> Diterima</span>
                                            <?php elseif($item->status_pengiriman == 'Diproses'): ?>
                                                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-box me-1"></i> Diproses</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-minus-circle me-1"></i> Belum Info</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-muted small fw-bold mb-2 mt-4">Unduh Berkas Pendukung</div>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- <?php if($item->modul): ?><a href="<?php echo e(getFileUrl($item->modul)); ?>" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-book text-primary me-1"></i> Modul</a><?php endif; ?> -->
                                    
                                    <?php if($item->laporan_pic): ?>
                                        <a href="<?php echo e(getFileUrl($item->laporan_pic)); ?>" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3">
                                            <i class="fas fa-file-alt text-success me-1"></i> Laporan
                                            <?php if($laporanLateText): ?>
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning ms-1" style="font-size: 0.65rem;"><?php echo e($laporanLateText); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    <?php elseif($laporanLateText): ?>
                                        <span class="btn btn-sm bg-warning-subtle text-warning-emphasis border border-warning fw-bold px-3"><i class="fas fa-exclamation-triangle me-1"></i> <?php echo e($laporanLateText); ?></span>
                                    <?php endif; ?>
                                    <?php if($item->scan_sertif): ?><a href="<?php echo e(getFileUrl($item->scan_sertif)); ?>" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-award text-warning me-1"></i> Scan Sertif</a><?php endif; ?>
                                    <?php if($item->bukti_kompeten): ?><a href="<?php echo e(getFileUrl($item->bukti_kompeten)); ?>" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-check-circle text-info me-1"></i> Bukti Kompeten</a><?php endif; ?>
                                    
                                    <?php if(!$item->modul && !$item->laporan_pic && !$item->scan_sertif && !$item->bukti_kompeten && !$laporanLateText): ?>
                                        <span class="text-muted fst-italic bg-light px-3 py-2 rounded-3 w-100 text-center border">Belum ada berkas yang diunggah.</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-2 pb-2">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-truck-fast text-info me-2"></i> Logistik & Pengiriman</h6>
                                    <button type="button" class="btn btn-sm btn-light border py-1 px-2 rounded-3" data-bs-toggle="modal" data-bs-target="#editLogistikModal<?php echo e($item->id); ?>"><i class="fas fa-edit text-info"></i> Edit Logistik</button>
                                </div>
                                <div class="bg-info-subtle border border-info border-opacity-25 rounded-4 p-4 position-relative">
                                    <i class="fas fa-box-open position-absolute text-info opacity-25" style="font-size: 5rem; right: 10px; bottom: 10px;"></i>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3 position-relative z-1">
                                        <div>
                                            <div class="text-info-emphasis small fw-bold mb-1">Status Paket</div>
                                            <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm"><?php echo e($item->status_pengiriman ?? 'Belum Info'); ?></span>
                                        </div>
                                        <div class="text-end">
                                            <div class="text-info-emphasis small fw-bold mb-1">Nomor Resi</div>
                                            <div class="fw-black text-dark fs-5 bg-white px-3 py-1 rounded-3 shadow-sm border"><?php echo e($item->no_resi ?? '-'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 small position-relative z-1 mt-1">
                                        <div class="col-12">
                                            <div class="text-info-emphasis fw-bold">Penerima & Alamat:</div>
                                            <div class="fw-bold text-dark"><i class="fas fa-user-circle me-1 text-info"></i> <?php echo e($item->nama_penerima ?? '-'); ?> <span class="text-muted fw-normal">(<?php echo e($item->wa_penerima ?? '-'); ?>)</span></div>
                                            <div class="text-dark mt-1"><i class="fas fa-map-marker-alt me-1 text-danger"></i> <?php echo e($item->alamat_pengiriman ?? '-'); ?></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-info-emphasis fw-bold">Isi Paket:</div>
                                            <div class="text-dark"><?php echo e($item->isi_paket ?? '-'); ?></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-info-emphasis fw-bold">Tanggal Proses:</div>
                                            <div class="text-dark"><?php echo e($item->tanggal_kirim ? \Carbon\Carbon::parse($item->tanggal_kirim)->format('d M Y') : '-'); ?> <i class="fas fa-arrow-right mx-1 text-muted"></i> <?php echo e($item->tanggal_diterima ? \Carbon\Carbon::parse($item->tanggal_diterima)->format('d M Y') : 'Belum Diterima'); ?></div>
                                        </div>
                                        
                                        <?php if($item->foto): ?>
                                        <div class="col-12 mt-3">
                                            <a href="<?php echo e(getFileUrl($item->foto)); ?>" target="_blank" class="btn btn-info text-white rounded-pill px-4 fw-bold shadow-sm w-100"><i class="fas fa-image me-2"></i> Lihat Foto Bukti Resi</a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    
                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-camera-retro text-primary me-2"></i> Dokumentasi Pelatihan</h6>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($item->id); ?>">
                                <i class="fas fa-images me-1"></i> Lihat Galeri & Upload
                            </button>
                        </div>
                        <div class="bg-light rounded-4 p-4 text-center border">
                            <?php
                                $dokumentasiCount = is_array($item->dokumentasi) ? count($item->dokumentasi) : 0;
                            ?>
                            <?php if($dokumentasiCount > 0): ?>
                                <div class="fs-1 text-primary mb-2"><i class="fas fa-photo-video"></i></div>
                                <h5 class="fw-bold text-dark"><?php echo e($dokumentasiCount); ?> File Dokumentasi Tersedia</h5>
                                <p class="text-muted small mb-0">Klik tombol di atas untuk melihat atau mengelola galeri foto dan video kegiatan.</p>
                            <?php else: ?>
                                <div class="fs-1 text-muted mb-2 opacity-50"><i class="fas fa-folder-open"></i></div>
                                <h6 class="fw-bold text-muted">Belum Ada Dokumentasi</h6>
                                <p class="text-muted small mb-0">Anda bisa menambahkan hingga 15 foto/video kegiatan.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if($item->catatan || $item->keterangan_tambahan): ?>
                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex align-items-start bg-warning-subtle p-3 rounded-4 border border-warning border-opacity-25">
                            <div class="text-warning fs-2 me-3"><i class="fas fa-sticky-note mt-1"></i></div>
                            <div>
                                <h6 class="fw-bolder text-dark mb-2">Catatan Khusus Pelatihan</h6>
                                <?php if($item->keterangan_tambahan): ?><p class="small text-dark mb-1"><strong>Sertifikasi:</strong> <?php echo e($item->keterangan_tambahan); ?></p><?php endif; ?>
                                <?php if($item->catatan): ?><p class="small text-dark mb-0"><strong>Logistik:</strong> <?php echo e($item->catatan); ?></p><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                
                
                <div class="modal-footer bg-light border-top-0 py-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-lg rounded-pill px-5 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="galeriModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-black text-dark"><i class="fas fa-images me-2 text-primary"></i> Galeri Dokumentasi Kegiatan</h5>
                    <?php
                        $dokumentasi = is_array($item->dokumentasi) ? $item->dokumentasi : [];
                    ?>
                    <div class="d-flex align-items-center">
                        <?php if(count($dokumentasi) > 0): ?>
                            <a href="<?php echo e(route('riwayat.pelatihan.downloadDokumentasiZip', $item->id)); ?>" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm me-3">
                                <i class="fas fa-file-archive me-1"></i> Download ZIP
                            </a>
                        <?php endif; ?>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-4 bg-light">
                    
                    <div id="galeriContainer<?php echo e($item->id); ?>">
                        <?php if(count($dokumentasi) > 0): ?>
                            <div class="row g-3 mb-4" id="galeriGrid<?php echo e($item->id); ?>">
                                <?php $__currentLoopData = $dokumentasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                                            <?php
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $isVideo = in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                                                $url = getFileUrl($file);
                                            ?>
                                            
                                            <?php if($isVideo): ?>
                                                <video src="<?php echo e($url); ?>" class="w-100 h-100 object-fit-cover" controls style="min-height: 150px; max-height: 150px;"></video>
                                            <?php else: ?>
                                                <a href="<?php echo e($url); ?>" target="_blank">
                                                    <img src="<?php echo e($url); ?>" class="w-100 h-100 object-fit-cover" style="min-height: 150px; max-height: 150px;" alt="Dokumentasi">
                                                </a>
                                            <?php endif; ?>
                                            
                                            
                                            <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm position-absolute" 
                                                onclick="hapusDokumentasi(this, '<?php echo e(route('riwayat.pelatihan.deleteDokumentasi', ['id' => $item->id, 'index' => $i])); ?>')"
                                                style="top: 10px; right: 10px; z-index: 2; width: 30px; height: 30px; padding: 0; line-height: 1;"
                                                title="Hapus file">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="row g-3 mb-4" id="galeriGrid<?php echo e($item->id); ?>" style="display: none;"></div>
                            <div class="text-center py-5 mb-4" id="galeriEmpty<?php echo e($item->id); ?>">
                                <i class="fas fa-folder-open text-muted opacity-25" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada foto/video dokumentasi.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="card border border-primary border-opacity-25 rounded-4 shadow-sm">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-cloud-upload-alt text-primary me-2"></i> Tambah Dokumentasi Baru</h6>
                            <form id="formUploadDokumentasi<?php echo e($item->id); ?>" action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST" enctype="multipart/form-data" onsubmit="uploadDokumentasiAjax(event, this, <?php echo e($item->id); ?>, '<?php echo e(route('riwayat.pelatihan.deleteDokumentasi', ['id' => $item->id, 'index' => '__INDEX__'])); ?>')">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="block" value="dokumentasi">
                                
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Pilih File (Bisa pilih berulang kali. Foto max 5MB, Video max 20MB)</label>
                                    <input type="file" id="dokumentasiInput<?php echo e($item->id); ?>" class="form-control rounded-3" multiple accept="image/*,video/*" onchange="handleFileSelect(event, <?php echo e($item->id); ?>)">
                                    <div id="fileQueuePreview<?php echo e($item->id); ?>" class="mt-2 d-flex flex-wrap gap-2"></div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" id="btnSubmitUpload<?php echo e($item->id); ?>">
                                        <i class="fas fa-upload me-1"></i> Upload File
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top-0 py-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup Galeri</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editInfoUmumModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-primary me-2"></i> Edit Info Umum</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="info_umum">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Judul Pelatihan</label>
                            <input type="text" name="judul_pelatihan" class="form-control rounded-3" value="<?php echo e($item->judul_pelatihan); ?>" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control rounded-3" value="<?php echo e($item->tanggal_mulai); ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control rounded-3" value="<?php echo e($item->tanggal_selesai); ?>" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Jenis</label>
                                <select name="jenis" class="form-select rounded-3">
                                    <option value="Sertifikat KEMNAKER" <?php echo e($item->jenis == 'Sertifikat KEMNAKER' ? 'selected' : ''); ?>>Sertifikat KEMNAKER</option>
                                    <option value="Sertifikat BNSP" <?php echo e($item->jenis == 'Sertifikat BNSP' ? 'selected' : ''); ?>>Sertifikat BNSP</option>
                                    <option value="UPSKILLS" <?php echo e($item->jenis == 'UPSKILLS' ? 'selected' : ''); ?>>UPSKILLS</option>
                                    <option value="Sertifikat Internal" <?php echo e($item->jenis == 'Sertifikat Internal' ? 'selected' : ''); ?>>Sertifikat Internal</option>
                                    <option value="Pembuatan & Perpanjangan SIO" <?php echo e($item->jenis == 'Pembuatan & Perpanjangan SIO' ? 'selected' : ''); ?>>Pembuatan & Perpanjangan SIO</option>
                                    <option value="Riksa Uji Alat" <?php echo e($item->jenis == 'Riksa Uji Alat' ? 'selected' : ''); ?>>Riksa Uji Alat</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Metode</label>
                                <select name="metode" class="form-select rounded-3">
                                    <option value="Online Training" <?php echo e($item->metode == 'Online Training' ? 'selected' : ''); ?>>Online Training</option>
                                    <option value="Offline Training" <?php echo e($item->metode == 'Offline Training' ? 'selected' : ''); ?>>Offline Training</option>
                                    <option value="Blended Training" <?php echo e($item->metode == 'Blended Training' ? 'selected' : ''); ?>>Blended Training</option>
                                    <option value="Inhouse Training" <?php echo e($item->metode == 'Inhouse Training' ? 'selected' : ''); ?>>Inhouse Training</option>
                                    <option value="Public Training" <?php echo e($item->metode == 'Public Training' ? 'selected' : ''); ?>>Public Training</option>
                                    <option value="Titip Vendor Lain" <?php echo e($item->metode == 'Titip Vendor Lain' ? 'selected' : ''); ?>>Titip Vendor Lain</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editSyaratModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-primary me-2"></i> Edit Syarat Kelengkapan</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="syarat">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Link Syarat Peserta (GDrive)</label>
                            <input type="url" name="syarat_peserta" class="form-control rounded-3" value="<?php echo e($item->syarat_peserta); ?>">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Keterangan Syarat</label>
                            <select name="ket_syarat" class="form-select rounded-3">
                                <option value="Lengkap" <?php echo e($item->ket_syarat == 'Lengkap' ? 'selected' : ''); ?>>Lengkap</option>
                                <option value="Belum" <?php echo e($item->ket_syarat == 'Belum' ? 'selected' : ''); ?>>Belum Lengkap</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editTimModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-success me-2"></i> Edit Tim Eksekutor</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="tim">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Trainer</label>
                                <input type="text" name="nama_trainer" class="form-control rounded-3" value="<?php echo e($item->nama_trainer); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">WA Trainer</label>
                                <input type="text" name="wa_trainer" class="form-control rounded-3" value="<?php echo e($item->wa_trainer); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Upload CV Trainer (PDF)</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" name="cv" id="cv_<?php echo e($item->id); ?>" class="form-control" accept=".pdf,.doc,.docx">
                                    <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('cv_<?php echo e($item->id); ?>').value = ''" title="Batal unggah file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <?php if($item->cv): ?>
                                    <div class="d-flex align-items-center mt-1">
                                        <a href="<?php echo e(getFileUrl($item->cv)); ?>" target="_blank" class="small text-primary me-3"><i class="fas fa-file-pdf me-1"></i> Lihat CV</a>
                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="checkbox" name="delete_cv" value="1" id="delete_cv_<?php echo e($item->id); ?>">
                                            <label class="form-check-label small text-danger" for="delete_cv_<?php echo e($item->id); ?>"><i class="fas fa-trash-alt"></i> Hapus</label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!--
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Upload Modul</label>
                                <input type="file" name="modul" class="form-control rounded-3">
                                <?php if($item->modul): ?>
                                    <div class="small mt-1 text-success"><i class="fas fa-check-circle"></i> File sudah ada. Abaikan jika tidak diubah.</div>
                                <?php endif; ?>
                            </div>
                            -->
                            <div class="col-12"><hr class="text-muted opacity-25"></div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama LSP</label>
                                <input type="text" name="nama_lsp" class="form-control rounded-3" value="<?php echo e($item->nama_lsp); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Kontak LSP</label>
                                <input type="text" name="kontak_lsp" class="form-control rounded-3" value="<?php echo e($item->kontak_lsp); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Asesor</label>
                                <input type="text" name="nama_asesor" class="form-control rounded-3" value="<?php echo e($item->nama_asesor); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">WA Asesor</label>
                                <input type="text" name="wa_asesor" class="form-control rounded-3" value="<?php echo e($item->wa_asesor); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">PIC Kegiatan</label>
                                <select name="pic" class="form-select rounded-3">
                                    <option value="">Pilih...</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($usr->name); ?>" <?php echo e($item->pic == $usr->name ? 'selected' : ''); ?>><?php echo e($usr->nama_lengkap ?: $usr->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Asesmen</label>
                                <input type="date" name="tanggal_asesmen" class="form-control rounded-3" value="<?php echo e($item->tanggal_asesmen); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editSertifikasiModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-warning me-2"></i> Edit Sertifikasi</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="sertifikasi">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Kompeten</label>
                            <select name="status_kompeten" class="form-select rounded-3" onchange="toggleBuktiKompeten(this, <?php echo e($item->id); ?>)">
                                <option value="" <?php echo e(empty($item->status_kompeten) ? 'selected' : ''); ?>>Pilih...</option>
                                <option value="Kompeten" <?php echo e($item->status_kompeten == 'Kompeten' ? 'selected' : ''); ?>>Kompeten</option>
                                <option value="Belum" <?php echo e($item->status_kompeten == 'Belum' ? 'selected' : ''); ?>>Belum Kompeten</option>
                            </select>
                        </div>
                        <div class="mb-3" id="bukti-kompeten-container-<?php echo e($item->id); ?>" style="display: <?php echo e($item->status_kompeten == 'Kompeten' ? 'block' : 'none'); ?>;">
                            <label class="form-label small fw-bold">Upload Bukti Kompeten (PDF, Maks 30MB)</label>
                            <input type="file" name="bukti_kompeten" class="form-control form-control-sm" accept=".pdf">
                            <?php if($item->bukti_kompeten): ?>
                                <div class="d-flex align-items-center mt-1">
                                    <a href="<?php echo e(getFileUrl($item->bukti_kompeten)); ?>" target="_blank" class="small text-primary me-3"><i class="fas fa-file-pdf me-1"></i> Lihat Bukti Saat Ini</a>
                                    <span class="small text-success"><i class="fas fa-check-circle me-1"></i> Sudah diunggah (Kosongkan jika tidak diubah)</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Sertifikat</label>
                            <select name="status_sertif" class="form-select rounded-3">
                                <option value="" <?php echo e(empty($item->status_sertif) ? 'selected' : ''); ?>>Pilih...</option>
                                <option value="Sudah Terbit" <?php echo e($item->status_sertif == 'Sudah Terbit' ? 'selected' : ''); ?>>Sudah Terbit</option>
                                <option value="Belum Terbit" <?php echo e($item->status_sertif == 'Belum Terbit' ? 'selected' : ''); ?>>Belum Terbit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Pengiriman Sertifikat</label>
                            <select name="status_pengiriman" class="form-select rounded-3">
                                <option value="" <?php echo e(empty($item->status_pengiriman) ? 'selected' : ''); ?>>Pilih...</option>
                                <option value="Diproses" <?php echo e($item->status_pengiriman == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                                <option value="Dikirim" <?php echo e($item->status_pengiriman == 'Dikirim' ? 'selected' : ''); ?>>Dikirim</option>
                                <option value="Diterima" <?php echo e($item->status_pengiriman == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Upload Berkas Tambahan</label>
                            <div class="mb-3">
                                <label class="small text-muted">Scan Sertifikat (PDF, Maks 30MB)</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" name="scan_sertif" id="scan_sertif_<?php echo e($item->id); ?>" class="form-control" accept=".pdf">
                                    <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('scan_sertif_<?php echo e($item->id); ?>').value = ''" title="Batal unggah file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <?php if($item->scan_sertif): ?>
                                    <div class="d-flex align-items-center mt-1">
                                        <a href="<?php echo e(getFileUrl($item->scan_sertif)); ?>" target="_blank" class="small text-primary me-3"><i class="fas fa-file-pdf me-1"></i> Lihat Sertifikat Saat Ini</a>
                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="checkbox" name="delete_scan_sertif" value="1" id="delete_scan_sertif_<?php echo e($item->id); ?>">
                                            <label class="form-check-label small text-danger" for="delete_scan_sertif_<?php echo e($item->id); ?>"><i class="fas fa-trash-alt"></i> Hapus file</label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-2">
                                <label class="small text-muted">Laporan PIC (PDF, Maks 30MB)</label>
                                <div class="input-group input-group-sm">
                                    <input type="file" name="laporan_pic" id="laporan_pic_<?php echo e($item->id); ?>" class="form-control" accept=".pdf">
                                    <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('laporan_pic_<?php echo e($item->id); ?>').value = ''" title="Batal unggah file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <?php if($item->laporan_pic): ?>
                                    <div class="d-flex align-items-center mt-1">
                                        <a href="<?php echo e(getFileUrl($item->laporan_pic)); ?>" target="_blank" class="small text-primary me-3"><i class="fas fa-file-pdf me-1"></i> Lihat Laporan Saat Ini</a>
                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="checkbox" name="delete_laporan_pic" value="1" id="delete_laporan_pic_<?php echo e($item->id); ?>">
                                            <label class="form-check-label small text-danger" for="delete_laporan_pic_<?php echo e($item->id); ?>"><i class="fas fa-trash-alt"></i> Hapus file</label>
                                        </div>
                                        <?php if($laporanLateText): ?>
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning ms-2"><i class="fas fa-exclamation-triangle"></i> <?php echo e($laporanLateText); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif($laporanLateText): ?>
                                    <div class="mt-1">
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning"><i class="fas fa-exclamation-triangle"></i> <?php echo e($laporanLateText); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control rounded-3" rows="2"><?php echo e($item->keterangan_tambahan); ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editLogistikModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-info me-2"></i> Edit Logistik & Pengiriman</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="logistik">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Penerima</label>
                                <input type="text" name="nama_penerima" class="form-control rounded-3" value="<?php echo e($item->nama_penerima); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">WA Penerima</label>
                                <input type="text" name="wa_penerima" class="form-control rounded-3" value="<?php echo e($item->wa_penerima); ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat_pengiriman" class="form-control rounded-3" rows="2"><?php echo e($item->alamat_pengiriman); ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Isi Paket</label>
                                <textarea name="isi_paket" class="form-control rounded-3" rows="2"><?php echo e($item->isi_paket); ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Status Pengiriman</label>
                                <select name="status_pengiriman" class="form-select rounded-3">
                                    <option value="" <?php echo e(empty($item->status_pengiriman) ? 'selected' : ''); ?>>Pilih...</option>
                                    <option value="Diproses" <?php echo e($item->status_pengiriman == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                                    <option value="Dikirim" <?php echo e($item->status_pengiriman == 'Dikirim' ? 'selected' : ''); ?>>Dikirim</option>
                                    <option value="Diterima" <?php echo e($item->status_pengiriman == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Tanggal Kirim</label>
                                <input type="date" name="tanggal_kirim" class="form-control rounded-3" value="<?php echo e($item->tanggal_kirim); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Tanggal Diterima</label>
                                <input type="date" name="tanggal_diterima" class="form-control rounded-3" value="<?php echo e($item->tanggal_diterima); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">No Resi</label>
                                <input type="text" name="no_resi" class="form-control rounded-3" value="<?php echo e($item->no_resi); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Foto Bukti / Resi (Maks 2MB)</label>
                                <input type="file" name="foto" class="form-control rounded-3" accept="image/*,.pdf">
                                <?php if($item->foto): ?>
                                    <div class="d-flex align-items-center mt-1">
                                        <a href="<?php echo e(getFileUrl($item->foto)); ?>" target="_blank" class="small text-primary me-3"><i class="fas fa-image me-1"></i> Lihat Foto Saat Ini</a>
                                        <span class="small text-success"><i class="fas fa-check-circle me-1"></i> Sudah diunggah (Kosongkan jika tidak diubah)</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Catatan Logistik</label>
                                <textarea name="catatan" class="form-control rounded-3" rows="1"><?php echo e($item->catatan); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <?php
        $pesertas = explode(',', $item->nama_peserta ?? '');
        $instansis = explode(',', $item->instansi_peserta ?? '');
        $was = explode(',', $item->wa_peserta ?? '');
        $mkts = explode(',', $item->marketing ?? '');
    ?>

    
    <div class="modal fade" id="tambahPesertaModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-user-plus text-primary me-2"></i> Tambah Peserta Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.tambahPesertaMassal', $item->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body p-4" style="max-height: 60vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-success"><i class="fas fa-file-excel me-1"></i> Auto-Fill dari Excel (Opsional)</label>
                            <textarea id="pasteExcel<?php echo e($item->id); ?>" class="form-control rounded-3" rows="2" placeholder="Copy baris dari Excel lalu Paste di sini...&#10;Urutan Kolom: [Nama] [Instansi] [No WA] [Marketing]"></textarea>
                            <small class="text-muted" style="font-size: 11px;">*Maksimal 50 baris sekaligus. Data akan otomatis terisi ke bawah.</small>
                        </div>
                        <div class="mb-3 d-flex align-items-center gap-3 bg-light p-3 rounded-3 border">
                            <label class="form-label fw-bold mb-0">Jumlah Peserta Ditambahkan:</label>
                            <input type="number" id="inputTambahPeserta<?php echo e($item->id); ?>" class="form-control text-center rounded-3 fw-bold" style="width: 80px;" value="1" min="1" max="50">
                        </div>
                        <div id="tambahPesertaContainer<?php echo e($item->id); ?>">
                            <div class="border p-3 rounded-3 mb-2 bg-white shadow-sm">
                                <h6 class="fw-bold mb-2 small text-secondary">Peserta Tambahan 1</h6>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <input type="text" name="nama_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="Nama" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="instansi_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="Instansi">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="wa_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="WA">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="marketing[]" class="form-select rounded-3 form-control-sm">
                                            <option value="">Marketing...</option>
                                            <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($mkt->name); ?>"><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const inputPeserta = document.getElementById('inputTambahPeserta<?php echo e($item->id); ?>');
                                const pasteExcel = document.getElementById('pasteExcel<?php echo e($item->id); ?>');
                                
                                pasteExcel.addEventListener('paste', function(e) {
                                    e.preventDefault();
                                    let pasteData = (e.clipboardData || window.clipboardData).getData('text');
                                    let rows = pasteData.trim().split('\n');
                                    if(rows.length > 0) {
                                        let num = rows.length > 50 ? 50 : rows.length;
                                        inputPeserta.value = num;
                                        inputPeserta.dispatchEvent(new Event('input'));
                                        
                                        setTimeout(() => {
                                            let container = document.getElementById('tambahPesertaContainer<?php echo e($item->id); ?>');
                                            let namaInputs = container.querySelectorAll('input[name="nama_peserta[]"]');
                                            let instansiInputs = container.querySelectorAll('input[name="instansi_peserta[]"]');
                                            let waInputs = container.querySelectorAll('input[name="wa_peserta[]"]');
                                            let mktInputs = container.querySelectorAll('select[name="marketing[]"]');

                                            for(let i=0; i<num; i++) {
                                                let cols = rows[i].split('\t');
                                                if(namaInputs[i]) namaInputs[i].value = cols[0] ? cols[0].trim() : '';
                                                if(instansiInputs[i]) instansiInputs[i].value = cols[1] ? cols[1].trim() : '';
                                                if(waInputs[i]) waInputs[i].value = cols[2] ? cols[2].trim() : '';
                                                if(mktInputs[i] && cols[3]) {
                                                    let mktName = cols[3].trim().toLowerCase();
                                                    for(let opt of mktInputs[i].options) {
                                                        if(opt.text.toLowerCase().includes(mktName) || opt.value.toLowerCase() === mktName) {
                                                            mktInputs[i].value = opt.value;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }, 100);
                                    }
                                });

                                inputPeserta.addEventListener('input', function() {
                                    let num = parseInt(this.value) || 0;
                                    if(num > 50) num = 50; // max 50 for safety
                                    let container = document.getElementById('tambahPesertaContainer<?php echo e($item->id); ?>');
                                    container.innerHTML = '';
                                    let marketingOpts = `<option value="">Marketing...</option>`;
                                    <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        marketingOpts += `<option value="<?php echo e($mkt->name); ?>"><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>`;
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    if(num > 0) {
                                        for(let i=1; i<=num; i++) {
                                            container.innerHTML += `
                                                <div class="border p-3 rounded-3 mb-2 bg-white shadow-sm">
                                                    <h6 class="fw-bold mb-2 small text-secondary">Peserta Tambahan ${i}</h6>
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <input type="text" name="nama_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="Nama" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="instansi_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="Instansi">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="wa_peserta[]" class="form-control rounded-3 form-control-sm" placeholder="WA">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select name="marketing[]" class="form-select rounded-3 form-control-sm">
                                                                ${marketingOpts}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Tambahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editSemuaPesertaModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-users-cog text-warning me-2"></i> Edit Semua Peserta</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.update', $item->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="block" value="peserta">
                    <div class="modal-body p-4" style="max-height: 65vh; overflow-y: auto;">
                        <div class="alert alert-warning border-0 rounded-3 small">
                            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Perhatian:</strong> Perubahan di sini akan menimpa seluruh data peserta yang ada. Anda bisa menambah, mengubah, atau menghapus baris di bawah ini.
                        </div>
                        
                        <div class="table-responsive border rounded-3 mb-3">
                            <table class="table table-sm table-borderless align-middle mb-0" id="editSemuaTable<?php echo e($item->id); ?>">
                                <thead class="bg-light text-muted" style="font-size: 13px;">
                                    <tr>
                                        <th width="30%" class="py-2 px-3">Nama Peserta</th>
                                        <th width="25%" class="py-2 px-3">Perusahaan/Instansi</th>
                                        <th width="20%" class="py-2 px-3">WhatsApp</th>
                                        <th width="20%" class="py-2 px-3">Marketing</th>
                                        <th width="5%" class="text-center py-2 px-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="editSemuaTbody<?php echo e($item->id); ?>">
                                    <?php
                                        $editPesertas = $item->nama_peserta_array;
                                        $editInstansis = $item->instansi_peserta_array;
                                        $editWas = $item->wa_peserta_array;
                                        $editMkts = $item->marketing_array;
                                        
                                        $validPesertas = [];
                                        foreach($editPesertas as $idx => $p) {
                                            if(trim($p) !== '') {
                                                $validPesertas[] = [
                                                    'nama' => trim($p),
                                                    'instansi' => trim($editInstansis[$idx] ?? ''),
                                                    'wa' => trim($editWas[$idx] ?? ''),
                                                    'marketing' => trim($editMkts[$idx] ?? ''),
                                                ];
                                            }
                                        }
                                        if(count($validPesertas) == 0) {
                                            $validPesertas[] = ['nama' => '', 'instansi' => '', 'wa' => '', 'marketing' => ''];
                                        }
                                    ?>
                                    
                                    <?php $__currentLoopData = $validPesertas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="peserta-row">
                                        <td class="px-3 py-2"><input type="text" name="nama_peserta[]" class="form-control rounded-3 form-control-sm" value="<?php echo e($p['nama']); ?>" required></td>
                                        <td class="px-3 py-2"><input type="text" name="instansi_peserta[]" class="form-control rounded-3 form-control-sm" value="<?php echo e($p['instansi']); ?>"></td>
                                        <td class="px-3 py-2"><input type="text" name="wa_peserta[]" class="form-control rounded-3 form-control-sm" value="<?php echo e($p['wa']); ?>"></td>
                                        <td class="px-3 py-2">
                                            <select name="marketing[]" class="form-select rounded-3 form-control-sm">
                                                <option value="">Pilih...</option>
                                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($mkt->name); ?>" <?php echo e($p['marketing'] == $mkt->name ? 'selected' : ''); ?>><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button type="button" class="btn btn-sm btn-light border text-danger rounded-3 btn-remove-row" title="Hapus Baris"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btnTambahBaris<?php echo e($item->id); ?>">
                            <i class="fas fa-plus me-1"></i> Tambah Baris
                        </button>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnTambah = document.getElementById('btnTambahBaris<?php echo e($item->id); ?>');
            if (btnTambah) {
                btnTambah.addEventListener('click', function() {
                    const tbody = document.getElementById('editSemuaTbody<?php echo e($item->id); ?>');
                    const tr = document.createElement('tr');
                    tr.className = 'peserta-row';
                    tr.innerHTML = `
                        <td class="px-3 py-2"><input type="text" name="nama_peserta[]" class="form-control rounded-3 form-control-sm" required></td>
                        <td class="px-3 py-2"><input type="text" name="instansi_peserta[]" class="form-control rounded-3 form-control-sm"></td>
                        <td class="px-3 py-2"><input type="text" name="wa_peserta[]" class="form-control rounded-3 form-control-sm"></td>
                        <td class="px-3 py-2">
                            <select name="marketing[]" class="form-select rounded-3 form-control-sm">
                                <option value="">Pilih...</option>
                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mkt->name); ?>"><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td class="px-3 py-2 text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger rounded-3 btn-remove-row" title="Hapus Baris"><i class="fas fa-times"></i></button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-remove-row');
                if (btn) {
                    const tbody = btn.closest('tbody');
                    if (tbody && tbody.id === 'editSemuaTbody<?php echo e($item->id); ?>') {
                        if (tbody.querySelectorAll('.peserta-row').length > 1) {
                            btn.closest('tr').remove();
                        } else {
                            alert('Minimal harus ada 1 baris peserta.');
                        }
                    }
                }
            });
        });
    </script>

    <?php
        $pesertas = $item->nama_peserta_array;
        $instansis = $item->instansi_peserta_array;
        $was = $item->wa_peserta_array;
        $mkts = $item->marketing_array;
    ?>
    <?php $__currentLoopData = array_filter($pesertas, 'trim'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $peserta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editPesertaModal<?php echo e($item->id); ?>_<?php echo e($i); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-user-edit text-primary me-2"></i> Edit Data Peserta</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('riwayat.pelatihan.updatePeserta', ['id' => $item->id, 'index' => $i])); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Peserta</label>
                            <input type="text" name="nama_peserta" class="form-control rounded-3" value="<?php echo e(trim($peserta)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Perusahaan / Instansi</label>
                            <input type="text" name="instansi_peserta" class="form-control rounded-3" value="<?php echo e(trim($instansis[$i] ?? '')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">WA Peserta</label>
                            <input type="text" name="wa_peserta" class="form-control rounded-3" value="<?php echo e(trim($was[$i] ?? '')); ?>">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Marketing</label>
                            <select name="marketing" class="form-select rounded-3">
                                <option value="">Pilih...</option>
                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mkt->name); ?>" <?php echo e(trim($mkts[$i] ?? '') == $mkt->name ? 'selected' : ''); ?>><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
    /* UTILITIES */
    .fw-black { font-weight: 900 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .hover-lift { transition: transform 0.2s ease-in-out, box-shadow 0.2s; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* COLORS */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }
    
    /* TABLE TWEAKS */
    table td { vertical-align: top; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Chart 1: Line Chart (Trend 12 Bulan)
        var ctx1 = document.getElementById('riwayatChart').getContext('2d');
        var chartData = <?php echo json_encode($chartData, 15, 512) ?>;
        
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Total Peserta',
                        data: chartData.dataPeserta,
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        type: 'bar',
                        label: 'Jumlah Pelatihan',
                        data: chartData.dataPelatihan,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(5, 150, 105, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: { display: true, text: 'Total Peserta', color: '#3b82f6', font: {weight: 'bold'} },
                        grid: { borderDash: [4, 4], color: '#e2e8f0' },
                        ticks: { precision: 0, color: '#3b82f6' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Pelatihan', color: '#10b981', font: {weight: 'bold'} },
                        grid: { drawOnChartArea: false }, // only want the grid lines for one axis
                        ticks: { precision: 0, color: '#10b981' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', maxRotation: 45, minRotation: 45 }
                    }
                }
            }
        });

        // Chart 2: Doughnut Chart (Proporsi Jenis)
        var canvas2 = document.getElementById('jenisChart');
        if (canvas2) {
            var ctx2 = canvas2.getContext('2d');
            var chartJenisData = <?php echo json_encode($chartJenisData, 15, 512) ?>;
            
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: chartJenisData.labels,
                    datasets: [{
                        data: chartJenisData.data,
                        backgroundColor: [
                            '#3b82f6', // Blue
                            '#10b981', // Green
                            '#f59e0b', // Yellow
                            '#ef4444', // Red
                            '#8b5cf6', // Purple
                            '#ec4899', // Pink
                            '#64748b'  // Slate
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { 
                            display: true, 
                            position: 'bottom', 
                            labels: { boxWidth: 12, padding: 15, font: {size: 11} } 
                        }
                    }
                }
            });
        }

        // Prepare marketing options string
        let marketingOptions = `<option value="">Pilih...</option>`;
        <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            marketingOptions += `<option value="<?php echo e($mkt->name); ?>"><?php echo e($mkt->nama_lengkap ?: $mkt->name); ?></option>`;
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // Auto generate dynamic inputs for participants
        document.getElementById('inputJumlahPeserta').addEventListener('input', function() {
            let num = parseInt(this.value) || 0;
            let container = document.getElementById('pesertaContainer');
            container.innerHTML = '';
            if(num > 0) {
                for(let i=1; i<=num; i++) {
                    container.innerHTML += `
                        <div class="col-12 border p-3 rounded-3 mb-2 bg-white shadow-sm">
                            <h6 class="fw-bold mb-2 small text-secondary">Peserta ${i}</h6>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="small fw-bold">Nama Peserta <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peserta[]" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Instansi</label>
                                    <input type="text" name="instansi_peserta[]" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">WA Peserta</label>
                                    <input type="text" name="wa_peserta[]" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Marketing</label>
                                    <select name="marketing[]" class="form-select form-control-sm">
                                        ${marketingOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                }
            } else {
                container.innerHTML = '<div class="col-12 text-muted small fst-italic">Silakan isi Jumlah Peserta di atas terlebih dahulu.</div>';
            }
        });

    });

    function toggleBuktiKompeten(selectElement, id) {
        const container = document.getElementById('bukti-kompeten-container-' + id);
        if(container) {
            if(selectElement.value === 'Kompeten') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }
    }
    window.toggleBuktiKompeten = toggleBuktiKompeten;
</script>

<script>
    function hapusDokumentasi(btn, url) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Yakin hapus file ini?',
                text: "File akan dihapus secara permanen dari galeri!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    prosesHapus(btn, url);
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus foto/video ini secara permanen?')) {
                prosesHapus(btn, url);
            }
        }
    }

    function prosesHapus(btn, url) {
        let card = btn.closest('.col-md-3');
        let originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        card.style.opacity = '0.7';
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                card.remove();
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Terhapus!', data.message, 'success');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Gagal!', data.message || 'File tidak ditemukan', 'error');
                } else {
                    alert('Gagal: ' + (data.message || 'File tidak ditemukan'));
                }
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                card.style.opacity = '1';
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
            } else {
                alert('Terjadi kesalahan jaringan.');
            }
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            card.style.opacity = '1';
        });
    }
    window.hapusDokumentasi = hapusDokumentasi;

    window.queuedFiles = window.queuedFiles || {};

    function initFileQueue(id) {
        if (!window.queuedFiles[id]) {
            window.queuedFiles[id] = [];
        }
    }

    function handleFileSelect(event, id) {
        initFileQueue(id);
        let files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            window.queuedFiles[id].push(files[i]);
        }
        event.target.value = ''; // Reset input to allow selecting the same file again if needed
        renderQueuePreview(id);
    }
    window.handleFileSelect = handleFileSelect;

    function renderQueuePreview(id) {
        let previewContainer = document.getElementById('fileQueuePreview' + id);
        if (!previewContainer) return;
        previewContainer.innerHTML = '';
        window.queuedFiles[id].forEach((file, index) => {
            let size = (file.size / 1024 / 1024).toFixed(2);
            previewContainer.innerHTML += `
                <span class="badge bg-secondary-subtle text-secondary border d-flex align-items-center gap-2 p-2 shadow-sm rounded-pill">
                    <span class="text-truncate" style="max-width: 150px;" title="${file.name}">${file.name}</span> (${size}MB)
                    <i class="fas fa-times text-danger ms-1" style="cursor:pointer;" onclick="removeQueuedFile(${id}, ${index})" title="Batal tambah"></i>
                </span>
            `;
        });
    }

    function removeQueuedFile(id, index) {
        window.queuedFiles[id].splice(index, 1);
        renderQueuePreview(id);
    }
    window.removeQueuedFile = removeQueuedFile;

    function uploadDokumentasiAjax(event, form, id, deleteUrlTemplate) {
        event.preventDefault();
        
        initFileQueue(id);
        let files = window.queuedFiles[id];
        
        if (files.length === 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Perhatian', 'Pilih minimal satu file untuk diunggah.', 'warning');
            } else {
                alert('Pilih minimal satu file untuk diunggah.');
            }
            return;
        }

        let formData = new FormData(form);
        // Hapus input file default (jika ada) dan ganti dengan antrean file
        formData.delete('dokumentasi_files[]');
        files.forEach(file => {
            formData.append('dokumentasi_files[]', file);
        });

        let submitBtn = document.getElementById('btnSubmitUpload' + id);
        let originalHtml = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengunggah...';
        submitBtn.disabled = true;
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
                
                let gridContainer = document.getElementById('galeriGrid' + id);
                let emptyState = document.getElementById('galeriEmpty' + id);
                
                if (emptyState) emptyState.style.display = 'none';
                if (gridContainer) gridContainer.style.display = ''; 
                
                data.files.forEach(file => {
                    let ext = file.path.split('.').pop().toLowerCase();
                    let isVideo = ['mp4', 'webm', 'ogg', 'mov', 'avi'].includes(ext);
                    let mediaHtml = '';
                    
                    if (isVideo) {
                        mediaHtml = `<video src="${file.url}" class="w-100 h-100 object-fit-cover" controls style="min-height: 150px; max-height: 150px;"></video>`;
                    } else {
                        mediaHtml = `<a href="${file.url}" target="_blank">
                                        <img src="${file.url}" class="w-100 h-100 object-fit-cover" style="min-height: 150px; max-height: 150px;" alt="Dokumentasi">
                                     </a>`;
                    }
                    
                    let deleteUrl = deleteUrlTemplate.replace('__INDEX__', file.index);
                    
                    let cardHtml = `
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                                ${mediaHtml}
                                <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm position-absolute" 
                                    onclick="hapusDokumentasi(this, '${deleteUrl}')"
                                    style="top: 10px; right: 10px; z-index: 2; width: 30px; height: 30px; padding: 0; line-height: 1;"
                                    title="Hapus file">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    if(gridContainer) gridContainer.insertAdjacentHTML('beforeend', cardHtml);
                });
                
                // Bersihkan antrean
                window.queuedFiles[id] = [];
                renderQueuePreview(id);
                form.reset();
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan', 'error');
                } else {
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                }
            }
        })
        .catch(error => {
            console.error(error);
            if (typeof Swal !== 'undefined') {
                Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
            } else {
                alert('Terjadi kesalahan jaringan.');
            }
        })
        .finally(() => {
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        });
    }
    window.uploadDokumentasiAjax = uploadDokumentasiAjax;
</script>

<?php if(session('open_modal')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalId = '<?php echo e(session("open_modal")); ?>';
        var myModalEl = document.getElementById(modalId);
        if (myModalEl) {
            var myModal = new bootstrap.Modal(myModalEl);
            myModal.show();
        }
    });
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dashboard-mkt\resources\views/riwayat-pelatihan.blade.php ENDPATH**/ ?>
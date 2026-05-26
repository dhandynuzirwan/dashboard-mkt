@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Monitoring Operasional Pelatihan</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau jadwal, personil, administrasi, dan distribusi sertifikat klien</h6>
            </div>
        </div>

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Pelatihan Running</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">5 <span style="font-size: 14px;" class="text-muted fw-medium">Kelas</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Validasi Admin</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">3 <span style="font-size: 14px;" class="text-muted fw-medium">Pending</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-info-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat OGP</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">12 <span style="font-size: 14px;" class="text-muted fw-medium">Batch</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat Dikirim</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">8 <span style="font-size: 14px;" class="text-muted fw-medium">Resi</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER RENTANG TANGGAL ================= --}}
        {{-- FILTER TRACKING PROSPEK DEAL --}}
        <div class="card card-modern mb-4" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Prospek Deal</h6>
                </div>

                <form action="#" method="GET" class="row g-3 align-items-end">
                    {{-- Kolom 1: Perusahaan --}}
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <label class="label-modern">Cari Perusahaan</label>
                        <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" name="search_tracking" class="form-control border-start-0 shadow-none ps-0" style="font-size: 13px; padding: 8px 12px;" placeholder="Nama / PIC...">
                        </div>
                    </div>

                    {{-- Kolom 3: Status --}}
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <label class="label-modern">Skema Pelatihan</label>
                        <select name="status_tracking" class="form-select input-modern shadow-none" style="font-size: 13px;">
                            <option value="">Semua</option>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                            <option value="inhouse">Inhouse</option>
                            <option value="blended">Blended</option>
                        </select>
                    </div>

                    {{-- Kolom 4: Tanggal Awal --}}
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control input-modern shadow-none" style="font-size: 13px;">
                    </div>

                    {{-- Kolom 5: Tanggal Akhir --}}
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control input-modern shadow-none" style="font-size: 13px;">
                    </div>

                    {{-- Kolom 6: Tombol --}}
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm flex-fill" style="padding: 8px 12px; font-size: 13px;">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                            <a href="#" class="btn btn-white border btn-round fw-bold text-dark shadow-sm flex-fill d-flex align-items-center justify-content-center" style="padding: 8px 12px; font-size: 13px;">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex overflow-auto" id="pills-tab" role="tablist" style="max-width: 100%;">
                <button class="nav-link active text-nowrap" id="pills-pelaksanaan-tab" data-bs-toggle="pill" data-bs-target="#pills-pelaksanaan" type="button" role="tab">
                    <i class="fas fa-chalkboard-teacher me-1"></i> 1. Pelaksanaan & Jadwal
                </button>
                <button class="nav-link text-nowrap" id="pills-administrasi-tab" data-bs-toggle="pill" data-bs-target="#pills-administrasi" type="button" role="tab">
                    <i class="fas fa-file-signature me-1"></i> 2. Administrasi & Evaluasi
                </button>
                <button class="nav-link text-nowrap" id="pills-sertifikat-tab" data-bs-toggle="pill" data-bs-target="#pills-sertifikat" type="button" role="tab">
                    <i class="fas fa-award me-1"></i> 3. Monitoring Sertifikat
                </button>
            </div>
        </div>

        {{-- ================= TAB CONTENT ================= --}}
        <div class="tab-content fade-in" id="pills-tabContent">
            
            {{-- TAB 1: PELAKSANAAN & JADWAL --}}
            <div class="tab-pane fade show active" id="pills-pelaksanaan" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Data Kelas (Klien, Jadwal, Tim Pengajar, Kelembagaan)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Klien, Program & Marketing</th>
                                        <th width="200">Jadwal Pelaksanaan</th>
                                        <th width="300">Tim Lapangan (Pengajar & Pengawas)</th>
                                        <th width="250">Kelembagaan & PIC</th>
                                        <th class="text-center pe-4" width="150">Status Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- BARIS 1: DATA TERISI LENGKAP (RUNNING) --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Pertamina Hulu Rokan</div>
                                            <div class="fw-bold text-primary mt-1" style="font-size: 13px;">Ahli K3 Umum</div>
                                            <div class="d-flex gap-2 mt-2 align-items-center">
                                                <span class="badge badge-soft-info border">KEMNAKER</span>
                                                <span class="text-muted" style="font-size: 10px;"><i class="fas fa-user-tie me-1"></i> Mkt: Ayu</span>
                                            </div>
                                        </td>
                                        
                                        {{-- KOLOM JADWAL (UPDATE DENGAN LOKASI) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper d-flex flex-column gap-1">
                                                <div class="bg-light p-2 rounded border">
                                                    <small class="text-muted d-block" style="font-size: 9px;">TGL PELATIHAN</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">05 - 07 Mei 2026</span>
                                                </div>
                                                <div class="bg-danger-subtle p-2 rounded border border-danger-subtle">
                                                    <small class="text-danger d-block" style="font-size: 9px;">TGL ASESMEN</small>
                                                    <span class="fw-bold text-danger" style="font-size: 11px;">08 Mei 2026</span>
                                                </div>
                                                <div class="bg-info-subtle p-2 rounded border border-info-subtle mb-1">
                                                    <small class="text-info d-block" style="font-size: 9px;">LOKASI / VENUE</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">
                                                        <i class="fas fa-video text-muted me-1"></i> Virtual (Zoom)
                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Jadwal & Lokasi" data-bs-toggle="modal" data-bs-target="#modalUpdateJadwal"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        {{-- KOLOM TIM (UPDATE) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Instruktur & Asesor</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 12px;"><i class="fas fa-chalkboard-teacher text-primary me-1"></i> Bpk. Ahmad Fauzi</span>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 12px;"><i class="fas fa-user-check text-success me-1"></i> Bpk. Ridwan R.</span>
                                                </div>
                                                <div class="bg-gray-50 p-2 rounded border mb-0">
                                                    <small class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Pengawas (Wasnaker)</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 11px;">Bpk. Sudarsono (198012122005)</span>
                                                    <span class="text-muted fw-medium d-block mt-1" style="font-size: 10px;">Wilker: Disnaker Riau</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Tim" data-bs-toggle="modal" data-bs-target="#modalUpdateTim"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        {{-- KOLOM LEMBAGA & PIC (UPDATE LABEL) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                <div class="mb-2" style="font-size: 11px;">
                                                    <span class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Lembaga & PJK3</span>
                                                    <span class="fw-bold text-dark d-block"><i class="fas fa-building text-info me-1"></i> PT Arsa Safety</span>
                                                </div>
                                                
                                                {{-- 🔥 PIC SEKARANG MENJADI LABEL/BADGE 🔥 --}}
                                                <div class="mt-2">
                                                    <span class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Penanggung Jawab (PIC)</span>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-user-tie text-primary me-1"></i> Klien: Ibu Vina (HRD)
                                                        </span>
                                                        <span class="badge badge-soft-success border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-headset text-success me-1"></i> Int: Dimas
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Lembaga & PIC" data-bs-toggle="modal" data-bs-target="#modalUpdateLembaga"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        <td class="text-center pe-4">
                                            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm d-block mb-2 w-100">Running</span>
                                            <button class="btn btn-sm btn-white border btn-round text-muted d-block w-100 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusKelas">Ubah Status</button>
                                        </td>
                                    </tr>

                                    {{-- BARIS 2: DATA KOSONG (PERSIAPAN) --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Wijaya Karya</div>
                                            <div class="fw-bold text-primary mt-1" style="font-size: 13px;">Operator Crane Kelas A</div>
                                            <div class="d-flex gap-2 mt-2 align-items-center">
                                                <span class="badge badge-soft-primary border">BNSP</span>
                                                <span class="text-muted" style="font-size: 10px;"><i class="fas fa-user-tie me-1"></i> Mkt: Dhandy</span>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100 py-3" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUpdateJadwal">
                                                <i class="fas fa-calendar-plus me-2"></i> Set Jadwal
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100 py-3" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUpdateTim">
                                                <i class="fas fa-users-cog me-2"></i> Set Tim Lapangan
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-white text-info text-start fw-bold hover-lift w-100 py-3" style="border: 1.5px dashed #a5f3fc;" data-bs-toggle="modal" data-bs-target="#modalUpdateLembaga">
                                                <i class="fas fa-building me-2"></i> Set Lembaga & PIC
                                            </button>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm d-block mb-2 w-100">Persiapan</span>
                                            <button class="btn btn-sm btn-white border btn-round text-muted d-block w-100 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusKelas">Ubah Status</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: ADMINISTRASI & EVALUASI --}}
            <div class="tab-pane fade" id="pills-administrasi" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3 d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Pemberkasan Laporan, Validasi & Evaluasi Lapangan</h6>
                    </div>
                    <div class="card-body p-0">
                        
                        {{-- 🔥 ALERT SOP GLOBAL 🔥 --}}
                        <div class="alert bg-warning-subtle border-0 text-warning-dark m-3 py-2 px-3 rounded-3 d-flex align-items-center shadow-sm">
                            <i class="fas fa-bullhorn fs-5 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 13px;">SOP Upload Laporan Lembaga</h6>
                                <p class="mb-0 small opacity-75" style="font-size: 11px;">Maksimal <b>H+2</b> setelah pelatihan selesai untuk sertifikasi <b>BNSP</b>, dan maksimal <b>H+7</b> untuk sertifikasi <b>KEMNAKER</b>.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1400px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="300">Klien, Judul & Label</th>
                                        <th width="250">Validasi Administrasi</th>
                                        <th width="350">Link Laporan (Internal & Lembaga)</th>
                                        <th width="350">Evaluasi Pelaksanaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    {{-- BARIS 1: SUDAH UPLOAD (AMAN / TEPAT WAKTU) --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Pertamina Hulu Rokan</div>
                                            <div class="text-muted fw-bold mt-1" style="font-size: 12px;">Ahli K3 Umum</div>
                                            <span class="badge badge-soft-info border mt-2">KEMNAKER</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                <span class="text-primary fw-bolder" style="font-size: 11px;">100% (21/21)</span>
                                            </div>
                                            <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                <div class="progress-bar bg-primary rounded-pill" style="width: 100%"></div>
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <button class="btn btn-sm btn-white border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDetailValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-list-ul me-1 text-muted"></i> Detail
                                                </button>
                                                <button class="btn btn-sm btn-primary btn-round fw-bold shadow-sm flex-grow-1 hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-check-square me-1"></i> Update
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1" style="color: #0ea5e9;">
                                                        <i class="fas fa-check-circle me-1"></i> Lap. Internal
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File"><i class="fas fa-sync-alt"></i></button>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1 text-success">
                                                        <i class="fas fa-check-circle me-1"></i> Lap. Kemnaker
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File"><i class="fas fa-sync-alt"></i></button>
                                                </div>
                                                
                                                {{-- Status Aman --}}
                                                <div class="d-flex align-items-center mt-1 text-success bg-success-subtle px-2 py-1 rounded">
                                                    <i class="fas fa-check-double me-2" style="font-size: 11px;"></i>
                                                    <small class="fw-bold" style="font-size: 10px;">Laporan Tepat Waktu</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bg-gray-50 border p-3 rounded-4">
                                                <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.6;">
                                                    <i class="fas fa-comment-dots text-muted me-1"></i> Pelatihan kondusif, trainer komunikatif. Makanan dari hotel agak telat saat coffee break sore.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- BARIS 2: KOSONG & TERLAMBAT UPLOAD --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Wijaya Karya</div>
                                            <div class="text-muted fw-bold mt-1" style="font-size: 12px;">Operator Crane Kelas A</div>
                                            <span class="badge badge-soft-primary border mt-2">BNSP</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                <span class="text-warning-dark fw-bolder" style="font-size: 11px;">43% (9/21)</span>
                                            </div>
                                            <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                <div class="progress-bar bg-warning" style="width: 43%"></div>
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <button class="btn btn-sm btn-white border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDetailValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-list-ul me-1 text-muted"></i> Detail
                                                </button>
                                                <button class="btn btn-sm btn-primary btn-round fw-bold shadow-sm flex-grow-1 hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-check-square me-1"></i> Update
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan">
                                                    <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Internal
                                                </button>
                                                <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan">
                                                    <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. BNSP
                                                </button>
                                                
                                                {{-- 🔥 WARNING TERLAMBAT 🔥 --}}
                                                <div class="d-flex align-items-center mt-1 text-danger bg-danger-subtle px-2 py-1 rounded shadow-sm border border-danger">
                                                    <i class="fas fa-exclamation-triangle me-2 animate-pulse" style="font-size: 11px;"></i>
                                                    <div>
                                                        <small class="fw-bolder d-block lh-1 mt-1" style="font-size: 10px;">TERLAMBAT UPLOAD!</small>
                                                        <small class="fw-medium" style="font-size: 9px;">Melewati batas H+2 (Telat 3 Hari)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                <p class="mb-2 text-muted small fw-bold">Belum ada evaluasi pelaksanaan.</p>
                                                <button class="btn btn-sm btn-white border btn-round shadow-sm hover-lift text-dark fw-bold px-3">
                                                    <i class="fas fa-pen me-1"></i> Tulis Evaluasi
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- BARIS 3: KOSONG TAPI MASIH AMAN (MENDEKATI DEADLINE) --}}
                                    <tr>
                                        <td class="ps-4 border-bottom-0">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Indofood CBP</div>
                                            <div class="text-muted fw-bold mt-1" style="font-size: 12px;">Auditor SMK3</div>
                                            <span class="badge badge-soft-info border mt-2">KEMNAKER</span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                <span class="text-warning-dark fw-bolder" style="font-size: 11px;">80% (18/21)</span>
                                            </div>
                                            <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                <div class="progress-bar bg-warning" style="width: 80%"></div>
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <button class="btn btn-sm btn-white border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDetailValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-list-ul me-1 text-muted"></i> Detail
                                                </button>
                                                <button class="btn btn-sm btn-primary btn-round fw-bold shadow-sm flex-grow-1 hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi" style="font-size: 11px;">
                                                    <i class="fas fa-check-square me-1"></i> Update
                                                </button>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex flex-column gap-2">
                                                <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan">
                                                    <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Internal
                                                </button>
                                                <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan">
                                                    <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Kemnaker
                                                </button>
                                                
                                                {{-- 🔥 WARNING MENDEKATI DEADLINE 🔥 --}}
                                                <div class="d-flex align-items-center mt-1 text-warning-dark bg-warning-subtle px-2 py-1 rounded shadow-sm">
                                                    <i class="fas fa-clock me-2" style="font-size: 11px;"></i>
                                                    <div>
                                                        <small class="fw-bolder d-block lh-1 mt-1" style="font-size: 10px;">Batas Upload: Besok</small>
                                                        <small class="fw-medium" style="font-size: 9px;">Maks H+7 (27 Mei 2026)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                <p class="mb-2 text-muted small fw-bold">Belum ada evaluasi pelaksanaan.</p>
                                                <button class="btn btn-sm btn-white border btn-round shadow-sm hover-lift text-dark fw-bold px-3">
                                                    <i class="fas fa-pen me-1"></i> Tulis Evaluasi
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: MONITORING SERTIFIKAT --}}
            <div class="tab-pane fade" id="pills-sertifikat" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Status Penerbitan, Pengiriman & Logistik</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1600px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Klien & Judul Pelatihan</th>
                                        <th class="text-center" width="180">Status Sertifikat</th>
                                        <th width="250">Timeline Sertifikat (Tgl)</th>
                                        <th width="150" class="text-center">Scan Sertifikat</th>
                                        <th width="280">Ekspedisi & Resi Foto</th>
                                        <th class="text-center pe-4" width="180">Tanda Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- BARIS 1: PROSES SELESAI (SUDAH UPLOAD SEMUA) --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Pertamina Hulu Rokan</div>
                                            <div class="text-muted fw-bold mt-1" style="font-size: 12px;">Ahli K3 Umum</div>
                                            <div class="text-primary small fw-bold mt-1"><i class="fas fa-user-tie me-1"></i> Bpk. Anton (HRD)</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-soft-success border border-success text-success px-4 py-2 rounded-pill shadow-sm" style="font-size: 11px;">
                                                <i class="fas fa-check-circle me-1"></i> Selesai (Diterima)
                                            </span>
                                            <button class="btn btn-sm btn-white border btn-round text-muted d-block mx-auto mt-2 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusSertif">Ubah Status</button>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                <div class="d-flex justify-content-between border-bottom pb-1">
                                                    <span class="text-muted">Estimasi Terbit:</span>
                                                    <span class="fw-bold text-dark">20 Ags 2026</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-1">
                                                    <span class="text-muted">Terima Dr Lembaga:</span>
                                                    <span class="fw-bold text-success">22 Ags 2026</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Kirim Ke Klien:</span>
                                                    <span class="fw-bold text-primary">23 Ags 2026</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <a href="#" class="btn btn-sm btn-light border text-info fw-bold btn-round shadow-sm hover-lift w-100">
                                                    <i class="fas fa-file-pdf me-1"></i> Lihat Scan
                                                </a>
                                                <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif">Ganti File</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bg-gray-50 border p-2 rounded-3 d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <span class="badge badge-soft-danger border border-danger mb-1 fw-bold">JNE REG</span>
                                                        <span class="fw-bolder text-dark d-block" style="letter-spacing: 1px; font-size: 13px;">01234567890123</span>
                                                    </div>
                                                    <button class="btn btn-sm btn-white border text-muted px-2 py-1 hover-lift" title="Edit Resi" data-bs-toggle="modal" data-bs-target="#modalUpdateResi"><i class="fas fa-pen"></i></button>
                                                </div>
                                                <a href="#" class="badge bg-white text-primary border border-primary text-decoration-none shadow-sm px-2 py-1 w-100 text-center hover-lift">
                                                    <i class="fas fa-camera me-1"></i> Cek Foto Resi Fisik
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="#" class="btn btn-sm btn-success text-white btn-round shadow-sm hover-lift w-100 fw-bold">
                                                    <i class="fas fa-image me-1"></i> Cek Foto TTD
                                                </a>
                                                <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima">Ganti Foto</button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- BARIS 2: PROSES BERJALAN (BELUM UPLOAD) --}}
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">PT. Wijaya Karya</div>
                                            <div class="text-muted fw-bold mt-1" style="font-size: 12px;">Operator Crane Kelas A</div>
                                            <div class="text-primary small fw-bold mt-1"><i class="fas fa-user-tie me-1"></i> Ibu Rina (HSE)</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-soft-warning border border-warning text-dark px-4 py-2 rounded-pill shadow-sm" style="font-size: 11px;">
                                                <i class="fas fa-hourglass-half me-1"></i> OGP (Delay)
                                            </span>
                                            <button class="btn btn-sm btn-white border btn-round text-muted d-block mx-auto mt-2 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusSertif">Ubah Status</button>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                <div class="d-flex justify-content-between border-bottom pb-1">
                                                    <span class="text-muted">Estimasi Terbit:</span>
                                                    <span class="fw-bold text-dark">20 Mei 2026</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-1">
                                                    <span class="text-muted">Terima Dr Lembaga:</span>
                                                    <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Kirim Ke Klien:</span>
                                                    <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- Belum ada scan --}}
                                            <button class="btn btn-sm btn-white text-info fw-bold btn-round shadow-sm hover-lift w-100" style="border: 1.5px dashed #7dd3fc;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif">
                                                <i class="fas fa-cloud-upload-alt me-1"></i> Upload Scan
                                            </button>
                                        </td>
                                        <td>
                                            {{-- Belum ada resi pengiriman --}}
                                            <button class="btn btn-sm btn-white text-primary fw-bold rounded-3 shadow-sm hover-lift w-100 py-3" style="border: 1.5px dashed #93c5fd;" data-bs-toggle="modal" data-bs-target="#modalUpdateResi">
                                                <i class="fas fa-truck-loading me-1"></i> Input Resi & Ekspedisi
                                            </button>
                                        </td>
                                        <td class="text-center pe-4">
                                            {{-- Belum ada tanda terima --}}
                                            <button class="btn btn-sm btn-white text-success fw-bold btn-round shadow-sm hover-lift w-100 py-2" style="border: 1.5px dashed #86efac;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima" disabled>
                                                <i class="fas fa-lock me-1"></i> Input Resi Dulu
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= KUMPULAN MODAL TAB 1 (PELAKSANAAN) ================= --}}

{{-- Modal 1: Update Jadwal & Lokasi Pelaksanaan --}}
<div class="modal fade" id="modalUpdateJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-calendar-alt text-primary me-2"></i> Set Jadwal & Lokasi Kelas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern">Mulai Pelatihan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-6">
                        <label class="label-modern">Selesai Pelatihan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-12 mt-3">
                        <label class="label-modern text-danger">Tanggal Asesmen / Ujian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control input-modern shadow-none border-danger text-danger">
                    </div>
                    
                    {{-- 🔥 TAMBAHAN INPUT LOKASI / VIRTUAL 🔥 --}}
                    <div class="col-12 mt-3">
                        <label class="label-modern">Lokasi Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Virtual (Zoom) / Hotel Grand Rohan Jogja">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-round fw-bold px-4 shadow-sm hover-lift" data-bs-dismiss="modal">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 2: Update Tim Lapangan --}}
<div class="modal fade" id="modalUpdateTim" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-users-cog text-success me-2"></i> Set Tim Pengajar & Pengawas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Nama Instruktur / Trainer</label>
                    <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ahmad Fauzi">
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nama Asesor / Evaluator</label>
                    <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ridwan R.">
                </div>
                
                <hr class="border-light my-4">
                <h6 class="fw-bolder text-dark mb-3" style="font-size: 13px;">Pengawas Kemnaker (Wasnaker) <span class="text-muted fw-normal fst-italic">opsional</span></h6>
                
                <div class="mb-3">
                    <label class="label-modern">Nama Wasnaker</label>
                    <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Sudarsono">
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern">NIP Wasnaker</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="19801212...">
                    </div>
                    <div class="col-6">
                        <label class="label-modern">Wilayah Kerja</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Disnaker Prov...">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success text-white btn-round fw-bold px-4 shadow-sm hover-lift" data-bs-dismiss="modal">Simpan Tim</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 3: Update Kelembagaan & PIC --}}
<div class="modal fade" id="modalUpdateLembaga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-building text-info me-2"></i> Set Kelembagaan & PIC</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="label-modern">PJK3 / Lembaga Penyelenggara</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: PT Arsa Safety">
                    </div>
                    <div class="col-6">
                        <label class="label-modern">LSP (Lembaga Sertifikasi)</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: LSP K3 Konstruksi">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern">PIC Eksternal (Klien)</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Ibu Vina (HRD)">
                    </div>
                    <div class="col-6">
                        <label class="label-modern">PIC Internal (Operasional)</label>
                        <input type="text" class="form-control input-modern shadow-none" placeholder="Contoh: Dimas">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info text-white btn-round fw-bold px-4 shadow-sm hover-lift" data-bs-dismiss="modal">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 4: Update Status Kelas --}}
<div class="modal fade" id="modalUpdateStatusKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-flag text-warning me-2"></i> Update Status Kelas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih Status Baru</label>
                <select class="form-select input-modern shadow-none" style="height: 45px;">
                    <option value="Persiapan">🟡 Persiapan (Setup Kelas)</option>
                    <option value="Running" selected>🔵 Running (Sedang Berjalan)</option>
                    <option value="Selesai">🟢 Selesai (Menunggu Sertifikat)</option>
                    <option value="Pending">🔴 Pending / Tertunda</option>
                </select>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-primary btn-round fw-bold w-100 shadow-sm hover-lift" data-bs-dismiss="modal">Simpan Status</button>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL UPDATE VALIDASI CHECKLIST ================= --}}
<div class="modal fade" id="modalUpdateValidasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            
            {{-- Header --}}
            <div class="modal-header border-bottom pb-3 pt-4 px-4 px-md-5 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-dark mb-0">Update Validasi Checklist</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">Klien: <strong class="text-dark">PT. Pertamina Hulu Rokan</strong> | Program: <strong>Ahli K3 Umum</strong></p>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 px-md-5 pt-4 pb-4" style="background-color: #f8fafc;">
                
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        
                        {{-- Kategori 1: Administrasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-folder-open text-warning me-2"></i> 1. Administrasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    {{-- Item 1 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_adm_1" data-bs-toggle="collapse" data-bs-target="#col_adm_1" checked>
                                        <label class="form-check-label text-dark small fw-medium" for="chk_adm_1">Persyaratan Peserta</label>
                                    </div>

                                    {{-- Item 2 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_adm_2" data-bs-toggle="collapse" data-bs-target="#col_adm_2" checked>
                                        <label class="form-check-label text-dark small fw-medium" for="chk_adm_2">E Certificate</label>
                                    </div>
                                    <div class="collapse show mb-3" id="col_adm_2">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="url" name="link_sertifikat" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Drive Sertifikat...">
                                        </div>
                                    </div>

                                    {{-- Item 3 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_adm_3" data-bs-toggle="collapse" data-bs-target="#col_adm_3">
                                        <label class="form-check-label text-dark small fw-medium" for="chk_adm_3">Form Evaluasi</label>
                                    </div>
                                    <div class="collapse mb-3" id="col_adm_3">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="url" name="link_evaluasi" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Form/Drive Evaluasi...">
                                        </div>
                                    </div>

                                    {{-- Item 4 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_adm_4" data-bs-toggle="collapse" data-bs-target="#col_adm_4">
                                        <label class="form-check-label text-dark small fw-medium" for="chk_adm_4">Review Google</label>
                                    </div>
                                    <div class="collapse mb-2" id="col_adm_4">
                                        <div class="ps-4 pe-1 mt-1">
                                            <small class="text-muted d-block mb-1" style="font-size: 10px;">Upload Screenshot Review</small>
                                            <input type="file" class="form-control form-control-sm shadow-none" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 2: Online Support --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-laptop-house text-info me-2"></i> 2. Online Support</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    {{-- Item 1 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_os_1" data-bs-toggle="collapse" data-bs-target="#col_os_1" checked>
                                        <label class="form-check-label text-dark small fw-medium" for="chk_os_1">Link Zoom Materi</label>
                                    </div>
                                    <div class="collapse show mb-3" id="col_os_1">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="url" class="form-control form-control-sm shadow-none" placeholder="https://zoom.us/j/...">
                                        </div>
                                    </div>

                                    {{-- Item 2 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_os_2" data-bs-toggle="collapse" data-bs-target="#col_os_2">
                                        <label class="form-check-label text-dark small fw-medium" for="chk_os_2">Link Zoom Asesment</label>
                                    </div>
                                    <div class="collapse mb-3" id="col_os_2">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="url" class="form-control form-control-sm shadow-none" placeholder="https://zoom.us/j/...">
                                        </div>
                                    </div>

                                    {{-- Item 3 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_os_3" data-bs-toggle="collapse" data-bs-target="#col_os_3" checked>
                                        <label class="form-check-label text-dark small fw-medium" for="chk_os_3">Background Zoom</label>
                                    </div>
                                    <div class="collapse show mb-3" id="col_os_3">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="file" class="form-control form-control-sm shadow-none" accept="image/*">
                                        </div>
                                    </div>

                                    {{-- Item 4 --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_os_4" data-bs-toggle="collapse" data-bs-target="#col_os_4" checked>
                                        <label class="form-check-label text-dark small fw-medium" for="chk_os_4">Foto Profil Grup WA</label>
                                    </div>
                                    <div class="collapse show mb-2" id="col_os_4">
                                        <div class="ps-4 pe-1 mt-1">
                                            <input type="file" class="form-control form-control-sm shadow-none" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 3: Komunikasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-comments text-success me-2"></i> 3. Komunikasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="alert bg-success-subtle border-0 text-success small py-2 mb-3" style="border-radius: 8px;">
                                        <i class="fas fa-info-circle me-1"></i> Cukup centang jika komunikasi sudah dilakukan.
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_1" checked><label class="form-check-label text-dark small fw-medium" for="chk_kom_1">Hubungi Peserta</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_2" checked><label class="form-check-label text-dark small fw-medium" for="chk_kom_2">Hubungi Instruktur</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_3"><label class="form-check-label text-dark small fw-medium" for="chk_kom_3">Hubungi Asesor</label></div>
                                            <div class="form-check custom-checkbox mb-2 mb-sm-0"><input class="form-check-input" type="checkbox" id="chk_kom_4" checked><label class="form-check-label text-dark small fw-medium" for="chk_kom_4">Buat Grup WA</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_5" checked><label class="form-check-label text-dark small fw-medium" for="chk_kom_5">Share Link Zoom Materi</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_6"><label class="form-check-label text-dark small fw-medium" for="chk_kom_6">Share Link Zoom Asesment</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" id="chk_kom_7"><label class="form-check-label text-dark small fw-medium" for="chk_kom_7">Share Form Evaluasi</label></div>
                                            <div class="form-check custom-checkbox mb-0"><input class="form-check-input" type="checkbox" id="chk_kom_8"><label class="form-check-label text-dark small fw-medium" for="chk_kom_8">Share Sertifikat</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 4: Dokumentasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-camera text-danger me-2"></i> 4. Dokumentasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    {{-- Reusable Collapse for Dokumentasi (Using Select Dropdown) --}}
                                    @php
                                        $dokItems = [
                                            ['id' => '1', 'label' => 'Foto Kompeten'],
                                            ['id' => '2', 'label' => 'Foto K3'],
                                            ['id' => '3', 'label' => 'Foto Formal'],
                                            ['id' => '4', 'label' => 'Foto Materi'],
                                        ];
                                    @endphp

                                    @foreach($dokItems as $dok)
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_dok_{{ $dok['id'] }}" data-bs-toggle="collapse" data-bs-target="#col_dok_{{ $dok['id'] }}">
                                        <label class="form-check-label text-dark small fw-medium" for="chk_dok_{{ $dok['id'] }}">{{ $dok['label'] }}</label>
                                    </div>
                                    <div class="collapse mb-3" id="col_dok_{{ $dok['id'] }}">
                                        <div class="ps-4 pe-1 mt-1">
                                            <select class="form-select form-select-sm mb-1 bg-light border-0" onchange="toggleMethod(this, 'dok_{{ $dok['id'] }}')">
                                                <option value="link">Gunakan Link Drive</option>
                                                <option value="file">Upload Foto/ZIP</option>
                                            </select>
                                            <input type="url" id="dok_{{ $dok['id'] }}_link" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Drive...">
                                            <input type="file" id="dok_{{ $dok['id'] }}_file" class="form-control form-control-sm shadow-none d-none" accept=".zip,image/*" multiple>
                                        </div>
                                    </div>
                                    @endforeach

                                    {{-- Record Zoom (Only Link Drive because video sizes are huge) --}}
                                    <div class="form-check custom-checkbox mb-1">
                                        <input class="form-check-input" type="checkbox" id="chk_dok_5" data-bs-toggle="collapse" data-bs-target="#col_dok_5">
                                        <label class="form-check-label text-dark small fw-medium" for="chk_dok_5">Record Zoom</label>
                                    </div>
                                    <div class="collapse mb-2" id="col_dok_5">
                                        <div class="ps-4 pe-1 mt-1">
                                            <small class="text-muted d-block mb-1" style="font-size: 10px;">Link Drive Rekaman (Wajib Link)</small>
                                            <input type="url" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Drive Video...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
            {{-- Footer Action --}}
            <div class="modal-footer border-top px-4 px-md-5 py-3 bg-white" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary fw-bold px-4 btn-round shadow-sm hover-lift" onclick="alert('Simulasi: Progress checklist & file berhasil disimpan!')" data-bs-dismiss="modal">
                    <i class="fas fa-save me-1"></i> Simpan Progress
                </button>
            </div>
            
        </div>
    </div>
</div>

{{-- MODAL DETAIL (View Only) --}}
{{-- Kamu bisa menggunakan kerangka yang persis sama dengan modal Update di atas, namun tambahkan atribut `disabled` pada semua tag `<input type="checkbox">` dan hilangkan tombol "Simpan". --}}

{{-- ================= MODAL UPLOAD LAPORAN ================= --}}
<div class="modal fade" id="modalUploadLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-dark mb-0">Upload File Laporan</h5>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="modal-body px-4 pt-4 pb-4">
                    <div class="mb-3">
                        <label class="label-modern">Pilih Dokumen File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar" required>
                        <small class="text-danger fw-bold d-block mt-2" style="font-size: 11px;">
                            <i class="fas fa-exclamation-triangle me-1"></i> Maksimal ukuran file 5 MB!
                        </small>
                    </div>
                    <div class="mb-0">
                        <label class="label-modern">Keterangan / Catatan Tambahan</label>
                        <textarea class="form-control input-modern shadow-none" rows="3" placeholder="Tuliskan keterangan mengenai laporan ini (opsional)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 hover-lift shadow-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white btn-round fw-bold px-4 shadow-sm hover-lift" data-bs-dismiss="modal">
                        <i class="fas fa-upload me-1"></i> Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= KUMPULAN MODAL TAB 3 (SERTIFIKAT) ================= --}}

{{-- Modal 1: Update Status & Timeline Sertifikat --}}
<div class="modal fade" id="modalUpdateStatusSertif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-clock text-warning me-2"></i> Status & Timeline Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                
                <div class="mb-3">
                    <label class="label-modern">Status Sertifikat Saat Ini <span class="text-danger">*</span></label>
                    <select class="form-select input-modern shadow-none">
                        <option value="OGP">OGP (Sedang Proses di Lembaga)</option>
                        <option value="Delay">Delay (Tertunda dari Lembaga)</option>
                        <option value="Terbit">Sudah Terbit / Diterima ARSA</option>
                    </select>
                </div>
                
                <div class="bg-gray-50 border p-3 rounded-4 mb-0">
                    <div class="mb-3">
                        <label class="label-modern">Estimasi Terbit (Info dari Lembaga) <span class="text-danger">*</span></label>
                        <input type="date" class="form-control input-modern shadow-none border-primary">
                        <small class="text-muted fw-bold d-block mt-1" style="font-size: 10px;">Update tanggal ini jika terjadi kemunduran estimasi dari Kemnaker/BNSP.</small>
                    </div>

                    <hr class="border-light my-3">

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="label-modern text-success">Tanggal Terima Real</label>
                            <input type="date" class="form-control input-modern shadow-none" title="Diisi jika sertifikat fisik sudah sampai di kantor ARSA">
                        </div>
                        <div class="col-6">
                            <label class="label-modern text-primary">Tanggal Kirim</label>
                            <input type="date" class="form-control input-modern shadow-none" title="Diisi jika sertifikat sudah mulai dikirim ke klien">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning text-dark btn-round fw-bold px-4 shadow-sm hover-lift" data-bs-dismiss="modal">
                    <i class="fas fa-save me-1"></i> Simpan Timeline
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 2: Upload Scan Sertifikat --}}
<div class="modal fade" id="modalUploadScanSertif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-pdf text-info me-2"></i> Upload Scan Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-0">
                    <label class="label-modern">Pilih File (PDF/Zip)</label>
                    <input type="file" class="form-control input-modern shadow-none" accept=".pdf,.zip,.rar" required>
                    <small class="text-muted fw-bold d-block mt-2" style="font-size: 11px;">Maksimal ukuran file 10 MB.</small>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-info text-white btn-round fw-bold w-100 shadow-sm" data-bs-dismiss="modal">Upload Scan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 3: Input Resi Pengiriman --}}
<div class="modal fade" id="modalUpdateResi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-truck-loading text-primary me-2"></i> Input Resi & Pengiriman</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Kurir / Ekspedisi</label>
                    <select class="form-select input-modern shadow-none">
                        <option value="JNE">JNE</option>
                        <option value="J&T">J&T</option>
                        <option value="SiCepat">SiCepat</option>
                        <option value="Pos Indonesia">Pos Indonesia</option>
                        <option value="Kurir Internal">Kurir Internal ARSA</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor Resi / Pelacakan</label>
                    <input type="text" class="form-control input-modern shadow-none fw-bold" placeholder="Ketik nomor resi di sini...">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Upload Foto Resi Fisik (Opsional)</label>
                    <input type="file" class="form-control input-modern shadow-none" accept="image/*">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-primary text-white btn-round fw-bold w-100 shadow-sm" data-bs-dismiss="modal">Simpan Resi</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 4: Upload Tanda Terima --}}
<div class="modal fade" id="modalUploadTandaTerima" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-signature text-success me-2"></i> Upload Tanda Terima Klien</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="alert alert-modern-success py-2 px-3 border-0 mb-3 small fw-bold">
                    Upload bukti ini jika paket sertifikat sudah benar-benar sampai di tangan klien.
                </div>
                <div class="mb-0">
                    <label class="label-modern">Upload Foto / Scan TTD</label>
                    <input type="file" class="form-control input-modern shadow-none" accept="image/*,.pdf" required>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-success text-white btn-round fw-bold w-100 shadow-sm" data-bs-dismiss="modal">Selesaikan Pengiriman</button>
            </div>
        </div>
    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    /* Base UI */
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    /* Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .text-warning-dark { color: #b45309 !important; }

    /* Borders */
    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-info-subtle { border-color: #a5f3fc !important; }
    .border-warning-subtle { border-color: #fef08a !important; }
    .border-danger-subtle { border-color: #fca5a5 !important; }

    /* Badges */
    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }

    /* Tabs */
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Tables */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 14px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 16px; }

    /* Custom Elements */
    .alert-modern-danger { background-color: #fef2f2; border-radius: 8px; border-left: 3px solid #ef4444 !important; }
    .bg-gray-50 { background-color: #f8fafc; }

    /* Animation */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* CSS BARU UNTUK TOMBOL EDIT DI POJOK ATAS CELL */
    .cell-relative {
        position: relative; /* Menjadikan cell sebagai patokan posisi */
    }

    .btn-edit-absolute {
        position: absolute; /* Posisi melayang terhadap cell-relative */
        top: 8px;           /* Jarak dari atas cell */
        right: 8px;         /* Jarak dari kanan cell */
        z-index: 5;         /* Memastikan tombol di atas konten */
        
        /* Desain tombol agar lebih bersih & samar */
        padding: 4px 8px !important;
        border-radius: 6px !important;
        background: rgba(255, 255, 255, 0.7) !important; /* Semi transparan */
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 10px !important;
        opacity: 0.5; /* Samar saat diam */
        transition: all 0.2s ease;
    }

    /* Efek hover agar tombol terlihat jelas saat cell disorot */
    tr:hover .btn-edit-absolute,
    .btn-edit-absolute:hover {
        opacity: 1; /* Terlihat penuh */
        background: #fff !important; /* Latar putih pekat */
        border-color: #cbd5e1 !important;
        color: #3b82f6 !important; /* Warna primary */
    }

    /* Menambahkan padding kanan pada konten agar tidak tertabrak tombol */
    .cell-content-wrapper {
        padding-right: 25px; /* Beri ruang untuk tombol absolute */
    }
</style>
{{-- Skrip Khusus Modal Validasi --}}
<script>
    // Fungsi untuk mengganti input Link Drive vs Upload File
    function toggleMethod(selectElement, idPrefix) {
        const linkInput = document.getElementById(idPrefix + '_link');
        const fileInput = document.getElementById(idPrefix + '_file');
        
        if (selectElement.value === 'link') {
            linkInput.classList.remove('d-none');
            fileInput.classList.add('d-none');
        } else {
            linkInput.classList.add('d-none');
            fileInput.classList.remove('d-none');
        }
    }
</script>
@endsection
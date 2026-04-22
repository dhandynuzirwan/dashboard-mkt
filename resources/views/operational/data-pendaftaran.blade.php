@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div>
            <h3 class="fw-bold mb-1">Data Pendaftaran Pelatihan</h3>
            <h6 class="op-7 mb-2">Panel Verifikasi Berkas & Approval Tim Operasional</h6>
        </div>

        {{-- Header & Filter Section --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
            <div class="ms-md-auto py-2 py-md-0">
                <form action="#" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    
                    {{-- Input Search --}}
                    <div class="form-group p-0 m-0">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Cari Nama/ID/Instansi...">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                    </div>
                
                    {{-- Filter Status --}}
                    <div class="form-group p-0 m-0">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status Berkas</option>
                            <option value="pending">🟡 Menunggu Verifikasi</option>
                            <option value="revision">🔴 Butuh Revisi</option>
                            <option value="approved">🟢 Disetujui (Lengkap)</option>
                        </select>
                    </div>
                    
                    {{-- Filter Jalur Pendaftaran --}}
                    <div class="form-group p-0 m-0">
                        <select name="jalur" class="form-select form-select-sm">
                            <option value="">Semua Jalur</option>
                            <option value="individu">Individu / Pribadi</option>
                            <option value="kolektif">Kolektif / Instansi</option>
                        </select>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm btn-round"><i class="fas fa-filter"></i> Terapkan</button>
                        <a href="#" class="btn btn-border btn-round btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="icon-people"></i> 
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Pendaftar</p>
                                    <h4 class="card-title">145</h4>
                                    <p class="text-muted small mb-0">Peserta aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="icon-hourglass"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Antrean Verifikasi</p>
                                    <h4 class="card-title">28</h4>
                                    <p class="text-warning small mb-0">Perlu di-review</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="icon-action-undo"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Menunggu Revisi</p>
                                    <h4 class="card-title">12</h4>
                                    <p class="text-danger small mb-0">Berkas dikembalikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="icon-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Berkas Disetujui</p>
                                    <h4 class="card-title">105</h4>
                                    <p class="text-success small mb-0">Siap ikut pelatihan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card card-round shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Daftar Registrasi Peserta</div>
                <div>
                    <button class="btn btn-success btn-sm btn-round">
                        <i class="fas fa-file-excel me-1"></i> Export Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th width="90">ID Reg</th>
                                <th>Nama Peserta</th>
                                <th>Jalur & Instansi</th>
                                <th>Program Pelatihan</th>
                                <th>Status Berkas</th>
                                {{-- ================= KOLOM BARU: TANGGAL PELATIHAN ================= --}}
                                <th width="130">Tanggal Pelatihan</th>
                                <th width="110">Status Akhir</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            {{-- Baris 1: Individu (Pending) --}}
                            <tr>
                                <td class="text-center fw-bold text-primary">PLT-089</td>
                                <td>
                                    <div class="fw-bold">Dhandy Nuzirwan</div>
                                    <small class="text-muted"><i class="fab fa-whatsapp text-success"></i> 08123456789</small>
                                </td>
                                <td>
                                    <span class="badge badge-info mb-1"><i class="fas fa-user"></i> Individu</span><br>
                                    <small>-</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Web Development</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted fw-bold">Progress Berkas</span>
                                        <span class="text-muted fw-bold">43%</span>
                                    </div>
                                    <div class="progress mb-1" style="height: 8px; border-radius: 4px; background-color: #f1f1f1;">
                                        <div class="progress-bar bg-success" data-bs-toggle="tooltip" title="3 Terverifikasi" style="width: 43%"></div>
                                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" data-bs-toggle="tooltip" title="4 Menunggu" style="width: 57%"></div>
                                    </div>
                                    <small class="text-muted fw-bold d-block mt-1" style="font-size: 10px;">
                                        <span class="text-success">3 Terverifikasi</span>, <span class="text-warning">4 Menunggu</span>
                                    </small>
                                </td>
                                {{-- KONTEN TANGGAL PELATIHAN (KOSONG/PENDING) --}}
                                <td class="text-center">
                                    <span class="text-muted fst-italic small">Belum ditetapkan</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-warning shadow-sm"><i class="fas fa-hourglass-half me-1"></i> Menunggu</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm w-100 btn-round" data-bs-toggle="modal" data-bs-target="#modalReviewIndividu">
                                        <i class="fas fa-search me-1"></i> Review
                                    </button>
                                </td>
                            </tr>

                            {{-- Baris 2: Kolektif (Butuh Revisi) --}}
                            <tr>
                                <td class="text-center fw-bold text-primary">PLT-088</td>
                                <td>
                                    <div class="fw-bold">Leo Pratama</div>
                                    <small class="text-muted"><i class="fab fa-whatsapp text-success"></i> 08987654321</small>
                                </td>
                                <td>
                                    <span class="badge badge-secondary mb-1"><i class="fas fa-building"></i> Kolektif</span><br>
                                    <small class="fw-bold text-dark">PT Arsa Jaya Prima</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">UI/UX Design</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted fw-bold">Progress Berkas</span>
                                        <span class="text-muted fw-bold">85%</span>
                                    </div>
                                    <div class="progress mb-1" style="height: 8px; border-radius: 4px; background-color: #f1f1f1;">
                                        <div class="progress-bar bg-success" data-bs-toggle="tooltip" title="6 Terverifikasi" style="width: 85%"></div>
                                        <div class="progress-bar bg-danger" data-bs-toggle="tooltip" title="1 Revisi" style="width: 15%"></div>
                                    </div>
                                    <small class="text-muted fw-bold d-block mt-1" style="font-size: 10px;">
                                        <span class="text-success">6 Terverifikasi</span>, <span class="text-danger">1 Butuh Revisi</span>
                                    </small>
                                </td>
                                {{-- KONTEN TANGGAL PELATIHAN (KOSONG/REVISI) --}}
                                <td class="text-center">
                                    <span class="text-muted fst-italic small">Belum ditetapkan</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-danger shadow-sm"><i class="fas fa-exclamation-triangle me-1"></i> Revisi</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-secondary btn-sm w-100 btn-round" data-bs-toggle="modal" data-bs-target="#modalReviewKolektif">
                                        <i class="fas fa-search me-1"></i> Review
                                    </button>
                                </td>
                            </tr>

                            {{-- Baris 3: Individu (Approved & Sudah ada tanggal) --}}
                            <tr>
                                <td class="text-center fw-bold text-primary">PLT-087</td>
                                <td>
                                    <div class="fw-bold">Siti Aminah</div>
                                    <small class="text-muted"><i class="fab fa-whatsapp text-success"></i> 08561234987</small>
                                </td>
                                <td>
                                    <span class="badge badge-info mb-1"><i class="fas fa-user"></i> Individu</span><br>
                                    <small>-</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Digital Marketing</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted fw-bold">Progress Berkas</span>
                                        <span class="text-success fw-bold">100%</span>
                                    </div>
                                    <div class="progress mb-1" style="height: 8px; border-radius: 4px; background-color: #f1f1f1;">
                                        <div class="progress-bar bg-success" data-bs-toggle="tooltip" title="7 Terverifikasi" style="width: 100%"></div>
                                    </div>
                                    <small class="text-success fw-bold d-block mt-1" style="font-size: 10px;">
                                        7 Lengkap Terverifikasi
                                    </small>
                                </td>
                                {{-- KONTEN TANGGAL PELATIHAN (SUDAH DITETAPKAN) --}}
                                <td class="text-center">
                                    <div class="fw-bold text-dark small">20 Apr 2026</div>
                                    <small class="text-muted" style="font-size: 10px;">s.d 24 Apr 2026</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success shadow-sm"><i class="fas fa-check-circle me-1"></i> Disetujui</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-border btn-sm w-100 btn-round">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- Pagination Dummy --}}
                <div class="mt-3 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm">
                            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

        {{-- Include Modal Review Berkas --}}
        @include('partials.modal-review-individu')
        @include('partials.modal-review-kolektif')

    </div>
</div>

<style>
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    // Fungsi untuk menampilkan form catatan jika admin memilih Tolak/Revisi
    function toggleCatatan(selectElement, targetId) {
        const targetRow = document.getElementById(targetId);
        if (selectElement.value === 'reject') {
            targetRow.style.display = 'table-row';
            selectElement.classList.add('border-danger', 'text-danger');
            selectElement.classList.remove('border-success', 'text-success', 'border-warning', 'text-warning');
        } else if(selectElement.value === 'approve') {
            targetRow.style.display = 'none';
            selectElement.classList.add('border-success', 'text-success');
            selectElement.classList.remove('border-danger', 'text-danger', 'border-warning', 'text-warning');
        } else {
            targetRow.style.display = 'none';
            selectElement.classList.add('border-warning', 'text-warning');
            selectElement.classList.remove('border-danger', 'text-danger', 'border-success', 'text-success');
        }
    }
    
    // Inisialisasi Tooltip Bootstrap (Penting untuk Progress Bar)
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
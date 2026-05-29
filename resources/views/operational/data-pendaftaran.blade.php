@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Data Pendaftaran Pelatihan</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau progress pendaftaran klien deal dan verifikasi berkas peserta</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2 flex-wrap">
                <button class="btn btn-success btn-round fw-bold shadow-sm hover-lift">
                    <i class="fas fa-file-excel me-1"></i> Export Data
                </button>
            </div>
        </div>

        {{-- ================= ALERT NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-modern-success alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark">Berhasil!</span> <span class="text-dark opacity-75">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Gagal!</span> <span class="text-dark opacity-75">{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-start">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Tidak bisa menyimpan data!</span>
                        <ul class="mb-0 text-dark opacity-75 ps-3 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Pendaftar</p>
                             <h3 class="fw-bolder text-primary-dark mb-0 lh-1">{{ $stats['total_pendaftar'] }}</h3>
                            <p class="text-muted small mb-0 mt-1" style="font-size: 10px;">Peserta aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Antrean Verifikasi</p>
                            <h3 class="fw-bolder text-warning-dark mb-0 lh-1">{{ $stats['menunggu'] }}</h3>
                            <p class="text-warning-dark fw-bold small mb-0 mt-1" style="font-size: 10px;">Perlu di-review</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 border-danger-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-danger-subtle text-danger me-3">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu Revisi</p>
                            <h3 class="fw-bolder text-danger mb-0 lh-1">{{ $stats['revisi'] }}</h3>
                            <p class="text-danger fw-bold small mb-0 mt-1" style="font-size: 10px;">Berkas dikembalikan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Berkas Disetujui</p>
                            <h3 class="fw-bolder text-success mb-0 lh-1">{{ $stats['disetujui'] }}</h3>
                            <p class="text-success fw-bold small mb-0 mt-1" style="font-size: 10px;">Siap ikut pelatihan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <label class="label-modern">Status</label>
                        <select name="status_tracking" class="form-select input-modern shadow-none" style="font-size: 13px;">
                            <option value="">Semua</option>
                            <option value="lengkap">🟢 Lengkap</option>
                            <option value="kurang">🟡 Kurang</option>
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
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-tracking-tab" data-bs-toggle="pill" data-bs-target="#pills-tracking" type="button" role="tab">
                    <i class="fas fa-search-dollar me-1"></i> 1. Tracking Prospek Deal
                </button>
                <button class="nav-link" id="pills-registrasi-tab" data-bs-toggle="pill" data-bs-target="#pills-registrasi" type="button" role="tab">
                    <i class="fas fa-clipboard-check me-1"></i> 2. Verifikasi Berkas Peserta
                </button>
            </div>
        </div>

        {{-- ================= TAB CONTENT ================= --}}
        <div class="tab-content fade-in" id="pills-tabContent">

            {{-- TAB 1: TRACKING PROSPEK DEAL --}}
            <div class="tab-pane fade show active" id="pills-tracking" role="tabpanel">

                {{-- TABEL TRACKING PROSPEK DEAL --}}
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark"><i class="fas fa-clipboard-list text-primary me-2"></i>Tracking Progress Pendaftaran dari Prospek Deal</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="90">ID & Tgl</th>
                                        <th class="ps-3" width="250">Perusahaan & PIC</th>
                                        <th width="220">Program & Sertifikasi</th>
                                        <th width="150">Marketing</th>
                                        <th width="220">Progress Pendaftaran</th>
                                        <th class="text-center" width="130">Status Pendaftar</th>
                                        {{-- <th class="text-center pe-4" width="100">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deals as $deal)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge badge-soft-secondary border fw-bolder px-2 py-1 mb-1 shadow-sm">#{{ $deal->id }}</span><br>
                                            <small class="text-muted fw-bold" style="font-size: 10px;">{{ $deal->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="ps-3">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">{{ $deal->prospek->perusahaan ?? '-' }}</div>
                                            <small class="text-muted d-block text-truncate mb-1" style="max-width: 200px;">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $deal->prospek->alamat ?? 'Lokasi tidak diketahui' }}
                                            </small>
                                            <div class="bg-light border rounded px-2 py-1 d-inline-block mt-1">
                                                <small class="text-dark fw-bold" style="font-size: 10px;"><i class="fas fa-user-tie text-muted me-1"></i> {{ $deal->prospek->pic ?? '-' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bolder text-primary d-block mb-1" style="font-size: 13px;">{{ $deal->prospek->program ?? '-' }}</span>
                                            <span class="badge badge-soft-info border px-2 py-1 text-uppercase">{{ $deal->sertifikasi ?? 'Internal' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="icon-sm bg-light border rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 20px; height: 20px; font-size: 9px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                                <span class="fw-bold text-dark" style="font-size: 11px;">{{ $deal->prospek->marketing->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between mb-1" style="font-size: 11px;">
                                                <span class="text-muted fw-bold">Deal: {{ $deal->jumlah_peserta ?? 1 }} Org</span>
                                                <span class="text-warning-dark fw-bolder">Terdaftar: Menunggu Data</span>
                                            </div>
                                            <div class="progress mb-1 bg-light border" style="height: 6px; border-radius: 10px;">
                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-soft-warning text-dark border border-warning rounded-pill px-3 py-1 shadow-sm">Belum Lengkap</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data prospek deal.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: VERIFIKASI BERKAS PESERTA --}}
            <div class="tab-pane fade" id="pills-registrasi" role="tabpanel">
                {{-- FILTER VERIFIKASI BERKAS --}}
                <div class="card card-modern mb-4" style="background-color: #f8faff;">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                            <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-filter" style="font-size: 13px;"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Data Pendaftar</h6>
                        </div>

                        <form action="#" method="GET" class="row g-3 align-items-end">
                            {{-- Kolom 1 --}}
                            <div class="col-md-6 col-xl-3">
                                <label class="label-modern">Cari Peserta / Instansi</label>
                                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0 shadow-none ps-0" style="font-size: 13px; padding: 8px 12px;" placeholder="Nama / ID / Instansi...">
                                </div>
                            </div>
                            
                            {{-- Kolom 2 --}}
                            <div class="col-md-6 col-xl-3">
                                <label class="label-modern">Status Berkas</label>
                                <select name="status" class="form-select input-modern shadow-none">
                                    <option value="">Semua Status</option>
                                    <option value="pending">🟡 Menunggu Verifikasi</option>
                                    <option value="revision">🔴 Butuh Revisi</option>
                                    <option value="approved">🟢 Disetujui (Lengkap)</option>
                                </select>
                            </div>

                            {{-- Kolom 3 --}}
                            <div class="col-md-6 col-xl-3">
                                <label class="label-modern">Jalur Pendaftaran</label>
                                <select name="jalur" class="form-select input-modern shadow-none">
                                    <option value="">Semua Jalur</option>
                                    <option value="individu">Individu / Pribadi</option>
                                    <option value="kolektif">Kolektif / Instansi</option>
                                </select>
                            </div>

                            {{-- Kolom 4 --}}
                            <div class="col-md-6 col-xl-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm flex-fill" style="padding: 8px 12px; font-size: 13px;">
                                        <i class="fas fa-search me-1"></i> Terapkan
                                    </button>
                                    <a href="#" class="btn btn-white border btn-round fw-bold text-dark shadow-sm flex-fill d-flex align-items-center justify-content-center" style="padding: 8px 12px; font-size: 13px;">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- TABEL VERIFIKASI BERKAS --}}
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                        <h6 class="card-title fw-bolder mb-0 text-dark">Daftar Registrasi & Verifikasi Berkas</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="text-center" width="90">ID Reg</th>
                                        <th>Nama Peserta</th>
                                        <th>Jalur & Instansi</th>
                                        <th>Program Pelatihan</th>
                                        <th width="200">Status Berkas</th>
                                        <th width="140">Tanggal Pelatihan</th>
                                        <th class="text-center" width="120">Status Akhir</th>
                                        <th class="text-center pe-4" width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendaftarans as $pendaftar)
                                    @php
                                        // Hitung persentase berkas approve
                                        $berkasArray = [$pendaftar->status_ktp, $pendaftar->status_ijazah, $pendaftar->status_foto, $pendaftar->status_cv, $pendaftar->status_sk, $pendaftar->status_laporan, $pendaftar->status_sop];
                                        $totalBerkas = count($berkasArray);
                                        $approved = count(array_filter($berkasArray, fn($v) => $v == 'approve'));
                                        $persen = round(($approved / $totalBerkas) * 100);
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge badge-soft-primary border fw-bolder px-2 py-1 shadow-sm">{{ $pendaftar->id_pendaftaran }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">{{ $pendaftar->nama_lengkap }}</div>
                                            <small class="text-muted fw-medium"><i class="fab fa-whatsapp text-success me-1"></i> {{ $pendaftar->no_wa }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info border border-info px-2 py-1 mb-1"><i class="fas fa-user me-1"></i> Individu</span><br>
                                            <small class="text-muted">{{ $pendaftar->perusahaan ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bolder text-dark">{{ $pendaftar->training->nama_training ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                                <span class="text-muted fw-bold text-uppercase">Progress Berkas</span>
                                                <span class="text-muted fw-bold">{{ $persen }}%</span>
                                            </div>
                                            <div class="progress mb-1 bg-light border" style="height: 6px; border-radius: 10px;">
                                                <div class="progress-bar bg-success rounded-pill" style="width: {{ $persen }}%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fst-italic small bg-light px-2 py-1 rounded border">Belum ditetapkan</span>
                                        </td>
                                        <td class="text-center">
                                            @if($pendaftar->status == 'pending')
                                                <span class="badge badge-soft-warning border border-warning text-dark px-3 py-1 shadow-sm rounded-pill">Menunggu</span>
                                            @elseif($pendaftar->status == 'revisi')
                                                <span class="badge badge-soft-danger border border-danger px-3 py-1 shadow-sm rounded-pill">Revisi</span>
                                            @else
                                                <span class="badge badge-soft-success border border-success px-3 py-1 shadow-sm rounded-pill">Disetujui</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4">
                                            <button class="btn btn-primary btn-sm w-100 btn-round fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalReviewIndividu-{{ $pendaftar->id }}">
                                                <i class="fas fa-search me-1"></i> Review
                                            </button>
                                        </td>
                                    </tr>
                                    @include('partials.modal-review-individu')
                                    @empty
                                    <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data pendaftar.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item disabled"><a class="page-link shadow-none" href="#">Prev</a></li>
                                    <li class="page-item active"><a class="page-link shadow-none" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link shadow-none" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link shadow-none" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Include Modal Review Berkas --}}
        
        @include('partials.modal-review-kolektif')

    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    /* CSS MODERNISASI UI */
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }

    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-secondary-subtle { background-color: #f8fafc !important; }
    .text-warning-dark { color: #b45309 !important; }

    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-warning-subtle { border-color: #fef08a !important; }
    .border-danger-subtle { border-color: #fecaca !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-secondary { background-color: #f8fafc; color: #475569; }

    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-danger { background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

    /* Segmented Tabs (Modern Toggle) */
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Table Modern */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 14px 16px; }

    /* Form Modern */
    .label-modern { font-weight: 700; color: #64748b; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #334155; background-color: #ffffff; }
    .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important; }

    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

{{-- ================= SCRIPTS ================= --}}
<script>
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
    
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
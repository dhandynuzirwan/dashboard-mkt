@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        {{-- Header Section --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Database Modul Pelatihan</h3>
                <h6 class="op-7 mb-2">Repositori sentral untuk modul dan materi pelatihan.</h6>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
                @if(in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic']))
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload me-1"></i> Upload Modul Baru
                    </button>
                @endif
            </div>
        </div>

        {{-- Validasi Alerts --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        {{-- Statistik Cards --}}
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Modul</p>
                                    <h4 class="card-title">{{ $totalModul }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-certificate"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">KEMNAKER</p>
                                    <h4 class="card-title">{{ $totalKemnaker }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-award"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">BNSP</p>
                                    <h4 class="card-title">{{ $totalBnsp }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Modul Bulan Ini</p>
                                    <h4 class="card-title">{{ $modulBulanIni }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2 Cards: Activity Log & Pie Chart --}}
        <div class="row mb-4">
            {{-- Aktivitas Terbaru --}}
            <div class="col-md-7">
                <div class="card card-round h-100">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Aktivitas Penambahan Terbaru</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th>Judul Modul</th>
                                        <th>Pengunggah</th>
                                        <th>Tanggal Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aktivitasTerbaru as $log)
                                    <tr>
                                        <td><strong>{{ $log->judul_modul }}</strong><br><small class="text-muted">{{ $log->kategori }} - {{ $log->sertifikasi }}</small></td>
                                        <td>{{ $log->pengupload->name ?? '-' }}</td>
                                        <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada aktivitas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pie Chart --}}
            <div class="col-md-5">
                <div class="card card-round h-100">
                    <div class="card-header">
                        <div class="card-title">Statistik Modul per Sertifikasi</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 250px">
                            <canvas id="kategoriPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Modul --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-3 p-3 bg-white rounded shadow-sm border border-light">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-success-transparent text-success rounded-circle text-center me-2"><i class="fas fa-check-circle"></i></div>
                        <div><span class="text-muted d-block" style="font-size: 11px">Total Aktif</span><strong class="fs-5">{{ $totalAktif }}</strong></div>
                    </div>
                    <div class="border-start mx-2"></div>
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-danger-transparent text-danger rounded-circle text-center me-2"><i class="fas fa-times-circle"></i></div>
                        <div><span class="text-muted d-block" style="font-size: 11px">Total Nonaktif</span><strong class="fs-5">{{ $totalNonaktif }}</strong></div>
                    </div>
                    <div class="border-start mx-2"></div>
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-primary-transparent text-primary rounded-circle text-center me-2"><i class="fas fa-download"></i></div>
                        <div><span class="text-muted d-block" style="font-size: 11px">Total Download</span><strong class="fs-5">{{ $totalDownloadAll }}</strong></div>
                    </div>
                    <div class="border-start mx-2"></div>
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-warning-transparent text-warning rounded-circle text-center me-2"><i class="fas fa-database"></i></div>
                        <div><span class="text-muted d-block" style="font-size: 11px">Total Ukuran File</span><strong class="fs-5">{{ $totalUkuranMB }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Table --}}
        <div class="card card-round">
            <div class="card-header bg-light">
                {{-- Tabs Sertifikasi --}}
                <ul class="nav nav-pills nav-secondary mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request('sertifikasi') == '' ? 'active' : '' }}" href="{{ route('modul.index', array_merge(request()->except('sertifikasi', 'page'))) }}">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('sertifikasi') == 'KEMNAKER' ? 'active' : '' }}" href="{{ route('modul.index', array_merge(request()->except('sertifikasi', 'page'), ['sertifikasi' => 'KEMNAKER'])) }}">KEMNAKER</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('sertifikasi') == 'BNSP' ? 'active' : '' }}" href="{{ route('modul.index', array_merge(request()->except('sertifikasi', 'page'), ['sertifikasi' => 'BNSP'])) }}">BNSP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('sertifikasi') == 'UPSKILLS' ? 'active' : '' }}" href="{{ route('modul.index', array_merge(request()->except('sertifikasi', 'page'), ['sertifikasi' => 'UPSKILLS'])) }}">UPSKILLS</a>
                    </li>
                </ul>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('modul.index') }}">
                    <input type="hidden" name="sertifikasi" value="{{ request('sertifikasi') }}">
                    <div class="row align-items-end g-2">
                        <div class="col-md-3">
                            <label class="form-label" style="font-size: 12px">Search Judul Modul</label>
                            <div class="input-icon">
                                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                                <span class="input-icon-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach($listKategori as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px">Pengajar</label>
                            <select name="pengajar" class="form-select">
                                <option value="">-- Semua Pengajar --</option>
                                @foreach($listPengajar as $pj)
                                    <option value="{{ $pj }}" {{ request('pengajar') == $pj ? 'selected' : '' }}>{{ $pj }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px">Tahun</label>
                            <select name="tahun" class="form-select">
                                <option value="">-- Semua Tahun --</option>
                                @foreach($listTahun as $thn)
                                    <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Semua Status --</option>
                                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-secondary w-100"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Informasi Modul</th>
                                <th width="20%">Pengajar & Waktu</th>
                                <th width="20%">Statistik File</th>
                                <th width="10%">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($moduls as $index => $modul)
                                <tr>
                                    <td>{{ $moduls->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark fs-6 mb-1">{{ $modul->judul_modul }}</strong>
                                            <div class="">
                                                <span class="badge badge-soft-info my-1"><i class="fas fa-certificate me-1"></i>{{ $modul->sertifikasi }}</span>
                                                <span class="badge badge-soft-secondary my-1"><i class="fas fa-tag me-1"></i>{{ $modul->kategori }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column text-muted" style="font-size: 13px;">
                                            <span class="mb-1"><i class="fas fa-user-tie me-2 text-primary" style="width: 14px;"></i>{{ $modul->pengajar }}</span>
                                            <span class="mb-1"><i class="fas fa-calendar-alt me-2 text-warning" style="width: 14px;"></i>Tahun: <strong>{{ $modul->tahun }}</strong></span>
                                            <span><i class="fas fa-upload me-2 text-success" style="width: 14px;"></i>Upload: {{ $modul->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column text-muted" style="font-size: 13px;">
                                            <span class="mb-1"><i class="fas fa-file-pdf me-2 text-danger" style="width: 14px;"></i>{{ number_format($modul->ukuran_file / 1048576, 2) }} MB</span>
                                            <span><i class="fas fa-download me-2 text-primary" style="width: 14px;"></i>{{ $modul->total_download }}x Diunduh</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($modul->status == 'Aktif')
                                            <span class="badge badge-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times-circle me-1"></i>Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('modul.preview', $modul->id) }}" target="_blank" class="btn btn-sm btn-info hover-lift" data-bs-toggle="tooltip" title="Preview">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('modul.preview', $modul->id) }}?print=true" target="_blank" class="btn btn-sm btn-secondary hover-lift" data-bs-toggle="tooltip" title="Print">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('modul.download', $modul->id) }}" class="btn btn-sm btn-primary hover-lift" data-bs-toggle="tooltip" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if(in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic']))
                                                <button type="button" class="btn btn-sm btn-warning btn-edit hover-lift" data-modul="{{ json_encode($modul) }}" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('modul.destroy', $modul->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger hover-lift" data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-folder-open text-muted mb-2" style="font-size: 32px;"></i>
                                            <h5 class="text-muted">Data Modul Tidak Ditemukan.</h5>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $moduls->links() }}
            </div>
        </div>

    </div>
</div>

{{-- Modal Upload Modul --}}
@if(in_array(auth()->user()->role, ['superadmin', 'web_dev', 'graphic']))
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="uploadModalLabel"><i class="fas fa-upload me-2"></i> Upload Modul Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('modul.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Perhatian:</strong> Ukuran file maksimal adalah 10 MB dan format yang diizinkan hanya <strong>.PDF</strong>.
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Judul Modul <span class="text-danger">*</span></label>
                            <input type="text" name="judul_modul" class="form-control" required placeholder="Masukkan judul modul...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sertifikasi <span class="text-danger">*</span></label>
                            <select name="sertifikasi" class="form-select" required>
                                <option value="">-- Pilih Sertifikasi --</option>
                                <option value="KEMNAKER">KEMNAKER</option>
                                <option value="BNSP">BNSP</option>
                                <option value="UPSKILLS">UPSKILLS</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori" class="form-control" required placeholder="Contoh: Operator, Teknik, K3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengajar <span class="text-danger">*</span></label>
                            <input type="text" name="pengajar" class="form-control" required placeholder="Nama Lengkap Pengajar">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" required value="{{ date('Y') }}" min="2000" max="2099">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">File Modul (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="file_modul" class="form-control" id="fileUpload" accept="application/pdf" required>
                            <small class="text-danger d-none mt-1" id="fileErrorMsg">Ukuran file melebihi 10 MB!</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitUpload">Simpan Modul</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Modul --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-2"></i> Edit Data Modul</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="formEditModul">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i> Kosongkan input File jika tidak ingin mengganti file lama. Maksimal 10 MB (.PDF).
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Judul Modul <span class="text-danger">*</span></label>
                            <input type="text" name="judul_modul" id="edit_judul" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sertifikasi <span class="text-danger">*</span></label>
                            <select name="sertifikasi" id="edit_sertifikasi" class="form-select" required>
                                <option value="KEMNAKER">KEMNAKER</option>
                                <option value="BNSP">BNSP</option>
                                <option value="UPSKILLS">UPSKILLS</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori" id="edit_kategori" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengajar <span class="text-danger">*</span></label>
                            <input type="text" name="pengajar" id="edit_pengajar" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" id="edit_tahun" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">File Modul (PDF)</label>
                            <input type="file" name="file_modul" class="form-control" id="fileEdit" accept="application/pdf">
                            <small class="text-danger d-none mt-1" id="fileEditErrorMsg">Ukuran file melebihi 10 MB!</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="btnSubmitEdit">Update Modul</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pie Chart Initialization
        var pieCtx = document.getElementById('kategoriPieChart');
        if(pieCtx) {
            var pieLabels = {!! json_encode($pieLabels) !!};
            var pieData = {!! json_encode($pieData) !!};

            var myPieChart = new Chart(pieCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: [
                            '#1d7af3', '#f3545d', '#fdaf4b', '#59d05d', '#177dff', '#716aca', '#2bb930', '#ff9e27'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }

        // File size validation for Upload
        const fileUpload = document.getElementById('fileUpload');
        const fileErrorMsg = document.getElementById('fileErrorMsg');
        const btnSubmitUpload = document.getElementById('btnSubmitUpload');
        
        if (fileUpload) {
            fileUpload.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileSize = this.files[0].size / 1024 / 1024; // MB
                    if (fileSize > 10) {
                        fileErrorMsg.classList.remove('d-none');
                        fileUpload.classList.add('is-invalid');
                        btnSubmitUpload.disabled = true;
                    } else {
                        fileErrorMsg.classList.add('d-none');
                        fileUpload.classList.remove('is-invalid');
                        btnSubmitUpload.disabled = false;
                    }
                }
            });
        }

        // Edit Modal Data Population
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const data = JSON.parse(this.getAttribute('data-modul'));
                
                document.getElementById('edit_judul').value = data.judul_modul;
                document.getElementById('edit_sertifikasi').value = data.sertifikasi;
                document.getElementById('edit_kategori').value = data.kategori;
                document.getElementById('edit_pengajar').value = data.pengajar;
                document.getElementById('edit_tahun').value = data.tahun;
                document.getElementById('edit_status').value = data.status;
                
                const form = document.getElementById('formEditModul');
                form.action = `/modul-pelatihan/${data.id}`;
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        // File size validation for Edit
        const fileEdit = document.getElementById('fileEdit');
        const fileEditErrorMsg = document.getElementById('fileEditErrorMsg');
        const btnSubmitEdit = document.getElementById('btnSubmitEdit');
        
        if (fileEdit) {
            fileEdit.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const fileSize = this.files[0].size / 1024 / 1024; // MB
                    if (fileSize > 10) {
                        fileEditErrorMsg.classList.remove('d-none');
                        fileEdit.classList.add('is-invalid');
                        btnSubmitEdit.disabled = true;
                    } else {
                        fileEditErrorMsg.classList.add('d-none');
                        fileEdit.classList.remove('is-invalid');
                        btnSubmitEdit.disabled = false;
                    }
                }
            });
        }
    });
</script>

<style>
    /* CSS MODERNISASI UI */
    .card-modern {
        border-radius: 16px;
        border: 1px solid #eef2f7;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .icon-modern {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #e0eaff !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-warning-subtle { background-color: #fef08a !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    .text-warning-dark { color: #b45309 !important; }

    .badge-soft-primary { background-color: #e0eaff !important; color: #3b82f6 !important; }
    .badge-soft-success { background-color: #dcfce7 !important; color: #16a34a !important; }
    .badge-soft-danger { background-color: #fee2e2 !important; color: #dc2626 !important; }
    .badge-soft-warning { background-color: #fef08a !important; color: #b45309 !important; }
    .badge-soft-info { background-color: #cff4fc !important; color: #0891b2 !important; }
    .badge-soft-secondary { background-color: #f3f4f6 !important; color: #4b5563 !important; }

    /* Segmented Tabs (Modern Toggle) */
    .nav-modern {
        background-color: #f1f5f9;
        padding: 4px;
        border-radius: 50px;
    }
    .nav-modern .nav-link {
        border-radius: 50px;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 24px;
        border: none;
        transition: all 0.3s ease;
        background: transparent;
    }
    .nav-modern .nav-link:hover {
        color: #0f172a;
    }
    .nav-modern .nav-link.active {
        background-color: #ffffff;
        color: #3b82f6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Alert Duplikat Modern */
    .alert-modern-danger {
        background-color: #fef2f2;
        border-left: 4px solid #ef4444;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .alert-modern-warning {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    /* Table Modern */
    .table-modern th {
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
    }
    .table-modern td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .label-modern {
        font-weight: 700;
        color: #64748b;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .input-modern {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        color: #334155;
    }
    .input-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
</style>
@endsection

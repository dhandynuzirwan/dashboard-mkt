@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 fade-in" style="background-color: #f8fafc00; min-height: 100vh;">
    <div class="row px-2 px-md-3">
        <div class="col-12">
            
            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-black text-dark mb-0"><i class="fas fa-history text-primary me-2"></i> Riwayat Pelatihan</h3>
                    <p class="text-muted mb-0 small">Kelola data pelaksanaan, sertifikasi, dan pengiriman paket pelatihan.</p>
                </div>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold hover-lift" data-bs-toggle="modal" data-bs-target="#addRiwayatModal">
                    <i class="fas fa-plus me-1"></i> Input Data Riwayat
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm bg-success-subtle mb-4" role="alert">
                    <i class="fas fa-check-circle text-success me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Filter Bar --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white fade-in">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 13px;">
                            <i class="fas fa-filter"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">Filter Data Pelatihan</h6>
                    </div>
                    
                    <form action="{{ route('riwayat.pelatihan') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Bulan & Tahun</label>
                            <input type="month" name="month_year" class="form-control form-control-sm rounded-3 px-3 py-2" value="{{ request('month_year') }}">
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Jenis Pelatihan</label>
                            <select name="jenis" class="form-select form-select-sm rounded-3 px-3 py-2">
                                <option value="">Semua Jenis</option>
                                @foreach($listJenis as $j)
                                    <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="form-label fw-bold small text-muted">Metode</label>
                            <select name="metode" class="form-select form-select-sm rounded-3 px-3 py-2">
                                <option value="">Semua Metode</option>
                                @foreach($listMetode as $m)
                                    <option value="{{ $m }}" {{ request('metode') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm rounded-pill fw-bold px-4 flex-grow-1 hover-lift">Terapkan</button>
                            <a href="{{ route('riwayat.pelatihan') }}" class="btn btn-light btn-sm border rounded-pill px-3 fw-bold hover-lift text-muted" title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Stat Cards Modern --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Pelatihan (Batch)</p>
                                <h3 class="fw-black text-dark mb-0">{{ number_format($totalPelatihan) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Sertifikat Terbit (Peserta)</p>
                                <h3 class="fw-black text-dark mb-0">{{ number_format($totalSertifikatTerbit) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="icon-circle bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; font-size: 24px;">
                                <i class="fas fa-hourglass-half text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Sertifikat Pending (Peserta)</p>
                                <h3 class="fw-black text-dark mb-0">{{ number_format($totalSertifikatPending) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="row g-3 mb-4 fade-in">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                            <h6 class="fw-bolder mb-0"><i class="fas fa-chart-bar text-primary me-2"></i> Grafik Trend (6 Bulan Terakhir)</h6>
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
                            @if(count($chartJenisData['labels']) > 0)
                                <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
                                    <canvas id="jenisChart"></canvas>
                                </div>
                            @else
                                <div class="text-muted text-center py-5">
                                    <i class="fas fa-chart-pie fa-3x opacity-25 mb-3"></i>
                                    <p class="mb-0 small">Belum ada data untuk ditampilkan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Data --}}
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
                                @forelse($riwayat as $index => $item)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $riwayat->firstItem() + $index }}</td>
                                    
                                    {{-- Kolom Info Pelatihan --}}
                                    <td>
                                        <div class="fw-bolder text-dark mb-1 text-wrap" style="max-width: 250px; font-size: 14px;">{{ $item->judul_pelatihan }}</div>
                                        <div class="text-muted small mb-1">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i> 
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                        </div>
                                        <span class="badge bg-light text-dark border">{{ $item->jenis }}</span>
                                        <span class="badge bg-light text-dark border">{{ $item->metode }}</span>
                                    </td>
                                    
                                    {{-- Kolom Peserta --}}
                                    <td>
                                        <div class="fw-bold text-dark text-wrap" style="max-width: 200px;">{{ $item->instansi_peserta ?? '-' }}</div>
                                        <div class="text-muted small my-1">
                                            <i class="fas fa-users text-warning me-1"></i> <b class="text-dark">{{ $item->jumlah_peserta }}</b> Peserta
                                        </div>
                                        <div class="text-muted small text-truncate" style="max-width: 200px;" title="{{ $item->nama_peserta }}">{{ $item->nama_peserta }}</div>
                                    </td>
                                    
                                    {{-- Kolom Tim & PIC --}}
                                    <td>
                                        <div class="small mb-1"><span class="text-muted">Trainer:</span> <span class="fw-bold text-dark">{{ \Illuminate\Support\Str::limit($item->nama_trainer ?? '-', 15) }}</span></div>
                                        <div class="small mb-1"><span class="text-muted">LSP:</span> <span class="fw-bold text-dark">{{ \Illuminate\Support\Str::limit($item->nama_lsp ?? '-', 15) }}</span></div>
                                        <div class="small"><span class="text-muted">PIC:</span> <span class="text-primary fw-bold">{{ $item->pic ?? '-' }}</span> <span class="text-muted">| Mkt:</span> {{ $item->marketing ?? '-' }}</div>
                                    </td>
                                    
                                    {{-- Kolom Sertifikasi --}}
                                    <td>
                                        <div class="mb-1">
                                            @if($item->status_sertif == 'Sudah Terbit')
                                                <span class="badge bg-success-subtle text-success px-2 py-1"><i class="fas fa-check-circle me-1"></i>Sertif Terbit</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1"><i class="fas fa-clock me-1"></i>Sertif Pending</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($item->status_kompeten == 'Kompeten')
                                                <span class="badge bg-info-subtle text-info-emphasis px-2 py-1">Kompeten</span>
                                            @elseif($item->status_kompeten == 'Belum')
                                                <span class="badge bg-danger-subtle text-danger px-2 py-1">Belum Kompeten</span>
                                            @else
                                                <span class="badge bg-light text-muted border px-2 py-1">Belum Asesmen</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    {{-- Kolom Pengiriman --}}
                                    <td>
                                        <div class="mb-1">
                                            @if($item->status_pengiriman == 'Dikirim')
                                                <span class="badge bg-primary-subtle text-primary"><i class="fas fa-truck me-1"></i> Dikirim</span>
                                            @elseif($item->status_pengiriman == 'Diterima')
                                                <span class="badge bg-success-subtle text-success"><i class="fas fa-box-open me-1"></i> Diterima</span>
                                            @elseif($item->status_pengiriman == 'Diproses')
                                                <span class="badge bg-warning-subtle text-warning-emphasis"><i class="fas fa-box me-1"></i> Diproses</span>
                                            @else
                                                <span class="badge bg-light text-muted border">Belum Info</span>
                                            @endif
                                        </div>
                                        <div class="small text-muted">Resi: <span class="fw-bold text-dark">{{ $item->no_resi ?? '-' }}</span></div>
                                    </td>
                                    
                                    {{-- Aksi --}}
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold hover-lift" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                {{-- ================= MODAL DETAIL SUPER RAPI & MODERN ================= --}}
                                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        
                                        {{-- Header Modal --}}
                                        <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                                            <h5 class="modal-title fw-black text-dark"><i class="fas fa-file-invoice me-2 text-primary"></i> Detail Informasi Pelatihan</h5>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                        
                                        {{-- Body Modal --}}
                                        <div class="modal-body p-4">
                                            
                                            {{-- 1. Hero / Title Section --}}
                                            <div class="bg-primary-subtle rounded-4 p-4 mb-4 position-relative overflow-hidden">
                                                {{-- Decorative Icon Background --}}
                                                <i class="fas fa-graduation-cap position-absolute text-primary" style="font-size: 8rem; right: -20px; bottom: -20px; opacity: 0.1;"></i>
                                               <div class="position-relative z-1 text-start"> {{-- 🔥 Ditambahkan text-start agar semua konten di dalam box ini rata kiri murni --}}
                                                    {{-- 🔥 BADGE DIATAS JUDUL & RATA KIRI RAPAT 🔥 --}}
                                                        <span class="badge bg-primary px-3 py-1 fs-6 rounded-pill shadow-sm">{{ $item->jenis ?? 'N/A' }}</span>
                                                        <span class="badge bg-white text-dark px-3 py-1 fs-6 rounded-pill shadow-sm border">{{ $item->metode ?? 'N/A' }}</span>
                                                    <h4 class="fw-black text-dark mb-1 mt-2">{{ $item->judul_pelatihan }}</h4>
                                                    
                                                    <p class="text-primary mb-0 fw-bold">
                                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                        
                                            <div class="row g-4">
                                                {{-- ================= KOLOM KIRI ================= --}}
                                                <div class="col-lg-6">
                                                    
                                                    {{-- Block: Instansi & Peserta (Paling Atas Kiri) --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bolder text-dark mb-3 border-bottom border-2 pb-2"><i class="fas fa-building text-primary me-2"></i> Instansi & Peserta</h6>
                                                        <div class="row g-3">
                                                            <div class="col-sm-6">
                                                                <div class="text-muted small fw-bold mb-1">Instansi / Perusahaan</div>
                                                                <div class="fw-bolder text-dark" style="font-size: 15px;">{{ $item->instansi_peserta ?? '-' }}</div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="text-muted small fw-bold mb-1">Jumlah Peserta</div>
                                                                <div class="fw-bolder text-dark"><span class="badge bg-warning text-dark px-2 py-1 fs-6 me-1">{{ $item->jumlah_peserta ?? 0 }}</span> Orang</div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="text-muted small fw-bold mb-1">Daftar Nama Peserta</div>
                                                                <div class="bg-light p-3 rounded-3 border">
                                                                    <div class="fw-bold text-dark mb-1">{{ $item->nama_peserta ?? '-' }}</div>
                                                                    <div class="text-success small fw-bold"><i class="fab fa-whatsapp fs-6 me-1"></i> {{ $item->wa_peserta ?? '-' }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="text-muted small fw-bold mb-1">Syarat Kelengkapan</div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @if($item->syarat_peserta)
                                                                        <a href="{{ $item->syarat_peserta }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3"><i class="fas fa-link me-1"></i> Link GDrive</a>
                                                                    @else
                                                                        <span class="text-muted fst-italic">Tidak ada link</span>
                                                                    @endif
                                                                    <span class="badge {{ $item->ket_syarat == 'Lengkap' ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill">{{ $item->ket_syarat ?? 'Belum Lengkap' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    {{-- Block: Tim Eksekutor (Bawah Kiri) --}}
                                                    <div>
                                                        <h6 class="fw-bolder text-dark mb-3 border-bottom border-2 pb-2"><i class="fas fa-users-cog text-success me-2"></i> Tim Eksekutor</h6>
                                                        <div class="bg-light rounded-4 p-4 border">
                                                            <div class="row g-3">
                                                                <div class="col-sm-6">
                                                                    <div class="text-muted small fw-bold mb-1">Nama Trainer</div>
                                                                    <div class="fw-bold text-dark">{{ $item->nama_trainer ?? '-' }}</div>
                                                                    <div class="text-success small fw-bold"><i class="fab fa-whatsapp"></i> {{ $item->wa_trainer ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="text-muted small fw-bold mb-1">LSP & Asesor</div>
                                                                    <div class="fw-bold text-dark">{{ $item->nama_asesor ?? '-' }}</div>
                                                                    <div class="text-muted small"><i class="fas fa-building"></i> {{ $item->nama_lsp ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-12 border-top my-2"></div>
                                                                <div class="col-sm-6">
                                                                    <div class="text-muted small fw-bold mb-1">PIC Operasional</div>
                                                                    <div class="fw-bolder text-primary fs-6">{{ $item->pic ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="text-muted small fw-bold mb-1">Marketing</div>
                                                                    <div class="fw-bold text-dark">{{ $item->marketing ?? '-' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                        
                                                {{-- ================= KOLOM KANAN ================= --}}
                                                <div class="col-lg-6">
                                                    
                                                    {{-- Block: Sertifikasi & File (Paling Atas Kanan - Sejajar dengan Instansi Kiri) --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bolder text-dark mb-3 border-bottom border-2 pb-2"><i class="fas fa-award text-warning me-2"></i> Sertifikasi & Berkas Lengkap</h6>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-sm-6">
                                                                <div class="text-muted small fw-bold mb-2">Status Kompetensi</div>
                                                                <div>
                                                                    @if($item->status_kompeten == 'Kompeten')
                                                                        <span class="badge bg-success-subtle text-success px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-check-circle me-1"></i> Kompeten</span>
                                                                    @elseif($item->status_kompeten == 'Belum')
                                                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-times-circle me-1"></i> Belum Kompeten</span>
                                                                    @else
                                                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-minus-circle me-1"></i> Belum Asesmen</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="text-muted small fw-bold mb-2">Status Sertifikat</div>
                                                                <div>
                                                                    @if($item->status_sertif == 'Sudah Terbit')
                                                                        <span class="badge bg-primary-subtle text-primary px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-certificate me-1"></i> Telah Terbit</span>
                                                                    @else
                                                                        <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 fs-6 w-100 text-start shadow-sm"><i class="fas fa-clock me-1"></i> Masih Pending</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-muted small fw-bold mb-2 mt-4">Unduh Berkas Pendukung</div>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @if($item->cv)<a href="{{ asset('storage/'.$item->cv) }}" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-file-pdf text-danger me-1"></i> CV</a>@endif
                                                            @if($item->modul)<a href="{{ asset('storage/'.$item->modul) }}" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-book text-primary me-1"></i> Modul</a>@endif
                                                            @if($item->laporan_pic)<a href="{{ asset('storage/'.$item->laporan_pic) }}" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-file-alt text-success me-1"></i> Laporan</a>@endif
                                                            @if($item->scan_sertif)<a href="{{ asset('storage/'.$item->scan_sertif) }}" target="_blank" class="btn btn-sm btn-white border fw-bold hover-lift px-3"><i class="fas fa-award text-warning me-1"></i> Scan Sertif</a>@endif
                                                            
                                                            @if(!$item->cv && !$item->modul && !$item->laporan_pic && !$item->scan_sertif)
                                                                <span class="text-muted fst-italic bg-light px-3 py-2 rounded-3 w-100 text-center border">Belum ada berkas yang diunggah.</span>
                                                            @endif
                                                        </div>
                                                    </div>
                        
                                                    {{-- Block: Pengiriman (Bawah Kanan) --}}
                                                    <div>
                                                        <h6 class="fw-bolder text-dark mb-3 border-bottom border-2 pb-2"><i class="fas fa-truck-fast text-info me-2"></i> Logistik & Pengiriman</h6>
                                                        <div class="bg-info-subtle border border-info border-opacity-25 rounded-4 p-4 position-relative">
                                                            {{-- Watermark Icon --}}
                                                            <i class="fas fa-box-open position-absolute text-info opacity-25" style="font-size: 5rem; right: 10px; bottom: 10px;"></i>
                                                            
                                                            <div class="d-flex justify-content-between align-items-center mb-3 position-relative z-1">
                                                                <div>
                                                                    <div class="text-info-emphasis small fw-bold mb-1">Status Paket</div>
                                                                    <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm">{{ $item->status_pengiriman ?? 'Belum Info' }}</span>
                                                                </div>
                                                                <div class="text-end">
                                                                    <div class="text-info-emphasis small fw-bold mb-1">Nomor Resi</div>
                                                                    <div class="fw-black text-dark fs-5 bg-white px-3 py-1 rounded-3 shadow-sm border">{{ $item->no_resi ?? '-' }}</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row g-3 small position-relative z-1 mt-1">
                                                                <div class="col-12">
                                                                    <div class="text-info-emphasis fw-bold">Penerima & Alamat:</div>
                                                                    <div class="fw-bold text-dark"><i class="fas fa-user-circle me-1 text-info"></i> {{ $item->nama_penerima ?? '-' }} <span class="text-muted fw-normal">({{ $item->wa_penerima ?? '-' }})</span></div>
                                                                    <div class="text-dark mt-1"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $item->alamat_pengiriman ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="text-info-emphasis fw-bold">Isi Paket:</div>
                                                                    <div class="text-dark">{{ $item->isi_paket ?? '-' }}</div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="text-info-emphasis fw-bold">Tanggal Proses:</div>
                                                                    <div class="text-dark">{{ $item->tanggal_kirim ? \Carbon\Carbon::parse($item->tanggal_kirim)->format('d M Y') : '-' }} <i class="fas fa-arrow-right mx-1 text-muted"></i> {{ $item->tanggal_diterima ? \Carbon\Carbon::parse($item->tanggal_diterima)->format('d M Y') : 'Belum Diterima' }}</div>
                                                                </div>
                                                                
                                                                @if($item->foto)
                                                                <div class="col-12 mt-3">
                                                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="btn btn-info text-white rounded-pill px-4 fw-bold shadow-sm w-100"><i class="fas fa-image me-2"></i> Lihat Foto Bukti Resi</a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                        
                                            {{-- Block: Catatan (Full Width di bawah) --}}
                                            @if($item->catatan || $item->keterangan_tambahan)
                                            <div class="mt-4 pt-4 border-top">
                                                <div class="d-flex align-items-start bg-warning-subtle p-3 rounded-4 border border-warning border-opacity-25">
                                                    <div class="text-warning fs-2 me-3"><i class="fas fa-sticky-note mt-1"></i></div>
                                                    <div>
                                                        <h6 class="fw-bolder text-dark mb-2">Catatan Khusus Pelatihan</h6>
                                                        @if($item->keterangan_tambahan)<p class="small text-dark mb-1"><strong>Sertifikasi:</strong> {{ $item->keterangan_tambahan }}</p>@endif
                                                        @if($item->catatan)<p class="small text-dark mb-0"><strong>Logistik:</strong> {{ $item->catatan }}</p>@endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                        
                                        </div>
                                        
                                        {{-- Footer Modal --}}
                                        <div class="modal-footer bg-light border-top-0 py-3 px-4 rounded-bottom-4">
                                            <button type="button" class="btn btn-secondary btn-lg rounded-pill px-5 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                            <h6 class="fw-bold">Belum ada data pelatihan</h6>
                                            <p class="small mb-0">Data riwayat yang ditambahkan akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 bg-white border-top">
                        {{ $riwayat->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL TAMBAH DATA (DI DESAIN ULANG) ================= --}}
<div class="modal fade" id="addRiwayatModal" tabindex="-1" aria-labelledby="addRiwayatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form action="{{ route('riwayat.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
            <h5 class="modal-title fw-bold" id="addRiwayatModalLabel"><i class="fas fa-plus-circle me-2"></i> Input Data Riwayat Pelatihan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto; background-color: #f8fafc;">
              
              {{-- Section 1: Informasi Pelatihan --}}
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
                              <input type="number" name="jumlah_peserta" class="form-control rounded-3" required min="1">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Jenis Pelatihan</label>
                              <select name="jenis" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  <option value="Sertifikat KEMNAKER">Sertifikat KEMNAKER</option>
                                  <option value="Sertifikat BNSP">Sertifikat BNSP</option>
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
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Instansi Peserta</label>
                              <textarea name="instansi_peserta" class="form-control rounded-3" rows="2"></textarea>
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Daftar Nama Peserta</label>
                              <textarea name="nama_peserta" class="form-control rounded-3" rows="2"></textarea>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">WA Peserta</label>
                              <input type="text" name="wa_peserta" class="form-control rounded-3">
                          </div>
                          <div class="col-md-5">
                              <label class="form-label fw-bold small">Syarat Peserta (Link Drive)</label>
                              <input type="url" name="syarat_peserta" class="form-control rounded-3" placeholder="https://drive.google.com/...">
                          </div>
                          <div class="col-md-3">
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

              {{-- Section 2: Tim Eksekutor --}}
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
                              <input type="file" name="cv" class="form-control rounded-3" accept=".pdf,.doc,.docx">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label fw-bold small">Upload Modul</label>
                              <input type="file" name="modul" class="form-control rounded-3">
                          </div>
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

              {{-- Section 3: Sertifikasi & PIC --}}
              <div class="card border-0 shadow-sm rounded-4 mb-4">
                  <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                      <h6 class="fw-bold text-warning mb-0" style="color: #d97706 !important;">3. PIC & Status Sertifikasi</h6>
                  </div>
                  <div class="card-body p-4">
                      <div class="row g-3">
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">PIC Operasional</label>
                              <select name="pic" class="form-select rounded-3">
                                  <option value="">Pilih PIC...</option>
                                  @foreach($users as $user)
                                      <option value="{{ $user->name }}">{{ $user->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Marketing</label>
                              <select name="marketing" class="form-select rounded-3">
                                  <option value="">Pilih...</option>
                                  @foreach($marketings as $mkt)
                                      <option value="{{ $mkt->name }}">{{ $mkt->nama_lengkap ?: $mkt->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-4">
                              <label class="form-label fw-bold small">Laporan PIC (File)</label>
                              <input type="file" name="laporan_pic" class="form-control rounded-3">
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
                              <input type="file" name="scan_sertif" class="form-control rounded-3">
                          </div>
                          <div class="col-12">
                              <label class="form-label fw-bold small">Keterangan Tambahan</label>
                              <textarea name="keterangan_tambahan" class="form-control rounded-3" rows="2" placeholder="Catatan tambahan sertifikasi..."></textarea>
                          </div>
                      </div>
                  </div>
              </div>

              {{-- Section 4: Pengiriman --}}
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Chart 1: Bar Chart (Trend 6 Bulan)
        var ctx1 = document.getElementById('riwayatChart').getContext('2d');
        var chartData = @json($chartData);
        
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Total Peserta',
                        data: chartData.dataPeserta,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)', // Primary Blue
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 0,
                        borderRadius: 6,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Jumlah Pelatihan',
                        data: chartData.dataPelatihan,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)', // Success Green
                        borderColor: 'rgba(5, 150, 105, 1)',
                        borderWidth: 0,
                        borderRadius: 6,
                        barPercentage: 0.6
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
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#e2e8f0' },
                        ticks: { precision: 0, color: '#64748b' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { weight: 'bold' } }
                    }
                }
            }
        });

        // Chart 2: Doughnut Chart (Proporsi Jenis)
        var canvas2 = document.getElementById('jenisChart');
        if (canvas2) {
            var ctx2 = canvas2.getContext('2d');
            var chartJenisData = @json($chartJenisData);
            
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

    });
</script>
@endpush
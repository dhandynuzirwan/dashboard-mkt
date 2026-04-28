@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Pipeline Marketing</h3>
                <h6 class="text-muted mb-2 fw-normal">Laporan Terintegrasi & Pipeline Prospek</h6>
                
                {{-- Jam Realtime Modern --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border" style="background-color: #ffffff; color: #6366f1; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>
        
        {{-- ================= FILTER SECTION ================= --}}
        <div class="card card-modern mb-4 fade-in">
            <div class="card-body p-3 p-md-4">
                {{-- Header Filter --}}
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Data</h6>
                </div>

                <form action="{{ route('prospek.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern" value="{{ $start }}">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern" value="{{ $end }}">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Marketing</label>
                        <select name="marketing_id" class="form-select form-select-sm input-modern">
                            <option value="">Semua Marketing</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Tipe Sumber</label>
                        <select name="sumber_tipe" class="form-select form-select-sm input-modern">
                            <option value="">Semua Tipe</option>
                            <option value="ads" {{ request('sumber_tipe') == 'ads' ? 'selected' : '' }}>Ads / Iklan</option>
                            <option value="organik" {{ request('sumber_tipe') == 'organik' ? 'selected' : '' }}>Organik (Non-Ads)</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Tahap CTA</label>
                        <select name="cta_status" class="form-select form-select-sm input-modern">
                            <option value="">Semua Tahap</option>
                            <option value="pending" {{ request('cta_status') == 'pending' ? 'selected' : '' }}>🚩 Belum di-CTA</option>
                            <option value="done" {{ request('cta_status') == 'done' ? 'selected' : '' }}>✅ Sudah di-CTA</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <label class="label-modern">Status Penawaran</label>
                        <select name="status" class="form-select form-select-sm input-modern">
                            <option value="">Semua Status</option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Cancel</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                            <option value="kalah_harga" {{ request('status') == 'kalah_harga' ? 'selected' : '' }}>Kalah Harga</option>
                            <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <label class="label-modern">Status Catatan (Prospek)</label>
                        <select name="status_akhir" class="form-select form-select-sm input-modern">
                            <option value="">Semua Status</option>
                            <option value="belum_ada_status" {{ request('status_akhir') == 'belum_ada_status' ? 'selected' : '' }}>⚠️ Belum Ada Status</option>
                            @foreach ($all_status_akhir as $status)
                                @if(!empty($status))
                                    <option value="{{ $status }}" {{ request('status_akhir') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-9 d-flex gap-2 justify-content-md-end mt-4 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('prospek.index') }}" class="btn btn-white btn-sm btn-round fw-bold border px-4 hover-lift text-dark">
                            <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= STATS CARDS (MODERN UI) ================= --}}
        <div class="row mb-3 fade-in">
            {{-- Total Prospek --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Prospek</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['total_prospek']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Penawaran --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Penawaran</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['total_cta']) }}</h3>
                                <span class="badge badge-soft-info" style="font-size: 10px;">
                                    {{ $stats['total_prospek'] > 0 ? round(($stats['total_cta'] / $stats['total_prospek']) * 100, 1) : 0 }}% Rate
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nilai Pipeline --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Potensi Omzet</p>
                            <h4 class="fw-bolder text-dark mb-0 lh-1">Rp {{ number_format($stats['total_nilai'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Deal --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Project Deal</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['total_deal']) }}</h3>
                                <span class="badge badge-soft-warning" style="font-size: 10px;">
                                    {{ $stats['total_cta'] > 0 ? round(($stats['total_deal'] / $stats['total_cta']) * 100, 1) : 0 }}% Closing
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= BUTTON & SEARCH ================= --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 fade-in">
            <div class="d-flex gap-2">
                <button class="btn btn-success btn-sm btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#requestModal">
                    <i class="fas fa-file-excel me-1"></i> Download Excel
                </button>
                <a href="{{ route('prospek.check') }}" class="btn btn-white btn-sm btn-round border fw-bold text-dark shadow-sm hover-lift">
                    <i class="fas fa-sync-alt text-primary me-1"></i> Cek Sinkronisasi
                </a>
            </div>
            
            <div class="col-md-4 col-12">
                <form action="{{ route('prospek.index') }}" method="GET" class="input-group shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <input type="hidden" name="marketing_id" value="{{ request('marketing_id') }}">
                    <input type="hidden" name="status_akhir" value="{{ request('status_akhir') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="cta_status" value="{{ request('cta_status') }}">

                    <span class="input-group-text bg-white border-end-0 text-muted px-3"><i class="fas fa-search"></i></span>
                    <input type="text" name="search_perusahaan" class="form-control border-start-0 border-end-0 ps-0 shadow-none" placeholder="Cari Nama Perusahaan..." value="{{ request('search_perusahaan') }}">
                    
                    @if(request('search_perusahaan'))
                        <a href="{{ route('prospek.index', request()->except('search_perusahaan')) }}" class="btn btn-white border-start-0 border-top border-bottom text-danger">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                    <button class="btn btn-primary fw-bold px-3" type="submit">Cari</button>
                </form>
            </div>
        </div>

        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-prospek-tab" data-bs-toggle="pill" data-bs-target="#pills-prospek" type="button" role="tab">
                    <i class="fas fa-database me-1"></i> Data Prospek (Leads)
                </button>
                <button class="nav-link" id="pills-cta-tab" data-bs-toggle="pill" data-bs-target="#pills-cta" type="button" role="tab">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Data CTA Marketing
                </button>
            </div>
        </div>
        
        {{-- 🔥 ALERT DUPLIKAT PROSPEK 🔥 --}}
        @if(isset($duplicateGroups) && $duplicateGroups->count() > 0)
        <div class="alert alert-modern-danger mb-4 fade-in">
            <div class="d-flex align-items-start">
                <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-circle animate-pulse"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-danger">Terdeteksi Data Prospek Duplikat!</h6>
                    <p class="mb-3 small text-dark opacity-75">
                        Terdapat <b class="text-danger">{{ $duplicateGroups->count() }} kelompok perusahaan</b> dengan nama dan lokasi yang sama. Harap bersihkan data agar laporan tetap akurat.
                    </p>
                    <button class="btn btn-sm btn-danger btn-round shadow-sm fw-bold px-3 hover-lift" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDuplicates">
                        <i class="fas fa-search me-1"></i> Tinjau & Bersihkan
                    </button>

                    <div class="collapse mt-3" id="collapseDuplicates">
                        <div class="card card-body bg-white border-0 shadow-sm p-0 rounded-4 overflow-hidden">
                            <form action="{{ route('prospek.massDelete') }}" method="POST">
                                @csrf @method('DELETE')
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-modern table-hover mb-0">
                                        <thead class="bg-light sticky-top">
                                            <tr>
                                                <th width="40" class="text-center"><i class="fas fa-check-square"></i></th>
                                                <th>Perusahaan & Lokasi</th>
                                                <th>Marketing PIC</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Status & Keterangan</th>
                                                <th width="100" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($duplicateGroups as $groupName => $items)
                                                <tr>
                                                    <td colspan="6" class="bg-danger-subtle text-danger fw-bold border-bottom-0 py-2">
                                                        <i class="fas fa-building me-1"></i> {{ $groupName }} 
                                                        <span class="badge bg-danger ms-2 rounded-pill">{{ $items->count() }} Data Sama</span>
                                                    </td>
                                                </tr>
                                                @foreach($items as $index => $item)
                                                    <tr>
                                                        <td class="text-center align-middle">
                                                            <input type="checkbox" name="selected_prospek[]" value="{{ $item->id }}" class="form-check-input border-danger">
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="fw-bold text-dark">{{ $item->perusahaan }}</span><br>
                                                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $item->lokasi ?? '-' }}</small>
                                                        </td>
                                                        <td class="align-middle text-dark fw-medium">
                                                            {{ $item->marketing->name ?? 'Belum Diassign' }}
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="text-dark fw-medium">{{ $item->created_at->format('d M Y') }}</span><br>
                                                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                                            @if($index === 0)
                                                                <br><span class="badge badge-soft-success mt-1">Asli (Tertua)</span>
                                                            @else
                                                                <br><span class="badge badge-soft-danger mt-1">Duplikat (Baru)</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="fw-bold text-dark">{{ $item->status ?? '-' }}</span>
                                                            <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                                {!! \Illuminate\Support\Str::autoLink($item->catatan ?? 'Tidak ada catatan') !!}
                                                            </small>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <a href="{{ route('prospek.edit', $item->id) }}" target="_blank" class="btn btn-sm btn-white border text-primary rounded-pill hover-lift shadow-sm px-3">Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                                    <small class="text-muted">* Centang data yang ingin dihapus permanen.</small>
                                    <button type="submit" class="btn btn-danger btn-round shadow-sm fw-bold px-4 hover-lift" onclick="return confirm('Hapus permanen data terpilih?')">
                                        <i class="fas fa-trash-alt me-1"></i> Eksekusi Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- 🔥 ALERT DUPLIKAT CTA 🔥 --}}
        @if(isset($duplicateCtaGroups) && $duplicateCtaGroups->count() > 0)
        <div class="alert alert-modern-warning mb-4 fade-in">
            <div class="d-flex align-items-start">
                <div class="icon-sm bg-white text-warning-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                    <i class="fas fa-copy animate-pulse"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">Terdeteksi Data Penawaran (CTA) Duplikat!</h6>
                    <p class="mb-3 small text-dark opacity-75">
                        Terdapat <b class="text-danger">{{ $duplicateCtaGroups->count() }} kelompok penawaran</b> dengan Perusahaan dan Judul yang sama persis.
                    </p>
                    <button class="btn btn-sm btn-warning btn-round shadow-sm fw-bold px-3 text-dark hover-lift" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDuplicateCTA">
                        <i class="fas fa-search me-1"></i> Tinjau CTA Duplikat
                    </button>

                    <div class="collapse mt-3" id="collapseDuplicateCTA">
                        <div class="card card-body bg-white border-0 shadow-sm p-0 rounded-4 overflow-hidden">
                            <form action="{{ route('cta.massDelete') }}" method="POST">
                                @csrf
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-modern table-hover mb-0">
                                        <thead class="bg-light sticky-top">
                                            <tr>
                                                <th width="40" class="text-center"><i class="fas fa-check-square"></i></th>
                                                <th width="250">Program & Judul CTA</th>
                                                <th>Finansial & Peserta</th>
                                                <th>Status & Keterangan</th>
                                                <th>Waktu Input</th>
                                                <th width="100" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($duplicateCtaGroups as $groupName => $items)
                                                <tr>
                                                    <td colspan="6" class="bg-warning-subtle text-dark fw-bold border-bottom-0 py-2">
                                                        <i class="fas fa-file-invoice-dollar me-1 text-warning-dark"></i> {{ $groupName }} 
                                                        <span class="badge bg-warning text-dark ms-2 rounded-pill">{{ $items->count() }} Data Sama</span>
                                                    </td>
                                                </tr>
                                                @foreach($items as $index => $item)
                                                    <tr>
                                                        <td class="text-center align-middle">
                                                            <input type="checkbox" name="selected_cta[]" value="{{ $item->id }}" class="form-check-input border-warning">
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="fw-bold text-primary">{{ $item->judul_permintaan ?? '-' }}</span><br>
                                                            <span class="badge badge-soft-info my-1">{{ strtoupper($item->sertifikasi ?? 'NON-SERTIFIKASI') }}</span><br>
                                                            <small class="text-dark fw-medium d-block text-truncate" style="max-width: 230px;">{{ $item->skema ?? '-' }}</small>
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="d-flex justify-content-between mb-1 small">
                                                                <span class="text-muted">Hrg Jual:</span>
                                                                <span class="text-success fw-bold">Rp {{ number_format($item->harga_penawaran, 0, ',', '.') }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between pt-1 border-top small">
                                                                <span class="text-muted fw-bold">Total ({{ $item->jumlah_peserta }} Org):</span>
                                                                <span class="text-dark fw-bolder">Rp {{ number_format(($item->harga_penawaran ?? 0) * ($item->jumlah_peserta ?? 1), 0, ',', '.') }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="badge bg-dark rounded-pill mb-1">{{ strtoupper($item->status_penawaran ?? '-') }}</span>
                                                            <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                                {!! \Illuminate\Support\Str::autoLink($item->keterangan ?? 'Tidak ada keterangan') !!}
                                                            </small>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</span><br>
                                                            <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                                            @if($index === 0)
                                                                <br><span class="badge badge-soft-success mt-1">Asli (Tertua)</span>
                                                            @else
                                                                <br><span class="badge badge-soft-danger mt-1">Duplikat</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <a href="{{ route('cta.edit', $item->id) }}" target="_blank" class="btn btn-sm btn-white border text-primary rounded-pill hover-lift shadow-sm px-3">Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                                    <small class="text-muted">* Prospek induk <b>tidak</b> akan terhapus.</small>
                                    <button type="submit" class="btn btn-warning text-dark fw-bold btn-round shadow-sm px-4 hover-lift" onclick="return confirm('Hapus permanen CTA terpilih?')">
                                        <i class="fas fa-trash-alt me-1"></i> Eksekusi Hapus CTA
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ================= TAB CONTENT ================= --}}
        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            
            {{-- TAB 1: DATA PROSPEK --}}
            <div class="tab-pane fade show active" id="pills-prospek" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <form action="{{ route('prospek.massDelete') }}" method="POST" id="formMassDelete">
                            @csrf @method('DELETE')
                            
                            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                            <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="m-0 fw-bold text-dark"><i class="fas fa-list text-primary me-2"></i>Daftar Prospek Masuk</h6>
                                <button type="button" class="btn btn-danger btn-sm btn-round fw-bold shadow-sm" id="btnHapusTerpilih" disabled>
                                    <i class="fas fa-trash-alt me-1"></i> Hapus <span id="countSelected">0</span> Terpilih
                                </button>
                            </div>
                            @endif
                        
                            <div class="table-responsive">
                                <table class="table table-modern table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="50" class="text-center"><input type="checkbox" id="checkAllProspek" class="form-check-input shadow-none"></th>
                                            <th width="100">ID & TGL</th>
                                            <th width="250">
                                                <a href="{{ route('prospek.index', array_merge(request()->query(), [
                                                    'sort_by' => 'perusahaan',
                                                    'sort_order' => request('sort_by') == 'perusahaan' && request('sort_order') == 'asc' ? 'desc' : 'asc'
                                                ])) }}" class="text-dark d-flex justify-content-between align-items-center text-decoration-none">
                                                    PERUSAHAAN
                                                    <i class="fas {{ request('sort_by') == 'perusahaan' ? (request('sort_order') == 'asc' ? 'fa-sort-alpha-down' : 'fa-sort-alpha-up') : 'fa-sort text-muted opacity-50' }}"></i>
                                                </a>
                                            </th>
                                            <th>PIC & KONTAK</th>
                                            <th>MARKETING & CTA</th>
                                            <th width="220">STATUS & KETERANGAN</th>
                                            <th width="100" class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($prospeks as $data)
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" name="selected_prospek[]" value="{{ $data->id }}" class="form-check-input checkItemProspek shadow-none">
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-bold text-primary">#{{ $data->id }}</span><br>
                                                    <small class="text-muted fw-medium">{{ $data->tanggal_prospek ? \Carbon\Carbon::parse($data->tanggal_prospek)->format('d M Y') : '-' }}</small>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="fw-bolder text-dark mb-1" style="font-size: 14px;">{{ $data->perusahaan }}</div>
                                                    <small class="text-muted d-block text-truncate mb-1" style="max-width: 230px;">
                                                        <i class="fas fa-map-marker-alt text-danger"></i> {{ $data->lokasi ?? '-' }}
                                                    </small>
                                                    <span class="badge badge-soft-info" style="font-size: 10px;">{{ $data->sumber }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="fw-bold text-dark">{{ $data->nama_pic }}</div>
                                                    <small class="text-muted d-block mb-1">{{ $data->jabatan }}</small>
                                                    <div class="d-flex flex-wrap gap-2 mt-1">
                                                        @if($data->wa_pic) <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data->wa_pic) }}" target="_blank" class="badge badge-soft-success text-decoration-none" title="WA PIC"><i class="fab fa-whatsapp me-1"></i> WA</a> @endif
                                                        @if($data->telp) <span class="badge badge-soft-primary" title="Telp"><i class="fas fa-phone me-1"></i> Telp</span> @endif
                                                        @if($data->email) <span class="badge badge-soft-secondary" title="Email"><i class="fas fa-envelope me-1"></i> Email</span> @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="icon-sm bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-2 border" style="width: 24px; height: 24px; font-size: 10px;">
                                                            <i class="fas fa-user-tie"></i>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $data->marketing?->name ?? '-' }}</span>
                                                    </div>
                                                    @if (!$data->cta)
                                                        <span class="badge badge-soft-warning rounded-pill mt-1"><i class="fas fa-clock me-1"></i> Waiting CTA</span>
                                                    @else
                                                        <span class="badge badge-soft-success rounded-pill mt-1"><i class="fas fa-check me-1"></i> Done</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <span class="fw-bold text-dark d-block mb-1">{{ $data->status }}</span>
                                                    <small class="text-muted d-block text-wrap mb-1 lh-sm" style="max-width: 200px;">
                                                        {!! \Illuminate\Support\Str::autoLink($data->catatan ?? 'Tidak ada catatan...') !!}
                                                    </small>
                                                    <span class="badge bg-light text-muted border" style="font-size: 9px;"><i class="fas fa-history me-1"></i> Up: {{ $data->update_terakhir ?? '-' }}</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex flex-column gap-2 justify-content-center px-2">
                                                        @if (in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                            <a href="{{ route('prospek.edit', $data->id) }}" class="btn btn-primary btn-sm btn-round fw-bold shadow-sm">
                                                                Edit
                                                            </a>
                                                        @else
                                                            @if (!$data->cta)
                                                                <a href="{{ route('form-cta', $data->id) }}" class="btn btn-success btn-sm btn-round fw-bold shadow-sm">
                                                                    <i class="fas fa-plus me-1"></i> Buat CTA
                                                                </a>
                                                            @else
                                                                <button class="btn btn-light btn-sm btn-round border text-muted fw-bold" disabled>
                                                                    <i class="fas fa-check text-success"></i> Selesai
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">
                                                    <i class="fas fa-folder-open fs-1 mb-3 text-light"></i><br>
                                                    Belum ada data prospek yang sesuai filter.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                        <div class="d-flex justify-content-center">
                            {{ $prospeks->links('partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: DATA CTA MARKETING --}}
            <div class="tab-pane fade" id="pills-cta" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3">
                        <h6 class="m-0 fw-bold text-dark"><i class="fas fa-file-invoice-dollar text-info me-2"></i>Daftar Penawaran (CTA)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="220">INFO PROSPEK</th>
                                        <th>DETAIL PENAWARAN</th>
                                        <th>FINANSIAL & PROPOSAL</th>
                                        <th width="200">STATUS & KETERANGAN</th>
                                        <th width="100" class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ctaProspeks as $data)
                                        @php
                                            $semuaCta = \App\Models\Cta::where('prospek_id', $data->id)->latest()->get();
                                        @endphp
                                        @foreach ($semuaCta as $itemCta)
                                            <tr>
                                                <td class="align-middle ps-3">
                                                    <div class="fw-bold text-dark mb-1" style="font-size: 13px;">{{ $data->perusahaan }}</div>
                                                    <div class="d-flex flex-wrap gap-2 mt-1 mb-2">
                                                        <span class="badge bg-light text-primary border">#{{ $data->id }}</span>
                                                        <span class="badge bg-light text-muted border"><i class="far fa-calendar-alt me-1"></i>{{ $data->tanggal_prospek }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 20px; height: 20px; font-size: 9px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <small class="text-dark fw-medium">{{ $data->marketing?->name }}</small>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="fw-bold text-primary mb-1">{{ $itemCta->judul_permintaan }}</div>
                                                    <span class="badge badge-soft-info mb-1">{{ strtoupper($itemCta->sertifikasi) }}</span>
                                                    <small class="text-dark d-block fw-medium lh-sm mt-1" style="max-width: 250px;">{{ $itemCta->skema }}</small>
                                                    <span class="badge bg-light text-dark border mt-2"><i class="fas fa-users text-muted me-1"></i> {{ $itemCta->jumlah_peserta }} Peserta</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-between mb-1 small">
                                                        <span class="text-muted">Jual:</span>
                                                        <span class="text-success fw-bold">Rp {{ number_format($itemCta->harga_penawaran, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2 small">
                                                        <span class="text-muted">Modal:</span>
                                                        <span class="text-danger fw-bold">Rp {{ number_format($itemCta->harga_vendor, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div>
                                                        @if($itemCta->file_proposal)
                                                            <a href="{{ asset('storage/' . $itemCta->file_proposal) }}" target="_blank" class="btn btn-sm btn-info btn-round shadow-sm w-100 fw-bold text-white hover-lift">
                                                                <i class="fas fa-file-pdf me-1"></i> PDF File
                                                            </a>
                                                        @elseif($itemCta->proposal_link)
                                                            <a href="{{ $itemCta->proposal_link }}" target="_blank" class="btn btn-sm btn-primary btn-round shadow-sm w-100 fw-bold hover-lift">
                                                                <i class="fas fa-link me-1"></i> Link Drive
                                                            </a>
                                                        @else
                                                            <span class="badge bg-light text-muted border w-100 py-2">- Tidak ada proposal -</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    @php
                                                        $status_labels = [
                                                            'cancel' => ['label' => 'Cancel', 'class' => 'badge-soft-danger'],
                                                            'under_review' => ['label' => 'Under Review', 'class' => 'badge-soft-info'],
                                                            'hold' => ['label' => 'Hold', 'class' => 'badge-soft-warning text-dark'],
                                                            'kalah_harga' => ['label' => 'Kalah Harga', 'class' => 'badge-soft-danger'],
                                                            'deal' => ['label' => 'Deal', 'class' => 'badge-soft-success'],
                                                        ];
                                                        $current_status = $status_labels[$itemCta->status_penawaran] ?? ['label' => strtoupper($itemCta->status_penawaran ?? '-'), 'class' => 'bg-light text-dark border'];
                                                    @endphp
                                                    <span class="badge {{ $current_status['class'] }} rounded-pill px-3 mb-2">{{ $current_status['label'] }}</span>
                                                    <small class="text-muted d-block text-wrap lh-sm" style="max-width: 200px;">
                                                        {!! \Illuminate\Support\Str::autoLink($itemCta->keterangan ?? 'Tidak Ada Keterangan...') !!}
                                                    </small>
                                                </td>
                                                <td class="text-center align-middle pe-3">
                                                    @if (auth()->id() == $data->marketing_id || in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                        <a href="{{ route('cta.edit', $itemCta->id) }}" class="btn btn-primary btn-sm btn-round fw-bold shadow-sm w-100 hover-lift">
                                                            Edit
                                                        </a>
                                                    @else
                                                        <button class="btn btn-light btn-sm btn-round border text-muted fw-bold w-100" disabled>
                                                            <i class="fas fa-lock"></i> Locked
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-file-invoice-dollar fs-1 mb-3 text-light"></i><br>
                                                Belum ada data penawaran.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                        <div class="d-flex justify-content-center">
                            {{ $ctaProspeks->links('partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> 
</div> 

{{-- ================= MODAL REQUEST DOWNLOAD ================= --}}
<div class="modal fade" id="requestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('download.request') }}" method="POST">
            @csrf
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="marketing_id" value="{{ request('marketing_id') }}">
            <input type="hidden" name="status_akhir" value="{{ request('status_akhir') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="cta_status" value="{{ request('cta_status') }}">

            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark"><i class="fas fa-file-excel text-success me-2"></i>Request Download Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <div class="alert badge-soft-info border-0 rounded-3 small mb-3">
                        Request akan dikirim ke Superadmin untuk persetujuan. Pastikan alasan jelas.
                    </div>
                    <label class="fw-bold mb-2 small text-muted text-uppercase">Alasan / Kepentingan <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control bg-light shadow-none border-0" rows="3" placeholder="Contoh: Untuk laporan meeting akhir bulan..." required></textarea>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-white border fw-bold btn-round text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold btn-round shadow-sm px-4">Kirim Request</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
{{-- ================= STYLES ================= --}}
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

    .badge-soft-primary { background-color: #e0eaff; color: #3b82f6; }
    .badge-soft-success { background-color: #dcfce7; color: #16a34a; }
    .badge-soft-danger { background-color: #fee2e2; color: #dc2626; }
    .badge-soft-warning { background-color: #fef08a; color: #b45309; }
    .badge-soft-info { background-color: #cff4fc; color: #0891b2; }
    .badge-soft-secondary { background-color: #f3f4f6; color: #4b5563; }

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
    
{{-- ================= SCRIPTS ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Logika Master Checkbox Prospek
    const checkAll = document.getElementById('checkAllProspek');
    const checkItems = document.querySelectorAll('.checkItemProspek');
    const btnHapus = document.getElementById('btnHapusTerpilih');
    const countText = document.getElementById('countSelected');
    const formDelete = document.getElementById('formMassDelete');

    function updateDeleteButton() {
        if(!btnHapus) return; 
        const checkedCount = document.querySelectorAll('.checkItemProspek:checked').length;
        countText.innerText = checkedCount;
        if (checkedCount > 0) {
            btnHapus.removeAttribute('disabled');
        } else {
            btnHapus.setAttribute('disabled', 'disabled');
        }
    }

    if(checkAll) {
        checkAll.addEventListener('change', function () {
            checkItems.forEach(item => item.checked = checkAll.checked);
            updateDeleteButton();
        });
    }

    checkItems.forEach(item => {
        item.addEventListener('change', function () {
            updateDeleteButton();
            if (!this.checked) checkAll.checked = false;
        });
    });

    if(btnHapus) {
        btnHapus.addEventListener('click', function(e) {
            const total = document.querySelectorAll('.checkItemProspek:checked').length;
            if(confirm(`PERINGATAN!\n\nAnda akan menghapus ${total} data prospek beserta penawarannya secara permanen. Lanjutkan?`)) {
                formDelete.submit();
            }
        });
    }
});

function updateClock() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
}
setInterval(updateClock, 1000);
updateClock();
</script>
@endsection
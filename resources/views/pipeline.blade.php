@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            
            {{-- ================= HEADER SECTION ================= --}}
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
                <div>
                    <h3 class="fw-bold mb-1">Pipeline Marketing</h3>
                    <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6>
                    
                    {{-- Pake warna manual yang soft pastel --}}
                    <div class="d-inline-block rounded px-3 py-1 mt-1 fw-bold" style="background-color: #d8f5f9; color: #089eb7; font-size: 12px;">
                        <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                    </div>
                    
                </div>
            </div>
            
            {{-- ================= FILTER SECTION ================= --}}
            <div class="card p-2 mb-3 shadow-none border" style="background: #f9fbfd;">
                <form action="{{ route('prospek.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                    <div class="form-group p-0 m-0">
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            value="{{ $start }}" title="Tanggal Mulai">
                    </div>
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            value="{{ $end }}" title="Tanggal Akhir">
                    </div>
                    <div class="form-group p-0 m-0">
                        <select name="marketing_id" class="form-select form-select-sm">
                            <option value="">Semua Marketing</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}"
                                    {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group p-0 m-0">
                        <select name="status_akhir" class="form-select form-select-sm">
                            <option value="">Semua Status Akhir</option>
                            
                            {{-- 🔥 OPSI BARU UNTUK MENCARI DATA KOSONG 🔥 --}}
                            <option value="belum_ada_status" {{ request('status_akhir') == 'belum_ada_status' ? 'selected' : '' }}>
                                ⚠️ Belum Ada Status
                            </option>
                            
                            {{-- Loop data status yang ada di database --}}
                            @foreach ($all_status_akhir as $status)
                                {{-- Cegah opsi kosong dari DB tampil jadi opsi blank (karena sudah kita handle di atas) --}}
                                @if(!empty($status))
                                    <option value="{{ $status }}"
                                        {{ request('status_akhir') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group p-0 m-0">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status Penawaran</option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Cancel</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                            <option value="kalah_harga" {{ request('status') == 'kalah_harga' ? 'selected' : '' }}>Kalah Harga</option>
                            <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal</option>
                        </select>
                    </div>
                    <div class="form-group p-0 m-0">
                        <select name="cta_status" class="form-select form-select-sm" style="">
                            <option value="">Semua Tahap</option>
                            <option value="pending" {{ request('cta_status') == 'pending' ? 'selected' : '' }}>
                                🚩 Belum di-CTA</option>
                            <option value="done" {{ request('cta_status') == 'done' ? 'selected' : '' }}>✅
                                Sudah di-CTA</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm btn-round">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('prospek.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                </form>
            </div>

            {{-- ================= STATS CARDS ================= --}}
            <div class="row mb-2">
                {{-- Total Prospek --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round card-animate mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Prospek</p>
                                        <h4 class="card-title">{{ number_format($stats['total_prospek']) }}</h4>
                                        <p class="text-muted small mb-0">Database masuk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Penawaran --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round card-animate mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Penawaran</p>
                                        <h4 class="card-title">{{ number_format($stats['total_cta']) }}</h4>
                                        <p class="text-info small mb-0">
                                            @if ($stats['total_prospek'] > 0)
                                                {{ round(($stats['total_cta'] / $stats['total_prospek']) * 100, 1) }}% Rate CTA
                                            @else
                                                0% Rate CTA
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Nilai Pipeline --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round card-animate mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Nilai Penawaran</p>
                                        <h4 class="card-title" style="font-size: 1.1rem;">Rp
                                            {{ number_format($stats['total_nilai'], 0, ',', '.') }}</h4>
                                        <p class="text-success small mb-0">Potensi Omzet</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Deal --}}
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round card-animate mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Project Deal</p>
                                        <h4 class="card-title">{{ number_format($stats['total_deal']) }}</h4>
                                        <p class="text-secondary small mb-0">
                                            @if ($stats['total_cta'] > 0)
                                                {{ round(($stats['total_deal'] / $stats['total_cta']) * 100, 1) }}% Closing Rate
                                            @else
                                                0% Closing
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= BUTTON & SEARCH PERUSAHAAN ================= --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex gap-2">
                    {{-- Tombol Request Excel yang sudah ada --}}
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal">
                        <i class="fas fa-file-excel"></i> Request Download Excel
                    </button>
            
                    {{-- 🔥 TOMBOL BARU: CEK SINKRONISASI DATA 🔥 --}}
                    <a href="{{ route('prospek.check') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-sync-alt"></i> Cek Sinkronisasi Data
                    </a>
                </div>
                
                <div class="col-md-4 col-12">
                    <form action="{{ route('prospek.index') }}" method="GET" class="input-group">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                        <input type="hidden" name="marketing_id" value="{{ request('marketing_id') }}">
                        <input type="hidden" name="status_akhir" value="{{ request('status_akhir') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="hidden" name="cta_status" value="{{ request('cta_status') }}">
            
                        <input type="text" name="search_perusahaan" class="form-control form-control-sm" 
                               placeholder="Cari Nama Perusahaan..." value="{{ request('search_perusahaan') }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search_perusahaan'))
                            <a href="{{ route('prospek.index', request()->except('search_perusahaan')) }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- ================= TABS NAVIGASI ================= --}}
            <ul class="nav nav-pills nav-secondary bg-white p-1 rounded border d-inline-flex mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-prospek-tab" data-bs-toggle="pill" href="#pills-prospek" role="tab" aria-selected="true">
                        <i class="fas fa-database me-1"></i> Data Prospek (Leads)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-cta-tab" data-bs-toggle="pill" href="#pills-cta" role="tab" aria-selected="false">
                        <i class="fas fa-file-invoice-dollar me-1"></i> Data CTA Marketing
                    </a>
                </li>
            </ul>
            
            {{-- 🔥 CARD DETEKSI DUPLIKAT 🔥 --}}
            @if(isset($duplicateGroups) && $duplicateGroups->count() > 0)
            <div class="alert alert-danger shadow-sm border-0 rounded-4 p-3 mb-4">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-circle fs-2 text-danger me-3 mt-1 animate-pulse"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1 text-danger">Peringatan: Ditemukan Data Prospek Duplikat!</h6>
                        <p class="mb-2 small text-dark">
                            Sistem mendeteksi ada <b class="fs-6">{{ $duplicateGroups->count() }} kelompok perusahaan</b> yang memiliki nama dan lokasi yang sama. Silakan hapus data yang tidak diperlukan agar database tetap bersih.
                        </p>
                        
                        <button class="btn btn-sm btn-danger btn-round shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDuplicates">
                            <i class="fas fa-search me-1"></i> Tinjau & Bersihkan Duplikat
                        </button>
            
                        {{-- AREA TINJAUAN DUPLIKAT (Tersembunyi) --}}
                        <div class="collapse mt-3" id="collapseDuplicates">
                            <div class="card card-body bg-white border border-danger p-0 shadow-none rounded overflow-hidden">
                                <form action="{{ route('prospek.massDelete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                            <thead class="table-danger text-center" style="position: sticky; top: 0; z-index: 1;">
                                                <tr>
                                                    <th width="40"><i class="fas fa-check-square"></i></th>
                                                    <th>Nama Perusahaan & Lokasi (Kelompok)</th>
                                                    <th>Marketing PIC</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Status & Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($duplicateGroups as $groupName => $items)
                                                    <tr class="table-light">
                                                        {{-- 🔥 UBAH COLSPAN JADI 6 🔥 --}}
                                                        <td colspan="6" class="fw-bold text-primary border-bottom border-danger">
                                                            <i class="fas fa-building me-1"></i> {{ $groupName }} 
                                                            <span class="badge bg-danger ms-2">{{ $items->count() }} Data Sama</span>
                                                        </td>
                                                    </tr>
                                                    @foreach($items as $index => $item)
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                {{-- Kita set checklist secara default kosong, biar admin pilih manual mana yg dihapus --}}
                                                                <input type="checkbox" name="selected_prospek[]" value="{{ $item->id }}" class="form-check-input border-danger">
                                                            </td>
                                                            <td class="align-middle">
                                                                <span class="text-dark">{{ $item->perusahaan }}</span><br>
                                                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $item->lokasi ?? '-' }}</small>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{ $item->marketing->name ?? 'Belum Diassign' }}
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{ $item->created_at->format('d M Y H:i') }}
                                                                @if($index === 0)
                                                                    <br><span class="badge bg-success" style="font-size:9px;">Data Tertua (Asli)</span>
                                                                @else
                                                                    <br><span class="badge bg-warning text-dark" style="font-size:9px;">Data Baru (Duplikat)</span>
                                                                @endif
                                                            </td>
                                                            {{-- 🔥 ISI DATA STATUS & KETERANGAN 🔥 --}}
                                                            <td class="align-middle">
                                                                <div class="fw-bold text-dark">{{ $item->status ?? '-' }}</div>
                                                                <small class="text-muted d-block text-wrap" style="max-width: 200px;">
                                                                    {!! \Illuminate\Support\Str::autoLink($item->catatan ?? 'Tidak ada catatan') !!}
                                                                </small>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <a href="{{ route('prospek.edit', $item->id) }}" target="_blank" class="btn btn-xs btn-outline-primary rounded">Cek Detail</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3 bg-light border-top border-danger text-end">
                                        <span class="text-muted small me-3">* Centang data yang ingin <b>Dihapus</b>. Data yang tidak dicentang akan <b>Dipertahankan</b>.</span>
                                        <button type="submit" class="btn btn-danger btn-round shadow-sm" onclick="return confirm('Data prospek (beserta penawarannya jika ada) yang dicentang akan dihapus permanen. Lanjutkan?')">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus Duplikat Terpilih
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- 🔥 END CARD DUPLIKAT 🔥 --}}
            
            {{-- 🔥 CARD DETEKSI DUPLIKAT CTA (PENAWARAN) 🔥 --}}
            @if(isset($duplicateCtaGroups) && $duplicateCtaGroups->count() > 0)
            <div class="alert alert-warning shadow-sm border-0 rounded-4 p-3 mb-4">
                <div class="d-flex align-items-start">
                    <i class="fas fa-copy fs-2 text-warning me-3 mt-1 animate-pulse"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1 text-dark">Peringatan: Ditemukan Data Penawaran (CTA) Duplikat!</h6>
                        <p class="mb-2 small text-dark">
                            Sistem mendeteksi ada <b class="fs-6 text-danger">{{ $duplicateCtaGroups->count() }} kelompok Penawaran</b> yang memiliki Nama Perusahaan, Lokasi, dan Judul Permintaan yang sama persis.
                        </p>
                        
                        <button class="btn btn-sm btn-warning btn-round shadow-sm text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDuplicateCTA">
                            <i class="fas fa-search me-1"></i> Tinjau & Bersihkan CTA Duplikat
                        </button>
            
                        {{-- AREA TINJAUAN DUPLIKAT CTA (Tersembunyi) --}}
                        <div class="collapse mt-3" id="collapseDuplicateCTA">
                            <div class="card card-body bg-white border border-warning p-0 shadow-none rounded overflow-hidden">
                                <form action="{{ route('cta.massDelete') }}" method="POST">
                                    @csrf
                                    <!--@method('DELETE')-->
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-sm table-hover mb-0" style="font-size: 12px;">
                                            <thead class="table-warning text-dark text-center" style="position: sticky; top: 0; z-index: 1;">
                                                <tr>
                                                    <th width="40"><i class="fas fa-check-square"></i></th>
                                                    <th width="220">Detail Program & Judul CTA</th>
                                                    <th width="200">Finansial & Peserta</th>
                                                    <th>Status & Keterangan CTA</th>
                                                    <th width="120">Waktu Input</th>
                                                    <th width="80">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($duplicateCtaGroups as $groupName => $items)
                                                    <tr class="bg-light">
                                                        <td colspan="6" class="fw-bold text-primary border-bottom border-warning">
                                                            <i class="fas fa-file-invoice-dollar me-1"></i> {{ $groupName }} 
                                                            <span class="badge bg-warning text-dark ms-2">{{ $items->count() }} Data Sama</span>
                                                        </td>
                                                    </tr>
                                                    @foreach($items as $index => $item)
                                                        <tr>
                                                            <td class="text-center align-middle">
                                                                <input type="checkbox" name="selected_cta[]" value="{{ $item->id }}" class="form-check-input border-warning">
                                                            </td>
                                                            <td class="align-middle">
                                                                <span class="fw-bold text-primary">{{ $item->judul_permintaan ?? '-' }}</span><br>
                                                                <span class="badge bg-info my-1">{{ strtoupper($item->sertifikasi ?? 'NON-SERTIFIKASI') }}</span><br>
                                                                <small class="text-dark fw-bold">{{ $item->skema ?? '-' }}</small>
                                                                <div class="mt-1 pt-1 border-top border-warning">
                                                                    <small class="text-muted"><i class="fas fa-building me-1"></i>{{ $item->prospek->perusahaan ?? '-' }}</small><br>
                                                                    <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Sales: <b class="text-dark">{{ $item->prospek->marketing->name ?? '-' }}</b></small>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <small class="text-muted">Hrg Jual:</small>
                                                                    <span class="text-success fw-bold">Rp {{ number_format($item->harga_penawaran, 0, ',', '.') }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <small class="text-muted">Hrg Modal:</small>
                                                                    <span class="text-danger">Rp {{ number_format($item->harga_vendor, 0, ',', '.') }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between border-top border-warning pt-1">
                                                                    <small class="text-muted fw-bold">Total ({{ $item->jumlah_peserta }} Org):</small>
                                                                    <span class="text-dark fw-bold">Rp {{ number_format(($item->harga_penawaran ?? 0) * ($item->jumlah_peserta ?? 1), 0, ',', '.') }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                @php
                                                                    $status_labels = [
                                                                        'cancel' => ['label' => 'Cancel', 'class' => 'bg-dark'],
                                                                        'under_review' => ['label' => 'Under Review', 'class' => 'bg-info'],
                                                                        'hold' => ['label' => 'Hold', 'class' => 'bg-warning text-dark'],
                                                                        'kalah_harga' => ['label' => 'Kalah Harga', 'class' => 'bg-danger'],
                                                                        'deal' => ['label' => 'Deal', 'class' => 'bg-success'],
                                                                    ];
                                                                    $current_status = $status_labels[$item->status_penawaran] ?? ['label' => strtoupper($item->status_penawaran ?? '-'), 'class' => 'bg-secondary'];
                                                                @endphp
                                                                <span class="badge {{ $current_status['class'] }} mb-1">{{ $current_status['label'] }}</span>
                                                                <small class="text-muted d-block text-wrap" style="max-width: 250px;">
                                                                    {!! \Illuminate\Support\Str::autoLink($item->keterangan ?? 'Tidak ada keterangan...') !!}
                                                                </small>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <span class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</span><br>
                                                                <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                                                @if($index === 0)
                                                                    <br><span class="badge bg-success mt-1" style="font-size:9px;">Data Asli (Tertua)</span>
                                                                @else
                                                                    <br><span class="badge bg-danger mt-1" style="font-size:9px;">Duplikat (Baru)</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <a href="{{ route('cta.edit', $item->id) }}" target="_blank" class="btn btn-xs btn-outline-primary rounded" title="Buka Detail">
                                                                    <i class="fas fa-external-link-alt"></i> Detail
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3 bg-light border-top border-warning text-end">
                                        <span class="text-muted small me-3">* Centang data CTA yang ingin <b>Dihapus</b>. Data Prospek induknya <b>TIDAK</b> akan ikut terhapus.</span>
                                        <button type="submit" class="btn btn-warning text-dark btn-round shadow-sm" onclick="return confirm('Data CTA (Penawaran) yang dicentang akan dihapus permanen. Lanjutkan?')">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus CTA Duplikat Terpilih
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- 🔥 END CARD DUPLIKAT CTA 🔥 --}}

            {{-- ================= TAB CONTENT ================= --}}
            <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                
                {{-- TAB 1: DATA PROSPEK --}}
                <div class="tab-pane fade show active" id="pills-prospek" role="tabpanel" aria-labelledby="pills-prospek-tab">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header">
                            <div class="card-title">Tabel Pipeline (Leads)</div>
                        </div>
                        <div class="card-body">
                            {{-- BUNGKUS TABEL DENGAN FORM --}}
                            <form action="{{ route('prospek.massDelete') }}" method="POST" id="formMassDelete">
                                @csrf
                                @method('DELETE')
                                
                                {{-- TEMPATKAN TOMBOL HAPUS DI ATAS TABEL --}}
                                @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger btn-sm" id="btnHapusTerpilih" disabled>
                                        <i class="fas fa-trash-alt me-1"></i> Hapus <span id="countSelected">0</span> Terpilih
                                    </button>
                                </div>
                                @endif
                            
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            {{-- 🔥 TAMBAH CHECKBOX MASTER DI SINI --}}
                                            <th width="40">
                                                <input type="checkbox" id="checkAllProspek" class="form-check-input">
                                            </th>
                                            <th width="100">ID & TGL</th>
                                            {{-- Ganti <th>PERUSAHAAN</th> dengan kode ini --}}
                                            <th>
                                                <a href="{{ route('prospek.index', array_merge(request()->query(), [
                                                    'sort_by' => 'perusahaan',
                                                    'sort_order' => request('sort_by') == 'perusahaan' && request('sort_order') == 'asc' ? 'desc' : 'asc'
                                                ])) }}" class="text-dark d-flex justify-content-between align-items-center decoration-none">
                                                    PERUSAHAAN
                                                    <i class="fas {{ request('sort_by') == 'perusahaan' ? (request('sort_order') == 'asc' ? 'fa-sort-alpha-down' : 'fa-sort-alpha-up') : 'fa-sort' }} ms-1 text-muted"></i>
                                                </a>
                                            </th
                                            <th>PIC & KONTAK</th>
                                            <th>MARKETING & CTA</th>
                                            <th>STATUS & KETERANGAN</th>
                                            <th width="120">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prospeks as $data)
                                            <tr>
                                                {{-- 🔥 TAMBAH CHECKBOX UNTUK SETIAP BARIS --}}
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" name="selected_prospek[]" value="{{ $data->id }}" class="form-check-input checkItemProspek">
                                                </td>
                                                
                                                <td class="text-center">
                                                    <span class="fw-bold text-primary">#{{ $data->id }}</span><br>
                                                    <small class="text-muted">{{ $data->tanggal_prospek ? \Carbon\Carbon::parse($data->tanggal_prospek)->format('d M Y') : '-' }}</small>
                                                </td>
                                                
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $data->perusahaan }}</div>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                                        <i class="fas fa-map-marker-alt text-danger"></i> {{ $data->lokasi ?? '-' }}
                                                    </small>
                                                    <span class="badge badge-secondary mt-1">{{ $data->sumber }}</span>
                                                </td>
                                                
                                                <td>
                                                    <div class="fw-bold">{{ $data->nama_pic }}</div>
                                                    <small class="text-muted d-block">{{ $data->jabatan }}</small>
                                                    <div class="mt-1" style="font-size: 11px;">
                                                        @if($data->wa_pic) <div title="WA PIC"><i class="fab fa-whatsapp text-success me-1"></i> {!! \Illuminate\Support\Str::autoLink($data->wa_pic) !!}</div> @endif
                                                        @if($data->telp) <div title="Telp Perusahaan"><i class="fas fa-phone text-primary me-1"></i> {!! \Illuminate\Support\Str::autoLink($data->telp) !!}</div> @endif
                                                        @if($data->telp_baru) <div title="Telp Baru"><i class="fas fa-phone-alt text-info me-1"></i> {!! \Illuminate\Support\Str::autoLink($data->telp_baru) !!}</div> @endif
                                                        @if($data->email) <div title="Email"><i class="fas fa-envelope text-secondary me-1"></i> {!! \Illuminate\Support\Str::autoLink($data->email) !!}</div> @endif
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <span class="fw-bold text-dark">{{ $data->marketing?->name ?? '-' }}</span><br>
                                                    @if (!$data->cta)
                                                        <span class="badge badge-warning mt-1">Waiting CTA</span>
                                                    @else
                                                        <span class="badge badge-success mt-1">Done</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="fw-bold text-dark">{{ $data->status }}</div>
                                                    <small class="text-muted d-block text-wrap" style="max-width: 250px;">
                                                        {!! \Illuminate\Support\Str::autoLink($data->catatan ?? 'Tidak ada catatan') !!}
                                                    </small>
                                                    <small class="text-info mt-1 d-block" style="font-size: 11px;">Update: {{ $data->update_terakhir ?? '-' }}</small>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                        @if (in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                            <a href="{{ route('prospek.edit', $data->id) }}" class="btn btn-primary btn-sm w-100">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        @else
                                                            @if (!$data->cta)
                                                                <a href="{{ route('form-cta', $data->id) }}" class="btn btn-success btn-sm w-100">
                                                                    <i class="fas fa-plus"></i> CTA
                                                                </a>
                                                            @else
                                                                <button class="btn btn-outline-success btn-sm w-100" disabled style="cursor: default;">
                                                                    <i class="fas fa-check"></i> Done
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </form> {{-- PENUTUP FORM MASS DELETE --}}
                            <div class="demo mt-3 d-flex justify-content-center">
                                {{ $prospeks->links('partials.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: DATA CTA MARKETING --}}
                <div class="tab-pane fade" id="pills-cta" role="tabpanel" aria-labelledby="pills-cta-tab">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header">
                            <div class="card-title">Tabel Penawaran (CTA)</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th width="180">INFO PROSPEK</th>
                                            <th>DETAIL PENAWARAN</th>
                                            <th>FINANSIAL & PROPOSAL</th>
                                            <th width="150">STATUS & KETERANGAN</th>
                                            <th width="100">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ctaProspeks as $data)
                                            @php
                                                $semuaCta = \App\Models\Cta::where('prospek_id', $data->id)->latest()->get();
                                            @endphp

                                            @foreach ($semuaCta as $itemCta)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold text-dark">{{ $data->perusahaan }}</div>
                                                        <div style="font-size: 11px;" class="mt-1">
                                                            <span class="text-primary fw-bold">#{{ $data->id }}</span> | {{ $data->tanggal_prospek }}<br>
                                                            <span class="text-muted"><i class="fas fa-user me-1"></i> {{ $data->marketing?->name }}</span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="fw-bold text-primary">{{ $itemCta->judul_permintaan }}</div>
                                                        <span class="badge badge-info my-1">{{ strtoupper($itemCta->sertifikasi) }}</span>
                                                        <small class="fw-bold text-dark d-block">{{ $itemCta->skema }}</small>
                                                        <small class="text-muted"><i class="fas fa-users"></i> {{ $itemCta->jumlah_peserta }} Peserta</small>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <small class="text-muted">Penawaran:</small>
                                                            <span class="text-success fw-bold">Rp {{ number_format($itemCta->harga_penawaran, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <small class="text-muted">Vendor:</small>
                                                            <span class="text-danger">Rp {{ number_format($itemCta->harga_vendor, 0, ',', '.') }}</span>
                                                        </div>

                                                        <div>
                                                            @if($itemCta->file_proposal)
                                                                <a href="{{ asset('storage/' . $itemCta->file_proposal) }}" target="_blank" class="btn btn-sm btn-info shadow-sm w-100" title="Lihat PDF Proposal">
                                                                    <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                                                </a>
                                                            @elseif($itemCta->proposal_link)
                                                                <a href="{{ $itemCta->proposal_link }}" target="_blank" class="btn btn-sm btn-primary shadow-sm w-100" title="Buka Link Drive">
                                                                    <i class="fas fa-link me-1"></i> Buka Link
                                                                </a>
                                                            @else
                                                                <span class="text-muted small d-block text-center border bg-light py-1">- Tidak ada file -</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        @php
                                                            $status_labels = [
                                                                'cancel' => ['label' => 'Cancel', 'class' => 'badge-dark'],
                                                                'under_review' => ['label' => 'Under Review', 'class' => 'badge-info'],
                                                                'hold' => ['label' => 'Hold', 'class' => 'badge-warning'],
                                                                'kalah_harga' => ['label' => 'Kalah Harga', 'class' => 'badge-danger'],
                                                                'deal' => ['label' => 'Deal', 'class' => 'badge-success'],
                                                            ];
                                                            $current_status = $status_labels[$itemCta->status_penawaran] ?? ['label' => 'N/A', 'class' => 'badge-secondary'];
                                                        @endphp
                                                        <span class="badge {{ $current_status['class'] }} mb-2">
                                                            {{ $current_status['label'] }}
                                                        </span>
                                                        <div class="small text-muted text-start text-wrap" style="max-width: 200px;">
                                                            {!! \Illuminate\Support\Str::autoLink($itemCta->keterangan ?? 'Tidak Ada Keterangan') !!}
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        @if (auth()->id() == $data->marketing_id || in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                            <a href="{{ route('cta.edit', $itemCta->id) }}" class="btn btn-primary btn-sm w-100">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                                                <i class="fas fa-lock"></i> Locked
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="demo mt-3 d-flex justify-content-center">
                                {{ $ctaProspeks->links('partials.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div> {{-- Penutup Page-inner --}}
    </div> {{-- Penutup Container --}}

    {{-- ================= MODAL REQUEST DOWNLOAD ================= --}}
    <div class="modal fade" id="requestModal">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('download.request') }}" method="POST">
                @csrf
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                <input type="hidden" name="marketing_id" value="{{ request('marketing_id') }}">
                <input type="hidden" name="status_akhir" value="{{ request('status_akhir') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="cta_status" value="{{ request('cta_status') }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Download</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Alasan / Kepentingan</label>
                        <textarea name="reason" class="form-control" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <style>
        .card-animate {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }

        .card-animate:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .card-category {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        th a {
            text-decoration: none !important;
            color: inherit;
            display: block;
            width: 100%;
        }
        th a:hover {
            color: #007bff; /* Warna biru saat hover */
        }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAllProspek');
        const checkItems = document.querySelectorAll('.checkItemProspek');
        const btnHapus = document.getElementById('btnHapusTerpilih');
        const countText = document.getElementById('countSelected');
        const formDelete = document.getElementById('formMassDelete');

        // Fungsi update tombol hapus
        function updateDeleteButton() {
            if(!btnHapus) return; // Jika bukan admin, tombol tidak ada
            
            const checkedCount = document.querySelectorAll('.checkItemProspek:checked').length;
            countText.innerText = checkedCount;
            
            if (checkedCount > 0) {
                btnHapus.removeAttribute('disabled');
            } else {
                btnHapus.setAttribute('disabled', 'disabled');
            }
        }

        // Klik Master Checkbox (Pilih Semua)
        if(checkAll) {
            checkAll.addEventListener('change', function () {
                checkItems.forEach(item => {
                    item.checked = checkAll.checked;
                });
                updateDeleteButton();
            });
        }

        // Klik masing-masing Checkbox
        checkItems.forEach(item => {
            item.addEventListener('change', function () {
                updateDeleteButton();
                // Jika ada 1 yang uncheck, matikan master checkAll
                if (!this.checked) checkAll.checked = false;
            });
        });

        // Konfirmasi sebelum submit (Ganti Modal dengan SweetAlert/Confirm biasa agar lebih instan)
        if(btnHapus) {
            btnHapus.addEventListener('click', function(e) {
                const total = document.querySelectorAll('.checkItemProspek:checked').length;
                if(confirm(`PERINGATAN!\n\nAnda akan menghapus ${total} data prospek beserta penawarannya secara permanen. Lanjutkan?`)) {
                    formDelete.submit();
                }
            });
        }
    });
    </script>

    <script>
        function updateClock() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection
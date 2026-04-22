@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div>
            <h3 class="fw-bold mb-1">Data Masuk</h3>
            <h6 class="op-7 mb-2">Database Marketing & Assignment Center</h6>
        </div>
        
        {{-- Header & Filter Section --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
            <div class="ms-md-auto py-2 py-md-0">
                <form action="{{ route('data-masuk.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
    
                    {{-- NEW: Input Search --}}
                    <div class="form-group p-0 m-0">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Cari Perusahaan / PIC..." value="{{ request('search') }}">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                    </div>
                
                    <div class="form-group p-0 m-0">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" title="Tanggal Mulai">
                    </div>
                    
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" title="Tanggal Akhir">
                    </div>
                    
                    <div class="form-group p-0 m-0">
                        <select name="status_deliver" class="form-select form-select-sm">
                            <option value="">Semua Status Deliver</option>
                            <option value="undelivered" {{ request('status_deliver') == 'undelivered' ? 'selected' : '' }}>
                                🔴 Belum Diassign (New)
                            </option>
                            <option value="delivered" {{ request('status_deliver') == 'delivered' ? 'selected' : '' }}>
                                🟢 Sudah Diassign
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group p-0 m-0">
                        <select name="marketing_id" class="form-select form-select-sm">
                            <option value="">Semua Marketing</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm btn-round"><i class="fas fa-filter"></i> Terapkan</button>
                        <a href="{{ route('data-masuk.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            {{-- 1. Total Data Keseluruhan --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="icon-layers"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Data Masuk</p>
                                    <h4 class="card-title">{{ number_format($totalData, 0, ',', '.') }}</h4>
                                    <p class="text-muted small mb-0">Seluruh waktu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Data Masuk Hari Ini --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Data Hari Ini</p>
                                    <h4 class="card-title">{{ number_format($totalToday, 0, ',', '.') }}</h4>
                                    <p class="text-info small mb-0">Baru masuk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Rasio Email Valid --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="icon-envelope-letter"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Email Valid</p>
                                    <h4 class="card-title">{{ number_format($dataValid, 0, ',', '.') }}</h4>
                                    <p class="text-success small mb-0">
                                        {{ $validPercentage }}% dari total
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Total Ter-Deliver --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="icon-paper-plane"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Di-Deliver</p>
                                    <h4 class="card-title">{{ number_format($dataConverted, 0, ',', '.') }}</h4>
                                    <p class="text-secondary small mb-0">Terkirim ke Pipeline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi Tambah & Hapus Data --}}
        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('form-data-masuk') }}" class="btn btn-success btn-sm btn-round">
                <i class="fa fa-plus me-1"></i> Tambah Data Masuk
            </a>
            
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'rnd')
                <button class="btn btn-danger btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modalDeleteByDate">
                    <i class="fa fa-trash me-1"></i> Hapus By Tanggal
                </button>
            @endif
        </div>

        {{-- Modal Hapus Berdasarkan Tanggal --}}
        <div class="modal fade" id="modalDeleteByDate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('data-masuk.destroy-by-date') }}" method="POST">
                    @csrf
                    <div class="modal-content card-round">
                        <div class="modal-header bg-danger text-white border-0">
                            <h5 class="modal-title fw-bold"><i class="fa fa-exclamation-triangle me-2"></i> Hapus Data Massal</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4">
                            <div class="alert alert-warning">
                                <b>Peringatan:</b> Aksi ini akan menghapus data secara permanen berdasarkan rentang waktu <b>Tanggal Input</b> (<i>created_at</i>). Aksi ini tidak dapat dibatalkan.
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Dari Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Sampai Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light btn-round" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger btn-round" onclick="return confirm('Apakah Anda sangat yakin ingin menghapus data di rentang tanggal ini?')">
                                <i class="fa fa-trash me-1"></i> Hapus Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABS NAVIGASI ================= --}}
            <ul class="nav nav-pills nav-secondary bg-white p-1 rounded border d-inline-flex mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-umum-tab" data-bs-toggle="pill" href="#pills-umum" role="tab" aria-selected="true">
                        <i class="fas fa-database me-1"></i> Data Umum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-ads-tab" data-bs-toggle="pill" href="#pills-ads" role="tab" aria-selected="false">
                        <i class="fas fa-bullhorn me-1"></i> Data Ads
                    </a>
                </li>
            </ul>

        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-umum" role="tabpanel" aria-labelledby="pills-umum-tab">
            
            {{-- 🔥 CARD STATUS SINKRONISASI (LANGSUNG TAMPIL NAMA) 🔥 --}}
                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                    @if(count($unsyncedCompanies) > 0)
                        <div class="alert alert-warning shadow-sm border-0 rounded-4 p-3 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle fs-2 text-warning me-3 animate-pulse mt-1"></i>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark">Butuh Sinkronisasi Assignment!</h6>
                                    <p class="mb-2 small text-dark">
                                        Terdapat total <b class="text-danger fs-6">{{ count($unsyncedCompanies) }}</b> data perusahaan di seluruh database yang statusnya <b>Menunggu Admin</b>, namun <b>sudah ada di data Prospek</b>.
                                    </p>
                                    
                                    {{-- Box Daftar Nama Perusahaan --}}
                                    <div class="bg-white p-2 rounded border border-warning shadow-sm mb-2" style="max-height: 120px; overflow-y: auto;">
                                        <strong class="small text-danger d-block mb-2">
                                            <i class="fas fa-list-ul me-1"></i> Daftar Perusahaan Nyangkut:
                                        </strong>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($unsyncedCompanies as $companyName)
                                                <span class="badge bg-warning text-dark border border-warning-subtle py-1 px-2">
                                                    {{ $companyName }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    {{-- 🔥 TOMBOL AUTO-SYNC 🔥 --}}
                                    <form action="{{ route('data-masuk.auto-sync') }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-dark btn-sm btn-round shadow-sm" onclick="return confirm('Sistem akan otomatis menyesuaikan nama Marketing di Data Masuk mengikuti tabel Prospek. Lanjutkan?')">
                                            <i class="fas fa-sync-alt me-1"></i> Sinkronkan Semua Otomatis
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                {{-- 🔥 END TAMBAHAN CARD 🔥 --}}

                <div class="card card-round shadow-sm border-0">
                    <div class="card-header">
                        <div class="card-title">Tabel Data Masuk (Database Pusat)</div>
                    </div>
                    
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('data-masuk.deliver-massal') }}" method="POST" id="formDeliverMassal">
                            @csrf
                            
                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modalDeliverMassal" id="btnBulkDeliver" disabled>
                                        <i class="fas fa-paper-plane me-1"></i> Deliver Terpilih (<span id="countSelected">0</span>)
                                    </button>
                                </div>

                                {{-- Modal Deliver Massal --}}
                                <div class="modal fade" id="modalDeliverMassal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content card-round text-start">
                                            <div class="modal-header border-0">
                                                <h6 class="fw-bold m-0">Assign Massal ke Marketing</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                <div class="alert alert-info py-2 px-3 small mb-3">
                                                    Anda akan mengirim <b id="textCountModal">0</b> data terpilih ke Pipeline.
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="fw-bold mb-1 small">Pilih Marketing <span class="text-danger">*</span></label>
                                                    <select name="marketing_id" class="form-select form-select-sm" required>
                                                        <option value="">-- Pilih Marketing --</option>
                                                        @foreach($marketings as $m)
                                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- NEW: Input Tanggal Assign Massal --}}
                                                <div class="mb-2">
                                                    <label class="fw-bold mb-1 small">Tanggal Assign <span class="text-danger">*</span></label>
                                                    <input type="date" name="tanggal_assign" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                                    <small class="text-muted d-block mt-1">Ubah tanggal jika ingin mendeliver untuk besok/kemarin.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary btn-sm btn-round w-100">Kirim ke Pipeline</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                <th width="40"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                            @endif
                                            <th width="150">INFO DATA</th>
                                            <th>PERUSAHAAN & UNIT</th>
                                            <th>KONTAK</th>
                                            <th>ASSIGNMENT</th>
                                            <th width="100">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $item)
                                            <tr>
                                                {{-- KONTEN CHECKBOX --}}
                                                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                    <td class="text-center">
                                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="form-check-input checkItem" {{ $item->marketing_id ? 'disabled' : '' }}>
                                                    </td>
                                                @endif

                                                {{-- INFO DATA --}}
                                                <td>
                                                    <span class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</span><br>
                                                    @if($item->is_ads)
                                                        <span class="badge badge-primary my-1"><i class="fas fa-bullhorn me-1"></i> Ads</span>
                                                    @else
                                                        <span class="badge badge-secondary my-1">{{ $item->sumber }}</span>
                                                    @endif
                                                    <small class="d-block text-muted"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $item->lokasi ?? '-' }}</small>
                                                </td>
                                                
                                                {{-- PERUSAHAAN & UNIT --}}
                                                <td>
                                                    <div class="fw-bold text-primary" style="font-size: 15px;">{{ $item->perusahaan }}</div>
                                                    <small class="text-muted d-block"><i class="fas fa-building me-1"></i> Unit: {{ $item->unit_bisnis ?? '-' }}</small>
                                                </td>

                                                {{-- KONTAK --}}
                                                <td>
                                                    <div style="font-size: 12px;">
                                                        @if($item->email)
                                                            <div title="Email"><i class="fas fa-envelope text-secondary me-1"></i> {{ $item->email }} 
                                                                @if($item->status_email) <span class="badge bg-light text-muted border border-secondary p-1 ms-1" style="font-size: 9px;">{{ $item->status_email }}</span> @endif
                                                            </div>
                                                        @endif
                                                        @if($item->telp) <div title="Telp Perusahaan" class="mt-1"><i class="fas fa-phone text-primary me-1"></i> {{ $item->telp }}</div> @endif
                                                        @if($item->wa_baru ?? $item->wa_pic) <div title="WhatsApp" class="mt-1"><i class="fab fa-whatsapp text-success me-1"></i> {{ $item->wa_baru ?? $item->wa_pic }}</div> @endif
                                                    </div>
                                                </td>

                                                {{-- ASSIGNMENT --}}
                                                <td class="text-center">
                                                    @if($item->marketing)
                                                        @if(!in_array($item->perusahaan, $prospekList))
                                                            <span class="badge badge-warning shadow-sm" title="Data ini nyangkut! Assigned tapi tidak ada di Pipeline Prospek">
                                                                <i class="fas fa-exclamation-triangle text-dark me-1"></i> 
                                                                <span class="text-dark">Data Nyangkut ({{ $item->marketing->name }})</span>
                                                            </span>
                                                        @else
                                                            <span class="badge badge-info shadow-sm">
                                                                <i class="fas fa-user-check me-1"></i> {{ $item->marketing->name }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-danger badge-count animate-pulse">
                                                            <i class="fas fa-exclamation-circle me-1"></i> Menunggu Admin
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- ACTION --}}
                                                <td class="text-center">
                                                    <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                        @php $role = auth()->user()->role; @endphp

                                                        {{-- Tombol Deliver (Admin) --}}
                                                        @if (in_array($role, ['admin']))
                                                            @if(!$item->marketing)
                                                                <button type="button" class="btn btn-primary btn-sm btn-round w-100" data-bs-toggle="modal" data-bs-target="#modalDeliver{{ $item->id }}">
                                                                    <i class="fas fa-paper-plane me-1"></i> Deliver
                                                                </button>
                                                            @else
                                                                <span class="badge badge-success w-100 py-2"><i class="fa fa-check me-1"></i> Sent</span>
                                                            @endif
                                                        @endif

                                                        {{-- Tombol Edit & Delete (RnD / DM) --}}
                                                        @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                            <a href="{{ route('data-masuk.edit', $item->id) }}" class="btn btn-warning btn-sm w-100 btn-round">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a href="#" onclick="event.preventDefault(); if(confirm('Hapus data ini?')) document.getElementById('delete-form-{{ $item->id }}').submit();" class="btn btn-danger btn-sm w-100 btn-round">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        {{-- ================= MODAL DELIVER SATUAN (DATA UMUM) ================= --}}
                        @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                            @foreach ($allData as $item)
                                @if(!$item->marketing)
                                    <div class="modal fade" id="modalDeliver{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('data-masuk.deliver', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content card-round text-start">
                                                    <div class="modal-header border-0">
                                                        <h6 class="fw-bold m-0">Assign Lead Prospek</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        <p class="small text-muted mb-3">Assign <b>{{ Str::limit($item->perusahaan, 30) }}</b> ke Pipeline.</p>
                                                        
                                                        <div class="mb-3">
                                                            <label class="fw-bold mb-1 small">Pilih Marketing <span class="text-danger">*</span></label>
                                                            <select name="marketing_id" class="form-select form-select-sm" required>
                                                                <option value="">-- Pilih Marketing --</option>
                                                                @foreach($marketings as $m)
                                                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- NEW: Input Tanggal Assign Satuan --}}
                                                        <div class="mb-2">
                                                            <label class="fw-bold mb-1 small">Tanggal Assign <span class="text-danger">*</span></label>
                                                            <input type="date" name="tanggal_assign" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-round w-100">Kirim ke Pipeline</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        {{-- ================= END MODAL ================= --}}

                        {{-- Form Delete Satuan Dipisah agar tidak bentrok dengan form massal --}}
                        @if (in_array(auth()->user()->role, ['rnd', 'digitalmarketing']))
                            @foreach ($allData as $item)
                                <form id="delete-form-{{ $item->id }}" action="{{ route('data-masuk.destroy', $item->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            @endforeach
                        @endif

                        {{-- Pagination --}}
                        <div class="demo mt-3 d-flex justify-content-center">
                            {{ $allData->links('partials.pagination') }} 
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TAB 2: DATA ADS (SUDAH DIRAPIKAN) ================= --}}
            <div class="tab-pane fade" id="pills-ads" role="tabpanel">
                <div class="card card-round shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th width="140">TANGGAL & SUMBER</th>
                                        <th>PERUSAHAAN & HRD</th>
                                        <th>KONTAK</th>
                                        <th>PROGRAM & SERTIFIKASI</th>
                                        <th width="100">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adsData as $ad)
                                    <tr>
                                        {{-- TANGGAL & SUMBER --}}
                                        <td class="text-center">
                                            <span class="fw-bold text-dark">{{ $ad->created_at->format('d M Y') }}</span><br>
                                            <span class="badge badge-primary mt-1 mb-1">{{ $ad->channel_akuisisi }}</span><br>
                                            <small class="text-muted"><i class="fas fa-tag me-1"></i>{{ $ad->jenis_klien }}</small>
                                        </td>

                                        {{-- PERUSAHAAN & HRD --}}
                                        <td>
                                            <div class="fw-bold text-primary" style="font-size: 15px;">{{ $ad->nama_perusahaan }}</div>
                                            <small class="text-dark fw-bold d-block mt-1"><i class="fas fa-user-tie me-1"></i>{{ $ad->nama_hrd }}</small>
                                        </td>

                                        {{-- KONTAK --}}
                                        <td>
                                            <div style="font-size: 12px;">
                                                <div title="WA HRD"><i class="fab fa-whatsapp text-success me-1"></i> {{ $ad->wa_hrd }}</div>
                                                <div title="Email HRD" class="mt-1"><i class="fas fa-envelope text-secondary me-1"></i> {{ $ad->email }}</div>
                                            </div>
                                        </td>

                                        {{-- PROGRAM & SERTIFIKASI --}}
                                        <td>
                                            <span class="badge badge-info mb-1">{{ $ad->jenis_sertifikasi }}</span><br>
                                            <small class="text-dark d-block fw-medium">{{ Str::limit($ad->kebutuhan_program, 50) }}</small>
                                        </td>

                                        {{-- ACTION --}}
                                        <td class="text-center">
                                            <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                                @php $role = auth()->user()->role; @endphp
                                                
                                                {{-- Deliver khusus Admin --}}
                                                @if ($role == 'admin')
                                                    @if(!$ad->marketing_id)
                                                        <button class="btn btn-primary btn-sm btn-round w-100" data-bs-toggle="modal" data-bs-target="#modalDeliverAds{{ $ad->id }}">
                                                            <i class="fas fa-paper-plane me-1"></i> Deliver
                                                        </button>
                                                    @else
                                                        <span class="badge badge-success w-100 py-2"><i class="fa fa-check me-1"></i> Sent</span>
                                                    @endif
                                                @endif

                                                {{-- Edit & Hapus (RnD / DM) --}}
                                                @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-warning btn-sm w-100 btn-round"><i class="fa fa-edit"></i> Edit</a>
                                                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline w-100">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm w-100 btn-round" onclick="return confirm('Hapus data ads ini?')"><i class="fa fa-trash"></i> Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal Deliver Khusus Ads --}}
                                    <div class="modal fade" id="modalDeliverAds{{ $ad->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('ads.deliver', $ad->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content card-round">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="fw-bold m-0">Assign Lead Ads</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        <div class="mb-3">
                                                            <label class="fw-bold mb-1 small">Pilih Marketing <span class="text-danger">*</span></label>
                                                            <select name="marketing_id" class="form-select form-select-sm" required>
                                                                <option value="">-- Pilih --</option>
                                                                @foreach($marketings as $m)
                                                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- NEW: Input Tanggal Assign Ads --}}
                                                        <div class="mb-2">
                                                            <label class="fw-bold mb-1 small">Tanggal Assign <span class="text-danger">*</span></label>
                                                            <input type="date" name="tanggal_assign" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-round w-100">Kirim Ke Prospek</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        <div class="demo mt-3 d-flex justify-content-center">
                            {{ $adsData->links('partials.pagination') }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi Pulse untuk data yang belum diassign */
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    .badge-count { font-size: 0.65rem; }
    .nav-pills.nav-secondary .nav-link.active { background: #1a2035; color: #fff; border-radius: 8px; }
    .nav-pills .nav-link { color: #555; font-weight: 600; padding: 10px 20px; transition: all 0.2s; }
    .nav-pills .nav-link:hover:not(.active) { background: #f1f1f1; border-radius: 8px; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.checkItem:not([disabled])');
        const btnBulk = document.getElementById('btnBulkDeliver');
        const countSpan = document.getElementById('countSelected');
        const textCountModal = document.getElementById('textCountModal');

        // Fungsi update tombol bulk assign
        function updateBulkButton() {
            const checkedCount = document.querySelectorAll('.checkItem:checked').length;
            countSpan.innerText = checkedCount;
            if(textCountModal) textCountModal.innerText = checkedCount;

            if(checkedCount > 0) {
                btnBulk.removeAttribute('disabled');
            } else {
                btnBulk.setAttribute('disabled', 'disabled');
            }
        }

        if(checkAll) {
            checkAll.addEventListener('change', function() {
                checkItems.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkButton();
            });

            checkItems.forEach(cb => {
                cb.addEventListener('change', function() {
                    if(!this.checked) checkAll.checked = false;
                    const allChecked = Array.from(checkItems).every(item => item.checked);
                    if(allChecked && checkItems.length > 0) checkAll.checked = true;
                    updateBulkButton();
                });
            });
        }
    });
</script>
@endsection
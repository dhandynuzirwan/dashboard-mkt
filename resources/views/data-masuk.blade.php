@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Data Masuk</h3>
                <h6 class="text-muted mb-2 fw-normal">Database Marketing & Assignment Center</h6>
                
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border bg-white" style="color: #0ea5e9; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
            
            {{-- Tombol Aksi Tambah & Hapus Data --}}
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2 flex-wrap mt-3 mt-md-0">
                <a href="{{ route('form-data-masuk') }}" class="btn btn-success btn-round fw-bold shadow-sm hover-lift">
                    <i class="fa fa-plus me-1"></i> Tambah Data Masuk
                </a>
                @if(in_array(auth()->user()->role, ['admin', 'superadmin', 'rnd']))
                    <button class="btn btn-white border text-danger btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDeleteByDate">
                        <i class="fa fa-trash-alt me-1"></i> Hapus By Tanggal
                    </button>
                @endif
            </div>
        </div>

        {{-- ================= FILTER SECTION (MODERN SAAS) ================= --}}
        <div class="card card-modern mb-4 fade-in" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Data Masuk</h6>
                </div>

                <form action="{{ route('data-masuk.index') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <label class="label-modern">Cari Perusahaan / PIC</label>
                        <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 shadow-none ps-0" style="font-size: 13px;" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ request('start_date') }}">
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Status Deliver</label>
                        <select name="status_deliver" class="form-select form-select-sm input-modern shadow-none">
                            <option value="">Semua Status</option>
                            <option value="undelivered" {{ request('status_deliver') == 'undelivered' ? 'selected' : '' }}>🔴 Belum Diassign</option>
                            <option value="delivered" {{ request('status_deliver') == 'delivered' ? 'selected' : '' }}>🟢 Sudah Diassign</option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label class="label-modern">Marketing PIC</label>
                        <select name="marketing_id" class="form-select form-select-sm input-modern shadow-none">
                            <option value="">Semua Marketing</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-12 d-flex gap-2 justify-content-md-end mt-4 mt-lg-3">
                        <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift shadow-sm">
                            <i class="fas fa-search me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('data-masuk.index') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark hover-lift px-4 text-center shadow-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= STATS CARDS (MODERN UI) ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Data Masuk</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($totalData, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-info-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Data Hari Ini</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($totalToday, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-envelope-circle-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Email Valid</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($dataValid, 0, ',', '.') }}</h3>
                                <span class="badge badge-soft-success" style="font-size: 10px;">{{ $validPercentage }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-secondary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-secondary-subtle text-secondary me-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Di-Deliver</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($dataConverted, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-start mb-4 fade-in">
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-umum-tab" data-bs-toggle="pill" data-bs-target="#pills-umum" type="button" role="tab">
                    <i class="fas fa-layer-group me-1"></i> Data Umum
                </button>
                <button class="nav-link" id="pills-ads-tab" data-bs-toggle="pill" data-bs-target="#pills-ads" type="button" role="tab">
                    <i class="fas fa-bullhorn me-1"></i> Data Ads
                </button>
            </div>
        </div>

        <div class="tab-content fade-in" id="pills-tabContent">
            {{-- ================= TAB 1: DATA UMUM ================= --}}
            <div class="tab-pane fade show active" id="pills-umum" role="tabpanel">
                
                {{-- 🔥 CARD STATUS SINKRONISASI 🔥 --}}
                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                    @if(count($unsyncedCompanies) > 0)
                        <div class="alert alert-modern-warning mb-4 shadow-sm border-0">
                            <div class="d-flex align-items-start">
                                <div class="icon-sm bg-white text-warning-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 36px; height: 36px;">
                                    <i class="fas fa-exclamation-triangle animate-pulse"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bolder mb-1 text-dark">Butuh Sinkronisasi Assignment!</h6>
                                    <p class="mb-2 small text-dark opacity-75">
                                        Terdapat total <b class="text-danger">{{ count($unsyncedCompanies) }}</b> data perusahaan di seluruh database yang statusnya <b>Menunggu Admin</b>, namun <b>sudah ada di data Prospek</b>.
                                    </p>
                                    
                                    <div class="bg-white p-2 rounded-4 border border-warning shadow-sm mb-3" style="max-height: 120px; overflow-y: auto;">
                                        <strong class="small text-danger d-block mb-2 px-1">
                                            <i class="fas fa-list-ul me-1"></i> Daftar Perusahaan Nyangkut:
                                        </strong>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($unsyncedCompanies as $companyName)
                                                <span class="badge bg-warning-subtle text-warning-dark border border-warning px-2 py-1">
                                                    {{ $companyName }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('data-masuk.auto-sync') }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-dark btn-sm btn-round shadow-sm fw-bold hover-lift px-3" onclick="return confirm('Sistem akan otomatis menyesuaikan nama Marketing di Data Masuk mengikuti tabel Prospek. Lanjutkan?')">
                                            <i class="fas fa-sync-alt me-1 text-warning"></i> Sinkronkan Semua Otomatis
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="card card-modern shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title fw-bolder mb-0 text-dark">Tabel Data Masuk (Database Pusat)</h6>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <form action="{{ route('data-masuk.deliver-massal') }}" method="POST" id="formDeliverMassal">
                            @csrf
                            
                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <span class="text-muted small fw-bold">Aksi Massal:</span>
                                    <button type="button" class="btn btn-primary btn-sm btn-round fw-bold shadow-sm hover-lift px-3" data-bs-toggle="modal" data-bs-target="#modalDeliverMassal" id="btnBulkDeliver" disabled>
                                        <i class="fas fa-paper-plane me-1"></i> Deliver Terpilih (<span id="countSelected">0</span>)
                                    </button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-modern table-hover align-middle mb-0">
                                    <thead class="bg-light sticky-top">
                                        <tr>
                                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                <th width="40" class="text-center"><input type="checkbox" id="checkAll" class="form-check-input shadow-none"></th>
                                            @endif
                                            <th width="150">INFO DATA</th>
                                            <th width="250">PERUSAHAAN & UNIT</th>
                                            <th>KONTAK</th>
                                            <th>ASSIGNMENT</th>
                                            <th width="100" class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allData as $item)
                                            <tr>
                                                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="form-check-input checkItem shadow-none" {{ $item->marketing_id ? 'disabled' : '' }}>
                                                    </td>
                                                @endif

                                                <td class="align-middle ps-3">
                                                    <span class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</span><br>
                                                    @if($item->is_ads)
                                                        <span class="badge badge-soft-primary my-1 border"><i class="fas fa-bullhorn me-1"></i> Ads</span><br>
                                                    @else
                                                        <span class="badge badge-soft-secondary my-1 border">{{ $item->sumber }}</span><br>
                                                    @endif
                                                    <small class="text-muted fw-medium"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $item->lokasi ?? '-' }}</small>
                                                </td>
                                                
                                                <td class="align-middle">
                                                    <div class="fw-bolder text-primary" style="font-size: 14px;">{{ $item->perusahaan }}</div>
                                                    <small class="text-muted d-block fw-medium mt-1"><i class="fas fa-building me-1"></i> Unit: {{ $item->unit_bisnis ?? '-' }}</small>
                                                </td>

                                                <td class="align-middle">
                                                    <div class="d-flex flex-column gap-1" style="font-size: 12px;">
                                                        @if($item->email)
                                                            <div title="Email" class="d-flex align-items-center">
                                                                <i class="fas fa-envelope text-secondary me-2"></i> <span class="text-dark fw-medium">{{ $item->email }}</span>
                                                                @if($item->status_email) <span class="badge badge-soft-secondary ms-2" style="font-size: 9px;">{{ $item->status_email }}</span> @endif
                                                            </div>
                                                        @endif
                                                        @if($item->telp) 
                                                            <div title="Telp Perusahaan" class="d-flex align-items-center"><i class="fas fa-phone text-primary me-2"></i> <span class="text-dark fw-medium">{{ $item->telp }}</span></div> 
                                                        @endif
                                                        @if($item->wa_baru ?? $item->wa_pic) 
                                                            <div title="WhatsApp" class="d-flex align-items-center"><i class="fab fa-whatsapp text-success me-2 fs-6"></i> <span class="text-dark fw-medium">{{ $item->wa_baru ?? $item->wa_pic }}</span></div> 
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="align-middle text-start">
                                                    @if($item->marketing)
                                                        @if(!in_array($item->perusahaan, $prospekList))
                                                            <span class="badge badge-soft-warning border border-warning" title="Data ini nyangkut! Assigned tapi tidak ada di Pipeline">
                                                                <i class="fas fa-exclamation-triangle text-warning-dark me-1"></i> Nyangkut ({{ $item->marketing->name }})
                                                            </span>
                                                        @else
                                                            <span class="badge badge-soft-info border border-info px-3 py-1">
                                                                <i class="fas fa-user-check me-1"></i> {{ $item->marketing->name }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-soft-danger px-3 py-1 animate-pulse border border-danger">
                                                            <i class="fas fa-clock me-1"></i> Menunggu Admin
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="text-center align-middle pe-3">
                                                    <div class="d-flex flex-column gap-2 justify-content-center">
                                                        @php $role = auth()->user()->role; @endphp

                                                        @if (in_array($role, ['admin', 'superadmin']))
                                                            @if(!$item->marketing)
                                                                <button type="button" class="btn btn-primary btn-sm btn-round w-100 fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDeliver{{ $item->id }}">
                                                                    <i class="fas fa-paper-plane me-1"></i> Deliver
                                                                </button>
                                                            @else
                                                                <span class="badge badge-soft-success w-100 py-2 border border-success"><i class="fa fa-check me-1"></i> Sent</span>
                                                            @endif
                                                        @endif

                                                        @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                            <a href="{{ route('data-masuk.edit', $item->id) }}" class="btn btn-warning text-dark btn-sm w-100 btn-round fw-bold shadow-sm hover-lift"><i class="fa fa-edit"></i> Edit</a>
                                                            <button type="button" onclick="if(confirm('Hapus data ini?')) document.getElementById('delete-form-{{ $item->id }}').submit();" class="btn btn-danger btn-sm w-100 btn-round fw-bold shadow-sm hover-lift">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ in_array(auth()->user()->role, ['admin', 'superadmin']) ? 6 : 5 }}" class="text-center py-5 text-muted">
                                                    <i class="fas fa-folder-open fs-1 mb-3 text-light"></i><br>
                                                    Belum ada data masuk yang sesuai dengan filter.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        {{-- Pagination Umum --}}
                        @if($allData->hasPages())
                        <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                            <div class="d-flex justify-content-center">
                                {{ $allData->links('partials.pagination') }} 
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================= TAB 2: DATA ADS ================= --}}
            <div class="tab-pane fade" id="pills-ads" role="tabpanel">
                <div class="card card-modern shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title fw-bolder mb-0 text-dark">Tabel Data Leads (Ads)</h6>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th width="140" class="ps-4 text-center">TANGGAL & SUMBER</th>
                                        <th width="250">PERUSAHAAN & HRD</th>
                                        <th>KONTAK</th>
                                        <th width="280">PROGRAM & SERTIFIKASI</th>
                                        <th width="120" class="text-center pe-4">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($adsData as $ad)
                                    <tr>
                                        <td class="text-center align-middle ps-4">
                                            <span class="fw-bold text-dark">{{ $ad->created_at->format('d M Y') }}</span><br>
                                            <span class="badge badge-soft-primary border mt-1 mb-1">{{ $ad->channel_akuisisi }}</span><br>
                                            <small class="text-muted fw-medium"><i class="fas fa-tag me-1"></i>{{ $ad->jenis_klien }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-bolder text-primary" style="font-size: 14px;">{{ $ad->nama_perusahaan }}</div>
                                            <small class="text-dark fw-bold d-block mt-1"><i class="fas fa-user-tie me-1 text-muted"></i>{{ $ad->nama_hrd }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column gap-1" style="font-size: 12px;">
                                                <div title="WA HRD" class="d-flex align-items-center"><i class="fab fa-whatsapp text-success me-2 fs-6"></i> <span class="text-dark fw-medium">{{ $ad->wa_hrd }}</span></div>
                                                <div title="Email HRD" class="d-flex align-items-center"><i class="fas fa-envelope text-secondary me-2"></i> <span class="text-dark fw-medium">{{ $ad->email }}</span></div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-soft-info border mb-2">{{ $ad->jenis_sertifikasi }}</span><br>
                                            <small class="text-dark d-block fw-medium lh-sm">{{ Str::limit($ad->kebutuhan_program, 60) }}</small>
                                        </td>
                                        <td class="text-center align-middle pe-4">
                                            <div class="d-flex flex-column gap-2 justify-content-center align-items-center">
                                                @php $role = auth()->user()->role; @endphp
                                                
                                                @if (in_array($role, ['admin', 'superadmin']))
                                                    @if(!$ad->marketing_id)
                                                        <button class="btn btn-primary btn-sm btn-round w-100 fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalDeliverAds{{ $ad->id }}">
                                                            <i class="fas fa-paper-plane me-1"></i> Deliver
                                                        </button>
                                                    @else
                                                        <span class="badge badge-soft-success border border-success w-100 py-2"><i class="fa fa-check me-1"></i> Sent</span>
                                                    @endif
                                                @endif

                                                @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-warning text-dark btn-sm w-100 btn-round fw-bold shadow-sm hover-lift"><i class="fa fa-edit"></i> Edit</a>
                                                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline w-100">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm w-100 btn-round fw-bold shadow-sm hover-lift" onclick="return confirm('Hapus data ads ini?')"><i class="fa fa-trash"></i> Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-bullhorn fs-1 mb-3 text-light"></i><br>
                                            Belum ada data leads dari Ads.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination Ads --}}
                    @if($adsData->hasPages())
                    <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                        <div class="d-flex justify-content-center">
                            {{ $adsData->links('partials.pagination') }} 
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODALS SECTION (MODERN SAAS) ================= --}}

{{-- 1. Modal Hapus By Tanggal --}}
@if(in_array(auth()->user()->role, ['admin', 'superadmin', 'rnd']))
<div class="modal fade" id="modalDeleteByDate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('data-masuk.destroy-by-date') }}" method="POST">
            @csrf
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-danger-subtle text-danger border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder"><i class="fa fa-exclamation-triangle me-2"></i> Hapus Data Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pt-3 pb-4">
                    <div class="alert alert-modern-danger mb-4 border-0">
                        <b class="text-dark">Peringatan:</b> Aksi ini akan menghapus data secara permanen berdasarkan rentang waktu <b>Tanggal Input</b> (<i>created_at</i>). Aksi ini tidak dapat dibatalkan.
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="label-modern">Dari Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control input-modern shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Sampai Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control input-modern shadow-none" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white border btn-round fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-round fw-bold shadow-sm hover-lift px-4" onclick="return confirm('Apakah Anda sangat yakin ingin menghapus data di rentang tanggal ini?')">
                        <i class="fa fa-trash me-1"></i> Hapus Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- 2. Modal Deliver Massal (Admin Only) --}}
@if (in_array(auth()->user()->role, ['admin', 'superadmin']))
<div class="modal fade" id="modalDeliverMassal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modern border-0 shadow-lg text-start">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder m-0"><i class="fas fa-users-cog me-2"></i> Assign Massal ke Marketing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-3">
                <div class="alert alert-modern-info py-3 px-3 small mb-4 border-0 shadow-none">
                    Anda akan mengirim <b id="textCountModal" class="text-primary fs-6">0</b> data terpilih ke Pipeline Prospek.
                </div>
                
                <div class="mb-4">
                    <label class="label-modern">Pilih Marketing PIC <span class="text-danger">*</span></label>
                    <select name="marketing_id" form="formDeliverMassal" class="form-select input-modern shadow-none" required>
                        <option value="">-- Pilih Marketing --</option>
                        @foreach($marketings as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="label-modern">Tanggal Assign <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_assign" form="formDeliverMassal" class="form-control input-modern shadow-none" value="{{ date('Y-m-d') }}" required>
                    <small class="text-muted d-block mt-2" style="font-size: 11px;">Ubah tanggal jika ingin mendeliver untuk besok/kemarin.</small>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formDeliverMassal" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Kirim ke Pipeline</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- 3. Kumpulan Modal Deliver Satuan (Data Umum) --}}
@if (in_array(auth()->user()->role, ['admin', 'superadmin']))
    @foreach ($allData as $item)
        @if(!$item->marketing)
        <div class="modal fade" id="modalDeliver{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('data-masuk.deliver', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-content card-modern border-0 shadow-lg text-start">
                        <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                            <h5 class="modal-title fw-bolder m-0"><i class="fas fa-paper-plane me-2"></i> Assign Lead Prospek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pt-3">
                            <p class="small text-muted mb-4">Assign perusahaan <b class="text-dark">{{ Str::limit($item->perusahaan, 40) }}</b> ke Pipeline.</p>
                            
                            <div class="mb-4">
                                <label class="label-modern">Pilih Marketing PIC <span class="text-danger">*</span></label>
                                <select name="marketing_id" class="form-select input-modern shadow-none" required>
                                    <option value="">-- Pilih Marketing --</option>
                                    @foreach($marketings as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="label-modern">Tanggal Assign <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_assign" class="form-control input-modern shadow-none" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                            <button type="button" class="btn btn-white border btn-round fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Kirim ke Pipeline</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endforeach
@endif

{{-- 4. Kumpulan Modal Deliver Satuan (Data Ads) --}}
@if (in_array(auth()->user()->role, ['admin', 'superadmin']))
    @foreach ($adsData as $ad)
        @if(!$ad->marketing_id)
        <div class="modal fade" id="modalDeliverAds{{ $ad->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('ads.deliver', $ad->id) }}" method="POST">
                    @csrf
                    <div class="modal-content card-modern border-0 shadow-lg text-start">
                        <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                            <h5 class="modal-title fw-bolder m-0"><i class="fas fa-bullhorn me-2"></i> Assign Lead Ads</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pt-3">
                            <p class="small text-muted mb-4">Assign prospek dari ads <b class="text-dark">{{ Str::limit($ad->nama_perusahaan, 40) }}</b> ke Pipeline.</p>
                            
                            <div class="mb-4">
                                <label class="label-modern">Pilih Marketing PIC <span class="text-danger">*</span></label>
                                <select name="marketing_id" class="form-select input-modern shadow-none" required>
                                    <option value="">-- Pilih Marketing --</option>
                                    @foreach($marketings as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="label-modern">Tanggal Assign <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_assign" class="form-control input-modern shadow-none" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                            <button type="button" class="btn btn-white border btn-round fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Kirim ke Pipeline</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endforeach
@endif

{{-- Form Delete Satuan untuk RnD (Hidden) --}}
@if (in_array(auth()->user()->role, ['rnd', 'digitalmarketing']))
    @foreach ($allData as $item)
        <form id="delete-form-{{ $item->id }}" action="{{ route('data-masuk.destroy', $item->id) }}" method="POST" class="d-none">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endif

</div></div>

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
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-secondary-subtle { background-color: #f8fafc !important; }
    .text-warning-dark { color: #b45309 !important; }
    
    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-info-subtle { border-color: #a5f3fc !important; }
    .border-secondary-subtle { border-color: #e2e8f0 !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-secondary { background-color: #f8fafc; color: #475569; }

    /* Alert Modern */
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-danger { background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-warning { background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-info { background-color: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

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
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active {
        background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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
        border-bottom: 1px solid #f1f5f9;
        padding: 16px;
    }

    /* Form Modern */
    .label-modern {
        font-weight: 700;
        color: #64748b;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: block;
    }
    .input-modern {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        color: #334155;
        background-color: #ffffff;
    }
    .input-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
    .pagination { justify-content: center; }
</style>

{{-- ================= SCRIPTS ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Jam Realtime
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Checkbox Logic untuk Deliver Massal
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.checkItem:not([disabled])');
        const btnBulk = document.getElementById('btnBulkDeliver');
        const countSpan = document.getElementById('countSelected');
        const textCountModal = document.getElementById('textCountModal');

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
                checkItems.forEach(cb => { cb.checked = this.checked; });
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
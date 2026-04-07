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
                                    <i class="icon-layers"></i> {{-- Menggunakan icon-layers bawaan Kaiadmin --}}
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
                                    <i class="icon-calendar"></i> {{-- Menggunakan icon-calendar bawaan Kaiadmin --}}
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
                                    <i class="icon-envelope-letter"></i> {{-- Menggunakan icon-envelope-letter bawaan Kaiadmin --}}
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

            {{-- 4. Total Ter-Deliver (Prospek) --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate h-100 mb-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="icon-paper-plane"></i> {{-- Menggunakan icon-paper-plane bawaan Kaiadmin --}}
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
            
            {{-- Tombol Hapus By Tanggal (Hanya untuk Role Tertentu jika diperlukan, misal Admin) --}}
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

        <ul class="nav nav-pills nav-secondary bg-white p-1 rounded d-inline-flex mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-umum-tab" data-bs-toggle="pill" href="#pills-umum" role="tab">
                    <i class="fas fa-database me-1"></i> Data Umum
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-ads-tab" data-bs-toggle="pill" href="#pills-ads" role="tab">
                    <i class="fas fa-bullhorn me-1"></i> Data Ads Lead 
                </a>
            </li>
        </ul>

        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            {{-- TAB 1: DATA UMUM --}}
            <div class="tab-pane fade show active" id="pills-umum" role="tabpanel">
                <div class="card card-round shadow-sm">
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

                        {{-- FORM BUNGKUSAN UNTUK DELIVER MASSAL --}}
                        <form action="{{ route('data-masuk.deliver-massal') }}" method="POST" id="formDeliverMassal">
                            @csrf
                            
                            {{-- Tombol Deliver Massal (Hanya muncul untuk Admin) --}}
                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modalDeliverMassal" id="btnBulkDeliver" disabled>
                                        <i class="fas fa-paper-plane me-1"></i> Deliver Terpilih (<span id="countSelected">0</span>)
                                    </button>
                                </div>

                                {{-- Modal Deliver Massal --}}
                                <div class="modal fade" id="modalDeliverMassal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content card-round text-start">
                                            <div class="modal-header border-0">
                                                <h6 class="fw-bold m-0">Assign Massal ke Marketing</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-2">
                                                <p class="small text-muted mb-2">Pilih marketing untuk <b id="textCountModal">0</b> data prospek terpilih.</p>
                                                <select name="marketing_id" class="form-select form-select-sm" required>
                                                    <option value="">-- Pilih Marketing --</option>
                                                    @foreach($marketings as $m)
                                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary btn-sm btn-round w-100">Kirim ke Pipeline</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            {{-- HEADER CHECKBOX --}}
                                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                <th width="40"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                            @endif
                                            
                                            <th width="120">Tanggal Input</th>
                                            <th>Marketing Assignment</th>
                                            <th>Perusahaan</th>
                                            <th>Telp Perusahaan</th>
                                            <th>Unit Bisnis</th>
                                            <th>Email</th>
                                            <th>Status Email</th>
                                            <th>WhatsApp</th>
                                            <th>Lokasi</th>
                                            <th>Sumber</th>
                                            <th width="150">Aksi</th>
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

                                                <td class="text-center small">{{ $item->created_at->format('d/m/Y') }}</td>
                                                
                                                {{-- KODE TABEL KAMU YANG LAIN TETAP SAMA --}}
                                                <td class="text-center">
                                                    @if($item->marketing)
                                                        {{-- CEK: Apakah perusahaan ini ADA di array $prospekList? --}}
                                                        @if(!in_array($item->perusahaan, $prospekList))
                                                            {{-- Jika TIDAK ADA di Prospek, tampilkan badge peringatan --}}
                                                            <span class="badge badge-warning shadow-sm" title="Data ini nyangkut! Assigned tapi tidak ada di Pipeline Prospek">
                                                                <i class="fas fa-exclamation-triangle text-dark me-1"></i> 
                                                                <span class="text-dark">Data Nyangkut ({{ $item->marketing->name }})</span>
                                                            </span>
                                                        @else
                                                            {{-- Jika AMAN, tampilkan normal --}}
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
                                                <td class="fw-bold">{{ $item->perusahaan }}</td>
                                                <td>{{ $item->telp }}</td>
                                                <td>{{ $item->unit_bisnis }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->status_email }}</td>
                                                <td class="text-center">{{ $item->wa_baru ?? $item->wa_pic }}</td>
                                                <td class="text-center">{{ $item->lokasi }}</td>
                                                <td class="text-center">
                                                    @if($item->is_ads)
                                                        <span class="badge badge-primary"><i class="fas fa-bullhorn me-1"></i> Ads</span>
                                                    @else
                                                        {{ $item->sumber }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php $role = auth()->user()->role; @endphp

                                                    @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                        <div class="btn-group mb-1">
                                                            <a href="{{ route('data-masuk.edit', $item->id) }}" class="btn btn-warning btn-xs" title="Edit Data">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            {{-- Note: Karena ada form bulk, hapus satuan butuh button type button yg manggil JS atau biarkan jika tidak konflik --}}
                                                            <a href="#" onclick="event.preventDefault(); if(confirm('Hapus data ini?')) document.getElementById('delete-form-{{ $item->id }}').submit();" class="btn btn-danger btn-xs">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if (in_array($role, ['admin']))
                                                        @if(!$item->marketing)
                                                            <button type="button" class="btn btn-primary btn-xs btn-round w-100" data-bs-toggle="modal" data-bs-target="#modalDeliver{{ $item->id }}">
                                                                <i class="fas fa-paper-plane me-1"></i> Deliver
                                                            </button>
                                                        @else
                                                            <span class="badge badge-success mb-1"><i class="fa fa-check"></i> Sent</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
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

            {{-- TAB 2: DATA ADS --}}
            <div class="tab-pane fade" id="pills-ads" role="tabpanel">
                <div class="card card-round shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" style="min-width: 1000px">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>HRD / Perusahaan</th>
                                        <th>Kontak</th>
                                        <th>Program & Sertifikasi</th>
                                        <th>Sumber/Klien</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adsData as $ad)
                                    <tr>
                                        <td class="text-center small">{{ $ad->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $ad->nama_hrd }}</span><br>
                                            <small class="text-muted">{{ $ad->nama_perusahaan }}</small>
                                        </td>
                                        <td>
                                            <i class="fab fa-whatsapp text-success"></i> {{ $ad->wa_hrd }}<br>
                                            <small>{{ $ad->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $ad->jenis_sertifikasi }}</span><br>
                                            <small>{{ Str::limit($ad->kebutuhan_program, 30) }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $ad->channel_akuisisi }}</span><br>
                                            <small>{{ $ad->jenis_klien }}</small>
                                        </td>
                                        <td class="text-center">
                                            @php $role = auth()->user()->role; @endphp
                                            
                                            {{-- Deliver khusus Admin --}}
                                            @if ($role == 'admin')
                                                @if(!$ad->marketing_id)
                                                    <button class="btn btn-primary btn-xs btn-round w-100 mb-1" data-bs-toggle="modal" data-bs-target="#modalDeliverAds{{ $ad->id }}">
                                                        <i class="fas fa-paper-plane"></i> Deliver
                                                    </button>
                                                @else
                                                    <span class="badge badge-success mb-1"><i class="fa fa-check"></i> Sent</span>
                                                @endif
                                            @endif

                                            {{-- Edit & Hapus (RnD / Admin) --}}
                                            @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                <div class="btn-group">
                                                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-xs" onclick="return confirm('Hapus data ads ini?')"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Modal Deliver Khusus Ads --}}
                                    <div class="modal fade" id="modalDeliverAds{{ $ad->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <form action="{{ route('ads.deliver', $ad->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-content card-round">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="fw-bold m-0">Assign Lead Ads</h6>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        <label class="small mb-1">Pilih Marketing:</label>
                                                        <select name="marketing_id" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            @foreach($marketings as $m)
                                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                            @endforeach
                                                        </select>
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
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    .btn-xs { padding: 3px 10px; font-size: 0.75rem; }
    .badge-count { font-size: 0.65rem; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.checkItem:not([disabled])');
        const btnBulk = document.getElementById('btnBulkDeliver');
        const countSpan = document.getElementById('countSelected');
        const textCountModal = document.getElementById('textCountModal');

        // Fungsi update tombol
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
                    // Uncheck 'checkAll' jika ada satu yang tidak dicentang
                    if(!this.checked) checkAll.checked = false;
                    
                    // Check 'checkAll' jika semua item aktif tercentang
                    const allChecked = Array.from(checkItems).every(item => item.checked);
                    if(allChecked && checkItems.length > 0) checkAll.checked = true;

                    updateBulkButton();
                });
            });
        }
    });
</script>
@endsection
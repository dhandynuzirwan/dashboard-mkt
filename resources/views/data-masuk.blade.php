@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        {{-- Header & Filter Section --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
            <div>
                <h3 class="fw-bold mb-1">Data Masuk</h3>
                <h6 class="op-7 mb-2">Database Marketing & Assignment Center</h6>
            </div>
            
            <div class="ms-md-auto py-2 py-md-0">
                <form action="{{ route('data-masuk.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="form-group p-0 m-0">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" title="Tanggal Mulai">
                    </div>
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" title="Tanggal Akhir">
                    </div>
                    {{-- Tambahkan dropdown ini di dalam form filter --}}
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
                        <button type="submit" class="btn btn-primary btn-sm btn-round"><i class="fas fa-filter"></i> Filter</button>
                        <a href="{{ route('data-masuk.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-2">
            {{-- ... (Gunakan Stats Cards yang sudah kamu punya sebelumnya) ... --}}
        </div>

        {{-- Tombol Tambah Data --}}
        <div class="mb-3">
            <a href="{{ route('form-data-masuk') }}" class="btn btn-success btn-sm btn-round">
                <i class="fa fa-plus me-1"></i> Tambah Data Masuk
            </a>
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-pills nav-secondary mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-umum-tab" data-bs-toggle="pill" href="#pills-umum" role="tab">
                    <i class="fas fa-database me-1"></i> Data Umum
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-ads-tab" data-bs-toggle="pill" href="#pills-ads" role="tab">
                    <i class="fas fa-bullhorn me-1"></i> Data Ads Lead 
                    @if($adsData->count() > 0)
                        <span class="badge badge-notification bg-danger">{{ $adsData->total() }}</span>
                    @endif
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
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th width="120">Tanggal Input</th> {{-- KOLOM BARU --}}
                                        <th>Marketing Assignment</th>
                                        <th>Perusahaan</th>
                                        <th>Email</th>
                                        <th>WhatsApp</th>
                                        <th>Lokasi</th>
                                        <th>Sumber</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $item)
                                        <tr>
                                            <td class="text-center small">{{ $item->created_at->format('d/m/Y') }}</td> {{-- ISI TANGGAL --}}
                                            {{-- Di bagian <td> Marketing Assignment --}}
                                            <td class="text-center">
                                                @if($item->marketing)
                                                    <span class="badge badge-info shadow-sm">
                                                        <i class="fas fa-user-check me-1"></i> {{ $item->marketing->name }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger badge-count animate-pulse">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Menunggu Admin
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $item->perusahaan }}</td>
                                            <td>{{ $item->email }}</td>
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

                                                {{-- AKSI UNTUK RND / DIGITAL MARKETING --}}
                                                @if (in_array($role, ['rnd', 'digitalmarketing']))
                                                    <div class="btn-group mb-1">
                                                        <a href="{{ route('data-masuk.edit', $item->id) }}" class="btn btn-warning btn-xs" title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('data-masuk.destroy', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-danger btn-xs" onclick="return confirm('Hapus data ini?')" title="Hapus Data">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                {{-- AKSI UNTUK ADMIN: DELIVER --}}
                                                @if (in_array($role, ['admin']))
                                                    @if(!$item->marketing) {{-- Hanya muncul jika marketing_id NULL --}}
                                                        <button class="btn btn-primary btn-xs btn-round w-100" data-bs-toggle="modal" data-bs-target="#modalDeliver{{ $item->id }}">
                                                            <i class="fas fa-paper-plane me-1"></i> Deliver
                                                        </button>

                                                        {{-- Modal Assignment ke Marketing --}}
                                                        <div class="modal fade" id="modalDeliver{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <form action="{{ route('data-masuk.deliver', $item->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-content card-round text-start">
                                                                        <div class="modal-header border-0">
                                                                            <h6 class="fw-bold m-0">Assign ke Marketing</h6>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body py-2">
                                                                            <p class="small text-muted mb-2">Pilih marketing untuk prospek <b>{{ $item->perusahaan }}</b>.</p>
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
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Tampilan jika data sudah ter-assign --}}
                                                        <button class="btn btn-outline-success btn-xs btn-round w-100" disabled>
                                                            <i class="fas fa-check-double me-1"></i> Terdistribusi
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                            <table class="table table-bordered align-middle">
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
                                            <div class="btn-group">
                                                <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-xs" onclick="return confirm('Hapus data ads ini?')"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
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
@endsection
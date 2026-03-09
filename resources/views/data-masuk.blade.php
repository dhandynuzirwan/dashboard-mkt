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

        {{-- Tabel Utama --}}
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
                                        @if (in_array($role, ['rnd', 'digitalmarketing', 'superadmin']))
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
                                        @if (in_array($role, ['admin', 'superadmin']))
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
</div>

<style>
    /* ... (Style yang sudah kamu punya sebelumnya) ... */
    .btn-xs { padding: 2px 8px; font-size: 0.75rem; }
</style>
@endsection
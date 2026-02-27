@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        {{-- Header & Filter Section - Dibuat sejajar dan compact --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
            <div>
                <h3 class="fw-bold mb-1">Data Masuk</h3>
                <h6 class="op-7 mb-2">Database Marketing</h6>
            </div>
            
            <div class="ms-md-auto py-2 py-md-0">
                <form action="{{ route('data-masuk.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    {{-- Filter Tanggal Mulai --}}
                    <div class="form-group p-0 m-0">
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            value="{{ request('start_date') }}" title="Tanggal Mulai">
                    </div>

                    {{-- Filter Tanggal Akhir --}}
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            value="{{ request('end_date') }}" title="Tanggal Akhir">
                    </div>

                    {{-- Filter Marketing --}}
                    <div class="form-group p-0 m-0">
                        <select name="marketing_id" class="form-select form-select-sm">
                            <option value="">Semua Marketing</option>
                            @foreach ($marketings as $m)
                                <option value="{{ $m->id }}"
                                    {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Sumber --}}
                    <div class="form-group p-0 m-0">
                        <select name="sumber" class="form-select form-select-sm">
                            <option value="">Semua Sumber</option>
                            <option value="Website" {{ request('sumber') == 'Website' ? 'selected' : '' }}>Website</option>
                            <option value="Instagram" {{ request('sumber') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="Ads" {{ request('sumber') == 'Ads' ? 'selected' : '' }}>Ads</option>
                            <option value="LinkedIn" {{ request('sumber') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm btn-round">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('data-masuk.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stats Cards - Ditambahkan card-animate agar konsisten dengan Pipeline --}}
        <div class="row mb-2">
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
                                    <p class="card-category">Total Database</p>
                                    <h4 class="card-title">{{ $totalData }}</h4>
                                    <p class="text-muted small mb-0">+{{ $totalToday }} Hari Ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Email Valid</p>
                                    <h4 class="card-title">{{ $dataValid }}</h4>
                                    <p class="text-success small mb-0">{{ $validPercentage }}% Validitas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-solar-panel"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Source: ADS</p>
                                    <h4 class="card-title">{{ $dataAds }}</h4>
                                    <p class="text-info small mb-0">IG & Google</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-inbox"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sudah Prospek</p>
                                    <h4 class="card-title">{{ $dataConverted }}</h4>
                                    <p class="text-secondary small mb-0">Di Pipeline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Tambah Data --}}
        <div class="mb-3">
            <a href="{{ route('form-data-masuk') }}" class="btn btn-success btn-sm btn-round">
                <i class="fa fa-plus me-1"></i> Tambah Data Masuk
            </a>
        </div>

        {{-- Tabel Utama - 100% Struktur Kolom Sesuai Kode Kamu --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tabel Data Masuk</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Marketing</th>
                                <th>Perusahaan</th>
                                <th>Unit Bisnis</th>
                                <th>Email</th>
                                <th>Status Email</th>
                                <th>WhatsApp</th>
                                <th>Sumber</th>
                                @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $item)
                                <tr>
                                    <td>{{ $item->marketing->name }}</td>
                                    <td>{{ $item->perusahaan }}</td>
                                    <td>{{ $item->unit_bisnis }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <span class="badge {{ $item->status_email == 'Valid' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $item->status_email }}
                                        </span>
                                    </td>
                                    <td>{{ $item->wa_baru ?? $item->wa_pic }}</td>
                                    <td>{{ $item->sumber }}</td>
                                    @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                                        <td>
                                            <div class="d-flex align-items-center" style="gap: 5px;">
                                                <a href="{{ route('data-masuk.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('data-masuk.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data ini?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
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
    /* Style pendukung agar sama dengan Pipeline */
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

    /* Merapikan tinggi input filter agar sejajar */
    .form-control-sm, .form-select-sm {
        height: 31px;
    }
</style>
@endsection
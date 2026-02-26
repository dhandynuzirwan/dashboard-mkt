@extends('layouts.app') @section('content')
<<<<<<< HEAD
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data Masuk</h3>
                    <h6 class="op-7 mb-2">Database Marketing</h6>
                </div>
                {{-- <div class="ms-md-auto py-2 py-md-0">
                        <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                        <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                    </div> --}}
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Data</p>
                                        <h4 class="card-title">{{ $totalData }}</h4>
=======

    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            @include('layouts.header')
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Data Masuk</h3>
                            <h6 class="op-7 mb-2">Database Marketing</h6>
                        </div>
                        
                        <div class="ms-md-auto py-2 py-md-0">
                            <form action="{{ route('data-masuk.index') }}" method="GET" class="d-flex flex-wrap gap-2">
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
                                <button type="submit" class="btn btn-primary btn-sm btn-round">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('data-masuk.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
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
                                                <small class="text-muted">+{{ $totalToday }} Hari Ini</small>
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
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Email Valid</p>
                                                <h4 class="card-title">{{ $dataValid }}</h4>
                                                <small class="text-success">{{ $validPercentage }}% Tingkat Validitas</small>
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
                                                <i class="fas fa-solar-panel"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Source: ADS</p>
                                                <h4 class="card-title">{{ $dataAds }}</h4>
                                                <small class="text-info">Instagram & Google</small>
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
                                                <i class="fas fa-inbox"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Sudah Prospek</p>
                                                <h4 class="card-title">{{ $dataConverted }}</h4>
                                                <small class="text-muted">Masuk ke Pipeline</small>
                                            </div>
                                        </div>
>>>>>>> dc687de5d8b1b7c9e5eafe726c0bfd60aed1cc06
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
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-award"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Data ADS</p>
                                        <h4 class="card-title">{{ $dataAds }}</h4>
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
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Data Manual</p>
                                        <h4 class="card-title">{{ $dataManual }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- jika ingin dua tabel side by side --}}
            {{-- <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tabel Pipeline</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>DATE</th>                    
                                        <th>PERUSAHAAN</th>
                                        <th>NO TELP</th>
                                        <th>EMAIL</th>
                                        <th>JABATAN</th>
                                        <th>NAMA</th>
                                        <th>TELP PIC</th>
                                        <th>ALAMAT PERUSAHAAN</th>
                                        <th>SOURCE</th>
                                        <th>UPDATE FU</th>
                                        <th>STATUS AKHIR DATA</th>
                                        <th>KETERANGAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2024-01-01</td>
                                            <td>PT. Maju Jaya</td>
                                            <td>08123456789</td>
                                            <td>marketing@ptmaju.com</td>
                                            <td>HRD</td>
                                            <td>John Doe</td>
                                            <td>08123456789</td>
                                            <td>Jl. Raya Maju Jaya No. 123</td>
                                            <td>Database Marketing</td>
                                            <td>Terhubung HRD</td>
                                            <td>Masuk Penawaran</td>
                                            <td>PT INDO, Ibu Sinta (0888229)</td>
                                            <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
                                            <td><a href="#" class="btn btn-success btn-sm">CTA</a></td>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Data CTA Marketing</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID PROSPEK</th>
                                        <th>MARKETING</th>
                                        <th>DATE</th>                    
                                        <th>PERUSAHAAN</th>
                                        <th>PERMINTAAN JUDUL</th>
                                        <th>JUMLAH PESERTA</th>
                                        <th>SERTIFIKASI</th>
                                        <th>SKEMA</th>
                                        <th>HARGA PENAWARAN</th>
                                        <th>HARGA VENDOR</th>
                                        <th>PROPOSAL PENAWARAN</th>
                                        <th>STATUS PENAWARAN</th>
                                        <th>KETERANGAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Marketing 1</td>
                                            <td>2024-01-01</td>
                                            <td>PT. Maju Jaya</td>
                                            <td>Teknisi K3 Listrik</td>
                                            <td>5</td>
                                            <td>KEMENAKER RI</td>
                                            <td>Public Training</td>
                                            <td>Rp 50.000.000</td>
                                            <td>Rp 35.000.000</td>
                                            <td><a href="#">Nama File</a></td>
                                            <td>Under Review</td>
                                            <td>Belum ada kabar</td>
                                            <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            <div class="mb-4">
                <a href="{{ route('form-data-masuk') }}" class="btn btn-success">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Data Masuk
                </a>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel Data Masuk</div>
                </div>
                <div class="card-body">
                    {{-- <div class="card-sub">
                      Create responsive tables by wrapping any table with
                      <code class="highlighter-rouge">.table-responsive</code>
                      <code class="highlighter-rouge">DIV</code> to make them
                      scroll horizontally on small devices
                    </div> --}}
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
                                            <span
                                                class="badge {{ $item->status_email == 'Valid' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $item->status_email }}
                                            </span>
                                        </td>
                                        <td>{{ $item->wa_baru ?? $item->wa_pic }}</td>
                                        <td>{{ $item->sumber }}</td>
                                        @if (auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
                                            <td>
                                                <a href="{{ route('data-masuk.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

<<<<<<< HEAD
                                                <form action="{{ route('data-masuk.destroy', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data ini?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
=======
                                                        <form action="{{ route('data-masuk.destroy', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Yakin hapus data ini?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="demo mt-3 d-flex justify-content-center">
                                {{ $allData->links('partials.pagination') }} 
                            </div>
                        </div>
>>>>>>> dc687de5d8b1b7c9e5eafe726c0bfd60aed1cc06
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

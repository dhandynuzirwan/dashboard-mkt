@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Master Artikel</h3>
                <h6 class="text-muted mb-2 fw-normal">Database Artikel</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Artikel</p>
                                    <h4 class="card-title">{{ $totalStat }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-title">Statistik Artikel per Bulan (Tahun Ini)</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 250px">
                            <canvas id="statisticsChart"></canvas>

                            <div class="mt-4">
                                {{ $artikels->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-filter"></i> Filter Pencarian</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('master-artikel.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label>Cari Judul</label>
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Ketik judul artikel...">
                                </div>
                                <div class="col-md-2">
                                    <label>Kategori</label>
                                    <select class="form-select" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @foreach($listKategori as $kat)
                                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Penginput</label>
                                    <select class="form-select" name="user_id">
                                        <option value="">Semua Penginput</option>
                                        @foreach($listPenginput as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap ?? $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select class="form-select" name="status_publish">
                                        <option value="">Semua Status</option>
                                        <option value="Sudah Publish" {{ request('status_publish') == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                                        <option value="Belum Publish" {{ request('status_publish') == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Rentang Tanggal</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                                        <span class="mx-2 mt-2">-</span>
                                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <a href="{{ route('master-artikel.index') }}" class="btn btn-secondary me-2">Reset</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Terapkan Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Data Artikel</h4>
                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <i class="fa fa-plus"></i> Tambah Artikel
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Judul Artikel</th>
                                        <th>Naskah</th>
                                        <th>Penulis & Tanggal</th>
                                        <th>Status Publish</th>
                                        <th>Link Publikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikels as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kategori_artikel }}</td>
                                        <td>{{ $item->judul_artikel }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#naskahModal{{ $item->id }}">
                                                Lihat Naskah
                                            </button>

                                            <!-- Modal Naskah -->
                                            <div class="modal fade" id="naskahModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Naskah Artikel: {{ $item->judul_artikel }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="white-space: pre-wrap; font-size: 14px; text-align: left;">{{ $item->naskah_artikel }}</div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('master-artikel.download', $item->id) }}" class="btn btn-primary"><i class="fas fa-download"></i> Download .txt</a>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item->user->nama_lengkap ?? $item->user->name }}</div>
                                            <small class="text-muted"><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($item->status_publish == 'Sudah Publish')
                                                <span class="badge bg-success">Sudah Publish</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Belum Publish</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->link_publikasi)
                                                <a href="{{ $item->link_publikasi }}" target="_blank" class="btn btn-sm btn-outline-primary">Buka Link</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('master-artikel.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('master-artikel.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Artikel</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Kategori Artikel <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="kategori_artikel" value="{{ $item->kategori_artikel }}" required placeholder="Contoh: K3, Umum, dll">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Judul Artikel <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="judul_artikel" value="{{ $item->judul_artikel }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Naskah Artikel <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" name="naskah_artikel" rows="8" required>{{ $item->naskah_artikel }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Status Publish <span class="text-danger">*</span></label>
                                                            <select class="form-select" name="status_publish" required>
                                                                <option value="Belum Publish" {{ $item->status_publish == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                                                                <option value="Sudah Publish" {{ $item->status_publish == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Link Publikasi (Opsional)</label>
                                                            <input type="url" class="form-control" name="link_publikasi" value="{{ $item->link_publikasi }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $artikels->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('master-artikel.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kategori_artikel" value="{{ old('kategori_artikel') }}" required placeholder="Contoh: K3, Umum, dll">
                    </div>
                    <div class="mb-3">
                        <label>Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_artikel" value="{{ old('judul_artikel') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Naskah Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="naskah_artikel" rows="8" required>{{ old('naskah_artikel') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status Publish <span class="text-danger">*</span></label>
                        <select class="form-select" name="status_publish" required>
                            <option value="Belum Publish" {{ old('status_publish') == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                            <option value="Sudah Publish" {{ old('status_publish') == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Link Publikasi (Opsional)</label>
                        <input type="url" class="form-control" name="link_publikasi" value="{{ old('link_publikasi') }}" placeholder="https://...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        var ctx = document.getElementById('statisticsChart').getContext('2d');
        var statisticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: "Jumlah Artikel Baru",
                    backgroundColor: '#1d7af3',
                    borderColor: '#1d7af3',
                    data: {{ json_encode($chartValues) }},
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>

@endsection

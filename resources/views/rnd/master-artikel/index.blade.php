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
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Artikel</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalStat }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-header border-0 bg-transparent pb-0">
                        <div class="card-title fw-bold text-dark" style="font-size: 15px;">Statistik Artikel per Bulan (Tahun Ini)</div>
                    </div>
                    <div class="card-body pt-2">
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
                <div class="card card-modern mb-4 fade-in">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                            <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-filter" style="font-size: 13px;"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Data</h6>
                        </div>
                        <form method="GET" action="{{ route('master-artikel.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="label-modern">Cari Judul</label>
                                    <input type="text" class="form-control form-control-sm input-modern" name="search" value="{{ request('search') }}" placeholder="Ketik judul artikel...">
                                </div>
                                <div class="col-md-2">
                                    <label class="label-modern">Kategori</label>
                                    <select class="form-select form-select-sm input-modern" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @foreach($listKategori as $kat)
                                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="label-modern">Penginput</label>
                                    <select class="form-select form-select-sm input-modern" name="user_id">
                                        <option value="">Semua Penginput</option>
                                        @foreach($listPenginput as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap ?? $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="label-modern">Status</label>
                                    <select class="form-select form-select-sm input-modern" name="status_publish">
                                        <option value="">Semua Status</option>
                                        <option value="Sudah Publish" {{ request('status_publish') == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                                        <option value="Belum Publish" {{ request('status_publish') == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="label-modern">Rentang Tanggal</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control form-control-sm input-modern" name="start_date" value="{{ request('start_date') }}">
                                        <span class="mx-2 mt-2">-</span>
                                        <input type="date" class="form-control form-control-sm input-modern" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift shadow-sm">
                                        <i class="fas fa-search me-1"></i> Terapkan Filter
                                    </button>
                                    <a href="{{ route('master-artikel.index') }}" class="btn btn-white btn-sm btn-round fw-bold border px-4 hover-lift text-dark ms-2">
                                        <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 fade-in">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-list text-primary me-2"></i>Data Artikel</h5>
                    <button class="btn btn-primary btn-sm btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus me-1"></i> Tambah Artikel Baru
                    </button>
                </div>
                <div class="card card-modern fade-in border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light">
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
                                                <span class="badge badge-soft-success border border-success">Sudah Publish</span>
                                            @else
                                                <span class="badge badge-soft-warning border border-warning text-dark">Belum Publish</span>
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
                                                            <label class="label-modern">Kategori Artikel <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm input-modern" name="kategori_artikel" value="{{ $item->kategori_artikel }}" required placeholder="Contoh: K3, Umum, dll">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Judul Artikel <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm input-modern" name="judul_artikel" value="{{ $item->judul_artikel }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Naskah Artikel <span class="text-danger">*</span></label>
                                                            <textarea class="form-control form-control-sm input-modern" name="naskah_artikel" rows="8" required>{{ $item->naskah_artikel }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Status Publish <span class="text-danger">*</span></label>
                                                            <select class="form-select form-select-sm input-modern" name="status_publish" required>
                                                                <option value="Belum Publish" {{ $item->status_publish == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                                                                <option value="Sudah Publish" {{ $item->status_publish == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Link Publikasi (Opsional)</label>
                                                            <input type="url" class="form-control form-control-sm input-modern" name="link_publikasi" value="{{ $item->link_publikasi }}">
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
                        <label class="label-modern">Kategori Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm input-modern" name="kategori_artikel" value="{{ old('kategori_artikel') }}" required placeholder="Contoh: K3, Umum, dll">
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm input-modern" name="judul_artikel" value="{{ old('judul_artikel') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Naskah Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm input-modern" name="naskah_artikel" rows="8" required>{{ old('naskah_artikel') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Status Publish <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm input-modern" name="status_publish" required>
                            <option value="Belum Publish" {{ old('status_publish') == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                            <option value="Sudah Publish" {{ old('status_publish') == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Link Publikasi (Opsional)</label>
                        <input type="url" class="form-control form-control-sm input-modern" name="link_publikasi" value="{{ old('link_publikasi') }}" placeholder="https://...">
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

<style>
    /* CSS MODERNISASI UI */
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    .bg-primary-subtle { background-color: #e0eaff !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-warning-subtle { background-color: #fef08a !important; }
    
    .badge-soft-primary { background-color: #e0eaff; color: #3b82f6; }
    .badge-soft-success { background-color: #dcfce7; color: #16a34a; }
    .badge-soft-warning { background-color: #fef08a; color: #b45309; }
    .badge-soft-info { background-color: #cff4fc; color: #0891b2; }
    
    /* Table Modern */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0 !important; padding: 12px 16px; }
    .table-modern td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; }
    
    /* Form Modern */
    .label-modern { font-weight: 700; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 10px; color: #334155; }
    .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important; }
    
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

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

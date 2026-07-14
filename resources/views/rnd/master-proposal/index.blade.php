@extends('layouts.app')
@section('title', 'Master Proposal')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Master Proposal</h3>
                <h6 class="text-muted mb-2 fw-normal">Database Proposal Penawaran</h6>
            </div>
        </div>

        {{-- 3 STAT CARDS SEJAJAR --}}
        <div class="row mb-3 fade-in">
            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Proposal BNSP</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalBnsp }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Proposal KEMNAKER</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalKemnaker }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Proposal SOFTSKILL</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalSoftskill }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK --}}
        <div class="row mb-3 fade-in">
            <div class="col-md-8 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-header border-0 bg-transparent pb-0">
                        <div class="card-title fw-bold text-dark" style="font-size: 15px;">Statistik Input Proposal per Bulan (Tahun Ini)</div>
                    </div>
                    <div class="card-body pt-2">
                        @if(array_sum($chartValues) > 0)
                            <div class="chart-container" style="min-height: 250px">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100" style="min-height: 250px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-bar mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mb-0">Belum ada data statistik untuk tahun ini.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-header border-0 bg-transparent pb-0">
                        <div class="card-title fw-bold text-dark" style="font-size: 15px;">Komposisi Kategori</div>
                    </div>
                    <div class="card-body pt-2 d-flex justify-content-center align-items-center">
                        @if(count($kategoriValues) > 0)
                            <div class="chart-container" style="min-height: 250px; width: 100%;">
                                <canvas id="kategoriChart"></canvas>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100" style="min-height: 250px; width: 100%;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-pie mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mb-0">Belum ada data komposisi kategori.</p>
                                </div>
                            </div>
                        @endif
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

        {{-- FILTER SECTION --}}
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
                        <form method="GET" action="{{ route('master-proposal.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="label-modern">Cari Judul Proposal</label>
                                    <input type="text" class="form-control form-control-sm input-modern" name="search" value="{{ request('search') }}" placeholder="Ketik judul...">
                                </div>
                                <div class="col-md-3">
                                    <label class="label-modern">Lembaga</label>
                                    <select class="form-select form-select-sm input-modern" name="lembaga">
                                        <option value="">Semua Lembaga</option>
                                        @foreach($listLembaga as $lmbg)
                                            <option value="{{ $lmbg }}" {{ request('lembaga') == $lmbg ? 'selected' : '' }}>{{ $lmbg }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="label-modern">Kategori</label>
                                    <select class="form-select form-select-sm input-modern" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @foreach($listKategori as $kat)
                                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="label-modern">Rentang Tanggal Input</label>
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
                                    <a href="{{ route('master-proposal.index') }}" class="btn btn-white btn-sm btn-round fw-bold border px-4 hover-lift text-dark ms-2">
                                        <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 fade-in">
                    <button class="btn btn-primary btn-sm btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus me-1"></i> Tambah Proposal Baru
                    </button>
                </div>
                <div class="card card-modern fade-in border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Judul & Kategori</th>
                                        <th width="20%">Lembaga</th>
                                        <th width="15%">File Proposal</th>
                                        <th width="15%">Info Input</th>
                                        <th width="10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($proposals as $index => $item)
                                    <tr>
                                        <td><span class="text-muted fw-bold">{{ $proposals->firstItem() + $index }}</span></td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark text-wrap mb-1" style="max-width: 300px;">{{ $item->judul_proposal }}</span>
                                                <span class="badge badge-soft-info" style="width: fit-content;">{{ $item->kategori }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium text-secondary">{{ $item->lembaga }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ Storage::url($item->file_proposal_path) }}" class="btn btn-xs btn-outline-primary rounded-pill hover-lift shadow-sm" download>
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column text-muted" style="font-size: 12px;">
                                                <span><i class="far fa-user me-1"></i> {{ $item->user->nama_lengkap ?? $item->user->name }}</span>
                                                <span><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-sm btn-primary text-white rounded-pill hover-lift shadow-sm px-3" title="Edit">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('master-proposal.destroy', $item->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus proposal ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white rounded-pill hover-lift shadow-sm px-3" title="Hapus">
                                                        <i class="fa fa-trash-alt me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('master-proposal.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content border-0 shadow-lg">
                                                    <div class="modal-header border-bottom-0 bg-light pb-2 pt-4 px-4">
                                                        <h5 class="modal-title fw-bold text-dark">Edit Proposal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body px-4 pt-3 pb-4">
                                                        <div class="mb-3">
                                                            <label class="label-modern">Lembaga <span class="text-danger">*</span></label>
                                                            <select class="form-select form-select-sm input-modern" name="lembaga" required>
                                                                <option value="BNSP" {{ $item->lembaga == 'BNSP' ? 'selected' : '' }}>BNSP</option>
                                                                <option value="KEMNAKER" {{ $item->lembaga == 'KEMNAKER' ? 'selected' : '' }}>KEMNAKER</option>
                                                                <option value="SOFTSKILLS" {{ $item->lembaga == 'SOFTSKILLS' ? 'selected' : '' }}>SOFTSKILLS</option>
                                                                <option value="NON SERTIFIKASI" {{ $item->lembaga == 'NON SERTIFIKASI' ? 'selected' : '' }}>NON SERTIFIKASI</option>
                                                                <option value="PPSDM MIGAS" {{ $item->lembaga == 'PPSDM MIGAS' ? 'selected' : '' }}>PPSDM MIGAS</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Kategori <span class="text-danger">*</span></label>
                                                            <select class="form-select select2-kategori input-modern" name="kategori" required style="width: 100%;">
                                                                <option value="{{ $item->kategori }}" selected="selected">{{ $item->kategori }}</option>
                                                                <option value="FOOD SAFETY">FOOD SAFETY</option>
                                                                <option value="KELEMBAGAAN">KELEMBAGAAN</option>
                                                                <option value="LSP LAS">LSP LAS</option>
                                                            </select>
                                                            <small class="text-muted" style="font-size: 11px;">Pilih atau ketik kategori baru jika tidak ada.</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">Judul Proposal <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm input-modern" name="judul_proposal" value="{{ $item->judul_proposal }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="label-modern">File Word Proposal <small>(Opsional jika tak diubah)</small></label>
                                                            <input type="file" class="form-control form-control-sm input-modern" name="file_proposal" accept=".doc,.docx,.pdf">
                                                            <small class="text-muted" style="font-size: 11px;">Maks. 10MB. Format: .doc, .docx, .pdf</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0 bg-light px-4 py-3">
                                                        <button type="button" class="btn btn-white btn-sm btn-round fw-bold border hover-lift" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold hover-lift shadow-sm">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="far fa-folder-open text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                                <h5 class="text-muted fw-bold">Belum ada data proposal</h5>
                                                <p class="text-muted mb-0" style="font-size: 13px;">Silakan tambahkan proposal baru atau ubah filter pencarian Anda.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- PAGINATION --}}
                        <div class="mt-4 px-3 pb-3">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('master-proposal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0 bg-light pb-2 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">Tambah Proposal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pt-3 pb-4">
                    <div class="mb-3">
                        <label class="label-modern">Lembaga <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm input-modern" name="lembaga" required>
                            <option value="">-- Pilih Lembaga --</option>
                            <option value="BNSP">BNSP</option>
                            <option value="KEMNAKER">KEMNAKER</option>
                            <option value="SOFTSKILLS">SOFTSKILLS</option>
                            <option value="NON SERTIFIKASI">NON SERTIFIKASI</option>
                            <option value="PPSDM MIGAS">PPSDM MIGAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select select2-kategori input-modern" name="kategori" required style="width: 100%;">
                            <option value=""></option>
                            <option value="FOOD SAFETY">FOOD SAFETY</option>
                            <option value="KELEMBAGAAN">KELEMBAGAAN</option>
                            <option value="LSP LAS">LSP LAS</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Pilih atau ketik kategori baru jika tidak ada.</small>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">Judul Proposal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm input-modern" name="judul_proposal" required>
                    </div>
                    <div class="mb-3">
                        <label class="label-modern">File Word Proposal <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-sm input-modern" name="file_proposal" required accept=".doc,.docx,.pdf">
                        <small class="text-muted" style="font-size: 11px;">Maks. 10MB. Format: .doc, .docx, .pdf</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-white btn-sm btn-round fw-bold border hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold hover-lift shadow-sm">Upload Proposal</button>
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

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        // Init Select2
        $('.select2-kategori').select2({
            tags: true,
            placeholder: "-- Pilih atau Ketik Kategori --",
            dropdownParent: function(args) {
                var modal = $(args).closest('.modal');
                return modal.length ? modal : $(document.body);
            }
        });
        
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2-kategori').select2({
                tags: true,
                dropdownParent: $(this)
            });
        });

        // Initialize Bar Chart
        @if(array_sum($chartValues) > 0)
        var ctxBar = document.getElementById('statisticsChart').getContext('2d');
        var gradientBar = ctxBar.createLinearGradient(0, 0, 0, 400);
        gradientBar.addColorStop(0, 'rgba(29, 122, 243, 0.8)');
        gradientBar.addColorStop(1, 'rgba(29, 122, 243, 0.2)');
        
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: "Proposal Baru",
                    backgroundColor: gradientBar,
                    borderColor: '#1d7af3',
                    borderWidth: 1,
                    borderRadius: 4,
                    data: {{ json_encode($chartValues) }},
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
        @endif

        // Initialize Doughnut Chart (Kategori)
        @if(count($kategoriValues) > 0)
        var ctxPie = document.getElementById('kategoriChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($kategoriLabels) !!},
                datasets: [{
                    data: {{ json_encode($kategoriValues) }},
                    backgroundColor: ['#1d7af3', '#f3545d', '#fdaf4b', '#59d05d', '#177dff', '#ff9e27'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Nunito', sans-serif",
                                size: 11
                            }
                        }
                    }
                }
            }
        });
        @endif
    });
</script>
@endpush

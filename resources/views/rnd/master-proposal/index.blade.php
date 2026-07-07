@extends('layouts.app')
@section('title', 'Master Proposal')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h4 class="page-title">Master Proposal Penawaran</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard.progress') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Performance</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Master Proposal</a>
            </li>
        </ul>
    </div>

    
    {-- BARIS 1: STATISTIK & CHART --}
    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-file-contract"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Proposal</p>
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
                    <div class="card-title">Statistik Proposal per Bulan (Tahun Ini)</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 250px">
                        <canvas id="statisticsChart"></canvas>
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Proposal</h4>
                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus"></i> Tambah Proposal
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lembaga</th>
                                    <th>Kategori</th>
                                    <th>Judul Proposal</th>
                                    <th>File Proposal</th>
                                    <th>Penginput</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proposals as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->lembaga }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>{{ $item->judul_proposal }}</td>
                                    <td>
                                        <a href="{{ Storage::url($item->file_proposal_path) }}" class="btn btn-sm btn-info" download>
                                            <i class="fa fa-download"></i> Unduh File
                                        </a>
                                    </td>
                                    <td>{{ $item->user->nama_lengkap ?? $item->user->name }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('master-proposal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus proposal ini?');">
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
                                    <div class="modal-dialog">
                                        <form action="{{ route('master-proposal.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Proposal</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Lembaga <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="lembaga" required>
                                                            <option value="BNSP" {{ $item->lembaga == 'BNSP' ? 'selected' : '' }}>BNSP</option>
                                                            <option value="KEMNAKER" {{ $item->lembaga == 'KEMNAKER' ? 'selected' : '' }}>KEMNAKER</option>
                                                            <option value="SOFTSKILLS" {{ $item->lembaga == 'SOFTSKILLS' ? 'selected' : '' }}>SOFTSKILLS</option>
                                                            <option value="NON SERTIFIKASI" {{ $item->lembaga == 'NON SERTIFIKASI' ? 'selected' : '' }}>NON SERTIFIKASI</option>
                                                            <option value="PPSDM MIGAS" {{ $item->lembaga == 'PPSDM MIGAS' ? 'selected' : '' }}>PPSDM MIGAS</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kategori <span class="text-danger">*</span></label>
                                                        <select class="form-select select2-kategori" name="kategori" required style="width: 100%;">
                                                            <option value="{{ $item->kategori }}" selected="selected">{{ $item->kategori }}</option>
                                                            <option value="FOOD SAFETY">FOOD SAFETY</option>
                                                            <option value="KELEMBAGAAN">KELEMBAGAAN</option>
                                                            <option value="LSP LAS">LSP LAS</option>
                                                        </select>
                                                        <small class="text-muted">Pilih atau ketik kategori baru jika tidak ada.</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Judul Proposal <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="judul_proposal" value="{{ $item->judul_proposal }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>File Word Proposal <small>(Biarkan kosong jika tidak ingin mengubah file)</small></label>
                                                        <input type="file" class="form-control" name="file_proposal" accept=".doc,.docx,.pdf">
                                                        <small class="text-muted">Maksimal ukuran 10MB. Format: .doc, .docx, .pdf</small>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('master-proposal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Proposal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Lembaga <span class="text-danger">*</span></label>
                        <select class="form-select" name="lembaga" required>
                            <option value="">-- Pilih Lembaga --</option>
                            <option value="BNSP">BNSP</option>
                            <option value="KEMNAKER">KEMNAKER</option>
                            <option value="SOFTSKILLS">SOFTSKILLS</option>
                            <option value="NON SERTIFIKASI">NON SERTIFIKASI</option>
                            <option value="PPSDM MIGAS">PPSDM MIGAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select class="form-select select2-kategori" name="kategori" required style="width: 100%;">
                            <option value=""></option>
                            <option value="FOOD SAFETY">FOOD SAFETY</option>
                            <option value="KELEMBAGAAN">KELEMBAGAAN</option>
                            <option value="LSP LAS">LSP LAS</option>
                        </select>
                        <small class="text-muted">Pilih atau ketik kategori baru jika tidak ada.</small>
                    </div>
                    <div class="mb-3">
                        <label>Judul Proposal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_proposal" required>
                    </div>
                    <div class="mb-3">
                        <label>File Word Proposal <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file_proposal" required accept=".doc,.docx,.pdf">
                        <small class="text-muted">Maksimal ukuran 10MB. Format: .doc, .docx, .pdf</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Proposal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable();

        $('.select2-kategori').select2({
            tags: true,
            placeholder: "-- Pilih atau Ketik Kategori --",
            dropdownParent: function(args) {
                // Adjust dropdown parent to modal when it is open to avoid z-index issue
                var modal = $(args).closest('.modal');
                return modal.length ? modal : $(document.body);
            }
        });
        
        // Handle init for edit modals dynamically when shown
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2-kategori').select2({
                tags: true,
                dropdownParent: $(this)
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        var ctx = document.getElementById('statisticsChart').getContext('2d');
        var statisticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: "Jumlah Proposal Baru",
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

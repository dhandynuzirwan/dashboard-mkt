@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Manajemen Absensi</h3>
                <h6 class="op-7 mb-2">Log Kehadiran & Sinkronisasi Mesin Fingerspot</h6>
                <div class="badge badge-info shadow-sm">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>

            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2">
                <form action="{{ route('absensi.sync') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-round btn-sm">
                        <i class="fas fa-sync"></i> Sync Fingerspot.io
                    </button>
                </form>
                
                <button class="btn btn-info btn-round btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalImportIzin">
                    <i class="fas fa-file-medical"></i> Import Izin (CSV)
                </button>

                <button class="btn btn-primary btn-round btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="fas fa-file-import"></i> Import Absensi (CSV)
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Hadir Hari Ini</p>
                                    <h4 class="card-title">{{ $absensi->where('tanggal', date('Y-m-d'))->count() }}</h4>
                                    <p class="text-muted small mb-0">Karyawan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(session('debug_logs'))
                    <div class="alert alert-info border-left-info shadow-sm">
                        <h6 class="fw-bold"><i class="fas fa-search"></i> Hasil Analisa Import:</h6>
                        <ul class="mb-0 small" style="max-height: 150px; overflow-y: auto;">
                            @foreach(session('debug_logs') as $log)
                                <li>{{ $log }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('audit_ids'))
                    <div class="alert alert-info shadow-sm border-left-primary">
                        <h6 class="fw-bold"><i class="fas fa-fingerprint"></i> Hasil Audit ID File:</h6>
                        <ul class="mb-0 small" style="max-height: 150px; overflow-y: auto;">
                            @foreach(session('audit_ids') as $log)
                                <li class="mb-1">{{ $log }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round shadow-sm">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Absensi & Perizinan</h4>
                            <ul class="nav nav-pills nav-secondary ms-auto" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active btn-sm" id="pills-log-tab" data-bs-toggle="pill" href="#pills-log" role="tab">Log Absensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-sm" id="pills-izin-tab" data-bs-toggle="pill" href="#pills-izin" role="tab">Data Perizinan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn-sm" id="pills-mapping-tab" data-bs-toggle="pill" href="#pills-mapping" role="tab">Mapping User ID</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="pills-log" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jam</th>
                                                <th class="text-center">Tipe</th>
                                                <th>Sumber Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($absensi as $log)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}</td>
                                                <td class="fw-bold">{{ $log->user->name }}</td>
                                                <td>{{ $log->jam }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $log->tipe == 'in' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ strtoupper($log->tipe) }}
                                                    </span>
                                                </td>
                                                <td><small class="text-muted"><i class="fas fa-server me-1"></i> {{ strtoupper($log->source) }}</small></td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="5" class="text-center py-4">Belum ada data absensi.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $absensi->links('partials.pagination') }}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-izin" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-info text-white">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jenis Izin</th>
                                                <th>Keterangan</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($perizinans as $izin)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($izin->tanggal)->format('d/m/Y') }}</td>
                                                <td class="fw-bold">{{ $izin->user->name }}</td>
                                                <td>{{ $izin->jenis }}</td>
                                                <td><small>{{ $izin->keterangan ?? '-' }}</small></td>
                                                <td class="text-center">
                                                    @if($izin->status == 'approved')
                                                        <span class="badge badge-success">Diterima</span>
                                                    @elseif($izin->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="5" class="text-center py-4">Belum ada data perizinan.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-mapping" role="tabpanel">
                                <form action="{{ route('absensi.store_mapping') }}" method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mt-2">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>Nama Karyawan</th>
                                                    <th width="350">ID Fingerspot (PIN)</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        <input type="text" name="fingerspot_id[{{ $user->id }}]" 
                                                               value="{{ $user->fingerspot_id }}" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Contoh: ADM.001">
                                                    </td>
                                                    <td class="text-center">
                                                        @if($user->fingerspot_id)
                                                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                                        @else
                                                            <span class="text-warning"><i class="fas fa-exclamation-circle"></i></span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary btn-round">
                                            <i class="fas fa-save me-1"></i> Simpan Mapping
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('absensi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Import Data Flashdisk (Absensi)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group p-0">
                        <label class="mb-2">Pilih File Laporan Detail (CSV)</label>
                        <input type="file" name="file_absensi" class="form-control" required>
                        <small class="form-text text-muted">Gunakan file <b>Laporan Detail Kehadiran</b> dari mesin.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round">Mulai Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalImportIzin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('absensi.import_izin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content card-round">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-info">Import Laporan Izin (CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group p-0">
                        <label class="mb-2">Pilih File Laporan Izin (CSV)</label>
                        <input type="file" name="file_izin" class="form-control" required>
                        <small class="form-text text-muted">Gunakan file <b>Laporan Izin Karyawan</b> dari Fingerspot.io</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info btn-round text-white">Mulai Import Izin</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .card-animate { transition: transform 0.3s ease; }
    .card-animate:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .nav-pills.nav-secondary .nav-link.active { background: #6861ce !important; }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Manajemen Absensi</h3>
                        <h6 class="op-7 mb-2">Log Kehadiran & Sinkronisasi Mesin Fingerspot</h6>
                        <div class="badge badge-info">
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
                        
                        <button class="btn btn-primary btn-round btn-sm" data-toggle="modal" data-target="#modalImport">
                            <i class="fas fa-file-import"></i> Import Flashdisk
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
                                            <h4 class="card-title">12</h4>
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
                        <div class="card card-round">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Absensi Mesin</h4>
                                    <ul class="nav nav-pills nav-secondary ml-auto" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active btn-sm" id="pills-log-tab" data-toggle="pill" href="#pills-log" role="tab">Log Absensi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link btn-sm" id="pills-mapping-tab" data-toggle="pill" href="#pills-mapping" role="tab">Mapping User ID</a>
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
                                                        <th>Tipe</th>
                                                        <th>Sumber Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($absensi as $log)
                                                    <tr>
                                                        <td>{{ $log->tanggal }}</td>
                                                        <td class="fw-bold">{{ $log->user->name }}</td>
                                                        <td>{{ $log->jam }}</td>
                                                        <td>
                                                            <span class="badge {{ $log->tipe == 'in' ? 'badge-success' : 'badge-danger' }}">
                                                                {{ strtoupper($log->tipe) }}
                                                            </span>
                                                        </td>
                                                        <td><small class="text-muted">{{ strtoupper($log->source) }}</small></td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">Belum ada data absensi hari ini.</td>
                                                    </tr>
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
                                                            <th width="300">ID Fingerspot (PIN)</th>
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
                                                                       placeholder="Masukkan PIN Mesin...">
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-right mt-3">
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
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('absensi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Import Data Flashdisk</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group p-0">
                        <label>Pilih File (CSV/Excel)</label>
                        <input type="file" name="file_absensi" class="form-control" required>
                        <small class="form-text text-muted">Pastikan format kolom sesuai dengan template mesin.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border btn-round" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round">Mulai Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Mengadopsi style Pipeline Marketing */
    .card-animate {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
    }
    .card-animate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-category {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .nav-pills.nav-secondary .nav-link.active {
        background: #6861ce !important;
        box-shadow: 0 4px 10px rgba(104, 97, 206, 0.3);
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        const clockElement = document.getElementById('realtime-clock');
        if(clockElement) {
            clockElement.innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Pengajuan Izin & Cuti</h4>
                <p class="text-muted small">Kelola dan pantau status permohonan ketidakhadiran Anda.</p>
            </div>
            <div>
                <a href="{{ route('pengajuan-izin.create') }}" class="btn btn-primary fw-bold btn-round shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Buat Pengajuan Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-3 fs-6 fw-bold" id="pengajuanTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-primary" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                            Sedang Diproses
                            @if($pendingIzins->count() > 0)
                                <span class="badge bg-warning text-dark ms-2 rounded-circle">{{ $pendingIzins->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-muted" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">
                            Riwayat Selesai
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="pengajuanTabsContent">
                    
                    <!-- TAB PENDING -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">ID Pengajuan</th>
                                        <th>Tanggal Izin</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Lampiran</th>
                                        <th class="text-center">Status</th>
                                        <th>Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingIzins as $izin)
                                        <tr>
                                            <td class="px-4"><span class="badge bg-light text-dark border">{{ $izin->external_id }}</span></td>
                                            <td class="fw-bold text-primary">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $izin->jenis }}</td>
                                            <td>{{ $izin->keterangan ?? '-' }}</td>
                                            <td>
                                                @if($izin->file_path)
                                                    <a href="{{ asset('storage/' . $izin->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-file-download"></i> Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-clock"></i> Menunggu</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fs-1 text-light mb-3 d-block"></i>
                                                Anda tidak memiliki pengajuan izin yang sedang diproses.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB RIWAYAT -->
                    <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">ID Pengajuan</th>
                                        <th>Tanggal Izin</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Lampiran</th>
                                        <th class="text-center">Status</th>
                                        <th>Diajukan Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayatIzins as $izin)
                                        <tr>
                                            <td class="px-4"><span class="badge bg-light text-dark border">{{ $izin->external_id }}</span></td>
                                            <td class="fw-bold text-primary">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $izin->jenis }}</td>
                                            <td>{{ $izin->keterangan ?? '-' }}</td>
                                            <td>
                                                @if($izin->file_path)
                                                    <a href="{{ asset('storage/' . $izin->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-file-download"></i> Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Tidak ada</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($izin->status == 'approved')
                                                    <span class="badge bg-success px-3 py-2"><i class="fas fa-check"></i> Disetujui</span>
                                                @elseif($izin->status == 'rejected')
                                                    <span class="badge bg-danger px-3 py-2"><i class="fas fa-times"></i> Ditolak</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fs-1 text-light mb-3 d-block"></i>
                                                Belum ada riwayat pengajuan izin yang disetujui / ditolak.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($riwayatIzins->hasPages())
                            <div class="card-footer bg-white border-0 py-3">
                                {{ $riwayatIzins->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

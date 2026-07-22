@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Riwayat Pengajuan Lembur</h4>
                <p class="text-muted small">Kelola dan pantau status permohonan lembur Anda.</p>
            </div>
            <div>
                <a href="{{ route('pengajuan-lembur.create') }}" class="btn btn-primary fw-bold btn-round shadow-sm">
                    <i class="fas fa-plus-circle me-1"></i> Buat Pengajuan Lembur
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
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Tanggal Lembur</th>
                                <th>Jam</th>
                                <th>Tugas</th>
                                <th class="text-center">Status SPV/TLO</th>
                                <th class="text-center">Status HRD</th>
                                <th class="text-center">Status Direktur</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuans as $lembur)
                                <tr>
                                    <td class="px-4 fw-bold text-primary">
                                        {{ \Carbon\Carbon::parse($lembur->tanggal_mulai)->format('d M Y') }}
                                        @if($lembur->tanggal_selesai && $lembur->tanggal_selesai != $lembur->tanggal_mulai)
                                            <br><small class="text-muted">s/d {{ \Carbon\Carbon::parse($lembur->tanggal_selesai)->format('d M Y') }}</small>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($lembur->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($lembur->jam_selesai)->format('H:i') }}</td>
                                    <td>{{ Str::limit($lembur->tugas, 30) }}</td>
                                    
                                    <td class="text-center">
                                        @if($lembur->status_spv == 'approved')
                                            <span class="badge bg-success px-2 py-1"><i class="fas fa-check"></i> Disetujui</span>
                                        @elseif($lembur->status_spv == 'rejected')
                                            <span class="badge bg-danger px-2 py-1"><i class="fas fa-times"></i> Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($lembur->status_hrd == 'approved')
                                            <span class="badge bg-success px-2 py-1"><i class="fas fa-check"></i> Disetujui</span>
                                        @elseif($lembur->status_hrd == 'rejected')
                                            <span class="badge bg-danger px-2 py-1"><i class="fas fa-times"></i> Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($lembur->status_direktur == 'approved')
                                            <span class="badge bg-success px-2 py-1"><i class="fas fa-check"></i> Disetujui</span>
                                        @elseif($lembur->status_direktur == 'rejected')
                                            <span class="badge bg-danger px-2 py-1"><i class="fas fa-times"></i> Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock"></i> Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lembur->status_akhir == 'approved')
                                            <a href="{{ route('pengajuan-lembur.pdf', $lembur->id) }}" target="_blank" class="btn btn-sm btn-info shadow-sm">
                                                <i class="fas fa-file-pdf"></i> Unduh Surat
                                            </a>
                                        @else
                                            <span class="text-muted small">Menunggu Persetujuan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-moon fs-1 text-light mb-3 d-block"></i>
                                        Anda belum memiliki riwayat pengajuan lembur.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Approval Izin & Cuti</h4>
                <p class="text-muted small">Tinjau dan proses permohonan ketidakhadiran dari Karyawan.</p>
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
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-3 fs-6 fw-bold" id="approvalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-primary" id="antrean-tab" data-bs-toggle="tab" data-bs-target="#antrean" type="button" role="tab" aria-controls="antrean" aria-selected="true">
                            Antrean Approval
                            @if($izins->count() > 0)
                                <span class="badge bg-danger ms-2 rounded-circle">{{ $izins->count() }}</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-muted" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">
                            Riwayat Approval
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content" id="approvalTabsContent">
                    
                    <!-- TAB ANTREAN PENDING -->
                    <div class="tab-pane fade show active" id="antrean" role="tabpanel" aria-labelledby="antrean-tab">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama Pegawai</th>
                                <th>Tanggal Izin</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Diajukan Pada</th>
                                <th class="text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($izins as $izin)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        {{ $izin->user->name ?? 'User Dihapus' }}
                                    </td>
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
                                    <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y H:i') }}</td>
                                    <td class="text-end px-4">
                                        <button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#accModal{{ $izin->id }}">
                                            <i class="fas fa-check"></i> ACC
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm ms-1" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $izin->id }}">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal ACC -->
                                <div class="modal fade" id="accModal{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                      <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-success"><i class="fas fa-check-circle me-2"></i> Konfirmasi Persetujuan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-start pt-3">
                                        Apakah Anda yakin ingin <strong class="text-success">menyetujui</strong> pengajuan {{ $izin->jenis }} dari <strong>{{ $izin->user->name ?? 'Pegawai' }}</strong> pada tanggal {{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}?
                                      </div>
                                      <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('approval-izin.approve', $izin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success fw-bold rounded-3 px-4">Ya, Setujui</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Tolak -->
                                <div class="modal fade" id="tolakModal{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                      <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-danger"><i class="fas fa-times-circle me-2"></i> Konfirmasi Penolakan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-start pt-3">
                                        Apakah Anda yakin ingin <strong class="text-danger">menolak</strong> pengajuan {{ $izin->jenis }} dari <strong>{{ $izin->user->name ?? 'Pegawai' }}</strong> pada tanggal {{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}?
                                      </div>
                                      <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('approval-izin.reject', $izin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger fw-bold rounded-3 px-4">Ya, Tolak</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-check fs-1 text-light mb-3 d-block"></i>
                                        Yey! Tidak ada pengajuan izin yang perlu di-review.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> <!-- End Tab Antrean -->

            <!-- TAB RIWAYAT APPROVAL -->
            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama Pegawai</th>
                                <th>Tanggal Izin</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Status</th>
                                <th>Diproses Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatIzins as $riwayat)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">
                                        {{ $riwayat->user->name ?? 'User Dihapus' }}
                                    </td>
                                    <td class="fw-bold text-primary">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $riwayat->jenis }}</td>
                                    <td>{{ $riwayat->keterangan ?? '-' }}</td>
                                    <td>
                                        @if($riwayat->file_path)
                                            <a href="{{ asset('storage/' . $riwayat->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-file-download"></i> Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($riwayat->status == 'approved')
                                            <span class="badge bg-success px-3 py-2"><i class="fas fa-check"></i> Disetujui</span>
                                        @elseif($riwayat->status == 'rejected')
                                            <span class="badge bg-danger px-3 py-2"><i class="fas fa-times"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->updated_at)->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fs-1 text-light mb-3 d-block"></i>
                                        Belum ada riwayat approval.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $riwayatIzins->links('pagination::bootstrap-5') }}
                </div>
            </div> <!-- End Tab Riwayat -->

        </div> <!-- End Tab Content -->
    </div> <!-- End Card Body -->
</div> <!-- End Card -->

    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat & Approval Download</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>User</th>
                            <th>Alasan</th>
                            <th>Tanggal Request</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                        <tr>
                            <td><span class="fw-bold">{{ $r->user->name }}</span></td>
                            <td>{{ $r->reason }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y, H:i') }}</td>
                            <td>
                                {{-- Menampilkan Badge Status --}}
                                @if($r->status == 'pending')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending</span>
                                @elseif($r->status == 'approved')
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Approved</span>
                                @elseif($r->status == 'rejected')
                                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol Aksi hanya muncul jika status masih pending --}}
                                @if($r->status == 'pending')
                                    <form action="{{ route('download.approve', $r->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm btn-round" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('download.reject', $r->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-round" title="Tolak" onclick="return confirm('Yakin ingin menolak request ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- Indikator visual bahwa aksi sudah dikunci --}}
                                    <button class="btn btn-light btn-sm btn-round text-muted" disabled>
                                        <i class="fas fa-lock"></i> Selesai
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tidak ada data request download.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Tambahkan pagination jika data sudah banyak --}}
            {{-- <div class="mt-3 d-flex justify-content-center">
                {{ $requests->links() }}
            </div> --}}
        </div>
    </div>
</div>
@endsection
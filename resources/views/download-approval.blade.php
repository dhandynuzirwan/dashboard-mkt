@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat & Approval Download</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal Request</th>
                            <th>Nama Pegawai</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 🔥 LOOPING DIMULAI DI SINI 🔥 --}}
                        @forelse($requests as $req)
                            <tr>
                                <td>{{ $req->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $req->user->name }}</td>
                                <td>{{ $req->reason }}</td>
                                <td>
                                    {{-- Tampilan Status (Opsional, sesuaikan dengan desainmu) --}}
                                    @if($req->status == 'pending') <span class="badge bg-warning text-dark">Pending</span> @endif
                                    @if($req->status == 'approved') <span class="badge bg-success">Approved</span> @endif
                                    @if($req->status == 'rejected') <span class="badge bg-danger">Rejected</span> @endif
                                </td>
            
                                {{-- 🔥 KOLOM AKSI YANG TADI SAYA BERIKAN 🔥 --}}
                                <td class="text-center">
                                    @if($req->status == 'pending' && in_array(auth()->user()->role, ['superadmin', 'admin']))
                                        <form action="{{ route('download.approve', $req->id) }}" method="POST" class="d-inline">
                                            @csrf <button class="btn btn-success btn-sm btn-round shadow-sm"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('download.reject', $req->id) }}" method="POST" class="d-inline">
                                            @csrf <button class="btn btn-danger btn-sm btn-round shadow-sm"><i class="fas fa-times"></i></button>
                                        </form>
                                    @endif
            
                                    @if($req->status == 'approved')
                                        <a href="{{ route('download.file', $req->id) }}" class="btn btn-primary btn-sm btn-round shadow-sm fw-bold">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    @endif
                                    
                                    @if($req->status == 'pending' && !in_array(auth()->user()->role, ['superadmin', 'admin']))
                                        <span class="text-muted small fst-italic"><i class="fas fa-hourglass-half me-1"></i> Menunggu...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada data request download.</td>
                            </tr>
                        @endforelse
                        {{-- 🔥 LOOPING SELESAI 🔥 --}}
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination jika diperlukan --}}
            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
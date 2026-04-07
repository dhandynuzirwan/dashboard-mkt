@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Hasil Pencarian</h3>
                <h6 class="op-7 mb-2">Menampilkan hasil untuk: <span class="fw-bold text-primary">"{{ request('q') }}"</span> ({{ $totalResults ?? 0 }} ditemukan)</h6>
            </div>
        </div>

        @if(($totalResults ?? 0) == 0)
            <div class="text-center mt-5">
                <i class="fas fa-search-minus fa-4x text-muted mb-3"></i>
                <h4>Yah, data tidak ditemukan.</h4>
                <p class="text-muted">Coba gunakan kata kunci lain, seperti nama perusahaan, judul pelatihan, atau nama PIC.</p>
            </div>
        @else

            {{-- 1. HASIL PENCARIAN PROSPEK --}}
            @if($prospeks->total() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title text-white mb-0"><i class="fas fa-users me-2"></i> Data Prospek ({{ $prospeks->total() }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>PIC / Kontak</th>
                                    <th>Marketing</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prospeks as $p)
                                <tr>
                                    <td class="fw-bold">{{ $p->perusahaan }}</td>
                                    <td>{{ $p->nama_pic }} <br> <small class="text-muted">{{ $p->telp }}</small></td>
                                    <td>{{ $p->marketing->name ?? '-' }}</td>
                                    <td><span class="badge badge-secondary">{{ $p->status }}</span></td>
                                    <td>
                                        <a href="{{ route('prospek.edit', $p->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- TOMBOL PAGINATION PROSPEK --}}
                    <div class="mt-3">
                        {{ $prospeks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            @endif

            {{-- 2. HASIL PENCARIAN PENAWARAN (CTA) --}}
            @if($ctas->total() > 0)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title text-white mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> Data Penawaran / CTA ({{ $ctas->total() }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Judul Permintaan</th>
                                    <th>Nilai Penawaran</th>
                                    <th>Status Deal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ctas as $c)
                                <tr>
                                    <td class="fw-bold">{{ $c->prospek->perusahaan ?? '-' }}</td>
                                    <td>{{ $c->judul_permintaan }} <br> <small class="text-muted">{{ $c->sertifikasi }} - {{ $c->skema }}</small></td>
                                    <td class="text-success fw-bold">Rp {{ number_format($c->total_penawaran, 0, ',', '.') }}</td>
                                    <td>
                                        @if($c->status_penawaran == 'deal')
                                            <span class="badge badge-success">Deal</span>
                                        @elseif($c->status_penawaran == 'cancel')
                                            <span class="badge badge-danger">Cancel</span>
                                        @else
                                            <span class="badge badge-info">{{ str_replace('_', ' ', ucwords($c->status_penawaran)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('cta.edit', $c->id) }}" class="btn btn-sm btn-success">Lihat Penawaran</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- TOMBOL PAGINATION CTA --}}
                    <div class="mt-3">
                        {{ $ctas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            @endif

            {{-- 3. HASIL PENCARIAN MARKETING --}}
            @if($marketings->total() > 0)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="card-title text-white mb-0"><i class="fas fa-user-tie me-2"></i> Data Tim Marketing ({{ $marketings->total() }})</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($marketings as $m)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $m->name }}</h6>
                                <small class="text-muted">{{ $m->email }}</small>
                            </div>
                            <a href="{{ route('prospek.index', ['marketing_id' => $m->id]) }}" class="btn btn-sm btn-outline-info">Lihat Pipeline</a>
                        </li>
                        @endforeach
                    </ul>
                    {{-- TOMBOL PAGINATION MARKETING --}}
                    <div class="mt-3">
                        {{ $marketings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            @endif

        @endif
    </div>
</div>
@endsection
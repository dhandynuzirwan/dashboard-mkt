@extends('layouts.app')
@section('content')

<div class="wrapper">

    <div class="main-panel">

        <div class="container">
            <div class="page-inner">
                <h3 class="fw-bold mb-3">Hasil Pencarian: "{{ $query }}"</h3>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Prospek ({{ $prospeks->count() }})</div>
                            <div class="card-body">
                                @forelse($prospeks as $p)
                                    <p class="mb-1"><strong>{{ $p->nama_perusahaan }}</strong><br>
                                    <small>PIC: {{ $p->pic_nama }}</small></p>
                                    <hr>
                                @empty
                                    <p class="text-muted">Tidak ditemukan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">Penawaran/CTA ({{ $ctas->count() }})</div>
                            <div class="card-body">
                                @forelse($ctas as $c)
                                    <p class="mb-1"><strong>{{ $c->judul_permintaan }}</strong><br>
                                    <small>Perusahaan: {{ $c->prospek->nama_perusahaan ?? '-' }}</small></p>
                                    <hr>
                                @empty
                                    <p class="text-muted">Tidak ditemukan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">Marketing ({{ $marketings->count() }})</div>
                            <div class="card-body">
                                @forelse($marketings as $m)
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm me-2">
                                            <img src="https://cdn-icons-png.flaticon.com/512/14379/14379379.png" class="avatar-img rounded-circle">
                                        </div>
                                        <span>{{ $m->name }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted">Tidak ditemukan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
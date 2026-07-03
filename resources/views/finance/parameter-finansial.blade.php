@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Parameter Finansial</h3>
                <h6 class="op-7 mb-2">Konfigurasi Target Minimal (HPP) Perusahaan</h6>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="card-title fw-bold m-0"><i class="fas fa-sliders-h text-primary me-2"></i> Atur Target Minimal HPP</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('parameter-finansial.index') }}" method="GET" class="mb-4">
                            <label class="form-label fw-bold">Pilih Bulan & Tahun</label>
                            <div class="input-group">
                                <input type="month" name="bulan_tahun" class="form-control" value="{{ $bulan_tahun }}" onchange="this.form.submit()">
                            </div>
                        </form>

                        <hr>

                        <form action="{{ route('parameter-finansial.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="bulan_tahun" value="{{ $bulan_tahun }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Target Minimal HPP (Bulan: {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan_tahun)->translatedFormat('F Y') }})</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="target_minimal" class="form-control form-control-lg fw-bold text-primary" value="{{ $target_minimal }}" required min="0">
                                </div>
                                <small class="text-muted mt-2 d-block">Angka ini akan ditampilkan sebagai patokan target minimal perusahaan pada layar On Display Monitor.</small>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-round shadow-sm fw-bold px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Parameter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card bg-primary-gradient text-white shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-info-circle fa-3x mb-3 opacity-75"></i>
                        <h4 class="fw-bold mb-2">Informasi Penting</h4>
                        <p class="mb-0">
                            Target Minimal (HPP) adalah nilai Harga Pokok Penjualan yang harus dicapai perusahaan setiap bulannya agar operasional tetap berjalan dengan sehat. 
                            Nilai yang diinput di sini akan disinkronkan secara langsung (real-time) ke layar Live Tracking Monitor tim Marketing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

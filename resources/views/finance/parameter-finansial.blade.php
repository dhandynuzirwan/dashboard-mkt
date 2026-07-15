@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Nilai Target Omset</h3>
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
                    <div class="card-header bg-primary rounded-top">
                        <div class="card-title text-white fw-bold"><i class="fas fa-cog me-2"></i> Pengaturan Nilai Target Omset</div>
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
                                    <input type="text" id="target_minimal_display" class="form-control form-control-lg fw-bold text-primary format-rupiah" value="{{ number_format($target_minimal, 0, ',', '.') }}" required {{ auth()->user()->role !== 'superadmin' ? 'readonly' : '' }}>
                                    <input type="hidden" name="target_minimal" id="target_minimal_real" value="{{ $target_minimal }}">
                                </div>
                                <small class="text-muted mt-2 d-block">Angka ini akan ditampilkan sebagai patokan target minimal perusahaan pada layar On Display Monitor.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">HPP / Bulan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="text" id="hpp_per_bulan_display" class="form-control form-control-lg fw-bold text-success format-rupiah" value="{{ number_format($hpp_per_bulan ?? 0, 0, ',', '.') }}" required {{ auth()->user()->role !== 'superadmin' ? 'readonly' : '' }}>
                                    <input type="hidden" name="hpp_per_bulan" id="hpp_per_bulan_real" value="{{ $hpp_per_bulan ?? 0 }}">
                                </div>
                                <small class="text-muted mt-2 d-block">Angka ini digunakan untuk menghitung persentase HPP di layar Data KPI Superadmin.</small>
                            </div>
                            
                            @if(auth()->user()->role === 'superadmin')
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-round shadow-sm fw-bold px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Parameter
                                </button>
                            </div>
                            @endif
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formatRupiah = (angka, prefix) => {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    const inputs = document.querySelectorAll('.format-rupiah');
    inputs.forEach(input => {
        input.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
            // Update hidden input
            let realInput = this.nextElementSibling;
            if(realInput && realInput.type === 'hidden') {
                realInput.value = this.value.replace(/\./g, '');
            }
        });
    });
});
</script>
@endsection

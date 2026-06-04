@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama kamu --}}

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row justify-content-center align-items-center mt-4">
            <div class="col-md-8">
                
                {{-- Alert Sukses Login --}}
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success-subtle rounded-4 mb-4 fade-in" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <strong>Selamat Datang, {{ Auth::user()->name }}!</strong> Anda telah berhasil masuk ke dalam sistem.
                        </div>
                    </div>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                {{-- Kartu Sambutan Utama --}}
                <div class="card card-modern border-0 shadow-sm rounded-4 text-center p-5 fade-in" style="background: linear-gradient(to right bottom, #ffffff, #f8fafc);">
                    <div class="card-body">
                        <div class="mb-4">
                            {{-- Gunakan logo perusahaan jika ada, jika tidak pakai icon --}}
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 32px;">
                                <i class="fas fa-building"></i>
                            </div>
                            <h2 class="fw-bolder text-dark mb-1">Sistem Informasi Manajemen Terpadu</h2>
                            <p class="text-muted">Kelola data, pantau progres, dan tingkatkan performa.</p>
                        </div>

                        {{-- Jam & Tanggal --}}
                        <div class="d-inline-block bg-white border px-4 py-2 rounded-pill shadow-sm mb-4">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <span id="realtime-clock" class="fw-bold text-dark" style="letter-spacing: 0.5px;">Memuat waktu...</span>
                        </div>

                        <hr class="text-muted opacity-25 mx-5 mb-4">

                        {{-- Info User --}}
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">Status Login</span>
                                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-circle me-1" style="font-size: 8px;"></i> Online</span>
                            </div>
                            <div class="col-auto">
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">Hak Akses</span>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm text-capitalize">
                                    <i class="fas fa-user-shield me-1"></i> {{ Auth::user()->role ?? 'User' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <p class="text-muted small">Silakan gunakan menu navigasi di sebelah kiri untuk mulai bekerja.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Style & Script Khusus Halaman Home --}}
<style>
    .card-modern { transition: all 0.3s ease; }
    .card-modern:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05) !important; }
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
    });
</script>
@endsection
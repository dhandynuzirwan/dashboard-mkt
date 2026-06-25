@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama kamu --}}

@section('content')
<div class="container-fluid py-4">
    <div class="page-inner">
        {{-- Alert Sukses Login (Bisa di-dismiss) --}}
        @if(session('success_login') || true) {{-- Atur logika session sesuai sistem kamu --}}
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4 fade-in" role="alert" style="background-color: #d1fae5; color: #065f46;">
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
        @endif

        <div class="row g-4">
            {{-- KOLOM KIRI (Utama) --}}
            <div class="col-lg-8 col-md-12">
                
                {{-- 1. Hero Banner --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative overflow-hidden">
                        {{-- Ornamen Latar --}}
                        <i class="fas fa-chart-line position-absolute" style="font-size: 150px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
                        
                        <div class="row align-items-center position-relative z-1">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
                                <p class="opacity-75 mb-4">Siap untuk menyelesaikan tugas hebat hari ini? Cek jadwal dan progres kamu di bawah ini.</p>
                                
                                <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-2" style="backdrop-filter: blur(5px);">
                                    <i class="fas fa-clock me-2"></i>
                                    <span id="realtime-clock" class="fw-semibold" style="letter-spacing: 0.5px;">Memuat waktu...</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end d-none d-md-block">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow ms-auto" style="width: 80px; height: 80px;">
                                    <i class="fas fa-building text-primary fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Quick Actions (Akses Cepat) --}}
                <h5 class="fw-bold mb-3 fade-in" style="animation-delay: 0.1s;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h5>
                <div class="row g-3 mb-4 fade-in" style="animation-delay: 0.2s;">
                    <div class="col-6 col-sm-3">
                        <a href="{{ route('pegawai.absensi.index') }}" class="text-decoration-none">
                            <div class="card card-hover border-0 shadow-sm rounded-4 text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-primary-subtle text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-camera fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small">Absen Selfie</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="{{ route('operational.aktivitas-harian') }}" class="text-decoration-none">
                            <div class="card card-hover border-0 shadow-sm rounded-4 text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-success-subtle text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-tasks fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small">Aktivitas Harian</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="{{ route('pengajuan-izin.index') }}" class="text-decoration-none">
                            <div class="card card-hover border-0 shadow-sm rounded-4 text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-warning-subtle text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-envelope-open-text fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small">Ajukan Izin</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-3">
                        <a href="{{ route('modul.index') }}" class="text-decoration-none">
                            <div class="card card-hover border-0 shadow-sm rounded-4 text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-info-subtle text-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-book-open fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small">Modul Pelatihan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- 3. Pengumuman --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="animation-delay: 0.3s;">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0"><i class="fas fa-bullhorn text-danger me-2"></i> Pengumuman Terbaru</h5>
                            <button class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="bg-danger-subtle text-danger rounded p-2 text-center" style="width: 60px;">
                                    <span class="d-block fw-bold fs-5 line-height-1">28</span>
                                    <span class="d-block small">Jun</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold mb-1">Maintenance Sistem Malam Hari</h6>
                                <p class="text-muted small mb-0">Sistem akan mengalami pemeliharaan rutin pada pukul 23:00 - 02:00 WIB. Mohon simpan semua pekerjaan Anda.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-primary-subtle text-primary rounded p-2 text-center" style="width: 60px;">
                                    <span class="d-block fw-bold fs-5 line-height-1">01</span>
                                    <span class="d-block small">Jul</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold mb-1">Upload Bukti Potong Pajak</h6>
                                <p class="text-muted small mb-0">Silakan cek menu slip gaji, bukti potong pajak tahunan sudah dapat diunduh mulai tanggal 1 Juli.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (Sidebar Widget) --}}
            <div class="col-lg-4 col-md-12 fade-in" style="animation-delay: 0.4s;">
                
                {{-- 1. Mini Profile & Status --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-container mb-3 position-relative d-inline-block">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 90px; height: 90px;">
                                <i class="fas fa-user text-secondary fs-1"></i>
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" style="transform: translate(-10px, -5px);" title="Online">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </div>
                        <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted small mb-3 text-capitalize"><i class="fas fa-user-shield me-1"></i> {{ Auth::user()->role ?? 'Karyawan' }}</p>
                        
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('my-profile.edit') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Edit Profil</a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- 2. Ringkasan Absensi --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-clipboard-check text-success me-2"></i> Kehadiran Bulan Ini</h6>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Tingkat Kehadiran</span>
                            <span class="fw-bold text-success small">92%</span>
                        </div>
                        <div class="progress mb-4" style="height: 8px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="row text-center g-2">
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block fw-bold fs-5 text-dark">18</span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Hadir</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block fw-bold fs-5 text-warning">1</span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Telat</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded p-2">
                                    <span class="d-block fw-bold fs-5 text-danger">0</span>
                                    <span class="d-block text-muted" style="font-size: 11px;">Absen</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Status Pengajuan Terakhir --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-history text-secondary me-2"></i> Pengajuan Terakhir</h6>
                        
                        <div class="position-relative">
                            {{-- Item 1 --}}
                            <div class="d-flex mb-3 position-relative">
                                <div class="flex-shrink-0 d-flex flex-column align-items-center">
                                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; z-index: 2;">
                                        <i class="fas fa-check small"></i>
                                    </div>
                                    <div class="border-start border-2 position-absolute" style="height: 100%; top: 32px; left: 15px; border-color: #e9ecef !important; z-index: 1;"></div>
                                </div>
                                <div class="flex-grow-1 ms-3 pb-3">
                                    <h6 class="fw-semibold mb-0" style="font-size: 14px;">Izin Sakit</h6>
                                    <span class="text-muted d-block mb-1" style="font-size: 12px;">20 Jun 2026</span>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2" style="font-size: 10px;">Disetujui</span>
                                </div>
                            </div>
                            
                            {{-- Item 2 --}}
                            <div class="d-flex position-relative">
                                <div class="flex-shrink-0 d-flex flex-column align-items-center">
                                    <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; z-index: 2;">
                                        <i class="fas fa-hourglass-half small"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 pb-1">
                                    <h6 class="fw-semibold mb-0" style="font-size: 14px;">Download Request</h6>
                                    <span class="text-muted d-block mb-1" style="font-size: 12px;">24 Jun 2026</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2" style="font-size: 10px;">Menunggu Approval</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Style & Script Khusus Halaman Home --}}
<style>
    /* body { background-color: #f8f9fa; } */ /* Opsional, tergantung tema bawaan */
    .card { transition: all 0.3s ease; }
    .card-hover:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; 
        background-color: #fcfcfc;
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(15px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    .line-height-1 { line-height: 1; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            // Handle timezone and locale cleanly
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
    });
</script>
@endsection
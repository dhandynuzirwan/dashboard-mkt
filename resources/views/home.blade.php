@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="page-inner">
        
        {{-- Alert Sukses Login --}}
        @if(session('success_login') || true) 
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

                <div class="row">
                    <div class="col-md-6">
                        {{-- 3. Panel Pengumuman (Ditingkatkan) --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="animation-delay: 0.3s; height: 100%;">
                            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                <h5 class="fw-bold mb-0"><i class="fas fa-bullhorn text-danger me-2"></i> Papan Pengumuman</h5>
                            </div>
                            <div class="card-body p-4">
                                {{-- Item: Hari Besar --}}
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success-subtle text-success rounded p-2 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-mosque fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 mb-1" style="font-size: 10px;">Hari Besar</span>
                                        <h6 class="fw-bold mb-1">Cuti Bersama Idul Adha</h6>
                                        <p class="text-muted small mb-0">Libur operasional pada 28-29 Juni. Selamat merayakan bagi yang merayakan.</p>
                                    </div>
                                </div>
                                {{-- Item: Deadline Urgent --}}
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    <div class="flex-shrink-0">
                                        <div class="bg-danger-subtle text-danger rounded p-2 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-exclamation-triangle fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="badge bg-danger rounded-pill px-2 mb-1" style="font-size: 10px;"><i class="fas fa-fire me-1"></i> Urgent</span>
                                        <h6 class="fw-bold mb-1">Batas Akhir Laporan</h6>
                                        <p class="text-muted small mb-0">Segera lengkapi log aktivitas bulan ini maksimal tanggal 25 sebelum jam 15:00.</p>
                                    </div>
                                </div>
                                {{-- Item: Pencapaian --}}
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary-subtle text-primary rounded p-2 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-trophy fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 mb-1" style="font-size: 10px;">Pencapaian</span>
                                        <h6 class="fw-bold mb-1">Target Tercapai! 🎉</h6>
                                        <p class="text-muted small mb-0">Tim Marketing berhasil menembus target KPI kuartal ini lebih awal.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- 4. Aktivitas Terbaru --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="animation-delay: 0.4s; height: 100%;">
                            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                <h5 class="fw-bold mb-0"><i class="fas fa-stream text-info me-2"></i> Aktivitas Feed</h5>
                            </div>
                            <div class="card-body p-4 pt-3">
                                <ul class="list-unstyled mb-0 position-relative">
                                    {{-- Garis background timeline --}}
                                    <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 5px; z-index: 1;"></div>
                                    
                                    <li class="position-relative ps-4 mb-4 z-2">
                                        <div class="position-absolute bg-info border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1">10 Mnt lalu &bull; <span class="fw-semibold text-dark">Modul</span></div>
                                        <div class="small fw-semibold text-dark">Admin mengunggah: "Panduan ISO 9001"</div>
                                    </li>
                                    <li class="position-relative ps-4 mb-4 z-2">
                                        <div class="position-absolute bg-success border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1">1 Jam lalu &bull; <span class="fw-semibold text-dark">Operasional</span></div>
                                        <div class="small fw-semibold text-dark">Sistem berhasil di-backup harian.</div>
                                    </li>
                                    <li class="position-relative ps-4 mb-4 z-2">
                                        <div class="position-absolute bg-warning border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1">Kemarin &bull; <span class="fw-semibold text-dark">HRD</span></div>
                                        <div class="small fw-semibold text-dark">Izin tahunan Budi disetujui.</div>
                                    </li>
                                    <li class="position-relative ps-4 z-2">
                                        <div class="position-absolute bg-primary border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1">Kemarin &bull; <span class="fw-semibold text-dark">Pendaftaran</span></div>
                                        <div class="small fw-semibold text-dark">PT Maju Mendaftarkan 5 Karyawan.</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (Sidebar Widget) --}}
            <div class="col-lg-4 col-md-12 fade-in" style="animation-delay: 0.5s;">
                
                {{-- 1. Mini Profile --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="avatar-container position-relative me-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-secondary fs-3"></i>
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" style="transform: translate(-2px, -2px);" title="Online"></span>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted small mb-0 text-capitalize"><i class="fas fa-user-shield me-1"></i> {{ Auth::user()->role ?? 'Karyawan' }}</p>
                        </div>
                        <div class="ms-auto dropdown">
                            <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('my-profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- 2. Kalender Dinamis --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt text-primary me-2"></i> Kalender Agenda</h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Header Kalender --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-sm btn-light rounded-circle" onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                            <h6 class="fw-bold mb-0" id="calendar-month-year">...</h6>
                            <button class="btn btn-sm btn-light rounded-circle" onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        
                        {{-- Grid Hari Kalender --}}
                        <div class="text-center calendar-wrapper mb-3">
                            <div class="d-flex text-muted small fw-bold mb-2">
                                <div style="width: 14.28%">M</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">R</div>
                                <div style="width: 14.28%">K</div>
                                <div style="width: 14.28%">J</div>
                                <div style="width: 14.28%">S</div>
                            </div>
                            <div id="calendar-days" class="d-flex flex-wrap small">
                                <!-- JS Populated -->
                            </div>
                        </div>
                        
                        <hr class="opacity-10">
                        
                        {{-- List Event --}}
                        <h6 class="fw-semibold small mb-3 text-muted text-uppercase">Agenda Mendatang</h6>
                        <div class="d-flex mb-2 align-items-center">
                            <div class="bg-primary rounded-circle me-2" style="width:10px; height:10px;"></div>
                            <div class="small fw-semibold text-dark">Pelatihan K3 <span class="badge bg-light text-muted ms-2 fw-normal">12 Jun</span></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-danger rounded-circle me-2" style="width:10px; height:10px;"></div>
                            <div class="small fw-semibold text-dark">Batas Submit Absen <span class="badge bg-light text-muted ms-2 fw-normal">15 Jun</span></div>
                        </div>
                    </div>
                </div>

                {{-- 3. Ringkasan Absensi --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-clipboard-check text-success me-2"></i> Kehadiran Bulan Ini</h6>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Tingkat Kehadiran</span>
                            <span class="fw-bold text-success small">92%</span>
                        </div>
                        <div class="progress mb-4" style="height: 8px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 92%"></div>
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

            </div>
        </div>
    </div>
</div>

<style>
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
    
    /* Calendar styles */
    .calendar-day { 
        width: 14.28%; padding: 6px 0; border-radius: 6px; cursor: pointer; position: relative;
    }
    .calendar-day:hover:not(.empty) { background-color: #f8f9fa; }
    .calendar-day.today { background-color: #0d6efd; color: white; font-weight: bold; }
    .calendar-dot { 
        position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%);
        width: 4px; height: 4px; border-radius: 50%;
    }
</style>

<script>
    // --- JAM REALTIME ---
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
        
        // Render Initial Calendar
        renderCalendar();
    });

    // --- KALENDER DINAMIS ---
    let currentDate = new Date();
    
    // Dummy event dates (in current month context)
    const events = {
        12: 'primary', // tgl 12 warna primary
        15: 'danger',  // tgl 15 warna merah
        28: 'success', // tgl 28 hari raya
        29: 'success'
    };

    function renderCalendar() {
        const monthYearEl = document.getElementById('calendar-month-year');
        const daysEl = document.getElementById('calendar-days');
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Format Nama Bulan
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        monthYearEl.innerText = `${monthNames[month]} ${year}`;
        
        // Kalkulasi hari
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        const today = new Date();
        const isCurrentMonth = (today.getMonth() === month && today.getFullYear() === year);
        
        daysEl.innerHTML = '';
        
        // Empty slots sebelum tgl 1
        for(let i=0; i<firstDay; i++) {
            daysEl.innerHTML += `<div class="calendar-day empty"></div>`;
        }
        
        // Tanggal
        for(let i=1; i<=daysInMonth; i++) {
            let classes = "calendar-day";
            if(isCurrentMonth && i === today.getDate()) {
                classes += " today shadow-sm";
            }
            
            // Cek apakah ada event di tgl ini
            let dotHtml = '';
            if(events[i]) {
                // Jangan tampilkan dot di hari ini agar tidak tabrakan gaya, atau ubah warnanya
                if(!(isCurrentMonth && i === today.getDate())) {
                    dotHtml = `<div class="calendar-dot bg-${events[i]}"></div>`;
                }
            }
            
            daysEl.innerHTML += `<div class="${classes}">${i}${dotHtml}</div>`;
        }
    }

    function changeMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        renderCalendar();
    }
</script>
@endsection
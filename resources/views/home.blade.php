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
                @php
                    $userRole = Auth::user()->role ?? 'karyawan';
                    $quickAccess = [];
                
                    if ($userRole == 'superadmin') {
                        $quickAccess = [
                            ['title' => 'Dashboard Progress', 'icon' => 'fas fa-chart-pie', 'color' => 'primary', 'route' => route('dashboard.progress')],
                            ['title' => 'Simulasi Gaji', 'icon' => 'fas fa-calculator', 'color' => 'success', 'route' => route('simulasi-gaji')],
                            ['title' => 'Riwayat Pelatihan', 'icon' => 'fas fa-history', 'color' => 'warning', 'route' => route('riwayat.pelatihan')],
                            ['title' => 'Data Absensi', 'icon' => 'fas fa-clipboard-list', 'color' => 'info', 'route' => route('absensi')],
                        ];
                    } elseif ($userRole == 'spv' || $userRole == 'spv_marketing') {
                        $quickAccess = [
                            ['title' => 'Dashboard Progress', 'icon' => 'fas fa-chart-pie', 'color' => 'primary', 'route' => route('dashboard.progress')],
                            ['title' => 'Pipeline Marketing', 'icon' => 'fas fa-filter', 'color' => 'success', 'route' => route('pipeline')],
                            ['title' => 'Revenue', 'icon' => 'fas fa-money-bill-wave', 'color' => 'warning', 'route' => route('revenue')],
                            ['title' => 'Registrasi Peserta', 'icon' => 'fas fa-users', 'color' => 'info', 'route' => route('operational.data-pendaftaran')],
                        ];
                    } elseif (in_array($userRole, ['admin', 'rnd', 'digitalmarketing'])) {
                        $quickAccess = [
                            ['title' => 'Dashboard Progress', 'icon' => 'fas fa-chart-pie', 'color' => 'primary', 'route' => route('dashboard.progress')],
                            ['title' => 'Database Masuk', 'icon' => 'fas fa-database', 'color' => 'success', 'route' => route('data-masuk.index')],
                            ['title' => 'Pipeline Marketing', 'icon' => 'fas fa-filter', 'color' => 'warning', 'route' => route('pipeline')],
                            ['title' => 'Master Pelatihan', 'icon' => 'fas fa-book', 'color' => 'info', 'route' => route('master-training.index')],
                        ];
                    } elseif (in_array($userRole, ['operasional', 'graphic', 'team_leader', 'web_dev'])) {
                        $quickAccess = [
                            ['title' => 'Aktivitas Harian', 'icon' => 'fas fa-tasks', 'color' => 'primary', 'route' => route('operational.aktivitas-harian')],
                            ['title' => 'Registrasi Peserta', 'icon' => 'fas fa-users', 'color' => 'success', 'route' => route('operational.data-pendaftaran')],
                            ['title' => 'Pelatihan Berjalan', 'icon' => 'fas fa-desktop', 'color' => 'warning', 'route' => route('monitoring.pelatihan')],
                            ['title' => 'Riwayat Pelatihan', 'icon' => 'fas fa-history', 'color' => 'info', 'route' => route('riwayat.pelatihan')],
                        ];
                    } elseif ($userRole == 'marketing') {
                        $quickAccess = [
                            ['title' => 'Pipeline Marketing', 'icon' => 'fas fa-filter', 'color' => 'primary', 'route' => route('pipeline')],
                            ['title' => 'Simulasi Gaji', 'icon' => 'fas fa-calculator', 'color' => 'success', 'route' => route('simulasi-gaji')],
                            ['title' => 'Revenue', 'icon' => 'fas fa-money-bill-wave', 'color' => 'warning', 'route' => route('revenue')],
                            ['title' => 'Data KPI', 'icon' => 'fas fa-chart-line', 'color' => 'info', 'route' => route('data-kpi')],
                        ];
                    } else {
                        // Karyawan Biasa
                        $quickAccess = [
                            ['title' => 'Absen Selfie', 'icon' => 'fas fa-camera', 'color' => 'primary', 'route' => route('pegawai.absensi.index')],
                            ['title' => 'Aktivitas Harian', 'icon' => 'fas fa-tasks', 'color' => 'success', 'route' => route('operational.aktivitas-harian')],
                            ['title' => 'Ajukan Izin', 'icon' => 'fas fa-envelope-open-text', 'color' => 'warning', 'route' => route('pengajuan-izin.index')],
                            ['title' => 'Modul Pelatihan', 'icon' => 'fas fa-book-open', 'color' => 'info', 'route' => route('modul.index')],
                        ];
                    }
                @endphp

                <h5 class="fw-bold mb-3 fade-in" style="animation-delay: 0.1s;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h5>
                <div class="row g-3 mb-4 fade-in" style="animation-delay: 0.2s;">
                    @foreach($quickAccess as $item)
                    <div class="col-6 col-sm-3">
                        <a href="{{ $item['route'] }}" class="text-decoration-none">
                            <div class="card card-hover border-0 shadow-sm rounded-4 text-center h-100 p-3">
                                <div class="card-body p-2">
                                    <div class="icon-box bg-{{ $item['color'] }}-subtle text-{{ $item['color'] }} rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="{{ $item['icon'] }} fs-4"></i>
                                    </div>
                                    <h6 class="text-dark fw-semibold mb-0 small">{{ $item['title'] }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {{-- 3. Panel Pengumuman (Dinamis) --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="animation-delay: 0.3s; height: 100%;">
                            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                <h5 class="fw-bold mb-0"><i class="fas fa-bullhorn text-danger me-2"></i> Papan Pengumuman</h5>
                            </div>
                            <div class="card-body p-4">
                                @forelse($pengumuman as $p)
                                    @php
                                        $icon = 'fas fa-info-circle';
                                        $color = 'primary';
                                        $badgeText = 'Pengumuman';
                                        if($p->kategori == 'hari_besar') {
                                            $icon = 'fas fa-calendar-day';
                                            $color = 'success';
                                            $badgeText = 'Hari Besar';
                                        } elseif($p->kategori == 'urgent') {
                                            $icon = 'fas fa-exclamation-triangle';
                                            $color = 'danger';
                                            $badgeText = '<i class="fas fa-fire me-1"></i> Urgent';
                                        } elseif($p->kategori == 'pencapaian') {
                                            $icon = 'fas fa-trophy';
                                            $color = 'primary';
                                            $badgeText = 'Pencapaian';
                                        }
                                    @endphp
                                    <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="flex-shrink-0">
                                            <div class="bg-{{ $color }}-subtle text-{{ $color }} rounded p-2 text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="{{ $icon }} fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="badge badge-{{ $color }} rounded-pill px-2 mb-1" style="font-size: 10px;">{!! $badgeText !!}</span>
                                            <h6 class="fw-bold mb-1">{{ $p->judul }}</h6>
                                            <p class="text-muted small mb-0">{{ $p->deskripsi }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-bell-slash fs-1 text-light mb-2 d-block"></i>
                                        <span class="small">Belum ada pengumuman saat ini.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- 4. Aktivitas Terbaru (Dinamis) --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 fade-in" style="animation-delay: 0.4s; height: 100%;">
                            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                <h5 class="fw-bold mb-0"><i class="fas fa-list text-info me-2"></i> Aktivitas Feed</h5>
                            </div>
                            <div class="card-body p-4 pt-3">
                                <ul class="list-unstyled mb-0 position-relative">
                                    @if($feed->count() > 0)
                                        {{-- Garis background timeline --}}
                                        <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 5px; z-index: 1;"></div>
                                        
                                        @foreach($feed as $f)
                                        <li class="position-relative ps-4 mb-4 z-2">
                                            <div class="position-absolute bg-{{ $f['color'] }} border border-white border-2 rounded-circle" style="width: 14px; height: 14px; left: -1px; top: 3px;"></div>
                                            <div class="small text-muted mb-1">{{ \Carbon\Carbon::parse($f['time'])->diffForHumans() }} &bull; <span class="fw-semibold text-dark">{{ $f['type'] }}</span></div>
                                            <div class="small fw-semibold text-dark">{{ $f['title'] }}</div>
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="text-center py-4 text-muted">
                                            <i class="fas fa-history fs-1 text-light mb-2 d-block"></i>
                                            <span class="small">Belum ada aktivitas terekam.</span>
                                        </li>
                                    @endif
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
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center overflow-hidden" style="width: 60px; height: 60px;">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profile Picture" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <i class="fas fa-user text-secondary fs-3"></i>
                                @endif
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" style="transform: translate(-2px, -2px);" title="Online"></span>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted small mb-0 text-capitalize"><i class="fas fa-user-shield me-1"></i> {{ str_replace('_', ' ', Auth::user()->role ?? 'Karyawan') }}</p>
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
                        @forelse($upcomingAgendas as $agenda)
                            <div class="d-flex mb-2 align-items-center">
                                <div class="bg-{{ $agenda['color'] }} rounded-circle me-2" style="width:10px; height:10px;"></div>
                                <div class="small fw-semibold text-dark">{{ $agenda['title'] }} <span class="badge bg-light text-muted ms-2 fw-normal">{{ \Carbon\Carbon::parse($agenda['date'])->format('d M') }}</span></div>
                            </div>
                        @empty
                            <div class="small text-muted text-center py-2">Tidak ada agenda mendatang.</div>
                        @endforelse
                    </div>
                </div>

                {{-- 3. Ringkasan Absensi --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3 text-start"><i class="fas fa-clipboard-check text-success me-2"></i> Kehadiran Bulan Ini</h6>
                        
                        <div class="position-relative mx-auto" style="width: 140px; height: 140px; margin-bottom: 20px;">
                            <canvas id="attendanceChart"></canvas>
                            <div class="position-absolute top-50 start-50 translate-middle text-center" style="margin-top: 2px;">
                                <span class="d-block fw-bold fs-4 text-dark line-height-1" style="margin-bottom: -5px;">{{ $attendanceRate }}%</span>
                                <span class="text-muted" style="font-size: 10px;">Tingkat Kehadiran</span>
                            </div>
                        </div>

                        <div class="row text-center g-2 mt-2 border-top pt-3">
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-success">{{ $hadir }}</span>
                                <span class="d-block text-muted" style="font-size: 11px;">Hadir</span>
                            </div>
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-warning">{{ $telat }}</span>
                                <span class="d-block text-muted" style="font-size: 11px;">Telat</span>
                            </div>
                            <div class="col-4">
                                <span class="d-block fw-bold fs-5 text-danger">{{ $absen }}</span>
                                <span class="d-block text-muted" style="font-size: 11px;">Absen/Alpha</span>
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
    .calendar-day:hover:not(.empty) { background-color: #eff6ff; color: #0d6efd; font-weight: 600; }
    .calendar-day.today { background-color: #0d6efd; color: white; font-weight: bold; }
    .calendar-dot { 
        position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%);
        width: 4px; height: 4px; border-radius: 50%;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        // Render Doughnut Chart
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Telat', 'Absen'],
                datasets: [{
                    data: [{{ $hadir }}, {{ $telat }}, {{ $absen }}],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                maintainAspectRatio: false
            }
        });
    });

    // --- KALENDER DINAMIS ---
    let currentDate = new Date();
    
    // Server-side events injected to JS
    const events = @json($calendarEvents);

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
            // Only show events for current server month if we are viewing the current server month, 
            // since $calendarEvents is generated only for the server's current month.
            // For a fully dynamic calendar, we'd need to fetch events via AJAX. For now, this is static per month load.
            const serverDate = new Date();
            const isViewingServerMonth = (serverDate.getMonth() === month && serverDate.getFullYear() === year);

            if(isViewingServerMonth && events[i]) {
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
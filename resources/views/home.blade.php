@extends('layouts.app')

@section('content')
<style>
    /* Ultra-Premium Modern CSS (Bento Grid) */
    .page-wrapper-modern {
        background-color: #f4f6fa;
        min-height: 100vh;
        font-family: 'Nunito', 'Segoe UI', sans-serif;
    }
    
    .bento-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .bento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .bento-card-no-hover {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
        border-radius: 24px;
        overflow: hidden;
    }

    .profile-banner {
        height: 120px;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        position: relative;
        overflow: hidden;
    }
    
    .profile-avatar-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        padding: 5px;
        background: white;
        margin-top: -50px;
        position: relative;
        z-index: 2;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .data-diri-item {
        background: #f8f9fc;
        border-radius: 16px;
        padding: 12px 16px;
        transition: all 0.2s;
    }
    .data-diri-item:hover {
        background: #eff6ff;
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
        width: 14.28%; padding: 6px 0; border-radius: 8px; cursor: pointer; position: relative;
    }
    .calendar-day:hover:not(.empty) { background-color: #eff6ff; color: #4e73df; font-weight: 700; }
    .calendar-day.today { background-color: #4e73df; color: white; font-weight: bold; box-shadow: 0 4px 10px rgba(78, 115, 223, 0.4); }
    .calendar-label { 
        position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%);
        width: 20px; height: 4px; border-radius: 10px;
    }

    .scrollable-content {
        max-height: 380px;
        overflow-y: auto;
        padding-right: 5px;
    }
    
    .scrollable-content::-webkit-scrollbar { width: 5px; }
    .scrollable-content::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    
    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        border: 1px solid #edf2f9;
        padding: 12px 20px;
        border-radius: 16px;
        color: #475569;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border-color: #bac8f3;
        color: #4e73df;
    }
    
    .icon-box {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
</style>

<div class="page-wrapper-modern fade-in">
    <div class="container-fluid py-4 px-3 px-md-4">
        
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

        @if(isset($statusHariIni) && $statusHariIni)
        <div class="alert alert-{{ $statusHariIni['color'] }} alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4 fade-in" role="alert" style="background-color: var(--bs-{{ $statusHariIni['color'] }}-bg-subtle, #fef3c7);">
            <div class="d-flex align-items-center">
                <div class="icon-sm bg-white text-{{ $statusHariIni['color'] }} rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                    <i class="{{ $statusHariIni['icon'] }}"></i>
                </div>
                <div>
                    <strong>Pemberitahuan:</strong> Anda sedang berstatus <strong>{{ $statusHariIni['tipe'] }}</strong> hari ini. (Keterangan: {{ $statusHariIni['keterangan'] ?? '-' }})
                </div>
            </div>
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- BENTO GRID ROW 1: Profile & Attendance --}}
        <div class="row g-4 mb-4">
            {{-- PROFILE SECTION (Utama) --}}
            <div class="col-lg-8 col-md-12">
                <div class="bento-card-no-hover h-100 position-relative fade-in">
                    {{-- Banner Background --}}
                    <div class="profile-banner d-flex justify-content-end p-3">
                        <i class="fas fa-chart-line position-absolute" style="font-size: 150px; right: -20px; bottom: -30px; opacity: 0.1; color: white; z-index: 0;"></i>
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-1 text-white position-relative" style="backdrop-filter: blur(5px); height: fit-content; z-index: 1;">
                            <i class="fas fa-clock me-2"></i>
                            <span id="realtime-clock" class="fw-semibold small">Memuat waktu...</span>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4 px-md-5 pb-md-5">
                        <div class="d-flex flex-column flex-md-row align-items-md-end gap-4 mb-4">
                            <div class="profile-avatar-wrapper">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Profile Picture" class="profile-avatar">
                                @else
                                    <div class="profile-avatar bg-light d-flex align-items-center justify-content-center text-muted">
                                        <i class="fas fa-user fs-1"></i>
                                    </div>
                                @endif
                                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" style="transform: translate(-5px, -5px);" title="Online"></span>
                            </div>
                            
                            <div class="flex-grow-1 pb-1">
                                <h3 class="fw-black text-dark mb-1">{{ Auth::user()->name }}</h3>
                                <p class="text-primary fw-bold small mb-0 text-uppercase" style="letter-spacing: 1px;">
                                    <i class="fas fa-user-shield me-1"></i> {{ str_replace('_', ' ', Auth::user()->role ?? 'Karyawan') }}
                                </p>
                            </div>
                            
                            <div class="pb-1 dropdown">
                                <button class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-1"></i> Pengaturan
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                    <li><a class="dropdown-item rounded-3 mb-1" href="{{ route('my-profile.edit') }}"><i class="fas fa-user-edit me-2 text-primary"></i> Edit Profil</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Data Diri Bento Grid --}}
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="data-diri-item h-100">
                                    <div class="text-muted small fw-bold mb-1"><i class="fas fa-id-badge text-primary me-1"></i> NIK</div>
                                    <div class="text-dark fw-bolder">{{ Auth::user()->nik ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="data-diri-item h-100">
                                    <div class="text-muted small fw-bold mb-1"><i class="fas fa-birthday-cake text-warning me-1"></i> Tanggal Lahir</div>
                                    <div class="text-dark fw-bolder">{{ Auth::user()->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->translatedFormat('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="data-diri-item h-100">
                                    <div class="text-muted small fw-bold mb-1"><i class="fas fa-file-signature text-info me-1"></i> Kontrak Mulai</div>
                                    <div class="text-dark fw-bolder">{{ Auth::user()->tanggal_kontrak_baru ? \Carbon\Carbon::parse(Auth::user()->tanggal_kontrak_baru)->translatedFormat('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="data-diri-item h-100">
                                    <div class="text-muted small fw-bold mb-1"><i class="fas fa-hourglass-end text-danger me-1"></i> Kontrak Habis</div>
                                    <div class="text-danger fw-bolder">{{ Auth::user()->tanggal_kontrak_berakhir ? \Carbon\Carbon::parse(Auth::user()->tanggal_kontrak_berakhir)->translatedFormat('d M Y') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Quick Actions --}}
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold mb-3 text-muted small text-uppercase">Akses Cepat</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($quickAccess as $item)
                                    <a href="{{ $item['route'] }}" class="quick-action-btn">
                                        <div class="icon-box bg-{{ $item['color'] }}-subtle text-{{ $item['color'] }} shadow-sm" style="width: 32px; height: 32px; border-radius: 8px;">
                                            <i class="{{ $item['icon'] }}"></i>
                                        </div>
                                        {{ $item['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ATTENDANCE SECTION --}}
            <div class="col-lg-4 col-md-12">
                <div class="bento-card h-100 p-4 fade-in" style="animation-delay: 0.1s;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-clipboard-check text-success me-2"></i> Kehadiran</h5>
                        <span class="badge bg-light text-muted border">Bulan Ini</span>
                    </div>
                    
                    <div class="position-relative mx-auto w-100" style="max-width: 280px; aspect-ratio: 1/1; margin-bottom: 30px; margin-top: 10px;">
                        <canvas id="attendanceChart"></canvas>
                        <div class="position-absolute top-50 start-50 translate-middle text-center" style="margin-top: 2px;">
                            <span class="d-block fw-black text-dark line-height-1" style="font-size: 2.8rem; margin-bottom: -5px;">{{ $attendanceRate }}%</span>
                            <span class="text-muted fw-bold" style="font-size: 12px; letter-spacing: 1px;">RATING</span>
                        </div>
                    </div>

                    <div class="row text-center g-3">
                        <div class="col-4">
                            <div class="p-1 h-100">
                                <span class="d-block text-success fw-bold" style="font-size: 11px; text-transform: uppercase;">Hadir</span>
                                <span class="d-block fw-black fs-5 text-dark mt-1">{{ $hadir }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-1 h-100">
                                <span class="d-block text-warning fw-bold" style="font-size: 11px; text-transform: uppercase;">Telat</span>
                                <span class="d-block fw-black fs-5 text-dark mt-1">{{ $telat }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-1 h-100">
                                <span class="d-block text-danger fw-bold" style="font-size: 11px; text-transform: uppercase;">Absen</span>
                                <span class="d-block fw-black fs-5 text-dark mt-1">{{ $absen }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BENTO GRID ROW 2: Announcements, Calendar, Feed --}}
        <div class="row g-4 mb-4">
            {{-- Pengumuman --}}
            <div class="col-lg-4 col-md-6">
                <div class="bento-card h-100 fade-in" style="animation-delay: 0.2s;">
                    <div class="bg-transparent border-0 pt-4 pb-3 px-4 d-flex align-items-center gap-2">
                        <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h5 class="fw-bolder mb-0 text-dark">Pengumuman</h5>
                    </div>
                    <div class="p-4 pt-0 scrollable-content">
                        @forelse($pengumuman as $p)
                            @php
                                $icon = 'fas fa-info-circle';
                                $color = 'primary';
                                $badgeText = 'Info';
                                if($p->kategori == 'hari_besar') {
                                    $icon = 'fas fa-calendar-day';
                                    $color = 'success';
                                    $badgeText = 'Hari Besar';
                                } elseif($p->kategori == 'urgent') {
                                    $icon = 'fas fa-exclamation-triangle';
                                    $color = 'danger';
                                    $badgeText = 'Urgent';
                                } elseif($p->kategori == 'pencapaian') {
                                    $icon = 'fas fa-trophy';
                                    $color = 'warning';
                                    $badgeText = 'Pencapaian';
                                }
                            @endphp
                            <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="bg-{{ $color }}-subtle text-{{ $color }} rounded-circle text-center d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold text-dark mb-0 pe-2">{{ $p->judul }}</h6>
                                        <span class="badge bg-{{ $color }} rounded-pill px-2" style="font-size: 9px; letter-spacing: 0.5px;">{{ $badgeText }}</span>
                                    </div>
                                    <p class="text-muted small mb-1" style="font-size: 13px;">{{ $p->deskripsi }}</p>
                                    <small class="text-secondary fw-semibold" style="font-size: 11px;"><i class="fas fa-clock me-1"></i>{{ $p->tanggal_event ? \Carbon\Carbon::parse($p->tanggal_event)->format('d M Y') : $p->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-bell-slash fs-1 text-light mb-3 d-block"></i>
                                <span class="small fw-semibold">Tidak ada pengumuman baru.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Kalender Agenda --}}
            <div class="col-lg-4 col-md-6">
                <div class="bento-card h-100 fade-in" style="animation-delay: 0.3s;">
                    <div class="bg-transparent border-0 pt-4 pb-2 px-4 d-flex align-items-center gap-2">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5 class="fw-bolder mb-0 text-dark">Kalender</h5>
                    </div>
                    <div class="p-4 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3 bg-light rounded-pill p-1">
                            <button class="btn btn-sm btn-white rounded-circle shadow-sm" onclick="changeMonth(-1)"><i class="fas fa-chevron-left text-muted"></i></button>
                            <h6 class="fw-bolder mb-0 text-primary" id="calendar-month-year">...</h6>
                            <button class="btn btn-sm btn-white rounded-circle shadow-sm" onclick="changeMonth(1)"><i class="fas fa-chevron-right text-muted"></i></button>
                        </div>
                        
                        <div class="text-center calendar-wrapper mb-3">
                            <div class="d-flex text-secondary small fw-bold mb-2">
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">R</div>
                                <div style="width: 14.28%">K</div>
                                <div style="width: 14.28%">J</div>
                                <div style="width: 14.28%">S</div>
                                <div style="width: 14.28%">M</div>
                            </div>
                            <div id="calendar-days" class="d-flex flex-wrap small text-dark">
                                <!-- JS Populated -->
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top scrollable-content" style="max-height: 120px;">
                            <h6 class="fw-bold small mb-2 text-muted text-uppercase" style="letter-spacing: 1px;">Agenda Mendatang</h6>
                            @forelse($upcomingAgendas as $agenda)
                                <div class="d-flex mb-2 align-items-center bg-light p-2 rounded-3">
                                    <div class="bg-{{ $agenda['color'] }} rounded-circle me-3" style="width:12px; height:12px; box-shadow: 0 0 5px var(--bs-{{ $agenda['color'] }});"></div>
                                    <div class="small fw-bold text-dark flex-grow-1">{{ $agenda['title'] }}</div>
                                    <span class="badge bg-white text-dark shadow-sm border">{{ \Carbon\Carbon::parse($agenda['date'])->format('d M') }}</span>
                                </div>
                            @empty
                                <div class="small text-muted text-center py-2 fw-semibold">Tidak ada agenda.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Feed / Perizinan --}}
            <div class="col-lg-4 col-md-12">
                <div class="bento-card h-100 fade-in" style="animation-delay: 0.4s;">
                    @if(Auth::user()->role === 'superadmin')
                        <div class="bg-transparent border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-warning text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px;">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h5 class="fw-bolder mb-0 text-dark">Perizinan</h5>
                            </div>
                            <span class="badge bg-danger rounded-pill shadow-sm">{{ count($pendingPerizinan) }} Baru</span>
                        </div>
                        <div class="p-4 pt-0 scrollable-content">
                            @if(count($pendingPerizinan) > 0)
                                <div class="position-relative ms-2">
                                    <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 6px; z-index: 1;"></div>
                                    @foreach($pendingPerizinan as $p)
                                    <div class="position-relative ps-4 mb-4 z-2">
                                        <div class="position-absolute bg-{{ $p['color'] }} border border-white border-2 rounded-circle shadow-sm" style="width: 16px; height: 16px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1 fw-bold">{{ \Carbon\Carbon::parse($p['waktu'])->diffForHumans() }} &bull; <span class="text-{{ $p['color'] }}">{{ $p['tipe'] }}</span></div>
                                        <div class="small fw-bolder text-dark bg-light p-2 rounded-3 mt-1">Diajukan: {{ $p['nama'] }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-check-circle fs-1 text-success mb-3 d-block opacity-50"></i>
                                    <span class="small fw-semibold">Tidak ada permintaan perizinan.</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-transparent border-0 pt-4 pb-3 px-4 d-flex align-items-center gap-2">
                            <div class="bg-info text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 35px; height: 35px;">
                                <i class="fas fa-history"></i>
                            </div>
                            <h5 class="fw-bolder mb-0 text-dark">Feed Aktivitas</h5>
                        </div>
                        <div class="p-4 pt-0 scrollable-content">
                            @if($feed->count() > 0)
                                <div class="position-relative ms-2">
                                    <div class="position-absolute border-start border-2 border-light" style="top: 10px; bottom: 10px; left: 6px; z-index: 1;"></div>
                                    @foreach($feed as $f)
                                    <div class="position-relative ps-4 mb-4 z-2">
                                        <div class="position-absolute bg-{{ $f['color'] }} border border-white border-2 rounded-circle shadow-sm" style="width: 16px; height: 16px; left: -1px; top: 3px;"></div>
                                        <div class="small text-muted mb-1 fw-bold">{{ \Carbon\Carbon::parse($f['time'])->diffForHumans() }} &bull; <span class="text-{{ $f['color'] }}">{{ $f['type'] }}</span></div>
                                        <div class="small fw-bolder text-dark bg-light p-2 rounded-3 mt-1">{{ $f['title'] }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-history fs-1 text-light mb-3 d-block"></i>
                                    <span class="small fw-semibold">Belum ada aktivitas terekam.</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

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
        
        renderCalendar();
        
        // Render Doughnut Chart
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Telat', 'Absen'],
                datasets: [{
                    data: [{{ $hadir }}, {{ $telat }}, {{ $absen }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'], // Modern Emerald, Amber, Rose
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                cutout: '78%',
                plugins: {
                    legend: { display: false },
                    tooltip: { 
                        enabled: true,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { size: 13, family: "'Nunito', sans-serif" },
                        bodyFont: { size: 14, family: "'Nunito', sans-serif", weight: 'bold' }
                    }
                },
                maintainAspectRatio: false
            }
        });
    });

    // --- KALENDER DINAMIS ---
    let currentDate = new Date();
    const events = @json($calendarEvents);
    const agendas = @json($upcomingAgendas);

    function renderCalendar() {
        const monthYearEl = document.getElementById('calendar-month-year');
        const daysEl = document.getElementById('calendar-days');
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        monthYearEl.innerText = `${monthNames[month]} ${year}`;
        
        // Mulai hari Senin (1)
        let firstDay = new Date(year, month, 1).getDay() - 1;
        if(firstDay === -1) firstDay = 6; // Jika Minggu(0), jadi 6
        
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        const isCurrentMonth = (today.getMonth() === month && today.getFullYear() === year);
        
        daysEl.innerHTML = '';
        
        for(let i=0; i<firstDay; i++) {
            daysEl.innerHTML += `<div class="calendar-day empty"></div>`;
        }
        
        for(let i=1; i<=daysInMonth; i++) {
            let classes = "calendar-day";
            if(isCurrentMonth && i === today.getDate()) {
                classes += " today shadow-sm";
            }
            
            let dotHtml = '';
            let titleAttr = '';
            const serverDate = new Date();
            const isViewingServerMonth = (serverDate.getMonth() === month && serverDate.getFullYear() === year);

            if(isViewingServerMonth && events[i]) {
                // Cari nama event dari upcomingAgendas
                let matchingAgenda = agendas.find(a => {
                    if (typeof a.date === 'string' && a.date.length >= 10) {
                        let dateParts = a.date.substring(0, 10).split('-');
                        if (dateParts.length === 3) {
                            let y = parseInt(dateParts[0]);
                            let m = parseInt(dateParts[1]) - 1;
                            let d = parseInt(dateParts[2]);
                            return d === i && m === month && y === year;
                        }
                    }
                    let d = new Date(a.date);
                    return d.getDate() === i && d.getMonth() === month && d.getFullYear() === year;
                });

                if(matchingAgenda) {
                    titleAttr = `data-bs-toggle="tooltip" data-bs-placement="top" title="${matchingAgenda.title}"`;
                }

                if(!(isCurrentMonth && i === today.getDate())) {
                    dotHtml = `<div class="calendar-label bg-${events[i]} shadow-sm"></div>`;
                }
            }
            daysEl.innerHTML += `<div class="${classes}" ${titleAttr}>${i}${dotHtml}</div>`;
        }

        // Inisialisasi Bootstrap Tooltip untuk kalender
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = document.querySelectorAll('#calendar-days [data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    }

    function changeMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        renderCalendar();
    }
</script>
@endsection
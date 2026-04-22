<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard.progress') }}" class="logo">
                <img src="{{ asset('assets/img/arsa/arsa_logo_white.png') }}" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            @php
                $role = auth()->user()->role;
                $pendingCount = $role === 'superadmin' 
                    ? \App\Models\DownloadRequest::where('status', 'pending')->count() 
                    : 0;

                $approvedCount = $role === 'marketing' 
                    ? auth()->user()->unreadNotifications->count() 
                    : 0;
            @endphp
            
            <ul class="nav nav-secondary">
                
                {{-- ================= MENU DASHBOARD ================= --}}
                @php $isDashboard = request()->routeIs(['dashboard.*', 'pipeline', 'revenue', 'data-kpi', 'simulasi-gaji']); @endphp
                <li class="nav-item {{ $isDashboard ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboard" class="{{ $isDashboard ? '' : 'collapsed' }}" aria-expanded="{{ $isDashboard ? 'true' : 'false' }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isDashboard ? 'show' : '' }}" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('dashboard.progress') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.progress') }}">
                                    <span class="sub-item">Dashboard</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pipeline') ? 'active' : '' }}">
                                <a href="{{ route('pipeline') }}">
                                    <span class="sub-item">Pipeline Marketing</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('revenue') ? 'active' : '' }}">
                                <a href="{{ route('revenue') }}">
                                    <span class="sub-item">Revenue</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('data-kpi') ? 'active' : '' }}">
                                <a href="{{ route('data-kpi') }}">
                                    <span class="sub-item">Data KPI</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('simulasi-gaji') ? 'active' : '' }}">
                                <a href="{{ route('simulasi-gaji') }}">
                                    <span class="sub-item">Simulasi Gaji</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- ================= SECTION: MENU ADMIN ================= --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu Admin</h4>
                </li>

                {{-- Menu Human Resources --}}
                @php $isHR = request()->routeIs(['user', 'penggajian.index', 'absensi']); @endphp
                <li class="nav-item {{ $isHR ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#human-resources" class="{{ $isHR ? '' : 'collapsed' }}" aria-expanded="{{ $isHR ? 'true' : 'false' }}">
                        <i class="fas fa-users"></i>
                        <p>Human Resources</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isHR ? 'show' : '' }}" id="human-resources">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                                <a href="{{ route('user') }}">
                                    <span class="sub-item">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                <a href="{{ route('penggajian.index') }}">
                                    <span class="sub-item">Penggajian</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('absensi') ? 'active' : '' }}">
                                <a href="{{ route('absensi') }}">
                                    <span class="sub-item">Absensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Menu Marketing & Sales --}}
                @php $isMarketing = request()->routeIs(['form-prospek', 'form-cta-massal', 'data-masuk.index', 'master-training.index']); @endphp
                <li class="nav-item {{ $isMarketing ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#marketing-sales" class="{{ $isMarketing ? '' : 'collapsed' }}" aria-expanded="{{ $isMarketing ? 'true' : 'false' }}">
                        <i class="fas fa-chart-line"></i>
                        <p>Marketing & Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isMarketing ? 'show' : '' }}" id="marketing-sales">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('form-prospek') ? 'active' : '' }}">
                                <a href="{{ route('form-prospek') }}">
                                    <span class="sub-item">Tambah Data Prospek</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('form-cta-massal') ? 'active' : '' }}">
                                <a href="{{ route('form-cta-massal') }}">
                                    <span class="sub-item">Tambah Data CTA Massal</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('data-masuk.index') ? 'active' : '' }}">
                                <a href="{{ route('data-masuk.index') }}">
                                    <span class="sub-item">Data Masuk</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('master-training.index') ? 'active' : '' }}">
                                <a href="{{ route('master-training.index') }}">
                                    <span class="sub-item">Data Pelatihan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Menu Operasional (Admin & Superadmin Only) --}}
                @if (in_array($role, ['superadmin','operasional','team_leader','web_dev']))
                    @php $isOperational = request()->routeIs(['operational.aktivitas-harian', 'operational.data-pendaftaran', 'operational.inventaris', 'operational.monitoring-paket']); @endphp
                    <li class="nav-item {{ $isOperational ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#operasional" class="{{ $isOperational ? '' : 'collapsed' }}" aria-expanded="{{ $isOperational ? 'true' : 'false' }}">
                            <i class="fas fa-tasks"></i>
                            <p>Operational</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $isOperational ? 'show' : '' }}" id="operasional">
                            <ul class="nav nav-collapse">
                                {{-- Menu Aktivitas Harian (Bisa diakses semua role operasional) --}}
                                <li class="{{ request()->routeIs('operational.aktivitas-harian') ? 'active' : '' }}">
                                    <a href="{{ route('operational.aktivitas-harian') }}">
                                        <span class="sub-item">Aktivitas Harian</span>
                                    </a>
                                </li>
                        
                                {{-- Menu Registrasi Peserta --}}
                                {{-- Hanya: admin, pic, team_leader, superadmin, web_dev --}}
                                @if(in_array(auth()->user()->role, ['admin', 'pic', 'team_leader', 'superadmin', 'web_dev']))
                                    <li class="{{ request()->routeIs('operational.data-pendaftaran') ? 'active' : '' }}">
                                        <a href="{{ route('operational.data-pendaftaran') }}">
                                            <span class="sub-item">Registrasi Peserta</span>
                                        </a>
                                    </li>
                                @endif
                        
                                {{-- Menu Aset & Inventaris DAN Monitoring Paket --}}
                                {{-- Hanya: team_leader, superadmin, web_dev --}}
                                @if(in_array(auth()->user()->role, ['team_leader', 'superadmin', 'web_dev']))
                                    <li class="{{ request()->routeIs('operational.inventaris') ? 'active' : '' }}">
                                        <a href="{{ route('operational.inventaris') }}">
                                            <span class="sub-item">Aset & Inventaris</span>
                                        </a>
                                    </li>
                                    
                                    <li class="{{ request()->routeIs('operational.monitoring-paket') ? 'active' : '' }}">
                                        <a href="{{ route('operational.monitoring-paket') }}">
                                            <span class="sub-item">Monitoring Paket</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                

                {{-- Menu Download --}}
                @php $isDownload = request()->routeIs(['download.approval', 'download.my']); @endphp
                <li class="nav-item {{ $isDownload ? 'active' : '' }}">
                    @if ($role === 'superadmin')
                        <a href="{{ route('download.approval') }}">
                            <i class="fas fa-download"></i>
                            <p>Download Approval</p>
                            @if ($pendingCount > 0)
                                <span class="badge badge-danger">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('download.my') }}">
                            <i class="fas fa-download"></i>
                            <p>My Downloads</p>
                            @if ($approvedCount > 0)
                                <span class="badge badge-danger">{{ $approvedCount }}</span>
                            @endif
                        </a>
                    @endif
                </li>
                
                {{-- ================= MENU PORTAL BACK OFFICE ================= --}}
                {{-- Khusus untuk role: operasional dan team_leader --}}
                @if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev', 'superadmin']))
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Back Office</h4>
                    </li>
                    <li class="nav-item {{ request()->routeIs('operational') ? 'active' : '' }}">
                        <a href="{{ route('operational') }}">
                            <i class="fas fa-layer-group"></i>
                            <p>Portal Back Office</p>
                            <span class="badge badge-dark">Internal</span>
                        </a>
                    </li>
                @endif
                
                {{-- ================= MENU BRANKAS AKUN (PRIVATE) ================= --}}
                @php
                    // Daftar nama yang diizinkan sesuai database kamu
                    $allowedNames = ['direktur', 'Desainer Grafis'];
                @endphp
                
                @if(in_array(auth()->user()->name, $allowedNames))
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Privasi</h4>
                    </li>
                
                    <li class="nav-item {{ request()->routeIs('akun.index') ? 'active' : '' }}">
                        <a href="{{ route('akun.index') }}">
                            <i class="fas fa-key"></i>
                            <p>Brankas Akun</p>
                            <span class="badge badge-dark">Private</span>
                        </a>
                    </li>
                @endif

                {{-- ================= SECTION: BANTUAN ================= --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Bantuan</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('panduan.index') ? 'active' : '' }}">
                    <a href="{{ route('panduan.index') }}">
                        <i class="fas fa-info-circle"></i>
                        <p>Panduan Dashboard</p>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
<style>
    /* =========================================================
       ANIMASI MODERN SIDEBAR KAIADMIN (Tanpa merusak layout)
       ========================================================= */
       
    /* 1. Transisi dasar agar pergerakan halus */
    .sidebar .nav > .nav-item > a,
    .sidebar .nav-collapse li > a {
        transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease !important;
    }

    /* 2. Efek Hover Utama: Bergeser halus ke kanan (Smooth Slide) */
    .sidebar .nav > .nav-item > a:hover {
        transform: translateX(6px);
    }

    /* 3. Efek Hover Sub-menu: Bergeser sedikit lebih kecil */
    .sidebar .nav-collapse li > a:hover {
        transform: translateX(4px);
    }

    /* 4. Efek 'ditekan' (scale down) saat menu sedang aktif */
    .sidebar .nav > .nav-item.active > a {
        animation: popClick 0.4s ease forwards;
    }

    @keyframes popClick {
        0% { transform: scale(1); }
        50% { transform: scale(0.97); }
        100% { transform: scale(1); }
    }
</style>

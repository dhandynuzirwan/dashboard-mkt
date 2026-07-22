<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo">
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

                $approvedCount = $role !== 'superadmin' 
                    ? auth()->user()->unreadNotifications->where('type', 'App\Notifications\DownloadApprovedNotification')->count() 
                    : 0;
                    
                $dealCount = in_array($role, ['team_leader', 'operasional'])
                    ? auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewDealNotification')->count()
                    : 0;

                $lemburPendingCount = 0;
                if (in_array($role, ['spv_marketing', 'team_leader'])) {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_spv', 'pending')->count();
                } elseif ($role === 'hrd') {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_spv', 'approved')
                        ->where('status_hrd', 'pending')->count();
                } elseif ($role === 'superadmin') {
                    $lemburPendingCount = \App\Models\PengajuanLembur::where('status_hrd', 'approved')
                        ->where('status_direktur', 'pending')->count();
                }
            @endphp
            
            <ul class="nav nav-secondary">
                
                {{-- ================= MENU DASHBOARD ================= --}}
                @php $isDashboard = request()->routeIs(['home', 'pegawai.absensi.index', 'pengajuan-izin.index', 'pengajuan-izin.create']); @endphp
                <li class="nav-item {{ $isDashboard ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboard" class="{{ $isDashboard ? '' : 'collapsed' }}" aria-expanded="{{ $isDashboard ? 'true' : 'false' }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isDashboard ? 'show' : '' }}" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">
                                    <span class="sub-item">Home</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pegawai.absensi.index') ? 'active' : '' }}">
                                <a href="{{ route('pegawai.absensi.index') }}">
                                    <span class="sub-item">Absensi Online</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pengajuan-izin.*') ? 'active' : '' }}">
                                <a href="{{ route('pengajuan-izin.index') }}">
                                    <span class="sub-item">Pengajuan Izin / Cuti</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pengajuan-lembur.*') ? 'active' : '' }}">
                                <a href="{{ route('pengajuan-lembur.index') }}">
                                    <span class="sub-item">Pengajuan Lembur</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                                {{-- ================= MENU PERFORMANCE & FINANCE ================= --}}
                @if(in_array($role, ['superadmin', 'web_dev', 'spv_marketing', 'admin', 'rnd', 'marketing', 'performance']))
                    @php $isPerformance = request()->routeIs(['dashboard.progress', 'performance.display', 'revenue', 'data-kpi', 'simulasi-gaji', 'parameter-finansial.*', 'master-artikel.*', 'master-instruktur.*', 'master-proposal.*']); @endphp
                    <li class="nav-item {{ $isPerformance ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#performance" class="{{ $isPerformance ? '' : 'collapsed' }}" aria-expanded="{{ $isPerformance ? 'true' : 'false' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Performance</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $isPerformance ? 'show' : '' }}" id="performance">
                            <ul class="nav nav-collapse">
                                @if(in_array($role, ['superadmin', 'spv_marketing', 'admin', 'performance']))
                                <li class="{{ request()->routeIs('dashboard.progress') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.progress') }}">
                                        <span class="sub-item">Dashboard Progress</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['superadmin', 'performance']))
                                <li class="{{ request()->routeIs('performance.display') ? 'active' : '' }}">
                                    <a href="{{ route('performance.display') ?? '#' }}"> 
                                        <span class="sub-item">On Display Monitor</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['superadmin', 'marketing', 'web_dev', 'performance']))
                                <li class="{{ request()->routeIs('revenue') ? 'active' : '' }}">
                                    <a href="{{ route('revenue') }}">
                                        <span class="sub-item">Revenue</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['superadmin', 'spv_marketing', 'marketing', 'web_dev', 'performance']))
                                <li class="{{ request()->routeIs('data-kpi') ? 'active' : '' }}">
                                    <a href="{{ route('data-kpi') }}">
                                        <span class="sub-item">Data KPI</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['superadmin', 'marketing', 'web_dev', 'performance']))
                                <li class="{{ request()->routeIs('simulasi-gaji') ? 'active' : '' }}">
                                    <a href="{{ route('simulasi-gaji') }}">
                                        <span class="sub-item">Skema Penggajian</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['superadmin', 'spv_marketing', 'performance']))
                                <li class="{{ request()->routeIs('parameter-finansial.*') ? 'active' : '' }}">
                                    <a href="{{ route('parameter-finansial.index') }}">
                                        <span class="sub-item">Nilai Target Omset</span>
                                    </a>
                                </li>
                                @endif
                                
                                @if(in_array($role, ['rnd', 'superadmin', 'spv_marketing', 'admin']))
                                <li class="{{ request()->routeIs('master-artikel.*') ? 'active' : '' }}">
                                    <a href="{{ route('master-artikel.index') }}">
                                        <span class="sub-item">Master Artikel</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('master-instruktur.*') ? 'active' : '' }}">
                                    <a href="{{ route('master-instruktur.index') }}">
                                        <span class="sub-item">Master Instruktur/Narasumber</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('master-proposal.*') ? 'active' : '' }}">
                                    <a href="{{ route('master-proposal.index') }}">
                                        <span class="sub-item">Master Proposal Penawaran</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                                @if(in_array($role, ['superadmin', 'web_dev', 'hrd']))
{{-- ================= MENU HUMAN RESOURCES ================= --}}
                @php $isHR = request()->routeIs(['user', 'penggajian.index', 'absensi', 'approval-izin.index', 'pengumuman.*']); @endphp
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
                                    <span class="sub-item">Data Absensi Internal</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('approval-izin.*') ? 'active' : '' }}">
                                <a href="{{ route('approval-izin.index') }}">
                                    <span class="sub-item">Approval Izin / Cuti</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('pengumuman.*') ? 'active' : '' }}">
                                <a href="{{ route('pengumuman.index') }}">
                                    <span class="sub-item">Papan Pengumuman</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                
                @if($role !== 'finance')

                {{-- ================= MENU MARKETING & SALES ================= --}}
                @if(in_array($role, ['superadmin', 'web_dev', 'spv_marketing', 'admin', 'marketing', 'rnd', 'digitalmarketing', 'performance']))
                @php $isMarketing = request()->routeIs(['pipeline', 'form-prospek', 'form-cta-massal', 'data-masuk.index', 'master-training.index']); @endphp
                <li class="nav-item {{ $isMarketing ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#marketing-sales" class="{{ $isMarketing ? '' : 'collapsed' }}" aria-expanded="{{ $isMarketing ? 'true' : 'false' }}">
                        <i class="fas fa-chart-line"></i>
                        <p>Marketing & Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isMarketing ? 'show' : '' }}" id="marketing-sales">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('pipeline') ? 'active' : '' }}">
                                <a href="{{ route('pipeline') }}">
                                    <span class="sub-item">Pipeline Marketing</span>
                                </a>
                            </li>

                            @if($role !== 'performance')
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
                            @endif
                            <li class="{{ request()->routeIs('data-masuk.index') ? 'active' : '' }}">
                                <a href="{{ route('data-masuk.index') }}">
                                    <span class="sub-item">Database Masuk</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('master-training.index') ? 'active' : '' }}">
                                <a href="{{ route('master-training.index') }}">
                                    <span class="sub-item">Master Pelatihan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @endif

                {{-- ================= MENU OPERATIONAL ================= --}}
                @if (in_array($role, ['superadmin','operasional','team_leader','web_dev','spv_marketing','graphic','performance']))
                    @php $isOperational = request()->routeIs(['operational.aktivitas-harian', 'operational.data-pendaftaran', 'operational.inventaris', 'operational.monitoring-paket', 'monitoring.pelatihan', 'riwayat.pelatihan']); @endphp
                    <li class="nav-item {{ $isOperational ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#operasional" class="{{ $isOperational ? '' : 'collapsed' }}" aria-expanded="{{ $isOperational ? 'true' : 'false' }}">
                            <i class="fas fa-tasks"></i>
                            <p>Operational</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $isOperational ? 'show' : '' }}" id="operasional">
                            <ul class="nav nav-collapse">
                                @if(in_array($role, ['superadmin', 'operasional', 'team_leader', 'web_dev', 'graphic']))
                                <li class="{{ request()->routeIs('operational.aktivitas-harian') ? 'active' : '' }}">
                                    <a href="{{ route('operational.aktivitas-harian') }}">
                                        <span class="sub-item">Aktivitas Harian</span>
                                    </a>
                                </li>
                                @endif
                        
                                @if(in_array(auth()->user()->role, ['admin', 'operasional', 'team_leader', 'superadmin', 'web_dev', 'spv_marketing', 'graphic']))
                                    <li class="{{ request()->routeIs('operational.data-pendaftaran') ? 'active' : '' }}">
                                        <a href="{{ route('operational.data-pendaftaran') }}">
                                            <span class="sub-item">Registrasi Peserta</span>
                                            @if ($dealCount > 0)
                                                <span class="badge badge-success">{{ $dealCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                
                                <li class="{{ request()->routeIs('monitoring.pelatihan') ? 'active' : '' }}">
                                    <a href="{{ route('monitoring.pelatihan') }}">
                                        <span class="sub-item">Pelatihan Berjalan</span>
                                        <span class="badge badge-dark">Beta</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('riwayat.pelatihan') ? 'active' : '' }}">
                                    <a href="{{ Route::has('riwayat.pelatihan') ? route('riwayat.pelatihan') : '#' }}">
                                        <span class="sub-item">Riwayat Pelatihan</span>
                                        <span class="badge badge-dark">Beta</span>
                                    </a>
                                </li>
                        
                                @if(in_array(auth()->user()->role, ['team_leader', 'superadmin', 'web_dev', 'operasional', 'graphic']))
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
                
                {{-- ================= MENU DOWNLOAD ================= --}}
                @php $isDownload = request()->routeIs(['download.approval', 'download.my']); @endphp
                <li class="nav-item {{ $isDownload ? 'active' : '' }}">
                    <a href="{{ route('download.approval') }}">
                        <i class="fas fa-file-download"></i>
                        <p>{{ in_array($role, ['superadmin']) ? 'Download Approval' : 'Riwayat Download' }}</p>
                        @if ($pendingCount > 0 && in_array($role, ['superadmin']))
                            <span class="badge badge-danger">{{ $pendingCount }}</span>
                        @endif
                        @if ($approvedCount > 0 && $role !== 'superadmin')
                            <span class="badge badge-success">{{ $approvedCount }}</span>
                        @endif
                    </a>
                </li>
                
                {{-- ================= MENU APPROVAL LEMBUR ================= --}}
                @if(in_array($role, ['team_leader', 'spv_marketing', 'hrd', 'superadmin']))
                <li class="nav-item {{ request()->routeIs('approval-lembur.*') ? 'active' : '' }}">
                    <a href="{{ route('approval-lembur.index') }}">
                        <i class="fas fa-clock"></i>
                        <p>Approval Lembur</p>
                        @if($lemburPendingCount > 0)
                            <span class="badge badge-warning">{{ $lemburPendingCount }}</span>
                        @endif
                    </a>
                </li>
                @endif
                {{-- ================= MENU MODUL PELATIHAN ================= --}}
                @if(in_array($role, ['superadmin', 'graphic', 'team_leader', 'admin', 'rnd']))
                @php $isModul = request()->routeIs(['modul.index']); @endphp
                <li class="nav-item {{ $isModul ? 'active' : '' }}">
                    <a href="{{ route('modul.index') }}">
                        <i class="fas fa-book"></i>
                        <p>Modul Pelatihan</p>
                    </a>
                </li>
                @endif
                
                {{-- ================= MENU PORTAL BACK OFFICE ================= --}}
                @if(in_array(auth()->user()->email, ['pic1@arsatraining.com', 'pic2@arsatraining.com']))
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
                    $allowedNames = ['Direktur PT Arsa Jaya Prima', 'Desainer Grafis'];
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
                
            @endif
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

    @@keyframes popClick {
        0% { transform: scale(1); }
        50% { transform: scale(0.97); }
        100% { transform: scale(1); }
    }
</style>
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
                $pendingCount = auth()->user()->role === 'superadmin'
                    ? \App\Models\DownloadRequest::where('status', 'pending')->count()
                    : 0;

                $approvedCount = auth()->user()->role === 'marketing' 
                    ? auth()->user()->unreadNotifications->count() 
                    : 0;
            @endphp
            
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('dashboard.*', 'pipeline', 'revenue', 'data-kpi', 'simulasi-gaji') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#dashboard"
                        class="{{ request()->routeIs('dashboard.*', 'pipeline', 'revenue', 'data-kpi', 'simulasi-gaji') ? '' : 'collapsed' }}"
                        aria-expanded="{{ request()->routeIs('dashboard.*', 'pipeline', 'revenue', 'data-kpi', 'simulasi-gaji') ? 'true' : 'false' }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('dashboard.*', 'pipeline', 'revenue', 'data-kpi', 'simulasi-gaji') ? 'show' : '' }}" id="dashboard">
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

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu Admin</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('user', 'penggajian', 'absensi') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#human-resources"
                        class="{{ request()->routeIs('user', 'penggajian', 'absensi') ? '' : 'collapsed' }}"
                        aria-expanded="{{ request()->routeIs('user', 'penggajian', 'absensi') ? 'true' : 'false' }}">
                        <i class="fas fa-server"></i>
                        <p>Human Resources</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('user', 'penggajian', 'absensi') ? 'show' : '' }}" id="human-resources">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                                <a href="{{ route('user') }}">
                                    <span class="sub-item">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('penggajian') ? 'active' : '' }}">
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

                <li class="nav-item {{ request()->routeIs('form-prospek', 'data-masuk', 'master-training') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#marketing-sales"
                        class="{{ request()->routeIs('form-prospek', 'data-masuk', 'master-training') ? '' : 'collapsed' }}"
                        aria-expanded="{{ request()->routeIs('form-prospek', 'data-masuk', 'master-training') ? 'true' : 'false' }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Marketing & Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('form-prospek', 'data-masuk.index', 'master-training.index') ? 'show' : '' }}" id="marketing-sales">
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

                <li class="nav-item {{ request()->routeIs('download.approval', 'download.my') ? 'active' : '' }}">
                    @if (auth()->user()->role === 'superadmin')
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

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Bantuan</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('panduan.index') ? 'active' : '' }}">
                    <a href="{{ route('panduan.index') }}">
                        <i class="fas fa-question-circle"></i>
                        <p>Panduan Dashboard</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
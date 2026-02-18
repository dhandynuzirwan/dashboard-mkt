
<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img
            {{-- src="assets/img/kaiadmin/logo_light.svg" --}}
            alt="navbar brand"
            class="navbar-brand"
            height="20"
            />
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
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item active">
            <a
                data-bs-toggle="collapse"
                href="#dashboard"
                class="collapsed"
                aria-expanded="false"
            >
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="dashboard">
                <ul clas                    <a href="{{ route('dashboard.progress') }}">
                    <span class="sub-item">Dashboard Progress</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('revenue') }}">
                    <span class="sub-item">Revenue</span>
                    </a>
                </li>
                <li>
                <a href="{{ route('data-kpi') }}">
                    <span class="sub-item">Data KPI</span>
                    </a>
                </li>
                <li>
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
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#human-resources">
                    <i class="fas fa-server"></i>
                    <p>Human Resources</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="human-resources">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="{{ route('user') }}">
                            <span class="sub-item">Data Pengguna</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('penggajian') }}">
                            <span class="sub-item">Penggajian</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('absensi') }}">
                            <span class="sub-item">Absensi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#marketing-sales">
                    <i class="fas fa-layer-group"></i>
                    <p>Marketing & Sales</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="marketing-sales">
                    <ul class="nav nav-collapse">                        
                        <li>
                            <a href="{{ route('data-prospek') }}">
                            <span class="sub-item">Tambah Data Prospek</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pipeline') }}">
           </li>
                        <li>
                            <a href="components/buttons.html">
<li>
                            <a href="components/buttons.html">
                            <span class="sub-item">Pipeline Marketing</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
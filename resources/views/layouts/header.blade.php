@php
    // Hitung jumlah penawaran (CTA) yang masuk HARI INI saja
    $notifCount = \App\Models\Cta::whereDate('created_at', \Carbon\Carbon::today())->count();
    
    // Ambil 5 penawaran terbaru hari ini untuk ditampilkan di dropdown list
    $recentCtas = \App\Models\Cta::with('prospek')
                    ->whereDate('created_at', \Carbon\Carbon::today())
                    ->latest()
                    ->take(5)
                    ->get();
@endphp

<div class="main-header">
    <div class="main-header-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
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

    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <form action="{{ route('search.global') }}" method="GET" class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari prospek, penawaran, atau marketing..." class="form-control" />
                </form>
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </form>
                    </ul>
                </li>

                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if($notifCount > 0)
                            <span class="notification">{{ $notifCount }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                Ada {{ $notifCount }} Penawaran Baru Hari Ini
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    @forelse($recentCtas as $cta)
                                        <a href="{{ route('dashboard.progress') }}"> {{-- Arahkan ke dashboard untuk cek detail --}}
                                            <div class="notif-icon notif-primary">
                                                <i class="fa fa-file-invoice-dollar"></i>
                                            </div>
                                            <div class="notif-content">
                                                <span class="block fw-bold">
                                                    {{ $cta->prospek->nama_perusahaan ?? 'Penawaran Baru' }}
                                                </span>
                                                <span class="block small text-muted">
                                                    {{ $cta->judul_permintaan }} ({{ $cta->sertifikasi }})
                                                </span>
                                                <span class="time">{{ $cta->created_at->format('H:i') }}</span>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="text-center p-3 text-muted">
                                            <small>Belum ada penawaran masuk hari ini.</small>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="{{ route('dashboard.progress') }}">
                                Lihat Semua Progress <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $userRole = Auth::user()->role;
                    if ($userRole == 'superadmin') {
                        $avatarUrl = 'https://cdn-icons-png.flaticon.com/512/430/430876.png';
                        $badgeClass = 'badge-danger';
                    } elseif ($userRole == 'admin') {
                        $avatarUrl = 'https://cdn-icons-png.flaticon.com/512/999/999104.png';
                        $badgeClass = 'badge-primary';
                    } else {
                        $avatarUrl = 'https://cdn-icons-png.flaticon.com/512/14379/14379379.png';
                        $badgeClass = 'badge-success';
                    }
                @endphp

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ $avatarUrl }}" alt="profile" class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ $avatarUrl }}" alt="profile image" class="avatar-img rounded" />
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <span class="badge {{ $badgeClass }}">{{ strtoupper($userRole) }}</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
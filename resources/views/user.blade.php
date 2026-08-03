@extends('layouts.app') 

@section('content')
<style>
    /* Premium Modern CSS */
    .page-wrapper-modern {
        background-color: #f8f9fc;
        min-height: 100vh;
        font-family: 'Nunito', 'Segoe UI', sans-serif;
    }
    .glass-card {
        background: #ffffff;
        border: 1px solid rgba(227, 230, 240, 0.8);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }
    .table-custom { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px;}
    .table-custom tr { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 16px; transition: all 0.2s ease; border: 1px solid #f1f3f9;}
    .table-custom tr:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
    .table-custom td { padding: 18px 22px; border: none; vertical-align: middle;}
    .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-custom th { border: none; padding: 10px 22px; color: #858796; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; background: transparent;}

    .badge-soft-success { background-color: #e3fdf4; color: #0f9b6b; border: 1px solid #bcf2df; }
    .badge-soft-warning { background-color: #fff8e5; color: #d99a05; border: 1px solid #ffecb5; }
    .badge-soft-danger { background-color: #fee9e8; color: #e74a3b; border: 1px solid #fcd5d2; }
    .badge-soft-primary { background-color: #e8eff9; color: #4e73df; border: 1px solid #cdd8f6; }
    .badge-soft-info { background-color: #e3f8f9; color: #36b9cc; border: 1px solid #c7ecef; }
    .badge-soft-dark { background-color: #e9ecef; color: #343a40; border: 1px solid #dee2e6; }

    .file-card {
        border: 1px solid #eaecf4;
        border-radius: 12px;
        padding: 15px;
        transition: all 0.2s ease;
        background: #fdfdfe;
    }
    .file-card:hover {
        border-color: #cdd8f6;
        background: #f4f7fe;
    }
    .file-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
</style>

<div class="page-wrapper-modern py-4">
    <div class="container-fluid px-4">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pb-4 justify-content-between">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="font-size: 24px;">Data Pengguna</h3>
                <h6 class="text-muted mb-0">Manajemen Hak Akses & Akun Sistem</h6>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <div class="glass-card px-4 py-2 d-flex align-items-center">
                    <i class="fas fa-clock text-primary me-2"></i> 
                    <span id="realtime-clock" class="fw-bold text-dark small">Memuat waktu...</span>
                </div>
                <a href="{{ route('form-tambah-pengguna') }}" class="btn btn-primary d-flex align-items-center shadow-sm" style="border-radius: 12px; font-weight: 600;">
                    <i class="fa fa-plus me-2"></i> Tambah Pengguna
                </a>
            </div>
        </div>

        {{-- ================= TABEL DATA PENGGUNA ================= --}}
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="35%">INFORMASI PENGGUNA</th>
                        <th width="20%">KONTAK</th>
                        <th class="text-center" width="15%">HAK AKSES</th>
                        <th class="text-center" width="15%">STATUS BERKAS</th>
                        <th class="text-center" width="15%">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            {{-- Kolom 1: Profil & Nama --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3 flex-shrink-0" style="width: 55px; height: 55px;">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Profil" class="avatar-img rounded-circle object-fit-cover shadow-sm border" style="width: 100%; height: 100%; border-color: #eaecf4 !important;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded-circle shadow-sm fw-bold text-white fs-4" style="width: 100%; height: 100%; background: linear-gradient(135deg, #4e73df, #224abe);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bolder text-dark" style="font-size: 16px;">{{ $user->name }}</div>
                                        @if($user->nama_lengkap)
                                            <div class="text-muted small"><i class="fas fa-id-card me-1 text-primary"></i> {{ $user->nama_lengkap }}</div>
                                        @else
                                            <div class="text-muted small fst-italic">Nama panggilan belum diisi</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom 2: Kontak --}}
                            <td>
                                <div style="font-size: 13px; line-height: 1.8;">
                                    <div class="text-dark"><i class="fas fa-envelope text-secondary me-2" style="width: 16px;"></i> {{ $user->email }}</div>
                                    <div class="text-dark"><i class="fab fa-whatsapp text-success me-2" style="width: 16px;"></i> {{ $user->no_hp ?? '-' }}</div>
                                </div>
                            </td>

                            {{-- Kolom 3: Role --}}
                            <td class="text-center">
                                @php
                                    $roleBadge = match(strtolower($user->role)) {
                                        'superadmin' => 'badge-soft-danger',
                                        'admin' => 'badge-soft-primary',
                                        'rnd' => 'badge-soft-info',
                                        'marketing' => 'badge-soft-success',
                                        'digitalmarketing' => 'badge-soft-warning',
                                        'operasional' => 'badge-soft-dark',
                                        'team_leader' => 'badge-soft-dark',
                                        'web_dev' => 'badge-soft-danger',
                                        'hrd' => 'badge-soft-warning',
                                        default => 'badge-soft-dark',
                                    };
                                @endphp
                                <span class="badge {{ $roleBadge }} px-3 py-2 rounded-pill fw-bold" style="font-size: 11px;">
                                    <i class="fas fa-user-shield me-1"></i> {{ strtoupper($user->role) }}
                                </span>
                            </td>

                            {{-- Kolom 4: Status Berkas --}}
                            <td class="text-center">
                                @php
                                    $berkasList = ['ktp_file', 'ijasah_file', 'pas_foto_file', 'kk_file', 'jobdesk_file', 'sop_file'];
                                    $berkasTerisi = 0;
                                    foreach($berkasList as $berkas) {
                                        if(!empty($user->$berkas)) $berkasTerisi++;
                                    }
                                    $isLengkap = ($berkasTerisi == count($berkasList));
                                @endphp

                                @if($isLengkap)
                                    <div class="badge badge-soft-success px-3 py-2 rounded-pill fw-bold mb-1" style="font-size: 11px;">
                                        <i class="fas fa-check-circle me-1"></i> Lengkap
                                    </div>
                                @else
                                    <div class="badge badge-soft-warning px-3 py-2 rounded-pill fw-bold mb-1" style="font-size: 11px;">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $berkasTerisi }}/6 Berkas
                                    </div>
                                @endif
                                <br>
                                <button class="btn btn-sm btn-link text-primary p-0 fw-bold" style="font-size: 12px; text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalBerkas{{ $user->id }}">
                                    <i class="fas fa-folder-open me-1"></i> Lihat Berkas
                                </button>
                            </td>

                            {{-- Kolom 5: Action --}}
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px; border: 1px solid #e3e6f0;">
                                        <i class="fas fa-ellipsis-h text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                        <li>
                                            <a class="dropdown-item py-2 rounded-3" href="{{ route('user.edit', $user->id) }}">
                                                <i class="fas fa-edit text-info me-2"></i> Edit Data
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }} secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 rounded-3 text-danger border-0 bg-transparent" style="width: 100%; text-align: left;">
                                                    <i class="fas fa-trash me-2"></i> Hapus Permanen
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" width="150" class="mb-3 opacity-50">
                                <h6 class="fw-bolder text-muted mb-0">Belum ada data pengguna di dalam sistem.</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        @if($users->hasPages())
            <div class="d-flex justify-content-center py-4">
                {{ $users->links('partials.pagination') }}
            </div>
        @endif
        
    </div>
</div>

{{-- ================= MODAL BERKAS PENGGUNA ================= --}}
@foreach($users as $user)
<div class="modal fade" id="modalBerkas{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fa fa-folder-open me-2"></i> Dokumen & Berkas: {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                
                @php
                    $berkasDef = [
                        'ktp_file' => ['title' => 'KTP', 'icon' => 'fa-address-card', 'color' => 'primary'],
                        'kk_file' => ['title' => 'Kartu Keluarga', 'icon' => 'fa-users', 'color' => 'info'],
                        'ijasah_file' => ['title' => 'Ijazah', 'icon' => 'fa-graduation-cap', 'color' => 'success'],
                        'pas_foto_file' => ['title' => 'Pas Foto', 'icon' => 'fa-image', 'color' => 'warning'],
                        'jobdesk_file' => ['title' => 'Jobdesk', 'icon' => 'fa-tasks', 'color' => 'danger'],
                        'sop_file' => ['title' => 'SOP', 'icon' => 'fa-file', 'color' => 'secondary'],
                    ];
                @endphp

                <div class="row g-3">
                    @foreach($berkasDef as $field => $meta)
                        <div class="col-md-6 col-lg-4">
                            <div class="file-card h-100 d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="file-icon bg-{{ $meta['color'] }} bg-opacity-10 text-{{ $meta['color'] }} me-3">
                                        <i class="fa {{ $meta['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 14px;">{{ $meta['title'] }}</div>
                                        @if(!empty($user->$field))
                                            <div class="badge bg-success" style="font-size: 10px;">Tersedia</div>
                                        @else
                                            <div class="badge bg-secondary" style="font-size: 10px;">Kosong</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    @if(!empty($user->$field))
                                        @php
                                            $ext = strtolower(pathinfo($user->$field, PATHINFO_EXTENSION));
                                            $isImage = in_array($ext, ['jpg','jpeg','png','webp','gif']);
                                        @endphp
                                        <a href="{{ asset('storage/' . $user->$field) }}" target="_blank" class="btn btn-sm btn-outline-{{ $meta['color'] }} w-100 fw-bold">
                                            @if($isImage)
                                                <i class="fa fa-image me-1"></i> Lihat Gambar
                                            @else
                                                <i class="fa fa-file-pdf me-1"></i> Buka Dokumen
                                            @endif
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-light w-100 text-muted" disabled>
                                            <i class="fa fa-times me-1"></i> Belum Diunggah
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
            <div class="modal-footer border-top bg-white rounded-bottom-4 py-3 px-4">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary px-4 fw-bold"><i class="fa fa-upload me-1"></i> Lengkapi Berkas</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const clockEl = document.getElementById('realtime-clock');
        if(clockEl) {
            clockEl.innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
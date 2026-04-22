@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data Pengguna</h3>
                <h6 class="op-7 mb-2">Manajemen Hak Akses & Akun Sistem</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info px-3 py-2 mt-1" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= TABEL DATA PENGGUNA ================= --}}
        <div class="card card-round mb-4 border-0 shadow-sm">
            
            <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                <div class="card-title fw-bold m-0">
                    Daftar Pengguna Aktif
                </div>
                <a href="{{ route('form-tambah-pengguna') }}" class="btn btn-success btn-sm ms-auto shadow-sm">
                    <i class="fa fa-plus me-1"></i> Tambah Pengguna
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th>INFORMASI PENGGUNA</th>
                                <th>KONTAK</th>
                                <th class="text-center">HAK AKSES (ROLE)</th>
                                <th class="text-center pe-4" width="160">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="border-bottom">

                                    {{-- Kolom 2: Profil & Nama --}}
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            {{-- Hapus avatar-sm, ganti pakai ukuran custom 50px --}}
                                            <div class="avatar me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                                @if($user->foto_profil)
                                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Profil" class="avatar-img rounded-circle object-fit-cover shadow-sm" style="width: 100%; height: 100%;">
                                                @else
                                                    <span class="avatar-title rounded-circle bg-primary-gradient fw-bold text-white shadow-sm fs-4">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark" style="font-size: 15px;">{{ $user->name }}</span><br>
                                                @if($user->nama_lengkap)
                                                    <small class="text-muted"><i class="fas fa-id-card me-1"></i> {{ $user->nama_lengkap }}</small>
                                                @else
                                                    <small class="text-muted fst-italic">Nama KTP belum diisi</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Kontak (Email & HP) --}}
                                    <td>
                                        <div style="font-size: 13px; line-height: 1.6;">
                                            <div><i class="fas fa-envelope text-secondary me-2"></i> {{ $user->email }}</div>
                                            <div><i class="fab fa-whatsapp text-success me-2"></i> {{ $user->no_hp ?? '-' }}</div>
                                        </div>
                                    </td>

                                    {{-- Kolom 4: Role (Pake Warna Badge) --}}
                                    <td class="text-center">
                                        @php
                                            $roleColor = match(strtolower($user->role)) {
                                                'superadmin' => 'bg-danger',
                                                'admin' => 'bg-primary',
                                                'rnd' => 'bg-info',
                                                'marketing' => 'bg-success',
                                                'digitalmarketing' => 'bg-warning text-dark',
                                                'operasional' => 'bg-secondary',
                                                'team_leader' => 'bg-dark',
                                                'web_dev' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $roleColor }} px-3 py-2 shadow-sm" style="font-size: 11px; letter-spacing: 0.5px;">
                                            <i class="fas fa-user-shield me-1"></i> {{ strtoupper($user->role) }}
                                        </span>
                                    </td>

                                    {{-- Kolom 5: Action --}}
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data pengguna {{ $user->name }}?')">
                                                    <i class="fa fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-users-slash fs-3 mb-2 opacity-50"></i><br>
                                        Belum ada data pengguna di dalam sistem.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- ================= PAGINATION ================= --}}
                @if($users->hasPages())
                    <div class="d-flex justify-content-center py-4 bg-light border-top">
                        {{ $users->links('partials.pagination') }}
                    </div>
                @endif
                {{-- ================= END PAGINATION ================= --}}
            </div>
        </div>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
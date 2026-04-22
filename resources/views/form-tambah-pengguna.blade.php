@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data Pengguna</h3>
                <h6 class="op-7 mb-2">Formulir Tambah Pengguna Baru</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info px-3 py-2 mt-1" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= FORM SECTION ================= --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 border-0 shadow-sm">

                    <div class="card-header bg-white border-bottom py-3">
                        <div class="card-title fw-bold m-0">
                            <i class="fas fa-user-plus text-primary me-2"></i> Form Tambah Pengguna
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- ALERT ERROR VALIDATION --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                {{-- NAMA --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="name" class="fw-bold mb-1">Nama Panggilan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan Nama Panggilan" value="{{ old('name') }}" required>
                                </div>
                                
                                {{-- NAMA LENGKAP --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap" class="fw-bold mb-1">Nama Lengkap (KTP)</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                        value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}" 
                                        placeholder="Masukkan Nama Lengkap Sesuai KTP">
                                </div>

                                {{-- NOMOR HP / WHATSAPP --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="no_hp" class="fw-bold mb-1">No. HP / WhatsApp</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" 
                                        value="{{ old('no_hp', $user->no_hp ?? '') }}" 
                                        placeholder="Contoh: 081234567890">
                                </div>

                                {{-- EMAIL --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan Email Aktif" value="{{ old('email') }}" required>
                                </div>

                                {{-- PASSWORD --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="password" class="fw-bold mb-1">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Buat Password" required>
                                </div>

                                {{-- ROLE --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="role" class="fw-bold mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select class="form-select form-control" id="role" name="role" required>
                                        <option value="">-- Pilih Hak Akses --</option>
                                        <option value="superadmin" {{ old('role', $user->role ?? '') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="marketing" {{ old('role', $user->role ?? '') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="rnd" {{ old('role', $user->role ?? '') == 'rnd' ? 'selected' : '' }}>RnD</option>
                                        <option value="digitalmarketing" {{ old('role', $user->role ?? '') == 'digitalmarketing' ? 'selected' : '' }}>Digital Marketing</option>
                                        
                                        {{-- 2 ROLE BARU YANG DIGABUNG --}}
                                        <option value="operasional" {{ old('role', $user->role ?? '') == 'operasional' ? 'selected' : '' }}>Operasional / Backoffice / PIC</option>
                                        <option value="team_leader" {{ old('role', $user->role ?? '') == 'team_leader' ? 'selected' : '' }}>Team Leader / Admin PIC</option>
                                    </select>
                                </div>

                                {{-- BUTTONS --}}
                                <div class="col-md-12 mt-3 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Submit
                                    </button>
                                    <a href="{{ route('user') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
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
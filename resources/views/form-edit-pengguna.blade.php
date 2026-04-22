@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data Pengguna</h3>
                <h6 class="op-7 mb-2">Formulir Update Data Pengguna</h6>
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
                        <div class="card-title fw-bold m-0 text-primary">
                            <i class="fas fa-user-edit me-2"></i> Edit Data: {{ $user->name }}
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

                        {{-- Jangan lupa tambahkan enctype multipart/form-data! --}}
                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <div class="row">
                                {{-- 1. BAGIAN FOTO PROFIL --}}
                                <div class="col-md-12 mb-4 pb-3 border-bottom d-flex align-items-center">
                                    <div class="avatar avatar-xxl me-4 flex-shrink-0" style="width: 100px; height: 100px;">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Profil" class="avatar-img rounded-circle border border-3 shadow-sm object-fit-cover">
                                        @else
                                            <div class="avatar-title rounded-circle bg-primary-gradient fw-bold text-white shadow-sm fs-2">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <label class="fw-bold mb-1">Ganti Foto Profil (Opsional)</label>
                                        <input type="file" name="foto_profil" class="form-control form-control-sm" accept="image/*">
                                        <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</small>
                                    </div>
                                </div>
                        
                                {{-- 2. INPUT DATA TEKS --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="name" class="fw-bold mb-1">Nama Panggilan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap" class="fw-bold mb-1">Nama Lengkap (KTP)</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="no_hp" class="fw-bold mb-1">No. HP / WhatsApp</label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '') }}">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="role" class="fw-bold mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select class="form-select form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="marketing" {{ old('role', $user->role) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="rnd" {{ old('role', $user->role) == 'rnd' ? 'selected' : '' }}>RnD</option>
                                        <option value="digitalmarketing" {{ old('role', $user->role) == 'digitalmarketing' ? 'selected' : '' }}>Digital Marketing</option>
                                        <option value="web_dev" {{ old('role', $user->role) == 'web_dev' ? 'selected' : '' }}>Web Developer</option>
                                    </select>
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="password" class="fw-bold mb-1 text-danger">Ubah Password Baru</label>
                                    <input type="password" class="form-control border-danger border-opacity-50 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <small class="text-muted d-block mt-1">Biarkan kosong jika tetap memakai password lama.</small>
                                </div>
                        
                                {{-- 3. TOMBOL SUBMIT --}}
                                <div class="col-md-12 mt-3 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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
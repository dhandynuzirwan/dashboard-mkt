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
                                    <label for="name" class="fw-bold mb-1">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap" class="fw-bold mb-1">Nama Panggilan</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nama_lengkap_ktp" class="fw-bold mb-1">Nama Lengkap (KTP)</label>
                                    <input type="text" class="form-control @error('nama_lengkap_ktp') is-invalid @enderror" id="nama_lengkap_ktp" name="nama_lengkap_ktp" value="{{ old('nama_lengkap_ktp', $user->nama_lengkap_ktp ?? '') }}">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="no_hp" class="fw-bold mb-1">No. HP / WhatsApp</label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '') }}">
                                </div>
                        
                                <div class="form-group col-md-6 mb-3">
                                    <label for="email" class="fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                        
                                                                {{-- NIK --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="nik" class="fw-bold mb-1">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" placeholder="Masukkan NIK 16 digit">
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="fw-bold mb-1">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                                </div>

                                {{-- Tanggal Bergabung --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_bergabung" class="fw-bold mb-1">Tanggal Bergabung</label>
                                    <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', $user->tanggal_bergabung) }}">
                                </div>

                                {{-- Tanggal Kontrak --}}
                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_baru" class="fw-bold mb-1">Tanggal Kontrak Terbaru</label>
                                    <input type="date" class="form-control @error('tanggal_kontrak_baru') is-invalid @enderror" id="tanggal_kontrak_baru" name="tanggal_kontrak_baru" value="{{ old('tanggal_kontrak_baru', $user->tanggal_kontrak_baru) }}">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="tanggal_kontrak_berakhir" class="fw-bold mb-1">Tanggal Kontrak Berakhir</label>
                                    <input type="date" class="form-control @error('tanggal_kontrak_berakhir') is-invalid @enderror" id="tanggal_kontrak_berakhir" name="tanggal_kontrak_berakhir" value="{{ old('tanggal_kontrak_berakhir', $user->tanggal_kontrak_berakhir) }}">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="jobdesk_file" class="fw-bold mb-1">Jobdesk (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control @error('jobdesk_file') is-invalid @enderror" id="jobdesk_file" name="jobdesk_file">
                                    @if($user->jobdesk_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->jobdesk_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat Jobdesk saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="sop_file" class="fw-bold mb-1">SOP (PDF/Doc/Image)</label>
                                    <input type="file" class="form-control @error('sop_file') is-invalid @enderror" id="sop_file" name="sop_file">
                                    @if($user->sop_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->sop_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat SOP saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="ktp_file" class="fw-bold mb-1">KTP (PDF/Image)</label>
                                    <input type="file" class="form-control @error('ktp_file') is-invalid @enderror" id="ktp_file" name="ktp_file">
                                    @if($user->ktp_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->ktp_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat KTP saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="ijasah_file" class="fw-bold mb-1">Ijazah (PDF/Image)</label>
                                    <input type="file" class="form-control @error('ijasah_file') is-invalid @enderror" id="ijasah_file" name="ijasah_file">
                                    @if($user->ijasah_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->ijasah_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat Ijazah saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="pas_foto_file" class="fw-bold mb-1">Pas Foto (PDF/Image)</label>
                                    <input type="file" class="form-control @error('pas_foto_file') is-invalid @enderror" id="pas_foto_file" name="pas_foto_file">
                                    @if($user->pas_foto_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->pas_foto_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat Pas Foto saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="kk_file" class="fw-bold mb-1">Kartu Keluarga (PDF/Image)</label>
                                    <input type="file" class="form-control @error('kk_file') is-invalid @enderror" id="kk_file" name="kk_file">
                                    @if($user->kk_file)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->kk_file) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat KK saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="kontrak_kerja" class="fw-bold mb-1">Kontrak Kerja (PDF/Image)</label>
                                    <input type="file" class="form-control @error('kontrak_kerja') is-invalid @enderror" id="kontrak_kerja" name="kontrak_kerja">
                                    @if($user->kontrak_kerja)
                                        <small class="d-block mt-1"><a href="{{ asset('storage/' . $user->kontrak_kerja) }}" target="_blank"><i class="fas fa-file me-1"></i> Lihat Kontrak Kerja saat ini</a></small>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="role" class="fw-bold mb-1">Role / Hak Akses <span class="text-danger">*</span></label>
                                    <select class="form-select form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="marketing" {{ old('role', $user->role) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="rnd" {{ old('role', $user->role) == 'rnd' ? 'selected' : '' }}>RnD</option>
                                        <option value="digitalmarketing" {{ old('role', $user->role) == 'digitalmarketing' ? 'selected' : '' }}>Digital Marketing</option>
                                        <option value="operasional" {{ old('role', $user->role) == 'operasional' ? 'selected' : '' }}>Operasional / Backoffice / PIC</option>
                                        <option value="team_leader" {{ old('role', $user->role) == 'team_leader' ? 'selected' : '' }}>Team Leader / Admin PIC</option>
                                        <option value="spv_marketing" {{ old('role', $user->role) == 'spv_marketing' ? 'selected' : '' }}>SPV Marketing</option>
                                        <option value="web_dev" {{ old('role', $user->role) == 'web_dev' ? 'selected' : '' }}>Web Developer</option>
                                        <option value="hrd" {{ old('role', $user->role) == 'hrd' ? 'selected' : '' }}>HRD</option>
                                        <option value="graphic" {{ old('role', $user->role) == 'graphic' ? 'selected' : '' }}>Tim Grafis (Graphic)</option>
                                        <option value="pic" {{ old('role', $user->role) == 'pic' ? 'selected' : '' }}>PIC Khusus</option>
                                        <option value="finance" {{ old('role', $user->role) == 'finance' ? 'selected' : '' }}>Finance & Tax</option>
                                        <option value="performance" {{ old('role', $user->role) == 'performance' ? 'selected' : '' }}>Performance</option>
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
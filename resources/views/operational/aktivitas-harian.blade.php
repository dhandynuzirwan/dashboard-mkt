@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER & ACTIONS ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-1">Aktivitas Harian Operasional</h3>
                <h6 class="op-7 mb-0">Pantau log pekerjaan, durasi, dan evidence tim harian</h6>
            </div>
            
            @if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))
                <div class="ms-md-auto py-2 py-md-0">
                    <button class="btn btn-primary btn-round fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAktivitas">
                        <i class="fas fa-plus-circle me-1"></i> Isi Aktivitas Harian
                    </button>
                </div>
            @endif
        </div>

        {{-- ================= PESAN NOTIFIKASI ================= --}}
        
        {{-- Pesan Sukses (Tambah, Edit, Hapus) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-4 border-success bg-white" role="alert">
                <i class="fas fa-check-circle me-2 text-success fs-5 align-middle"></i> 
                <span class="fw-bold text-success">Berhasil!</span> <span class="text-dark">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Pesan Error Custom (Role ditolak, dll) --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-4 border-danger bg-white" role="alert">
                <i class="fas fa-times-circle me-2 text-danger fs-5 align-middle"></i> 
                <span class="fw-bold text-danger">Gagal!</span> <span class="text-dark">{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Pesan Error Validasi Form (File kebesaran, data kurang, dll) --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-4 border-danger bg-white" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-triangle me-2 text-danger fs-5"></i> 
                    <span class="fw-bold text-danger">Tidak bisa menyimpan data!</span>
                </div>
                <ul class="mb-0 text-dark ps-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Aktivitas</p>
                                    <h4 class="card-title">{{ $totalAktivitas }}</h4>
                                    <p class="text-muted small mb-0 mt-1">Sesuai Filter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-stopwatch"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Jam Kerja</p>
                                    <h4 class="card-title">{{ $totalJamKerja }} Jam</h4>
                                    <p class="text-muted small mb-0 mt-1">Sesuai Filter</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pegawai Aktif</p>
                                    @php
                                        $pegawaiInput = $aktivitas->pluck('user_id')->unique()->count();
                                    @endphp
                                    <h4 class="card-title">{{ $pegawaiInput }} / {{ $pegawaiOperasional->count() }}</h4>
                                    <p class="text-success small mb-0 mt-1 fw-bold">Sudah input log</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-paperclip"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Bukti / Evidence</p>
                                    @php
                                        $adaEvidence = $aktivitas->filter(function($item) {
                                            return $item->file_evidence != null || $item->link_evidence != null;
                                        })->count();
                                        $persentase = $totalAktivitas > 0 ? round(($adaEvidence / $totalAktivitas) * 100) : 0;
                                    @endphp
                                    <h4 class="card-title">{{ $persentase }}%</h4>
                                    <p class="text-secondary small mb-0 mt-1 fw-bold">Melampirkan file</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER SECTION ================= --}}
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('operational.aktivitas-harian') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block mb-1">Tanggal Aktivitas</small>
                        <input type="date" name="filter_date" class="form-control form-control-sm" value="{{ $filter_date }}">
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted fw-bold d-block mb-1">Pilih Pegawai (Filter)</small>
                        <select name="pegawai_id" class="form-select form-select-sm">
                            <option value="all" {{ $pegawai_id == 'all' ? 'selected' : '' }}>Semua Pegawai Operasional</option>
                            @foreach($pegawaiOperasional as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ $pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold">
                            <i class="fas fa-filter me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('operational.aktivitas-harian') }}" class="btn btn-light border btn-sm flex-grow-1 btn-round fw-bold">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= DATA TABEL AKTIVITAS ================= --}}
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <div class="card-title fw-bold">Log Aktivitas ({{ \Carbon\Carbon::parse($filter_date)->translatedFormat('d F Y') }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-4">Pegawai</th>
                                <th>Nama Kegiatan</th>
                                <th>Durasi</th>
                                <th>Evidence</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitas as $log)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-title rounded-circle bg-primary text-white" style="font-size: 12px;">
                                                    {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $log->user->name }}</span>
                                                <small class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB</small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $log->nama_kegiatan }}</div>
                                        <small class="text-muted d-block" style="white-space: normal; word-break: break-word; max-width: 300px;">
                                            {{ $log->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                                        </small>
                                    </td>
                                    
                                    <td>
                                        @if($log->durasi_menit)
                                            <span class="badge badge-count bg-light text-dark border"><i class="far fa-clock me-1 text-primary"></i> {{ $log->durasi_menit }} Menit</span>
                                        @else
                                            <span class="text-muted small fst-italic">-</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">
                                            @if($log->file_evidence)
                                                <a href="{{ asset('storage/' . $log->file_evidence) }}" class="badge badge-success shadow-sm text-decoration-none" target="_blank">
                                                    <i class="fas fa-image me-1"></i> Gambar
                                                </a>
                                            @endif
                                            
                                            @if($log->link_evidence)
                                                <a href="{{ $log->link_evidence }}" class="badge badge-secondary shadow-sm text-decoration-none" target="_blank">
                                                    <i class="fas fa-link me-1"></i> Link
                                                </a>
                                            @endif
                                            
                                            @if(!$log->file_evidence && !$log->link_evidence)
                                                <span class="text-muted small fst-italic">Kosong</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @php
                                            // Cek murni berdasarkan ID Kepemilikan Data
                                            $isOwner = (auth()->id() == $log->user_id);
                                        @endphp
                                    
                                        <div class="d-flex justify-content-center gap-2">
                                            @if($isOwner)
                                                {{-- Tombol Edit Aktif (Hanya untuk pemilik) --}}
                                                <button class="btn btn-warning btn-sm text-white shadow-sm" style="border-radius: 6px;" 
                                                    data-bs-toggle="modal" data-bs-target="#modalEditAktivitas{{ $log->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                {{-- Tombol Delete Aktif (Hanya untuk pemilik) --}}
                                                {{-- 🔥 PERBAIKAN FORM HAPUS 🔥 --}}
                                                <form action="{{ route('operational.aktivitas-harian.destroy', $log->id) }}" 
                                                      method="POST" 
                                                      class="m-0 p-0 form-hapus"> {{-- Tambahkan class form-hapus --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- Ganti type="submit" menjadi type="button" dan tambahkan class btn-delete --}}
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm shadow-sm btn-delete" 
                                                            style="border-radius: 6px;" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Tombol Locked (Tampil untuk orang lain) --}}
                                                <button class="btn btn-secondary btn-sm opacity-50 shadow-none" style="border-radius: 6px; cursor: not-allowed;" disabled title="Hanya pemilik yang bisa mengedit">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                                <button class="btn btn-secondary btn-sm opacity-50 shadow-none" style="border-radius: 6px; cursor: not-allowed;" disabled title="Hanya pemilik yang bisa menghapus">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT UNTUK SETIAP BARIS --}}
                                @if(auth()->id() == $log->user_id || in_array(auth()->user()->role, ['team_leader', 'web_dev', 'superadmin']))
                                    <div class="modal fade" id="modalEditAktivitas{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content card-round border-0 shadow-lg">
                                                <div class="modal-header border-bottom-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="fas fa-edit text-warning me-2"></i> Edit Aktivitas Harian
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <form action="{{ route('operational.aktivitas-harian.update', $log->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body pt-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2">Tanggal Aktivitas <span class="text-danger">*</span></label>
                                                                    <input type="date" class="form-control" name="tanggal_aktivitas" value="{{ $log->tanggal_aktivitas }}" max="{{ date('Y-m-d') }}" required>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="col-md-8">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2">Nama Kegiatan <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="nama_kegiatan" value="{{ $log->nama_kegiatan }}" required>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="col-md-5">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2 text-muted">Durasi Pekerjaan</label>
                                                                    <div class="input-group">
                                                                        @php
                                                                            $jamLama = $log->durasi_menit ? floor($log->durasi_menit / 60) : '';
                                                                            $menitLama = $log->durasi_menit ? ($log->durasi_menit % 60) : '';
                                                                        @endphp
                                                                        <input type="number" class="form-control text-center" name="durasi_jam" value="{{ $jamLama }}" placeholder="0" min="0">
                                                                        <span class="input-group-text bg-light px-2">Jam</span>
                                                                        
                                                                        <input type="number" class="form-control text-center" name="durasi_menit" value="{{ $menitLama }}" placeholder="0" min="0" max="59">
                                                                        <span class="input-group-text bg-light px-2">Mnt</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2 text-muted">Deskripsi Pekerjaan</label>
                                                                    <textarea class="form-control" name="deskripsi" rows="3">{{ $log->deskripsi }}</textarea>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="col-md-6">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2 text-muted">Upload Baru (Opsional)</label>
                                                                    <input type="file" class="form-control" name="file_evidence" accept="image/*">
                                                                    @if($log->file_evidence)
                                                                        <small class="text-success d-block mt-1"><i class="fas fa-check"></i> File lama tersimpan. Biarkan kosong jika tidak diganti.</small>
                                                                    @else
                                                                        <small class="text-muted d-block mt-1">Format: JPG/PNG, Maks: 2MB.</small>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group px-0 m-0">
                                                                    <label class="fw-bold mb-2 text-muted">Tautan Bukti Online</label>
                                                                    <input type="url" class="form-control" name="link_evidence" value="{{ $log->link_evidence }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal-footer border-top-0 pt-4">
                                                        <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning text-white btn-round fw-bold">
                                                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-list fs-1 opacity-25 mb-3 d-block"></i>
                                        Belum ada data aktivitas yang dicatat pada filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Cek akses untuk Modal Create --}}
@if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))
{{-- ================= MODAL TAMBAH AKTIVITAS ================= --}}
<div class="modal fade" id="modalTambahAktivitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-clipboard-check text-primary me-2"></i> Form Aktivitas Harian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('operational.aktivitas-harian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-4">
                    <div class="alert alert-info shadow-sm rounded-3 border-start border-4 border-info small mb-4">
                        <strong>Info:</strong> Anda dapat mencatat aktivitas yang terlewat maksimal <strong>H-3</strong> dari hari ini.
                    </div>
                
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Tanggal Aktivitas <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_aktivitas" 
                                       value="{{ date('Y-m-d') }}" 
                                       max="{{ date('Y-m-d') }}" 
                                       min="{{ \Carbon\Carbon::today()->subDays(3)->toDateString() }}" required>
                            </div>
                        </div>
                
                        {{-- Nama Kegiatan --}}
                        <div class="col-md-7">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_kegiatan" placeholder="Contoh: Slicing UI" required>
                            </div>
                        </div>
                
                        {{-- Durasi (Opsional) - Format Jam & Menit --}}
                        <div class="col-md-5">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2 text-muted">Durasi Pekerjaan</label>
                                <div class="input-group">
                                    <input type="number" class="form-control text-center" name="durasi_jam" placeholder="0" min="0">
                                    <span class="input-group-text bg-light px-2">Jam</span>
                                    
                                    <input type="number" class="form-control text-center" name="durasi_menit" placeholder="0" min="0" max="59">
                                    <span class="input-group-text bg-light px-2">Mnt</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2 text-muted">Deskripsi Pekerjaan</label>
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Opsional: Jelaskan secara singkat apa saja yang dikerjakan..."></textarea>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2 text-muted">Upload Foto / Screenshot</label>
                                <input type="file" class="form-control" name="file_evidence" accept="image/*">
                                <small class="text-muted d-block mt-1">Format: JPG/PNG, Maks: 2MB.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2 text-muted">Tautan Bukti Online</label>
                                <input type="url" class="form-control" name="link_evidence" placeholder="https://docs.google.com/...">
                                <small class="text-muted d-block mt-1">Opsional: Jika ada link Drive/Figma dll.</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-4">
                    <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Aktivitas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Letakkan di bagian paling bawah sebelum @endsection --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gunakan event delegation agar lebih aman
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                const button = e.target.closest('.btn-delete');
                const form = button.closest('.form-hapus');

                Swal.fire({
                    title: 'Hapus aktivitas ini?',
                    text: "Data log harian Anda akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endif
@endsection
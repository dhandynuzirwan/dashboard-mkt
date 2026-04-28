@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER & ACTIONS (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Aktivitas Harian Operasional</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau log pekerjaan, durasi, dan evidence tim harian</h6>
            </div>
            
            @if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))
                <div class="ms-md-auto py-2 py-md-0 mt-3 mt-md-0">
                    <button class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4" data-bs-toggle="modal" data-bs-target="#modalTambahAktivitas">
                        <i class="fas fa-plus me-2"></i> Isi Aktivitas Harian
                    </button>
                </div>
            @endif
        </div>

        {{-- ================= PESAN NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-modern-success alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark">Berhasil!</span> <span class="text-dark opacity-75">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Gagal!</span> <span class="text-dark opacity-75">{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-start">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Tidak bisa menyimpan data!</span>
                        <ul class="mb-0 text-dark opacity-75 ps-3 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= STATISTIC CARDS (MODERN UI) ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Aktivitas</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalAktivitas }}</h3>
                            <p class="text-muted small mb-0 mt-1" style="font-size: 10px;">Sesuai filter</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-info-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-stopwatch"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Jam Kerja</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalJamKerja }} <span style="font-size: 14px;">Jam</span></h3>
                            <p class="text-muted small mb-0 mt-1" style="font-size: 10px;">Akumulasi durasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Pegawai Aktif</p>
                            @php $pegawaiInput = $aktivitas->pluck('user_id')->unique()->count(); @endphp
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $pegawaiInput }} <span class="text-muted fw-medium" style="font-size: 14px;">/ {{ $pegawaiOperasional->count() }}</span></h3>
                            <p class="text-success fw-bold small mb-0 mt-1" style="font-size: 10px;">Sudah input log</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-secondary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-secondary-subtle text-secondary me-3">
                            <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Bukti / Evidence</p>
                            @php
                                $adaEvidence = $aktivitas->filter(function($item) { return $item->file_evidence != null || $item->link_evidence != null; })->count();
                                $persentase = $totalAktivitas > 0 ? round(($adaEvidence / $totalAktivitas) * 100) : 0;
                            @endphp
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $persentase }}%</h3>
                            </div>
                            <div class="progress bg-light mt-2" style="height: 4px; border-radius: 10px;">
                                <div class="progress-bar bg-secondary rounded-pill" style="width: {{ $persentase }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER SECTION (MODERN SAAS) ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Log Aktivitas</h6>
                </div>

                <form action="{{ route('operational.aktivitas-harian') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="label-modern">Tanggal Aktivitas</label>
                        <input type="date" name="filter_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $filter_date }}">
                    </div>
                    <div class="col-md-4">
                        <label class="label-modern">Pilih Pegawai</label>
                        <select name="pegawai_id" class="form-select form-select-sm input-modern shadow-none">
                            <option value="all" {{ $pegawai_id == 'all' ? 'selected' : '' }}>Semua Pegawai Operasional</option>
                            @foreach($pegawaiOperasional as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ $pegawai_id == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 d-flex gap-2 mt-4 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift px-3">
                            <i class="fas fa-search me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('operational.aktivitas-harian') }}" class="btn btn-white border btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift text-dark px-3 text-center pt-2">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= DATA TABEL AKTIVITAS ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Log Aktivitas ({{ \Carbon\Carbon::parse($filter_date)->translatedFormat('d F Y') }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4" width="220">Pegawai</th>
                                <th>Nama Kegiatan</th>
                                <th width="120">Durasi</th>
                                <th width="180">Evidence</th>
                                <th class="text-center pe-4" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitas as $log)
                                <tr>
                                    {{-- Kolom Pegawai --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-modern bg-primary text-white me-3 fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="fw-bolder text-dark" style="font-size: 14px;">{{ $log->user->name }}</span><br>
                                                <small class="text-muted fw-medium" style="font-size: 11px;"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB</small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- Kolom Kegiatan --}}
                                    <td class="py-3">
                                        <div class="fw-bolder text-primary mb-1" style="font-size: 14px;">{{ $log->nama_kegiatan }}</div>
                                        <small class="text-muted d-block text-wrap lh-sm" style="max-width: 350px;">
                                            {{ $log->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                                        </small>
                                    </td>
                                    
                                    {{-- Kolom Durasi --}}
                                    <td class="py-3">
                                        @if($log->durasi_menit)
                                            <span class="badge badge-soft-info border border-info rounded-pill px-3 py-2 fw-bold text-dark">
                                                <i class="fas fa-hourglass-half text-info me-1"></i> {{ $log->durasi_menit }} Menit
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic opacity-50">-</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Evidence --}}
                                    <td class="py-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            @if($log->file_evidence)
                                                <a href="{{ asset('storage/' . $log->file_evidence) }}" class="badge badge-soft-success border border-success text-decoration-none px-2 py-1 shadow-sm hover-lift" target="_blank">
                                                    <i class="fas fa-image me-1"></i> Gambar
                                                </a>
                                            @endif
                                            
                                            @if($log->link_evidence)
                                                <a href="{{ $log->link_evidence }}" class="badge badge-soft-secondary border text-decoration-none px-2 py-1 shadow-sm hover-lift" target="_blank">
                                                    <i class="fas fa-link me-1"></i> Link
                                                </a>
                                            @endif
                                            
                                            @if(!$log->file_evidence && !$log->link_evidence)
                                                <span class="badge bg-light text-muted border border-secondary px-2 py-1">- Kosong -</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="text-center pe-4 py-3">
                                        @php
                                            $isOwner = (auth()->id() == $log->user_id);
                                        @endphp
                                    
                                        <div class="d-flex justify-content-center gap-2">
                                            @if($isOwner)
                                                <button class="btn btn-white border text-primary btn-sm btn-round shadow-sm hover-lift px-3" data-bs-toggle="modal" data-bs-target="#modalEditAktivitas{{ $log->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <form action="{{ route('operational.aktivitas-harian.destroy', $log->id) }}" method="POST" class="m-0 p-0 form-hapus">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-white border text-danger btn-sm btn-round shadow-sm hover-lift btn-delete px-3" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-light btn-sm btn-round border text-muted opacity-50 w-100" disabled title="Terkunci">
                                                    <i class="fas fa-lock me-1"></i> Locked
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-list fs-1 opacity-25 mb-3 d-block"></i>
                                        Belum ada data aktivitas yang dicatat pada hari ini.
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

{{-- Cek akses untuk Modal --}}
@if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))

{{-- ================= MODAL TAMBAH AKTIVITAS ================= --}}
<div class="modal fade" id="modalTambahAktivitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-clipboard-check me-2"></i> Form Aktivitas Harian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('operational.aktivitas-harian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pt-3">
                    <div class="alert alert-modern-info small mb-4 border-0">
                        <i class="fas fa-info-circle me-1 fw-bold"></i> <strong>Info:</strong> Anda dapat mencatat aktivitas yang terlewat maksimal <strong>H-3</strong> dari hari ini.
                    </div>
                
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="label-modern">Tanggal Aktivitas <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-modern shadow-none" name="tanggal_aktivitas" 
                                   value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" min="{{ \Carbon\Carbon::today()->subDays(3)->toDateString() }}" required>
                        </div>
                
                        <div class="col-md-8">
                            <label class="label-modern">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="nama_kegiatan" placeholder="Contoh: Slicing UI Dashboard" required>
                        </div>
                
                        <div class="col-md-4">
                            <label class="label-modern">Durasi Pekerjaan</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="number" class="form-control border-end-0 shadow-none text-center bg-white" name="durasi_jam" placeholder="0" min="0" style="font-size: 13px;">
                                    <span class="input-group-text bg-light text-muted border-start-0" style="font-size: 11px;">Jam</span>
                                </div>
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="number" class="form-control border-end-0 shadow-none text-center bg-white" name="durasi_menit" placeholder="0" min="0" max="59" style="font-size: 13px;">
                                    <span class="input-group-text bg-light text-muted border-start-0" style="font-size: 11px;">Mnt</span>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-8">
                            <label class="label-modern">Deskripsi Pekerjaan</label>
                            <textarea class="form-control input-modern shadow-none" name="deskripsi" rows="2" placeholder="Opsional: Jelaskan secara singkat apa saja yang dikerjakan..."></textarea>
                        </div>
                
                        <div class="col-md-6 mt-4">
                            <label class="label-modern">Upload Foto / Screenshot</label>
                            <input type="file" class="form-control input-modern shadow-none" name="file_evidence" accept="image/*">
                            <small class="text-muted d-block mt-2" style="font-size: 10px;">Format: JPG/PNG, Maks: 2MB.</small>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label class="label-modern">Tautan Bukti Online</label>
                            <input type="url" class="form-control input-modern shadow-none" name="link_evidence" placeholder="https://docs.google.com/...">
                            <small class="text-muted d-block mt-2" style="font-size: 10px;">Opsional: Jika ada link Drive/Figma dll.</small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">
                        <i class="fas fa-save me-1"></i> Simpan Aktivitas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= KUMPULAN MODAL EDIT (DI LUAR TABEL) ================= --}}
@foreach($aktivitas as $log)
    @if(auth()->id() == $log->user_id || in_array(auth()->user()->role, ['team_leader', 'web_dev', 'superadmin']))
    <div class="modal fade" id="modalEditAktivitas{{ $log->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-warning-subtle text-warning-dark border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder">
                        <i class="fas fa-edit me-2"></i> Edit Aktivitas Harian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('operational.aktivitas-harian.update', $log->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body px-4 pt-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="label-modern">Tanggal Aktivitas <span class="text-danger">*</span></label>
                                <input type="date" class="form-control input-modern shadow-none" name="tanggal_aktivitas" value="{{ $log->tanggal_aktivitas }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                            
                            <div class="col-md-8">
                                <label class="label-modern">Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="nama_kegiatan" value="{{ $log->nama_kegiatan }}" required>
                            </div>
                    
                            <div class="col-md-4">
                                <label class="label-modern">Durasi Pekerjaan</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                        @php
                                            $jamLama = $log->durasi_menit ? floor($log->durasi_menit / 60) : '';
                                            $menitLama = $log->durasi_menit ? ($log->durasi_menit % 60) : '';
                                        @endphp
                                        <input type="number" class="form-control border-end-0 shadow-none text-center bg-white" name="durasi_jam" value="{{ $jamLama }}" placeholder="0" min="0" style="font-size: 13px;">
                                        <span class="input-group-text bg-light text-muted border-start-0" style="font-size: 11px;">Jam</span>
                                    </div>
                                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                        <input type="number" class="form-control border-end-0 shadow-none text-center bg-white" name="durasi_menit" value="{{ $menitLama }}" placeholder="0" min="0" max="59" style="font-size: 13px;">
                                        <span class="input-group-text bg-light text-muted border-start-0" style="font-size: 11px;">Mnt</span>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-md-8">
                                <label class="label-modern">Deskripsi Pekerjaan</label>
                                <textarea class="form-control input-modern shadow-none" name="deskripsi" rows="2">{{ $log->deskripsi }}</textarea>
                            </div>
                    
                            <div class="col-md-6 mt-4">
                                <label class="label-modern">Upload Baru (Opsional)</label>
                                <input type="file" class="form-control input-modern shadow-none" name="file_evidence" accept="image/*">
                                @if($log->file_evidence)
                                    <div class="bg-success-subtle text-success p-2 rounded mt-2 fw-bold d-inline-block" style="font-size: 10px;">
                                        <i class="fas fa-check-circle me-1"></i> File lama tersimpan. Biarkan kosong jika tidak diganti.
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="label-modern">Tautan Bukti Online</label>
                                <input type="url" class="form-control input-modern shadow-none" name="link_evidence" value="{{ $log->link_evidence }}" placeholder="https://docs.google.com/...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                        <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark btn-round fw-bold shadow-sm hover-lift px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endif

{{-- ================= STYLES ================= --}}
<style>
    /* CSS MODERNISASI UI */
    .card-modern {
        border-radius: 16px;
        border: 1px solid #eef2f7;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }

    .icon-modern {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 20px;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-secondary-subtle { background-color: #f8fafc !important; }
    .text-warning-dark { color: #b45309 !important; }

    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-info-subtle { border-color: #a5f3fc !important; }
    .border-secondary-subtle { border-color: #e2e8f0 !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-secondary { background-color: #f8fafc; color: #475569; }

    /* Alert Modern */
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-danger { background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-warning { background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-info { background-color: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

    /* Table Modern */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 14px 16px; }

    /* Form Modern */
    .label-modern { font-weight: 700; color: #64748b; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; display: block; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #334155; background-color: #ffffff; }
    .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important; }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
</style>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hapus Data dengan SweetAlert2 (Modern Look)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                const button = e.target.closest('.btn-delete');
                const form = button.closest('.form-hapus');

                Swal.fire({
                    title: 'Hapus aktivitas ini?',
                    text: "Data log harian Anda akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'card-modern',
                        confirmButton: 'btn btn-round shadow-sm px-4',
                        cancelButton: 'btn btn-round shadow-sm px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endsection
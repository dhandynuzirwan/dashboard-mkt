@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER & ACTIONS (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Aktivitas Harian Operasional</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau log pekerjaan, durasi, dan evidence tim selama sebulan</h6>
                
                {{-- Jam Realtime Modern --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border bg-white" style="color: #0ea5e9; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
            
            @if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))
                <div class="ms-md-auto py-2 py-md-0 mt-3 mt-md-0 d-flex flex-wrap gap-2">
                    <button class="btn btn-success btn-round fw-bold shadow-sm hover-lift px-4" data-bs-toggle="modal" data-bs-target="#modalImportAktivitas">
                        <i class="fas fa-file-excel me-2"></i> Import Excel
                    </button>
                    
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
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $aktivitas->pluck('user_id')->unique()->count() }} / {{ $pegawaiOperasional->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning me-3">
                            <i class="fas fa-paperclip"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Bukti / Evidence</p>
                            @php
                                $adaEvidence = $aktivitas->filter(fn($i) => $i->file_evidence || $i->link_evidence)->count();
                                $persen = $totalAktivitas > 0 ? round(($adaEvidence / $totalAktivitas) * 100) : 0;
                            @endphp
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $persen }}%</h3>
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
                    <h6 class="fw-bold mb-0 text-dark">Filter Log Aktivitas Berdasarkan Range</h6>
                </div>

                <form action="{{ route('operational.aktivitas-harian') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-sm-6 col-md-2">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $start_date }}">
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $end_date }}">
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
                    <div class="col-md-4 d-flex gap-2 mt-4 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift px-3">
                            <i class="fas fa-search me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('operational.aktivitas-harian') }}" class="btn btn-white border btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift text-dark px-3 text-center pt-2">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= DATA TABEL AKTIVITAS ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">
                    Log Aktivitas ({{ \Carbon\Carbon::parse($start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d M Y') }})
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4" width="220">Pegawai & Waktu</th>
                                <th>Nama Kegiatan</th>
                                <th width="120">Durasi</th>
                                <th width="180">Evidence</th>
                                <th class="text-center pe-4" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitas as $log)
                                <tr>
                                    {{-- 🔥 UPDATE: Tanggal diletakkan di atas waktu 🔥 --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-modern bg-primary text-white me-3 fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="fw-bolder text-dark d-block mb-1" style="font-size: 13px;">{{ $log->user->name }}</span>
                                                <div style="line-height: 1.2;">
                                                    <small class="text-primary fw-bold d-block mb-0" style="font-size: 10px;">
                                                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($log->tanggal_aktivitas)->translatedFormat('d M Y') }}
                                                    </small>
                                                    <small class="text-muted fw-medium d-block" style="font-size: 10px;">
                                                        <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="fw-bolder text-dark me-2" style="font-size: 14px;">{{ $log->nama_kegiatan }}</div>
                                        </div>
                                         {{-- Badge Status Dinamis --}}
                                            @php
                                                $statusColor = [
                                                    'Not Started'  => 'bg-secondary',
                                                    'In Progress'  => 'bg-primary',
                                                    'Complete'     => 'bg-success',
                                                    'Needs Review' => 'bg-warning text-dark',
                                                    'Approved'     => 'bg-info',
                                                    'Overdue'      => 'bg-danger',
                                                    'On Hold'      => 'bg-dark',
                                                ];
                                                $color = $statusColor[$log->status] ?? 'bg-light text-dark border';
                                            @endphp
                                            <span class="badge {{ $color }}" style="font-size: 9px; padding: 3px 8px;">{{ $log->status }}</span>
                                        <small class="text-muted d-block text-wrap lh-sm" style="max-width: 350px;">
                                            {{ $log->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                                        </small>
                                    </td>
                                    
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
                                            
                                            {{-- 🔥 UPDATE: Ubah warna menjadi biru (primary) 🔥 --}}
                                            @if($log->link_evidence)
                                                <a href="{{ $log->link_evidence }}" class="badge badge-soft-primary border border-primary text-decoration-none px-2 py-1 shadow-sm hover-lift" target="_blank">
                                                    <i class="fas fa-link me-1"></i> Link URL
                                                </a>
                                            @endif
                                            
                                            @if(!$log->file_evidence && !$log->link_evidence)
                                                <span class="badge bg-light text-muted border border-secondary px-2 py-1">- Kosong -</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center pe-4 py-3">
                                        @if(auth()->id() == $log->user_id)
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-white border text-primary btn-sm btn-round shadow-sm hover-lift px-3" data-bs-toggle="modal" data-bs-target="#modalEditAktivitas{{ $log->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('operational.aktivitas-harian.destroy', $log->id) }}" method="POST" class="m-0 p-0 form-hapus">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-white border text-danger btn-sm btn-round shadow-sm hover-lift btn-delete px-3">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <button class="btn btn-light btn-sm btn-round border text-muted opacity-50 w-100" disabled>
                                                <i class="fas fa-lock me-1"></i> Locked
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-list fs-1 opacity-25 mb-3 d-block"></i>
                                        Tidak ada aktivitas yang ditemukan pada periode ini.
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

{{-- ================= MODALS SECTION (CREATE & IMPORT) ================= --}}

@if(in_array(auth()->user()->role, ['operasional', 'team_leader', 'web_dev']))
{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahAktivitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder"><i class="fas fa-clipboard-check me-2"></i> Form Aktivitas Harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('operational.aktivitas-harian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="label-modern">Tanggal Aktivitas <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-modern shadow-none" name="tanggal_aktivitas" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="label-modern">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="nama_kegiatan" placeholder="Contoh: Slicing UI Dashboard" required>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Durasi</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="number" class="form-control border-end-0 shadow-none text-center" name="durasi_jam" placeholder="0" min="0">
                                    <span class="input-group-text bg-light text-muted border-start-0">Jam</span>
                                </div>
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="number" class="form-control border-end-0 shadow-none text-center" name="durasi_menit" placeholder="0" min="0" max="59">
                                    <span class="input-group-text bg-light text-muted border-start-0">Mnt</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Status Aktivitas <span class="text-danger">*</span></label>
                            <select name="status" class="form-select input-modern shadow-none" required>
                                @php
                                    $statuses = ['Not Started', 'In Progress', 'Complete', 'Needs Review', 'Approved', 'Overdue', 'On Hold'];
                                @endphp
                                @foreach($statuses as $st)
                                    <option value="{{ $st }}" {{ (isset($log) && $log->status == $st) ? 'selected' : ($st == 'Not Started' ? 'selected' : '') }}>
                                        {{ $st }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="label-modern">Deskripsi Pekerjaan</label>
                            <textarea class="form-control input-modern shadow-none" name="deskripsi" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Upload Evidence</label>
                            <input type="file" class="form-control input-modern shadow-none" name="file_evidence" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Link Evidence</label>
                            <input type="url" class="form-control input-modern shadow-none" name="link_evidence" placeholder="https://...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Simpan Aktivitas</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Import --}}
<div class="modal fade" id="modalImportAktivitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('aktivitas-harian.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success-subtle text-success border-bottom-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bolder"><i class="fas fa-file-excel me-2"></i>Import Aktivitas (Excel)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3 px-4">
                    <div class="alert alert-modern-warning border-0 rounded-3 small mb-4 shadow-sm">
                        Format Kolom Baris 1: <code>DATE</code>, <code>ACTIVITY</code>, <code>TOTAL TIME</code>, <code>WORK EVIDENCE</code>, <code>STATUS</code>, <code>NOTES</code>.
                    </div>
                    <div class="form-group px-0 m-0">
                        <label class="label-modern">Pilih File Excel (.xlsx) <span class="text-danger">*</span></label>
                        <input type="file" name="file_excel" class="form-control input-modern shadow-none" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 pt-3 px-4 pb-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-white border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold btn-round shadow-sm px-4 hover-lift text-white">Mulai Import</button>
                </div>
            </div>
        </form>
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

                            {{-- 🔥 KOLOM STATUS BARU (EDIT) 🔥 --}}
                            <div class="col-md-6">
                                <label class="label-modern">Status Pekerjaan <span class="text-danger">*</span></label>
                                <select name="status" class="form-select input-modern shadow-none" required>
                                    @php
                                        $statuses = ['Not Started', 'In Progress', 'Complete', 'Needs Review', 'Approved', 'Overdue', 'On Hold'];
                                    @endphp
                                    @foreach($statuses as $st)
                                        <option value="{{ $st }}" {{ $log->status == $st ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="col-md-6">
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
                    
                            <div class="col-md-12">
                                <label class="label-modern">Deskripsi Pekerjaan</label>
                                <textarea class="form-control input-modern shadow-none" name="deskripsi" rows="2">{{ $log->deskripsi }}</textarea>
                            </div>
                    
                            <div class="col-md-6 mt-3">
                                <label class="label-modern">Upload Baru (Opsional)</label>
                                <input type="file" class="form-control input-modern shadow-none" name="file_evidence" accept="image/*">
                                @if($log->file_evidence)
                                    <div class="bg-success-subtle text-success p-2 rounded mt-2 fw-bold d-inline-block" style="font-size: 10px;">
                                        <i class="fas fa-check-circle me-1"></i> File lama tersimpan. Biarkan kosong jika tidak diganti.
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mt-3">
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

{{-- ================= STYLES & SCRIPTS ================= --}}
<style>
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; }
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; background: transparent; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .table-modern th { text-transform: uppercase; font-size: 11px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 14px 16px; }
    .label-modern { font-weight: 700; color: #64748b; font-size: 10px; text-transform: uppercase; margin-bottom: 4px; display: block; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 13px; }
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000); updateClock();

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                const form = e.target.closest('.form-hapus');
                Swal.fire({
                    title: 'Hapus aktivitas ini?', text: "Data akan dihapus permanen!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal', reverseButtons: true
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            }
        });
    });
</script>
@endsection
@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Monitoring Operasional Pelatihan</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau jadwal, personil, administrasi, dan distribusi sertifikat klien</h6>
            </div>
        </div>

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Pelatihan Running</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">5 <span style="font-size: 14px;" class="text-muted fw-medium">Kelas</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Validasi Admin</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">3 <span style="font-size: 14px;" class="text-muted fw-medium">Pending</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-info-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat OGP</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">12 <span style="font-size: 14px;" class="text-muted fw-medium">Batch</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertifikat Dikirim</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">8 <span style="font-size: 14px;" class="text-muted fw-medium">Resi</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav nav-pills nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex overflow-auto" id="pills-tab" role="tablist" style="max-width: 100%;">
                <button class="nav-link active text-nowrap" id="pills-pelaksanaan-tab" data-bs-toggle="tab" data-bs-target="#pills-pelaksanaan" type="button" role="tab">
                    <i class="fas fa-chalkboard-teacher me-1"></i> 1. Pelaksanaan & Jadwal
                </button>
                <button class="nav-link text-nowrap" id="pills-administrasi-tab" data-bs-toggle="tab" data-bs-target="#pills-administrasi" type="button" role="tab">
                    <i class="fas fa-file-signature me-1"></i> 2. Administrasi & Evaluasi
                </button>
                <button class="nav-link text-nowrap" id="pills-sertifikat-tab" data-bs-toggle="tab" data-bs-target="#pills-sertifikat" type="button" role="tab">
                    <i class="fas fa-award me-1"></i> 3. Monitoring Sertifikat
                </button>
            </div>
        </div>

        {{-- ================= TAB CONTENT ================= --}}
        <div class="tab-content fade-in" id="pills-tabContent">
            
            {{-- TAB 1: PELAKSANAAN & JADWAL --}}
            <div class="tab-pane fade show active" id="pills-pelaksanaan" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Data Kelas (Sertifikasi, Jadwal, Tim Pengajar, Kelembagaan)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Program Pelatihan & Sertifikasi</th>
                                        <th width="200">Jadwal Pelaksanaan</th>
                                        <th width="300">Tim Lapangan (Pengajar & Pengawas)</th>
                                        <th width="250">Kelembagaan & PIC</th>
                                        <th class="text-center pe-4" width="150">Status Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelatihans as $pelatihan)
                                        @php
                                            $pesertaList = $pelatihan->pendaftaranPribadis;
                                            $marketingData = [];
                                            $sertifikasi = 'Lainnya';

                                            foreach($pesertaList as $p) {
                                                if ($p->tipe_pendaftaran == 'kolektif' && $p->kolektif && $p->kolektif->cta && $p->kolektif->cta->prospek) {
                                                    $mktName = $p->kolektif->cta->prospek->marketing->name ?? 'Unknown';
                                                } else if ($p->cta && $p->cta->prospek) {
                                                    $mktName = $p->cta->prospek->marketing->name ?? 'Unknown';
                                                } else {
                                                    $mktName = 'Unknown';
                                                }
                                                
                                                if(!isset($marketingData[$mktName])) {
                                                    $marketingData[$mktName] = 0;
                                                }
                                                $marketingData[$mktName]++;
                                            }

                                            $firstPendaftaran = $pesertaList->first();
                                            $skema = '';
                                            if ($firstPendaftaran) {
                                                if ($firstPendaftaran->tipe_pendaftaran == 'kolektif' && $firstPendaftaran->kolektif && $firstPendaftaran->kolektif->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->kolektif->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->kolektif->cta->skema);
                                                } else if ($firstPendaftaran->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->cta->skema);
                                                }
                                            }
                                            
                                            // Badge Status Kelas
                                            $statusBadgeMap = [
                                                'persiapan' => ['class' => 'bg-warning text-dark', 'text' => 'Persiapan'],
                                                'running' => ['class' => 'bg-primary', 'text' => 'Running'],
                                                'selesai' => ['class' => 'bg-success', 'text' => 'Selesai'],
                                                'batal' => ['class' => 'bg-danger', 'text' => 'Batal'],
                                            ];
                                            $badgeInfo = $statusBadgeMap[$pelatihan->status_kelas] ?? $statusBadgeMap['persiapan'];
                                        @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark" style="font-size: 14px;">{{ optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan' }}</div>
                                            <div class="fw-bold text-primary mt-1 mb-2" style="font-size: 13px;"><i class="fas fa-certificate me-1"></i> {{ $sertifikasi }}</div>
                                            
                                            <div class="d-flex flex-column gap-1 bg-light p-2 rounded border border-light">
                                                @forelse($marketingData as $mkt => $count)
                                                <span class="text-dark fw-bold" style="font-size: 10px;">
                                                    <i class="fas fa-user-tie text-muted me-1"></i> {{ $mkt }} <span class="badge bg-white text-primary border px-1 ms-1">{{ $count }} org</span>
                                                </span>
                                                @empty
                                                <span class="text-muted" style="font-size: 10px;">
                                                    <i class="fas fa-user-tie me-1"></i> Belum ada peserta
                                                </span>
                                                @endforelse
                                            </div>
                                            
                                            <button class="btn btn-sm btn-white border shadow-sm btn-round text-primary hover-lift mt-2 w-100" style="font-size: 10px; max-width: 180px;" data-bs-toggle="modal" data-bs-target="#modalDetailPeserta-{{ $pelatihan->id }}">
                                                <i class="fas fa-users me-1"></i> Lihat Detail Peserta
                                            </button>
                                        </td>
                                        
                                        {{-- KOLOM JADWAL (UPDATE DENGAN LOKASI) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper d-flex flex-column gap-1">
                                                <div class="bg-light p-2 rounded border">
                                                    <small class="text-muted d-block" style="font-size: 9px;">TGL PELATIHAN</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">
                                                        {{ $pelatihan->tanggal_pelatihan ? \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->translatedFormat('d M Y') : 'Belum Diset' }}
                                                        @if($pelatihan->tanggal_selesai)
                                                            - {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->translatedFormat('d M Y') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="bg-danger-subtle p-2 rounded border border-danger-subtle">
                                                    <small class="text-danger d-block" style="font-size: 9px;">TGL ASESMEN</small>
                                                    <span class="fw-bold text-danger" style="font-size: 11px;">
                                                        {{ $pelatihan->tanggal_asesmen ? \Carbon\Carbon::parse($pelatihan->tanggal_asesmen)->translatedFormat('d M Y') : 'Belum Diset' }}
                                                    </span>
                                                </div>
                                                <div class="bg-info-subtle p-2 rounded border border-info-subtle mb-1">
                                                    <small class="text-info d-block" style="font-size: 9px;">LOKASI / VENUE</small>
                                                    <span class="fw-bold text-dark" style="font-size: 11px;">
                                                        <i class="fas fa-map-marker-alt text-muted me-1"></i> {{ $pelatihan->lokasi ?? 'Belum Diset' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Jadwal & Lokasi" data-bs-toggle="modal" data-bs-target="#modalUpdateJadwal-{{ $pelatihan->id }}"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        {{-- KOLOM TIM (UPDATE) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                @if($skema == 'titip vendor lain')
                                                <div class="mb-2">
                                                    <span class="badge badge-soft-warning border border-warning text-dark px-2 py-1 mb-2 d-inline-block" style="font-size: 10px;">Titip Vendor</span>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 12px;"><i class="fas fa-building text-primary me-1"></i> {{ $pelatihan->instruktur ?? '-' }}</span>
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fas fa-user text-success me-1"></i> PIC: {{ $pelatihan->asesor ?? '-' }}</span>
                                                    @if($pelatihan->wa_trainer)
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fab fa-whatsapp text-success me-1"></i> WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pelatihan->wa_trainer) }}" target="_blank" class="text-success text-decoration-none">{{ $pelatihan->wa_trainer }}</a></span>
                                                    @endif
                                                </div>
                                                @else
                                                <div class="mb-2">
                                                    <small class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Instruktur & Asesor</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 12px;"><i class="fas fa-chalkboard-teacher text-primary me-1"></i> Inst: {{ $pelatihan->instruktur ?? '-' }}</span>
                                                    @if($pelatihan->wa_trainer)
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 11px;"><i class="fab fa-whatsapp text-success me-1"></i> WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pelatihan->wa_trainer) }}" target="_blank" class="text-success text-decoration-none">{{ $pelatihan->wa_trainer }}</a></span>
                                                    @endif
                                                    <span class="text-dark fw-bold d-block mt-1" style="font-size: 12px;"><i class="fas fa-user-check text-success me-1"></i> Asr: {{ $pelatihan->asesor ?? '-' }}</span>
                                                </div>
                                                <div class="bg-gray-50 p-2 rounded border mb-0">
                                                    <small class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Pengawas (Wasnaker)</small>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 11px;">{{ $pelatihan->pengawas ?? 'Belum Diset' }}</span>
                                                </div>
                                                @endif
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Tim" data-bs-toggle="modal" data-bs-target="#modalUpdateTim-{{ $pelatihan->id }}"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        {{-- KOLOM LEMBAGA & PIC (UPDATE LABEL) --}}
                                        <td class="cell-relative">
                                            <div class="cell-content-wrapper me-2">
                                                @if($skema == 'titip vendor lain')
                                                <div class="mb-2" style="font-size: 11px;">
                                                    <span class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Nama Lembaga</span>
                                                    <span class="fw-bold text-dark d-block"><i class="fas fa-building text-info me-1"></i> {{ $pelatihan->pjk3 ?? 'Belum Diset' }}</span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <span class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">PIC Internal</span>
                                                    <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                        <i class="fas fa-user-shield text-success me-1"></i> {{ $pelatihan->pic_operasional ?? 'Belum Diset' }}
                                                    </span>
                                                </div>
                                                @else
                                                <div class="mb-2" style="font-size: 11px;">
                                                    <span class="text-muted d-block" style="font-size: 9px; text-transform: uppercase;">Lembaga & PJK3</span>
                                                    <span class="fw-bold text-dark d-block"><i class="fas fa-building text-info me-1"></i> {{ $pelatihan->pjk3 ?? 'Belum Diset' }}</span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <span class="text-muted d-block mb-1" style="font-size: 9px; text-transform: uppercase;">Penanggung Jawab (PIC)</span>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-user-tie text-primary me-1"></i> Eksternal: {{ $pelatihan->pic_klien ?? 'Belum Diset' }}
                                                        </span>
                                                        <span class="badge bg-light text-dark border text-start px-2 py-1 shadow-sm w-100 text-truncate" style="font-size: 10px;">
                                                            <i class="fas fa-user-shield text-success me-1"></i> Internal: {{ $pelatihan->pic_operasional ?? 'Belum Diset' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <button class="btn btn-sm btn-edit-absolute hover-lift" title="Edit Lembaga & PIC" data-bs-toggle="modal" data-bs-target="#modalUpdateLembaga-{{ $pelatihan->id }}"><i class="fas fa-pen"></i></button>
                                        </td>
                                        
                                        <td class="text-center pe-4">
                                            <span class="badge {{ $badgeInfo['class'] }} rounded-pill px-3 py-2 shadow-sm d-block mb-2 w-100">{{ $badgeInfo['text'] }}</span>
                                            <button class="btn btn-sm btn-white border btn-round text-muted d-block w-100 hover-lift px-3 mb-1" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusKelas-{{ $pelatihan->id }}">Ubah Status</button>
                                            <button class="btn btn-sm btn-danger btn-round text-white d-block w-100 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalHapusPelatihan-{{ $pelatihan->id }}">Hapus Data</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data pelatihan berjalan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: ADMINISTRASI & EVALUASI --}}
            <div class="tab-pane fade" id="pills-administrasi" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3 d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Pemberkasan Laporan, Validasi & Evaluasi Lapangan</h6>
                    </div>
                    <div class="card-body p-0">
                        
                        {{-- 🔥 ALERT SOP GLOBAL 🔥 --}}
                        <div class="alert bg-warning-subtle border-0 text-warning-dark m-3 py-2 px-3 rounded-3 d-flex align-items-center shadow-sm">
                            <i class="fas fa-bullhorn fs-5 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 13px;">SOP Upload Laporan Lembaga</h6>
                                <p class="mb-0 small opacity-75" style="font-size: 11px;">Maksimal <b>H+2</b> setelah pelatihan selesai untuk sertifikasi <b>BNSP</b>, dan maksimal <b>H+7</b> untuk sertifikasi <b>KEMNAKER</b>.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1400px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="300">Sertifikasi, Judul & Klien</th>
                                        <th width="250">Validasi Administrasi</th>
                                        <th width="350">Link Laporan (Internal & Lembaga)</th>
                                        <th width="350">Evaluasi Pelaksanaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelatihans as $pelatihan)
                                        @php
                                            $firstPendaftaran = $pelatihan->pendaftaranPribadis->first();
                                            $sertifikasi = 'Lainnya';
                                            $skema = '';
                                            if ($firstPendaftaran) {
                                                if ($firstPendaftaran->tipe_pendaftaran == 'kolektif' && $firstPendaftaran->kolektif && $firstPendaftaran->kolektif->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->kolektif->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->kolektif->cta->skema);
                                                } else if ($firstPendaftaran->cta) {
                                                    $sertifikasi = strtoupper($firstPendaftaran->cta->sertifikasi);
                                                    $skema = strtolower($firstPendaftaran->cta->skema);
                                                }
                                            }
                                            $checklist = json_decode($pelatihan->checklist_validasi, true) ?? [];
                                            $progress = count($checklist);
                                            $percent = $progress > 0 ? round(($progress / 21) * 100) : 0;
                                            $percentColor = $percent == 100 ? 'primary' : 'warning';
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">{{ optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan' }}</div>
                                                <div class="text-primary fw-bold mt-1" style="font-size: 13px;"><i class="fas fa-certificate me-1"></i> {{ $sertifikasi }}</div>
                                            </td>
                                            @if($skema == 'titip vendor lain')
                                            <td colspan="3" class="text-center bg-gray-50 border-start">
                                                <div class="py-3">
                                                    <span class="badge badge-soft-warning border border-warning text-dark px-3 py-2" style="font-size: 13px;">
                                                        <i class="fas fa-building me-2"></i> Titip Vendor Lain
                                                    </span>
                                                    <p class="text-muted small mt-2 mb-0">Administrasi dan evaluasi dikelola oleh vendor terkait.</p>
                                                </div>
                                            </td>
                                            @else
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                    <span class="text-{{ $percentColor }} fw-bolder" style="font-size: 11px;">{{ $percent }}% ({{ $progress }}/21)</span>
                                                </div>
                                                <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                    <div class="progress-bar bg-{{ $percentColor }} {{ $percent == 100 ? 'rounded-pill' : '' }}" style="width: {{ $percent }}%"></div>
                                                </div>
                                                <div class="d-flex gap-2 mt-2">
                                                    <button class="btn btn-sm btn-white border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi-{{ $pelatihan->id }}" style="font-size: 11px;">
                                                        <i class="fas fa-check-square me-1"></i> Update Checklist
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    @if($pelatihan->file_laporan_internal)
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ asset($pelatihan->file_laporan_internal) }}" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1" style="color: #0ea5e9;">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Internal
                                                        </a>
                                                        <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    @else
                                                    <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Internal
                                                    </button>
                                                    @endif

                                                    @if($pelatihan->file_laporan_kemnaker)
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ asset($pelatihan->file_laporan_kemnaker) }}" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1 text-success">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Instansi
                                                        </a>
                                                        <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    @else
                                                    <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Instansi
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($pelatihan->evaluasi)
                                                <div class="bg-gray-50 border p-3 rounded-4 position-relative">
                                                    <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.6;">
                                                        <i class="fas fa-comment-dots text-muted me-1"></i> {{ Str::limit($pelatihan->evaluasi, 100) }}
                                                    </p>
                                                    <button class="btn btn-sm btn-link text-muted position-absolute top-0 end-0 mt-1 me-1 p-1" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-{{ $pelatihan->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                </div>
                                                @else
                                                <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                    <p class="mb-2 text-muted small fw-bold">Belum ada evaluasi pelaksanaan.</p>
                                                    <button class="btn btn-sm btn-white border btn-round shadow-sm hover-lift text-dark fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-{{ $pelatihan->id }}">
                                                        <i class="fas fa-pen me-1"></i> Tulis Evaluasi
                                                    </button>
                                                </div>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: MONITORING SERTIFIKAT --}}
            <div class="tab-pane fade" id="pills-sertifikat" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Status Penerbitan, Pengiriman & Logistik</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1600px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Program Pelatihan & Sertifikasi</th>
                                        <th class="text-center" width="180">Status Sertifikat</th>
                                        <th width="250">Timeline Sertifikat (Tgl)</th>
                                        <th width="150" class="text-center">Scan Sertifikat</th>
                                        <th width="280">Ekspedisi & Resi Foto</th>
                                        <th class="text-center pe-4" width="180">Tanda Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelatihans as $pelatihan)
                                        @php
                                            $firstPendaftaran = $pelatihan->pendaftaranPribadis->first();
                                            $sertifikasi = ($firstPendaftaran && $firstPendaftaran->cta) ? strtoupper($firstPendaftaran->cta->sertifikasi) : 'Lainnya';
                                            $picInfo = $pelatihan->pic_klien ?? 'Belum ditentukan';
                                            
                                            $badgeSertif = 'secondary';
                                            $iconSertif = 'hourglass-half';
                                            if($pelatihan->status_sertifikat == 'Terbit') { $badgeSertif = 'success'; $iconSertif = 'check-circle'; }
                                            elseif($pelatihan->status_sertifikat == 'Delay') { $badgeSertif = 'warning'; $iconSertif = 'exclamation-triangle'; }
                                            elseif($pelatihan->status_sertifikat == 'OGP') { $badgeSertif = 'primary'; $iconSertif = 'cog fa-spin'; }
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">{{ optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan' }}</div>
                                                <div class="text-primary fw-bold mt-1" style="font-size: 13px;"><i class="fas fa-certificate me-1"></i> {{ $sertifikasi }}</div>
                                                <div class="text-primary small fw-bold mt-1"><i class="fas fa-user-tie me-1"></i> PIC: {{ $picInfo }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-soft-{{ $badgeSertif }} border border-{{ $badgeSertif }} text-{{ $badgeSertif == 'warning' ? 'dark' : $badgeSertif }} px-4 py-2 rounded-pill shadow-sm" style="font-size: 11px;">
                                                    <i class="fas fa-{{ $iconSertif }} me-1"></i> {{ $pelatihan->status_sertifikat ?? 'OGP' }}
                                                </span>
                                                <button class="btn btn-sm btn-white border btn-round text-muted d-block mx-auto mt-2 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusSertif-{{ $pelatihan->id }}">Ubah Status</button>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Estimasi Terbit:</span>
                                                        <span class="fw-bold text-dark">{{ $pelatihan->estimasi_terbit ? \Carbon\Carbon::parse($pelatihan->estimasi_terbit)->format('d M Y') : '-' }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Terima Dr Lembaga:</span>
                                                        @if($pelatihan->tgl_terima_lembaga)
                                                            <span class="fw-bold text-success">{{ \Carbon\Carbon::parse($pelatihan->tgl_terima_lembaga)->format('d M Y') }}</span>
                                                        @else
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Kirim Ke Klien:</span>
                                                        @if($pelatihan->tgl_kirim_klien)
                                                            <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($pelatihan->tgl_kirim_klien)->format('d M Y') }}</span>
                                                        @else
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($pelatihan->file_scan_sertifikat)
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ asset($pelatihan->file_scan_sertifikat) }}" target="_blank" class="btn btn-sm btn-light border text-info fw-bold btn-round shadow-sm hover-lift w-100">
                                                        <i class="fas fa-file-pdf me-1"></i> Lihat Scan
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-{{ $pelatihan->id }}">Ganti File</button>
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-info fw-bold btn-round shadow-sm hover-lift w-100" style="border: 1.5px dashed #7dd3fc;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-{{ $pelatihan->id }}">
                                                    <i class="fas fa-cloud-upload-alt me-1"></i> Upload Scan
                                                </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if($pelatihan->resi_pengiriman)
                                                <div class="bg-gray-50 border p-2 rounded-3 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <span class="badge badge-soft-danger border border-danger mb-1 fw-bold">{{ $pelatihan->ekspedisi ?? 'EKSPEDISI' }}</span>
                                                            <span class="fw-bolder text-dark d-block" style="letter-spacing: 1px; font-size: 13px;">{{ $pelatihan->resi_pengiriman }}</span>
                                                        </div>
                                                        <button class="btn btn-sm btn-white border text-muted px-2 py-1 hover-lift" title="Edit Resi" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-{{ $pelatihan->id }}"><i class="fas fa-pen"></i></button>
                                                    </div>
                                                    @if($pelatihan->foto_resi)
                                                    <a href="{{ asset($pelatihan->foto_resi) }}" target="_blank" class="badge bg-white text-primary border border-primary text-decoration-none shadow-sm px-2 py-1 w-100 text-center hover-lift">
                                                        <i class="fas fa-camera me-1"></i> Foto Resi Fisik
                                                    </a>
                                                    @endif
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-primary fw-bold rounded-3 shadow-sm hover-lift w-100 py-3" style="border: 1.5px dashed #93c5fd;" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-{{ $pelatihan->id }}">
                                                    <i class="fas fa-truck-loading me-1"></i> Input Resi
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($pelatihan->foto_tanda_terima)
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ asset($pelatihan->foto_tanda_terima) }}" target="_blank" class="btn btn-sm btn-success text-white btn-round shadow-sm hover-lift w-100 fw-bold">
                                                        <i class="fas fa-image me-1"></i> TTD
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-{{ $pelatihan->id }}">Ganti Foto</button>
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-success fw-bold btn-round shadow-sm hover-lift w-100 py-2" style="border: 1.5px dashed #86efac;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-{{ $pelatihan->id }}">
                                                    <i class="fas fa-upload me-1"></i> Upload Bukti
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= KUMPULAN MODAL TAB 1 (PELAKSANAAN) ================= --}}

{{-- Modal 1: Update Jadwal & Lokasi Pelaksanaan --}}
@foreach($pelatihans as $pelatihan)
{{-- Modal 1: Update Jadwal & Lokasi --}}
<div class="modal fade" id="modalUpdateJadwal-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status_kelas" value="{{ $pelatihan->status_kelas }}">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-calendar-alt text-primary me-2"></i> Set Jadwal & Lokasi Kelas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-6 mt-3">
                        <label class="label-modern">Mulai Pelatihan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pelatihan" value="{{ $pelatihan->tanggal_pelatihan }}" class="form-control input-modern shadow-none" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="label-modern">Selesai Pelatihan</label>
                        <input type="date" name="tanggal_selesai" value="{{ $pelatihan->tanggal_selesai }}" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-12 mt-3">
                        <label class="label-modern text-danger">Tanggal Asesmen / Ujian</label>
                        <input type="date" name="tanggal_asesmen" value="{{ $pelatihan->tanggal_asesmen }}" class="form-control input-modern shadow-none border-danger text-danger">
                    </div>
                    
                    <div class="col-12 mt-3">
                        <label class="label-modern">Lokasi Pelaksanaan</label>
                        <input type="text" name="lokasi" value="{{ $pelatihan->lokasi }}" class="form-control input-modern shadow-none" placeholder="Contoh: Virtual (Zoom) / Hotel Grand Rohan Jogja">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal 2: Update Tim Lapangan --}}
<div class="modal fade" id="modalUpdateTim-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status_kelas" value="{{ $pelatihan->status_kelas }}">
            <input type="hidden" name="tanggal_pelatihan" value="{{ $pelatihan->tanggal_pelatihan }}">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-users-cog text-success me-2"></i> Set Tim Pengajar & Pengawas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Nama Instruktur / Trainer</label>
                    <input type="text" name="instruktur" value="{{ $pelatihan->instruktur }}" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ahmad Fauzi">
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor WA Instruktur</label>
                    <input type="text" name="wa_trainer" value="{{ $pelatihan->wa_trainer }}" class="form-control input-modern shadow-none" placeholder="Contoh: 081234567890">
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nama Asesor / Evaluator</label>
                    <input type="text" name="asesor" value="{{ $pelatihan->asesor }}" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Ridwan R.">
                </div>
                
                <hr class="border-light my-4">
                <h6 class="fw-bolder text-dark mb-3" style="font-size: 13px;">Pengawas Kemnaker (Wasnaker) <span class="text-muted fw-normal fst-italic">opsional</span></h6>
                
                <div class="mb-3">
                    <label class="label-modern">Nama Wasnaker</label>
                    <input type="text" name="pengawas" value="{{ $pelatihan->pengawas }}" class="form-control input-modern shadow-none" placeholder="Contoh: Bpk. Sudarsono">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success text-white btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Tim</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal 3: Update Kelembagaan & PIC --}}
<div class="modal fade" id="modalUpdateLembaga-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="status_kelas" value="{{ $pelatihan->status_kelas }}">
            <input type="hidden" name="tanggal_pelatihan" value="{{ $pelatihan->tanggal_pelatihan }}">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-building text-info me-2"></i> Set Kelembagaan & PIC</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="label-modern">PJK3 / Lembaga Penyelenggara</label>
                        <input type="text" name="pjk3" value="{{ $pelatihan->pjk3 }}" class="form-control input-modern shadow-none" placeholder="Contoh: PT Arsa Safety">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="label-modern">PIC Eksternal (Lembaga Sertifikasi)</label>
                        <input type="text" name="pic_klien" value="{{ $pelatihan->pic_klien }}" class="form-control input-modern shadow-none" placeholder="Contoh: Ibu Vina (HRD)">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="label-modern">PIC Internal (Operasional)</label>
                        <select name="pic_operasional" class="form-select input-modern shadow-none">
                            <option value="">-- Pilih PIC Operasional --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->name }}" {{ $pelatihan->pic_operasional == $user->name ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-info text-white btn-round fw-bold px-4 shadow-sm hover-lift">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal 4: Update Status Kelas --}}
<div class="modal fade" id="modalUpdateStatusKelas-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="tanggal_pelatihan" value="{{ $pelatihan->tanggal_pelatihan }}">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-flag text-warning me-2"></i> Update Status Kelas</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih Status Baru</label>
                <select name="status_kelas" class="form-select input-modern shadow-none" style="height: 45px;">
                    <option value="persiapan" {{ $pelatihan->status_kelas == 'persiapan' ? 'selected' : '' }}>🟡 Persiapan (Setup Kelas)</option>
                    <option value="running" {{ $pelatihan->status_kelas == 'running' ? 'selected' : '' }}>🔵 Running (Sedang Berjalan)</option>
                    <option value="selesai" {{ $pelatihan->status_kelas == 'selesai' ? 'selected' : '' }}>🟢 Selesai (Menunggu Sertifikat)</option>
                    <option value="batal" {{ $pelatihan->status_kelas == 'batal' ? 'selected' : '' }}>🔴 Batal</option>
                </select>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-primary btn-round fw-bold w-100 shadow-sm hover-lift">Simpan Status</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal 5: Detail Peserta --}}
<div class="modal fade" id="modalDetailPeserta-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-users text-primary me-2"></i> Detail Peserta Pelatihan</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1000px;">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4" width="200">Nama Peserta</th>
                                <th width="150">Tanggal Lahir</th>
                                <th width="200">Alamat Perusahaan</th>
                                <th width="150">Nomor WA</th>
                                <th width="200">Nama Perusahaan</th>
                                <th class="pe-4" width="150">Marketing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelatihan->pendaftaranPribadis as $p)
                                @php
                                    if ($p->tipe_pendaftaran == 'kolektif' && $p->kolektif && $p->kolektif->cta && $p->kolektif->cta->prospek) {
                                        $mktName = $p->kolektif->cta->prospek->marketing->name ?? 'Unknown';
                                    } else if ($p->cta && $p->cta->prospek) {
                                        $mktName = $p->cta->prospek->marketing->name ?? 'Unknown';
                                    } else {
                                        $mktName = 'Unknown';
                                    }
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-bold text-dark" style="font-size: 13px;">{{ $p->nama_lengkap }}</td>
                                    <td style="font-size: 12px;">{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d M Y') : '-' }}</td>
                                    <td style="font-size: 12px;" class="text-truncate" style="max-width: 200px;" title="{{ $p->alamat_perusahaan }}">{{ Str::limit($p->alamat_perusahaan, 30) }}</td>
                                    <td style="font-size: 12px;"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_wa) }}" target="_blank" class="text-success fw-bold text-decoration-none"><i class="fab fa-whatsapp me-1"></i> {{ $p->no_wa }}</a></td>
                                    <td style="font-size: 12px;">{{ $p->perusahaan }}</td>
                                    <td class="pe-4" style="font-size: 12px;"><span class="badge bg-light text-dark border">{{ $mktName }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data peserta.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-white border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($pelatihans as $pelatihan)
{{-- ================= MODAL UPDATE VALIDASI CHECKLIST ================= --}}
<div class="modal fade" id="modalUpdateValidasi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 px-md-5 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-dark mb-0">Update Validasi Checklist</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">Program: <strong class="text-dark">{{ optional($pelatihan->training)->nama_training ?? '-' }}</strong></p>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 px-md-5 pt-4 pb-4" style="background-color: #f8fafc;">
                    @php $checklist = json_decode($pelatihan->checklist_validasi, true) ?? []; @endphp
                    <div class="row g-4">
                        {{-- Kategori 1: Administrasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-folder-open text-warning me-2"></i> 1. Administrasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Persyaratan Peserta" {{ in_array('Persyaratan Peserta', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Persyaratan Peserta</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="E Certificate" {{ in_array('E Certificate', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">E Certificate</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Form Evaluasi" {{ in_array('Form Evaluasi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Form Evaluasi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Review Google" {{ in_array('Review Google', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Review Google</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 2: Online Support --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-laptop-house text-info me-2"></i> 2. Online Support / Fasilitas</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Materi" {{ in_array('Link Zoom Materi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Materi</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="url" name="link_zoom_pelatihan" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Zoom Materi" value="{{ $pelatihan->link_zoom_pelatihan }}">
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Asesment" {{ in_array('Link Zoom Asesment', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Asesment</label>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <input type="url" name="link_zoom_asesmen" class="form-control form-control-sm shadow-none" placeholder="Masukkan Link Zoom Asesmen" value="{{ $pelatihan->link_zoom_asesmen }}">
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Background Zoom" {{ in_array('Background Zoom', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Background Zoom / Banner</label>
                                    </div>
                                    <div class="mb-2 mt-1 d-flex gap-2">
                                        <input type="file" name="background_zoom" class="form-control form-control-sm shadow-none" accept=".jpg,.jpeg,.png">
                                        @if($pelatihan->background_zoom) <a href="{{ asset($pelatihan->background_zoom) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-image"></i></a> @endif
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Profil Grup WA" {{ in_array('Foto Profil Grup WA', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Profil Grup WA</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Modul Pelatihan" {{ in_array('Modul Pelatihan', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Modul Pelatihan (Maks 5MB)</label>
                                    </div>
                                    <div class="mb-2 mt-1 d-flex gap-2">
                                        <input type="file" name="modul" class="form-control form-control-sm shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                                        @if($pelatihan->modul) <a href="{{ asset($pelatihan->modul) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i></a> @endif
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Rundown Pelatihan" {{ in_array('Rundown Pelatihan', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Rundown Pelatihan</label>
                                    </div>
                                    <div class="mb-2 mt-1 d-flex gap-2">
                                        <input type="file" name="rundown_pelatihan" class="form-control form-control-sm shadow-none" accept=".pdf,.doc,.docx">
                                        @if($pelatihan->rundown_pelatihan) <a href="{{ asset($pelatihan->rundown_pelatihan) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file-alt"></i></a> @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 3: Komunikasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-comments text-success me-2"></i> 3. Komunikasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Peserta" {{ in_array('Hubungi Peserta', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Peserta</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Instruktur" {{ in_array('Hubungi Instruktur', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Instruktur</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Asesor" {{ in_array('Hubungi Asesor', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Asesor</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Buat Grup WA" {{ in_array('Buat Grup WA', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Buat Grup WA</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Materi" {{ in_array('Share Link Zoom Materi', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Materi</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Asesment" {{ in_array('Share Link Zoom Asesment', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Asesment</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Form Evaluasi" {{ in_array('Share Form Evaluasi', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Form Evaluasi</label></div>
                                            <div class="form-check custom-checkbox mb-0"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Sertifikat" {{ in_array('Share Sertifikat', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Sertifikat</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 4: Dokumentasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-camera text-danger me-2"></i> 4. Dokumentasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Kompeten" {{ in_array('Foto Kompeten', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Kompeten</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto K3" {{ in_array('Foto K3', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto K3</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Formal" {{ in_array('Foto Formal', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Formal</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Materi" {{ in_array('Foto Materi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Materi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Record Zoom" {{ in_array('Record Zoom', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Record Zoom / Daftar Hadir</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top px-4 px-md-5 py-3 bg-white" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-white border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 btn-round shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Simpan Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD LAPORAN --}}
<div class="modal fade" id="modalUploadLaporan-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div><h5 class="modal-title fw-bolder text-dark mb-0">Upload Laporan</h5></div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Laporan Internal <span class="text-danger">*</span></label>
                    <input type="file" name="file_laporan_internal" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Laporan Instansi Kemnaker/BNSP</label>
                    <input type="file" name="file_laporan_kemnaker" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-info text-white fw-bold btn-round w-100 shadow-sm">Upload File</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPDATE EVALUASI --}}
<div class="modal fade" id="modalUpdateEvaluasi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-comment-dots text-warning me-2"></i> Catatan Evaluasi</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Evaluasi Pelaksanaan</label>
                <textarea name="evaluasi" class="form-control input-modern shadow-none" rows="4" placeholder="Masukkan catatan evaluasi pelaksanaan kelas ini...">{{ $pelatihan->evaluasi }}</textarea>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-warning text-dark fw-bold btn-round w-100 shadow-sm">Simpan Evaluasi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPDATE STATUS SERTIFIKAT --}}
<div class="modal fade" id="modalUpdateStatusSertif-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-award text-success me-2"></i> Update Status Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Status Saat Ini</label>
                    <select name="status_sertifikat" class="form-select input-modern shadow-none">
                        <option value="OGP" {{ $pelatihan->status_sertifikat == 'OGP' ? 'selected' : '' }}>⚙️ On Going Process (OGP)</option>
                        <option value="Delay" {{ $pelatihan->status_sertifikat == 'Delay' ? 'selected' : '' }}>⚠️ Delay / Terhambat</option>
                        <option value="Terbit" {{ $pelatihan->status_sertifikat == 'Terbit' ? 'selected' : '' }}>✅ Terbit / Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Estimasi Terbit</label>
                    <input type="date" name="estimasi_terbit" value="{{ $pelatihan->estimasi_terbit }}" class="form-control input-modern shadow-none">
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern text-success">Tanggal Terima Real</label>
                        <input type="date" name="tgl_terima_lembaga" value="{{ $pelatihan->tgl_terima_lembaga }}" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-6">
                        <label class="label-modern text-primary">Tanggal Kirim Klien</label>
                        <input type="date" name="tgl_kirim_klien" value="{{ $pelatihan->tgl_kirim_klien }}" class="form-control input-modern shadow-none">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Status</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPLOAD SCAN SERTIFIKAT --}}
<div class="modal fade" id="modalUploadScanSertif-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-pdf text-info me-2"></i> Upload Scan Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih File (PDF/Zip)</label>
                <input type="file" name="file_scan_sertifikat" class="form-control input-modern shadow-none" accept=".pdf,.zip,.rar" required>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-info text-white fw-bold btn-round w-100 shadow-sm">Upload Scan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL INPUT RESI PENGIRIMAN --}}
<div class="modal fade" id="modalUpdateResi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-truck-loading text-primary me-2"></i> Input Resi & Pengiriman</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Kurir / Ekspedisi</label>
                    <select name="ekspedisi" class="form-select input-modern shadow-none">
                        <option value="JNE" {{ $pelatihan->ekspedisi == 'JNE' ? 'selected' : '' }}>JNE</option>
                        <option value="J&T" {{ $pelatihan->ekspedisi == 'J&T' ? 'selected' : '' }}>J&T</option>
                        <option value="SiCepat" {{ $pelatihan->ekspedisi == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                        <option value="Pos Indonesia" {{ $pelatihan->ekspedisi == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                        <option value="Kurir Internal" {{ $pelatihan->ekspedisi == 'Kurir Internal' ? 'selected' : '' }}>Kurir Internal ARSA</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor Resi / Pelacakan</label>
                    <input type="text" name="resi_pengiriman" value="{{ $pelatihan->resi_pengiriman }}" class="form-control input-modern shadow-none fw-bold">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Upload Foto Resi Fisik (Opsional)</label>
                    <input type="file" name="foto_resi" class="form-control input-modern shadow-none" accept="image/*">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-primary text-white fw-bold btn-round w-100 shadow-sm">Simpan Resi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPLOAD TANDA TERIMA --}}
<div class="modal fade" id="modalUploadTandaTerima-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-signature text-success me-2"></i> Upload Tanda Terima</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-0">
                    <label class="label-modern">Upload Foto / Scan TTD</label>
                    <input type="file" name="foto_tanda_terima" class="form-control input-modern shadow-none" accept="image/*,.pdf" required>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Tanda Terima</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- MODAL HAPUS DATA --}}
@foreach($pelatihans as $pelatihan)
<div class="modal fade" id="modalHapusPelatihan-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 bg-danger text-white pb-3" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger">
                    <i class="fas fa-trash-alt fa-3x"></i>
                </div>
                <h6 class="fw-bold text-dark mb-2">Hapus Pelatihan Berjalan ini?</h6>
                <p class="text-muted small mb-0">Apakah Anda yakin ingin menghapus data pelatihan <strong>{{ optional($pelatihan->training)->nama_training ?? 'Belum Ada Pelatihan' }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-end" style="border-radius: 0 0 20px 20px;">
                <button type="button" class="btn btn-light border btn-round fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('operational.pelatihan-berjalan.destroy', $pelatihan->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-round fw-bold px-4">Ya, Hapus Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= STYLES ================= --}}
<style>
    /* Base UI */
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    /* Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .text-warning-dark { color: #b45309 !important; }

    /* Borders */
    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-info-subtle { border-color: #a5f3fc !important; }
    .border-warning-subtle { border-color: #fef08a !important; }
    .border-danger-subtle { border-color: #fca5a5 !important; }

    /* Badges */
    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }

    /* Tabs */
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Tables */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 14px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 16px; }

    /* Custom Elements */
    .alert-modern-danger { background-color: #fef2f2; border-radius: 8px; border-left: 3px solid #ef4444 !important; }
    .bg-gray-50 { background-color: #f8fafc; }

    /* Animation */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* CSS BARU UNTUK TOMBOL EDIT DI POJOK ATAS CELL */
    .cell-relative {
        position: relative; /* Menjadikan cell sebagai patokan posisi */
    }

    .btn-edit-absolute {
        position: absolute; /* Posisi melayang terhadap cell-relative */
        top: 8px;           /* Jarak dari atas cell */
        right: 8px;         /* Jarak dari kanan cell */
        z-index: 5;         /* Memastikan tombol di atas konten */
        
        /* Desain tombol agar lebih bersih & samar */
        padding: 4px 8px !important;
        border-radius: 6px !important;
        background: rgba(255, 255, 255, 0.7) !important; /* Semi transparan */
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 10px !important;
        opacity: 0.5; /* Samar saat diam */
        transition: all 0.2s ease;
    }

    /* Efek hover agar tombol terlihat jelas saat cell disorot */
    tr:hover .btn-edit-absolute,
    .btn-edit-absolute:hover {
        opacity: 1; /* Terlihat penuh */
        background: #fff !important; /* Latar putih pekat */
        border-color: #cbd5e1 !important;
        color: #3b82f6 !important; /* Warna primary */
    }

    /* Menambahkan padding kanan pada konten agar tidak tertabrak tombol */
    .cell-content-wrapper {
        padding-right: 25px; /* Beri ruang untuk tombol absolute */
    }
</style>
{{-- Skrip Khusus Modal Validasi --}}
<script>
    // Fungsi untuk mengganti input Link Drive vs Upload File
    function toggleMethod(selectElement, idPrefix) {
        const linkInput = document.getElementById(idPrefix + '_link');
        const fileInput = document.getElementById(idPrefix + '_file');
        
        if (selectElement.value === 'link') {
            linkInput.classList.remove('d-none');
            fileInput.classList.add('d-none');
        } else {
            linkInput.classList.add('d-none');
            fileInput.classList.remove('d-none');
        }
    }
</script>
@endsection
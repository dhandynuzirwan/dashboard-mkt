@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Monitoring Operasional Pelatihan</h3>
                <h6 class="text-muted mb-2 fw-normal">Pantau jadwal, instuktur, asessor, laporan administrasi, dan pengiriman sertifikat</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 mt-3 mt-md-0 d-flex gap-2">
                <button class="btn btn-white border btn-round fw-bold shadow-sm hover-lift px-3 text-dark pt-2">
                    <i class="fas fa-filter text-muted me-1"></i> Filter
                </button>
                <button class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">
                    <i class="fas fa-plus me-2"></i> Input Data Baru
                </button>
            </div>
        </div>

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Pelatihan Running</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">5 <span style="font-size: 14px;" class="text-muted fw-medium">Batch</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Laporan Pending</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">3 <span style="font-size: 14px;" class="text-muted fw-medium">Klien</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-info-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertif. Diterima</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">12 <span style="font-size: 14px;" class="text-muted fw-medium">Dokumen</span></h3>
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
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Sertif. Dikirim</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">8 <span style="font-size: 14px;" class="text-muted fw-medium">Resi</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" id="pills-tab" role="tablist">
                <button class="nav-link active" id="pills-running-tab" data-bs-toggle="pill" data-bs-target="#pills-running" type="button" role="tab">
                    <i class="fas fa-play-circle me-1"></i> Pelatihan Running
                </button>
                <button class="nav-link" id="pills-progress-tab" data-bs-toggle="pill" data-bs-target="#pills-progress" type="button" role="tab">
                    <i class="fas fa-tasks me-1"></i> Progress & Laporan
                </button>
                <button class="nav-link" id="pills-sertifikat-tab" data-bs-toggle="pill" data-bs-target="#pills-sertifikat" type="button" role="tab">
                    <i class="fas fa-award me-1"></i> Monitoring Sertifikat
                </button>
            </div>
        </div>

        {{-- ================= TAB CONTENT ================= --}}
        <div class="tab-content fade-in" id="pills-tabContent">
            
            {{-- TAB 1: PELATIHAN RUNNING --}}
            <div class="tab-pane fade show active" id="pills-running" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Daftar Pelatihan (Jadwal, Instruktur & Asesor)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            {{-- Karena kolomnya banyak, tabel dibuat sedikit lebih padat --}}
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1500px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="220">Klien & Program</th>
                                        <th width="150">Jadwal Tgl</th>
                                        <th width="180">Instruktur / Pengajar</th>
                                        <th width="200">Asesor & Lembaga (LSP/Disnaker)</th>
                                        <th width="150">PIC Inhouse & SPPD</th>
                                        <th class="text-center pe-4" width="100">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">PT. Pertamina Hulu Rokan</div>
                                            <div class="fw-bold text-primary mt-1" style="font-size: 13px;">Ahli K3 Umum</div>
                                            <span class="badge badge-soft-info border mt-1">Kemnaker RI</span>
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">Pelatihan:</small>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">05 - 07 Mei 2026</span>
                                            <small class="text-muted d-block mt-2">Assesmen:</small>
                                            <span class="fw-bold text-danger" style="font-size: 12px;">08 Mei 2026</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-medium d-block"><i class="fas fa-user-tie text-muted me-1"></i> Bpk. Ahmad Fauzi</span>
                                            <span class="text-dark fw-medium d-block mt-1"><i class="fas fa-user-tie text-muted me-1"></i> Bpk. Doni Salmanan</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">PJK3 / LSP:</small><br>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">PT. Arsa Safety</span><br>
                                            <small class="text-muted mt-1 d-block">Asesor / Disnaker:</small>
                                            <span class="fw-bold text-secondary" style="font-size: 12px;">Bpk. Budi (Disnaker Riau)</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block mb-1">Dimas (PIC Arsa)</span>
                                            <a href="#" class="badge badge-soft-success text-decoration-none border shadow-sm">
                                                <i class="fas fa-file-pdf me-1"></i> SPPD.pdf
                                            </a>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-primary rounded-pill px-3 shadow-sm"><i class="fas fa-spinner fa-spin me-1"></i> Running</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">PT. Wijaya Karya</div>
                                            <div class="fw-bold text-primary mt-1" style="font-size: 13px;">Operator Crane Kelas A</div>
                                            <span class="badge badge-soft-primary border mt-1">BNSP</span>
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">Pelatihan:</small>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">12 - 14 Mei 2026</span>
                                            <small class="text-muted d-block mt-2">Assesmen:</small>
                                            <span class="fw-bold text-danger" style="font-size: 12px;">15 Mei 2026</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-medium d-block"><i class="fas fa-user-tie text-muted me-1"></i> Bpk. Jono (Praktisi)</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">PJK3 / LSP:</small><br>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">LSP K3 Konstruksi</span><br>
                                            <small class="text-muted mt-1 d-block">Asesor / Disnaker:</small>
                                            <span class="fw-bold text-secondary" style="font-size: 12px;">Bpk. Ridwan (Asesor BNSP)</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block mb-1">Ayu (PIC ARSA)</span>
                                            <span class="badge bg-light text-muted border">- Belum Ada -</span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm">Persiapan</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: PROGRESS & LAPORAN --}}
            <div class="tab-pane fade" id="pills-progress" role="tabpanel">
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom p-3" style="border-radius: 16px 16px 0 0;">
                        <h6 class="m-0 fw-bolder text-dark">Laporan Internal & Administrasi Lembaga</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1400px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="250">Program & Tanggal</th>
                                        <th width="200">Nomor Sertifikat (Ref)</th>
                                        <th width="300">File Laporan (Internal & Admin)</th>
                                        <th width="250">Catatan Kekurangan Admin</th>
                                        <th width="250">Evaluasi / Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">Sertifikasi Ahli K3 Umum</div>
                                            <div class="text-muted fw-medium d-block mt-1">PT. Pertamina Hulu Rokan</div>
                                            <small class="text-primary fw-bold"><i class="far fa-calendar-alt me-1"></i> 05 - 07 Mei 2026</small>
                                        </td>
                                        <td>
                                            <span class="fw-bolder text-dark" style="letter-spacing: 0.5px;">K3.UM/2026/05/112</span><br>
                                            <small class="text-muted">Total: 15 Peserta</small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <a href="#" class="badge badge-soft-primary border text-decoration-none shadow-sm text-start py-2 px-2 hover-lift">
                                                    <i class="fas fa-file-word me-1"></i> Lap. Kegiatan Internal
                                                </a>
                                                <a href="#" class="badge badge-soft-warning text-dark border text-decoration-none shadow-sm text-start py-2 px-2 hover-lift">
                                                    <i class="fas fa-file-pdf me-1"></i> Lap. Admin Kemnaker
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="alert alert-modern-danger p-2 m-0 border-0">
                                                <small class="fw-bold d-block mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Kekurangan:</small>
                                                <ul class="mb-0 ps-3 small text-dark" style="font-size: 11px;">
                                                    <li>Pas foto peserta A.n Rahmat blm background merah.</li>
                                                    <li>Surat tugas dari perusahaan blm di stempel.</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 text-dark small" style="white-space: normal;">
                                                Pelatihan kondusif, trainer komunikatif. Makanan dari hotel agak telat saat coffee break sore. Selebihnya aman.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">Operator Crane Kelas A</div>
                                            <div class="text-muted fw-medium d-block mt-1">PT. Wijaya Karya</div>
                                            <small class="text-primary fw-bold"><i class="far fa-calendar-alt me-1"></i> 12 - 14 Mei 2026</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-muted border">- Menunggu Ujian -</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="badge bg-light text-muted border text-start py-2 px-2">
                                                    <i class="fas fa-minus me-1"></i> Belum ada file internal
                                                </span>
                                                <span class="badge bg-light text-muted border text-start py-2 px-2">
                                                    <i class="fas fa-minus me-1"></i> Belum ada file admin
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted small fst-italic">Administrasi lengkap 100%. Tinggal pelaksanaan.</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small fst-italic">- Belum ada evaluasi -</span>
                                        </td>
                                    </tr>
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
                        <h6 class="m-0 fw-bolder text-dark">Status Penerbitan & Pengiriman Sertifikat</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" style="min-width: 1400px;">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="220">Klien & Program</th>
                                        <th width="150">Timeline Sertifikat</th>
                                        <th width="150">Scan Dokumen</th>
                                        <th width="200">Logistik (Isi Paket)</th>
                                        <th width="220">Resi Pengiriman</th>
                                        <th class="text-center pe-4" width="150">Tanda Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">PT. Wijaya Karya</div>
                                            <small class="text-dark fw-bold d-block mt-1" style="font-size: 11px;">Operator Crane Kelas A</small>
                                            <small class="text-muted d-block mt-1">Up: Bpk. Anton (HRD)</small>
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">Estimasi Terbit:</small>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">20 Mei 2026</span>
                                            <small class="text-muted d-block mt-2">Diterima PJK3:</small>
                                            <span class="fw-bold text-success" style="font-size: 12px;">22 Mei 2026</span>
                                            <small class="text-muted d-block mt-2">Dikirim ke Klien:</small>
                                            <span class="fw-bold text-primary" style="font-size: 12px;">23 Mei 2026</span>
                                        </td>
                                        <td>
                                            <a href="#" class="badge badge-soft-info border text-decoration-none shadow-sm py-2 px-3 hover-lift d-inline-block text-center">
                                                <i class="fas fa-file-pdf fs-5 mb-1 d-block"></i> Scan_Sertif.pdf
                                            </a>
                                        </td>
                                        <td>
                                            <ul class="mb-0 ps-3 small text-dark" style="font-size: 11px;">
                                                <li>12 Sertifikat BNSP Asli</li>
                                                <li>12 Kartu Lisensi (ID Card)</li>
                                                <li>Hardcopy Invoice & Bukti Pajak</li>
                                                <li>Pin & Merchandise</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-danger border border-danger mb-1 fw-bold">JNE REG</span><br>
                                            <span class="fw-bolder text-dark d-block mb-2" style="letter-spacing: 1px;">01234567890123</span>
                                            <a href="#" class="badge bg-light text-dark border text-decoration-none shadow-sm px-2 py-1">
                                                <i class="fas fa-image me-1"></i> Foto_Resi.jpg
                                            </a>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm d-block mb-2">
                                                <i class="fas fa-check-circle me-1"></i> Delivered
                                            </span>
                                            <a href="#" class="badge badge-soft-success border text-decoration-none shadow-sm px-2 py-1">
                                                <i class="fas fa-file-signature me-1"></i> Tanda_Terima.pdf
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder text-dark">CV. Sumber Makmur</div>
                                            <small class="text-dark fw-bold d-block mt-1" style="font-size: 11px;">ISO 9001:2015</small>
                                            <small class="text-muted d-block mt-1">Up: Ibu Rina (Direktur)</small>
                                        </td>
                                        <td>
                                            <small class="text-muted d-block">Estimasi Terbit:</small>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">30 Mei 2026</span>
                                            <small class="text-muted d-block mt-2">Diterima PJK3:</small>
                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                            <small class="text-muted d-block mt-2">Dikirim ke Klien:</small>
                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-muted border py-2 px-3 text-center d-inline-block w-100">Belum ada file</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small fst-italic">Menunggu sertifikat fisik dari lembaga terbit.</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-muted border py-2 w-100">- Belum Dikirim -</span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="badge badge-soft-warning text-dark rounded-pill px-3 py-2 shadow-sm d-block border">
                                                <i class="fas fa-hourglass-half me-1"></i> On Process
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .text-warning-dark { color: #b45309 !important; }

    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-info-subtle { border-color: #a5f3fc !important; }
    .border-warning-subtle { border-color: #fef08a !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }

    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 14px 16px; }

    /* Custom Alert for Table */
    .alert-modern-danger { background-color: #fef2f2; border-radius: 8px; border-left: 3px solid #ef4444 !important; }

    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
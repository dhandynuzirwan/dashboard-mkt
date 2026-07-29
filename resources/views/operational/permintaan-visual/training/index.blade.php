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
    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }
    
    .table-custom { border-collapse: separate; border-spacing: 0 12px; margin-top: -12px;}
    .table-custom tr { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 16px; transition: all 0.2s ease; border: 1px solid #f1f3f9;}
    .table-custom tr:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
    .table-custom td { padding: 18px 22px; border: none; vertical-align: middle;}
    .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .table-custom th { border: none; padding: 10px 22px; color: #858796; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; background: transparent;}

    .badge-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #258391; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    
    .btn-premium { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); transition: all 0.3s; }
    .btn-premium:hover { box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4); color: white;}
    
    .btn-outline-premium { border: 2px solid #4e73df; color: #4e73df; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: all 0.3s; background: white;}
    .btn-outline-premium:hover { background: #4e73df; color: white; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); }

    .form-control-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-control-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    /* MODAL STYLES */
    .modal-content-modern { border-radius: 24px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);}
    .modal-header-modern { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;}
    .file-item-card { background: white; border: 1px solid #edf2f9; border-radius: 16px; transition: all 0.3s; padding: 20px;}
    .file-item-card:hover { border-color: #bac8f3; box-shadow: 0 5px 15px rgba(78, 115, 223, 0.08); }
    .file-icon-box { width: 50px; height: 50px; border-radius: 14px; background: rgba(78, 115, 223, 0.1); color: #4e73df; display: flex; align-items: center; justify-content: center; font-size: 24px;}
</style>

<div class="page-wrapper-modern fade-in">
    <div class="container-fluid py-4 px-3 px-md-4">
        
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">Permintaan Training</h2>
                <p class="text-muted mb-0" style="font-size: 15px;">Manajemen kebutuhan desain khusus untuk materi dan operasional pelatihan.</p>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-primary me-3 shadow-sm">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Total Training</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">12</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-warning me-3 shadow-sm">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Menunggu</p>
                        <div class="d-flex align-items-end gap-2">
                            <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">4</h3>
                            <span class="text-muted fw-bold mb-1" style="font-size: 11px;">(0 Berkas)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-info me-3 shadow-sm">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Dalam Proses</p>
                        <div class="d-flex align-items-end gap-2">
                            <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">5</h3>
                            <span class="text-muted fw-bold mb-1" style="font-size: 11px;">(≥1 Berkas)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-success me-3 shadow-sm">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Lengkap</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">3</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Data --}}
        <div class="glass-card p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-chalkboard text-primary me-2"></i> Data Pelatihan Bulan Ini</h5>
                
                {{-- Filter --}}
                <form action="#" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <input type="text" name="search" class="form-control-modern" placeholder="Cari pelatihan..." style="width: 250px;">
                    <input type="date" name="tanggal" class="form-control-modern" style="width: 150px;">
                    <button type="submit" class="btn btn-premium px-4"><i class="fas fa-filter me-1"></i> Filter</button>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom w-100">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="40%">Informasi Pelatihan</th>
                            <th width="35%">Status Kelengkapan Berkas</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data Mockup 1 --}}
                        <tr>
                            <td class="text-center text-muted fw-bold fs-5">1</td>
                            <td>
                                <div class="fw-bold text-dark mb-2" style="font-size: 16px;">Pelatihan Ahli K3 Umum</div>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="text-muted small fw-bold"><i class="fas fa-calendar-alt text-primary me-1"></i> 10 Ags - 22 Ags 2026</div>
                                    <div class="text-muted small fw-bold"><i class="fas fa-map-marker-alt text-danger me-1"></i> Hotel Amaris, Jakarta</div>
                                    <div class="text-muted small fw-bold"><i class="fas fa-certificate text-warning me-1"></i> Kemnaker RI</div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3 d-flex align-items-center gap-3">
                                    <span class="badge-soft-info">Dalam Proses</span>
                                    <span class="text-primary fw-bolder" style="font-size: 13px;">2/9 Berkas Terunggah</span>
                                </div>
                                <div class="text-dark small text-start mt-2" style="font-size: 13px;">
                                    Background Zoom, Banner
                                </div>
                                <div class="text-muted mt-2" style="font-size: 11px;">
                                    Diunggah oleh: <span class="fw-bold text-dark">Alex (Graphic)</span> &bull; <i class="far fa-clock"></i> 27 Jul 2026, 14:30
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-premium" data-bs-toggle="modal" data-bs-target="#modalDetailBerkas">
                                    <i class="fas fa-folder-open me-1"></i> Kelola Berkas
                                </button>
                            </td>
                        </tr>

                        {{-- Data Mockup 2 --}}
                        <tr>
                            <td class="text-center text-muted fw-bold fs-5">2</td>
                            <td>
                                <div class="fw-bold text-dark mb-2" style="font-size: 16px;">Pelatihan Auditor SMK3</div>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="text-muted small fw-bold"><i class="fas fa-calendar-alt text-primary me-1"></i> 15 Ags - 18 Ags 2026</div>
                                    <div class="text-muted small fw-bold"><i class="fas fa-map-marker-alt text-danger me-1"></i> Online Zoom</div>
                                    <div class="text-muted small fw-bold"><i class="fas fa-certificate text-warning me-1"></i> Kemnaker RI</div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-3 d-flex align-items-center gap-3">
                                    <span class="badge-soft-warning">Menunggu</span>
                                    <span class="text-muted fw-bolder" style="font-size: 13px;">0/9 Berkas Terunggah</span>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 11px;">
                                    Belum ada berkas yang diunggah
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-premium" data-bs-toggle="modal" data-bs-target="#modalDetailBerkas">
                                    <i class="fas fa-folder-open me-1"></i> Kelola Berkas
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- MODAL DETAIL BERKAS (PREMIUM UI) --}}
<div class="modal fade" id="modalDetailBerkas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bolder mb-1"><i class="fas fa-folder-open me-2 text-white-50"></i> Manajemen Berkas Desain Training</h4>
                    <p class="mb-0 text-white-50 fw-bold" style="font-size: 13px;">Pelatihan Ahli K3 Umum &bull; 10 Ags - 22 Ags 2026 &bull; Hotel Amaris</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-primary px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                        Dalam Proses
                    </div>
                    <button class="btn btn-light rounded-pill fw-bold text-success shadow-sm px-4">
                        <i class="fas fa-download me-2"></i> Unduh ZIP
                    </button>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="modal-body p-4 p-md-5" style="background-color: #f8f9fc;">
                
                @php
                    $berkasList = ['Background Zoom', 'Banner Kegiatan', 'Photo Profil Grup WA', 'Table Name', 'Lanyard', 'Sertifikat Internal', 'Rekap Foto', 'Rekap Video', 'Lainnya'];
                @endphp

                <div class="row g-4">
                    @foreach($berkasList as $index => $berkas)
                    <div class="col-md-6 col-xl-4">
                        <div class="file-item-card h-100 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="file-icon-box">
                                        @if($berkas == 'Rekap Video') <i class="fas fa-video"></i>
                                        @elseif($berkas == 'Background Zoom' || $berkas == 'Rekap Foto' || $berkas == 'Banner Kegiatan' || $berkas == 'Photo Profil Grup WA') <i class="fas fa-image"></i>
                                        @else <i class="fas fa-file-alt"></i> @endif
                                    </div>
                                    <h6 class="fw-bolder text-dark mb-0">{{ $berkas }}</h6>
                                </div>
                                @if($index < 2) 
                                    <span class="badge-soft-success"><i class="fas fa-check"></i> Ada</span>
                                @else
                                    <span class="badge bg-light text-muted border">Kosong</span>
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                @if($index < 2)
                                    <div class="position-relative rounded-3 overflow-hidden mb-3 border shadow-sm">
                                        <img src="https://placehold.co/600x400/e3e6f0/a1a1a1?text={{ str_replace(' ', '+', $berkas) }}" alt="Thumbnail" class="w-100 object-fit-cover" style="height: 140px;">
                                        
                                        @if($berkas == 'Rekap Video')
                                        <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                            <i class="fas fa-play text-white fs-5 ms-1"></i>
                                        </div>
                                        @endif
                                        
                                        <div class="position-absolute bottom-0 w-100 p-2 d-flex justify-content-between align-items-end" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                            <div class="text-white overflow-hidden text-truncate pe-2">
                                                <div class="fw-bold text-truncate" style="font-size: 12px;">{{ strtolower(str_replace(' ', '_', $berkas)) }}_final.{{ $berkas == 'Rekap Video' ? 'mp4' : 'jpg' }}</div>
                                                <div class="small opacity-75" style="font-size: 10px;">2.4 MB &bull; 27 Jul 2026, 14:30</div>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Unduh">
                                                <i class="fas fa-download" style="font-size: 12px;"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if(in_array(auth()->user()->role ?? 'graphic', ['graphic', 'superadmin', 'web_dev']))
                            <div class="mt-auto border-top pt-3">
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm mb-2 rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                        <input type="file" class="form-control form-control-sm border-0 py-2 px-3 bg-white" name="file_{{ $index }}[]" multiple>
                                        <button class="btn btn-primary px-3 fw-bold border-0" type="button" style="background: #4e73df;"><i class="fas fa-upload"></i></button>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-muted fw-bold" style="font-size: 10px;"><i class="fas fa-clone me-1"></i>Bisa multi file</span>
                                        @if($index < 2)
                                            <button type="button" class="btn btn-link text-danger p-0 text-decoration-none fw-bold" style="font-size: 11px;">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="modal-footer bg-white border-top-0 py-4 px-5">
                <button type="button" class="btn btn-light-modern" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection

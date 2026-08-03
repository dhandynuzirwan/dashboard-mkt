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

    .nav-pills-custom .nav-link {
        border-radius: 50px;
        padding: 10px 24px;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .nav-pills-custom .nav-link.active {
        background-color: #4e73df;
        color: #fff;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.35);
    }
    .nav-pills-custom .nav-link:hover:not(.active) {
        background-color: #f1f3f9;
        color: #4e73df;
    }
    .badge-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-warning { background-color: rgba(246, 194, 62, 0.15); color: #dda20a; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    .badge-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #258391; font-weight: 700; padding: 6px 12px; border-radius: 8px; }
    
    .btn-premium { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); transition: all 0.3s; }
    .btn-premium:hover { box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4); color: white;}
    .form-control-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-control-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    .form-select-modern { border-radius: 12px; border: 1px solid #e3e6f0; padding: 10px 15px; font-size: 14px; background-color: #f8f9fc; transition: all 0.3s; }
    .form-select-modern:focus { background-color: #fff; border-color: #bac8f3; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    
    .btn-light-modern { background: #ffffff; color: #6c757d; border: 2px solid #edf2f9; border-radius: 50px; padding: 8px 20px; font-weight: 700; transition: all 0.3s; }
    .btn-light-modern:hover { background: #f8f9fc; color: #4a5568; border-color: #d1d3e2; }
    
    /* MODAL STYLES */
    .modal-content-modern { border-radius: 24px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);}
    .modal-header-modern { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;}
</style>

<div class="container">
    <div class="page-inner">
        

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">Permintaan Biasa</h2>
                <p class="text-muted mb-0" style="font-size: 15px;">Manajemen visual untuk desain umum selain keperluan training.</p>
            </div>
            <a href="{{ route('operational.permintaan-visual.biasa.create') }}" class="btn btn-premium">
                <i class="fas fa-plus me-2"></i> Buat Permintaan
            </a>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-warning me-3 shadow-sm">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Menunggu</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">{{ $statMenunggu }}</h3>
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
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">{{ $statProses }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-primary me-3 shadow-sm">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Review</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">{{ $statReview }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card p-4 d-flex align-items-center h-100">
                    <div class="stat-icon-wrapper bg-gradient-success me-3 shadow-sm">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-1" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Selesai</p>
                        <h3 class="fw-black text-dark mb-0" style="font-size: 28px;">{{ $statSelesai }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                {{-- HISTORY CHART --}}
                <div class="glass-card p-4 h-100">
                    <h6 class="fw-bolder mb-3 text-dark">History Permintaan (Bulan Ini)</h6>
                    <div style="position: relative; height: 220px; width: 100%;">
                        @if(array_sum($chartData['history']) > 0)
                            <canvas id="historyChart"></canvas>
                        @else
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 opacity-50">
                                <i class="fas fa-chart-line fa-3x mb-3 text-muted"></i>
                                <span class="small text-muted fw-bold">Belum ada data history bulan ini</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- DOUGHNUT CHART --}}
                <div class="glass-card p-4 h-100">
                    <h6 class="fw-bolder mb-3 text-dark">Prioritas Permintaan</h6>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div style="position: relative; height: 180px; width: 100%;">
                            @if(array_sum($chartData['prioritas']) > 0)
                                <canvas id="prioritasChart"></canvas>
                            @else
                                <div class="d-flex flex-column justify-content-center align-items-center h-100 opacity-50">
                                    <i class="fas fa-chart-pie fa-3x mb-3 text-muted"></i>
                                    <span class="small text-muted fw-bold">Belum ada data prioritas</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB JENIS KEBUTUHAN --}}
        <div class="d-flex justify-content-center mb-5">
            <div class="glass-card p-2 d-inline-flex">
                <ul class="nav nav-pills-custom mb-0 d-flex flex-wrap gap-2" id="pills-tab-with-icon" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active filter-tab" href="#" data-filter="Semua">
                        <i class="fas fa-layer-group"></i> Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="#" data-filter="Cover Proposal">
                        <i class="fas fa-book"></i> Cover Proposal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="#" data-filter="Flyer/Poster">
                        <i class="fas fa-file-image"></i> Flyer/Poster
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="#" data-filter="Penjualan">
                        <i class="fas fa-shopping-cart"></i> Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="#" data-filter="Media Sosial">
                        <i class="fab fa-instagram"></i> Media Sosial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="#" data-filter="Presentasi">
                        <i class="fas fa-desktop"></i> Presentasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link filter-tab" href="javascript:void(0)" data-filter="Lainnya">
                        <i class="fas fa-ellipsis-h"></i> Lainnya
                    </a>
                </li>
            </ul>
        </div>
    </div>

        {{-- Table Data --}}
        <div class="glass-card p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-ul text-primary me-2"></i> Daftar Permintaan</h5>
                
                {{-- Filter --}}
                <form action="#" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <input type="text" name="search" class="form-control-modern" placeholder="Cari judul..." style="width: 200px;">
                    <select name="status" class="form-control-modern" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dalam Proses">Dalam Proses</option>
                    </select>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background-color: #4e73df; border:none;"><i class="fas fa-filter me-1"></i> Filter</button>
                </form>
            </div>
            
            <div class="table-responsive" style="min-height: 400px; overflow-y: visible; padding-bottom: 80px;">
                <table class="table table-custom w-100">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul Permintaan</th>
                            <th width="15%">Kategori & Tipe</th>
                            <th width="10%">Prioritas</th>
                            <th width="18%">Status</th>
                            <th width="12%">PIC Graphic</th>
                            <th width="12%">Tanggal</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permintaans as $index => $item)
                        <tr class="permintaan-row" data-kategori="{{ $item->kategori }}">
                            <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 15px;">{{ $item->judul }}</div>
                                <div class="text-muted small mt-1">Dibuat oleh: <span class="text-primary fw-bold">{{ $item->user->name ?? 'Unknown' }}</span></div>
                            </td>
                            <td>
                                @php
                                    $kategoriBadge = 'badge-soft-primary';
                                    if(str_contains(strtolower($item->kategori), 'flyer')) $kategoriBadge = 'badge-soft-info';
                                    elseif(str_contains(strtolower($item->kategori), 'media sosial')) $kategoriBadge = 'badge-soft-success';
                                    elseif(str_contains(strtolower($item->kategori), 'penjualan')) $kategoriBadge = 'badge-soft-warning';
                                @endphp
                                <span class="{{ $kategoriBadge }} d-inline-block mb-1">{{ $item->kategori }}</span><br>
                                @if($item->created_at->diffInDays(now()) < 3)
                                    <span class="badge bg-secondary text-white rounded-pill px-2" style="font-size:10px;">Baru</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $prioBadge = 'badge-soft-primary';
                                    $prioIcon = 'fa-minus';
                                    if($item->prioritas == 'Tinggi') { $prioBadge = 'badge-soft-danger'; $prioIcon = 'fa-arrow-up'; }
                                    elseif($item->prioritas == 'Sedang') { $prioBadge = 'badge-soft-warning'; $prioIcon = 'fa-equals'; }
                                    elseif($item->prioritas == 'Rendah') { $prioBadge = 'badge-soft-info'; $prioIcon = 'fa-arrow-down'; }
                                @endphp
                                <span class="{{ $prioBadge }} px-2 py-1 rounded-pill" style="font-size: 11px;"><i class="fas {{ $prioIcon }} me-1"></i> {{ $item->prioritas }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $statusBadge = 'badge-soft-secondary';
                                        $statusIcon = 'fa-clock';
                                        if($item->status == 'Menunggu') { $statusBadge = 'badge-soft-warning'; $statusIcon = 'fa-clock'; }
                                        elseif($item->status == 'Dalam Proses') { $statusBadge = 'badge-soft-info'; $statusIcon = 'fa-spinner fa-spin'; }
                                        elseif($item->status == 'Review') { $statusBadge = 'badge-soft-primary'; $statusIcon = 'fa-search'; }
                                        elseif($item->status == 'Selesai') { $statusBadge = 'badge-soft-success'; $statusIcon = 'fa-check-double'; }
                                        elseif($item->status == 'Batal') { $statusBadge = 'badge-soft-danger'; $statusIcon = 'fa-times'; }
                                    @endphp
                                    <span class="{{ $statusBadge }} px-2 py-1 rounded-pill fw-bold" style="font-size: 11px;"><i class="fas {{ $statusIcon }} me-1"></i> {{ $item->status }}</span>
                                </div>
                                @if($item->waktu_selesai)
                                <div class="text-muted small mt-2 fw-bold" style="font-size: 10px;">
                                    <i class="fas fa-stopwatch text-primary"></i> {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(\Carbon\Carbon::parse($item->waktu_selesai), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]) }}
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($item->pic)
                                    <div class="fw-bold text-dark small" style="font-size: 13px;">{{ $item->pic->name }}</div>
                                @else
                                    <span class="text-muted small fst-italic">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                <div class="text-muted small">Target: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px; border: 1px solid #e3e6f0;">
                                        <i class="fas fa-ellipsis-h text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                                        <li><a class="dropdown-item py-2 rounded-3" href="#" data-bs-toggle="modal" data-bs-target="#modalDetailPermintaan{{ $item->id }}"><i class="fas fa-eye text-primary me-2"></i> Detail</a></li>
                                        <li><a class="dropdown-item py-2 rounded-3" href="{{ route('operational.permintaan-visual.biasa.edit', $item->id) }}"><i class="fas fa-edit text-info me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('operational.permintaan-visual.biasa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data permintaan ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 rounded-3 text-danger border-0 bg-transparent" style="width: 100%; text-align: left;"><i class="fas fa-trash me-2"></i> Hapus Permanen</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" width="150" class="mb-3 opacity-50">
                                <h6 class="fw-bolder text-muted mb-0">Belum ada permintaan visual</h6>
                            </td>
                        </tr>
                        @endforelse
                        {{-- Baris khusus jika filter tab kosong --}}
                        <tr id="empty-state-row" style="display: none;">
                            <td colspan="8" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" width="150" class="mb-3 opacity-50">
                                <h6 class="fw-bolder text-muted mb-0">Belum ada data untuk kategori ini.</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PERMINTAAN (PREMIUM UI) --}}
@foreach($permintaans as $item)
<div class="modal fade" id="modalDetailPermintaan{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bolder mb-1"><i class="fas fa-file-invoice me-2 text-white-50"></i> Detail Permintaan Visual</h4>
                    <p class="mb-0 text-white-50 fw-bold" style="font-size: 13px;">{{ $item->judul }} &bull; Dibuat oleh {{ $item->user->name ?? 'Unknown' }}</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white {{ $item->prioritas == 'Tinggi' ? 'text-danger' : ($item->prioritas == 'Sedang' ? 'text-warning' : 'text-info') }} px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                        <i class="fas fa-arrow-{{ $item->prioritas == 'Tinggi' ? 'up' : ($item->prioritas == 'Sedang' ? 'right' : 'down') }} me-1"></i> Prioritas {{ $item->prioritas }}
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="modal-body p-4 p-md-5" style="background-color: #f8f9fc;">
                <div class="row g-4">
                    {{-- KOLOM INFO PERMINTAAN --}}
                    <div class="col-lg-8">
                        <div class="glass-card p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                <h5 class="fw-bolder text-dark mb-0"><i class="fas fa-info-circle text-primary me-2"></i> Informasi Kebutuhan</h5>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold"><i class="fas fa-edit me-1"></i> Edit</button>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Judul Permintaan</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $item->judul }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Kategori Desain</div>
                                <div class="col-sm-8"><span class="badge-soft-info px-3 py-1">{{ $item->kategori }}</span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Target Selesai</div>
                                <div class="col-sm-8 fw-bold text-dark"><i class="fas fa-calendar-alt text-danger me-1"></i> {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted fw-bold small">Tujuan/Kegunaan</div>
                                <div class="col-sm-8 text-dark">{{ $item->tujuan }}</div>
                            </div>
                            
                            <hr class="my-4" style="border-color: #edf2f9; opacity: 1;">
                            
                            <h6 class="fw-bolder text-dark mb-3">Deskripsi Kebutuhan Secara Detail</h6>
                            <div class="p-3 bg-light rounded-3 border mb-4 text-dark" style="font-size: 14px; line-height: 1.6;">
                                {!! nl2br(e($item->deskripsi)) !!}
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="fw-bolder text-dark mb-2">Referensi Desain</h6>
                                    @if($item->referensi_file)
                                    <div class="d-flex align-items-center p-3 rounded-3" style="background: #f4f7fe; border: 1px dashed #bac8f3;">
                                        <i class="fas fa-file-image text-primary fa-2x me-3"></i>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">{{ basename($item->referensi_file) }}</div>
                                            <div class="text-muted small">File Uploaded</div>
                                        </div>
                                        <a href="{{ asset('storage/' . $item->referensi_file) }}" target="_blank" class="btn btn-light rounded-circle text-primary shadow-sm ms-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="text-muted small fst-italic">Tidak ada referensi dilampirkan.</div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bolder text-dark mb-0">Komentar / Catatan</h6>
                                        <button class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-bold" style="font-size: 13px;"><i class="fas fa-edit me-1"></i> Edit/Tambah</button>
                                    </div>
                                    <div class="p-3 bg-light rounded-3 border h-100 text-dark small">
                                        @if($item->catatan)
                                            <em>"{!! nl2br(e($item->catatan)) !!}"</em>
                                        @else
                                            <span class="text-muted fst-italic">Belum ada komentar atau catatan revisi.</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM STATUS & HASIL --}}
                    <div class="col-lg-4">
                        <div class="glass-card p-4 mb-4">
                            <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-tasks text-warning me-2"></i> Status Pengerjaan</h6>
                            <form action="{{ route('operational.permintaan-visual.biasa.update-status', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <select class="form-select-modern w-100" name="status_update" id="statusSelect{{ $item->id }}" onchange="toggleRevisiNote({{ $item->id }})" @if(in_array(auth()->user()->role ?? 'graphic', ['karyawan'])) disabled @endif>
                                        <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Dalam Proses" {{ $item->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="Review" {{ $item->status == 'Review' ? 'selected' : '' }}>Review (Sudah di-upload)</option>
                                        <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Batal" {{ $item->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>
                                
                                <div id="revisi-note-area{{ $item->id }}" class="d-none">
                                    <label class="form-label fw-bold text-dark small mb-2">Komentar Revisi <span class="text-danger">*</span></label>
                                    <textarea class="form-control-modern w-100 mb-3" name="catatan_revisi" rows="3" placeholder="Tuliskan bagian mana yang perlu direvisi..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-premium w-100 py-2">Update Status</button>
                            </form>
                        </div>

                        {{-- AREA GRAPHIC TEAM --}}
                        <div class="glass-card p-4 border-primary border-2">
                            <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-paint-brush text-primary me-2"></i> Hasil Desain (Tim Graphic)</h6>
                            
                            @if($item->hasil_file)
                            <div class="d-flex align-items-center p-3 rounded-3 mb-3" style="background: #f4f7fe; border: 1px solid #bac8f3;">
                                <i class="fas fa-file-image text-success fa-2x me-3"></i>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 13px;">{{ basename($item->hasil_file) }}</div>
                                    <div class="text-muted small">Diunggah oleh: <strong>{{ $item->pic->name ?? 'Graphic' }}</strong></div>
                                    @if($item->waktu_selesai)
                                    <div class="text-primary small mt-1 fw-bold">
                                        <i class="fas fa-stopwatch me-1"></i> Durasi: {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(\Carbon\Carbon::parse($item->waktu_selesai), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]) }}
                                    </div>
                                    @endif
                                </div>
                                <a href="{{ asset('storage/' . $item->hasil_file) }}" download class="btn btn-sm btn-light text-primary rounded-circle shadow-sm ms-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Unduh">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            @else
                            <div class="text-muted small fst-italic mb-3">Belum ada hasil desain yang diunggah.</div>
                            @endif

                            @if(in_array(auth()->user()->role ?? 'graphic', ['graphic', 'superadmin', 'web_dev']))
                            <hr class="my-3 opacity-25">
                            <form action="{{ route('operational.permintaan-visual.biasa.upload-hasil', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="fw-bold text-dark small mb-2">Upload / Ganti File Hasil</label>
                                <div class="input-group input-group-sm mb-2 rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                    <input type="file" class="form-control form-control-sm border-0 py-2 px-3 bg-white" name="hasil_desain" required>
                                    <button class="btn btn-primary px-3 fw-bold border-0" type="submit" style="background: #4e73df;"><i class="fas fa-upload"></i></button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-white border-top-0 py-3 px-4">
                <button type="button" class="btn btn-light-modern px-4 py-2" data-bs-dismiss="modal">Tutup Modal</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Filter kategori berdasarkan tab
        const filterTabs = document.querySelectorAll('.filter-tab');
        const tableRows = document.querySelectorAll('.permintaan-row');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // hapus active dari semua tab
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const kategori = (row.getAttribute('data-kategori') || '').toLowerCase().trim();
                    const filter = filterValue.toLowerCase().trim();
                    
                    // Gunakan includes untuk pencarian string (misal: "Media Sosial" -> "media sosial")
                    if (filterValue === 'Semua' || kategori.includes(filter)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const emptyState = document.getElementById('empty-state-row');
                if (emptyState) {
                    if (visibleCount === 0) {
                        emptyState.style.display = '';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }
            });
        });

        // Doughnut Chart (Prioritas)
        if (document.getElementById('prioritasChart')) {
            var ctxPrioritas = document.getElementById('prioritasChart').getContext('2d');
            var prioritasChart = new Chart(ctxPrioritas, {
                type: 'doughnut',
                data: {
                    labels: ['Tinggi', 'Sedang', 'Rendah'],
                    datasets: [{
                        data: @json($chartData['prioritas']),
                        backgroundColor: ['#e74a3b', '#f6c23e', '#36b9cc'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 12, family: "'Nunito', sans-serif" }
                            }
                        }
                    }
                }
            });
        }

        // Line/Bar Chart (History)
        if (document.getElementById('historyChart')) {
            var ctxHistory = document.getElementById('historyChart').getContext('2d');
            var historyChart = new Chart(ctxHistory, {
                type: 'line',
                data: {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                    datasets: [{
                        label: 'Jumlah Permintaan',
                        data: @json($chartData['history']),
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderColor: '#4e73df',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4e73df',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#edf2f9' },
                            ticks: { stepSize: 5 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });

    // Toggle text area revisi
    function toggleRevisiNote(id) {
        var status = document.getElementById('statusSelect' + id).value;
        var revisiArea = document.getElementById('revisi-note-area' + id);
        if (status === 'Revisi') {
            revisiArea.classList.remove('d-none');
        } else {
            revisiArea.classList.add('d-none');
        }
    }
</script>
@endpush

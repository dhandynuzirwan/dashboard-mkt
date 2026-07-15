@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Data KPI</h3>
                <h6 class="op-7 mb-2">Key Performance Indicator Marketing</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info mt-1 px-3 py-2" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= FILTER SECTION ================= --}}
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('data-kpi') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <div class="d-flex flex-wrap gap-2">
                            {{-- Filter Tanggal Mulai --}}
                            <div class="form-group p-0 m-0">
                                <input type="date" name="start_date" class="form-control form-control-sm w-auto" value="{{ $start }}" title="Tanggal Mulai">
                            </div>

                            {{-- Filter Tanggal Akhir --}}
                            <div class="form-group p-0 m-0">
                                <input type="date" name="end_date" class="form-control form-control-sm w-auto" value="{{ $end }}" title="Tanggal Akhir">
                            </div>

                            {{-- Filter Karyawan --}}
                            @if(auth()->user()->role !== 'marketing')
                            <div class="form-group p-0 m-0">
                                <select name="marketing_id" class="form-select form-select-sm w-auto">
                                    <option value="">Semua Marketing</option>
                                    @foreach($all_marketing as $m)
                                        <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <button type="submit" class="btn btn-primary btn-sm btn-round">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('data-kpi') }}" class="btn btn-light border btn-sm btn-round">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= STAT CARDS KHUSUS SUPERADMIN & SPV ================= --}}
        @if(in_array(auth()->user()->role, ['superadmin', 'spv_marketing']))
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total KPI Keseluruhan</p>
                                    <h4 class="card-title">{{ number_format($total_kpi_avg ?? 0, 1) }}%</h4>
                                    <small class="text-muted" style="font-size:10px;">AVG Total KPI</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">HPP% (Bulan Ini)</p>
                                    <h4 class="card-title">{{ number_format($hpp_percent ?? 0, 1) }}%</h4>
                                    <small class="text-muted" style="font-size:10px;">HPP / Total Income</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Komisi SPV</p>
                                    <h4 class="card-title">Rp {{ number_format($komisi_spv ?? 0, 0, ',', '.') }}</h4>
                                    <small class="text-muted" style="font-size:10px;">Berdasarkan Fee Mkt</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

                {{-- ================= STYLES UNTUK MICRO CARDS ================= --}}
        <style>
            .micro-card-wrapper {
                position: relative;
                height: 110px; /* TINGGI DEFAULT KARTU */
                margin-bottom: 20px;
            }
            .micro-card {
                position: absolute;
                top: 0;
                left: 10px;
                right: 10px;
                background: #ffffff;
                border-radius: 14px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.03);
                transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
                overflow: hidden;
                z-index: 1;
                height: 110px; /* SAMA DENGAN WRAPPER */
                border: 1px solid #eef2f7;
            }
            .micro-card:hover {
                height: 380px; /* EKSPANSI TINGGI KARTU */
                z-index: 100;
                box-shadow: 0 25px 50px rgba(0,0,0,0.15);
                border-color: #bfdbfe;
            }
            .micro-card-header {
                height: 110px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 12px 16px;
                cursor: pointer;
                background-color: #fff;
            }
            .micro-card:hover .micro-card-header {
                background-color: #f8fafc;
                border-bottom: 1px solid #eef2f7;
            }
            .hover-details {
                padding: 16px;
                opacity: 0;
                transform: translateY(-15px);
                transition: all 0.3s ease;
                visibility: hidden;
            }
            .micro-card:hover .hover-details {
                opacity: 1;
                transform: translateY(0);
                visibility: visible;
                transition-delay: 0.1s;
            }
            .text-truncate-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;  
                overflow: hidden;
            }
        </style>

        {{-- ================= CARD DATA KPI (MICRO CARDS 4x3) ================= --}}
        <div class="row">
            @foreach ($marketings as $m)
                @php
                    $total_kpi = $m->total_kpi;
                    $badgeClass = $total_kpi >= 70 ? 'bg-success' : 'bg-danger';
                @endphp
                {{-- MENGGUNAKAN COL-LG-3 UNTUK 4 KOLOM --}}
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="micro-card-wrapper">
                        <div class="micro-card">
                            
                            {{-- HEADER (SELALU TAMPIL) --}}
                            <div class="micro-card-header">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-sm me-2 flex-shrink-0">
                                        <span class="avatar-title rounded-circle bg-primary-gradient fw-bold shadow-sm" style="font-size: 11px;">
                                            {{ substr($m->nama_lengkap ?? $m->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="overflow-hidden w-100">
                                        <h6 class="fw-bolder mb-0 text-dark text-truncate" style="font-size: 13px;">{{ $m->nama_lengkap ?? $m->name }}</h6>
                                        <div class="text-muted text-truncate" style="font-size: 10px;">{{ $m->name }}</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1 bg-light rounded px-2 py-1 border">
                                    <span class="text-muted fw-bold" style="font-size: 11px;">TOTAL KPI</span>
                                    <span class="badge {{ $badgeClass }} shadow-sm" style="font-size: 11px;">{{ number_format($total_kpi, 1) }}%</span>
                                </div>
                            </div>

                            {{-- DETAILS (TAMPIL SAAT HOVER) --}}
                            <div class="hover-details bg-white">
                                
                                {{-- ABSENSI --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted fw-bold" style="font-size: 11px;"><i class="fas fa-calendar-check text-info me-1"></i> Absen (10%)</span>
                                        <span class="fw-bold text-info" style="font-size: 12px;">{{ number_format($m->absensi_kpi, 1) }}%</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted">Target (Hadir):</span>
                                        <span class="fw-bold text-dark">{{ $m->absensi_hadir }} / {{ $m->absensi_jadwal }} Hari</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $m->absensi_ach > 100 ? 100 : $m->absensi_ach }}%;"></div>
                                    </div>
                                </div>
                                
                                {{-- PROGRESS (3 KOMPONEN) --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted fw-bold" style="font-size: 11px;"><i class="fas fa-chart-line text-warning me-1"></i> Progress (30%)</span>
                                        <span class="fw-bold text-warning" style="font-size: 12px;">{{ number_format($m->progress_kpi, 1) }}%</span>
                                    </div>
                                    
                                    <div class="p-2 bg-light rounded border border-light">
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                            <span class="text-muted">Update:</span>
                                            <span class="fw-bold text-dark">{{ $m->detail_update_data }} ({{ number_format($m->skor_update, 1) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                            <span class="text-muted">Akhir Data:</span>
                                            <span class="fw-bold text-dark">{{ $m->detail_akhir_data }} ({{ number_format($m->skor_akhir, 1) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                            <span class="text-muted">Penawaran:</span>
                                            <span class="fw-bold text-dark">{{ $m->detail_penawaran }} ({{ number_format($m->skor_penawaran, 1) }}%)</span>
                                        </div>
                                    </div>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $m->progress_ach > 100 ? 100 : $m->progress_ach }}%;"></div>
                                    </div>
                                </div>

                                {{-- REVENUE --}}
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted fw-bold" style="font-size: 11px;"><i class="fas fa-money-bill-wave text-success me-1"></i> Revenue (60%)</span>
                                        <span class="fw-bold text-success" style="font-size: 12px;">{{ number_format($m->revenue_kpi, 1) }}%</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted">Target:</span>
                                        <span class="fw-medium text-dark">Rp {{ number_format($m->revenue_target, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 10px;">
                                        <span class="text-muted">Aktual:</span>
                                        <span class="fw-bold text-success">Rp {{ number_format($m->revenue_actual, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $m->revenue_ach > 100 ? 100 : $m->revenue_ach }}%;"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(count($marketings) == 0)
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fs-1 text-muted mb-3 opacity-50"></i>
                    <h5 class="text-muted">Belum ada data KPI pada rentang waktu ini.</h5>
                </div>
            @endif
        </div>

        {{-- ================= TABEL BREAKDOWN KPI ================= --}}
        <div class="card card-round shadow-sm border-0 mt-2 mb-4 fade-in">
            <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-primary me-2"></i> Breakdown Rincian KPI</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 12px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="250">Marketing</th>
                                <th>Detail Absensi (10%)</th>
                                <th>Detail Progress (30%)</th>
                                <th>Detail Revenue (60%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bolder text-dark" style="font-size: 13px;">{{ $m->nama_lengkap ?? $m->name }}</div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 mt-1">{{ $m->name }}</span>
                                </td>
                                
                                <td>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 180px;">
                                        <span class="text-muted">Jadwal:</span> <span class="fw-bold">{{ $m->absensi_jadwal }} Hari</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 180px;">
                                        <span class="text-muted">Hadir:</span> <span class="text-success fw-bold">{{ $m->absensi_hadir }} Hari</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 180px;">
                                        <span class="text-muted">Tidak Hadir:</span> <span class="text-danger fw-bold">{{ $m->absensi_jadwal - $m->absensi_hadir }} Hari</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 pt-1 border-top border-light" style="max-width: 180px;">
                                        <span class="fw-bold">Total Absensi:</span> <span class="fw-bolder text-info">{{ number_format($m->absensi_kpi, 1) }}%</span>
                                    </div>
                                </td>
                                
                                <td>

                                    <div class="d-flex justify-content-between mb-1" style="max-width: 200px;">
                                        <span class="text-muted">Update Data:</span> <span class="fw-bold">{{ $m->detail_update_data }} Data</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 200px;">
                                        <span class="text-muted">Akhir Data:</span> <span class="fw-bold">{{ $m->detail_akhir_data }} Data</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 200px;">
                                        <span class="text-muted">Penawaran:</span> <span class="fw-bold">{{ $m->detail_penawaran }} Data</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 pt-1 border-top border-light" style="max-width: 200px;">
                                        <span class="fw-bold">Total Progress:</span> <span class="fw-bolder text-warning">{{ number_format($m->progress_kpi, 1) }}%</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 220px;">
                                        <span class="text-muted">Target:</span> <span class="fw-bold">Rp {{ number_format($m->revenue_target, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1" style="max-width: 220px;">
                                        <span class="text-muted">Pencapaian:</span> <span class="text-success fw-bold">Rp {{ number_format($m->revenue_actual, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 pt-1 border-top border-light" style="max-width: 220px;">
                                        <span class="fw-bold">Total Revenue:</span> <span class="fw-bolder text-success">{{ number_format($m->revenue_kpi, 1) }}%</span>
                                    </div>
                                    @php
                                        // Kalkulasi Nilai KPI Rp Berdasarkan Ruleset (60jt threshold)
                                        $kpi_rp = ($m->revenue_actual < 60000000) ? $m->revenue_actual * 0.40 : $m->revenue_actual * 0.60;
                                    @endphp
                                    <div class="d-flex justify-content-between mt-1 pt-1" style="max-width: 220px;">
                                        <span class="fw-bold">Nilai Revenue:</span> <span class="fw-bolder text-dark">Rp {{ number_format($kpi_rp, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

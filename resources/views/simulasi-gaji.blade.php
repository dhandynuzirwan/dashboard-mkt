@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Take Home Pay</h3>
                <h6 class="text-muted mb-2 fw-normal">Monitoring Gaji Bersih Karyawan</h6>
                
                {{-- Jam Realtime Modern --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border bg-white" style="color: #0ea5e9; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

                {{-- ================= FILTER SECTION (MODERN SAAS) ================= --}}
        <div class="card card-modern mb-4 fade-in" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Periode Penggajian</h6>
                </div>

                <form action="{{ route('simulasi-gaji') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $start }}" title="Tanggal Mulai">
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $end }}" title="Tanggal Akhir">
                    </div>

                    @if(auth()->user()->role !== 'marketing')
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <label class="label-modern">Pilih Karyawan (Marketing)</label>
                        <select name="marketing_id" class="form-select form-select-sm input-modern shadow-none">
                            <option value="">Semua Marketing</option>
                            @foreach($all_marketing as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-sm-12 col-md-12 col-lg-3 d-flex gap-2 mt-4 mt-lg-0">
                        <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift w-100 shadow-sm">
                            <i class="fas fa-search me-1"></i> Proses Data
                        </button>
                        <a href="{{ route('simulasi-gaji') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark hover-lift w-100 text-center shadow-sm pt-2">
                            <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(auth()->user()->role !== 'marketing')
        {{-- ================= STAT CARDS SUPERADMIN ================= --}}
        <div class="row fade-in mb-3">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-white rounded-circle">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers text-white">
                                    <p class="card-category text-white mb-1 fw-bold text-uppercase" style="font-size: 11px; opacity: 0.8;">Total Take Home Pay</p>
                                    <h4 class="card-title text-white fw-bolder mb-0 fs-5">Rp {{ number_format($total_thp, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-white rounded-circle">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers text-white">
                                    <p class="card-category text-white mb-1 fw-bold text-uppercase" style="font-size: 11px; opacity: 0.8;">Total Income</p>
                                    <h4 class="card-title text-white fw-bolder mb-0 fs-5">Rp {{ number_format($total_income, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-white rounded-circle">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers text-white">
                                    <p class="card-category text-white mb-1 fw-bold text-uppercase" style="font-size: 11px; opacity: 0.8;">Total Fee Marketing</p>
                                    <h4 class="card-title text-white fw-bolder mb-0 fs-5">Rp {{ number_format($total_fee_marketing, 0, ',', '.') }}</h4>
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
        height: 145px; /* TINGGI DEFAULT KARTU */
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
        height: 145px; /* SAMA DENGAN WRAPPER */
        border: 1px solid #eef2f7;
    }
    .micro-card:hover {
        height: 310px; /* EKSPANSI TINGGI KARTU */
        z-index: 100;
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        border-color: #bfdbfe;
    }
    .micro-card-header {
        height: 145px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 12px 16px;
        cursor: pointer;
        background-color: #fff;
    }
    .micro-card:hover .micro-card-header {
        background-color: #f8fafc;
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
</style>

{{-- ================= CARD SIMULASI GAJI (MICRO CARDS 4x3) ================= --}}
@if(auth()->user()->role === 'marketing')

    {{-- TABEL SIMULASI GAJI (KHUSUS MARKETING) --}}
    <div class="row fade-in mb-4 mt-3">
        <div class="col-12">
            <div class="card card-modern shadow-sm border-0 mb-4 fade-in">
                <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="card-title fw-bolder mb-0 text-dark">Rincian Perhitungan Take Home Pay</h6>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th class="ps-4" width="220">Marketing & Target</th>
                                    <th>Detail Pencapaian KPI</th>
                                    <th class="text-center" width="140">Skor KPI Akhir</th>
                                    <th>Komponen Pendapatan</th>
                                    <th>Komponen Variabel (Insentif)</th>
                                    <th class="text-end pe-4" width="200">Take Home Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $m)
                                    <tr>
                                        {{-- Kolom 1: Marketing & Target Income --}}
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 16px;">
                                                    {{ substr($m->nama_lengkap ?? $m->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bolder text-dark" style="font-size: 14px;">{{ $m->nama_lengkap ?? $m->name }}</span><br>
                                                    <span class="badge bg-light text-muted border mt-1 fw-medium">
                                                        {{ $m->name }}
                                                    </span><br>
                                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 mt-1 fw-medium">
                                                        Income: Rp {{ number_format($m->income, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
    
                                        {{-- Kolom 2: Rincian Pencapaian KPI --}}
                                        <td class="py-4">
                                            <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                <div class="d-flex justify-content-between align-items-center p-2 rounded bg-light border border-white shadow-sm" style="max-width: 250px;">
                                                    <span class="text-muted fw-bold"><i class="fas fa-calendar-check text-info me-2"></i>Absensi (10%)</span>
                                                    <div class="text-end">
                                                        <span class="fw-bolder text-dark">{{ number_format($m->ach_absensi, 1) }}%</span>
                                                        <span class="text-muted d-block" style="font-size: 9px;">({{ $m->absensi_hadir_real }}/{{ $hariEfektif }} Hari)</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-2 rounded bg-light border border-white shadow-sm" style="max-width: 250px;">
                                                    <span class="text-muted fw-bold"><i class="fas fa-chart-line text-warning me-2"></i>Progress (30%)</span>
                                                    <div class="text-end">
                                                        <span class="fw-bolder text-dark">{{ number_format($m->ach_progress, 1) }}%</span>
                                                        <span class="text-muted d-block" style="font-size: 9px;">({{ $m->real_penawaran }}/{{ $m->target_penawaran }} Penawaran)</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center p-2 rounded bg-light border border-white shadow-sm" style="max-width: 250px;">
                                                    <span class="text-muted fw-bold"><i class="fas fa-money-bill-wave text-success me-2"></i>Revenue (60%)</span>
                                                    <span class="fw-bolder text-dark">{{ number_format($m->ach_revenue, 1) }}%</span>
                                                </div>
                                            </div>
                                        </td>
    
                                        {{-- Kolom 3: Skor KPI Akhir --}}
                                        <td class="py-4 text-center">
                                            @if($m->kpi_persen >= 70)
                                                <div class="badge bg-success shadow-sm rounded-pill px-3 py-2 fs-6 mb-1">
                                                    {{ number_format($m->kpi_persen, 1) }}%
                                                </div>
                                                <small class="d-block text-success fw-bold" style="font-size: 10px;">Sesuai KPI</small>
                                            @else
                                                <div class="badge bg-danger shadow-sm rounded-pill px-3 py-2 fs-6 mb-1">
                                                    {{ number_format($m->kpi_persen, 1) }}%
                                                </div>
                                                <small class="d-block text-danger fw-bold" style="font-size: 10px;">Di Bawah Target</small>
                                            @endif
                                        </td>
    
                                        {{-- Kolom 4: Komponen Pendapatan --}}
                                        <td class="py-4">
                                            <div class="p-3 rounded-4 border border-light shadow-sm" style="background-color: #f8fafc; font-size: 11px;">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted fw-medium">Gaji Pokok:</span>
                                                    <span class="fw-bold text-dark">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted fw-medium">Tunj. BPJS:</span>
                                                    <span class="fw-bold text-success">+ Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                                <hr class="my-2 border-secondary opacity-25">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bolder text-dark" style="font-size: 10px;">Total (Inc BPJS & Fee):</span>
                                                    <span class="fw-bolder text-success">Rp {{ number_format($m->total_gaji, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>
    
                                        {{-- Kolom 5: Komponen Variabel --}}
                                        <td class="py-4">
                                            <div class="p-3 rounded-4 border-primary-subtle border shadow-sm" style="background-color: #f0f5ff; font-size: 11px;">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted fw-medium">Nilai Revenue:</span>
                                                    <span class="fw-bold text-dark">Rp {{ number_format($m->kpi_rp, 0, ',', '.') }}</span>
                                                </div>
                                                <hr class="my-2 border-primary opacity-25">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-primary fw-bolder"><i class="fas fa-coins me-1"></i> Fee Sales:</span>
                                                    <span class="fw-bolder text-primary" style="font-size: 13px;">Rp {{ number_format($m->fee_marketing ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>
    
                                        {{-- Kolom 6: TOTAL TAKE HOME PAY --}}
                                        <td class="py-4 text-end pe-4 align-middle">
                                            <div class="d-inline-block text-end">
                                                <p class="label-modern text-muted mb-1">TOTAL DITERIMA</p>
                                                <h4 class="fw-bolder text-success mb-2 lh-1">
                                                    Rp {{ number_format($m->gapok_hitung + ($m->fee_marketing ?? 0), 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @if(count($marketings) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fs-1 mb-3 text-light"></i><br>
                                            Belum ada data untuk ditampilkan pada rentang waktu ini.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- TAMPILAN MICRO CARDS 4x3 (UNTUK SUPERADMIN / ROLE LAIN) --}}
<div class="row fade-in mb-4">
    @foreach ($marketings as $m)
        @php
            $total_kpi = $m->kpi_persen;
            $badgeClass = $total_kpi >= 70 ? 'bg-success' : 'bg-danger';
        @endphp
        <div class="col-md-4 col-lg-3 col-sm-6">
            <div class="micro-card-wrapper">
                <div class="micro-card">
                    
                    {{-- HEADER (SELALU TAMPIL) --}}
                    <div class="micro-card-header">
                        <div class="d-flex align-items-center mb-2 pb-1 border-bottom border-light">
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
                        
                        {{-- 3 METRIK UTAMA --}}
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted fw-bold" style="font-size: 10px;">Income</span>
                            <span class="fw-bold text-success" style="font-size: 11px;">Rp {{ number_format($m->income, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted fw-bold" style="font-size: 10px;">Fee Sales</span>
                            <span class="fw-bold text-primary" style="font-size: 11px;">Rp {{ number_format($m->fee_marketing ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1 pt-1 bg-light rounded px-2 border">
                            <span class="fw-bolder text-dark" style="font-size: 10px;">THP</span>
                            <span class="fw-black text-success" style="font-size: 13px;">Rp {{ number_format($m->gapok_hitung + ($m->fee_marketing ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- DETAILS (TAMPIL SAAT HOVER) --}}
                    <div class="hover-details bg-white border-top">
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted fw-bold" style="font-size: 11px;">Skor KPI Akhir</span>
                                <span class="fw-bold {{ $total_kpi >= 70 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">{{ number_format($total_kpi, 1) }}%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted fw-bold" style="font-size: 11px;">Nilai Revenue</span>
                                <span class="fw-bold text-dark" style="font-size: 11px;">Rp {{ number_format($m->kpi_rp, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <hr class="my-2 border-secondary opacity-10">
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted" style="font-size: 10px;">Gaji Pokok:</span>
                                <span class="fw-bold text-dark" style="font-size: 10px;">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted" style="font-size: 10px;">Tunj. BPJS:</span>
                                <span class="fw-bold text-success" style="font-size: 10px;">+ Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-1 border-secondary opacity-10">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-dark" style="font-size: 10px;">Total (Inc BPJS & Fee):</span>
                                <span class="fw-bolder text-success" style="font-size: 10px;">Rp {{ number_format($m->total_gaji, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if(count($marketings) == 0)
        <div class="col-12 text-center py-5">
            <i class="fas fa-folder-open fs-1 mb-3 text-light"></i><br>
            <h5 class="text-muted">Belum ada data untuk ditampilkan pada rentang waktu ini.</h5>
        </div>
    @endif
</div>
@endif
@if(auth()->user()->role === 'superadmin')
{{-- ================= TABEL SUMMARY KHUSUS SUPERADMIN (RINGKAS) ================= --}}
<div class="row fade-in mb-3">
    <div class="col-12">
        <div class="card card-round shadow-sm border-0 mb-3">
            <div class="card-body p-2 px-3">
                <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                    <i class="fas fa-briefcase text-primary me-2"></i>
                    <span class="fw-bolder text-dark" style="font-size: 13px;">Ringkasan Komisi & Rasio (Khusus Superadmin)</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0 text-center align-middle" style="white-space: nowrap; font-size: 11px;">
                        <thead class="text-muted border-bottom">
                            <tr>
                                <th class="text-start pb-1">Avg KPI</th>
                                <th class="pb-1">Fee Marketing</th>
                                <th class="pb-1">Komisi SPV</th>
                                <th class="pb-1">Komisi TL</th>
                                <th class="pb-1">Total Keluar</th>
                                <th class="pb-1">Rasio Fee</th>
                                <th class="pb-1">Rasio Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start pt-2">
                                    <span class="fw-bolder {{ ($total_kpi_avg ?? 0) >= 70 ? 'text-success' : 'text-danger' }}">{{ number_format($total_kpi_avg ?? 0, 1) }}%</span>
                                </td>
                                <td class="pt-2"><span class="fw-bold text-success">Rp {{ number_format($total_fee_marketing ?? 0, 0, ',', '.') }}</span></td>
                                <td class="pt-2">
                                    <span class="fw-bold text-primary">Rp {{ number_format($komisi_spv ?? 0, 0, ',', '.') }}</span>
                                    <span class="text-muted ms-1" style="font-size: 9px;">({{ ($total_kpi_avg ?? 0) >= 70 ? '10%' : '5%' }})</span>
                                </td>
                                <td class="pt-2">
                                    <span class="fw-bold text-warning">Rp {{ number_format($komisi_tl ?? 0, 0, ',', '.') }}</span>
                                    <span class="text-muted ms-1" style="font-size: 9px;">({{ ($total_kpi_avg ?? 0) >= 70 ? '5%' : '2.5%' }})</span>
                                </td>
                                <td class="pt-2">
                                    <span class="fw-bold text-danger">Rp {{ number_format($total_fee_dikeluarkan ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="pt-2">
                                    <span class="badge bg-secondary shadow-sm" style="font-size: 10px;">{{ number_format($rasio_fee_revenue ?? 0, 1) }}%</span>
                                </td>
                                <td class="pt-2">
                                    <span class="badge bg-dark shadow-sm" style="font-size: 10px;">{{ number_format($rasio_gaji_revenue ?? 0, 1) }}%</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ================= INFO & KETERANGAN (MODERN) ================= --}}
        <div class="row fade-in">
            <div class="col-md-6 d-flex flex-column gap-3 mb-3">
                <!-- Komposisi THP -->
                <div class="alert-modern-info d-flex align-items-start p-3 h-100 shadow-sm" style="border-radius: 12px; background-color: #f0f9ff; border-left: 4px solid #0ea5e9;">
                    <div class="icon-sm bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 35px; height: 35px;">
                        <i class="fas fa-wallet fs-6"></i>
                    </div>
                    <div>
                        <h6 class="fw-bolder text-dark mb-1">Komposisi Take Home Pay</h6>
                        <div class="bg-white px-3 py-2 mt-2 rounded-3 border fw-bold small text-dark shadow-sm">
                            Gaji Pokok + Fee Marketing
                        </div>
                    </div>
                </div>

                <!-- Perhitungan KPI -->
                <div class="alert-modern-warning d-flex align-items-start p-3 h-100 shadow-sm" style="border-radius: 12px; background-color: #fffbeb; border-left: 4px solid #f59e0b;">
                    <div class="icon-sm bg-white text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 35px; height: 35px;">
                        <i class="fas fa-chart-pie fs-6"></i>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bolder text-dark mb-1">Perhitungan Skor KPI</h6>
                        <p class="small text-muted mb-2">Total bobot KPI terbagi menjadi 3 komponen utama.</p>
                        
                        <div class="bg-white p-3 rounded-3 border shadow-sm">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between fw-bold text-dark small mb-1">
                                    <span>1. Absensi</span>
                                    <span class="text-warning">10%</span>
                                </div>
                                <div class="progress" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 10%"></div></div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between fw-bold text-dark small mb-1">
                                    <span>2. Progres Database</span>
                                    <span class="text-warning">30%</span>
                                </div>
                                <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 30%"></div></div>
                            </div>

                            <div class="mb-1">
                                <div class="d-flex justify-content-between fw-bold text-dark small mb-1">
                                    <span>3. Revenue</span>
                                    <span class="text-warning">60%</span>
                                </div>
                                <div class="progress" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 60%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <!-- Perhitungan Fee Marketing -->
                <div class="alert-modern-info d-flex align-items-start p-3 h-100 shadow-sm" style="border-radius: 12px; background-color: #f0fdf4; border-left: 4px solid #10b981;">
                    <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 35px; height: 35px;">
                        <i class="fas fa-money-bill-wave fs-6"></i>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bolder text-dark mb-1">Perhitungan Fee Marketing & Syarat KPI</h6>
                        <ul class="list-group list-group-flush rounded border shadow-sm small fw-bold mt-2">
                            <li class="list-group-item p-3">
                                <span class="d-block text-danger mb-1"><i class="fas fa-exclamation-circle me-1"></i></span>
                                Jika Revenue < Rp 30.000.000 & KPI < 70% <br>
                                <span class="text-muted"><i class="fas fa-arrow-right me-1"></i> THP = Gaji Pokok (Tanpa Fee & KPI)</span>
                            </li>
                            <li class="list-group-item p-3">
                                <span class="d-block text-primary mb-1"><i class="fas fa-hand-holding-usd me-1"></i></span>
                                Jika Revenue >= Rp 30.000.000 & KPI < 70% <br>
                                <span class="text-muted"><i class="fas fa-arrow-right me-1"></i> THP = Revenue * 40% * 2%</span>
                            </li>
                            <li class="list-group-item p-3">
                                <span class="d-block text-success mb-1"><i class="fas fa-star me-1"></i></span>
                                Jika Skor KPI >= 70% <br>
                                <span class="text-muted"><i class="fas fa-arrow-right me-1"></i> THP = Revenue * 60% * 5%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .text-warning-dark { color: #b45309 !important; }
    .border-primary-subtle { border-color: #bfdbfe !important; }

    /* Alert Modern */
    .alert-modern-info {
        background-color: #f0f9ff;
        border-left: 4px solid #0ea5e9;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .alert-modern-warning {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    /* Table Modern */
    .table-modern th {
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
    }
    .table-modern td {
        border-bottom: 1px solid #f1f5f9;
    }

    /* Form Modern */
    .label-modern {
        font-weight: 700;
        color: #64748b;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: block;
    }
    .input-modern {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        color: #334155;
    }
    .input-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
</style>

{{-- ================= SCRIPTS ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();
    });
</script>
@endsection
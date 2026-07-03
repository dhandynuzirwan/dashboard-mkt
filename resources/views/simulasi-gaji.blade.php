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
    {{-- TAMPILAN BARIS DETAIL (KHUSUS MARKETING) --}}
    @foreach ($marketings as $m)
        @php
            $total_kpi = $m->kpi_persen;
        @endphp
        <div class="row fade-in mb-4">
            <div class="col-md-12">
                <div class="card card-modern shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                            <div class="avatar avatar-md me-3 flex-shrink-0">
                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold shadow-sm fs-5">
                                    {{ substr($m->nama_lengkap ?? $m->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="fw-bolder mb-1 text-dark">{{ $m->nama_lengkap ?? $m->name }}</h4>
                                <span class="badge bg-primary-subtle text-primary">Marketing Sales</span>
                            </div>
                            <div class="ms-auto text-end">
                                <a href="{{ route('penggajian.preview', $m->id) }}" target="_blank" class="btn btn-primary btn-round shadow-sm fw-bold">
                                    <i class="fas fa-print me-2"></i> Cetak Slip Gaji
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded border border-light h-100">
                                    <h6 class="fw-bold text-muted mb-3 text-uppercase" style="font-size: 11px; letter-spacing: 1px;"><i class="fas fa-wallet me-2"></i>Rincian Gaji & Tunjangan</h6>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-dark fw-bold">Gaji Pokok</span>
                                        <span class="text-dark">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-dark fw-bold">Tunjangan BPJS</span>
                                        <span class="text-success">+ Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-dark fw-bold">Fee Sales</span>
                                        <span class="text-primary">+ Rp {{ number_format($m->fee_marketing ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded border border-light h-100">
                                    <h6 class="fw-bold text-muted mb-3 text-uppercase" style="font-size: 11px; letter-spacing: 1px;"><i class="fas fa-chart-line me-2"></i>Perhitungan KPI</h6>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-dark fw-bold">Skor KPI Akhir</span>
                                        <span class="fw-bold {{ $total_kpi >= 70 ? 'text-success' : 'text-danger' }}">{{ number_format($total_kpi, 1) }}%</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-dark fw-bold">Nilai KPI (Rp)</span>
                                        <span class="text-dark">Rp {{ number_format($m->kpi_rp, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-dark fw-bold">Total Income</span>
                                        <span class="text-dark">Rp {{ number_format($m->income, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 p-3 bg-success-subtle border border-success border-opacity-25 rounded d-flex justify-content-between align-items-center">
                            <h5 class="fw-bolder text-success mb-0">TOTAL TAKE HOME PAY</h5>
                            <h3 class="fw-black text-success mb-0">Rp {{ number_format($m->total_gaji, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
                            <span class="fw-black text-success" style="font-size: 13px;">Rp {{ number_format($m->total_gaji, 0, ',', '.') }}</span>
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
                                <span class="text-muted fw-bold" style="font-size: 11px;">Nilai KPI (Rp)</span>
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
                        </div>
                        <a href="{{ route('penggajian.preview', $m->id) }}" target="_blank" class="btn btn-white btn-sm border text-primary rounded hover-lift shadow-sm w-100 mt-2" style="font-size: 10px; font-weight: 600;">
                            <i class="fas fa-print me-1"></i> Cetak Slip
                        </a>
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
{{-- ================= INFO & KETERANGAN (MODERN) ================= --}}
        <div class="row fade-in">
            <div class="col-md-12 mb-3">
                <div class="alert-modern-info h-100 d-flex align-items-start">
                    <div class="icon-sm bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-info-circle fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bolder text-dark mb-1">Komposisi Take Home Pay</h6>
                        <p class="small text-muted mb-2">Total gaji bersih merupakan akumulasi final dari komponen tetap dan variabel.</p>
                        <div class="bg-white px-3 py-2 rounded-3 border fw-bold small text-dark shadow-sm">
                            Gapok + Fee Marketing + Tunjangan BPJS.<br>
                            <span class="text-primary mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Perhitungan KPI: Skor KPI Akhir digunakan sebagai pengukur kinerja. Nilai KPI (Rp) dikalkulasikan berdasarkan capaian HPP, yang nantinya menjadi acuan performa/bonus bulanan.</span>
                        </div>
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
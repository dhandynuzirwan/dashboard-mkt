@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Revenue & Laporan Penjualan</h3>
                <h6 class="text-muted mb-2 fw-normal">Laporan Pencapaian & Detail Penjualan Marketing</h6>
                
                {{-- Jam Realtime --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border" style="background-color: #ffffff; color: #0891b2; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
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
                    <h6 class="fw-bold mb-0 text-dark">Filter Laporan Revenue</h6>
                </div>

                <form action="{{ route('revenue') }}" method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $start }}">
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $end }}">
                    </div>

                    @if(auth()->user()->role !== 'marketing')
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <label class="label-modern">Pilih Marketing</label>
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
                            <i class="fas fa-search me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('revenue') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark hover-lift w-100 text-center shadow-sm pt-2">
                            <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABEL REVENUE (CLEAN & MODERN) ================= --}}
        <div class="card card-modern border-0 shadow-sm fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Rincian Target & Pencapaian (Deal)</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4" width="280">Marketing & Pencapaian</th>
                                <th>Detail Rupiah Penawaran</th>
                                <th>Detail Rupiah Deal (Revenue)</th>
                                <th class="text-end pe-4" width="180">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($marketings as $m)
                                <tr>
                                    {{-- 1. Marketing & Progress Bar --}}
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 16px;">
                                                {{ substr($m->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="fw-bolder text-dark" style="font-size: 15px;">{{ $m->name }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-light p-3 rounded-4 border">
                                            <div class="d-flex justify-content-between mb-2" style="font-size: 11px;">
                                                <span class="text-muted fw-bold">TARGET:</span>
                                                <span class="fw-bolder text-dark">Rp {{ number_format($m->target, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2" style="font-size: 11px;">
                                                <span class="text-muted fw-bold">TERCAPAI:</span>
                                                <span class="fw-bolder text-success">Rp {{ number_format($m->achieve, 0, ',', '.') }}</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mt-2 pt-2 border-top">
                                                <div class="progress flex-grow-1 bg-white border" style="height: 6px; border-radius: 10px;">
                                                    <div class="progress-bar progress-bar-animate rounded-pill {{ $m->avg >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                                         style="width: {{ $m->avg > 100 ? 100 : $m->avg }}%;">
                                                    </div>
                                                </div>
                                                <span class="ms-2 fw-bolder {{ $m->avg >= 100 ? 'text-success' : 'text-primary' }}" style="font-size: 11px;">
                                                    {{ number_format($m->avg, 1) }}%
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 2. Rincian Penawaran (Stacked) --}}
                                    <td class="py-4">
                                        <div class="p-3 rounded-4 border border-light shadow-sm" style="background-color: #f8fafc;">
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Kemenaker</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_pen_kemenaker, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">BNSP</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_pen_bnsp, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Internal</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_pen_internal, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">PP SIO</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_pen_ppsio, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Riksa Uji Alat</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_pen_riksa, 0, ',', '.') }}</span>
                                            </div>
                                            <hr class="my-2 border-secondary opacity-10">
                                            <div class="d-flex justify-content-between text-primary mb-0">
                                                <span class="fw-bolder" style="font-size: 11px; letter-spacing: 0.5px;">TOTAL PENAWARAN</span>
                                                <span class="fw-bolder">Rp {{ number_format($m->total_rp_pen, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 3. Rincian Deal (Stacked) --}}
                                    <td class="py-4">
                                        <div class="p-3 rounded-4 border-success-subtle border shadow-sm" style="background-color: #f0fdf4;">
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Kemenaker</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_deal_kemenaker, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">BNSP</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_deal_bnsp, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Internal</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_deal_internal, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">PP SIO</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_deal_ppsio, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 small">
                                                <span class="text-muted fw-medium">Riksa Uji Alat</span>
                                                <span class="text-dark fw-bold">Rp {{ number_format($m->rp_deal_riksa, 0, ',', '.') }}</span>
                                            </div>
                                            <hr class="my-2 border-success opacity-25">
                                            <div class="d-flex justify-content-between text-success mb-0">
                                                <span class="fw-bolder" style="font-size: 11px; letter-spacing: 0.5px;">TOTAL DEAL</span>
                                                <span class="fw-bolder">Rp {{ number_format($m->total_rp_deal, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 4. Grand Total Revenue --}}
                                    <td class="py-4 text-end pe-4 align-middle">
                                        <div class="d-inline-block text-end">
                                            <p class="label-modern text-muted mb-1">TOTAL REVENUE</p>
                                            <h4 class="fw-bolder text-success mb-0 lh-1">
                                                Rp {{ number_format($m->total_rp_deal, 0, ',', '.') }}
                                            </h4>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fs-1 mb-3 text-light"></i><br>
                                        Belum ada data revenue pada rentang waktu filter ini.
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

{{-- ================= STYLES ================= --}}
<style>
    /* CSS MODERNISASI UI (Sama persis dengan halaman lain) */
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

    .icon-modern {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #e0eaff !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-warning-subtle { background-color: #fef08a !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }
    
    .border-success-subtle { border-color: #bbf7d0 !important; }

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
    
    @keyframes grow { from { width: 0; } }
    .progress-bar-animate { animation: grow 1s ease-out; }
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
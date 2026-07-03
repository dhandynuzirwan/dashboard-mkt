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

        {{-- ================= KARTU SIMULASI GAJI ================= --}}
        <div class="row fade-in">
            @foreach ($marketings as $m)
                @php
                    $total_kpi = $m->kpi_persen;
                    $badgeClass = $total_kpi >= 70 ? 'bg-success' : 'bg-danger';
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-modern shadow-sm h-100 border-0 hover-lift">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ substr($m->nama_lengkap ?? $m->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $m->nama_lengkap ?? $m->name }}</h5>
                                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 mt-1" style="font-size: 0.65rem;">{{ $m->name }}</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            
                            {{-- PENDAPATAN & KPI --}}
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Income (Prospek Deal)</span>
                                    <span class="fw-bold text-success" style="font-size: 0.8rem;">Rp {{ number_format($m->income, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Nilai KPI (Rp)</span>
                                    <span class="fw-bold text-info" style="font-size: 0.8rem;">Rp {{ number_format($m->kpi_rp, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Skor KPI Akhir</span>
                                    <span class="fw-bold {{ $total_kpi >= 70 ? 'text-success' : 'text-danger' }}" style="font-size: 0.8rem;">{{ number_format($total_kpi, 1) }}%</span>
                                </div>
                            </div>
                            
                            {{-- DETAIL PENCAPAIAN KPI --}}
                            <div class="mb-3 border-bottom pb-2">
                                <span class="text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Detail Pencapaian KPI</span>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Absensi (10%)</span>
                                    <span class="fw-bold text-dark">{{ number_format($m->ach_absensi, 1) }}% ({{ $m->absensi_hadir_real }}/{{ $hariEfektif }} Hari)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Progress (30%)</span>
                                    <span class="fw-bold text-dark">{{ number_format($m->ach_progress, 1) }}% ({{ $m->real_penawaran }}/{{ $m->target_penawaran }})</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Revenue (60%)</span>
                                    <span class="fw-bold text-dark">{{ number_format($m->ach_revenue, 1) }}%</span>
                                </div>
                            </div>

                            {{-- KOMPONEN GAJI --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-medium" style="font-size: 0.75rem;">Gaji Pokok</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.75rem;">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-medium" style="font-size: 0.75rem;">Tunjangan BPJS</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.75rem;">Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-medium" style="font-size: 0.75rem;">Fee Marketing</span>
                                    <span class="fw-bold text-success" style="font-size: 0.75rem;">Rp {{ number_format($m->fee_marketing, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-top p-3 text-center">
                            <span class="text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">TOTAL TAKE HOME PAY</span>
                            <h4 class="fw-black text-success mb-0" style="font-size: 1.5rem; letter-spacing: -1px;">
                                Rp {{ number_format($m->total_gaji, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(count($marketings) == 0)
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fs-1 text-muted mb-3 opacity-50"></i>
                    <h5 class="text-muted">Belum ada data gaji pada rentang waktu ini.</h5>
                </div>
            @endif
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
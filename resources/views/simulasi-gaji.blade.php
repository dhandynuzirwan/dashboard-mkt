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

        {{-- ================= TABEL SIMULASI GAJI (CLEAN & MODERN) ================= --}}
        <div class="card card-modern shadow-sm border-0 mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
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
                                <th>Komponen Tetap</th>
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
                                                {{ substr($m->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="fw-bolder text-dark" style="font-size: 14px;">{{ $m->name }}</span><br>
                                                <span class="badge bg-light text-muted border mt-1 fw-medium">
                                                    Target: Rp {{ number_format($m->income, 0, ',', '.') }}
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

                                    {{-- Kolom 4: Komponen Tetap --}}
                                    <td class="py-4">
                                        <div class="p-3 rounded-4 border border-light shadow-sm" style="background-color: #f8fafc; font-size: 11px;">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted fw-medium">Gaji Pokok:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted fw-medium">Tunjangan:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->tunj_kemahalan, 0, ',', '.') }}</span>
                                            </div>
                                            <hr class="my-2 border-secondary opacity-10">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted fw-medium">Tunj. BPJS:</span>
                                                <span class="fw-bold text-success">+ Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted fw-medium">Iuran BPJS:</span>
                                                <span class="fw-bold text-danger">- Rp {{ number_format($m->iuran_bpjs ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                            
                                            @if($m->potonganIzin > 0)
                                            <hr class="my-2 border-danger opacity-25">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-danger fw-bold">Pot. Izin:</span>
                                                <span class="fw-bold text-danger">- Rp {{ number_format($m->potonganIzin, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 5: Komponen Variabel --}}
                                    <td class="py-4">
                                        <div class="p-3 rounded-4 border-primary-subtle border shadow-sm" style="background-color: #f0f5ff; font-size: 11px;">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-muted fw-medium">Progress Value:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->progress_val, 0, ',', '.') }}</span>
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
                                                Rp {{ number_format($m->total_gaji, 0, ',', '.') }}
                                            </h4>
                                            
                                            <a href="{{ route('penggajian.preview', $m->id) }}" target="_blank" class="btn btn-white btn-sm border text-primary rounded-pill hover-lift shadow-sm px-3 mt-1" style="font-size: 11px; font-weight: 600;">
                                                <i class="fas fa-print me-1"></i> Cetak Slip
                                            </a>
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

        {{-- ================= INFO & KETERANGAN (MODERN) ================= --}}
        <div class="row fade-in">
            <div class="col-md-6 mb-3">
                <div class="alert-modern-info h-100 d-flex align-items-start">
                    <div class="icon-sm bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-info-circle fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bolder text-dark mb-1">Komposisi Take Home Pay</h6>
                        <p class="small text-muted mb-2">Total gaji bersih merupakan akumulasi final dari komponen tetap, variabel, dan asuransi kesehatan.</p>
                        <div class="bg-white px-3 py-2 rounded-3 border fw-bold small text-dark shadow-sm">
                            Gapok + Progress + Fee + Tunjangan <span class="text-success">+ Tunj. BPJS</span> <span class="text-danger">- Iuran BPJS</span> <span class="text-danger">- Pot. Izin</span>.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="alert-modern-warning h-100 d-flex align-items-start">
                    <div class="icon-sm bg-white text-warning-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-calculator fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bolder text-dark mb-1">Komponen Utama Gaji</h6>
                        <p class="small text-muted mb-2">Gaji kotor (Gross) sebelum asuransi dan potongan terbentuk dari 4 pilar utama ini:</p>
                        <div class="bg-white px-3 py-2 rounded-3 border fw-bold small text-dark shadow-sm">
                            <span class="text-primary">Gaji Pokok</span> + <span class="text-info">Nilai Progress</span> + <span class="text-success">Fee Sales</span> + <span class="text-secondary">Tunjangan</span>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= ACCORDION RUMUS GAJI (MODERN) ================= --}}
        <div class="accordion card-modern border-0 overflow-hidden mt-2 fade-in" id="accordionRumusGaji">
            <div class="accordion-item border-0 bg-transparent">
                <h2 class="accordion-header" id="headingRumus">
                    <button class="accordion-button collapsed fw-bolder text-dark shadow-none bg-white p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRumus" style="font-size: 15px;">
                        <i class="fas fa-book-open me-3 text-primary fs-5"></i> Panduan Lengkap Rumus Perhitungan Gaji & KPI
                    </button>
                </h2>
                <div id="collapseRumus" class="accordion-collapse collapse" data-bs-parent="#accordionRumusGaji">
                    <div class="accordion-body p-4 bg-light border-top">
                        
                        <div class="row g-4">
                            {{-- Kolom Kiri: Perhitungan KPI --}}
                            <div class="col-md-6">
                                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-light">
                                    <h6 class="fw-bolder text-primary mb-4 d-flex align-items-center">
                                        <div class="icon-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;"><i class="fas fa-chart-pie"></i></div>
                                        1. Rumus Skor KPI (Maks. 100%)
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">KPI Absensi (Bobot 10%)</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 border">((Hadir + Izin) / Hari Efektif) x 10%</code>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">KPI Progress (Bobot 30%)</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 border">(Total CTA / Target CTA Bulanan) x 30%</code>
                                    </div>
                                    <div class="mb-4">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">KPI Revenue (Bobot 60%)</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 border">(Total Rp Deal / Target Income) x 60%</code>
                                    </div>
                                    
                                    <div class="p-3 text-center fw-bolder rounded-3 bg-primary-subtle text-primary border border-primary border-opacity-25">
                                        Total Skor KPI = Absensi + Progress + Revenue
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Perhitungan Rupiah --}}
                            <div class="col-md-6">
                                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-light">
                                    <h6 class="fw-bolder text-success mb-4 d-flex align-items-center">
                                        <div class="icon-sm bg-success-subtle text-success rounded d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;"><i class="fas fa-money-bill-wave"></i></div>
                                        2. Pencairan Komponen (Rupiah)
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">Gaji Pokok & Tunjangan (Proporsional)</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 border">(Total Kehadiran / Hari Efektif) x Nilai Dasar</code>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">Pencairan Nilai Progress</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 border">Gapok Dasar x (Skor KPI Progress / 100)</code><br>
                                        <span class="text-muted" style="font-size: 11px;">*Maksimal cair senilai 30% dari Gapok.</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">Fee Marketing (Komisi Penjualan)</span><br>
                                        <code class="d-inline-block bg-light text-danger px-2 py-1 rounded mt-1 mb-2 border">(Total Rp Project Deal x 60%) x Persentase Fee</code>
                                        <div class="bg-light p-2 rounded border" style="font-size: 11px;">
                                            <div class="d-flex align-items-center mb-1"><i class="fas fa-check-circle text-success me-2"></i> KPI ≥ 70% = Fee <b>5%</b>.</div>
                                            <div class="d-flex align-items-center"><i class="fas fa-times-circle text-danger me-2"></i> KPI < 70% = Fee Turun Jadi <b>2.5%</b>.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
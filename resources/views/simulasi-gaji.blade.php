@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Take Home Pay</h3>
                <h6 class="op-7 mb-2">Monitoring Gaji Bersih Karyawan</h6>
                
                {{-- Pake warna manual yang soft pastel --}}
                <div class="d-inline-block rounded px-3 py-1 mt-1 fw-bold" style="background-color: #d8f5f9; color: #089eb7; font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
                
            </div>
        </div>

        {{-- ================= FILTER SECTION ================= --}}
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('simulasi-gaji') }}" method="GET" class="row g-2 align-items-center">
                    
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
                            <a href="{{ route('absensi') }}" class="btn btn-light border btn-sm btn-round">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABEL SIMULASI GAJI (CLEAN UI) ================= --}}
        <div class="card card-round shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <div class="card-title fw-bold">Rincian Perhitungan Take Home Pay</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4">MARKETING & TARGET</th>
                                <th>DETAIL PENCAPAIAN KPI</th>
                                <th class="text-center">SKOR KPI AKHIR</th>
                                <th>KOMPONEN TETAP</th>
                                <th>KOMPONEN VARIABEL (INSENTIF)</th>
                                <th class="text-end pe-4">TAKE HOME PAY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                                <tr class="border-bottom">
                                    
                                    {{-- Kolom 1: Marketing & Target Income --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ substr($m->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark" style="font-size: 14px;">{{ $m->name }}</span><br>
                                                <small class="text-muted" style="font-size: 11px;">Income: Rp {{ number_format($m->income, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Rincian Pencapaian KPI (Ditumpuk Rapi) --}}
                                    <td class="py-3">
                                        <div style="font-size: 11px; line-height: 1.6;">
                                            <div class="d-flex justify-content-between" style="max-width: 220px;">
                                                <span class="text-muted"><i class="fas fa-calendar-check text-info me-1"></i> Absensi (10%):</span>
                                                <span class="fw-bold text-dark">{{ number_format($m->ach_absensi, 1) }}% <span class="text-muted fw-normal">({{ $m->absensi_hadir_real }}/{{ $hariEfektif }})</span></span>
                                            </div>
                                            <div class="d-flex justify-content-between" style="max-width: 220px;">
                                                <span class="text-muted"><i class="fas fa-chart-line text-warning me-1"></i> Progress (30%):</span>
                                                <span class="fw-bold text-dark">{{ number_format($m->ach_progress, 1) }}% <span class="text-muted fw-normal">({{ $m->real_penawaran }}/{{ $m->target_penawaran }})</span></span>
                                            </div>
                                            <div class="d-flex justify-content-between" style="max-width: 220px;">
                                                <span class="text-muted"><i class="fas fa-money-bill-wave text-success me-1"></i> Revenue (60%):</span>
                                                <span class="fw-bold text-dark">{{ number_format($m->ach_revenue, 1) }}%</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Skor KPI Akhir (Badge Besar) --}}
                                    <td class="py-3 text-center">
                                        @if($m->kpi_persen >= 70)
                                            <div class="badge bg-success px-3 py-2 fs-6 shadow-sm rounded-pill">
                                                {{ number_format($m->kpi_persen, 1) }}%
                                            </div>
                                            <small class="d-block text-success fw-bold mt-1" style="font-size: 10px;">Sesuai KPI</small>
                                        @else
                                            <div class="badge bg-danger px-3 py-2 fs-6 shadow-sm rounded-pill">
                                                {{ number_format($m->kpi_persen, 1) }}%
                                            </div>
                                            <small class="d-block text-danger fw-bold mt-1" style="font-size: 10px;">Kebijakan KPI</small>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Komponen Tetap (Gapok + Tunjangan + BPJS + Potongan Izin) --}}
                                    <td class="py-3">
                                        <div style="font-size: 12px; line-height: 1.6;">
                                            <div class="d-flex justify-content-between" style="max-width: 190px;">
                                                <span class="text-muted">Gapok:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between" style="max-width: 190px;">
                                                <span class="text-muted">Tunjangan:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->tunj_kemahalan, 0, ',', '.') }}</span>
                                            </div>
                                            
                                            {{-- BPJS SECTION --}}
                                            <div class="d-flex justify-content-between mt-1" style="max-width: 190px;">
                                                <span class="text-muted">Tunj. BPJS:</span>
                                                <span class="fw-bold text-success">+ Rp {{ number_format($m->tunjangan_bpjs ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between" style="max-width: 190px;">
                                                <span class="text-muted">Pot. BPJS:</span>
                                                <span class="fw-bold text-danger">- Rp {{ number_format($m->iuran_bpjs ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                    
                                            {{-- 🔥 BARU: POTONGAN IZIN --}}
                                            @if($m->potonganIzin > 0)
                                            <div class="d-flex justify-content-between mt-1 border-top pt-1" style="max-width: 190px;">
                                                <span class="text-muted">Pot. Izin:</span>
                                                <span class="fw-bold text-danger">- Rp {{ number_format($m->potonganIzin, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 5: Komponen Variabel (Nilai Progress + Fee Marketing) --}}
                                    <td class="py-3">
                                        <div style="font-size: 12px; line-height: 1.6;">
                                            <div class="d-flex justify-content-between" style="max-width: 200px;">
                                                <span class="text-muted">Progress Val:</span>
                                                <span class="fw-bold text-dark">Rp {{ number_format($m->progress_val, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1 p-1 rounded" style="max-width: 200px; background-color: #e8f1ff;">
                                                <span class="text-primary fw-bold"><i class="fas fa-coins me-1"></i> Komisi/Fee:</span>
                                                <span class="fw-bolder text-primary">Rp {{ number_format($m->fee_marketing ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 6: TOTAL TAKE HOME PAY --}}
                                    <td class="py-3 text-end pe-4">
                                        <div class="fw-bolder text-success" style="font-size: 18px;">
                                            Rp {{ number_format($m->total_gaji, 0, ',', '.') }}
                                        </div>
                                        {{-- Optional Print Button (Muted/Light style) --}}
                                        {{-- UPDATE: Mengubah button menjadi link yang aktif --}}
                                        <a href="{{ route('penggajian.preview', $m->id) }}" target="_blank" class="btn btn-white btn-sm border text-primary mt-1 shadow-sm" style="font-size: 10px; padding: 2px 8px;">
                                            <i class="fas fa-print me-1"></i> Slip Gaji
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                        
                </div>
            </div>
        </div>

        {{-- ================= INFO & KETERANGAN (Dipercantik) ================= --}}
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-start p-3">
                    <i class="fas fa-info-circle fs-3 text-info me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold text-warning mb-1">Total Take Home Pay (Gaji Bersih)</h6>
                        <p class="small text-dark mb-0">Total gaji merupakan akumulasi dari komponen tetap, variabel, dan BPJS:</p>
                        <p class="fw-bold small text-dark mb-0 bg-white bg-opacity-50 mt-1 p-1 rounded">
                            Gapok + Nilai Progress + Fee Marketing + Tunjangan <span class="text-success">+ Tunj. BPJS</span> <span class="text-danger">- Iuran BPJS</span>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-start p-3">
                    <i class="fas fa-calculator fs-3 text-warning me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold text-warning mb-1">Total Take Home Pay (Gaji Bersih)</h6>
                        <p class="small text-dark mb-0">Total gaji merupakan akumulasi dari 4 komponen utama:</p>
                        <p class="fw-bold small text-dark mb-0 bg-white bg-opacity-50 mt-1 p-1 rounded">Gaji Pokok + Nilai Progress + Fee Marketing + Tunjangan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= ACCORDION RUMUS GAJI ================= --}}
        <div class="accordion mt-3 shadow-sm rounded-4 overflow-hidden" id="accordionRumusGaji">
            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingRumus">
                    <button class="accordion-button collapsed fw-bold bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRumus" aria-expanded="false" aria-controls="collapseRumus">
                        <i class="fas fa-book-open me-2 text-primary"></i> Panduan Lengkap Rumus Perhitungan Gaji & KPI
                    </button>
                </h2>
                <div id="collapseRumus" class="accordion-collapse collapse bg-light" aria-labelledby="headingRumus" data-bs-parent="#accordionRumusGaji">
                    <div class="accordion-body p-4 text-muted small" style="line-height: 1.8;">
                        
                        <div class="row">
                            {{-- Kolom Kiri: Perhitungan KPI --}}
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-gray-100">
                                    <h6 class="fw-bolder text-primary border-bottom pb-2 mb-3"><i class="fas fa-chart-pie me-2"></i> 1. Rumus Skor KPI (Maks. 100%)</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">KPI Absensi (Bobot 10%)</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">(Total Kehadiran & Izin / Hari Efektif) x 10%</code>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">KPI Progress (Bobot 30%)</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">(Total Pembuatan CTA / Target CTA Sebulan) x 30%</code>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">KPI Revenue (Bobot 60%)</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">(Total Rupiah Deal / Target Revenue Sebulan) x 60%</code>
                                        </li>
                                    </ul>
                                    <div class="p-2 mt-3 text-center fw-bold rounded shadow-sm" style="background-color: #e8f1ff; color: #0d6efd; border: 1px dashed #0d6efd;">
                                        Total KPI = Skor Absensi + Skor Progress + Skor Revenue
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Perhitungan Rupiah --}}
                            <div class="col-md-6">
                                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-gray-100">
                                    <h6 class="fw-bolder text-success border-bottom pb-2 mb-3"><i class="fas fa-money-bill-wave me-2"></i> 2. Rumus Komponen Gaji (Rupiah)</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">Gaji Pokok & Tunjangan (Proporsional)</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">(Kehadiran / Hari Efektif) x Nilai Dasar</code>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">Nilai Progress</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">Gapok Dasar x (Skor KPI Progress / 100)</code><br>
                                            <i class="text-muted" style="font-size: 10px;">*Maksimal cair senilai 30% dari Gapok jika mencapai target.</i>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">Fee Marketing (Komisi)</span><br>
                                            <code class="bg-light text-danger px-2 py-1 rounded">(Total Rp Project Deal x 60%) x Persentase Fee</code><br>
                                            <div class="mt-1" style="font-size: 10.5px;">
                                                <i class="fas fa-check text-success"></i> KPI ≥ 70% : Persentase Fee = <b>5%</b>.<br>
                                                <i class="fas fa-times text-danger"></i> KPI < 70% : Persentase Fee turun jadi <b>2.5%</b>.
                                            </div>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold text-dark">Potongan & Tunjangan BPJS + Izin</span><br>
                                            <code class="bg-light text-dark px-2 py-1 rounded border">
                                                Total Gaji = (Komponen Tetap + Variabel + Tunj. BPJS) - (Iuran BPJS + Potongan Izin)
                                            </code>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- END ACCORDION --}}
            
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
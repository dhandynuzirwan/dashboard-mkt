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

        {{-- ================= TABEL DATA KPI (CLEAN UI) ================= --}}
        <div class="card card-round shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <div class="card-title fw-bold">Detail Pencapaian Kinerja</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4">NAMA MARKETING</th>
                                <th width="200">ABSENSI (Bobot 10%)</th>
                                <th width="220">PROGRESS CTA (Bobot 30%)</th>
                                <th width="250">REVENUE (Bobot 60%)</th>
                                <th class="text-center pe-4" width="160">TOTAL KPI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                                <tr class="border-bottom">
                                    
                                    {{-- Kolom 1: Nama Marketing --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ substr($m->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark" style="font-size: 15px;">{{ $m->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Absensi --}}
                                    <td class="py-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Target (Hadir):</span>
                                            <span class="fw-bold text-dark">{{ $m->absensi_hadir }} / {{ $m->absensi_jadwal }} Hari</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Pencapaian:</span>
                                            <span class="fw-bold text-info">{{ number_format($m->absensi_ach, 1) }}%</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px; background-color: #f1f1f1;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $m->absensi_ach > 100 ? 100 : $m->absensi_ach }}%;"></div>
                                        </div>
                                        <div class="mt-1" style="font-size: 11px;">
                                            <span class="text-muted">Skor Final:</span> <span class="fw-bold text-dark">{{ number_format($m->absensi_kpi, 1) }}%</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Progress CTA --}}
                                    <td class="py-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Target (Real):</span>
                                            <span class="fw-bold text-dark">{{ $m->progress_real }} / {{ $m->progress_target }} CTA</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Pencapaian:</span>
                                            <span class="fw-bold text-warning">{{ number_format($m->progress_ach, 1) }}%</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px; background-color: #f1f1f1;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $m->progress_ach > 100 ? 100 : $m->progress_ach }}%;"></div>
                                        </div>
                                        <div class="mt-1" style="font-size: 11px;">
                                            <span class="text-muted">Skor Final:</span> <span class="fw-bold text-dark">{{ number_format($m->progress_kpi, 1) }}%</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 4: Revenue --}}
                                    <td class="py-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Target:</span>
                                            <span class="fw-medium text-dark">Rp {{ number_format($m->revenue_target, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Aktual:</span>
                                            <span class="fw-bold text-success">Rp {{ number_format($m->revenue_actual, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                            <span class="text-muted">Pencapaian:</span>
                                            <span class="fw-bold text-success">{{ number_format($m->revenue_ach, 1) }}%</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px; background-color: #f1f1f1;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $m->revenue_ach > 100 ? 100 : $m->revenue_ach }}%;"></div>
                                        </div>
                                        <div class="mt-1" style="font-size: 11px;">
                                            <span class="text-muted">Skor Final:</span> <span class="fw-bold text-dark">{{ number_format($m->revenue_kpi, 1) }}%</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 5: Total KPI Akhir --}}
                                    <td class="py-3 text-center pe-4">
                                        @php
                                            $total_kpi = $m->total_kpi;
                                            $badgeClass = $total_kpi >= 70 ? 'bg-success' : 'bg-danger';
                                        @endphp
                                        
                                        <h4 class="fw-bolder mb-1 {{ $total_kpi >= 70 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($total_kpi, 1) }}%
                                        </h4>
                                        <span class="badge {{ $badgeClass }} px-2 py-1 shadow-sm" style="font-size: 10px;">
                                            {{ $total_kpi >= 70 ? 'Sesuai KPI' : 'Kebijakan KPI' }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach

                            {{-- Jika Data Kosong --}}
                            @if(count($marketings) == 0)
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fs-3 mb-2 opacity-50"></i><br>
                                        Belum ada data KPI pada rentang waktu ini.
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
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

        {{-- ================= CARD DATA KPI (CLEAN UI) ================= --}}
        <div class="row">
            @foreach ($marketings as $m)
                @php
                    $total_kpi = $m->total_kpi;
                    $badgeClass = $total_kpi >= 70 ? 'bg-success' : 'bg-danger';
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-round shadow-sm h-100 border-0 hover-lift">
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
                            {{-- ABSENSI --}}
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Absensi (Bobot 10%)</span>
                                    <span class="fw-bold text-info" style="font-size: 0.8rem;">{{ number_format($m->absensi_kpi, 1) }}%</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted">Target (Hadir):</span>
                                    <span class="fw-bold text-dark">{{ $m->absensi_hadir }} / {{ $m->absensi_jadwal }} Hari</span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $m->absensi_ach > 100 ? 100 : $m->absensi_ach }}%;"></div>
                                </div>
                            </div>
                            
                            {{-- PROGRESS (3 KOMPONEN) --}}
                            <div class="mb-3 border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Progress (Bobot 30%)</span>
                                    <span class="fw-bold text-warning" style="font-size: 0.8rem;">{{ number_format($m->progress_kpi, 1) }}%</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Update Data:</span>
                                    <span class="fw-bold text-dark">{{ $m->detail_update_data }} data ({{ number_format($m->skor_update, 1) }}%)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Akhir Data:</span>
                                    <span class="fw-bold text-dark">{{ $m->detail_akhir_data }} data ({{ number_format($m->skor_akhir, 1) }}%)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                    <span class="text-muted">- Penawaran:</span>
                                    <span class="fw-bold text-dark">{{ $m->detail_penawaran }} data ({{ number_format($m->skor_penawaran, 1) }}%)</span>
                                </div>
                                
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $m->progress_ach > 100 ? 100 : $m->progress_ach }}%;"></div>
                                </div>
                            </div>

                            {{-- REVENUE --}}
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted fw-bold" style="font-size: 0.75rem;">Revenue (Bobot 60%)</span>
                                    <span class="fw-bold text-success" style="font-size: 0.8rem;">{{ number_format($m->revenue_kpi, 1) }}%</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted">Target:</span>
                                    <span class="fw-medium text-dark">Rp {{ number_format($m->revenue_target, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem;">
                                    <span class="text-muted">Aktual:</span>
                                    <span class="fw-bold text-success">Rp {{ number_format($m->revenue_actual, 0, ',', '.') }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $m->revenue_ach > 100 ? 100 : $m->revenue_ach }}%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-top d-flex justify-content-between align-items-center p-3">
                            <span class="fw-bolder text-dark" style="font-size: 0.85rem;">TOTAL KPI</span>
                            <div class="text-end">
                                <h4 class="fw-black mb-0 {{ $total_kpi >= 70 ? 'text-success' : 'text-danger' }}" style="font-size: 1.5rem; letter-spacing: -1px;">
                                    {{ number_format($total_kpi, 1) }}%
                                </h4>
                                <span class="badge {{ $badgeClass }} px-2 py-1 shadow-sm mt-1" style="font-size: 0.65rem;">
                                    {{ $total_kpi >= 70 ? 'Sesuai KPI' : 'Kebijakan KPI' }}
                                </span>
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
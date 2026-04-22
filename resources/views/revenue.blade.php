@extends('layouts.app') 

@section('content')
    <div class="container">
        <div class="page-inner">
            
            {{-- ================= HEADER SECTION ================= --}}
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
                <div>
                    <h3 class="fw-bold mb-1">REVENUE</h3>
                    <h6 class="op-7 mb-2">Laporan Pencapaian & Detail Penjualan Marketing</h6>
                    <div class="d-inline-block rounded px-3 py-1 mt-1 fw-bold" style="background-color: #d1f3f8; color: #089eb7; font-size: 12px;">
                        <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                    </div>
                </div>
            </div>

            {{-- ================= FILTER SECTION (CLEAN UI) ================= --}}
            <div class="card card-round mb-4 border-0 shadow-sm">
                <div class="card-body p-3">
                    <form action="{{ route('revenue') }}" method="GET" class="row g-2 align-items-center">
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
                                <a href="{{ route('revenue') }}" class="btn btn-light border btn-sm btn-round">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ================= TABEL REVENUE (CLEAN UI) ================= --}}
            <div class="card card-round shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <div class="card-title fw-bold">Rincian Target & Pencapaian (Deal)</div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr>
                                    <th class="ps-4" width="250">MARKETING & PENCAPAIAN</th>
                                    <th>DETAIL RUPIAH PENAWARAN</th>
                                    <th>DETAIL RUPIAH DEAL (REVENUE)</th>
                                    <th class="text-end pe-4" width="180">TOTAL REVENUE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $m)
                                    <tr class="border-bottom">
                                        
                                        {{-- Kolom 1: Marketing, Target & Progress Bar --}}
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                    <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ substr($m->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark" style="font-size: 15px;">{{ $m->name }}</span>
                                                </div>
                                            </div>
                                            
                                            <div style="font-size: 11px;">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Target:</span>
                                                    <span class="fw-bold">Rp {{ number_format($m->target, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Tercapai:</span>
                                                    <span class="fw-bold text-success">Rp {{ number_format($m->achieve, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            
                                            {{-- Progress Bar Pencapaian --}}
                                            <div class="progress mt-2" style="height: 6px; background-color: #f1f1f1;">
                                                <div class="progress-bar {{ $m->avg >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $m->avg > 100 ? 100 : $m->avg }}%;" 
                                                     title="{{ number_format($m->avg, 1) }}%">
                                                </div>
                                            </div>
                                            <small class="fw-bold {{ $m->avg >= 100 ? 'text-success' : 'text-primary' }}" style="font-size: 10px;">
                                                {{ number_format($m->avg, 1) }}% dari Target
                                            </small>
                                        </td>

                                        {{-- Kolom 2: Rincian Penawaran (Stacked) --}}
                                        <td class="py-3">
                                            <div class="p-2 rounded" style="font-size: 11px; background-color: #f8f9fa;">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Kemenaker</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_pen_kemenaker, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">BNSP</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_pen_bnsp, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Internal</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_pen_internal, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">PP SIO</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_pen_ppsio, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Riksa Uji Alat</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_pen_riksa, 0, ',', '.') }}</span>
                                                </div>
                                                <hr class="my-1 border-secondary opacity-25">
                                                <div class="d-flex justify-content-between fw-bold text-primary">
                                                    <span>TOTAL PENAWARAN</span>
                                                    <span>Rp {{ number_format($m->total_rp_pen, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom 3: Rincian Deal (Stacked) --}}
                                        <td class="py-3">
                                            <div class="p-2 rounded border border-success border-opacity-25" style="font-size: 11px; background-color: #f1fcf5;">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Kemenaker</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_deal_kemenaker, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">BNSP</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_deal_bnsp, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">Internal</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_deal_internal, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted">PP SIO</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_deal_ppsio, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Riksa Uji Alat</span>
                                                    <span class="fw-medium text-dark">Rp {{ number_format($m->rp_deal_riksa, 0, ',', '.') }}</span>
                                                </div>
                                                <hr class="my-1 border-success opacity-25">
                                                <div class="d-flex justify-content-between fw-bold text-success">
                                                    <span>TOTAL DEAL</span>
                                                    <span>Rp {{ number_format($m->total_rp_deal, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom 4: Grand Total Revenue --}}
                                        <td class="py-3 text-end pe-4 align-middle">
                                            <p class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">TOTAL REVENUE</p>
                                            <h5 class="fw-bolder text-success mb-0">
                                                Rp {{ number_format($m->total_rp_deal, 0, ',', '.') }}
                                            </h5>
                                        </td>

                                    </tr>
                                @endforeach

                                {{-- Jika Data Kosong --}}
                                @if(count($marketings) == 0)
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-folder-open fs-3 mb-2 opacity-50"></i><br>
                                            Belum ada data revenue pada rentang waktu ini.
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
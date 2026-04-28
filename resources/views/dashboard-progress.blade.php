@extends('layouts.app')

@section('content')

@php
    // Helper Global untuk membuat angka menjadi link Pop Up (Style Modern)
    $renderLink = function($count, $marketingId, $status) use ($start, $end) {
        if ($count > 0) {
            return '<a href="javascript:void(0)" class="fw-bold text-primary text-decoration-none btn-detail-status d-inline-block px-2 py-1 bg-primary-subtle rounded hover-lift" 
                       data-marketing="'.$marketingId.'" 
                       data-status="'.$status.'" 
                       data-start="'.$start.'" 
                       data-end="'.$end.'" 
                       title="Klik untuk lihat detail">'.$count.'</a>';
        }
        return '<span class="text-muted opacity-50 fw-light">0</span>';
    };
@endphp

<div class="container">
    <div class="page-inner">
        
        {{-- ================= ALERT REMINDER (MODERN) ================= --}}
        @if (auth()->user()->role === 'admin')
            @if ($showReminder)
                <div class="alert alert-modern-warning mb-4 fade-in">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-white text-warning-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 36px; height: 36px;">
                            <i class="fas fa-exclamation-triangle animate-pulse"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Reminder Admin!</h6>
                            <p class="mb-0 text-dark small opacity-75">Data masuk hari ini baru <b class="text-danger">{{ $dataMasukToday }}</b> dari target <b>{{ $targetDataMasuk }}</b>. Silakan upload data sebelum jam 16:00.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($showSuccessReminder)
                <div class="alert alert-modern-success mb-4 fade-in">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 36px; height: 36px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Target Tercapai!</h6>
                            <p class="mb-0 text-dark small opacity-75">Hari ini sudah ada <b class="text-success">{{ $dataMasukToday }}</b> data masuk dari target <b>{{ $targetDataMasuk }}</b>.</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- ================= HEADER & CLOCK ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Dashboard Marketing</h3>
                <h6 class="text-muted mb-2 fw-normal">Laporan Terintegrasi & Progress Marketing</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 fw-bold border" style="background-color: #ffffff; color: #6366f1; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= STATISTIC CARDS (MODERN UI) ================= --}}
        <div class="row mb-3 fade-in">
            {{-- Total Penawaran --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Penawaran</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stat_total_qty) }}</h3>
                                <span class="badge badge-soft-primary" style="font-size: 10px;">
                                    <i class="fas fa-sync-alt fa-spin me-1"></i> {{ $marketings->sum('review') }} Review
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Deal --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Deal</p>
                            <div class="d-flex align-items-end justify-content-between">
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stat_deal_qty) }}</h3>
                                <span class="badge badge-soft-success" style="font-size: 10px;">
                                    @php $rate = $stat_total_qty > 0 ? ($stat_deal_qty / $stat_total_qty) * 100 : 0; @endphp
                                    <i class="fas fa-chart-line me-1"></i> {{ number_format($rate, 1) }}% Rate
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nilai Penawaran --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Nilai Penawaran</p>
                            <h4 class="fw-bolder text-dark mb-1 lh-1">Rp {{ number_format($stat_total_nilai, 0, ',', '.') }}</h4>
                            <p class="text-muted small mb-0" style="font-size: 10px;">
                                @php $avg = $stat_total_qty > 0 ? $stat_total_nilai / $stat_total_qty : 0; @endphp
                                Avg: Rp {{ number_format($avg / 1000000, 1) }} Jt/Prospek
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nilai Deal --}}
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success text-white shadow-sm me-3">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Nilai Deal</p>
                            <h4 class="fw-bolder text-dark mb-1 lh-1">Rp {{ number_format($stat_deal_nilai, 0, ',', '.') }}</h4>
                            <p class="text-success fw-bold small mb-0" style="font-size: 10px;">
                                @php $realization = $stat_total_nilai > 0 ? ($stat_deal_nilai / $stat_total_nilai) * 100 : 0; @endphp
                                <i class="fas fa-check-double me-1"></i> {{ number_format($realization, 1) }}% Terwujud
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER SECTION (MODERN STYLE) ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('dashboard.progress') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $start }}">
                    </div>
                    <div class="col-md-3">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ $end }}">
                    </div>
                    <div class="col-md-3">
                        <label class="label-modern">Marketing</label>
                        <select name="marketing_id" class="form-select form-select-sm input-modern shadow-none">
                            <option value="">Semua Marketing</option>
                            @foreach ($all_marketing as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift px-3">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('dashboard.progress') }}" class="btn btn-white border btn-sm flex-grow-1 btn-round fw-bold shadow-sm hover-lift text-dark px-3">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= CHARTS ================= --}}
        <div class="row mb-4 fade-in">
            {{-- Pie Chart --}}
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0 d-flex justify-content-between align-items-center pt-4 px-4">
                        <div>
                            <h6 class="card-title fw-bolder mb-0 text-dark">Grafik Ach Target</h6>
                            <small class="text-muted opacity-75" style="font-size: 11px;">Pencapaian nominal deal tim.</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-white border btn-round hover-lift text-muted" onclick="downloadChart('achTargetChart', 'Grafik_Ach_Target')" title="Unduh Gambar">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                    <div class="card-body pb-3">
                        <div style="position: relative; height: 260px; width: 100%;">
                            <canvas id="achTargetChart"></canvas>
                        </div>
                        <div id="customPieLegend" class="d-flex flex-wrap justify-content-center gap-2 mt-3 mb-1"></div>
                    </div>
                </div>
            </div>

            {{-- Line Chart --}}
            <div class="col-md-8">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0 d-flex justify-content-between align-items-center flex-wrap pt-4 px-4">
                        <div class="mb-2 mb-md-0">
                            <h6 class="card-title fw-bolder mb-0 text-dark">Tren Produktivitas</h6>
                            <small class="text-muted opacity-75" style="font-size: 11px;">Pergerakan nominal penawaran.</small>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" role="group">
                                <button type="button" class="nav-link active py-1 px-3" style="font-size: 11px;" id="btn-6bulan" onclick="ubahChart('6bulan')">6 Bln</button>
                                <button type="button" class="nav-link py-1 px-3" style="font-size: 11px;" id="btn-1bulan" onclick="ubahChart('1bulan')">1 Bln</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-white border btn-round hover-lift text-muted" onclick="downloadChart('multipleLineChart', 'Tren_Produktivitas')" title="Unduh Gambar">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div class="chart-container" style="position: relative; height: 280px; width: 100%;">
                            <canvas id="multipleLineChart"></canvas>
                        </div>
                        <div id="customLegend" class="d-flex flex-wrap justify-content-center gap-2 mt-4 mb-1"></div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ================= 🔥 PETA HIGHCHARTS 🔥 ================= --}}
        <div class="row mb-4 fade-in">
            <div class="col-md-12">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom-0 pb-0 d-flex justify-content-between align-items-center flex-wrap pt-4 px-4">
                        <div class="mb-2 mb-md-0">
                            <h6 class="card-title fw-bolder mb-0 text-dark">Peta Persebaran Geografis</h6>
                            <small class="text-muted opacity-75" style="font-size: 11px;">Intensitas prospek di berbagai provinsi Indonesia.</small>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex">
                                <button type="button" class="nav-link active py-1 px-3" style="font-size: 11px;" id="btn-map-dasar" onclick="ubahWarnaPeta('dasar')">Intensitas (Biru)</button>
                                <button type="button" class="nav-link py-1 px-3" style="font-size: 11px;" id="btn-map-marketing" onclick="ubahWarnaPeta('marketing')">Dominasi Marketing</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-white border btn-round hover-lift text-muted" onclick="unduhPeta()" title="Unduh Gambar">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-4">
                        <div id="indonesia-map" style="width: 100%; height: 450px;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABEL ANALISIS FUNNEL KONVERSI ================= --}}
        <div class="row mb-4 fade-in">
            <div class="col-md-12">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center pt-4 px-4 pb-3">
                        <div>
                            <h6 class="card-title fw-bolder mb-0 text-dark">Analisis Funnel Konversi Marketing</h6>
                            <small class="text-muted opacity-75" style="font-size: 11px;">Melacak efektivitas dari Lead masuk hingga menjadi Deal (Closing).</small>
                        </div>
                        <span class="badge badge-soft-info border"><i class="fas fa-info-circle me-1"></i> Angka biru bisa diklik</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="ps-4">Nama Marketing</th>
                                        <th width="15%" class="text-center" title="Total Database yang diterima">Leads Masuk</th>
                                        <th width="15%" class="text-center" title="Leads dikurangi Invalid, Tidak Respon, dan Kosong">Leads Valid</th>
                                        <th width="15%" class="text-center" title="Jumlah Form Penawaran Dibuat">Penawaran</th>
                                        <th width="15%" class="text-center" title="Penawaran yang berhasil Deal">Project Deal</th>
                                        <th width="15%" class="text-center">Win Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($marketings as $m)
                                        @php
                                            $total_leads = ($m->count_belum_ada_kebutuhan ?? 0) + ($m->count_email ?? 0) + ($m->count_dapat_telp ?? 0) + 
                                                           ($m->count_wa ?? 0) + ($m->count_hold ?? 0) + ($m->count_invalid ?? 0) + 
                                                           ($m->count_compro ?? 0) + ($m->count_manja ?? 0) + ($m->count_manja_ulang ?? 0) + 
                                                           ($m->count_penawaran ?? 0) + ($m->count_penawaran_hardfile ?? 0) + ($m->count_perpanjangan ?? 0) + 
                                                           ($m->count_pelatihan ?? 0) + ($m->count_tidak_menerima_penawaran ?? 0) + ($m->count_tidak_respon ?? 0) + 
                                                           ($m->count_sudah_ada_vendor_kerjasama ?? 0) + ($m->count_tanpa_status ?? 0);

                                            $leads_mati = ($m->count_invalid ?? 0) + ($m->count_tidak_respon ?? 0) + ($m->count_tanpa_status ?? 0);
                                            $leads_valid = $total_leads - $leads_mati;
                                            $persen_valid = $total_leads > 0 ? ($leads_valid / $total_leads) * 100 : 0;

                                            $total_penawaran = $m->total_penawaran ?? 0;
                                            $persen_penawaran = $leads_valid > 0 ? ($total_penawaran / $leads_valid) * 100 : 0;

                                            $total_deal = $m->deal ?? 0;
                                            $persen_deal = $total_penawaran > 0 ? ($total_deal / $total_penawaran) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td class="fw-bold ps-4 text-dark">{{ $m->name }}</td>
                                            
                                            <td class="text-center align-middle">
                                                <div class="fw-bolder fs-6 mb-1">{!! $renderLink($total_leads, $m->id, 'semua') !!}</div>
                                                <span class="badge badge-soft-secondary" style="font-size: 9px;">100% Base</span>
                                            </td>

                                            <td class="align-middle px-3">
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <span class="fw-bold text-dark">{{ $leads_valid }}</span>
                                                    <span class="small text-muted" style="font-size: 10px;">{{ number_format($persen_valid, 0) }}%</span>
                                                </div>
                                                <div class="progress bg-light" style="height: 6px; border-radius: 10px;">
                                                    <div class="progress-bar progress-bar-animate bg-info rounded-pill" style="width: {{ $persen_valid }}%"></div>
                                                </div>
                                            </td>

                                            <td class="align-middle px-3">
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <a href="javascript:void(0)" class="fw-bold text-primary text-decoration-none btn-detail bg-primary-subtle px-2 rounded hover-lift" data-id="{{ $m->id }}">
                                                        {{ $total_penawaran }}
                                                    </a>
                                                    <span class="small text-muted" style="font-size: 10px;">{{ number_format($persen_penawaran, 0) }}%</span>
                                                </div>
                                                <div class="progress bg-light" style="height: 6px; border-radius: 10px;">
                                                    <div class="progress-bar progress-bar-animate bg-warning rounded-pill" style="width: {{ $persen_penawaran }}%"></div>
                                                </div>
                                            </td>

                                            <td class="align-middle px-3">
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <span class="fw-bold text-success">{{ $total_deal }}</span>
                                                    <span class="small text-muted" style="font-size: 10px;">{{ number_format($persen_deal, 0) }}%</span>
                                                </div>
                                                <div class="progress bg-light" style="height: 6px; border-radius: 10px;">
                                                    <div class="progress-bar progress-bar-animate bg-success rounded-pill" style="width: {{ $persen_deal }}%"></div>
                                                </div>
                                            </td>

                                            <td class="text-center align-middle pe-4">
                                                @if($persen_deal >= 50)
                                                    <span class="badge bg-success shadow-sm rounded-pill px-3 py-2"><i class="fas fa-trophy me-1 text-warning"></i> {{ number_format($persen_deal, 1) }}%</span>
                                                @elseif($persen_deal >= 20)
                                                    <span class="badge bg-primary shadow-sm rounded-pill px-3 py-2">{{ number_format($persen_deal, 1) }}%</span>
                                                @else
                                                    <span class="badge bg-danger shadow-sm rounded-pill px-3 py-2"><i class="fas fa-arrow-down me-1"></i> {{ number_format($persen_deal, 1) }}%</span>
                                                @endif
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

        {{-- ================= TABEL PROGRESS MARKETING ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Progress Pencapaian Target</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="text-start ps-4">Marketing</th>
                                <th class="text-center">Target (Form)</th>
                                <th class="text-center">Pencapaian</th>
                                <th class="text-center pe-4">Ach Target (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                                <tr>
                                    <td class="text-start fw-bold text-dark ps-4">{{ $m->name }}</td>
                                    <td class="text-center text-muted fw-medium">{{ $m->target_total }}</td>
                                    <td class="text-center fw-bolder text-primary fs-6">{{ $m->pencapaian }}</td>
                                    <td class="pe-4" style="width: 40%;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="progress flex-grow-1 bg-light" style="height: 8px; border-radius: 10px;">
                                                <div class="progress-bar progress-bar-animate rounded-pill {{ $m->ach_persen < 50 ? 'bg-danger' : ($m->ach_persen < 80 ? 'bg-warning' : 'bg-success') }}"
                                                     role="progressbar" 
                                                     style="width: {{ $m->ach_persen }}%" 
                                                     aria-valuenow="{{ $m->ach_persen }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="ms-3 fw-bolder text-dark small" style="min-width: 45px;">
                                                {{ number_format($m->ach_persen, 1) }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= TABEL UPDATE PENAWARAN ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Update Penawaran & Follow Up</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover text-center align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="text-start ps-4">Marketing</th>
                                <th>Under Review</th>
                                <th>Deal</th>
                                <th>Hold</th>
                                <th>Kalah Harga</th>
                                <th class="pe-4">Total Follow Up</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                                <tr>
                                    <td class="text-start fw-bold text-dark ps-4">{{ $m->name }}</td>
                                    <td><span class="badge badge-soft-info px-3 py-2 rounded-pill fw-bold">{{ $m->review }}</span></td>
                                    <td><span class="badge badge-soft-success px-3 py-2 rounded-pill fw-bold">{{ $m->deal }}</span></td>
                                    <td><span class="badge badge-soft-warning text-dark px-3 py-2 rounded-pill fw-bold">{{ $m->hold }}</span></td>
                                    <td><span class="badge badge-soft-danger px-3 py-2 rounded-pill fw-bold">{{ $m->kalah }}</span></td>
                                    <td class="pe-4">
                                        <button class="btn btn-sm btn-primary btn-round btn-detail fw-bold px-3 shadow-sm hover-lift" data-id="{{ $m->id }}">
                                            {{ $m->total_penawaran }} Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= TABEL STATUS AKHIR DATA ================= --}}
        <div class="card card-modern border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Status Akhir Catatan Data (Prospek)</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-modern table-hover align-middle text-center mb-0" style="white-space: nowrap;">
                        <thead class="bg-light text-secondary" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th class="text-start ps-4 bg-light text-dark shadow-sm" style="position: sticky; left: 0; z-index: 11; border-right: 1px solid #eef2f7;">Marketing</th>
                                
                                <th>Belum Ada<br>Kebutuhan</th>
                                <th>Dapat<br>Email</th>
                                <th>Dapat<br>No Telp</th>
                                <th>Dapat<br>WA HRD</th>
                                <th>Hold</th>
                                <th>Invalid /<br>No Connect</th>
                                <th>Kirim<br>Compro</th>
                                <th>Manja</th>
                                <th>Manja<br>Ulang</th>
                                <th>Masuk<br>Penawaran</th>
                                <th>Penawaran<br>Hardfile</th>
                                <th>Perpanjang<br>Sertifikat</th>
                                <th>Req.<br>Pelatihan</th>
                                <th>Tidak Menerima<br>Penawaran</th>
                                <th>Tidak<br>Respon</th>
                                <th>Vendor<br>Kerjasama</th>
        
                                <th class="text-danger fw-bolder bg-danger-subtle">Belum Ada<br>Status</th>
                                <th class="pe-4 text-success fw-bolder bg-success-subtle">Total<br>Semua</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t_belum_kebutuhan = $t_email = $t_dapat_telp = $t_wa = $t_hold = $t_invalid = 0;
                                $t_compro = $t_manja = $t_manja_ulang = $t_penawaran = $t_hardfile = $t_perpanjangan = 0;
                                $t_pelatihan = $t_tidak_menerima = $t_tidak_respon = $t_vendor_kerjasama = 0;
                                $t_tanpa_status = $t_semua = 0;
                            @endphp
        
                            @foreach ($marketings as $m)
                                @php
                                    $total_per_marketing = 
                                        ($m->count_belum_ada_kebutuhan ?? 0) + ($m->count_email ?? 0) + ($m->count_dapat_telp ?? 0) + 
                                        ($m->count_wa ?? 0) + ($m->count_hold ?? 0) + ($m->count_invalid ?? 0) + 
                                        ($m->count_compro ?? 0) + ($m->count_manja ?? 0) + ($m->count_manja_ulang ?? 0) + 
                                        ($m->count_penawaran ?? 0) + ($m->count_penawaran_hardfile ?? 0) + ($m->count_perpanjangan ?? 0) + 
                                        ($m->count_pelatihan ?? 0) + ($m->count_tidak_menerima_penawaran ?? 0) + ($m->count_tidak_respon ?? 0) + 
                                        ($m->count_sudah_ada_vendor_kerjasama ?? 0) + ($m->count_tanpa_status ?? 0);
                                @endphp
                                <tr>
                                    <td class="text-start fw-bold text-dark ps-4 bg-white shadow-sm" style="position: sticky; left: 0; z-index: 5; border-right: 1px solid #eef2f7;">
                                        {{ $m->name }}
                                    </td>
                                    
                                    <td>{!! $renderLink($m->count_belum_ada_kebutuhan ?? 0, $m->id, 'BELUM ADA KEBUTUHAN') !!}</td>
                                    <td>{!! $renderLink($m->count_email ?? 0, $m->id, 'DAPAT EMAIL') !!}</td>
                                    <td>{!! $renderLink($m->count_dapat_telp ?? 0, $m->id, 'DAPAT NO TELP') !!}</td>
                                    <td>{!! $renderLink($m->count_wa ?? 0, $m->id, 'DAPAT NO WA HRD') !!}</td>
                                    <td>{!! $renderLink($m->count_hold ?? 0, $m->id, 'HOLD') !!}</td>
                                    <td>{!! $renderLink($m->count_invalid ?? 0, $m->id, 'DATA TIDAK VALID & TIDAK TERHUBUNG') !!}</td>
                                    <td>{!! $renderLink($m->count_compro ?? 0, $m->id, 'KIRIM COMPRO') !!}</td>
                                    <td>{!! $renderLink($m->count_manja ?? 0, $m->id, 'MANJA') !!}</td>
                                    <td>{!! $renderLink($m->count_manja_ulang ?? 0, $m->id, 'MANJA ULANG') !!}</td>
                                    <td class="bg-primary-subtle">{!! $renderLink($m->count_penawaran ?? 0, $m->id, 'MASUK PENAWARAN') !!}</td>
                                    <td>{!! $renderLink($m->count_penawaran_hardfile ?? 0, $m->id, 'PENAWARAN HARDFILE') !!}</td>
                                    <td>{!! $renderLink($m->count_perpanjangan ?? 0, $m->id, 'REQUES PERPANJANGAN SERTIFIKAT') !!}</td>
                                    <td>{!! $renderLink($m->count_pelatihan ?? 0, $m->id, 'REQUEST PERMINTAAN PELATIHAN') !!}</td>
                                    <td>{!! $renderLink($m->count_tidak_menerima_penawaran ?? 0, $m->id, 'TIDAK MENERIMA PENAWARAN') !!}</td>
                                    <td>{!! $renderLink($m->count_tidak_respon ?? 0, $m->id, 'TIDAK RESPON') !!}</td>
                                    <td>{!! $renderLink($m->count_sudah_ada_vendor_kerjasama ?? 0, $m->id, 'SUDAH ADA VENDOR KERJASAMA') !!}</td>
                                    
                                    <td class="bg-danger-subtle">{!! $renderLink($m->count_tanpa_status ?? 0, $m->id, 'tanpa_status') !!}</td>
                                    <td class="pe-4 bg-success-subtle">{!! $renderLink($total_per_marketing, $m->id, 'semua') !!}</td>
                                </tr>
                                @php
                                    $t_belum_kebutuhan += ($m->count_belum_ada_kebutuhan ?? 0);
                                    $t_email += ($m->count_email ?? 0);
                                    $t_dapat_telp += ($m->count_dapat_telp ?? 0);
                                    $t_wa += ($m->count_wa ?? 0);
                                    $t_hold += ($m->count_hold ?? 0);
                                    $t_invalid += ($m->count_invalid ?? 0);
                                    $t_compro += ($m->count_compro ?? 0);
                                    $t_manja += ($m->count_manja ?? 0);
                                    $t_manja_ulang += ($m->count_manja_ulang ?? 0);
                                    $t_penawaran += ($m->count_penawaran ?? 0);
                                    $t_hardfile += ($m->count_penawaran_hardfile ?? 0);
                                    $t_perpanjangan += ($m->count_perpanjangan ?? 0);
                                    $t_pelatihan += ($m->count_pelatihan ?? 0);
                                    $t_tidak_menerima += ($m->count_tidak_menerima_penawaran ?? 0);
                                    $t_tidak_respon += ($m->count_tidak_respon ?? 0);
                                    $t_vendor_kerjasama += ($m->count_sudah_ada_vendor_kerjasama ?? 0);
                                    $t_tanpa_status += ($m->count_tanpa_status ?? 0);
                                    $t_semua += $total_per_marketing;
                                @endphp
                            @endforeach
        
                            <tr class="table-primary fw-bolder text-dark border-top border-2 border-primary">
                                <td class="text-start ps-4 bg-primary text-white shadow-sm" style="position: sticky; left: 0; z-index: 5;">TOTAL KESELURUHAN</td>
                                <td>{{ $t_belum_kebutuhan }}</td>
                                <td>{{ $t_email }}</td>
                                <td>{{ $t_dapat_telp }}</td>
                                <td>{{ $t_wa }}</td>
                                <td>{{ $t_hold }}</td>
                                <td>{{ $t_invalid }}</td>
                                <td>{{ $t_compro }}</td>
                                <td>{{ $t_manja }}</td>
                                <td>{{ $t_manja_ulang }}</td>
                                <td class="text-primary bg-white">{{ $t_penawaran }}</td>
                                <td>{{ $t_hardfile }}</td>
                                <td>{{ $t_perpanjangan }}</td>
                                <td>{{ $t_pelatihan }}</td>
                                <td>{{ $t_tidak_menerima }}</td>
                                <td>{{ $t_tidak_respon }}</td>
                                <td>{{ $t_vendor_kerjasama }}</td>
                                <td class="text-danger bg-white">{{ $t_tanpa_status }}</td>
                                <td class="pe-4 text-success bg-white">{{ $t_semua }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= MODALS ================= --}}
<div class="modal fade" id="modalDetailStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0">
                <h5 class="modal-title fw-bolder" id="modalDetailTitle"><i class="fas fa-list me-2"></i> Detail Prospek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover mb-0 align-middle">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center" width="100">Tanggal</th>
                                <th>Perusahaan</th>
                                <th>PIC & Jabatan</th>
                                <th class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody id="modalDetailBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 pt-2 pb-2">
                <button type="button" class="btn btn-white border fw-bold btn-round btn-sm text-dark" data-bs-dismiss="modal">Tutup Layar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-modern shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-info-circle text-info me-2"></i>Detail Penawaran & Follow Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3" id="detailBody"></div>
        </div>
    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    /* CSS MODERNISASI UI (Sama persis dengan halaman pipeline) */
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
    .text-warning-dark { color: #b45309 !important; }

    .badge-soft-primary { background-color: #e0eaff; color: #3b82f6; }
    .badge-soft-success { background-color: #dcfce7; color: #16a34a; }
    .badge-soft-danger { background-color: #fee2e2; color: #dc2626; }
    .badge-soft-warning { background-color: #fef08a; color: #b45309; }
    .badge-soft-info { background-color: #cff4fc; color: #0891b2; }
    .badge-soft-secondary { background-color: #f3f4f6; color: #4b5563; }

    /* Alert Modern */
    .alert-modern-success {
        background-color: #f0fdf4;
        border-left: 4px solid #22c55e;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .alert-modern-warning {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 16px;
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
        padding: 16px;
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

    /* Segmented Tabs (Modern Toggle) */
    .nav-modern {
        background-color: #f1f5f9;
        padding: 4px;
        border-radius: 50px;
    }
    .nav-modern .nav-link {
        border-radius: 50px;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 24px;
        border: none;
        transition: all 0.3s ease;
        background: transparent;
    }
    .nav-modern .nav-link:hover {
        color: #0f172a;
    }
    .nav-modern .nav-link.active {
        background-color: #ffffff;
        color: #3b82f6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
    @keyframes grow { from { width: 0; } }
    .progress-bar-animate { animation: grow 1s ease-out; }
    
    /* Perbaikan Highcharts */
    .highcharts-credits { display: none !important; }
</style>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>

<script>
    // --- 1. Fungsi Download Chart.js ---
    Chart.register({
        id: 'customCanvasBackgroundColor',
        beforeDraw: (chart, args, options) => {
            const {ctx} = chart;
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = options.color || '#ffffff';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
        }
    });

    function downloadChart(canvasId, fileName) {
        const canvas = document.getElementById(canvasId);
        if (canvas) {
            const imageUrl = canvas.toDataURL("image/png", 1.0);
            const downloadLink = document.createElement('a');
            downloadLink.href = imageUrl;
            downloadLink.download = fileName + '.png';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        } else {
            alert('Grafik belum selesai dimuat!');
        }
    }
    
    // --- 2. Main DOM Ready ---
    document.addEventListener("DOMContentLoaded", function() {

        // Jam Realtime
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // AJAX Modal Detail Follow Up Penawaran
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const mId = this.getAttribute('data-id');
                const modalBody = document.getElementById('detailBody');
                
                $('#modalDetail').modal('show');
                modalBody.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted small">Memuat data detail...</p></div>`;

                fetch(`/marketing-detail/${mId}?start={{ $start }}&end={{ $end }}`)
                    .then(response => response.text())
                    .then(html => { modalBody.innerHTML = html; })
                    .catch(error => { modalBody.innerHTML = '<p class="text-center text-danger py-4">Gagal memuat data.</p>'; });
            });
        });

        // AJAX Modal Detail Status Prospek
        const modalDetailStatus = new bootstrap.Modal(document.getElementById('modalDetailStatus'));
        const modalTitleStatus = document.getElementById('modalDetailTitle');
        const modalBodyStatus = document.getElementById('modalDetailBody');

        document.querySelectorAll('.btn-detail-status').forEach(button => {
            button.addEventListener('click', function () {
                const marketingId = this.getAttribute('data-marketing');
                const status = this.getAttribute('data-status');
                const startDate = this.getAttribute('data-start');
                const endDate = this.getAttribute('data-end');

                modalTitleStatus.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengambil Data...';
                modalBodyStatus.innerHTML = '<tr><td colspan="5" class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Sedang memuat data prospek...</p></td></tr>';
                
                modalDetailStatus.show();

                fetch(`{{ route('prospek.detailAjax') }}?marketing_id=${marketingId}&status=${status}&start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        modalTitleStatus.innerHTML = `<i class="fas fa-list me-2"></i> ${data.title}`;
                        modalBodyStatus.innerHTML = data.html;
                    })
                    .catch(error => {
                        modalTitleStatus.innerHTML = '<i class="fas fa-exclamation-triangle text-warning me-2"></i> Terjadi Kesalahan';
                        modalBodyStatus.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data. Silakan coba lagi.</td></tr>';
                    });
            });
        });

        // Pie Chart
        const ctxPie = document.getElementById('achTargetChart');
        let pieChartInstance = null;

        if (ctxPie) {
            pieChartInstance = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        data: @json($pieData),
                        // Warna dikembalikan ke versi lama yang lebih pop-out
                        backgroundColor: ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2', '#fd7e14', '#20c997'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                plugins: [ChartDataLabels], 
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 1500, easing: 'easeOutQuart' },
                    plugins: {
                        legend: { display: false }, 
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = Number(context.raw) || 0; 
                                    return ' ' + label + ': Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        datalabels: {
                            color: '#ffffff',
                            font: { weight: 'bold', size: 12 },
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataset = ctx.chart.data.datasets[0];
                                dataset.data.forEach((data, index) => {
                                    if (ctx.chart.getDataVisibility(index)) {
                                        sum += Number(data) || 0;
                                    }
                                });
                                
                                if (value === 0 || sum === 0) return '';
                                return (value * 100 / sum).toFixed(1) + "%";
                            }
                        }
                    }
                }
            });

            function buildCustomPieLegend(chart) {
                const legendContainer = document.getElementById('customPieLegend');
                legendContainer.innerHTML = ''; 

                const bgColors = chart.data.datasets[0].backgroundColor;

                chart.data.labels.forEach((label, index) => {
                    const isVisible = chart.getDataVisibility(index);
                    const color = bgColors[index];

                    const btn = document.createElement('button');
                    btn.className = 'btn fw-bold rounded-pill border shadow-sm transition-all m-1 d-inline-flex align-items-center hover-lift';
                    btn.style.padding = '2px 10px';  
                    btn.style.fontSize = '10px';     
                    
                    if (isVisible) {
                        btn.style.backgroundColor = color;
                        btn.style.color = '#fff';
                        btn.style.borderColor = color;
                    } else {
                        btn.style.backgroundColor = '#f8f9fa'; 
                        btn.style.color = '#adb5bd'; 
                        btn.style.borderColor = '#dee2e6';
                        btn.style.opacity = '0.6'; 
                    }

                    btn.innerHTML = `<span style="display:inline-block; width:8px; height:8px; border-radius:50%; background-color:${isVisible ? '#fff' : color}; margin-right:4px; box-shadow: 0 1px 2px rgba(0,0,0,0.2);"></span>${label}`;

                    btn.onclick = () => {
                        chart.toggleDataVisibility(index);
                        chart.update(); 
                        buildCustomPieLegend(chart); 
                    };

                    legendContainer.appendChild(btn);
                });
            }

            buildCustomPieLegend(pieChartInstance);
        }

        // Line Chart
        const ctxLine = document.getElementById("multipleLineChart");
        let lineChartInstance = null;

        if (ctxLine) {
            const data6Bulan = {
                labels: @json($lineLabels6Months),
                datasets: @json($lineDatasets6Months)
            };

            const data1Bulan = {
                labels: @json($lineLabelsThisMonth),
                datasets: @json($lineDatasetsThisMonth)
            };

            lineChartInstance = new Chart(ctxLine.getContext("2d"), {
                type: "line",
                data: data6Bulan,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 1500, easing: 'easeInOutBack' },
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    let num = Number(value); 
                                    if(num >= 1000000000) return 'Rp ' + (num / 1000000000).toLocaleString('id-ID') + ' M';
                                    else if(num >= 1000000) return 'Rp ' + (num / 1000000).toLocaleString('id-ID') + ' Jt';
                                    else return 'Rp ' + num.toLocaleString('id-ID');
                                },
                                font: { size: 10 }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }, 
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = Number(context.raw) || 0; 
                                    return ' ' + context.dataset.label + ': Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            function buildCustomLegend(chart) {
                const legendContainer = document.getElementById('customLegend');
                legendContainer.innerHTML = ''; 

                chart.data.datasets.forEach((dataset, index) => {
                    const isVisible = chart.isDatasetVisible(index);
                    const color = dataset.borderColor || '#3b82f6';

                    const btn = document.createElement('button');
                    btn.className = 'btn btn-sm fw-bold rounded-pill border shadow-sm transition-all m-1 hover-lift';
                    
                    if (isVisible) {
                        btn.style.backgroundColor = color;
                        btn.style.color = '#fff';
                        btn.style.borderColor = color;
                    } else {
                        btn.style.backgroundColor = '#f8f9fa'; 
                        btn.style.color = '#adb5bd'; 
                        btn.style.borderColor = '#dee2e6';
                        btn.style.opacity = '0.6'; 
                    }

                    btn.innerHTML = `<span style="display:inline-block; width:10px; height:10px; border-radius:50%; background-color:${isVisible ? '#fff' : color}; margin-right:6px; box-shadow: 0 1px 2px rgba(0,0,0,0.2);"></span>${dataset.label}`;

                    btn.onclick = () => {
                        const currentlyVisible = chart.isDatasetVisible(index);
                        chart.setDatasetVisibility(index, !currentlyVisible); 
                        chart.update(); 
                        buildCustomLegend(chart); 
                    };

                    legendContainer.appendChild(btn);
                });
            }

            buildCustomLegend(lineChartInstance);

            window.ubahChart = function(tipe) {
                const visibilityState = lineChartInstance.data.datasets.map((ds, i) => lineChartInstance.isDatasetVisible(i));

                if (tipe === '6bulan') {
                    lineChartInstance.data = data6Bulan; 
                    document.getElementById('btn-6bulan').classList.add('active'); 
                    document.getElementById('btn-1bulan').classList.remove('active'); 
                } else {
                    lineChartInstance.data = data1Bulan; 
                    document.getElementById('btn-1bulan').classList.add('active');
                    document.getElementById('btn-6bulan').classList.remove('active');
                }

                lineChartInstance.data.datasets.forEach((ds, i) => {
                    ds.hidden = !visibilityState[i];
                });

                lineChartInstance.update(); 
                buildCustomLegend(lineChartInstance);
            };
        }

        // ================= 🔥 MAP HIGHCHARTS 🔥 =================
        if (document.getElementById('indonesia-map')) {
            const rawMapData = @json($mapData ?? []);
            
            const dataDasar = Object.keys(rawMapData).map(key => {
                let provinceData = rawMapData[key];
                let totalValue = provinceData.total !== undefined ? provinceData.total : provinceData;
                let hoverColor = provinceData.warna ? provinceData.warna : '#f59e0b'; 
        
                return {
                    'hc-key': key.toLowerCase(),
                    value: totalValue,
                    states: { hover: { color: hoverColor } }
                };
            });

            const dataMarketing = Object.keys(rawMapData).map(key => {
                let provinceData = rawMapData[key];
                let totalValue = provinceData.total !== undefined ? provinceData.total : provinceData;
                let markerColor = provinceData.warna ? provinceData.warna : '#f59e0b'; 
        
                return {
                    'hc-key': key.toLowerCase(),
                    value: totalValue,
                    color: markerColor, 
                    states: { hover: { brightness: -0.1 } }
                };
            });

            window.mapChartInstance = Highcharts.mapChart('indonesia-map', {
                chart: { map: 'countries/id/id-all', backgroundColor: 'transparent', style: { fontFamily: 'inherit' } },
                title: { text: null },
                credits: { enabled: false },
                exporting: { enabled: true, buttons: { contextButton: { enabled: false } } }, 

                mapNavigation: {
                    enabled: true,
                    buttonOptions: { 
                        verticalAlign: 'bottom',
                        theme: {
                            fill: '#ffffff', 'stroke-width': 1, stroke: '#e2e8f0', r: 8,
                            states: { hover: { fill: '#f1f5f9' }, select: { stroke: '#3b82f6', fill: '#f1f5f9' } }
                        }
                    }
                },

                colorAxis: {
                    min: 1, minColor: '#bae6fd', maxColor: '#0ea5e9', 
                    labels: { style: { color: '#64748b', fontWeight: 'bold' } }
                },

                tooltip: {
                    useHTML: true, backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    borderWidth: 0, borderRadius: 12, padding: 16,
                    shadow: { color: 'rgba(0, 0, 0, 0.05)', width: 15, offsetX: 0, offsetY: 4 },
                    formatter: function() {
                        let val = this.point.value || 0;
                        let textColor = this.point.color || '#0ea5e9'; 
                        return `
                            <div style="text-align: center; min-width: 120px;">
                                <div style="font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; font-weight: 700;">${this.point.name}</div>
                                <div style="font-size: 24px; font-weight: 800; color: ${textColor}; line-height: 1;">${val}</div>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Total Penawaran</div>
                            </div>
                        `;
                    }
                },

                series: [{
                    data: dataDasar, name: 'Total Penawaran',
                    nullColor: '#f1f5f9', borderColor: '#ffffff', borderWidth: 1.5,
                    dataLabels: {
                        enabled: true, format: '{point.name}',
                        style: { fontSize: '9px', fontWeight: '600', color: '#475569', textOutline: '2px contrast' }
                    }
                }]
            });

            window.ubahWarnaPeta = function(mode) {
                if (mode === 'dasar') {
                    document.getElementById('btn-map-dasar').classList.add('active');
                    document.getElementById('btn-map-marketing').classList.remove('active');
                    mapChartInstance.series[0].setData(dataDasar);
                    mapChartInstance.update({ colorAxis: { showInLegend: true } });
                } else {
                    document.getElementById('btn-map-marketing').classList.add('active');
                    document.getElementById('btn-map-dasar').classList.remove('active');
                    mapChartInstance.series[0].setData(dataMarketing);
                    mapChartInstance.update({ colorAxis: { showInLegend: false } });
                }
            };

            window.unduhPeta = function() {
                mapChartInstance.exportChartLocal({ type: 'image/png', filename: 'Peta_Persebaran_Prospek' });
            };
        }
    });
</script>
@endsection
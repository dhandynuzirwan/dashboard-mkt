@extends('layouts.app')

@section('content')

@php
    // Helper Global untuk membuat angka menjadi link Pop Up
    $renderLink = function($count, $marketingId, $status) use ($start, $end) {
        if ($count > 0) {
            return '<a href="javascript:void(0)" class="fw-bold text-primary text-decoration-underline btn-detail-status" 
                       data-marketing="'.$marketingId.'" 
                       data-status="'.$status.'" 
                       data-start="'.$start.'" 
                       data-end="'.$end.'" 
                       title="Klik untuk lihat detail">'.$count.'</a>';
        }
        return '<span class="text-muted">0</span>';
    };
@endphp
<div class="container">
    <div class="page-inner">
        
        {{-- ================= ALERT REMINDER ================= --}}
        @if (auth()->user()->role === 'admin')
            @if ($showReminder)
                <div class="alert alert-warning mb-4 shadow-sm rounded-3 border-start border-4 border-warning">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fs-3 text-warning me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Reminder Admin!</h6>
                            <p class="mb-0 text-dark small">Data masuk hari ini baru <b>{{ $dataMasukToday }}</b> dari target <b>{{ $targetDataMasuk }}</b>. Silakan upload data sebelum jam 16:00.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($showSuccessReminder)
                <div class="alert alert-success mb-4 shadow-sm rounded-3 border-start border-4 border-success">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fs-3 text-success me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Target Tercapai!</h6>
                            <p class="mb-0 text-dark small">Hari ini sudah ada <b>{{ $dataMasukToday }}</b> data masuk dari target <b>{{ $targetDataMasuk }}</b>.</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- ================= HEADER & CLOCK ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-1">Dashboard Marketing</h3>
                <h6 class="op-7 mb-0">Laporan Terintegrasi & Progress Marketing</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <span class="badge badge-info py-2 px-3 shadow-sm" style="font-size: 0.85rem;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </span>
            </div>
        </div>

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Penawaran</p>
                                    <h4 class="card-title">{{ number_format($stat_total_qty) }}</h4>
                                    <p class="text-muted small mb-0 mt-1">
                                        <i class="fas fa-sync-alt fa-spin text-primary me-1"></i>
                                        {{ $marketings->sum('under_review') }} Review
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-handshake"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Deal</p>
                                    <h4 class="card-title">{{ number_format($stat_deal_qty) }}</h4>
                                    <p class="text-success small mb-0 mt-1 fw-bold">
                                        <i class="fas fa-chart-line me-1"></i>
                                        @php $rate = $stat_total_qty > 0 ? ($stat_deal_qty / $stat_total_qty) * 100 : 0; @endphp
                                        {{ number_format($rate, 1) }}% Rate
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Nilai Penawaran</p>
                                    <h4 class="card-title fs-5">Rp {{ number_format($stat_total_nilai, 0, ',', '.') }}</h4>
                                    <p class="text-muted small mb-0 mt-1">
                                        @php $avg = $stat_total_qty > 0 ? $stat_total_nilai / $stat_total_qty : 0; @endphp
                                        Avg: Rp {{ number_format($avg / 1000000, 1) }} Jt/Prospek
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4" style="border-bottom: 3px solid #31ce36 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small bg-success-gradient text-white">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Nilai Deal</p>
                                    <h4 class="card-title text-success fs-5">Rp {{ number_format($stat_deal_nilai, 0, ',', '.') }}</h4>
                                    <p class="text-success small mb-0 mt-1 fw-bold">
                                        <i class="fas fa-check-double me-1"></i>
                                        @php $realization = $stat_total_nilai > 0 ? ($stat_deal_nilai / $stat_total_nilai) * 100 : 0; @endphp
                                        {{ number_format($realization, 1) }}% Terwujud
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER SECTION ================= --}}
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('dashboard.progress') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block mb-1">Dari Tanggal</small>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $start }}">
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block mb-1">Sampai Tanggal</small>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $end }}">
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block mb-1">Pilih Marketing</small>
                        <select name="marketing_id" class="form-select form-select-sm">
                            <option value="">Semua Marketing</option>
                            @foreach ($all_marketing as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('dashboard.progress') }}" class="btn btn-light border btn-sm flex-grow-1 btn-round fw-bold">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= CHARTS ================= --}}
        <div class="row mb-4">
            {{-- Pie Chart --}}
            <div class="col-md-4">
                <div class="card card-round border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold mb-0">Grafik Ach Target</h5>
                            <small class="text-muted">Persentase pencapaian target deal masing-masing tim marketing.</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-round" onclick="downloadChart('achTargetChart', 'Grafik_Ach_Target')" title="Unduh Gambar">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                    <div class="card-body pb-0">
                        <div style="position: relative; height: 280px; width: 100%;">
                            <canvas id="achTargetChart"></canvas>
                        </div>
                        {{-- 🔥 Tempat untuk tombol warna filter Pie Chart 🔥 --}}
                        <div id="customPieLegend" class="d-flex flex-wrap justify-content-center gap-2 mt-3 mb-2"></div>
                    </div>
                </div>
            </div>

            {{-- Line Chart --}}
            <div class="col-md-8">
                <div class="card card-round border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <h5 class="card-title fw-bold mb-0">Tren Produktivitas Nilai Penawaran</h5>
                            <small class="text-muted">Pergerakan total nominal penawaran yang dibuat dari waktu ke waktu.</small>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary active" id="btn-6bulan" onclick="ubahChart('6bulan')">6 Bulan</button>
                                <button type="button" class="btn btn-outline-primary" id="btn-1bulan" onclick="ubahChart('1bulan')">Bulan Ini</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" onclick="downloadChart('multipleLineChart', 'Tren_Produktivitas')" title="Unduh Gambar">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                            <canvas id="multipleLineChart"></canvas>
                        </div>
                        <div id="customLegend" class="d-flex flex-wrap justify-content-center gap-2 mt-4 mb-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ================= 🔥 PETA HIGHCHARTS (ANTI ERROR) 🔥 ================= --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-round border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold mb-0">Peta Persebaran Penawaran (Geografis)</h5>
                            <small class="text-muted">Menampilkan intensitas prospek dan penawaran di berbagai provinsi Indonesia.</small>
                        </div>
                        <span class="badge bg-primary text-white shadow-sm d-none d-md-inline-block">Berdasarkan Provinsi</span>
                    </div>
                    <div class="card-body">
                        <div id="indonesia-map" style="width: 100%; height: 450px;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABEL ANALISIS FUNNEL KONVERSI ================= --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-round border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold mb-0">Analisis Funnel Konversi Marketing</h5>
                            <small class="text-muted">Melacak efektivitas dari Lead masuk hingga menjadi Deal (Closing).</small>
                        </div>
                        <span class="badge bg-light text-dark border"><i class="fas fa-info-circle text-info me-1"></i> Angka biru bisa diklik</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center mb-0">
                                <thead class="table-light text-secondary" style="font-size: 13px;">
                                    <tr>
                                        <th class="text-start ps-4">Nama Marketing</th>
                                        <th width="15%" title="Total Database yang diterima">Total Leads Masuk</th>
                                        <th width="15%" title="Leads dikurangi Invalid, Tidak Respon, dan Kosong">Leads Valid (Terhubung)</th>
                                        <th width="15%" title="Jumlah Form Penawaran Dibuat">Terkirim Penawaran</th>
                                        <th width="15%" title="Penawaran yang berhasil Deal">Project Deal</th>
                                        <th width="15%">Win Rate (Rasio Closing)</th>
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
                                            <td class="text-start fw-bold ps-4 text-dark">{{ $m->name }}</td>
                                            
                                            <td>
                                                <div class="fw-bold fs-6">{!! $renderLink($total_leads, $m->id, 'semua') !!}</div>
                                                <small class="text-muted" style="font-size: 11px;">100% Database</small>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <span class="fw-bold text-dark">{{ $leads_valid }}</span>
                                                    <span class="small text-muted">{{ number_format($persen_valid, 0) }}%</span>
                                                </div>
                                                <div class="progress shadow-sm" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-animate bg-info" style="width: {{ $persen_valid }}%"></div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <a href="javascript:void(0)" class="fw-bold text-primary text-decoration-underline btn-detail" data-id="{{ $m->id }}">
                                                        {{ $total_penawaran }}
                                                    </a>
                                                    <span class="small text-muted">{{ number_format($persen_penawaran, 0) }}%</span>
                                                </div>
                                                <div class="progress shadow-sm" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-animate bg-warning" style="width: {{ $persen_penawaran }}%"></div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-between align-items-end mb-1">
                                                    <span class="fw-bold text-success">{{ $total_deal }}</span>
                                                    <span class="small text-muted">{{ number_format($persen_deal, 0) }}%</span>
                                                </div>
                                                <div class="progress shadow-sm" style="height: 6px;">
                                                    <div class="progress-bar progress-bar-animate bg-success" style="width: {{ $persen_deal }}%"></div>
                                                </div>
                                            </td>

                                            <td class="pe-4">
                                                @if($persen_deal >= 50)
                                                    <span class="badge bg-success-gradient px-3 py-2 shadow-sm"><i class="fas fa-trophy me-1"></i> {{ number_format($persen_deal, 1) }}%</span>
                                                @elseif($persen_deal >= 20)
                                                    <span class="badge bg-primary px-3 py-2 shadow-sm">{{ number_format($persen_deal, 1) }}%</span>
                                                @else
                                                    <span class="badge bg-danger px-3 py-2 shadow-sm"><i class="fas fa-arrow-down me-1"></i> {{ number_format($persen_deal, 1) }}%</span>
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
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <div class="card-title fw-bold">Progress Marketing</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="text-start ps-4">Marketing</th>
                                <th>Target</th>
                                <th>Pencapaian</th>
                                <th class="pe-4">Ach Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketings as $m)
                                <tr>
                                    <td class="text-start fw-bold ps-4">{{ $m->name }}</td>
                                    <td>{{ $m->target_total }}</td>
                                    <td class="fw-bold text-primary">{{ $m->pencapaian }}</td>
                                    <td class="pe-4" style="width: 35%;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="progress flex-grow-1 shadow-sm" style="height: 8px;">
                                                <div class="progress-bar progress-bar-animate {{ $m->ach_persen < 50 ? 'bg-danger' : ($m->ach_persen < 80 ? 'bg-warning' : 'bg-success') }}"
                                                     role="progressbar" 
                                                     style="width: {{ $m->ach_persen }}%" 
                                                     aria-valuenow="{{ $m->ach_persen }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="ms-3 fw-bold text-muted small" style="min-width: 45px;">
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
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <div class="card-title fw-bold">Update Penawaran</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="table-light text-secondary">
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
                                    <td class="text-start fw-bold ps-4">{{ $m->name }}</td>
                                    <td><span class="badge badge-info px-3 py-2">{{ $m->review }}</span></td>
                                    <td><span class="badge badge-success px-3 py-2">{{ $m->deal }}</span></td>
                                    <td><span class="badge badge-warning px-3 py-2">{{ $m->hold }}</span></td>
                                    <td><span class="badge badge-danger px-3 py-2">{{ $m->kalah }}</span></td>
                                    <td class="pe-4">
                                        <button class="btn btn-sm btn-primary btn-round btn-detail fw-bold px-3 shadow-sm" data-id="{{ $m->id }}">
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
        <div class="card card-round border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <div class="card-title fw-bold">Status Akhir Data</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped align-middle text-center mb-0" style="white-space: nowrap;">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="text-start ps-4 min-w-150 sticky-left bg-light">Marketing</th>
                                
                                {{-- Urutan Abjad (A-Z) --}}
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
        
                                {{-- Kolom Penutup --}}
                                <th class="text-danger fw-bold">Belum Ada<br>Status</th>
                                <th class="pe-4 text-success fw-bold">Total<br>Semua</th>
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
                                    <td class="text-start fw-bold ps-4">{{ $m->name }}</td>
                                    
                                    <td>{!! $renderLink($m->count_belum_ada_kebutuhan ?? 0, $m->id, 'BELUM ADA KEBUTUHAN') !!}</td>
                                    <td>{!! $renderLink($m->count_email ?? 0, $m->id, 'DAPAT EMAIL') !!}</td>
                                    <td>{!! $renderLink($m->count_dapat_telp ?? 0, $m->id, 'DAPAT NO TELP') !!}</td>
                                    <td>{!! $renderLink($m->count_wa ?? 0, $m->id, 'DAPAT NO WA HRD') !!}</td>
                                    <td>{!! $renderLink($m->count_hold ?? 0, $m->id, 'HOLD') !!}</td>
                                    <td>{!! $renderLink($m->count_invalid ?? 0, $m->id, 'DATA TIDAK VALID & TIDAK TERHUBUNG') !!}</td>
                                    <td>{!! $renderLink($m->count_compro ?? 0, $m->id, 'KIRIM COMPRO') !!}</td>
                                    <td>{!! $renderLink($m->count_manja ?? 0, $m->id, 'MANJA') !!}</td>
                                    <td>{!! $renderLink($m->count_manja_ulang ?? 0, $m->id, 'MANJA ULANG') !!}</td>
                                    <td class="bg-light">{!! $renderLink($m->count_penawaran ?? 0, $m->id, 'MASUK PENAWARAN') !!}</td>
                                    <td>{!! $renderLink($m->count_penawaran_hardfile ?? 0, $m->id, 'PENAWARAN HARDFILE') !!}</td>
                                    <td>{!! $renderLink($m->count_perpanjangan ?? 0, $m->id, 'REQUES PERPANJANGAN SERTIFIKAT') !!}</td>
                                    <td>{!! $renderLink($m->count_pelatihan ?? 0, $m->id, 'REQUEST PERMINTAAN PELATIHAN') !!}</td>
                                    <td>{!! $renderLink($m->count_tidak_menerima_penawaran ?? 0, $m->id, 'TIDAK MENERIMA PENAWARAN') !!}</td>
                                    <td>{!! $renderLink($m->count_tidak_respon ?? 0, $m->id, 'TIDAK RESPON') !!}</td>
                                    <td>{!! $renderLink($m->count_sudah_ada_vendor_kerjasama ?? 0, $m->id, 'SUDAH ADA VENDOR KERJASAMA') !!}</td>
                                    
                                    <td class="bg-light">{!! $renderLink($m->count_tanpa_status ?? 0, $m->id, 'tanpa_status') !!}</td>
                                    <td class="pe-4 bg-light">{!! $renderLink($total_per_marketing, $m->id, 'semua') !!}</td>
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
        
                            <tr class="table-primary fw-bold text-dark border-top border-2 border-primary">
                                <td class="text-start ps-4">TOTAL KESELURUHAN</td>
                                <td>{{ $t_belum_kebutuhan }}</td>
                                <td>{{ $t_email }}</td>
                                <td>{{ $t_dapat_telp }}</td>
                                <td>{{ $t_wa }}</td>
                                <td>{{ $t_hold }}</td>
                                <td>{{ $t_invalid }}</td>
                                <td>{{ $t_compro }}</td>
                                <td>{{ $t_manja }}</td>
                                <td>{{ $t_manja_ulang }}</td>
                                <td class="text-primary">{{ $t_penawaran }}</td>
                                <td>{{ $t_hardfile }}</td>
                                <td>{{ $t_perpanjangan }}</td>
                                <td>{{ $t_pelatihan }}</td>
                                <td>{{ $t_tidak_menerima }}</td>
                                <td>{{ $t_tidak_respon }}</td>
                                <td>{{ $t_vendor_kerjasama }}</td>
                                <td class="text-danger">{{ $t_tanpa_status }}</td>
                                <td class="pe-4 text-success">{{ $t_semua }}</td>
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
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalDetailTitle"><i class="fas fa-list me-2"></i> Detail Prospek</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
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
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-round btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Detail Penawaran & Follow Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3" id="detailBody"></div>
        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
{{-- Library Chart.js dan Highcharts Maps --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- 🔥 Tambahkan plugin datalabels di sini 🔥 --}}
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script>

<style>
    @keyframes grow { from { width: 0; } }
    .progress-bar-animate { animation: grow 1s ease-out; }
    
    /* Perbaikan agar Highcharts tidak muncul credit link */
    .highcharts-credits { display: none !important; }
</style>

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
        let pieChartInstance = null; // Simpan ke variabel agar bisa diakses custom legend

        if (ctxPie) {
            pieChartInstance = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        data: @json($pieData),
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
                        // 🔥 Matikan legend bawaan yang ada teksnya 🔥
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
                                // Hitung sum hanya dari data yang sedang AKTIF (visible)
                                let dataset = ctx.chart.data.datasets[0];
                                dataset.data.forEach((data, index) => {
                                    if (ctx.chart.getDataVisibility(index)) {
                                        sum += Number(data) || 0;
                                    }
                                });
                                
                                if (value === 0 || sum === 0) return '';
                                
                                let percentage = (value * 100 / sum).toFixed(1) + "%";
                                return percentage;
                            }
                        }
                    }
                }
            });

            // 🔥 FUNGSI MEMBUAT TOMBOL (CUSTOM LEGEND) VERSI SUPER MINI 🔥
            function buildCustomPieLegend(chart) {
                const legendContainer = document.getElementById('customPieLegend');
                legendContainer.innerHTML = ''; 

                const bgColors = chart.data.datasets[0].backgroundColor;

                chart.data.labels.forEach((label, index) => {
                    const isVisible = chart.getDataVisibility(index);
                    const color = bgColors[index];

                    const btn = document.createElement('button');
                    
                    // Class d-inline-flex agar bulatan dan teks sejajar rapi
                    btn.className = 'btn fw-bold rounded-pill border shadow-sm transition-all m-1 d-inline-flex align-items-center';
                    
                    // Custom style untuk mengecilkan ukuran tombol secara drastis
                    btn.style.padding = '2px 8px';   // Atas-bawah 2px, kiri-kanan 8px
                    btn.style.fontSize = '10px';     // Ukuran huruf sangat kecil tapi masih terbaca
                    
                    if (isVisible) {
                        btn.style.backgroundColor = color;
                        btn.style.color = '#fff';
                        btn.style.borderColor = color;
                    } else {
                        // Jika dimatikan, tombol jadi putih/abu-abu pudar
                        btn.style.backgroundColor = '#f8f9fa'; 
                        btn.style.color = '#adb5bd'; 
                        btn.style.borderColor = '#dee2e6';
                        btn.style.opacity = '0.6'; 
                    }

                    // Titik warna diperkecil jadi 8x8 px dan jarak ke teks (margin-right) dikurangi
                    btn.innerHTML = `<span style="display:inline-block; width:8px; height:8px; border-radius:50%; background-color:${isVisible ? '#fff' : color}; margin-right:4px; box-shadow: 0 1px 2px rgba(0,0,0,0.2);"></span>${label}`;

                    // Aksi saat diklik: matikan/nyalakan data
                    btn.onclick = () => {
                        chart.toggleDataVisibility(index);
                        chart.update(); // Update chart
                        buildCustomPieLegend(chart); // Render ulang tombolnya
                    };

                    legendContainer.appendChild(btn);
                });
            }

            // Panggil fungsi untuk membuat tombol saat chart pertama kali dimuat
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
                    const color = dataset.borderColor || '#0d6efd';

                    const btn = document.createElement('button');
                    btn.className = 'btn btn-sm fw-bold rounded-pill border shadow-sm transition-all';
                    
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

        // ================= 🔥 MAP HIGHCHARTS (PREMIUM STYLE) 🔥 =================
        if (document.getElementById('indonesia-map')) {
            // Data Mentah dari Controller
            const rawMapData = @json($mapData ?? []);
            
            // Format data khusus untuk Highcharts: Mengubah 'ID-JK' menjadi 'id-jk'
            const highchartsData = Object.keys(rawMapData).map(key => {
                return [key.toLowerCase(), rawMapData[key]];
            });

            Highcharts.mapChart('indonesia-map', {
                chart: {
                    map: 'countries/id/id-all',
                    backgroundColor: 'transparent',
                    style: { fontFamily: 'inherit' } // Mengikuti font bawaan template website
                },
                title: { text: null }, // Sembunyikan judul bawaan Highcharts
                credits: { enabled: false }, // Sembunyikan watermark Highcharts

                // Desain Tombol Zoom
                mapNavigation: {
                    enabled: true,
                    buttonOptions: { 
                        verticalAlign: 'bottom',
                        theme: {
                            fill: '#ffffff',
                            'stroke-width': 1,
                            stroke: '#e9ecef',
                            r: 6, // Sudut membulat
                            states: {
                                hover: { fill: '#f8f9fa' },
                                select: { stroke: '#039BE5', fill: '#e9ecef' }
                            }
                        }
                    }
                },

                // Konfigurasi Gradasi Warna (Skala Heatmap)
                colorAxis: {
                    min: 1, // 🔥 Ubah min jadi 1 (karena yang 0 akan diurus oleh nullColor)
                    minColor: '#7bb2ff', // 🔥 Biru muda terang (Sangat kontras dengan abu-abu)
                    maxColor: '#1572e8', // Biru solid gelap untuk yang paling banyak
                    labels: { style: { color: '#8d9498', fontWeight: 'bold' } }
                },

                // (Bagian tooltip biarkan sama)
                tooltip: {
                    useHTML: true,
                    backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    borderWidth: 0,
                    borderRadius: 10,
                    shadow: { color: 'rgba(0, 0, 0, 0.15)', width: 10, offsetX: 0, offsetY: 4 },
                    padding: 12,
                    formatter: function() {
                        let val = this.point.value || 0;
                        return `
                            <div style="text-align: center; min-width: 120px;">
                                <div style="font-size: 10px; color: #8d9498; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; font-weight: 700;">${this.point.name}</div>
                                <div style="font-size: 22px; font-weight: 800; color: #1572e8; line-height: 1;">${val}</div>
                                <div style="font-size: 12px; color: #6c757d; margin-top: 2px;">Total Penawaran</div>
                            </div>
                        `;
                    }
                },

                // Pengaturan Data dan Area Peta
                series: [{
                    data: highchartsData,
                    name: 'Total Penawaran',
                    nullColor: '#f0f3f5', // 🔥 Abu-abu pucat khusus untuk provinsi yang 0 (kosong)
                    borderColor: '#ffffff', // Garis batas putih
                    borderWidth: 1.5,
                    states: {
                        hover: { 
                            color: '#ff9e27', // Oranye saat disorot
                            borderColor: '#ffffff',
                            borderWidth: 2
                        } 
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '9px',
                            fontWeight: '600',
                            color: '#495057',
                            textOutline: '2px contrast' 
                        }
                    }
                }]
            });
        }
    });
</script>
@endsection
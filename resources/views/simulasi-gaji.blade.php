@extends('layouts.app') @section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-3">
            <div>
                <h3 class="fw-bold mb-1">Take Home Pay</h3>
                <h6 class="op-7 mb-2">Monitoring Gaji Bersih Karyawan</h6>
                <div class="badge badge-info">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

            {{-- Toolbar Filter gaya Pipeline --}}
            <div class="card p-2 mb-3 shadow-none border" style="background: #f9fbfd;">
                <form action="{{ route('simulasi-gaji') }}" method="GET" class="d-flex flex-wrap gap-2">
                    {{-- Filter Tanggal Mulai --}}
                    <div class="form-group p-0 m-0">
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            value="{{ $start }}" title="Tanggal Mulai">
                    </div>

                    {{-- Filter Tanggal Akhir --}}
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            value="{{ $end }}" title="Tanggal Akhir">
                    </div>

                    {{-- Filter Karyawan --}}
                    @if(auth()->user()->role !== 'marketing')
                    <div class="col-md-3">
                        {{-- <label class="small fw-bold">Pilih Marketing</label> --}}
                        <select name="marketing_id" class="form-select form-select-sm">
                            <option value="">Semua Marketing</option>
                            @foreach($all_marketing as $m)
                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Tombol Aksi --}}
                    <button type="submit" class="btn btn-primary btn-sm btn-round">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('absensi') }}" class="btn btn-border btn-round btn-sm">Reset</a>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel Simulasi Gaji</div>
                </div>
                <div class="card-body">
                    {{-- <div class="card-sub">
                      Create responsive tables by wrapping any table with
                      <code class="highlighter-rouge">.table-responsive</code>
                      <code class="highlighter-rouge">DIV</code> to make them
                      scroll horizontally on small devices
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" style="min-width: 2000px">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2">MARKETING</th>
                                    <th rowspan="2">INCOME</th>
                                    <th rowspan="2">KPI</th>
                                    <th colspan="4" class="text-center">SESUAI KPI</th>
                                    <th colspan="5" class="text-center">KEBIJAKAN KPI</th>
                                    {{-- <th rowspan="2">ACTION</th> --}}
                                </tr>
                                <tr>
                                    {{-- Sesuai KPI --}}
                                    <th>ABSENSI</th>
                                    <th>PROGRESS</th>
                                    <th>REVENEW</th>
                                    <th>TOTAL</th>

                                    {{-- Kebijakan KPI --}}
                                    <th>GAPOK</th>
                                    <th>FEE MARKETING</th>
                                    <th>PROGRES</th>
                                    <th>TUNJ KEMAHALAN</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $m)
                                    <tr>
                                        <td class="fw-bold">{{ $m->name }}</td>
                                        <td class="small text-end">Rp {{ number_format($m->income, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $m->kpi_persen >= 70 ? 'badge-success' : 'badge-danger' }}">
                                                {{ number_format($m->kpi_persen, 1) }}%
                                            </span>
                                        </td>

                                        {{-- SESUAI KPI --}}
                                        {{-- <td class="text-center">
                                            <span class="fw-bold">{{ number_format($m->ach_absensi, 1) }}%</span>
                                            <br>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $m->absensi_hadir_real }} / {{ $hariEfektif }} Hari
                                            </small>
                                        </td> --}}

                                        <td class="text-center">
                                            <span class="fw-bold">{{ number_format($m->ach_absensi, 1) }}%</span>
                                            <br>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $m->absensi_hadir_real }} / {{ $hariEfektif }} Hari
                                            </small>
                                        </td>

                                        {{-- 2. Kolom PROGRESS --}}
                                        <td class="text-center">
                                            <span class="fw-bold">{{ number_format($m->ach_progress, 1) }}%</span>
                                            <br>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $m->real_penawaran }} / {{ $m->target_penawaran }} CTA
                                            </small>
                                        </td>

                                        {{-- 3. Kolom REVENUE (Yang tadi sudah kita buat) --}}
                                        <td class="text-center">
                                            <span class="fw-bold">{{ number_format($m->ach_revenue, 1) }}%</span>
                                            <br>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                Rp {{ number_format($m->weighted_revenue_rp, 0, ',', '.') }}
                                            </small>
                                        </td>
                                        <td class="text-center fw-bold">{{ number_format($m->kpi_persen, 1) }}%</td>

                                        {{-- KEBIJAKAN KPI --}}
                                        <td class="small text-end">Rp {{ number_format($m->gapok_hitung, 0, ',', '.') }}
                                        </td>
                                        <td class="small text-end text-primary">Rp
                                            {{ number_format($m->fee_marketing, 0, ',', '.') }}</td>
                                        <td class="small text-end">Rp {{ number_format($m->progress_val, 0, ',', '.') }}
                                        </td>
                                        <td class="small text-end">Rp {{ number_format($m->tunj_kemahalan, 0, ',', '.') }}
                                        </td>

                                        {{-- TOTAL --}}
                                        <td class="small text-end fw-bold bg-dark text-white">
                                            Rp {{ number_format($m->total_gaji, 0, ',', '.') }}
                                        </td>

                                        {{-- <td class="text-center">
                                            <button class="btn btn-sm btn-info"><i class="fa fa-print"></i> Slip</button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Keterangan KPI:</strong><br>
                        <span class="badge badge-success">≥ 70%</span>
                        Marketing memenuhi KPI dan menggunakan skema <b>Sesuai KPI</b>.<br><br>

                        <span class="badge badge-danger">&lt; 70%</span>
                        Marketing tidak memenuhi KPI dan menggunakan skema <b>Kebijakan KPI</b>.
                    </div>
                    {{-- ACCORDION RUMUS GAJI --}}
                    <div class="accordion mt-4" id="accordionRumusGaji">
                        <div class="accordion-item border">
                            <h2 class="accordion-header" id="headingRumus">
                                <button class="accordion-button collapsed fw-bold bg-light" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#collapseRumus" aria-expanded="false" aria-controls="collapseRumus">
                                    <i class="fas fa-calculator me-2 text-primary"></i> Klik di sini untuk melihat Panduan Rumus Perhitungan Gaji
                                </button>
                            </h2>
                            <div id="collapseRumus" class="accordion-collapse collapse" aria-labelledby="headingRumus" data-bs-parent="#accordionRumusGaji">
                                <div class="accordion-body text-muted small" style="line-height: 1.8;">
                                    
                                    <div class="row">
                                        {{-- Kolom Kiri: Perhitungan KPI --}}
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-bold text-dark border-bottom pb-2"><i class="fas fa-chart-pie me-1"></i> 1. Rumus Skor KPI (Maksimal 100%)</h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <b>KPI Absensi (Bobot 10%)</b><br>
                                                    <code>(Total Kehadiran & Izin / Hari Kerja Efektif) x 10%</code>
                                                </li>
                                                <li class="mb-2">
                                                    <b>KPI Progress (Bobot 30%)</b><br>
                                                    <code>(Total Pembuatan & Follow Up CTA / Target CTA Sebulan) x 30%</code>
                                                </li>
                                                <li class="mb-2">
                                                    <b>KPI Revenue (Bobot 60%)</b><br>
                                                    <code>(Total Rupiah Project Deal / Target Revenue Sebulan) x 60%</code>
                                                </li>
                                            </ul>
                                            <div class="p-2 bg-light border rounded">
                                                <b>Total KPI</b> = Skor Absensi + Skor Progress + Skor Revenue.
                                            </div>
                                        </div>

                                        {{-- Kolom Kanan: Perhitungan Rupiah --}}
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-bold text-dark border-bottom pb-2"><i class="fas fa-money-bill-wave me-1"></i> 2. Rumus Komponen Gaji (Rupiah)</h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <b>Gaji Pokok (Proporsional Kehadiran)</b><br>
                                                    <code>(Total Kehadiran / Hari Kerja Efektif) x Gaji Pokok Dasar</code>
                                                </li>
                                                <li class="mb-2">
                                                    <b>Tunjangan Kemahalan</b><br>
                                                    <code>(Total Kehadiran / Hari Kerja Efektif) x Tunjangan Dasar</code>
                                                </li>
                                                <li class="mb-2">
                                                    <b>Nilai Progress</b><br>
                                                    <code>Gaji Pokok Dasar x (Skor KPI Progress / 100)</code><br>
                                                    <i>*Maksimal senilai 30% dari Gaji Pokok jika progress mencapai target.</i>
                                                </li>
                                                <li class="mb-2">
                                                    <b>Fee Marketing (Komisi)</b><br>
                                                    <code>(Total Rupiah Project Deal x 60%) x Persentase Fee</code><br>
                                                    <i>*Jika Total KPI ≥ 70%, maka Persentase Fee = <b>5%</b>.<br>
                                                    *Jika Total KPI < 70%, maka Persentase Fee turun menjadi <b>2.5%</b>.</i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning p-2 m-0 mt-2 text-dark">
                                        <i class="fas fa-info-circle me-1"></i> <b>Total Take Home Pay (Gaji Bersih)</b> = Gaji Pokok + Nilai Progress + Fee Marketing + Tunjangan Kemahalan.
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END ACCORDION --}}
                </div>
            </div>
        </div>
    </div>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection

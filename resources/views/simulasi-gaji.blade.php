@extends('layouts.app') @section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-3">
            <div>
                <h3 class="fw-bold mb-1">Simulasi Gaji</h3>
                <h6 class="op-7 mb-2">Monitoring simulasi gaji karyawan berdasarkan KPI</h6>
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
                            value="{{ request('start_date') }}" title="Tanggal Mulai">
                    </div>

                    {{-- Filter Tanggal Akhir --}}
                    <div class="form-group p-0 m-0">
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            value="{{ request('end_date') }}" title="Tanggal Akhir">
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
                                    <th rowspan="2">ACTION</th>
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
                                        <td class="text-center">{{ number_format($m->ach_absensi, 1) }}%</td>
                                        <td class="text-center">{{ number_format($m->ach_progress, 1) }}%</td>
                                        <td class="text-center">{{ number_format($m->ach_revenue, 1) }}%</td>
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

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info"><i class="fa fa-print"></i> Slip</button>
                                        </td>
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

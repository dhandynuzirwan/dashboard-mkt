@extends('layouts.app') @section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Simulasi Gaji</h3>
                    {{-- <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6> --}}
                </div>
                {{-- <div class="ms-md-auto py-2 py-md-0">
                        <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                        <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                    </div> --}}
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
                                    <th colspan="5" class="text-center">KEBIJAKAN KPI (Kurang dari 70%)</th>
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
                </div>
            </div>
        </div>
    </div>
@endsection

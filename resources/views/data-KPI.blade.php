@extends('layouts.app') @section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data KPI</h3>
                    {{-- <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6> --}}
                </div>
                {{-- <div class="ms-md-auto py-2 py-md-0">
                        <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                        <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                    </div> --}}
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel Data KPI</div>
                </div>
                <div class="card-body">
                    {{-- <div class="card-sub">
                      Create responsive tables by wrapping any table with
                      <code class="highlighter-rouge">.table-responsive</code>
                      <code class="highlighter-rouge">DIV</code> to make them
                      scroll horizontally on small devices
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2" class="text-center">MARKETING</th>
                                    <th colspan="3" class="text-center">ABSENSI</th>
                                    <th colspan="3" class="text-center">PROGRESS</th>
                                    <th colspan="3" class="text-center">REVENEW</th>
                                    <th colspan="4" class="text-center">TOTAL PENCAPAIAN KPI</th>
                                </tr>
                                <tr>
                                    {{-- Absensi --}}
                                    <th>JADWAL</th>
                                    <th>HADIR</th>
                                    <th>ACH</th>

                                    {{-- Progress --}}
                                    <th>TARGET</th>
                                    <th>REALISASI</th>
                                    <th>ACH</th>

                                    {{-- Reveneuw --}}
                                    <th>TARGET</th>
                                    <th>AKTUAL</th>
                                    <th>ACH</th>

                                    {{-- Total Pencapaian KPI --}}
                                    <th>ABSENSI</th>
                                    <th>PROGRESS</th>
                                    <th>REVENEW</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $m)
                                    <tr>
                                        <td class="fw-bold">{{ $m->name }}</td>

                                        {{-- Absensi --}}
                                        <td class="text-center">{{ $m->absensi_jadwal }}</td>
                                        <td class="text-center">{{ $m->absensi_hadir }}</td>
                                        <td class="text-center fw-bold">{{ number_format($m->absensi_ach, 1) }}%</td>

                                        {{-- Progress --}}
                                        <td class="text-center">{{ $m->progress_target }}</td>
                                        <td class="text-center">{{ $m->progress_real }}</td>
                                        <td class="text-center fw-bold text-primary">
                                            {{ number_format($m->progress_ach, 1) }}%</td>

                                        {{-- Revenue --}}
                                        <td class="small">{{ number_format($m->revenue_target, 0, ',', '.') }}</td>
                                        <td class="small text-success">{{ number_format($m->revenue_actual, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center fw-bold text-success">
                                            {{ number_format($m->revenue_ach, 1) }}%</td>

                                        {{-- Total Pencapaian --}}
                                        <td class="text-center small">{{ number_format($m->absensi_kpi, 1) }}%</td>
                                        <td class="text-center small">{{ number_format($m->progress_kpi, 1) }}%</td>
                                        <td class="text-center small">{{ number_format($m->revenue_kpi, 1) }}%</td>
                                        <td class="text-center fw-bold bg-dark text-white">
                                            {{ number_format($m->total_kpi, 1) }}%
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

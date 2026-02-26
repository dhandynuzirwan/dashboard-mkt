@extends('layouts.app') @section('content')



    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">REVENUE</h3>
                    {{-- <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6> --}}
                </div>
                {{-- <div class="ms-md-auto py-2 py-md-0">
                        <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                        <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                    </div> --}}
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel Revenue</div>
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
                                    <th rowspan="2">MARKETING</th>
                                    <th colspan="3" class="text-center">TARGET</th>
                                    <th colspan="6" class="text-center">TOTAL PENAWARAN</th>
                                    <th colspan="6" class="text-center">TOTAL DEAL</th>
                                    <th rowspan="2">TOTAL DEAL</th>
                                    <th rowspan="2">ACTION</th>
                                </tr>
                                <tr>
                                    {{-- Target --}}
                                    <th>TARGET</th>
                                    <th>ACHIEVE</th>
                                    <th>AVG</th>

                                    {{-- Total Penawan --}}
                                    <th>KEMENAKER</th>
                                    <th>BNSP</th>
                                    <th>INTERNAL</th>
                                    <th>PP SIO</th>
                                    <th>RIKSA UJI ALAT</th>
                                    <th>TOT</th>

                                    {{-- Total Deal --}}
                                    <th>KEMENAKER</th>
                                    <th>BNSP</th>
                                    <th>INTERNAL</th>
                                    <th>PP SIO</th>
                                    <th>RIKSA UJI ALAT</th>
                                    <th>TOT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketings as $m)
                                    <tr>
                                        <td class="fw-bold">{{ $m->name }}</td>

                                        {{-- TARGET AREA --}}
                                        <td class="small">{{ number_format($m->target, 0, ',', '.') }}</td>
                                        <td class="small text-success fw-bold">{{ number_format($m->achieve, 0, ',', '.') }}
                                        </td>
                                        <td><span class="badge badge-info">{{ number_format($m->avg, 1) }}%</span></td>

                                        {{-- RUPIAH PENAWARAN --}}
                                        <td class="text-end small">{{ number_format($m->rp_pen_kemenaker, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end small">{{ number_format($m->rp_pen_bnsp, 0, ',', '.') }}</td>
                                        <td class="text-end small">{{ number_format($m->rp_pen_internal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end small">{{ number_format($m->rp_pen_ppsio, 0, ',', '.') }}</td>
                                        <td class="text-end small">{{ number_format($m->rp_pen_riksa, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold bg-light">
                                            {{ number_format($m->total_rp_pen, 0, ',', '.') }}</td>

                                        {{-- RUPIAH DEAL --}}
                                        <td class="text-end small">{{ number_format($m->rp_deal_kemenaker, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end small">{{ number_format($m->rp_deal_bnsp, 0, ',', '.') }}</td>
                                        <td class="text-end small">{{ number_format($m->rp_deal_internal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end small">{{ number_format($m->rp_deal_ppsio, 0, ',', '.') }}</td>
                                        <td class="text-end small">{{ number_format($m->rp_deal_riksa, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold bg-success text-white">
                                            {{ number_format($m->total_rp_deal, 0, ',', '.') }}</td>

                                        {{-- TOTAL AKHIR --}}
                                        <td class="text-end fw-bold text-primary">
                                            {{ number_format($m->total_rp_deal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary">Detail</button>
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

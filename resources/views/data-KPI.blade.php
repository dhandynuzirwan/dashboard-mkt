@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
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
                                <th colspan="4" class="text-center">ABSENSI</th>                                
                                <th colspan="3" class="text-center">PROGRESS</th>
                                <th colspan="3" class="text-center">REVENEW</th>
                                <th colspan="4" class="text-center">TOTAL PENCAPAIAN KPI</th>
                            </tr>
                            <tr>
                                {{-- Absensi --}}
                                <th>JADWAL</th>
                                <th>HADIR</th>
                                <th>ACH</th>
                                <th>%</th>

                                {{-- Progress --}}
                                <th>TARGET</th>
                                <th>AVG</th>
                                <th>ACH</th>

                                {{-- Reveneuw --}}
                                <th>TARGET</th>
                                <th>AVG</th>
                                <th>ACH</th>

                                {{-- Total Pencapaian KPI --}}
                                <th>ABSENSI</th>
                                <th>PROGRESS</th>
                                <th>REVENEW</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Marketing 1</td>
                                <td>22</td>
                                <td>20</td>
                                <td>18</td>
                                <td>90%</td>
                                <td>100</td>
                                <td>85</td>
                                <td>85%</td>
                                <td>200</td>
                                <td>180</td>
                                <td>90%</td>
                                <td>90</td>
                                <td>85</td>
                                <td>90</td>
                                <td>265</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
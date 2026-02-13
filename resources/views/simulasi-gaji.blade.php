@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
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
                      <table class="table table-bordered">
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
                        <tbody>
                            <tr>
                                <td>MARKETING 1</td>
                                <td>10.000.000</td>
                                <td>8.000.000</td>
                                <td>90%</td>
                                <td>85%</td>
                                <td>80%</td>
                                <td>255%</td>
                                <td>5.000.000</td>
                                <td>2.000.000</td>
                                <td>1.500.000</td>
                                <td>500.000</td>
                                <td>9.000.000</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>MARKETING 2</td>
                                <td>8.000.000</td>
                                <td>75%</td>
                                <td>80%</td>
                                <td>70%</td>
                                <td>75%</td>
                                <td>225%</td>
                                <td>4.000.000</td>
                                <td>1.500.000</td>
                                <td>1.200.000</td>
                                <td>400.000</td>
                                <td>7.100.000</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                </td>
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
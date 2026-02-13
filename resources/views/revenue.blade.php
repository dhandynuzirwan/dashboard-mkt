@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Dashboard PT</h3>
                        <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6>
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
                        <thead>
                            <tr>
                                <th rowspan="2">MARKETING</th>                                
                                <th colspan="3">TARGET</th>                                
                                <th colspan="9">TOTAL PENAWARAN</th>
                                <th colspan="8">TOTAL DEAL</th>
                                <th rowspan="2">TOTAL DEAL</th>
                                <th rowspan="2">ACTION</th>
                            </tr>
                            <tr>
                                {{-- Target --}}
                                <th>TARGET</th>
                                <th>ACHIEVE</th>
                                <th>% PROG</th>

                                {{-- Total Penawan --}}
                                <th>KEMEN</th>
                                <th>BNSP</th>
                                <th>S INT</th>
                                <th>PP SIO</th>
                                <th>RUA</th>
                                <th>SK HUB</th>
                                <th>RE BNSP</th>
                                <th>ESDM</th>
                                <th>TOT</th>

                                {{-- Total Deal --}}
                                <th>KEMEN</th>
                                <th>BNSP</th>
                                <th>S INT</th>
                                <th>PP SIO</th>
                                <th>RUA</th>
                                <th>SK HUB</th>
                                <th>RE BNSP</th>
                                <th>ESDM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Marketing  1</td>
                                <td>100</td>
                                <td>80</td>
                                <td>80%</td>

                                <td>10</td>
                                <td>5</td>
                                <td>8</td>
                                <td>7</td>
                                <td>6</td>
                                <td>4</td>
                                <td>3</td>
                                <td>2</td>
                                <td>45</td>

                                <td>8</td>
                                <td>4</td>
                                <td>6</td>
                                <td>5</td>
                                <td>4</td>
                                <td>3</td>
                                <td>2</td>
                                <td>1</td>

                                <td>34</td>
                                <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
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
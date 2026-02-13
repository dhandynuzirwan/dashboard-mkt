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
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                    class="icon-big text-center icon-primary bubble-shadow-small"
                                    >
                                    <i class="fas fa-bullseye"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                    <p class="card-category">Total Target</p>
                                    <h4 class="card-title">2.400</h4>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                    class="icon-big text-center icon-primary bubble-shadow-small"
                                    >
                                    <i class="fas fa-award"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                    <p class="card-category">Total Achive</p>
                                    <h4 class="card-title">470</h4>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                    class="icon-big text-center icon-primary bubble-shadow-small"
                                    >
                                    <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                    <p class="card-category">AVG Progress</p>
                                    <h4 class="card-title">19%</h4>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                    class="icon-big text-center icon-primary bubble-shadow-small"
                                    >
                                    <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                    <p class="card-category">Total Progress</p>
                                    <h4 class="card-title">470</h4>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Tabel Progress</div>
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
                            <th>No</th>
                            <th>Marketing</th>
                            <th>Target</th>
                            <th>Achieve</th>
                            <th>%Progress</th>
                            <th>Total FU</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Marketing 1</td>
                            <td>600</td>
                            <td>60</td> 
                            <td style="width: 250px;">
                            <div class="d-flex align-items-center">
                                <div class="progress flex-1" style="height: 6px; width: 100%;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2 fw-bold">10%</span>
                            </div>
                            </td>
                            <td>120</td>
                            <td>
                            <a href="#" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">2</th>
                            <td>Marketing 2</td>
                            <td>600</td>
                            <td>120</td> 
                            <td style="width: 250px;">
                            <div class="d-flex align-items-center">
                                <div class="progress flex-1" style="height: 6px; width: 100%;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2 fw-bold">20%</span>
                            </div>
                            </td>
                            <td>180</td>
                            <td>
                            <a href="#" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">3</th>
                            <td>Marketing 3</td>
                            <td>600</td>
                            <td>180</td> 
                            <td style="width: 250px;">
                            <div class="d-flex align-items-center">
                                <div class="progress flex-1" style="height: 6px; width: 100%;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ms-2 fw-bold">30%</span>
                            </div>
                            </td>
                            <td>240</td>
                            <td>
                            <a href="#" class="btn btn-info btn-sm">Detail</a>
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
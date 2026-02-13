@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Pipeline Marketing</h3>
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
                </div>
                {{-- jika ingin dua tabel side by side --}}
                {{-- <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tabel Pipeline</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>DATE</th>                    
                                        <th>PERUSAHAAN</th>
                                        <th>NO TELP</th>
                                        <th>EMAIL</th>
                                        <th>JABATAN</th>
                                        <th>NAMA</th>
                                        <th>TELP PIC</th>
                                        <th>ALAMAT PERUSAHAAN</th>
                                        <th>SOURCE</th>
                                        <th>UPDATE FU</th>
                                        <th>STATUS AKHIR DATA</th>
                                        <th>KETERANGAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2024-01-01</td>
                                            <td>PT. Maju Jaya</td>
                                            <td>08123456789</td>
                                            <td>marketing@ptmaju.com</td>
                                            <td>HRD</td>
                                            <td>John Doe</td>
                                            <td>08123456789</td>
                                            <td>Jl. Raya Maju Jaya No. 123</td>
                                            <td>Database Marketing</td>
                                            <td>Terhubung HRD</td>
                                            <td>Masuk Penawaran</td>
                                            <td>PT INDO, Ibu Sinta (0888229)</td>
                                            <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
                                            <td><a href="#" class="btn btn-success btn-sm">CTA</a></td>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Data CTA Marketing</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID PROSPEK</th>
                                        <th>MARKETING</th>
                                        <th>DATE</th>                    
                                        <th>PERUSAHAAN</th>
                                        <th>PERMINTAAN JUDUL</th>
                                        <th>JUMLAH PESERTA</th>
                                        <th>SERTIFIKASI</th>
                                        <th>SKEMA</th>
                                        <th>HARGA PENAWARAN</th>
                                        <th>HARGA VENDOR</th>
                                        <th>PROPOSAL PENAWARAN</th>
                                        <th>STATUS PENAWARAN</th>
                                        <th>KETERANGAN</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Marketing 1</td>
                                            <td>2024-01-01</td>
                                            <td>PT. Maju Jaya</td>
                                            <td>Teknisi K3 Listrik</td>
                                            <td>5</td>
                                            <td>KEMENAKER RI</td>
                                            <td>Public Training</td>
                                            <td>Rp 50.000.000</td>
                                            <td>Rp 35.000.000</td>
                                            <td><a href="#">Nama File</a></td>
                                            <td>Under Review</td>
                                            <td>Belum ada kabar</td>
                                            <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Tabel Pipeline</div>
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
                            <th>ID</th>
                            <th>DATE</th>                    
                            <th>PERUSAHAAN</th>
                            <th>NO TELP</th>
                            <th>EMAIL</th>
                            <th>JABATAN</th>
                            <th>NAMA</th>
                            <th>TELP PIC</th>
                            <th>ALAMAT PERUSAHAAN</th>
                            <th>SOURCE</th>
                            <th>UPDATE FU</th>
                            <th>STATUS AKHIR DATA</th>
                            <th>KETERANGAN</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2024-01-01</td>
                                <td>PT. Maju Jaya</td>
                                <td>08123456789</td>
                                <td>marketing@ptmaju.com</td>
                                <td>HRD</td>
                                <td>John Doe</td>
                                <td>08123456789</td>
                                <td>Jl. Raya Maju Jaya No. 123</td>
                                <td>Database Marketing</td>
                                <td>Terhubung HRD</td>
                                <td>Masuk Penawaran</td>
                                <td>PT INDO, Ibu Sinta (0888229)</td>
                                <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
                                <td><a href="#" class="btn btn-success btn-sm">CTA</a></td>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Data CTA Marketing</div>
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
                            <th>ID PROSPEK</th>
                            <th>MARKETING</th>
                            <th>DATE</th>                    
                            <th>PERUSAHAAN</th>
                            <th>PERMINTAAN JUDUL</th>
                            <th>JUMLAH PESERTA</th>
                            <th>SERTIFIKASI</th>
                            <th>SKEMA</th>
                            <th>HARGA PENAWARAN</th>
                            <th>HARGA VENDOR</th>
                            <th>PROPOSAL PENAWARAN</th>
                            <th>STATUS PENAWARAN</th>
                            <th>KETERANGAN</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Marketing 1</td>
                                <td>2024-01-01</td>
                                <td>PT. Maju Jaya</td>
                                <td>Teknisi K3 Listrik</td>
                                <td>5</td>
                                <td>KEMENAKER RI</td>
                                <td>Public Training</td>
                                <td>Rp 50.000.000</td>
                                <td>Rp 35.000.000</td>
                                <td><a href="#">Nama File</a></td>
                                <td>Under Review</td>
                                <td>Belum ada kabar</td>
                                <td><a href="#" class="btn btn-primary btn-sm">Edit</a></td>
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
@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Penggajian</h3>
                        <h6 class="op-7 mb-2">Manejemen Data Gaji Karyawan</h6>
                    </div>
                </div>
                <div class="mb-4">
                    <a href="{{ route('form-penggajian') }}" class="btn btn-success">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>
                        Tambah Data
                    </a>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Tabel Data Gaji Karyawan</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Marketing</th>
                            <th>Target Call</th>
                            <th>Target (Rp)</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Marketing 1</td>
                                <td>100</td>
                                <td>10.000.000</td>
                                <td>5.000.000</td>
                                <td>2.000.000</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Marketing 2</td>
                                <td>150</td>
                                <td>15.000.000</td>
                                <td>7.500.000</td>
                                <td>3.000.000</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Marketing 3</td>
                                <td>200</td>
                                <td>20.000.000</td>
                                <td>10.000.000</td>
                                <td>4.000.000</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
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

@endsection
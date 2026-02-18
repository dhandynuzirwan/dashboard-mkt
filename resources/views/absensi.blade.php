@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Absensi</h3>
                        <h6 class="op-7 mb-2">Manejemen Data Absensi Karyawan</h6>
                    </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Tabel Data Absensi Karyawan</div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Marketing</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Hadir</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                            <th>%</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>Januari</td>
                                <td>2026</td>
                                <td>20</td>
                                <td>2</td>
                                <td>1</td>
                                <td>0</td>
                                <td>90%</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>Februari</td>
                                <td>2026</td>
                                <td>18</td>
                                <td>1</td>
                                <td>2</td>
                                <td>1</td>
                                <td>85%</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Michael Johnson</td>
                                <td>Maret</td>
                                <td>2026</td>
                                <td>22</td>
                                <td>0</td>
                                <td>1</td>
                                <td>0</td>
                                <td>95%</td>
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
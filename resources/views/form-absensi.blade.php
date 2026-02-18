@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Data Absensi Karyawan</h3>
                        <h6 class="op-7 mb-2">Formulir Tambah Absensi Karyawan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Form Tambah Absensi Karyawan</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    {{-- 
                                    Marketing (enum Marketing 1, Marketing 2, Marketing 3)
                                    Tanggal Inputan (rentang tanggal)
                                    Hadir
                                    Sakit
                                    Izin
                                    Alpha
                                    --}}

                                    <div class="form-group">
                                        <label for="marketing">Marketing</label>
                                        <select class="form-select form-control" id="marketing" name="marketing">
                                            <option value="Marketing 1">Marketing 1</option>
                                            <option value="Marketing 2">Marketing 2</option>
                                            <option value="Marketing 3">Marketing 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Periode Absensi</label>
                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                </div>
                                                <small class="text-muted">Tanggal Mulai</small>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                                </div>
                                                <small class="text-muted">Tanggal Selesai</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="hadir">Hadir</label>
                                                <input type="number" class="form-control" id="hadir" name="hadir" placeholder="Jumlah Hadir">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="sakit">Sakit</label>
                                                <input type="number" class="form-control" id="sakit" name="sakit" placeholder="Jumlah Sakit">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="izin">Izin</label>
                                                <input type="number" class="form-control" id="izin" name="izin" placeholder="Jumlah Izin">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="alpha">Alpha</label>
                                                <input type="number" class="form-control" id="alpha" name="alpha" placeholder="Jumlah Alpha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
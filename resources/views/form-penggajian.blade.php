@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Data Penggajian Karyawan</h3>
                        <h6 class="op-7 mb-2">Formulir Tambah Penggajian Karyawan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Form Tambah Penggajian Karyawan</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    {{-- 
                                    Marketing (enum Marketing 1, Marketing 2, Marketing 3)
                                    Target Call
                                    Target (Rp)
                                    Gaji Pokok
                                    Tunjangan]
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
                                        <label for="target_call">Target Call</label>
                                        <input type="number" class="form-control" id="target_call" name="target_call" placeholder="Masukkan Target Call">
                                    </div>
                                    <div class="form-group">
                                        <label for="target">Target (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input
                                            type="number"
                                            class="form-control"
                                            id="target" name="target"
                                            aria-label="Amount (to the nearest rupiah)"
                                            />
                                            <span class="input-group-text">.00</span>
                                        </div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="gaji_pokok">Gaji Pokok</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input
                                            type="number"
                                            class="form-control"
                                            id="gaji_pokok" name="gaji_pokok"
                                            aria-label="Amount (to the nearest rupiah)"
                                            />
                                            <span class="input-group-text">.00</span>
                                        </div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="tunjangan">Tunjangan</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input
                                            type="number"
                                            class="form-control"
                                            id="tunjangan" name="tunjangan"
                                            aria-label="Amount (to the nearest rupiah)"
                                            />
                                            <span class="input-group-text">.00</span>
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
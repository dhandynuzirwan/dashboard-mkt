@extends('layouts.app')

@section('content')
@include('layouts.sidebar')

<div class="wrapper">
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Data Masuk</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('data-masuk.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="fw-bold">Marketing</label>
                                    <select name="marketing_id" class="form-select" required>
                                        @foreach($marketings as $m)
                                            <option value="{{ $m->id }}"
                                                {{ $data->marketing_id == $m->id ? 'selected' : '' }}>
                                                {{ $m->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label>Perusahaan</label>
                                    <input type="text" name="perusahaan" class="form-control"
                                           value="{{ old('perusahaan', $data->perusahaan) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Nomor Telp</label>
                                    <input type="text" name="telp" class="form-control"
                                           value="{{ old('telp', $data->telp) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Unit Bisnis</label>
                                    <input type="text" name="unit_bisnis" class="form-control"
                                           value="{{ old('unit_bisnis', $data->unit_bisnis) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $data->email) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Status Email</label>
                                    <input type="text" name="status_email" class="form-control"
                                           value="{{ old('status_email', $data->status_email) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>WA PIC</label>
                                    <input type="text" name="wa_pic" class="form-control"
                                           value="{{ old('wa_pic', $data->wa_pic) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>WA Baru</label>
                                    <input type="text" name="wa_baru" class="form-control"
                                           value="{{ old('wa_baru', $data->wa_baru) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control"
                                           value="{{ old('lokasi', $data->lokasi) }}">
                                </div>

                                <div class="col-md-6">
                                    <label>Sumber</label>
                                    <input type="text" name="sumber" class="form-control"
                                           value="{{ old('sumber', $data->sumber) }}">
                                </div>

                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary">Update Data</button>
                                <a href="{{ route('data-masuk') }}" class="btn btn-secondary">Kembali</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
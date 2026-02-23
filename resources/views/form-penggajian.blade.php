@extends('layouts.app')

@section('content')

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

                {{-- ALERT VALIDATION ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="card-title">Form Tambah Penggajian Karyawan</div>
                            </div>

                            <div class="card-body">

                                {{-- FORM START --}}
                                <form action="{{ route('penggajian.store') }}" method="POST">
                                    @csrf

                                    <div class="row">

                                        {{-- MARKETING --}}
                                        <div class="form-group mb-3">
                                            <label>Marketing</label>
                                            <select class="form-control" name="user_id" required>
                                                <option value="">-- Pilih Marketing --</option>
                                                @foreach($marketings as $marketing)
                                                    <option value="{{ $marketing->id }}"
                                                        {{ old('user_id') == $marketing->id ? 'selected' : '' }}>
                                                        {{ $marketing->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- TARGET CALL --}}
                                        <div class="form-group mb-3">
                                            <label>Target Call</label>
                                            <input type="number"
                                                   class="form-control"
                                                   name="target_call"
                                                   value="{{ old('target_call') }}"
                                                   placeholder="Masukkan Target Call"
                                                   required>
                                        </div>

                                        {{-- TARGET --}}
                                        <div class="form-group mb-3">
                                            <label>Target (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                       class="form-control"
                                                       name="target"
                                                       value="{{ old('target') }}"
                                                       required>
                                            </div>
                                        </div>

                                        {{-- GAJI POKOK --}}
                                        <div class="form-group mb-3">
                                            <label>Gaji Pokok</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                       class="form-control"
                                                       name="gaji_pokok"
                                                       value="{{ old('gaji_pokok') }}"
                                                       required>
                                            </div>
                                        </div>

                                        {{-- TUNJANGAN --}}
                                        <div class="form-group mb-3">
                                            <label>Tunjangan</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                       class="form-control"
                                                       name="tunjangan"
                                                       value="{{ old('tunjangan') }}"
                                                       required>
                                            </div>
                                        </div>

                                        {{-- BUTTON --}}
                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                Simpan Data
                                            </button>
                                            <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">
                                                Kembali
                                            </a>
                                        </div>

                                    </div>

                                </form>
                                {{-- FORM END --}}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
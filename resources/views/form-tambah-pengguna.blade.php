@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data Pengguna</h3>
                    <h6 class="op-7 mb-2">Formulir Tambah Pengguna Baru</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">Form Tambah Pengguna</div>
                        </div>

                        <div class="card-body">

                            {{-- ALERT ERROR VALIDATION --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf

                                <div class="row">

                                    {{-- NAMA --}}
                                    <div class="form-group col-md-6">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Masukkan Nama" value="{{ old('name') }}" required>
                                    </div>

                                    {{-- EMAIL --}}
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Masukkan Email" value="{{ old('email') }}" required>
                                    </div>

                                    {{-- PASSWORD --}}
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Masukkan Password" required>
                                    </div>

                                    {{-- ROLE --}}
                                    <div class="form-group col-md-6">
                                        <label for="role">Role</label>
                                        <select class="form-select form-control" id="role" name="role" required>
                                            <option value="">Pilih Role</option>
                                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                                Super Admin
                                            </option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="marketing" {{ old('role') == 'marketing' ? 'selected' : '' }}>
                                                Marketing
                                            </option>
                                        </select>
                                    </div>

                                    {{-- BUTTON --}}
                                    <div class="form-group col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                        <a href="{{ route('user') }}" class="btn btn-secondary">
                                            Kembali
                                        </a>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

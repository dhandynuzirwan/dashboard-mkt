@extends('layouts.app') @section('content')



            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Data Pengguna</h3>
                            <h6 class="op-7 mb-2">Manejemen Data Pengguna</h6>
                        </div>
                    </div>
                    {{-- // Tombol Tambah Pengguna mengarah ke form-tambah-pengguna --}}
                    <div class="mb-4">
                        <a href="{{ route('form-tambah-pengguna') }}" class="btn btn-success">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Pengguna
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Tabel Data Pengguna</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>-</td>
                                                <td>******</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 @endsection

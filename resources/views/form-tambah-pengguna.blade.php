@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
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
                                <div class="row">
                                    
                                    {{-- 
                                    nama
                                    email
                                    no hp
                                    password
                                    role (enum Super Admin, Admin, User)
                                    --}}
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <div class="input-group">
                                            <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Username"
                                            aria-label="username"
                                            aria-describedby="basic-addon2"
                                            />
                                            <span class="input-group-text" id="basic-addon2"
                                            >@company.com</span
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No HP</label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select
                                            class="form-select form-control"
                                            id="role"
                                        >
                                            <option value="">Pilih Role</option>
                                            <option value="super_admin">Super Admin</option>
                                            <option value="admin">Admin</option>
                                            <option value="Marketing">Marketing</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button
                                            type="submit"
                                            class="btn btn-primary"
                                            >
                                            Submit
                                            </button>
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
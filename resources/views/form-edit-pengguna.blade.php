@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">User Management</h4>
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="{{ route('user') }}"><i class="flaticon-home"></i></a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="{{ route('user') }}">User</a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="#">Edit Pengguna</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Data: {{ $user->name }}</div>
                    </div>
                    {{-- Form mengarah ke route update dengan method PUT --}}
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <div class="row">
                                {{-- Input Nama --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $user->name) }}" required>
                                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Input Email --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $user->email) }}" required>
                                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Input Role --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role Pengguna</label>
                                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                                            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="marketing" {{ old('role', $user->role) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                        </select>
                                        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                

                                {{-- Input Password --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password">Password Baru</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Kosongkan jika tidak ingin mengubah password">
                                        <small class="text-muted">Biarkan kosong jika tetap memakai password lama.</small>
                                        @error('password') <br><span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary btn-round">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('user') }}" class="btn btn-danger btn-round">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                                            <th>Target Call Harian</th>
                                            <th>Target (Rp)</th>
                                            <th>Gaji Pokok</th>
                                            <th>Tunjangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penggajians as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->target_call }}</td>
                                                <td>Rp {{ number_format($item->target, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('penggajian.edit', $item->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('penggajian.destroy', $item->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus data ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
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
        </div>
    </div>
@endsection

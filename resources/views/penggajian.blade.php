@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Penggajian & Aturan Potongan</h3>
                <h6 class="op-7 mb-2">Manajemen Data Gaji Karyawan & Master Potongan Izin</h6>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <div class="card-title">Tabel Data Gaji Karyawan</div>
                <a href="{{ route('form-penggajian') }}" class="btn btn-success btn-sm ms-auto">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>
                    Tambah Data Gaji
                </a>
                {{-- <button class="btn btn-primary btn-sm ms-auto">
                    <i class="fa fa-plus"></i> Tambah Data Gaji
                </button> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Marketing</th>
                                <th>Target Call</th>
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
                                        <a href="{{ route('penggajian.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data gaji ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="card-title">Aturan Potongan Gaji per Jenis Izin</div>
                <button class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                    <i class="fa fa-plus"></i> Tambah Aturan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Izin (Fingerspot)</th>
                                <th>Potongan (Rp)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis_izins as $idx => $izin)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $izin->nama_izin }}</td>
                                    <td class="text-danger">Rp {{ number_format($izin->potongan, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditIzin{{ $izin->id }}">Edit</button>
                                        <form action="{{ route('jenis-izin.destroy', $izin->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus aturan potongan ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditIzin{{ $izin->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <form action="{{ route('jenis-izin.update', $izin->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Edit Aturan Potongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Jenis Izin</label>
                                                        <input type="text" name="nama_izin" class="form-control" value="{{ $izin->nama_izin }}" required>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label>Besar Potongan (Rp)</label>
                                                        <input type="number" name="potongan" class="form-control" value="{{ (int)$izin->potongan }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-border" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambahIzin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('jenis-izin.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Aturan Izin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis Izin (Samakan dengan CSV Fingerspot)</label>
                        <input type="text" name="nama_izin" class="form-control" placeholder="Contoh: Sakit Tanpa Surat Dokter" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Besar Potongan (Rp)</label>
                        <input type="number" name="potongan" class="form-control" placeholder="100000" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Aturan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
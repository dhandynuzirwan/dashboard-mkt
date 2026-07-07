@extends('layouts.app')
@section('title', 'Master Instruktur / Narasumber')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h4 class="page-title">Master Instruktur / Narasumber</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard.progress') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Performance</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Master Instruktur</a>
            </li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Instruktur</h4>
                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus"></i> Tambah Instruktur
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Instruktur</th>
                                    <th>Wilayah/Instansi</th>
                                    <th>No Telp</th>
                                    <th>Bidang Ahli</th>
                                    <th>Rate (Harga)</th>
                                    <th>Rekening</th>
                                    <th>Link CV</th>
                                    <th>Penginput</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($instrukturs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_instruktur }}</td>
                                    <td>{{ $item->wilayah_instansi }}</td>
                                    <td>{{ $item->no_telepon }}</td>
                                    <td>{{ $item->bidang_ahli }}</td>
                                    <td>Rp {{ number_format($item->rate_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <strong>Bank:</strong> {{ $item->bank }} <br>
                                        <strong>No:</strong> {{ $item->no_rek }}
                                    </td>
                                    <td>
                                        @if($item->link_cv)
                                            <a href="{{ $item->link_cv }}" target="_blank" class="btn btn-sm btn-outline-info">Buka CV</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->user->nama_lengkap ?? $item->user->name }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('master-instruktur.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus instruktur ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('master-instruktur.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Instruktur</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label>Nama Instruktur <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="nama_instruktur" value="{{ $item->nama_instruktur }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Wilayah/Instansi <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="wilayah_instansi" value="{{ $item->wilayah_instansi }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Nomor Telepon <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="no_telepon" value="{{ $item->no_telepon }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Bidang Ahli <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="bidang_ahli" value="{{ $item->bidang_ahli }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Rate Harga (Rp) <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control input-currency" name="rate_harga_display" value="{{ number_format($item->rate_harga, 0, ',', '.') }}" required>
                                                            <input type="hidden" name="rate_harga" class="input-currency-hidden" value="{{ $item->rate_harga }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Nama Bank <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="bank" value="{{ $item->bank }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>No Rekening <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="no_rek" value="{{ $item->no_rek }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label>Link CV (Opsional)</label>
                                                            <input type="url" class="form-control" name="link_cv" value="{{ $item->link_cv }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('master-instruktur.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Instruktur Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Instruktur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_instruktur" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Wilayah/Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="wilayah_instansi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_telepon" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Bidang Ahli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bidang_ahli" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Rate Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-currency" name="rate_harga_display" required>
                            <input type="hidden" name="rate_harga" class="input-currency-hidden">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bank" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_rek" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Link CV (Opsional)</label>
                            <input type="url" class="form-control" name="link_cv">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Instruktur</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable();

        // Currency Auto Formatting
        $('.input-currency').on('keyup', function(e) {
            let val = $(this).val();
            // hilangkan karakter selain angka
            val = val.replace(/[^,\d]/g, '').toString();
            // split berdasarkan koma (untuk desimal)
            let split = val.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            $(this).val(rupiah);
            
            // Set real value to hidden input
            $(this).closest('.mb-3').find('.input-currency-hidden').val(val.replace(/\./g, ''));
        });

        // Format at start
        $('.input-currency').each(function() {
            let val = $(this).val();
            if (val) {
                $(this).closest('.mb-3').find('.input-currency-hidden').val(val.replace(/\./g, ''));
            }
        });
    });
</script>
@endsection

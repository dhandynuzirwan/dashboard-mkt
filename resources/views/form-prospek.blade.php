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
                        <h4 class="card-title">Input Massal Data Prospek</h4>
                        <p class="text-muted">Klik pada kolom <b>Perusahaan</b>, lalu tekan <b>Ctrl + V</b> untuk copas 12 kolom sekaligus dari Excel.</p>
                    </div>
                    <div class="card-body">
                        <form id="bulkForm" action="{{ route('prospek.store') }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label>Marketing</label>
                                    <select name="marketing_id" class="form-select" required>
                                        <option value="">-- Pilih Marketing --</option>
                                        @foreach($marketings as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Prospek</label>
                                    <input type="date" name="tanggal_prospek" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="tableProspek" style="min-width: 4000px;">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th style="width: 200px;">Perusahaan</th>
                                            <th style="width: 150px;">Telp</th>
                                            <th style="width: 200px;">Email</th>
                                            <th style="width: 150px;">Jabatan</th>
                                            <th style="width: 200px;">Nama HRD/PIC</th>
                                            <th style="width: 150px;">WA HRD/PIC</th>
                                            <th style="width: 150px;">WA Baru</th>
                                            <th style="width: 200px;">Lokasi</th>
                                            <th style="width: 150px;">Sumber</th>
                                            <th style="width: 150px;">Update Terakhir</th>
                                            <th style="width: 150px;">Status</th>
                                            <th style="width: 250px;">Deskripsi</th>
                                            <th style="width: 250px;">Catatan</th>
                                            <th style="width: 50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="rows[0][perusahaan]" class="form-control paste-input" placeholder="Paste di sini"></td>
                                            <td><input type="text" name="rows[0][telp]" class="form-control"></td>
                                            <td><input type="email" name="rows[0][email]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][jabatan]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][nama_pic]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][wa_pic]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][wa_baru]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][lokasi]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][sumber]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][update_terakhir]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][status]" class="form-control"></td>
                                            <td><textarea name="rows[0][deskripsi]" class="form-control" rows="1"></textarea></td>
                                            <td><textarea name="rows[0][catatan]" class="form-control" rows="1"></textarea></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="addRow" class="btn btn-secondary btn-sm">Tambah Baris Manual</button>
                                <button type="submit" class="btn btn-primary btn-sm float-end">Simpan Semua Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let rowIdx = 1;

    function createRow(index) {
        return `<tr>
            <td><input type="text" name="rows[${index}][perusahaan]" class="form-control paste-input"></td>
            <td><input type="text" name="rows[${index}][telp]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][email]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][jabatan]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][nama_pic]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][wa_pic]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][wa_baru]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][lokasi]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][sumber]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][update_terakhir]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][status]" class="form-control"></td>
            <td><textarea name="rows[${index}][deskripsi]" class="form-control" rows="1"></textarea></td>
            <td><textarea name="rows[${index}][catatan]" class="form-control" rows="1"></textarea></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
        </tr>`;
    }

    $('#addRow').click(function() {
        $('#tableProspek tbody').append(createRow(rowIdx++));
    });

    $(document).on('paste', '.paste-input', function(e) {
        e.preventDefault();
        let cbData = (e.originalEvent || e).clipboardData.getData('text');
        let lines = cbData.split(/\r?\n/);
        let currentRow = $(this).closest('tr');

        lines.forEach((line) => {
            if (line.trim() === '') return;
            let cols = line.split('\t');

            if (currentRow.length === 0) {
                $('#tableProspek tbody').append(createRow(rowIdx++));
                currentRow = $('#tableProspek tbody tr').last();
            }

            let inputs = currentRow.find('input, textarea');
            cols.forEach((val, j) => {
                if (inputs.eq(j).length) {
                    inputs.eq(j).val(val.trim());
                }
            });

            currentRow = currentRow.next();
        });
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });
});
</script>
@endpush
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
                        <h4 class="card-title">Input Massal Data Masuk</h4>
                        <p class="text-muted">Klik pada kolom <b>Perusahaan</b>, lalu tekan <b>Ctrl + V</b> untuk copas 12 kolom sekaligus dari Excel.</p>
                    </div>
                    <div class="card-body">
                        <form id="bulkForm" action="" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div>
                                    <label>Marketing</label>
                                    <select name="marketing_id" class="form-select">
                                        <option value="1">Marketing 1</option>
                                        <option value="2">Marketing 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="tableProspek" style="min-width: 1500px">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th style="width: 200px;">Perusahaan</th>
                                            <th style="width: 150px;">Nomor Telp</th>
                                            <th style="width: 200px;">Unit Bisnis</th>
                                            <th style="width: 150px;">Email Perusahaan</th>
                                            <th style="width: 150px;">Status Email</th>
                                            <th style="width: 200px;">WA PIC</th>
                                            <th style="width: 200px;">Alamat Perusahaan</th>
                                            <th style="width: 150px;">Source</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="rows[0][perusahaan]" class="form-control paste-input" placeholder="Paste di sini"></td>
                                            <td><input type="text" name="rows[0][telp]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][unit_bisnis]" class="form-control"></td>
                                            <td><input type="email" name="rows[0][email_perusahaan]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][status_email]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][wa_pic]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][alamat_perusahaan]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][source]" class="form-control"></td>
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
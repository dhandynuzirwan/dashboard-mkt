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
                        <p class="text-muted">Klik pada kolom <b>Perusahaan</b>, lalu tekan <b>Ctrl + V</b> untuk copas kolom dari Excel (Urutan: Perusahaan, Telp, Unit Bisnis, Email, Status Email, WA PIC, Lokasi, Sumber).</p>
                    </div>
                    <div class="card-body">
                        <form id="bulkForm" action="{{ route('data-masuk.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="fw-bold">Marketing</label>
                                    <select name="marketing_id" class="form-select" required>
                                        <option value="">-- Pilih Marketing --</option>
                                        @foreach($marketings as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap" id="tableDataMasuk" style="min-width: 1800px">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th style="width: 250px;">Perusahaan</th>
                                            <th style="width: 150px;">Nomor Telp</th>
                                            <th style="width: 200px;">Unit Bisnis</th>
                                            <th style="width: 200px;">Email</th>
                                            <th style="width: 150px;">Status Email</th>
                                            <th style="width: 150px;">WA PIC</th>
                                            <th style="width: 150px;">WA BARU (Manual)</th>
                                            <th style="width: 300px;">Lokasi</th>
                                            <th style="width: 150px;">Sumber</th>
                                            <th style="width: 50px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="rows[0][perusahaan]" class="form-control paste-input" placeholder="Paste Perusahaan di sini"></td>
                                            <td><input type="text" name="rows[0][telp]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][unit_bisnis]" class="form-control"></td>
                                            <td><input type="email" name="rows[0][email]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][status_email]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][wa_pic]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][wa_baru]" class="form-control" placeholder="Isi manual"></td>
                                            <td><input type="text" name="rows[0][lokasi]" class="form-control"></td>
                                            <td><input type="text" name="rows[0][sumber]" class="form-control"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="button" id="addRow" class="btn btn-secondary btn-sm">Tambah Baris Manual</button>
                                <button type="submit" class="btn btn-primary btn-sm float-end">Simpan Semua Data ke Database</button>
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
            <td><input type="text" name="rows[${index}][unit_bisnis]" class="form-control"></td>
            <td><input type="email" name="rows[${index}][email]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][status_email]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][wa_pic]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][wa_baru]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][lokasi]" class="form-control"></td>
            <td><input type="text" name="rows[${index}][sumber]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
        </tr>`;
    }

    $('#addRow').click(function() {
        $('#tableDataMasuk tbody').append(createRow(rowIdx++));
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
                $('#tableDataMasuk tbody').append(createRow(rowIdx++));
                currentRow = $('#tableDataMasuk tbody tr').last();
            }

            let inputs = currentRow.find('input');
            
            // Logika pemetaan kolom Excel (Asumsi urutan Excel: Perusahaan, Telp, Unit, Email, Status, WA, Lokasi, Sumber)
            // Indeks input: 0=Perus, 1=Telp, 2=Unit, 3=Email, 4=Status, 5=WA_PIC, 6=WA_BARU (kita lewati), 7=Lokasi, 8=Sumber
            let colMap = [0, 1, 2, 3, 4, 5, 7, 8]; 

            cols.forEach((val, j) => {
                let targetInputIdx = colMap[j];
                if (inputs.eq(targetInputIdx).length) {
                    inputs.eq(targetInputIdx).val(val.trim());
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
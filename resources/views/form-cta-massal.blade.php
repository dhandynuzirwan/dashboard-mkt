@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Massal Data CTA</h4>
                    <p class="text-muted">Klik pada kolom <b>Perusahaan</b>, lalu tekan <b>Ctrl + V</b> untuk copas 11 kolom sekaligus dari Excel.</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="bulkForm" action="{{ route('cta.store_massal') }}" method="POST">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" id="tableCTA" style="min-width: 2500px;">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th style="width: 200px;" class="bg-warning text-dark">Perusahaan (Pencocok)</th>
                                        <th style="width: 200px;" class="bg-warning text-dark">Lokasi (Pencocok)</th>
                                        
                                        <th style="width: 200px;" class="bg-info text-dark">Keterangan Akhir Data</th>
                                        
                                        <th style="width: 200px;">Judul Permintaan</th>
                                        <th style="width: 100px;">Jml Peserta</th>
                                        <th style="width: 150px;">Sertifikasi</th>
                                        <th style="width: 150px;">Skema</th>
                                        <th style="width: 150px;">Harga Penawaran</th>
                                        <th style="width: 150px;">Harga Vendor</th>
                                        <th style="width: 200px;">Link Proposal</th>
                                        <th style="width: 150px;">Status Penawaran</th>
                                        <th style="width: 250px;">Keterangan</th>
                                        <th style="width: 50px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="rows[0][perusahaan]" class="form-control paste-input" placeholder="Paste di sini"></td>
                                        <td><input type="text" name="rows[0][lokasi]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][catatan_prospek]" class="form-control"></td>
                                        
                                        <td><input type="text" name="rows[0][judul_permintaan]" class="form-control"></td>
                                        <td><input type="number" name="rows[0][jumlah_peserta]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][sertifikasi]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][skema]" class="form-control"></td>
                                        <td><input type="number" name="rows[0][harga_penawaran]" class="form-control"></td>
                                        <td><input type="number" name="rows[0][harga_vendor]" class="form-control"></td>
                                        <td><input type="url" name="rows[0][proposal_link]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][status_penawaran]" class="form-control"></td>
                                        <td><textarea name="rows[0][keterangan]" class="form-control" rows="1"></textarea></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" id="addRow" class="btn btn-secondary btn-sm">Tambah Baris Manual</button>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Simpan Semua CTA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let rowIdx = 1;
            
            // [Potongan Kode Script createRow di Blade]
            function createRow(index) {
                return `<tr>
                            <td><input type="text" name="rows[${index}][perusahaan]" class="form-control paste-input"></td>
                            <td><input type="text" name="rows[${index}][lokasi]" class="form-control"></td>
                            
                            <td><input type="text" name="rows[${index}][catatan_prospek]" class="form-control"></td>
                            
                            <td><input type="text" name="rows[${index}][judul_permintaan]" class="form-control"></td>
                            <td><input type="number" name="rows[${index}][jumlah_peserta]" class="form-control"></td>
                            <td><input type="text" name="rows[${index}][sertifikasi]" class="form-control"></td>
                            <td><input type="text" name="rows[${index}][skema]" class="form-control"></td>
                            <td><input type="number" name="rows[${index}][harga_penawaran]" class="form-control"></td>
                            <td><input type="number" name="rows[${index}][harga_vendor]" class="form-control"></td>
                            <td><input type="url" name="rows[${index}][proposal_link]" class="form-control"></td>
                            <td><input type="text" name="rows[${index}][status_penawaran]" class="form-control"></td>
                            <td><textarea name="rows[${index}][keterangan]" class="form-control" rows="1"></textarea></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                        </tr>`;
            }

            $('#addRow').click(function() {
                $('#tableCTA tbody').append(createRow(rowIdx++));
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
                        $('#tableCTA tbody').append(createRow(rowIdx++));
                        currentRow = $('#tableCTA tbody tr').last();
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
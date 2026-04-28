@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            {{-- Bagian Notifikasi (Pesan Duplikasi & Sukses) --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                    <i class="fas fa-exclamation-triangle me-1"></i> {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-round border-0 shadow-sm">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title fw-bold">Input Massal Data Masuk</h4>
                    <p class="text-muted small">
                        Klik pada kolom <b>Perusahaan</b>, lalu tekan <b>Ctrl + V</b> untuk copas dari Excel. <br>
                        <span class="text-primary fw-bold">Urutan Kolom Excel:</span> Perusahaan, Telp, Unit Bisnis, Email, Status Email, WA PIC, Lokasi, Sumber.
                    </p>
                </div>
                <div class="card-body">
                    <form id="bulkForm" action="{{ route('data-masuk.store') }}" method="POST">
                        @csrf

                        {{-- Logika Hak Akses Marketing Assignment --}}
                        @php $role = auth()->user()->role; @endphp

                        @if ($role == 'admin' || $role == 'superadmin')
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="fw-bold mb-2">Assign ke Marketing (Wajib bagi Admin)</label>
                                    <select name="marketing_id" class="form-select shadow-sm" required>
                                        <option value="">-- Pilih Marketing --</option>
                                        @foreach ($marketings as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            {{-- Tampilan untuk RnD / Digital Marketing --}}
                            <div class="row mb-4">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <div class="alert alert-light border-left-info shadow-sm py-3 m-0 h-100 d-flex align-items-center">
                                        <i class="fas fa-info-circle text-info fa-2x me-3"></i>
                                        <div>
                                            <span class="fw-bold d-block text-dark">Mode Input Terpusat</span>
                                            <span class="small text-muted">Data akan disimpan sebagai "Data Mentah". Admin operasional akan membagikannya ke Marketing nanti.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-2">Pilih Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_input" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" required>
                                    <small class="text-muted mt-1 d-block">Ubah jika data berasal dari hari sebelumnya.</small>
                                </div>
                            </div>
                            {{-- Input Hidden agar Controller tidak error --}}
                            <input type="hidden" name="marketing_id" value="">
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tableDataMasuk" style="min-width: 1800px">
                                <thead class="bg-light text-center small text-uppercase fw-bold">
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
                                    <tr class="table-row-input">
                                        <td><input type="text" name="rows[0][perusahaan]" class="form-control paste-input" placeholder="Paste di sini..." required></td>
                                        <td><input type="text" name="rows[0][telp]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][unit_bisnis]" class="form-control"></td>
                                        <td><input type="email" name="rows[0][email]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][status_email]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][wa_pic]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][wa_baru]" class="form-control" placeholder="Opsional"></td>
                                        <td><input type="text" name="rows[0][lokasi]" class="form-control"></td>
                                        <td><input type="text" name="rows[0][sumber]" class="form-control"></td>
                                        <td class="text-center"><button type="button" class="btn btn-link text-danger p-0 remove-row"><i class="fas fa-times"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pb-3">
                            <button type="button" id="addRow" class="btn btn-border btn-round btn-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Baris Manual
                            </button>
                            <button type="submit" class="btn btn-primary btn-round btn-sm float-end px-4">
                                <i class="fas fa-save me-1"></i> Simpan ke Database Pusat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <td class="text-center"><button type="button" class="btn btn-link text-danger p-0 remove-row"><i class="fas fa-times"></i></button></td>
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
                        // Mapping Excel ke Input (Melewati index 6: WA Baru)
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
@endsection
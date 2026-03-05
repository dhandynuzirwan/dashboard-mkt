@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
            <div>
                <h3 class="fw-bold mb-1">Master Judul Pelatihan</h3>
                <h6 class="op-7">Kelola database judul pelatihan perusahaan secara terpusat.</h6>
            </div>
        </div>

        {{-- BARIS 1: STATISTIK --}}
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Judul</p>
                                    <h4 class="card-title">{{ $totalTitles }}</h4>
                                    <p class="text-muted small">Pelatihan Tersimpan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- BARIS 2: FORM INPUT MASSAL (ATAS) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round shadow-sm">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-file-import me-2 text-primary"></i> Input Judul Massal
                        </div>
                        <p class="text-muted small mb-0">Klik pada kotak input, lalu *Paste (Ctrl+V)* 1 kolom judul dari Excel.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master-training.bulk_store') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableTraining">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Nama Judul Pelatihan</th>
                                            <th width="50" class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="trainings[0][nama_training]" 
                                                       class="form-control paste-input-training" 
                                                       placeholder="Paste daftar judul di sini..." required>
                                            </td>
                                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="button" id="addRowTraining" class="btn btn-border btn-round btn-sm">
                                    <i class="fas fa-plus me-1"></i> Tambah Baris Manual
                                </button>
                                <button type="submit" class="btn btn-primary btn-round btn-sm float-end">
                                    <i class="fas fa-save me-1"></i> Simpan Database
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS 3: TABEL DATA (BAWAH) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round shadow-sm">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Database Pelatihan</h4>
                            {{-- FITUR SEARCH --}}
                            <div class="ms-auto">
                                <form action="{{ route('master-training.index') }}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm" 
                                               placeholder="Cari judul..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('master-training.index') }}" class="btn btn-border btn-sm">Reset</a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th width="60" class="text-center">No</th>
                                        <th>Nama Pelatihan (A-Z)</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($trainings as $t)
                                    <tr>
                                        <td class="text-center">{{ ($trainings->currentPage()-1) * $trainings->perPage() + $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $t->nama_training }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('master-training.destroy', $t->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger p-0" 
                                                        onclick="return confirm('Hapus judul ini dari database?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-4">Data tidak ditemukan atau belum ada.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $trainings->links('partials.pagination') }}
                        </div>
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
    let trainingIdx = 1;

    // Fungsi tambah baris manual
    $('#addRowTraining').click(function() {
        $('#tableTraining tbody').append(`
            <tr>
                <td><input type="text" name="trainings[${trainingIdx}][nama_training]" class="form-control paste-input-training"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
            </tr>
        `);
        trainingIdx++;
    });

    // Fitur Paste Massal dari Excel (Satu Kolom)
    $(document).on('paste', '.paste-input-training', function(e) {
        e.preventDefault();
        let cbData = (e.originalEvent || e).clipboardData.getData('text');
        let lines = cbData.split(/\r?\n/);
        let currentRow = $(this).closest('tr');

        lines.forEach((line) => {
            if (line.trim() === '') return;

            if (currentRow.length === 0) {
                $('#addRowTraining').click();
                currentRow = $('#tableTraining tbody tr').last();
            }

            currentRow.find('input').val(line.trim());
            currentRow = currentRow.next();
        });
    });

    // Hapus baris
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });
});
</script>
@endpush
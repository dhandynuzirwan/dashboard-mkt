@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Cek Sinkronisasi Data Prospek</h3>
        
        <div class="row">
            <div class="col-md-5">
                {{-- Tambahkan rounded-4 dan shadow-sm --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="card-title text-white mb-0"><i class="fas fa-edit me-2"></i>Input Nama Perusahaan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('prospek.processCheck') }}" method="POST">
                            @csrf
                            <div class="form-group px-0">
                                <label class="fw-bold">Pilih Tanggal Prospek di Sistem</label>
                                <input type="date" name="check_date" class="form-control rounded-3" value="{{ $checkedDate ?? date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group px-0">
                                <label class="fw-bold">Paste Nama-Nama Perusahaan</label>
                                <textarea name="names" class="form-control rounded-4" rows="12" style="resize: none;" placeholder="Contoh:&#10;PT Maju Jaya&#10;CV Sumber Makmur">{{ $oldInput ?? '' }}</textarea>
                                <small class="text-muted mt-2 d-block">* Pisahkan satu nama per baris (Enter)</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3 btn-round shadow-sm">
                                <i class="fas fa-sync-alt me-1"></i> Mulai Cek Selisih
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                @if(isset($missingInSystem))
                <div class="row">
                    {{-- HASIL A: TIDAK ADA DI SISTEM --}}
                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center py-3">
                                <span class="fw-bold"><i class="fas fa-exclamation-circle me-2"></i>Tidak Ada di Sistem</span>
                                <span class="badge bg-white text-danger rounded-pill px-3">{{ $missingInSystem->count() }} Data</span>
                            </div>
                            <div class="card-body p-0"> {{-- P-0 agar tabel nempel ke pinggir card yang rounded --}}
                                <div class="table-responsive" style="max-height: 300px;">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Nama Perusahaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($missingInSystem->isEmpty())
                                                <tr>
                                                    <td class="text-center py-4 text-success fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Semua nama sudah ada di sistem!
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($missingInSystem as $name)
                                                <tr>
                                                    <td class="ps-4"><span class="badge bg-danger-gradient me-2" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></span>{{ $name }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HASIL B: ADA DI SISTEM TAPI GAK ADA DI COPAS --}}
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center py-3">
                                <span class="fw-bold"><i class="fas fa-search me-2"></i>Hanya Ada di Sistem</span>
                                <span class="badge bg-dark text-white rounded-pill px-3">{{ $missingInInput->count() }} Data</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 300px;">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light text-dark">
                                            <tr>
                                                <th class="ps-4">Nama Perusahaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($missingInInput->isEmpty())
                                                <tr>
                                                    <td class="text-center py-4 text-success fw-bold">
                                                        <i class="fas fa-check-circle me-1"></i> Data sistem cocok dengan list!
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($missingInInput as $name)
                                                <tr>
                                                    <td class="ps-4"><span class="badge bg-warning me-2" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></span>{{ $name }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <img src="https://illustrations.popsy.co/blue/searching.svg" alt="Search" style="width: 150px;" class="mb-3">
                        <h5 class="fw-bold">Belum Ada Perbandingan</h5>
                        <p class="text-muted px-md-5">Silakan masukkan daftar nama perusahaan dan pilih tanggal untuk mulai melakukan rekonsiliasi data.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom style untuk efek rounded yang lebih halus */
    .rounded-4 { border-radius: 1rem !important; }
    
    .table thead th {
        border-top: none !important;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .list-group-item:first-child { border-top-left-radius: 0; border-top-right-radius: 0; }
    
    .bg-danger-gradient {
        background: linear-gradient(to right, #ff4d4d, #ff0000);
    }

    /* Hilangkan border terakhir tabel agar tidak merusak rounded card */
    .table tr:last-child td {
        border-bottom: none;
    }
</style>
@endsection
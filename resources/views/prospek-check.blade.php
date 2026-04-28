@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Cek Sinkronisasi Prospek</h3>
                <h6 class="text-muted mb-2 fw-normal">Rekonsiliasi Data Spreadsheet vs Database Sistem</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2 flex-wrap">
                <a href="{{ route('prospek.index') }}" class="btn btn-white border btn-round fw-bold text-dark shadow-sm hover-lift">
                    <i class="fas fa-arrow-left me-1 text-muted"></i> Kembali ke Pipeline
                </a>
            </div>
        </div>
        
        <div class="row fade-in">
            {{-- BAGIAN KIRI: FORM INPUT MASSAL --}}
            <div class="col-md-5 mb-4">
                <div class="card card-modern border-0 shadow-sm sticky-top" style="top: 80px; z-index: 10;">
                    <div class="card-header bg-primary-subtle border-bottom-0 pt-4 px-4 pb-3">
                        <h6 class="card-title text-primary fw-bolder mb-0"><i class="fas fa-file-excel me-2"></i>Paste Data dari Spreadsheet</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('prospek.processCheckMassal') }}" method="POST">
                            @csrf
                            
                            <div class="alert alert-modern-info border-0 small mb-4">
                                <i class="fas fa-info-circle me-1 fw-bold"></i> Buka Spreadsheet Anda, blok 2 kolom ini sekaligus: <br><b>1. Tanggal</b> dan <b>2. Nama Perusahaan</b>.<br>Lalu <i>Paste</i> di kotak bawah ini.
                                <hr class="my-2 border-info opacity-25">
                                <span class="text-muted" style="font-size: 11px;">Sistem otomatis hanya akan mencocokkan rentang tanggal yang Anda paste.</span>
                            </div>

                            <div class="form-group px-0">
                                <label class="label-modern mb-2">Area Paste Data <span class="text-danger">*</span></label>
                                <textarea name="data_excel" class="form-control input-modern text-nowrap p-3" rows="14" style="resize: none; overflow-x: auto; font-family: monospace; font-size: 12px; background-color: #f8fafc;" placeholder="Contoh Paste:&#10;2026-04-05    PT Maju Jaya&#10;2026-04-05    CV Sumber Makmur&#10;2026-04-06    PT Mencari Cinta Sejati" required>{{ $oldInput ?? '' }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-4 btn-round fw-bold shadow-sm hover-lift py-2">
                                <i class="fas fa-sync-alt me-2"></i> Mulai Rekonsiliasi Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- BAGIAN KANAN: HASIL PENGECEKAN --}}
            <div class="col-md-7">
                @if(isset($missingInSystemGrouped))
                    
                    {{-- HEADER SUMMARY --}}
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <h5 class="fw-bolder mb-1 text-dark">Hasil Rekonsiliasi</h5>
                                <small class="text-muted">Menganalisis <b>{{ $jumlahTanggalUnik }}</b> tanggal berbeda.</small>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <div class="badge bg-light text-dark border px-3 py-2 shadow-sm rounded-pill fw-medium" style="font-size: 11px;">
                                    <i class="fas fa-database me-1 text-primary"></i> Target DB: <b>{{ $totalDb }}</b> <span class="text-muted mx-2">|</span> <i class="fas fa-file-excel me-1 text-success"></i> Excel: <b>{{ $totalInput }}</b>
                                </div>
                                @if($totalMissingInSystem > 0 || $totalMissingInInput > 0)
                                    <button onclick="exportToExcel()" class="btn btn-success btn-sm btn-round shadow-sm fw-bold hover-lift">
                                        <i class="fas fa-download me-1"></i> Export Selisih
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- SCRIPT EXPORT (Hidden) --}}
                    @push('scripts')
                    <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
                    <script>
                    function exportToExcel() {
                        const dataKurang = @json($missingInSystemGrouped ?? []);
                        const dataLebih = @json($missingInInputGrouped ?? []);
                    
                        const workbook = XLSX.utils.book_new();
                        
                        if (Object.keys(dataKurang).length > 0) {
                            let rowsKurang = [["Tanggal", "Nama Perusahaan", "Keterangan"]];
                            Object.keys(dataKurang).forEach(tgl => {
                                dataKurang[tgl].forEach(item => { rowsKurang.push([tgl, item.perusahaan, "Belum ada di Sistem"]); });
                            });
                            const wsKurang = XLSX.utils.aoa_to_sheet(rowsKurang);
                            XLSX.utils.book_append_sheet(workbook, wsKurang, "Data Kurang di Sistem");
                        }
                    
                        if (Object.keys(dataLebih).length > 0) {
                            let rowsLebih = [["Tanggal", "Nama Perusahaan", "Marketing", "Keterangan"]];
                            Object.keys(dataLebih).forEach(tgl => {
                                dataLebih[tgl].forEach(item => { rowsLebih.push([tgl, item.perusahaan, item.marketing, "Hanya ada di Sistem"]); });
                            });
                            const wsLebih = XLSX.utils.aoa_to_sheet(rowsLebih);
                            XLSX.utils.book_append_sheet(workbook, wsLebih, "Data Berlebih di Sistem");
                        }
                    
                        const fileName = `Rekonsiliasi_Prospek_${new Date().toISOString().slice(0,10)}.xlsx`;
                        XLSX.writeFile(workbook, fileName);
                    }
                    </script>
                    @endpush

                    {{-- ================= SECTION A: DATA KURANG DI SISTEM ================= --}}
                    @if($totalMissingInSystem > 0)
                        <div class="alert alert-modern-danger mb-4 border-0">
                            <h6 class="fw-bolder mb-1 text-danger"><i class="fas fa-exclamation-circle me-2"></i>Data Belum Diinput (Kurang di Sistem)</h6>
                            <p class="mb-0 small text-dark opacity-75">Ditemukan <b>{{ $totalMissingInSystem }}</b> data di Excel yang belum dimasukkan ke sistem pada tanggal tersebut.</p>
                        </div>

                        <div class="row mb-5" style="max-height: 600px; overflow-y: auto; overflow-x: hidden; padding-right: 5px;">
                            @foreach($missingInSystemGrouped as $tanggal => $items)
                                <div class="col-md-12 mb-3">
                                    <div class="card card-modern border-0 shadow-sm overflow-hidden">
                                        <div class="card-header bg-danger-subtle border-bottom-0 d-flex justify-content-between align-items-center py-3 px-4">
                                            <span class="fw-bolder fs-6 text-danger">
                                                <i class="far fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                                            </span>
                                            <span class="badge bg-danger rounded-pill px-3">{{ count($items) }} Tertinggal</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-modern table-hover mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th width="10%" class="text-center">No</th>
                                                            <th width="50%">Nama Perusahaan (Dari Excel)</th>
                                                            <th width="40%">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $index => $item)
                                                        <tr>
                                                            <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                                                            <td class="fw-bolder text-dark">{{ $item['perusahaan'] }}</td>
                                                            <td><span class="badge badge-soft-danger border border-danger"><i class="fas fa-times me-1"></i> Tidak Ditemukan</span></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-modern-success mb-4 border-0">
                            <h6 class="fw-bolder mb-0 text-success"><i class="fas fa-check-circle me-2"></i>Aman! Tidak ada data yang tertinggal untuk diinput.</h6>
                        </div>
                    @endif

                    @if($totalMissingInSystem > 0 && $totalMissingInInput > 0)
                        <hr class="my-4 border-secondary opacity-10">
                    @endif

                    {{-- ================= SECTION B: DATA LEBIH DI SISTEM ================= --}}
                    @if($totalMissingInInput > 0)
                        <div class="alert alert-modern-warning mb-4 border-0">
                            <h6 class="fw-bolder mb-1 text-warning-dark"><i class="fas fa-question-circle me-2"></i>Data Berlebih (Siluman di Sistem)</h6>
                            <p class="mb-0 small text-dark opacity-75">Ditemukan <b>{{ $totalMissingInInput }}</b> data asing di sistem yang tidak tercantum di Excel Anda.</p>
                        </div>

                        <div class="row" style="max-height: 600px; overflow-y: auto; overflow-x: hidden; padding-right: 5px;">
                            @foreach($missingInInputGrouped as $tanggal => $items)
                                <div class="col-md-12 mb-3">
                                    <div class="card card-modern border-0 shadow-sm overflow-hidden">
                                        <div class="card-header bg-warning-subtle border-bottom-0 d-flex justify-content-between align-items-center py-3 px-4">
                                            <span class="fw-bolder fs-6 text-warning-dark">
                                                <i class="far fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                                            </span>
                                            <span class="badge bg-warning text-dark rounded-pill px-3">{{ count($items) }} Siluman</span>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-modern table-hover mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th width="10%" class="text-center">No</th>
                                                            <th width="50%">Perusahaan (Di Sistem)</th>
                                                            <th width="40%">Marketing PIC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $index => $item)
                                                        <tr>
                                                            <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                                                            <td class="fw-bolder text-dark">{{ $item['perusahaan'] }}</td>
                                                            <td>
                                                                <span class="badge badge-soft-info border border-info">
                                                                    <i class="fas fa-user-tie me-1"></i> {{ $item['marketing'] }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif(isset($missingInSystemGrouped) && $totalMissingInInput == 0 && $totalMissingInSystem > 0)
                        <div class="alert alert-modern-success mb-4 border-0">
                            <h6 class="fw-bolder mb-0 text-success"><i class="fas fa-check-circle me-2"></i>Aman! Tidak ada data siluman/berlebih di sistem.</h6>
                        </div>
                    @endif

                    {{-- JIKA BENAR-BENAR SINKRON 100% KEDUA SISI --}}
                    @if($totalMissingInSystem == 0 && $totalMissingInInput == 0)
                        <div class="card card-modern border-0 shadow-sm mt-4 bg-success-subtle text-center py-5 hover-lift">
                            <div class="card-body">
                                <div class="icon-modern bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 35px;">
                                    <i class="fas fa-shield-check"></i>
                                </div>
                                <h4 class="fw-bolder text-success mb-2">Sinkronisasi Sempurna!</h4>
                                <p class="text-dark opacity-75 mb-0">Data di Spreadsheet dan Sistem Anda 100% cocok pada rentang waktu tersebut.</p>
                            </div>
                        </div>
                    @endif

                @else
                    {{-- TAMPILAN AWAL SEBELUM CEK --}}
                    <div class="card card-modern border-0 shadow-sm h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-5">
                            <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                                <i class="fas fa-search text-primary" style="font-size: 50px;"></i>
                            </div>
                            <h4 class="fw-bolder text-dark mb-2">Belum Ada Perbandingan</h4>
                            <p class="text-muted px-md-5 mb-0" style="max-width: 400px; line-height: 1.6;">Silakan paste data kolom <b>Tanggal & Perusahaan</b> dari Excel Anda ke kotak di sebelah kiri untuk mendeteksi anomali data.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS MODERNISASI UI */
    .card-modern {
        border-radius: 16px;
        border: 1px solid #eef2f7;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .text-warning-dark { color: #b45309 !important; }

    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }

    /* Alert Modern */
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-danger { background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-warning { background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-info { background-color: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

    /* Table Modern */
    .table-modern th {
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 16px;
    }
    .table-modern td {
        border-bottom: 1px solid #f1f5f9;
        padding: 14px 16px;
    }

    /* Form Modern */
    .label-modern {
        font-weight: 700;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .input-modern {
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        color: #334155;
    }
    .input-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    /* Animations & Scrollbar */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection
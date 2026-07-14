@extends('layouts.app')
@section('title', 'Master Instruktur / Narasumber')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Master Instruktur / Narasumber</h3>
                <h6 class="text-muted mb-2 fw-normal">Database Instruktur dan Narasumber</h6>
            </div>
        </div>

        {{-- 3 STAT CARDS SEJAJAR --}}
        <div class="row mb-3 fade-in">
            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Instruktur</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalStat }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata Rate/Fee</p>
                            <h4 class="fw-bolder text-dark mb-0 lh-1">Rp {{ number_format($avgRate, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-info-subtle text-info me-3">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div style="min-width: 0;">
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Bidang Ahli Terbanyak</p>
                            <h4 class="fw-bolder text-dark mb-0 lh-1 text-truncate" title="{{ $bidangTop }}">{{ $bidangTop }} <span class="badge badge-soft-info" style="font-size: 10px;">{{ $bidangTopCount }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK --}}
        <div class="row mb-3 fade-in">
            <div class="col-md-8 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-header border-0 bg-transparent pb-0">
                        <div class="card-title fw-bold text-dark" style="font-size: 15px;">Statistik Input Instruktur per Bulan (Tahun Ini)</div>
                    </div>
                    <div class="card-body pt-2">
                        @if(array_sum($chartValues) > 0)
                            <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100" style="min-height: 250px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-bar mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mb-0">Belum ada data statistik untuk tahun ini.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-modern hover-lift h-100">
                    <div class="card-header border-0 bg-transparent pb-0">
                        <div class="card-title fw-bold text-dark" style="font-size: 15px;">Komposisi Bidang Ahli</div>
                    </div>
                    <div class="card-body pt-2 d-flex justify-content-center align-items-center">
                        @if(count($bidangValues) > 0)
                            <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
                                <canvas id="kategoriChart"></canvas>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100" style="min-height: 250px; width: 100%;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-chart-pie mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mb-0">Belum ada data komposisi bidang ahli.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- FILTER SECTION --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-modern mb-4 fade-in">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                            <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-filter" style="font-size: 13px;"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Data</h6>
                        </div>
                        <form method="GET" action="{{ route('master-instruktur.index') }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="label-modern">Cari Nama/Wilayah</label>
                                    <input type="text" class="form-control form-control-sm input-modern" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau wilayah...">
                                </div>
                                <div class="col-md-4">
                                    <label class="label-modern">Bidang Ahli</label>
                                    <select class="form-select form-select-sm input-modern" name="bidang_ahli">
                                        <option value="">Semua Bidang</option>
                                        @foreach($listBidang as $bidang)
                                            <option value="{{ $bidang }}" {{ request('bidang_ahli') == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="label-modern">Rentang Tanggal Input</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control form-control-sm input-modern" name="start_date" value="{{ request('start_date') }}">
                                        <span class="mx-2 mt-2">-</span>
                                        <input type="date" class="form-control form-control-sm input-modern" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift shadow-sm">
                                        <i class="fas fa-search me-1"></i> Terapkan Filter
                                    </button>
                                    <a href="{{ route('master-instruktur.index') }}" class="btn btn-white btn-sm btn-round fw-bold border px-4 hover-lift text-dark ms-2">
                                        <i class="fas fa-sync-alt me-1 text-muted"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 fade-in">
                    <button class="btn btn-primary btn-sm btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus me-1"></i> Tambah Instruktur Baru
                    </button>
                </div>
                <div class="card card-modern fade-in border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Profil Instruktur</th>
                                        <th style="width: 20%">Bidang & Berkas</th>
                                        <th style="width: 20%">Info Rate & Rekening</th>
                                        <th style="width: 15%">Penginput</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($instrukturs as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $instrukturs->firstItem() - 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark fs-6">{{ $item->nama_instruktur }}</div>
                                            <div class="text-muted" style="font-size: 12px;"><i class="fas fa-building me-1"></i> {{ $item->wilayah_instansi }}</div>
                                            <div class="text-muted" style="font-size: 12px;"><i class="fas fa-phone-alt me-1"></i> {{ $item->no_telepon }}</div>
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                @foreach(array_map('trim', explode(',', $item->bidang_ahli)) as $bidang)
                                                    @if(!empty($bidang))
                                                        <span class="badge badge-soft-primary me-1 mb-1">{{ $bidang }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if($item->link_cv)
                                                <a href="{{ $item->link_cv }}" target="_blank" class="btn btn-xs btn-outline-info rounded-pill hover-lift shadow-sm"><i class="fas fa-link me-1"></i> Buka CV</a>
                                            @else
                                                <span class="text-muted" style="font-size: 11px;">(Tidak ada CV)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold text-success mb-1">Rp {{ number_format($item->rate_harga, 0, ',', '.') }}</div>
                                            <div class="text-muted" style="font-size: 12px;">
                                                <i class="fas fa-university me-1"></i> {{ $item->bank }} - <strong>{{ $item->no_rek }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark" style="font-size: 13px;">{{ !empty($item->user->nama_lengkap) ? $item->user->nama_lengkap : $item->user->name }}</div>
                                            <div class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-sm btn-primary text-white rounded-pill hover-lift shadow-sm px-3">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('master-instruktur.destroy', $item->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Yakin ingin menghapus instruktur ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white rounded-pill hover-lift shadow-sm px-3">
                                                        <i class="fa fa-trash-alt me-1"></i> Hapus
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
                                                                <label class="label-modern">Nama Instruktur <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="nama_instruktur" value="{{ $item->nama_instruktur }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Wilayah/Instansi</label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="wilayah_instansi" value="{{ $item->wilayah_instansi }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Nomor Telepon <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="no_telepon" value="{{ $item->no_telepon }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Bidang Ahli <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="bidang_ahli" value="{{ $item->bidang_ahli }}" placeholder="Pisahkan dengan koma jika lebih dari 1" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Rate Harga (Rp)</label>
                                                                <input type="text" class="form-control form-control-sm input-modern input-currency" name="rate_harga_display" value="{{ number_format($item->rate_harga, 0, ',', '.') }}">
                                                                <input type="hidden" name="rate_harga" class="input-currency-hidden" value="{{ $item->rate_harga }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Nama Bank</label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="bank" value="{{ $item->bank }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">No Rekening</label>
                                                                <input type="text" class="form-control form-control-sm input-modern" name="no_rek" value="{{ $item->no_rek }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="label-modern">Link CV (Opsional)</label>
                                                                <input type="url" class="form-control form-control-sm input-modern" name="link_cv" value="{{ $item->link_cv }}">
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

                            <div class="mt-4 px-3">
                                {{ $instrukturs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
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
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info py-2" style="font-size: 12px;">
                                <i class="fas fa-lightbulb me-1"></i> <strong>Tips:</strong> Anda dapat men-copy 1 baris dari Excel (Nama, Instansi, Telp, Bidang, Rate, Bank, Rekening, Link CV) lalu <strong>Paste</strong> pada kolom "Nama Instruktur" di bawah untuk mengisi formulir secara otomatis.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Nama Instruktur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm input-modern" name="nama_instruktur" id="nama_instruktur_add" placeholder="Paste data Excel di sini..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Wilayah/Instansi</label>
                            <input type="text" class="form-control form-control-sm input-modern" name="wilayah_instansi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm input-modern" name="no_telepon" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Bidang Ahli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm input-modern" name="bidang_ahli" placeholder="Pisahkan dengan koma jika lebih dari 1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Rate Harga (Rp)</label>
                            <input type="text" class="form-control form-control-sm input-modern input-currency" name="rate_harga_display">
                            <input type="hidden" name="rate_harga" class="input-currency-hidden">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Nama Bank</label>
                            <input type="text" class="form-control form-control-sm input-modern" name="bank">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">No Rekening</label>
                            <input type="text" class="form-control form-control-sm input-modern" name="no_rek">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label-modern">Link CV (Opsional)</label>
                            <input type="url" class="form-control form-control-sm input-modern" name="link_cv">
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

<style>
    /* CSS MODERNISASI UI (Sama seperti Master Artikel) */
    .card-modern { border-radius: 16px; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: #ffffff; transition: all 0.3s ease; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    
    .icon-modern { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    .bg-primary-subtle { background-color: #e0eaff !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-warning-subtle { background-color: #fef08a !important; }
    
    .badge-soft-primary { background-color: #e0eaff; color: #3b82f6; }
    .badge-soft-success { background-color: #dcfce7; color: #16a34a; }
    .badge-soft-warning { background-color: #fef08a; color: #b45309; }
    .badge-soft-info { background-color: #cff4fc; color: #0891b2; }
    
    /* Table Modern */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0 !important; padding: 12px 16px; }
    .table-modern td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; }
    
    /* Form Modern */
    .label-modern { font-weight: 700; color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 10px; color: #334155; }
    .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important; }
    
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Currency Auto Formatting
        $('.input-currency').on('keyup', function(e) {
            let val = $(this).val();
            val = val.replace(/[^,\d]/g, '').toString();
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

        // ==========================================
        // AUTOFILL PASTE EXCEL PADA MODAL TAMBAH
        // ==========================================
        $('#nama_instruktur_add').on('paste', function(e) {
            var clipboardData = e.originalEvent.clipboardData || window.clipboardData;
            var pastedData = clipboardData.getData('Text');
            
            // Periksa jika mengandung tab (ciri khas copy dari Excel)
            if (pastedData.indexOf('\t') !== -1) {
                e.preventDefault(); 
                
                // Pisahkan string berdasarkan tab
                var columns = pastedData.trim().split('\t');
                
                if (columns.length > 0) $(this).val(columns[0].trim());
                if (columns.length > 1) $('#tambahModal [name="wilayah_instansi"]').val(columns[1].trim());
                if (columns.length > 2) $('#tambahModal [name="no_telepon"]').val(columns[2].trim());
                if (columns.length > 3) $('#tambahModal [name="bidang_ahli"]').val(columns[3].trim());
                if (columns.length > 4) {
                    var rate = columns[4].trim().replace(/[^0-9]/g, ''); // Ambil angkanya saja
                    var rateInput = $('#tambahModal [name="rate_harga_display"]');
                    rateInput.val(rate);
                    rateInput.trigger('keyup'); // Memicu format mata uang dan hidden value
                }
                if (columns.length > 5) $('#tambahModal [name="bank"]').val(columns[5].trim());
                if (columns.length > 6) $('#tambahModal [name="no_rek"]').val(columns[6].trim());
                if (columns.length > 7) $('#tambahModal [name="link_cv"]').val(columns[7].trim());
                
                // Notifikasi ringan (Opsional, jika ada library notify)
                console.log("Data berhasil diparsing dari Excel");
            }
        });

        // CHARTS
        var elStat = document.getElementById('statisticsChart');
        if (elStat) {
            var ctx = elStat.getContext('2d');
            var statisticsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: "Jumlah Instruktur Baru",
                        backgroundColor: '#1d7af3',
                        borderColor: '#1d7af3',
                        data: {{ json_encode($chartValues) }},
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }],
                        xAxes: [{
                            gridLines: { display: false }
                        }]
                    }
                }
            });
        }

        var elKategori = document.getElementById('kategoriChart');
        if (elKategori) {
            var ctxKategori = elKategori.getContext('2d');
            var kategoriChart = new Chart(ctxKategori, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($bidangLabels) !!},
                    datasets: [{
                        data: {!! json_encode($bidangValues) !!},
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#64748b'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20,
                            fontSize: 11
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

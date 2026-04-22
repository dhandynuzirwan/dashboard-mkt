@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER & ACTIONS ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 fade-in">
            <div>
                <h3 class="fw-bold mb-1">Data Aset & Inventaris</h3>
                <h6 class="op-7 mb-0">Manajemen pencatatan aset tetap dan stok barang operasional (habis pakai)</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2">
                <button class="btn btn-success btn-round fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Data
                </button>
            </div>
        </div>

        {{-- ================= ALERT NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-4 border-success bg-white fade-in" role="alert">
                <i class="fas fa-check-circle me-2 text-success fs-5 align-middle"></i> 
                <span class="fw-bold text-success">Berhasil!</span> <span class="text-dark">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-4 border-danger bg-white fade-in" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-triangle me-2 text-danger fs-5"></i> 
                    <span class="fw-bold text-danger">Terjadi Kesalahan!</span>
                </div>
                <ul class="mb-0 text-dark ps-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= STATISTIC CARDS ================= --}}
        <div class="row fade-in">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-boxes"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Aset Tetap</p>
                                    <h4 class="card-title">{{ number_format($stats['total_aset']) }}</h4>
                                    <p class="text-muted small mb-0 mt-1">Unit terdaftar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Jenis Persediaan</p>
                                    <h4 class="card-title">{{ number_format($stats['jenis_item']) }}</h4>
                                    <p class="text-success small mb-0 mt-1 fw-bold">Item habis pakai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4" style="border-bottom: 3px solid #fad714 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small bg-warning-gradient text-white">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Stok Menipis</p>
                                    <h4 class="card-title text-warning fs-5">{{ $stats['stok_menipis'] }} Item</h4>
                                    <p class="text-warning small mb-0 mt-1 fw-bold">Segera restock!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm card-animate mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Aset Rusak/Servis</p>
                                    <h4 class="card-title">{{ $stats['aset_rusak'] }}</h4>
                                    <p class="text-danger small mb-0 mt-1 fw-bold">Perlu perbaikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABS NAVIGASI ================= --}}
        <ul class="nav nav-pills nav-secondary bg-white p-1 rounded border shadow-sm d-inline-flex mb-4 fade-in" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active fw-bold" id="pills-aset-tab" data-bs-toggle="pill" href="#pills-aset" role="tab" aria-selected="true">
                    <i class="fas fa-laptop me-1"></i> Aset Tetap
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-bold" id="pills-persediaan-tab" data-bs-toggle="pill" href="#pills-persediaan" role="tab" aria-selected="false">
                    <i class="fas fa-box-open me-1"></i> Barang Persediaan
                </a>
            </li>
        </ul>

        <div class="tab-content fade-in" id="pills-tabContent">
            
            {{-- ================= TAB 1: ASET TETAP ================= --}}
            <div class="tab-pane fade show active" id="pills-aset" role="tabpanel" aria-labelledby="pills-aset-tab">
                
                <div class="card card-round border-0 shadow-sm mb-4">
                    <div class="card-body p-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <form action="{{ route('operational.inventaris') }}" method="GET" class="d-flex gap-2 flex-grow-1 align-items-end">
                            <div style="min-width: 250px;">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari Kode/Nama Aset..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold">Filter</button>
                            <a href="{{ route('operational.inventaris') }}" class="btn btn-light border btn-sm btn-round fw-bold">Reset</a>
                        </form>
                        <button class="btn btn-secondary btn-round btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAset">
                            <i class="fas fa-plus me-1"></i> Tambah Aset Tetap
                        </button>
                    </div>
                </div>

                <div class="card card-round border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th class="text-start ps-4">Kode Aset</th>
                                        <th>Nama Aset & Kategori</th>
                                        <th>Lokasi / PIC</th>
                                        <th>Status</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($asets as $aset)
                                        <tr>
                                            <td class="text-start ps-4"><span class="badge badge-black bg-dark">{{ $aset->kode }}</span></td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $aset->nama }}</div>
                                                <small class="text-muted">{{ $aset->kategori }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $aset->lokasi }}</div>
                                                <small class="text-muted">PIC: {{ $aset->pic ?? '-' }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $kondisiClass = 'badge-success'; // Default Baik
                                                    if(str_contains(strtolower($aset->kondisi), 'rusak')) $kondisiClass = 'badge-danger';
                                                    if(str_contains(strtolower($aset->kondisi), 'bekas')) $kondisiClass = 'badge-warning';
                                                @endphp
                                                <span class="badge {{ $kondisiClass }} px-3 py-1 rounded-pill">{{ $aset->kondisi }}</span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <button class="btn btn-warning btn-sm fw-bold text-white shadow-sm" style="border-radius: 6px;" title="Edit Data">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data aset tetap.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TAB 2: BARANG PERSEDIAAN ================= --}}
            <div class="tab-pane fade" id="pills-persediaan" role="tabpanel" aria-labelledby="pills-persediaan-tab">
                
                <div class="card card-round border-0 shadow-sm mb-4">
                    <div class="card-body p-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <form action="{{ route('operational.inventaris') }}" method="GET" class="d-flex gap-2 flex-grow-1 align-items-end">
                            <div style="min-width: 250px;">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search_stok" class="form-control" placeholder="Cari Nama Barang..." value="{{ request('search_stok') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold">Filter</button>
                            <a href="{{ route('operational.inventaris') }}" class="btn btn-light border btn-sm btn-round fw-bold">Reset</a>
                        </form>
                        <button class="btn btn-success btn-round btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPersediaan">
                            <i class="fas fa-plus me-1"></i> Tambah Barang Baru
                        </button>
                    </div>
                </div>

                <div class="card card-round border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-center">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th class="text-start ps-4">Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Sisa Stok</th>
                                        <th>Satuan</th>
                                        <th>Status Stok</th>
                                        <th class="text-center pe-4">Logistik (Mutasi)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td class="text-start ps-4 fw-bold text-dark">{{ $item->nama }}</td>
                                            <td class="text-muted small">{{ $item->kategori }}</td>
                                            <td>
                                                <h4 class="mb-0 fw-bold {{ $item->stok <= $item->min_stok ? 'text-danger' : 'text-primary' }}">
                                                    {{ number_format($item->stok) }}
                                                </h4>
                                            </td>
                                            <td class="text-muted">{{ $item->satuan }}</td>
                                            <td>
                                                @if($item->stok <= $item->min_stok)
                                                    <span class="badge badge-danger px-3 py-1 rounded-pill animate-pulse" title="Batas Minimal: {{ $item->min_stok }}">Menipis</span>
                                                @else
                                                    <span class="badge badge-success px-3 py-1 rounded-pill" title="Batas Minimal: {{ $item->min_stok }}">Aman</span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                {{-- Tombol Mutasi In & Out memanggil modal berdasarkan ID Item --}}
                                                <button class="btn btn-sm btn-primary btn-round fw-bold me-1" data-bs-toggle="modal" data-bs-target="#modalMutasi{{ $item->id }}In" title="Tambah Stok (Restock)"><i class="fas fa-arrow-down me-1"></i> In</button>
                                                <button class="btn btn-sm btn-warning btn-round fw-bold text-white" data-bs-toggle="modal" data-bs-target="#modalMutasi{{ $item->id }}Out" title="Kurangi Stok (Pemakaian)"><i class="fas fa-arrow-up me-1"></i> Out</button>
                                            </td>
                                        </tr>

                                        {{-- MODAL MUTASI IN (MASUK) --}}
                                        <div class="modal fade" id="modalMutasi{{ $item->id }}In" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content card-round border-0 shadow-lg">
                                                    <div class="modal-header border-bottom-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-primary">
                                                            <i class="fas fa-arrow-down me-2"></i> Tambah Stok (Barang Masuk)
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('inventaris.mutasi', $item->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="tipe" value="in">
                                                        <div class="modal-body pt-4">
                                                            <p class="mb-3 text-muted">Tambah stok untuk: <strong class="text-dark">{{ $item->nama }}</strong></p>
                                                            <div class="form-group px-0">
                                                                <label class="fw-bold mb-2">Jumlah Masuk (<span class="text-lowercase">{{ $item->satuan }}</span>) <span class="text-danger">*</span></label>
                                                                <input type="number" name="qty" class="form-control" min="1" required placeholder="0">
                                                            </div>
                                                            <div class="form-group px-0 m-0">
                                                                <label class="fw-bold mb-2">Keterangan / Sumber Beli <span class="text-muted fw-normal">(Opsional)</span></label>
                                                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pembelian dari Toko ABC"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 pt-4">
                                                            <button type="button" class="btn btn-light btn-round border" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary btn-round fw-bold">Simpan Stok Masuk</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- MODAL MUTASI OUT (KELUAR) --}}
                                        <div class="modal fade" id="modalMutasi{{ $item->id }}Out" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content card-round border-0 shadow-lg">
                                                    <div class="modal-header border-bottom-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-warning">
                                                            <i class="fas fa-arrow-up me-2 text-warning"></i> Keluarkan Stok (Pemakaian)
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('inventaris.mutasi', $item->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="tipe" value="out">
                                                        <div class="modal-body pt-4">
                                                            <p class="mb-3 text-muted">Kurangi stok untuk: <strong class="text-dark">{{ $item->nama }}</strong> <br><small>Sisa stok saat ini: {{ $item->stok }} {{ $item->satuan }}</small></p>
                                                            <div class="form-group px-0">
                                                                <label class="fw-bold mb-2">Jumlah Keluar (<span class="text-lowercase">{{ $item->satuan }}</span>) <span class="text-danger">*</span></label>
                                                                <input type="number" name="qty" class="form-control" min="1" max="{{ $item->stok }}" required placeholder="0">
                                                            </div>
                                                            <div class="form-group px-0 m-0">
                                                                <label class="fw-bold mb-2">Tujuan Pemakaian <span class="text-muted fw-normal">(Opsional)</span></label>
                                                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Dipakai untuk meeting tim marketing"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 pt-4">
                                                            <button type="button" class="btn btn-light btn-round border" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning text-white btn-round fw-bold">Simpan Pemakaian</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data barang persediaan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL TAMBAH ASET ================= --}}
<div class="modal fade" id="modalTambahAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-box-open text-primary me-2"></i> Form Tambah Aset Tetap
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('inventaris.aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Nama Aset / Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Laptop Asus ROG" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Kategori Aset <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Elektronik & IT">Elektronik & IT</option>
                                    <option value="Furnitur">Furnitur (Meja, Kursi, dll)</option>
                                    <option value="Kendaraan">Kendaraan Operasional</option>
                                    <option value="Perlengkapan Cetak">Perlengkapan Cetak / ATK</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Tanggal Masuk / Pembelian <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tgl_masuk" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Lokasi Penempatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Contoh: Ruang Meeting Lantai 1" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Penanggung Jawab (PIC)</label>
                                <input type="text" class="form-control" name="pic" placeholder="Contoh: Nama Pegawai (Opsional)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Harga Beli (Rp) <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="number" class="form-control" name="harga_beli" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Status / Kondisi Awal <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="Baik" selected>Baik / Baru</option>
                                    <option value="Bekas - Baik">Bekas - Masih Layak</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Upload Foto Barang <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="file" class="form-control" name="foto_aset" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Catatan Tambahan</label>
                                <textarea class="form-control" name="keterangan" rows="2" placeholder="Spesifikasi, nomor seri, atau kelengkapan barang..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-4">
                    <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Data Aset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH BARANG PERSEDIAAN BARU --}}
<div class="modal fade" id="modalTambahPersediaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-box text-success me-2"></i> Item Persediaan Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('inventaris.item.store') }}" method="POST">
                @csrf
                <div class="modal-body pt-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_barang" placeholder="Contoh: Kertas HVS A4" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Atribut Pelatihan">Atribut Pelatihan</option>
                                    <option value="ATK & Modul">ATK & Modul</option>
                                    <option value="Konsumsi/Pantry">Konsumsi / Pantry</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Satuan Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="satuan" placeholder="Contoh: Pcs, Rim, Pack" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stok_awal" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group px-0 m-0">
                                <label class="fw-bold mb-2">Batas Minimum Peringatan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="batas_minimum" placeholder="Contoh: 15" min="1" required title="Sistem akan memberi peringatan jika stok di bawah angka ini">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-4">
                    <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-round fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom style for nav pills so it matches the theme */
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    
    .nav-pills.nav-secondary .nav-link.active {
        background: #1a2035;
        color: #fff;
        border-radius: 8px;
    }
    .nav-pills .nav-link {
        color: #555;
        padding: 10px 20px;
        transition: all 0.2s;
    }
    .nav-pills .nav-link:hover:not(.active) {
        background: #f1f1f1;
        border-radius: 8px;
    }
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endsection
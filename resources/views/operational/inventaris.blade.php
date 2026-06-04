@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Data Aset & Inventaris</h3>
                <h6 class="text-muted mb-2 fw-normal">Manajemen pencatatan aset tetap dan stok barang operasional (habis pakai)</h6>
                
                {{-- Jam Realtime Modern --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border bg-white" style="color: #0ea5e9; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2">
                <button class="btn btn-success btn-round fw-bold shadow-sm hover-lift">
                    <i class="fas fa-file-excel me-1"></i> Export Data
                </button>
            </div>
        </div>

        {{-- ================= ALERT NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-modern-success alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark">Berhasil!</span> <span class="text-dark opacity-75">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-start">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Terjadi Kesalahan!</span>
                        <ul class="mb-0 text-dark opacity-75 ps-3 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= STATISTIC CARDS (MODERN UI) ================= --}}
        <div class="row mb-3 fade-in">
            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-primary-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-primary-subtle text-primary me-3">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Aset Tetap</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['total_aset']) }}</h3>
                            <p class="text-muted small mb-0 mt-1" style="font-size: 10px;">Unit terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Jenis Persediaan</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['jenis_item']) }}</h3>
                            <p class="text-success fw-bold small mb-0 mt-1" style="font-size: 10px;">Item habis pakai</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-warning-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Stok Menipis</p>
                            <h3 class="fw-bolder text-warning-dark mb-0 lh-1">{{ $stats['stok_menipis'] }} <span style="font-size: 14px;">Item</span></h3>
                            <p class="text-warning-dark fw-bold small mb-0 mt-1" style="font-size: 10px;">Segera restock!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-danger-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-danger-subtle text-danger me-3">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Aset Rusak/Servis</p>
                            <h3 class="fw-bolder text-danger mb-0 lh-1">{{ $stats['aset_rusak'] }}</h3>
                            <p class="text-danger fw-bold small mb-0 mt-1" style="font-size: 10px;">Perlu perbaikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SEGMENTED TABS (MODERN) ================= --}}
        <div class="d-flex justify-content-center mb-4 fade-in">
            <div class="nav-modern p-1 rounded-pill bg-white border shadow-sm d-inline-flex" id="pills-tab" role="tablist">
                {{-- Persediaan ditaruh di kiri dan jadi Active --}}
                <button class="nav-link active" id="pills-persediaan-tab" data-bs-toggle="pill" data-bs-target="#pills-persediaan" type="button" role="tab">
                    <i class="fas fa-box-open me-1"></i> Barang Persediaan
                </button>
                <button class="nav-link" id="pills-aset-tab" data-bs-toggle="pill" data-bs-target="#pills-aset" type="button" role="tab">
                    <i class="fas fa-laptop me-1"></i> Aset Tetap
                </button>
            </div>
        </div>

        <div class="tab-content fade-in" id="pills-tabContent">
            
            {{-- ================= TAB 1: BARANG PERSEDIAAN (Tampil Pertama) ================= --}}
            <div class="tab-pane fade show active" id="pills-persediaan" role="tabpanel">
                
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3 bg-light" style="border-radius: 16px;">
                        <form action="{{ route('operational.inventaris') }}" method="GET" class="d-flex gap-2 flex-grow-1 align-items-end flex-wrap">
                            <div style="min-width: 280px; flex-grow: 1; max-width: 400px;">
                                <label class="label-modern">Cari Persediaan</label>
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search_stok" class="form-control border-start-0 shadow-none ps-0" placeholder="Cari Nama Barang..." value="{{ request('search_stok') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 shadow-sm hover-lift">Filter</button>
                            <a href="{{ route('operational.inventaris') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark px-4 shadow-sm hover-lift">Reset</a>
                        </form>
                        <button class="btn btn-success btn-round btn-sm fw-bold shadow-sm hover-lift px-4" data-bs-toggle="modal" data-bs-target="#modalTambahPersediaan">
                            <i class="fas fa-plus me-1"></i> Tambah Barang Baru
                        </button>
                    </div>
                </div>

                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0 text-center">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="text-start ps-4">Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Sisa Stok</th>
                                        <th>Satuan</th>
                                        <th>Status Stok</th>
                                        <th class="text-center" width="130">Mutasi Stok</th>
                                        <th class="text-center pe-4" width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td class="text-start ps-4 fw-bolder text-dark" style="font-size: 14px;">{{ $item->nama }}</td>
                                            <td><span class="badge badge-soft-secondary border text-muted px-2 py-1" style="font-size: 10px;">{{ $item->kategori }}</span></td>
                                            <td>
                                                <h4 class="mb-0 fw-bolder {{ $item->stok <= $item->min_stok ? 'text-danger' : 'text-primary' }}">
                                                    {{ number_format($item->stok) }}
                                                </h4>
                                            </td>
                                            <td class="text-muted fw-bold small text-uppercase">{{ $item->satuan }}</td>
                                            <td>
                                                @if($item->stok <= $item->min_stok)
                                                    <span class="badge badge-soft-danger border border-danger px-3 py-1 rounded-pill animate-pulse" title="Batas Minimal: {{ $item->min_stok }}"><i class="fas fa-exclamation-circle me-1"></i> Menipis</span>
                                                @else
                                                    <span class="badge badge-soft-success border border-success px-3 py-1 rounded-pill" title="Batas Minimal: {{ $item->min_stok }}"><i class="fas fa-check me-1"></i> Aman</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <button class="btn btn-sm btn-primary btn-round fw-bold shadow-sm hover-lift flex-grow-1 px-2" data-bs-toggle="modal" data-bs-target="#modalMutasi{{ $item->id }}In" title="Stok Masuk (+)">
                                                        <i class="fas fa-plus"></i> In
                                                    </button>
                                                    <button class="btn btn-sm btn-warning btn-round fw-bold text-dark shadow-sm hover-lift flex-grow-1 px-2" data-bs-toggle="modal" data-bs-target="#modalMutasi{{ $item->id }}Out" title="Stok Keluar (-)">
                                                        <i class="fas fa-minus"></i> Out
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- Tombol Edit --}}
                                                    <button class="btn btn-sm btn-light border text-primary btn-round shadow-sm hover-lift px-2" title="Edit Barang" data-bs-toggle="modal" data-bs-target="#modalEditPersediaan{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    {{-- Tombol Hapus --}}
                                                    <form action="{{ route('inventaris.item.destroy', $item->id) }}" method="POST" class="d-inline form-hapus m-0 p-0">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-light border text-danger btn-round shadow-sm hover-lift btn-delete px-2" title="Hapus Barang">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-box-open fs-1 mb-3 text-light opacity-50"></i><br>
                                                Belum ada data barang persediaan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TAB 2: ASET TETAP ================= --}}
            <div class="tab-pane fade" id="pills-aset" role="tabpanel">
                
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3 bg-light" style="border-radius: 16px;">
                        <form action="{{ route('operational.inventaris') }}" method="GET" class="d-flex gap-2 flex-grow-1 align-items-end flex-wrap">
                            <div style="min-width: 280px; flex-grow: 1; max-width: 400px;">
                                <label class="label-modern">Cari Aset</label>
                                <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0 shadow-none ps-0" placeholder="Cari Kode / Nama Aset..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 shadow-sm hover-lift">Filter</button>
                            <a href="{{ route('operational.inventaris') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark px-4 shadow-sm hover-lift">Reset</a>
                        </form>
                        <button class="btn btn-primary btn-round btn-sm fw-bold shadow-sm hover-lift px-4" data-bs-toggle="modal" data-bs-target="#modalTambahAset">
                            <i class="fas fa-plus me-1"></i> Tambah Aset Tetap
                        </button>
                    </div>
                </div>

                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="text-start ps-4" width="130">Kode Aset</th>
                                        {{-- 🔥 UBAH NAMA KOLOM INI 🔥 --}}
                                        <th>Detail Aset (Info & Catatan)</th> 
                                        <th>Jumlah & Satuan</th>
                                        <th>Nilai Aset</th>
                                        <th>Lokasi / PIC</th>
                                        <th>Status</th>
                                        <th class="text-center pe-4" width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($asets as $aset)
                                        <tr>
                                            <td class="text-start ps-4">
                                                <span class="badge badge-soft-secondary border text-dark py-2 px-3 fw-bold shadow-sm" style="letter-spacing: 0.5px;">{{ $aset->kode }}</span>
                                            </td>
                                            {{-- 🔥 TAMPILAN BARU: FOTO, NAMA, KATEGORI, DAN CATATAN 🔥 --}}
                                            <td>
                                                <div class="d-flex align-items-start">
                                                    {{-- 1. Kotak Foto --}}
                                                    <div class="me-3 mt-1 flex-shrink-0">
                                                        @if($aset->foto)
                                                            <a href="{{ asset('storage/' . $aset->foto) }}" target="_blank" title="Klik untuk perbesar foto">
                                                                <img src="{{ asset('storage/' . $aset->foto) }}" alt="Foto Aset" class="rounded border shadow-sm hover-lift" style="width: 52px; height: 52px; object-fit: cover;">
                                                            </a>
                                                        @else
                                                            <div class="rounded border bg-light text-muted d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px;" title="Tidak ada foto">
                                                                <i class="fas fa-laptop text-secondary opacity-50"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    {{-- 2. Detail Teks & Catatan --}}
                                                    <div>
                                                        <div class="fw-bolder text-dark mb-1" style="font-size: 14px;">{{ $aset->nama }}</div>
                                                        <span class="badge badge-soft-info border mb-1" style="font-size: 10px;">{{ $aset->kategori }}</span>
                                                        
                                                        {{-- 3. Area Catatan Tambahan --}}
                                                        @if($aset->keterangan)
                                                            <div class="text-muted fst-italic mt-1 lh-sm text-wrap" style="font-size: 11px; max-width: 250px;">
                                                                <i class="fas fa-info-circle me-1 text-primary opacity-75"></i> {{ $aset->keterangan }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- 🔥 Tampilan Jumlah dan Satuan 🔥 --}}
                                            <td>
                                                <h5 class="mb-0 fw-bolder text-dark">{{ $aset->jumlah ?? 1 }}</h5>
                                                <small class="text-muted fw-bold text-uppercase" style="font-size: 10px;">{{ $aset->satuan ?? 'Unit' }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $hargaBeli = $aset->harga ?? 0;
                                                    $jumlah = $aset->jumlah ?? 1;
                                                    $totalNilai = $hargaBeli * $jumlah;
                                                @endphp
                                                
                                                {{-- Menampilkan Total Nilai --}}
                                                <div class="fw-bolder text-success mb-1" style="font-size: 14px;">
                                                    Rp {{ number_format($totalNilai, 0, ',', '.') }}
                                                </div>
                                                {{-- Menampilkan Harga Satuan --}}
                                                <small class="text-muted fw-medium" style="font-size: 10px;">
                                                    @ Rp {{ number_format($hargaBeli, 0, ',', '.') }} / {{ $aset->satuan ?? 'Unit' }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-primary mb-1"><i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $aset->lokasi }}</div>
                                                <small class="text-muted fw-medium"><i class="fas fa-user-tie me-1"></i> PIC: {{ $aset->pic ?? '-' }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $kondisiClass = 'badge-soft-success'; // Default Baik
                                                    if(str_contains(strtolower($aset->kondisi), 'rusak')) $kondisiClass = 'badge-soft-danger';
                                                    if(str_contains(strtolower($aset->kondisi), 'bekas')) $kondisiClass = 'badge-soft-warning text-dark';
                                                @endphp
                                                <span class="badge {{ $kondisiClass }} px-3 py-1 rounded-pill border">{{ $aset->kondisi }}</span>
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    {{-- Tombol Edit --}}
                                                    <button class="btn btn-sm btn-light border text-primary btn-round shadow-sm hover-lift px-2" 
                                                            title="Edit Data Aset" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditAset{{ $aset->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    {{-- Tombol Hapus --}}
                                                    <form action="{{ route('inventaris.aset.destroy', $aset->id) }}" method="POST" class="d-inline form-hapus m-0 p-0">
                                                        @csrf 
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-light border text-danger btn-round shadow-sm hover-lift btn-delete px-2" title="Hapus Aset">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
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

{{-- ================= KUMPULAN MODALS (DI LUAR TABEL) ================= --}}

{{-- Modal Tambah Aset --}}
<div class="modal fade" id="modalTambahAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-laptop me-2"></i> Form Tambah Aset Tetap
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('inventaris.aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 pt-3">
                    <div class="row g-3">
                        {{-- //kode aset input manual --}}
                        <div class="col-md-12">
                            <label class="label-modern">Kode Aset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="kode" placeholder="Contoh: AS001" required>
                        </div>
                        <div class="col-md-12">
                            <label class="label-modern">Nama Aset / Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="nama" placeholder="Contoh: Laptop Asus ROG" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Kategori Aset <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select input-modern shadow-none" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                <option value="Elektronik & IT">Elektronik & IT</option>
                                <option value="Furnitur">Furnitur (Meja, Kursi, dll)</option>
                                <option value="Kendaraan">Kendaraan Operasional</option>
                                <option value="Perlengkapan Cetak">Perlengkapan Cetak / ATK</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Tanggal Masuk / Pembelian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-modern shadow-none" name="tgl_masuk" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Lokasi Penempatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="lokasi" placeholder="Contoh: Ruang Meeting Lantai 1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Penanggung Jawab (PIC)</label>
                            <input type="text" class="form-control input-modern shadow-none" name="pic" placeholder="Contoh: Nama Pegawai (Opsional)" required>
                        </div>
                        {{-- Jumlah dan Satuan --}}
                        <div class="col-md-6">
                            <label class="label-modern">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-modern shadow-none" name="jumlah" placeholder="Contoh: 5" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="satuan" placeholder="Contoh: Buah, Unit, Set" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Harga Beli (Rp)</label>
                            <input type="number" class="form-control input-modern shadow-none" name="harga" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Status / Kondisi Awal <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select input-modern shadow-none" required>
                                <option value="Baik" selected>Baik / Baru</option>
                                <option value="Bekas - Baik">Bekas - Masih Layak</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="label-modern">Upload Foto Barang</label>
                            <input type="file" class="form-control input-modern shadow-none" name="foto_aset" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="label-modern">Catatan Tambahan</label>
                            <textarea class="form-control input-modern shadow-none" name="keterangan" rows="2" placeholder="Spesifikasi, nomor seri, atau kelengkapan barang..."></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Simpan Data Aset</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals Looping untuk Edit (Aset Tetap) --}}
@foreach($asets as $aset)
    <div class="modal fade" id="modalEditAset{{ $aset->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-warning-subtle text-warning-dark border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder">
                        <i class="fas fa-edit me-2"></i> Edit Data Aset Tetap
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('inventaris.aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 pt-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="label-modern">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none text-uppercase" name="kode" value="{{ $aset->kode }}" required>
                            </div>
                            <div class="col-md-8">
                                <label class="label-modern">Nama Aset / Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="nama" value="{{ $aset->nama }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="label-modern">Jumlah Aset <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-modern shadow-none" name="jumlah" value="{{ $aset->jumlah }}" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Satuan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="satuan" value="{{ $aset->satuan }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="label-modern">Kategori Aset <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select input-modern shadow-none" required>
                                    <option value="Elektronik & IT" {{ $aset->kategori == 'Elektronik & IT' ? 'selected' : '' }}>Elektronik & IT</option>
                                    <option value="Furnitur" {{ $aset->kategori == 'Furnitur' ? 'selected' : '' }}>Furnitur (Meja, Kursi, dll)</option>
                                    <option value="Kendaraan" {{ $aset->kategori == 'Kendaraan' ? 'selected' : '' }}>Kendaraan Operasional</option>
                                    <option value="Perlengkapan Cetak" {{ $aset->kategori == 'Perlengkapan Cetak' ? 'selected' : '' }}>Perlengkapan Cetak / ATK</option>
                                    <option value="Lainnya" {{ $aset->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Tanggal Masuk / Pembelian <span class="text-danger">*</span></label>
                                <input type="date" class="form-control input-modern shadow-none" name="tgl_masuk" value="{{ $aset->tgl_masuk }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Lokasi Penempatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="lokasi" value="{{ $aset->lokasi }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Penanggung Jawab (PIC)</label>
                                <input type="text" class="form-control input-modern shadow-none" name="pic" value="{{ $aset->pic }}">
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Harga Beli (Rp)</label>
                                <input type="number" class="form-control input-modern shadow-none" name="harga" value="{{ $aset->harga }}">
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Status / Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select input-modern shadow-none" required>
                                    <option value="Baik" {{ $aset->kondisi == 'Baik' ? 'selected' : '' }}>Baik / Baru</option>
                                    <option value="Bekas - Baik" {{ $aset->kondisi == 'Bekas - Baik' ? 'selected' : '' }}>Bekas - Masih Layak</option>
                                    <option value="Rusak Ringan" {{ $aset->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="label-modern">Update Foto Barang</label>
                                <input type="file" class="form-control input-modern shadow-none" name="foto_aset" accept="image/*">
                                @if($aset->foto)
                                    <small class="text-muted d-block mt-1"><i class="fas fa-check-circle text-success me-1"></i>Aset ini sudah memiliki foto. Upload baru untuk mengganti.</small>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label class="label-modern">Catatan Tambahan</label>
                                <textarea class="form-control input-modern shadow-none" name="keterangan" rows="2">{{ $aset->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                        <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning btn-round fw-bold text-dark shadow-sm hover-lift px-4">Update Data Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal Tambah Persediaan --}}
<div class="modal fade" id="modalTambahPersediaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-success-subtle text-success border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-box me-2"></i> Item Persediaan Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('inventaris.item.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 pt-3">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="label-modern">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="nama_barang" placeholder="Contoh: Kertas HVS A4" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select input-modern shadow-none" required>
                                <option value="Atribut Pelatihan">Atribut Pelatihan</option>
                                <option value="ATK & Modul">ATK & Modul</option>
                                <option value="Konsumsi/Pantry">Konsumsi / Pantry</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Satuan Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none" name="satuan" placeholder="Contoh: Pcs, Rim, Pack" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-modern shadow-none" name="stok_awal" placeholder="0" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Batas Min. Peringatan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-modern shadow-none" name="batas_minimum" placeholder="Contoh: 15" min="1" required title="Peringatan jika stok di bawah angka ini">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success text-white btn-round fw-bold shadow-sm hover-lift px-4">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals Looping untuk Mutasi In & Out & Edit (Persediaan) --}}
@foreach($items as $item)
    {{-- Modal Edit Persediaan --}}
    <div class="modal fade" id="modalEditPersediaan{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder">
                        <i class="fas fa-edit me-2"></i> Edit Item Persediaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('inventaris.item.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 pt-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="label-modern">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="nama_barang" value="{{ $item->nama }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select input-modern shadow-none" required>
                                    <option value="Atribut Pelatihan" {{ $item->kategori == 'Atribut Pelatihan' ? 'selected' : '' }}>Atribut Pelatihan</option>
                                    <option value="ATK & Modul" {{ $item->kategori == 'ATK & Modul' ? 'selected' : '' }}>ATK & Modul</option>
                                    <option value="Konsumsi/Pantry" {{ $item->kategori == 'Konsumsi/Pantry' ? 'selected' : '' }}>Konsumsi / Pantry</option>
                                    <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="label-modern">Satuan Unit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-modern shadow-none" name="satuan" value="{{ $item->satuan }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="label-modern">Batas Min. Peringatan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-modern shadow-none" name="batas_minimum" value="{{ $item->min_stok }}" min="1" required>
                                <small class="text-muted" style="font-size: 10px;">*Stok saat ini: {{ $item->stok }} {{ $item->satuan }} (Perubahan stok hanya bisa lewat mutasi In/Out)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                        <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-white btn-round fw-bold shadow-sm hover-lift px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Mutasi IN --}}
    <div class="modal fade" id="modalMutasi{{ $item->id }}In" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder">
                        <i class="fas fa-arrow-down me-2"></i> Tambah Stok (Masuk)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inventaris.mutasi', $item->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe" value="in">
                    <div class="modal-body px-4 pt-3">
                        <p class="mb-3 text-dark opacity-75">Barang: <strong class="text-primary">{{ $item->nama }}</strong></p>
                        <div class="form-group px-0">
                            <label class="label-modern">Jumlah Masuk (<span class="text-lowercase">{{ $item->satuan }}</span>) <span class="text-danger">*</span></label>
                            <input type="number" name="qty" class="form-control input-modern shadow-none" min="1" required placeholder="0">
                        </div>
                        <div class="form-group px-0 mt-3">
                            <label class="label-modern">Keterangan / Sumber Beli</label>
                            <textarea name="keterangan" class="form-control input-modern shadow-none" rows="2" placeholder="Contoh: Pembelian dari Toko ABC..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                        <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Simpan Stok Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Mutasi OUT --}}
    <div class="modal fade" id="modalMutasi{{ $item->id }}Out" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-modern border-0 shadow-lg">
                <div class="modal-header bg-warning-subtle text-warning-dark border-bottom-0 pb-3 pt-4 px-4">
                    <h5 class="modal-title fw-bolder">
                        <i class="fas fa-arrow-up me-2"></i> Kurangi Stok (Pemakaian)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inventaris.mutasi', $item->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe" value="out">
                    <div class="modal-body px-4 pt-3">
                        <div class="alert alert-modern-warning mb-4 py-2 px-3 border-0">
                            Barang: <strong class="text-dark">{{ $item->nama }}</strong> <br>
                            Sisa stok: <strong class="text-danger">{{ $item->stok }}</strong> {{ $item->satuan }}
                        </div>
                        <div class="form-group px-0">
                            <label class="label-modern">Jumlah Keluar (<span class="text-lowercase">{{ $item->satuan }}</span>) <span class="text-danger">*</span></label>
                            <input type="number" name="qty" class="form-control input-modern shadow-none" min="1" max="{{ $item->stok }}" required placeholder="0">
                        </div>
                        <div class="form-group px-0 mt-3">
                            <label class="label-modern">Tujuan Pemakaian</label>
                            <textarea name="keterangan" class="form-control input-modern shadow-none" rows="2" placeholder="Contoh: Dipakai untuk operasional tim..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                        <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark btn-round fw-bold shadow-sm hover-lift px-4">Simpan Pemakaian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- ================= STYLES ================= --}}
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

    .icon-modern {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 20px;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-secondary-subtle { background-color: #f8fafc !important; }
    .text-warning-dark { color: #b45309 !important; }

    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }
    .border-warning-subtle { border-color: #fef08a !important; }
    .border-danger-subtle { border-color: #fecaca !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-warning { background-color: #fefce8; color: #b45309; }
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; }
    .badge-soft-secondary { background-color: #f8fafc; color: #475569; }

    /* Alert Modern */
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-danger { background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .alert-modern-warning { background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 12px; padding: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

    /* Segmented Tabs (Modern Toggle) */
    .nav-modern { background-color: #f1f5f9; padding: 4px; border-radius: 50px; }
    .nav-modern .nav-link { border-radius: 50px; color: #64748b; font-weight: 600; font-size: 14px; padding: 8px 24px; border: none; transition: all 0.3s ease; background: transparent; }
    .nav-modern .nav-link:hover { color: #0f172a; }
    .nav-modern .nav-link.active { background-color: #ffffff; color: #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

    /* Table Modern */
    .table-modern th { text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
    .table-modern td { border-bottom: 1px solid #f1f5f9; padding: 14px 16px; }

    /* Form Modern */
    .label-modern { font-weight: 700; color: #64748b; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: block; }
    .input-modern { border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px 12px; font-size: 13px; color: #334155; background-color: #ffffff; }
    .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
</style>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // =========================================================================
        // 1. FUNGSI JAM REALTIME
        // =========================================================================
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // =========================================================================
        // 2. KONFIRMASI HAPUS SWEETALERT
        // =========================================================================
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-hapus');
                
                Swal.fire({
                    title: 'Hapus data ini?',
                    text: "Seluruh log riwayat mutasi stok barang ini juga akan ikut terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8', 
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'card-modern',
                        confirmButton: 'btn btn-round shadow-sm px-4 ms-2',
                        cancelButton: 'btn btn-round shadow-sm px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // =========================================================================
        // 3. FITUR MEMORI TAB (AGAR TIDAK KEMBALI KE AWAL SETELAH REFRESH)
        // =========================================================================
        const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
        const activeTab = localStorage.getItem('activeInventoryTab');
        
        // Paksa Bootstrap 5 untuk membuka tab yang tersimpan di memori
        if (activeTab) {
            const targetButton = document.querySelector(`button[data-bs-target="${activeTab}"]`);
            if (targetButton) {
                // Menggunakan getOrCreateInstance agar tidak bentrok dengan inisialisasi bawaan BS5
                const tabInstance = bootstrap.Tab.getOrCreateInstance(targetButton);
                tabInstance.show();
            }
        }

        // Simpan ID tab setiap kali diklik
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function (event) {
                const currentTabId = event.target.getAttribute('data-bs-target');
                localStorage.setItem('activeInventoryTab', currentTabId);
            });
        });

    });
</script>


@endsection
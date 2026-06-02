@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION (MODERN) ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Monitoring Pengiriman Paket</h3>
                <h6 class="text-muted mb-2 fw-normal">Lacak distribusi modul, sertifikat, dan perlengkapan peserta pelatihan</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2 flex-wrap">
                <button class="btn btn-info btn-round fw-bold shadow-sm text-white hover-lift" data-bs-toggle="modal" data-bs-target="#modalImportPaket">
                    <i class="fas fa-file-import me-1"></i> Import Excel
                </button>
                <button class="btn btn-success btn-round fw-bold shadow-sm hover-lift">
                    <i class="fas fa-file-excel me-1"></i> Export Data
                </button>
                <button class="btn btn-primary btn-round fw-bold shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">
                    <i class="fas fa-plus-circle me-1"></i> Input Pengiriman
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

        {{-- Alert Error Global Dihilangkan/Dipersingkat karena error sudah ada di dalam form --}}
        @if($errors->any())
            <div class="alert alert-modern-danger alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 mt-1" style="width: 32px; height: 32px;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-danger">Terjadi Kesalahan Validasi!</span>
                        <span class="text-dark opacity-75 ms-1">Silakan periksa kembali form yang Anda isikan.</span>
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
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Paket</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['total'] ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-secondary-subtle text-secondary me-3">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Sedang Diproses</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['diproses'] ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-warning-subtle text-warning-dark me-3">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Dalam Perjalanan</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['dikirim'] ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-3">
                <div class="card card-modern h-100 hover-lift border-success-subtle border-2">
                    <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                        <div class="icon-modern bg-success-subtle text-success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Berhasil Diterima</p>
                            <h3 class="fw-bolder text-dark mb-0 lh-1">{{ number_format($stats['diterima'] ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER & SEARCH (MODERN STYLE) ================= --}}
        <div class="card card-modern mb-4 fade-in" style="background-color: #f8faff;">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                    <div class="icon-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-filter" style="font-size: 13px;"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Filter Pencarian Pengiriman</h6>
                </div>

                <form action="{{ route('operational.monitoring-paket') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <label class="label-modern">Cari Nama / Resi / Instansi</label>
                        <div class="input-group input-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 shadow-none ps-0" style="font-size: 13px;" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Status Pengiriman</label>
                        <select name="status" class="form-select form-select-sm input-modern shadow-none">
                            <option value="">Semua Status</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Bermasalah" {{ request('status') == 'Bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm input-modern shadow-none" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <label class="label-modern">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm input-modern shadow-none" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-3 d-flex gap-2 mt-4 mt-lg-0">
                        <button type="submit" class="btn btn-primary btn-sm btn-round fw-bold px-4 hover-lift w-100 shadow-sm">
                            <i class="fas fa-search me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('operational.monitoring-paket') }}" class="btn btn-white btn-sm border btn-round fw-bold text-dark hover-lift w-100 text-center shadow-sm pt-2">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABEL DATA PENGIRIMAN (CLEAN UI) ================= --}}
        <div class="card card-modern border-0 shadow-sm fade-in mb-4">
            <div class="card-header bg-transparent border-bottom pt-4 px-4 pb-3">
                <h6 class="card-title fw-bolder mb-0 text-dark">Daftar Pengiriman Paket</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="ps-4">Info Penerima</th>
                                <th width="250">Detail Paket</th>
                                <th width="200">Kurir & No. Resi</th>
                                <th width="150">Timeline</th>
                                <th class="text-center" width="120">Status</th>
                                <th class="text-center pe-4" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_pengiriman as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bolder text-dark mb-1" style="font-size: 14px;">{{ $p->nama_penerima }}</div>
                                    <div class="text-primary small fw-bold mb-1 d-flex align-items-center"><i class="fas fa-building me-1"></i> {{ $p->instansi }}</div>
                                    
                                    {{-- Mengambil nama dari relasi tabel User --}}
                                    <span class="badge badge-soft-info border px-2 py-1 mb-1 d-inline-block">
                                        <i class="fas fa-user-tie me-1"></i> Marketing: {{ $p->marketing->nama_lengkap ?? 'Belum Diatur' }}
                                    </span>
                                    
                                    <div class="text-muted small d-flex align-items-center mt-1"><i class="fab fa-whatsapp text-success me-1"></i> {{ $p->no_hp }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-soft-warning mb-2">{{ $p->jenis_paket }}</span>
                                    <small class="d-block text-muted lh-sm text-wrap" style="max-width: 250px;">
                                        @if($p->isi_paket)
                                            {{ is_array($p->isi_paket) ? implode(', ', $p->isi_paket) : implode(', ', json_decode($p->isi_paket, true) ?? []) }}
                                        @endif
                                        {{ $p->isi_paket_lainnya ? ', ' . $p->isi_paket_lainnya : '' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="fw-bolder text-dark mb-1">{{ $p->ekspedisi }}</div>
                                    <code class="d-inline-block text-dark bg-light px-2 py-1 rounded border small shadow-sm">{{ $p->no_resi ?? 'Belum ada resi' }}</code>

                                    {{-- 🔥 TAMPILKAN TOMBOL FOTO RESI JIKA ADA 🔥 --}}
                                    @if($p->foto_resi)
                                        <a href="{{ asset('storage/' . $p->foto_resi) }}" target="_blank" class="btn bg-info-subtle text-info border-0 btn-sm btn-round fw-bold shadow-sm w-100 mt-2 hover-lift" style="font-size: 10px; padding: 4px;">
                                            <i class="fas fa-receipt me-1"></i> Lihat Resi
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="small mb-1"><span class="text-muted fw-bold">Kirim:</span> <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d M Y') }}</span></div>
                                    <div class="small"><span class="text-muted fw-bold">Terima:</span> <span class="text-dark fw-medium">{{ $p->tanggal_diterima ? \Carbon\Carbon::parse($p->tanggal_diterima)->format('d M Y') : '-' }}</span></div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = [
                                            'Diproses' => 'badge-soft-info',
                                            'Dikirim' => 'badge-soft-warning',
                                            'Diterima' => 'badge-soft-success',
                                            'Bermasalah' => 'badge-soft-danger'
                                        ][$p->status_pengiriman] ?? 'badge-soft-secondary';
                                    @endphp
                                    
                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill d-inline-block shadow-sm w-100">
                                        {{ $p->status_pengiriman }}
                                    </span>

                                    {{-- 🔥 TAMPILKAN BUKTI DITERIMA (CATATAN FILE) 🔥 --}}
                                    @if($p->catatan_file)
                                        <a href="{{ asset('storage/' . $p->catatan_file) }}" target="_blank" class="btn bg-info-subtle text-info border-0 btn-sm btn-round fw-bold shadow-sm w-100 mt-2 hover-lift" style="font-size: 10px; padding: 4px;">
                                            <i class="fas fa-box-open me-1"></i> Bukti Terima
                                        </a>
                                    @endif

                                    @if($p->catatan_teks)
                                        <div class="mt-2 text-start text-muted bg-light p-2 rounded-3 border" style="font-size: 10px; line-height: 1.4;">
                                            <b class="text-dark">Catatan:</b><br>{{ $p->catatan_teks }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex flex-column gap-2 justify-content-center">
                                        <button type="button" class="btn btn-primary btn-sm btn-round fw-bold shadow-sm text-white hover-lift" title="Edit Data" data-bs-toggle="modal" data-bs-target="#modalEditPaket{{ $p->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('monitoring-paket.destroy', $p->id) }}" method="POST" class="d-inline form-hapus">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-round fw-bold shadow-sm btn-delete w-100 hover-lift" title="Hapus Data">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fs-1 mb-3 text-light opacity-50"></i><br>
                                    Data pengiriman tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if(method_exists($data_pengiriman, 'hasPages') && $data_pengiriman->hasPages())
                <div class="card-footer bg-white border-top-0 pt-4 pb-3">
                    <div class="d-flex justify-content-center">
                        {{ $data_pengiriman->links('partials.pagination') }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ================= MODALS SECTION ================= --}}

{{-- 1. Modal Tambah Paket --}}
<div class="modal fade" id="modalTambahPaket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-box me-2"></i> Form Pengiriman Paket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('operational.monitoring-paket') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create"> <!-- Penanda Modal untuk Auto-Open -->
                
                <div class="modal-body px-4 pt-3">
                    
                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-user text-primary me-2"></i> Info Penerima</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="label-modern">Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none @error('instansi') is-invalid @enderror" name="instansi" placeholder="Contoh: PT ABC / RS XYZ" value="{{ old('instansi') }}" required>
                            @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">PIC Marketing <span class="text-danger"></span></label>
                            <select class="form-select input-modern shadow-none @error('marketing_id') is-invalid @enderror" name="marketing_id">
                                <option value="">-- Pilih Marketing --</option>
                                @foreach($marketings as $m)
                                    <option value="{{ $m->id }}" {{ old('marketing_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marketing_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none @error('nama_penerima') is-invalid @enderror" name="nama_penerima" placeholder="Nama lengkap penerima" value="{{ old('nama_penerima') }}" required>
                            @error('nama_penerima') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control input-modern shadow-none @error('no_hp') is-invalid @enderror" name="no_hp" placeholder="0812xxxxxx" value="{{ old('no_hp') }}" required>
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Alamat Lengkap Pengiriman <span class="text-danger">*</span></label>
                            <textarea class="form-control input-modern shadow-none @error('alamat_pengiriman') is-invalid @enderror" name="alamat_pengiriman" rows="2" placeholder="Alamat lengkap..." required>{{ old('alamat_pengiriman') }}</textarea>
                            @error('alamat_pengiriman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-cube text-primary me-2"></i> Detail Paket & Kurir</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="label-modern">Jenis Paket Utama <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none @error('jenis_paket') is-invalid @enderror" name="jenis_paket" required>
                                <option value="">-- Pilih Jenis Paket --</option>
                                <option value="Modul Pelatihan" {{ old('jenis_paket') == 'Modul Pelatihan' ? 'selected' : '' }}>Modul Pelatihan</option>
                                <option value="Sertifikat" {{ old('jenis_paket') == 'Sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                                <option value="Souvenir / ATK" {{ old('jenis_paket') == 'Souvenir / ATK' ? 'selected' : '' }}>Souvenir / ATK</option>
                                <option value="Invoice" {{ old('jenis_paket') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="Gabungan" {{ old('jenis_paket') == 'Gabungan' ? 'selected' : '' }}>Gabungan</option>
                            </select>
                            @error('jenis_paket') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-12">
                            <label class="label-modern">Isi Paket (Pilih yang sesuai) <span class="text-danger">*</span></label>
                            <div class="border border-light rounded-4 p-3 bg-light mb-2 shadow-sm @error('isi_paket') border-danger @enderror">
                                <div class="d-flex flex-wrap gap-3">
                                    @php 
                                        $items = ['Sertifikat', 'Modul Pelatihan', 'Kartu Lisensi/ID', 'Invoice', 'Kwitansi', 'Surat Pengantar', 'Souvenir (Polo/Tumbler)'];
                                    @endphp
                                    @foreach($items as $item)
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" name="isi_paket[]" value="{{ $item }}" id="check_{{ Str::slug($item) }}" {{ in_array($item, old('isi_paket', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark fw-medium small" for="check_{{ Str::slug($item) }}">{{ $item }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('isi_paket') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                            <input type="text" class="form-control form-control-sm input-modern shadow-none @error('isi_paket_lainnya') is-invalid @enderror" name="isi_paket_lainnya" placeholder="Tambah isi lainnya jika ada..." value="{{ old('isi_paket_lainnya') }}">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="label-modern">Ekspedisi <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none @error('ekspedisi') is-invalid @enderror" name="ekspedisi" required>
                                <option value="JNE" {{ old('ekspedisi') == 'JNE' ? 'selected' : '' }}>JNE</option>
                                <option value="J&T" {{ old('ekspedisi') == 'J&T' ? 'selected' : '' }}>J&T</option>
                                <option value="SiCepat" {{ old('ekspedisi') == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                                <option value="Pos Indonesia" {{ old('ekspedisi') == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                                <option value="Paxel" {{ old('ekspedisi') == 'Paxel' ? 'selected' : '' }}>Paxel</option>
                                <option value="Kurir Internal" {{ old('ekspedisi') == 'Kurir Internal' ? 'selected' : '' }}>Kurir Internal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">No. Resi</label>
                            <input type="text" class="form-control input-modern shadow-none @error('no_resi') is-invalid @enderror" name="no_resi" value="{{ old('no_resi') }}">
                            @error('no_resi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="label-modern">Foto Resi (Opsional)</label>
                            <input type="file" class="form-control input-modern shadow-none @error('foto_resi') is-invalid @enderror" name="foto_resi" accept=".jpg,.png,.jpeg,.pdf">
                            @error('foto_resi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="label-modern">Biaya Kirim (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-modern shadow-none @error('biaya_pengiriman') is-invalid @enderror" name="biaya_pengiriman" value="{{ old('biaya_pengiriman', 0) }}" required>
                        </div>
                    </div>

                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-calendar-check text-primary me-2"></i> Status & Berkas</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="label-modern">Status Pengiriman <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none @error('status_pengiriman') is-invalid @enderror" name="status_pengiriman" required>
                                <option value="Diproses" {{ old('status_pengiriman') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Dikirim" {{ old('status_pengiriman') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="Diterima" {{ old('status_pengiriman') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Bermasalah" {{ old('status_pengiriman') == 'Bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-modern shadow-none @error('tanggal_kirim') is-invalid @enderror" name="tanggal_kirim" value="{{ old('tanggal_kirim', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Upload Bukti (JPG/PDF)</label>
                            <input type="file" class="form-control input-modern shadow-none @error('catatan_file') is-invalid @enderror" name="catatan_file">
                            @error('catatan_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Simpan Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Modal Import Excel (Tetap Sama) --}}
<!-- ... kode import excel ... -->

{{-- 3. Kumpulan Modal Edit --}}
@foreach($data_pengiriman as $p)
<div class="modal fade" id="modalEditPaket{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-modern border-0 shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-edit me-2"></i> Edit Pengiriman Paket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('monitoring-paket.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="form_type" value="edit_{{ $p->id }}"> <!-- Penanda Modal untuk Auto-Open -->
                
                <div class="modal-body px-4 pt-3 text-start">
                    
                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-user text-primary me-2"></i> Info Penerima</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="label-modern">Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none @error('instansi') is-invalid @enderror" name="instansi" value="{{ old('instansi', $p->instansi) }}" required>
                            @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">PIC Marketing <span class="text-danger"></span></label>
                            <select class="form-select input-modern shadow-none @error('marketing_id') is-invalid @enderror" name="marketing_id">
                                <option value="">-- Pilih Marketing --</option>
                                @foreach($marketings as $m)
                                    <option value="{{ $m->id }}" {{ old('marketing_id', $p->marketing_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marketing_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-modern shadow-none @error('nama_penerima') is-invalid @enderror" name="nama_penerima" value="{{ old('nama_penerima', $p->nama_penerima) }}" required>
                            @error('nama_penerima') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control input-modern shadow-none @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp', $p->no_hp) }}" required>
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Alamat Lengkap Pengiriman <span class="text-danger">*</span></label>
                            <textarea class="form-control input-modern shadow-none @error('alamat_pengiriman') is-invalid @enderror" name="alamat_pengiriman" rows="2" required>{{ old('alamat_pengiriman', $p->alamat_pengiriman) }}</textarea>
                            @error('alamat_pengiriman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-cube text-primary me-2"></i> Detail Paket & Kurir</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="label-modern">Jenis Paket Utama <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none @error('jenis_paket') is-invalid @enderror" name="jenis_paket" required>
                                <option value="Modul Pelatihan" {{ old('jenis_paket', $p->jenis_paket) == 'Modul Pelatihan' ? 'selected' : '' }}>Modul Pelatihan</option>
                                <option value="Sertifikat" {{ old('jenis_paket', $p->jenis_paket) == 'Sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                                <option value="Souvenir / ATK" {{ old('jenis_paket', $p->jenis_paket) == 'Souvenir / ATK' ? 'selected' : '' }}>Souvenir / ATK</option>
                                <option value="Invoice" {{ old('jenis_paket') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                                <option value="Gabungan" {{ old('jenis_paket', $p->jenis_paket) == 'Gabungan' ? 'selected' : '' }}>Gabungan</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="label-modern">Isi Paket <span class="text-danger">*</span></label>
                            <div class="border border-light rounded-4 p-3 bg-light mb-2 shadow-sm @error('isi_paket') border-danger @enderror">
                                <div class="d-flex flex-wrap gap-3">
                                    @php 
                                        $items = ['Sertifikat', 'Modul Pelatihan', 'Kartu Lisensi/ID', 'Invoice', 'Kwitansi', 'Surat Pengantar', 'Souvenir (Polo/Tumbler)'];
                                        $isiPaketTersimpan = is_array($p->isi_paket) ? $p->isi_paket : json_decode($p->isi_paket, true) ?? [];
                                    @endphp
                                    @foreach($items as $item)
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" name="isi_paket[]" value="{{ $item }}" id="edit_check_{{ $p->id }}_{{ Str::slug($item) }}" {{ in_array($item, old('isi_paket', $isiPaketTersimpan)) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark fw-medium small" for="edit_check_{{ $p->id }}_{{ Str::slug($item) }}">{{ $item }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-sm input-modern shadow-none" name="isi_paket_lainnya" value="{{ old('isi_paket_lainnya', $p->isi_paket_lainnya) }}" placeholder="Tambah isi lainnya jika ada...">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="label-modern">Ekspedisi <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none" name="ekspedisi" required>
                                @foreach(['JNE', 'J&T', 'SiCepat', 'Pos Indonesia', 'Paxel', 'Kurir Internal'] as $eks)
                                    <option value="{{ $eks }}" {{ old('ekspedisi', $p->ekspedisi) == $eks ? 'selected' : '' }}>{{ $eks }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">No. Resi</label>
                            <input type="text" class="form-control input-modern shadow-none @error('no_resi') is-invalid @enderror" name="no_resi" value="{{ old('no_resi', $p->no_resi) }}">
                            @error('no_resi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="label-modern">Update Resi (Opsional)</label>
                            <input type="file" class="form-control input-modern shadow-none @error('foto_resi') is-invalid @enderror" name="foto_resi" accept=".jpg,.png,.jpeg,.pdf">
                            @error('foto_resi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if($p->foto_resi)
                                <small class="text-info fw-bold mt-1 d-block"><i class="fas fa-check-circle"></i> File resi tersimpan</small>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Biaya Kirim (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-modern shadow-none @error('biaya_pengiriman') is-invalid @enderror" name="biaya_pengiriman" value="{{ old('biaya_pengiriman', $p->biaya_pengiriman) }}" required>
                        </div>
                    </div>

                    <h6 class="fw-bolder text-dark mb-3 border-bottom pb-2"><i class="fas fa-calendar-check text-primary me-2"></i> Status & Berkas</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="label-modern">Status Pengiriman <span class="text-danger">*</span></label>
                            <select class="form-select input-modern shadow-none" name="status_pengiriman" required>
                                @foreach(['Diproses', 'Dikirim', 'Diterima', 'Bermasalah'] as $sts)
                                    <option value="{{ $sts }}" {{ old('status_pengiriman', $p->status_pengiriman) == $sts ? 'selected' : '' }}>{{ $sts }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" class="form-control input-modern shadow-none" name="tanggal_kirim" value="{{ old('tanggal_kirim', $p->tanggal_kirim) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="label-modern">Tanggal Diterima</label>
                            <input type="date" class="form-control input-modern shadow-none" name="tanggal_diterima" value="{{ old('tanggal_diterima', $p->tanggal_diterima) }}">
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <label class="label-modern">Update Bukti Resi/Foto (Opsional)</label>
                            <input type="file" class="form-control input-modern shadow-none @error('catatan_file') is-invalid @enderror" name="catatan_file">
                            @error('catatan_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if($p->catatan_file)
                                <div class="bg-success-subtle text-success p-2 rounded mt-2 small fw-bold d-inline-block">
                                    <i class="fas fa-check-circle me-1"></i> File bukti sudah ada. Upload baru untuk menimpa.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-top-0 pt-3 pb-3 px-4 rounded-bottom-4">
                    <button type="button" class="btn btn-white btn-round border fw-bold text-dark hover-lift" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold shadow-sm hover-lift px-4">Update Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- ================= STYLES ================= --}}
<style>
    /* CSS MODERNISASI UI TETAP SAMA */
    .card-modern {
        border-radius: 16px;
        border: 1px solid #eef2f7;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        background: #ffffff;
        transition: all 0.3s ease;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .icon-modern {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Soft Colors */
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-secondary-subtle { background-color: #f8fafc !important; }
    .text-warning-dark { color: #b45309 !important; }
    
    .border-primary-subtle { border-color: #bfdbfe !important; }
    .border-success-subtle { border-color: #bbf7d0 !important; }

    .badge-soft-primary { background-color: #eff6ff; color: #3b82f6; }
    .badge-soft-success { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;}
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;}
    .badge-soft-warning { background-color: #fefce8; color: #b45309; border: 1px solid #fef08a;}
    .badge-soft-info { background-color: #ecfeff; color: #0891b2; border: 1px solid #a5f3fc;}
    .badge-soft-secondary { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;}

    /* Alert Modern */
    .alert-modern-success {
        background-color: #f0fdf4;
        border-left: 4px solid #22c55e;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .alert-modern-danger {
        background-color: #fef2f2;
        border-left: 4px solid #ef4444;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .alert-modern-warning {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

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
        padding: 16px;
    }

    /* Form Modern */
    .label-modern {
        font-weight: 700;
        color: #64748b;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }
    .input-modern {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        color: #334155;
        background-color: #ffffff;
    }
    .input-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Animations */
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .pagination { justify-content: center; }
</style>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-hapus');
            
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8', 
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'card-modern',
                    confirmButton: 'btn btn-round shadow-sm px-4',
                    cancelButton: 'btn btn-round shadow-sm px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // =========================================================
    // SCRIPT AUTO-OPEN MODAL SAAT ADA ERROR VALIDASI
    // =========================================================
    @if($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            let errorFormType = "{{ old('form_type') }}";
            
            if(errorFormType === 'create') {
                // Buka modal Tambah jika error dari form tambah
                let myModal = new bootstrap.Modal(document.getElementById('modalTambahPaket'), {});
                myModal.show();
            } else if(errorFormType.startsWith('edit_')) {
                // Ekstrak ID dari string "edit_12"
                let paketId = errorFormType.replace('edit_', '');
                let modalId = 'modalEditPaket' + paketId;
                
                // Pastikan modal ditemukan di DOM
                if(document.getElementById(modalId)) {
                    let myModal = new bootstrap.Modal(document.getElementById(modalId), {});
                    myModal.show();
                }
            }
        });
    @endif
</script>
@endsection
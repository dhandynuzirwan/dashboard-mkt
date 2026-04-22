@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 fade-in">
            <div>
                <h3 class="fw-bold mb-1">Monitoring Pengiriman Paket</h3>
                <h6 class="op-7 mb-0">Lacak distribusi modul, sertifikat, dan perlengkapan peserta pelatihan</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2 flex-wrap">
                {{-- Tombol Import (Baru) --}}
                <button class="btn btn-info btn-round fw-bold shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalImportPaket">
                    <i class="fas fa-file-import me-1"></i> Import Excel
                </button>
                <button class="btn btn-success btn-round fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Data
                </button>
                <button class="btn btn-primary btn-round fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">
                    <i class="fas fa-plus-circle me-1"></i> Input Pengiriman
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
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-box-open"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Paket</p>
                                    <h4 class="card-title">{{ number_format($stats['total']) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sedang Diproses</p>
                                    <h4 class="card-title">{{ number_format($stats['diproses']) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small bg-warning-gradient text-white">
                                    <i class="fas fa-truck"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Dalam Perjalanan</p>
                                    <h4 class="card-title text-warning">{{ number_format($stats['dikirim']) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-sm mb-4" style="border-bottom: 3px solid #31ce36 !important;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small bg-success-gradient text-white">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Berhasil Diterima</p>
                                    <h4 class="card-title text-success">{{ number_format($stats['diterima']) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FILTER & SEARCH ================= --}}
        <div class="card card-round border-0 shadow-sm mb-4 fade-in">
            <div class="card-body p-3">
                <form action="{{ route('operational.monitoring-paket') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <small class="text-muted fw-bold d-block mb-1">Cari Nama / Resi / Instansi</small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted fw-bold d-block mb-1">Status Pengiriman</small>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Bermasalah" {{ request('status') == 'Bermasalah' ? 'selected' : '' }}>Bermasalah</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted fw-bold d-block mb-1">Dari Tanggal</small>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted fw-bold d-block mb-1">Sampai Tanggal</small>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 btn-round fw-bold">Filter</button>
                        <a href="{{ route('operational.monitoring-paket') }}" class="btn btn-light border btn-sm flex-grow-1 btn-round fw-bold">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= TABEL DATA PENGIRIMAN ================= --}}
        <div class="card card-round border-0 shadow-sm mb-4 fade-in">
            <div class="card-header bg-transparent border-bottom">
                <div class="card-title fw-bold">Daftar Pengiriman Paket</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-4">Info Penerima</th>
                                <th>Detail Paket</th>
                                <th>Kurir & No. Resi</th>
                                <th>Timeline</th>
                                <th class="text-center">Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_pengiriman as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark fs-6">{{ $p->nama_penerima }}</div>
                                    <div class="text-primary small fw-bold mb-1"><i class="fas fa-building me-1"></i> {{ $p->instansi }}</div>
                                    <div class="text-muted small"><i class="fab fa-whatsapp text-success me-1"></i> {{ $p->no_hp }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-secondary mb-1">{{ $p->jenis_paket }}</span>
                                    <small class="d-block text-muted">
                                        @if($p->isi_paket)
                                            {{ implode(', ', $p->isi_paket) }}
                                        @endif
                                        {{ $p->isi_paket_lainnya ? ', ' . $p->isi_paket_lainnya : '' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $p->ekspedisi }}</div>
                                    <div class="d-flex align-items-center mt-1">
                                        <code class="text-dark bg-light px-2 py-1 rounded border">{{ $p->no_resi ?? 'Belum ada resi' }}</code>
                                    </div>
                                </td>
                                <td>
                                    <div class="small"><b>Kirim:</b> {{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d M Y') }}</div>
                                    <div class="small text-muted mt-1"><b>Terima:</b> {{ $p->tanggal_diterima ? \Carbon\Carbon::parse($p->tanggal_diterima)->format('d M Y') : '-' }}</div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = [
                                            'Diproses' => 'badge-info',
                                            'Dikirim' => 'badge-warning',
                                            'Diterima' => 'badge-success',
                                            'Bermasalah' => 'badge-danger'
                                        ][$p->status_pengiriman] ?? 'badge-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-1 rounded-pill">{{ $p->status_pengiriman }}</span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-primary btn-sm btn-round fw-bold shadow-sm" title="Edit Data">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                
                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('monitoring-paket.destroy', $p->id) }}" method="POST" class="d-inline form-hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-round fw-bold shadow-sm btn-delete" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Data pengiriman tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- ================= PAGINATION ================= --}}
            @if($data_pengiriman->hasPages())
                <div class="d-flex justify-content-center py-4 bg-light border-top" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    {{ $data_pengiriman->links('partials.pagination') }}
                </div>
            @endif
            {{-- ================= END PAGINATION ================= --}}
        </div>

    </div>
</div>

{{-- ================= MODAL TAMBAH PAKET ================= --}}
<div class="modal fade" id="modalTambahPaket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-box text-primary me-2"></i> Form Pengiriman Paket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('operational.monitoring-paket') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-4">
                    
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user me-1"></i> Info Penerima</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold mb-1 small">Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="instansi" placeholder="Contoh: PT ABC / RS XYZ" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold mb-1 small">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_penerima" placeholder="Nama lengkap penerima" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold mb-1 small">No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="no_hp" placeholder="0812xxxxxx" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold mb-1 small">Alamat Lengkap Pengiriman <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat_pengiriman" rows="2" placeholder="Alamat lengkap..." required></textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-cube me-1"></i> Detail Paket & Kurir</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="fw-bold mb-1 small">Jenis Paket Utama <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_paket" required>
                                <option value="">-- Pilih Jenis Paket --</option>
                                <option value="Modul Pelatihan">Modul Pelatihan</option>
                                <option value="Sertifikat">Sertifikat</option>
                                <option value="Souvenir / ATK">Souvenir / ATK</option>
                                <option value="Gabungan">Gabungan</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="fw-bold mb-1 small">Isi Paket (Pilih yang sesuai) <span class="text-danger">*</span></label>
                            <div class="border rounded p-3 bg-light mb-2">
                                <div class="d-flex flex-wrap gap-3">
                                    @php 
                                        $items = ['Sertifikat', 'Modul Pelatihan', 'Kartu Lisensi/ID', 'Invoice', 'Kwitansi', 'Surat Pengantar', 'Souvenir (Polo/Tumbler)'];
                                    @endphp
                                    @foreach($items as $item)
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" name="isi_paket[]" value="{{ $item }}" id="check_{{ Str::slug($item) }}">
                                        <label class="form-check-label small" for="check_{{ Str::slug($item) }}">{{ $item }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-sm" name="isi_paket_lainnya" placeholder="Tambah isi lainnya jika ada...">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">Ekspedisi <span class="text-danger">*</span></label>
                            <select class="form-select" name="ekspedisi" required>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="Pos Indonesia">Pos Indonesia</option>
                                <option value="Paxel">Paxel</option>
                                <option value="Kurir Internal">Kurir Internal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">No. Resi</label>
                            <input type="text" class="form-control" name="no_resi">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">Biaya Kirim (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="biaya_pengiriman" value="0" required>
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-calendar-check me-1"></i> Status & Berkas</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">Status Pengiriman <span class="text-danger">*</span></label>
                            <select class="form-select" name="status_pengiriman" required>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Bermasalah">Bermasalah</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_kirim" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold mb-1 small">Upload Bukti (JPG/PDF)</label>
                            <input type="file" class="form-control" name="catatan_file">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-4">
                    <button type="button" class="btn btn-light btn-round border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold">Simpan Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL IMPORT EXCEL ================= --}}
<div class="modal fade" id="modalImportPaket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-file-excel text-success me-2"></i> Import Data Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('operational.monitoring-paket.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-4">
                    <div class="alert alert-warning shadow-sm rounded-3 border-start border-4 border-warning small mb-4">
                        <strong>Perhatian:</strong> Pastikan judul kolom di baris pertama Excel Anda sama persis dengan template sistem (seperti: <i>nama penerima, no hp, instansi, dll</i>).
                    </div>
                    
                    <div class="form-group px-0 m-0">
                        <label class="fw-bold mb-2">Upload File (.xlsx, .csv) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file_excel" accept=".xlsx, .xls, .csv" required>
                        <small class="text-muted d-block mt-1">Maksimal ukuran file: 5MB.</small>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-4">
                    <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white btn-round fw-bold">
                        <i class="fas fa-upload me-1"></i> Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .pagination { justify-content: center; }
</style>

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
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
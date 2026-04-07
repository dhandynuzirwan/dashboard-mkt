@extends('layouts.app')

{{-- Tambahkan CSS Select2 & Theme --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Edit CTA</h3>
                    <h6 class="op-7 mb-2">Update Data Penawaran & Prospek</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit CTA</div>
                        </div>
                        <div class="card-body">
                            {{-- Gunakan method PUT untuk Update --}}
                            <form action="{{ route('cta.update', $cta->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Info Read-Only (Sama seperti Form Tambah) --}}
                                <div class="form-group">
                                    <label>Marketing</label>
                                    <input type="text" class="form-control bg-light" value="{{ $cta->prospek->marketing->name }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Prospek</label>
                                    <input type="text" class="form-control bg-light" value="{{ $cta->prospek->tanggal_prospek }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <input type="text" class="form-control bg-light" value="{{ $cta->prospek->perusahaan }}" readonly>
                                </div>

                                {{-- Judul Permintaan (Select2) --}}
                                <div class="form-group">
                                    <label>Permintaan Pelatihan (Judul)</label>
                                    <select name="judul_permintaan" class="form-select select2-js">
                                        <option value="">-- Cari Judul Pelatihan --</option>
                                        @foreach ($trainings as $training)
                                            <option value="{{ $training->nama_training }}" 
                                                {{ $cta->judul_permintaan == $training->nama_training ? 'selected' : '' }}>
                                                {{ $training->nama_training }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Peserta</label>
                                    <input type="number" class="form-control" name="jumlah_peserta" value="{{ $cta->jumlah_peserta }}">
                                </div>

                                <div class="form-group">
                                    <label>Sertifikasi</label>
                                    <select class="form-select" name="sertifikasi">
                                        <option value="">-- Kosong --</option>
                                        <option value="kemnaker" {{ $cta->sertifikasi == 'kemnaker' ? 'selected' : '' }}>Sertifikat KEMENAKER</option>
                                        <option value="bnsp" {{ $cta->sertifikasi == 'bnsp' ? 'selected' : '' }}>Sertifikat BNSP</option>
                                        <option value="internal" {{ $cta->sertifikasi == 'internal' ? 'selected' : '' }}>Sertifikat Internal</option>
                                        <option value="sio" {{ $cta->sertifikasi == 'sio' ? 'selected' : '' }}>Pembuatan & Perpanjangan SIO</option>
                                        <option value="riksa" {{ $cta->sertifikasi == 'riksa' ? 'selected' : '' }}>Riksa Uji Alat</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Skema Pelatihan</label>
                                    <select class="form-select" name="skema">
                                        <option value="">-- Kosong --</option>
                                        <option value="Online Training" {{ $cta->skema == 'Online Training' ? 'selected' : '' }}>Online Training</option>
                                        <option value="Offline Training" {{ $cta->skema == 'Offline Training' ? 'selected' : '' }}>Offline Training</option>
                                        <option value="Inhouse Training" {{ $cta->skema == 'Inhouse Training' ? 'selected' : '' }}>Inhouse Training</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Harga Penawaran</label>
                                    <input type="number" class="form-control" name="harga_penawaran" value="{{ $cta->harga_penawaran }}">
                                </div>

                                <div class="form-group">
                                    <label>Harga Titip Vendor</label>
                                    <input type="number" class="form-control" name="harga_vendor" value="{{ $cta->harga_vendor }}">
                                </div>

                                <div class="form-group">
                                    <label>Link Proposal Google Drive</label>
                                    <input type="url" class="form-control" name="proposal_link" 
                                        placeholder="https://drive.google.com/..." value="{{ $cta->proposal_link }}">
                                    <small class="text-muted">Pastikan akses link sudah "Anyone with the link"</small>
                                </div>

                                <div class="form-group">
                                    <label>Status Penawaran</label>
                                    <select name="status_penawaran" class="form-select">
                                        <option value="">-- Kosong --</option>
                                        <option value="under_review" {{ $cta->status_penawaran == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="hold" {{ $cta->status_penawaran == 'hold' ? 'selected' : '' }}>Hold</option>
                                        <option value="kalah_harga" {{ $cta->status_penawaran == 'kalah_harga' ? 'selected' : '' }}>Kalah Harga</option>
                                        <option value="deal" {{ $cta->status_penawaran == 'deal' ? 'selected' : '' }}>Deal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Catatan CTA</label>
                                    <textarea class="form-control" name="keterangan" rows="1">{{ $cta->keterangan }}</textarea>
                                </div>

                                {{-- Field Wajib: Keterangan Akhir Data --}}
                                <div class="form-group">
                                    <label>Keterangan Akhir Data <span class="text-danger">*</span></label>
                                    <textarea 
                                        name="catatan_prospek" 
                                        class="form-control @error('catatan_prospek') is-invalid @enderror" 
                                        rows="3" 
                                        placeholder="Isi keterangan akhir prospek di sini..."
                                        required>{{ old('catatan_prospek', $cta->prospek->catatan) }}</textarea>
                                    @error('catatan_prospek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update CTA
                                    </button>
                                    <a href="{{ route('pipeline') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-js').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "-- Pilih atau Cari Judul --"
            });
        });
    </script>
@endpush
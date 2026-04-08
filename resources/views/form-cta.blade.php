@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Data CTA</h3>
                    <h6 class="op-7 mb-2">Formulir Tambah CTA Baru</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Tambah CTA</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cta.store') }}" method="POST" id="form-cta" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="prospek_id" value="{{ $prospek->id }}">

                                <div class="form-group">
                                    <label>Marketing</label>
                                    <input type="text" class="form-control" value="{{ $prospek->marketing->name }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Prospek</label>
                                    <input type="text" class="form-control" value="{{ $prospek->tanggal_prospek }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <input type="text" class="form-control" value="{{ $prospek->perusahaan }}" readonly>
                                </div>

                                {{-- Judul Permintaan --}}
                                <div class="form-group">
                                    <label>Permintaan Pelatihan (Judul)</label>
                                    {{-- Tambahkan class 'select2-js' --}}
                                    <select name="judul_permintaan" class="form-select select2-js">
                                        <option value="">-- Cari Judul Pelatihan --</option>
                                        @foreach ($trainings as $training)
                                            <option value="{{ $training->nama_training }}">
                                                {{ $training->nama_training }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Peserta</label>
                                    <input type="number" class="form-control" name="jumlah_peserta">
                                </div>

                                <div class="form-group">
                                    <label>Sertifikasi</label>
                                    <select class="form-select" name="sertifikasi">
                                        <option value="">-- Kosong --</option>
                                        <option value="kemnaker">Sertifikat KEMENAKER</option>
                                        <option value="bnsp">Sertifikat BNSP</option>
                                        <option value="internal">Sertifikat Internal</option>
                                        <option value="sio">Pembuatan & Perpanjangan SIO</option>
                                        <option value="riksa">Riksa Uji Alat</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Skema Pelatihan</label>
                                    <select class="form-select" name="skema">
                                        <option value="">-- Kosong --</option>
                                        <option value="Online Training">Online Training</option>
                                        <option value="Offline Training">Offline Training</option>
                                        <option value="Inhouse Training">Inhouse Training</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Harga Penawaran</label>
                                    <input type="number" class="form-control" name="harga_penawaran">
                                </div>

                                <div class="form-group">
                                    <label>Harga Titip Vendor</label>
                                    <input type="number" class="form-control" name="harga_vendor">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Upload File Proposal (PDF)</label>
                                        <input type="file" class="form-control" name="file_proposal" accept=".pdf">
                                        <small class="text-muted">Maksimal ukuran file: 5MB</small>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Atau Link Google Drive</label>
                                        <input type="url" class="form-control" name="proposal_link" placeholder="https://drive.google.com/...">
                                        <small class="text-muted">Gunakan ini jika file lebih dari 5MB</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Status Penawaran</label>
                                    <select name="status_penawaran" class="form-select">
                                        <option value="">-- Kosong --</option>
                                        <option value="under_review">Under Review</option>
                                        <option value="hold">Hold</option>
                                        <option value="kalah_harga">Kalah Harga</option>
                                        <option value="deal">Deal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Catatan CTA</label>
                                    <textarea class="form-control" name="keterangan" rows="1"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Keterangan Akhir Data <span class="text-danger">*</span></label>
                                    <textarea 
                                        name="catatan_prospek" 
                                        class="form-control @error('catatan_prospek') is-invalid @enderror" 
                                        rows="3" 
                                        placeholder="Isi keterangan akhir prospek di sini..."
                                        required>{{ old('catatan_prospek', $prospek->catatan) }}</textarea>
                                    @error('catatan_prospek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- BUTTON GROUP DENGAN NEXT PREVIOUS --}}
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    {{-- Tombol Previous --}}
                                    <div>
                                        @if($prevProspek)
                                            <a href="{{ route('form-cta', $prevProspek->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-chevron-left"></i> Prev Prospek
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                                        @endif
                                    </div>

                                    {{-- Tombol Utama --}}
                                    <div>
                                        <button type="submit" id="btn-simpan" class="btn btn-primary shadow-sm">
                                            <i class="fas fa-save"></i> Simpan CTA
                                        </button>
                                        <a href="{{ route('pipeline') }}" class="btn btn-secondary">Batal</a>
                                    </div>

                                    {{-- Tombol Next --}}
                                    <div>
                                        @if($nextProspek)
                                            <a href="{{ route('form-cta', $nextProspek->id) }}" class="btn btn-outline-secondary btn-sm">
                                                Next Prospek <i class="fas fa-chevron-right"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>Next <i class="fas fa-chevron-right"></i></button>
                                        @endif
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // 1. Inisialisasi Select2
            $('.select2-js').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "-- Pilih atau Cari Judul --"
            });

            // 2. Cegah Double Click Saat Proses Submit
            $('#form-cta').on('submit', function() {
                let btn = $('#btn-simpan');
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            });

            // 3. LOGIKA SETELAH BERHASIL DISIMPAN (HALAMAN RELOAD)
            @if(session('success'))
                // Munculkan Pop-up
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{!! session('success') !!}',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: 'top-end'
                });

                // MATIKAN TOMBOL SIMPAN SEMENTARA
                let btnSimpan = $('#btn-simpan');
                btnSimpan.prop('disabled', true);
                btnSimpan.removeClass('btn-primary').addClass('btn-secondary');
                btnSimpan.html('<i class="fas fa-check"></i> Sudah Tersimpan');

                // HIDUPKAN LAGI JIKA USER MENGUBAH INPUTAN (Milih judul baru)
                $('input, select, textarea').on('input change', function() {
                    btnSimpan.prop('disabled', false);
                    btnSimpan.removeClass('btn-secondary').addClass('btn-primary');
                    btnSimpan.html('<i class="fas fa-save"></i> Simpan CTA Lainnya');
                });
            @endif

            // 4. Pop-up khusus kalau langsung Deal
            @if(session('deal_congrats'))
                Swal.fire({
                    icon: 'success',
                    title: '🎉 PROJECT DEAL! 🎉',
                    text: '{!! session('deal_congrats') !!}',
                    confirmButtonText: 'Sikat Terus!',
                    confirmButtonColor: '#28a745',
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif
        });
    </script>
@endpush

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
                            <form action="{{ route('cta.update', $cta->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <option value="Inhouse Training" {{ $cta->skema == 'Blended Training' ? 'selected' : '' }}>Blended Training</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Harga Penawaran</label>
                                    {{-- Input yang dilihat user (Sudah diformat dari DB) --}}
                                    <input type="text" class="form-control input-rupiah" value="{{ $cta->harga_penawaran ? number_format($cta->harga_penawaran, 0, ',', '.') : '' }}" placeholder="Rp 0">
                                    {{-- Input asli yang dikirim ke database (Hidden) --}}
                                    <input type="hidden" name="harga_penawaran" class="input-real" value="{{ $cta->harga_penawaran }}">
                                </div>

                                <div class="form-group">
                                    <label>Harga Titip Vendor</label>
                                    <input type="text" class="form-control input-rupiah" value="{{ $cta->harga_vendor ? number_format($cta->harga_vendor, 0, ',', '.') : '' }}" placeholder="Rp 0">
                                    <input type="hidden" name="harga_vendor" class="input-real" value="{{ $cta->harga_vendor }}">
                                </div>

                                <div class="row mx-0">
                                    <div class="col-md-6 form-group ps-md-0">
                                        <label>Upload File Proposal Baru (PDF)</label>
                                        {{-- Tambahkan ID dan class error --}}
                                        <input type="file" id="file_proposal" class="form-control @error('file_proposal') is-invalid @enderror" name="file_proposal" accept=".pdf">
                                        
                                        {{-- Tampilkan Error Laravel jika ada --}}
                                        @error('file_proposal')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @else
                                            <small class="text-muted">Maksimal 5MB. Biarkan kosong jika tidak mengubah file.</small>
                                        @enderror
                                        
                                        {{-- Munculkan tombol lihat file jika sebelumnya sudah pernah upload --}}
                                        @if($cta->file_proposal)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $cta->file_proposal) }}" target="_blank" class="btn btn-sm btn-info shadow-sm">
                                                    <i class="fas fa-file-pdf"></i> Lihat File Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group pe-md-0">
                                        <label>Atau Link Google Drive</label>
                                        <input type="url" class="form-control @error('proposal_link') is-invalid @enderror" name="proposal_link" placeholder="https://drive..." value="{{ old('proposal_link', $cta->proposal_link) }}">
                                        @error('proposal_link')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
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

                                {{-- BUTTON GROUP DENGAN NEXT PREVIOUS --}}
                                <div class="d-flex justify-content-between align-items-center mt-4 mx-0">
                                    {{-- Tombol Previous --}}
                                    <div>
                                        @if($prevCta)
                                            <a href="{{ route('cta.edit', $prevCta->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-chevron-left"></i> Prev CTA
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                                        @endif
                                    </div>

                                    {{-- Tombol Utama --}}
                                    <div class="d-flex" style="gap: 8px;">
                                        <button type="submit" id="btn-simpan" class="btn btn-success shadow-sm">
                                            <i class="fas fa-save"></i> Update
                                        </button>
                                        
                                        {{-- Tombol Hapus memanggil fungsi JS confirmDelete() --}}
                                        <button type="button" class="btn btn-danger shadow-sm" onclick="confirmDelete()">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>

                                        <a href="{{ session('url_pipeline_terakhir', route('prospek.index')) }}" class="btn btn-secondary shadow-sm">Kembali</a>
                                    </div>

                                    {{-- Tombol Next --}}
                                    <div>
                                        @if($nextCta)
                                            <a href="{{ route('cta.edit', $nextCta->id) }}" class="btn btn-outline-secondary btn-sm">
                                                Next CTA <i class="fas fa-chevron-right"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>Next <i class="fas fa-chevron-right"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </form> {{-- <--- INI ADALAH PENUTUP FORM UPDATE UTAMA --}}

                            {{-- 🔥 TARUH FORM HAPUS DI SINI, DI LUAR FORM UTAMA 🔥 --}}
                            <form id="form-delete-cta" action="{{ route('cta.destroy', $cta->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>

                        </div>
                    </div>
                </div>

                {{-- ==================================================== --}}
                {{-- TAMBAHAN: INFO PENAWARAN LAIN & TOMBOL TAMBAH BARU --}}
                {{-- ==================================================== --}}
                <div class="col-md-12 mt-3">
                    <div class="alert alert-info d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-2"><i class="fas fa-info-circle"></i> Info Penawaran Perusahaan Ini</h6>
                            
                            @if($penawaranLainnya->count() > 0)
                                <p class="mb-2 small">Perusahaan <strong>{{ $cta->prospek->perusahaan }}</strong> juga memiliki {{ $penawaranLainnya->count() }} penawaran lain:</p>
                                <ul class="mb-0 small">
                                    @foreach($penawaranLainnya as $lain)
                                        <li>
                                            <strong>{{ $lain->judul_permintaan }}</strong> 
                                            - Status: 
                                            <span class="text-uppercase fw-bold text-{{ $lain->status_penawaran == 'deal' ? 'success' : 'primary' }}">
                                                {{ str_replace('_', ' ', $lain->status_penawaran ?? 'Review') }}
                                            </span>
                                            <a href="{{ route('cta.edit', $lain->id) }}" class="ms-2 text-decoration-underline">Edit Data Ini</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0 small">Belum ada penawaran judul pelatihan lain untuk perusahaan ini.</p>
                            @endif
                        </div>

                        {{-- TOMBOL TAMBAH CTA BARU --}}
                        <div class="ms-3">
                            <a href="{{ route('form-cta', $cta->prospek_id) }}" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Penawaran Baru
                            </a>
                        </div>
                    </div>
                </div>
                {{-- ==================================================== --}}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- 1. Panggil Library Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    {{-- 2. WAJIB: Panggil Library SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // FUNGSI KONFIRMASI HAPUS DATA
        function confirmDelete() {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data penawaran ini akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Biar tombol Batal ada di kiri
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika di-klik Ya, maka submit form yang tersembunyi
                    document.getElementById('form-delete-cta').submit();
                }
            });
        }

        $(document).ready(function() {
            // VALIDASI UKURAN FILE LANGSUNG (MAKSIMAL 5MB)
            $('#file_proposal').on('change', function() {
                if (this.files && this.files[0]) {
                    let fileSize = this.files[0].size; // Ambil ukuran file dalam satuan bytes
                    let maxSize = 5 * 1024 * 1024; // Hitungan 5 MB

                    if (fileSize > maxSize) {
                        // Munculkan peringatan SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops! File Kebesaran',
                            text: 'Ukuran file PDF kamu lebih dari 5MB. Silakan compress dulu atau gunakan Link Google Drive ya!',
                            confirmButtonColor: '#d33'
                        });
                        
                        // Kosongkan kembali input file-nya biar nggak bisa disubmit
                        $(this).val('');
                    }
                }
            });
            
            // Inisialisasi Select2
            $('.select2-js').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "-- Pilih atau Cari Judul --"
            });

            // Cegah Double Click Saat Proses Submit Form Update
            $('form:not(#form-delete-cta)').on('submit', function() {
                let btn = $('#btn-simpan');
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            });

            // Logika Setelah Berhasil Disimpan / Update
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{!! session('success') !!}',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: 'top-end'
                });

                // MATIKAN TOMBOL SEMENTARA
                let btnSimpan = $('#btn-simpan');
                btnSimpan.prop('disabled', true);
                btnSimpan.removeClass('btn-success').addClass('btn-secondary');
                btnSimpan.html('<i class="fas fa-check"></i> Sudah Terupdate');

                // HIDUPKAN LAGI JIKA ADA PERUBAHAN
                $('input, select, textarea').on('input change', function() {
                    btnSimpan.prop('disabled', false);
                    btnSimpan.removeClass('btn-secondary').addClass('btn-success');
                    btnSimpan.html('<i class="fas fa-save"></i> Update CTA');
                });
            @endif

            // Pop-up khusus kalau langsung Deal
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
            
            // 🔥 FORMAT INPUT RUPIAH OTOMATIS 🔥
            $('.input-rupiah').on('input', function() {
                let inputVal = $(this).val();
                
                // Hapus semua karakter selain angka
                let angkaString = inputVal.replace(/[^,\d]/g, '').toString();
                
                // Format jadi titik (Ribuan)
                let split = angkaString.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                // Tampilkan formatnya di layar user
                $(this).val(rupiah);

                // Kirim angka aslinya (tanpa titik) ke input Hidden untuk dikirim ke database
                let cleanNumber = angkaString.replace(/\./g, '');
                $(this).siblings('.input-real').val(cleanNumber);
            });

            // 🔥 LOGIKA JIKA GAGAL VALIDASI (ERROR) 🔥
            @if($errors->any())
                // Matikan loading di tombol kalau halamannya kereload karena error
                let btnError = $('#btn-simpan');
                btnError.prop('disabled', false);
                btnError.html('<i class="fas fa-save"></i> Update'); // Ganti text sesuai tombol edit

                // Munculkan Pop-up Error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Ada yang terlewat',
                    text: 'Silakan cek kembali kotak peringatan warna merah di atas form.',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Perbaiki Data',
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif
        });
    </script>
@endpush
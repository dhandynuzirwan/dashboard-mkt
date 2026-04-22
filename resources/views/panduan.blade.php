@extends('layouts.app') {{-- Sesuaikan dengan nama file master layout kamu --}}

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER & ACTIONS ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-1">Panduan Penggunaan Dashboard</h3>
                <h6 class="op-7 mb-0">Dokumentasi & Standar Operasional Prosedur</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0 d-flex gap-2">
                @if (auth()->user()->role === 'superadmin')
                    <button class="btn btn-warning btn-round fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUpdatePanduan">
                        <i class="fas fa-upload me-1"></i> Update Panduan
                    </button>
                @endif
                <a href="{{ asset('assets/pdf/panduan-dashboard.pdf') }}" class="btn btn-primary btn-round fw-bold shadow-sm" download="Panduan_Dashboard_Arsa.pdf">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </a>
            </div>
        </div>

        {{-- ================= PDF VIEWER CARD ================= --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <div class="card-title fw-bold">Buku Panduan Internal (PDF)</div>
                        <p class="card-category mb-0">Silakan scroll pada area dokumen di bawah ini untuk membaca panduan secara langsung.</p>
                    </div>
                    {{-- Tambahkan border-radius dan overflow-hidden agar iframe menyesuaikan bentuk card --}}
                    <div class="card-body p-0" style="height: 75vh; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; overflow: hidden;">
                        <iframe 
                            src="{{ asset('assets/pdf/panduan-dashboard.pdf') }}#toolbar=1&navpanes=0" 
                            width="100%" 
                            height="100%" 
                            style="border: none;"
                            title="Panduan Dashboard">
                            <p>Browser Anda tidak mendukung pratinjau PDF. Silakan klik tombol Download di atas.</p>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= MODAL UPDATE PANDUAN ================= --}}
@if (auth()->user()->role === 'superadmin')
<div class="modal fade" id="modalUpdatePanduan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-round border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-file-pdf text-danger me-2"></i> Update File Panduan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('panduan.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-4">
                    {{-- Info Alert --}}
                    <div class="alert alert-info shadow-sm rounded-3 border-start border-4 border-info small mb-4">
                        <div class="d-flex">
                            <i class="fas fa-info-circle fs-4 me-3 text-info"></i>
                            <div>
                                <strong>Catatan:</strong> Upload file PDF baru untuk menggantikan panduan yang lama. Pastikan format file adalah <strong>.pdf</strong>.
                            </div>
                        </div>
                    </div>
                    
                    {{-- Input File --}}
                    <div class="form-group px-0 m-0">
                        <label for="file_panduan" class="fw-bold mb-2">Pilih File Panduan Baru <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file_panduan" name="file_panduan" accept=".pdf" required>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light btn-round border fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-round fw-bold">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Simpan
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endif
@endsection
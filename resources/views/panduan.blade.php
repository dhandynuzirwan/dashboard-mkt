@extends('layouts.app') {{-- Sesuaikan dengan nama file master layout kamu (misal: layouts.master atau layouts.main) --}}

@section('content')
<div class="page-inner">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title">Panduan Penggunaan Dashboard</h4>
        
        <div class="d-flex gap-2">
            
            @if (auth()->user()->role === 'superadmin')
                <button class="btn btn-warning btn-round" data-bs-toggle="modal" data-bs-target="#modalUpdatePanduan">
                    <i class="fas fa-upload mr-2"></i> Update Panduan
                </button>
            @endif

            <a href="{{ asset('assets/pdf/panduan-dashboard.pdf') }}" class="btn btn-primary btn-round" download="Panduan_Dashboard_Arsa.pdf">
                <i class="fas fa-file-download mr-2"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Buku Panduan Internal (PDF)</div>
                    <div class="card-category">
                        Silakan scroll pada area dokumen di bawah ini untuk membaca panduan secara langsung.
                    </div>
                </div>
                <div class="card-body p-0"> {{-- p-0 agar PDF full mepet ke pinggir card --}}
                    <div class="embed-responsive" style="height: 75vh;"> 
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

@if (auth()->user()->role === 'superadmin')
<div class="modal fade" id="modalUpdatePanduan" tabindex="-1" aria-labelledby="modalUpdatePanduanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdatePanduanLabel">Update File Panduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panduan.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info small">
                        Upload file PDF baru untuk menggantikan panduan yang lama. Pastikan format file adalah <strong>.pdf</strong>.
                    </div>
                    <div class="form-group">
                        <label for="file_panduan">Pilih File Panduan Baru</label>
                        <input type="file" class="form-control" id="file_panduan" name="file_panduan" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload & Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
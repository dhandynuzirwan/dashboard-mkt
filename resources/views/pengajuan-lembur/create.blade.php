@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-5 pb-3 text-center">
                    <h4 class="fw-bolder mb-1 text-dark">Formulir Pengajuan Lembur</h4>
                    <p class="text-muted small mb-0">Isi detail lembur Anda di bawah ini.</p>
                </div>
                
                <div class="card-body p-4 p-md-5 pt-0">
                    <form action="{{ route('pengajuan-lembur.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Informasi Pemohon</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" name="jabatan" class="form-control" placeholder="Jabatan Anda" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small">Divisi <span class="text-danger">*</span></label>
                                    <input type="text" name="divisi" class="form-control" placeholder="Divisi Anda" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Detail Lembur</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Tugas yang Dikerjakan <span class="text-danger">*</span></label>
                                <textarea name="tugas" class="form-control" rows="3" placeholder="Deskripsikan tugas yang akan/sudah dikerjakan" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Selesai <span class="text-muted fw-normal">(Opsional)</span></label>
                                    <input type="date" name="tanggal_selesai" class="form-control">
                                    <small class="text-muted" style="font-size: 11px;">Isi jika lembur melewati pergantian hari.</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Informasi Tambahan</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Dukungan yang Dibutuhkan (Fasilitas) <span class="text-muted fw-normal">(Opsional)</span></label>
                                <textarea name="dukungan_fasilitas" class="form-control" rows="2" placeholder="Contoh: Makan malam, kendaraan operasional, dll."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan Lainnya <span class="text-muted fw-normal">(Opsional)</span></label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Informasi tambahan lain jika ada."></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('pengajuan-lembur.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="fas fa-paper-plane me-1"></i> Ajukan Lembur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

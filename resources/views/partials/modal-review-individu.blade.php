{{-- ================= MODAL REVIEW INDIVIDU (CLEAN UI & NATIVE KAI ADMIN) ================= --}}
<div class="modal fade" id="modalReviewIndividu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-round border-0 shadow-lg">
            
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
                <h5 class="modal-title fw-bold text-dark mb-0">
                    <i class="fas fa-clipboard-check text-primary me-2 fs-4 align-middle"></i> 
                    Verifikasi Berkas Individu
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 px-md-5 pt-4 pb-4">
                
                {{-- Info Peserta --}}
                <div class="d-flex flex-column flex-md-row justify-content-between bg-light p-4 rounded-3 mb-4 border border-light">
                    <div class="mb-3 mb-md-0">
                        <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Nama Peserta</p>
                        <h6 class="fw-bold text-dark mb-0 fs-5">Dhandy Nuzirwan</h6>
                    </div>
                    <div class="text-md-end">
                        <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Program Pelatihan</p>
                        <h6 class="fw-bold text-primary mb-0">Web Development Bootcamp</h6>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3">Kelengkapan Dokumen Persyaratan</h6>
                
                {{-- List Dokumen --}}
                <div class="table-responsive mb-4 overflow-visible">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="border-bottom">
                            <tr>
                                <th class="text-muted fw-bold pb-2" style="font-size: 12px;">DOKUMEN SYARAT</th>
                                <th class="text-muted fw-bold pb-2 text-center" width="90" style="font-size: 12px;">FILE</th>
                                <th class="text-muted fw-bold pb-2 text-end" width="160" style="font-size: 12px;">AKSI KELAYAKAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dokumens = [
                                    1 => 'Scan KTP Asli',
                                    2 => 'Scan Ijazah Terakhir',
                                    3 => 'Pas Foto Formal (BG Merah)',
                                    4 => 'Curriculum Vitae (CV)',
                                    5 => 'Surat Keterangan Kerja',
                                    6 => 'Laporan Kerja',
                                    7 => 'Uraian Jobdesk / SOP'
                                ];
                            @endphp

                            @foreach($dokumens as $key => $nama)
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        {{-- Menggunakan class avatar bawaan KaiAdmin --}}
                                        <div class="avatar avatar-xs me-3 flex-shrink-0">
                                            <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ $key }}</span>
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 14px;">{{ $nama }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <button class="btn btn-icon btn-round btn-light btn-sm text-primary shadow-sm" title="Lihat File">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                                <td class="py-3 text-end">
                                    <select class="form-select form-select-sm shadow-none fw-bold text-secondary" onchange="toggleCatatan(this, 'catatan-doc-{{$key}}')">
                                        <option value="pending" selected>🟡 Pending</option>
                                        <option value="approve">✔ Disetujui</option>
                                        <option value="reject">✖ Tolak/Revisi</option>
                                    </select>
                                </td>
                            </tr>
                            {{-- Row Catatan Penolakan --}}
                            <tr id="catatan-doc-{{$key}}" style="display: none;">
                                <td colspan="3" class="pt-0 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mt-2 px-2">
                                        <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                        <input type="text" class="form-control form-control-sm border-danger text-danger bg-white" placeholder="Tulis catatan revisi untuk dokumen ini...">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Penetapan Jadwal Pelatihan --}}
                <div class="border border-2 border-dashed p-4 rounded-3 bg-white mt-2">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-calendar-alt text-primary fs-4 me-2"></i>
                        <h6 class="fw-bold text-dark mb-0">Penetapan Jadwal Pelatihan</h6>
                    </div>
                    <p class="text-muted mb-3" style="font-size: 12px;">Tentukan tanggal jika seluruh dokumen di atas telah diverifikasi dan disetujui (ACC).</p>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Mulai Pelatihan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm text-dark fw-bold">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Estimasi Selesai</label>
                            <input type="date" class="form-control form-control-sm text-dark fw-bold">
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Footer Action --}}
            <div class="modal-footer border-0 px-4 px-md-5 py-4 bg-light" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <button type="button" class="btn btn-border btn-round fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-round fw-bold px-4" onclick="alert('Simulasi: Berkas dan jadwal pelatihan berhasil disimpan!')" data-bs-dismiss="modal">
                    <i class="fas fa-save me-1"></i> Simpan Hasil Verifikasi
                </button>
            </div>
            
        </div>
    </div>
</div>
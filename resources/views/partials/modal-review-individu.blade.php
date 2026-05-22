{{-- ================= MODAL REVIEW INDIVIDU (MODERN SAAS STYLE) ================= --}}
<div class="modal fade" id="modalReviewIndividu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
                <div class="d-flex align-items-center">
                    <div class="icon-modern bg-primary-subtle text-primary me-3" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h5 class="modal-title fw-bolder text-dark mb-0">Verifikasi Berkas Individu</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 px-md-5 pt-4 pb-4">
                
                {{-- Info Peserta (Soft Highlight) --}}
                <div class="bg-primary-subtle border border-primary-subtle p-4 rounded-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="mb-3 mb-md-0">
                        <p class="text-primary fw-bold mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">NAMA PESERTA</p>
                        <h5 class="fw-bolder text-dark mb-0">Dhandy Nuzirwan</h5>
                    </div>
                    <div class="text-md-end">
                        <p class="text-primary fw-bold mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">PROGRAM PELATIHAN</p>
                        <h6 class="fw-bold text-dark mb-0">Web Development Bootcamp</h6>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-end mb-3">
                    <h6 class="fw-bolder text-dark mb-0">Kelengkapan Dokumen Persyaratan</h6>
                    <span class="badge bg-light text-muted border">7 Dokumen</span>
                </div>
                
                {{-- List Dokumen (Modern Card List) --}}
                <div class="d-flex flex-column gap-3 mb-4">
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
                    <div class="p-3 border border-light rounded-4 bg-white shadow-sm hover-lift" style="transition: all 0.2s;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            
                            {{-- Sisi Kiri: Nama Dokumen --}}
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-muted fw-bold d-flex align-items-center justify-content-center rounded-circle me-3 border" style="width: 28px; height: 28px; font-size: 12px;">
                                    {{ $key }}
                                </div>
                                <span class="fw-bold text-dark" style="font-size: 14px;">{{ $nama }}</span>
                            </div>

                            {{-- Sisi Kanan: Aksi --}}
                            <div class="d-flex align-items-center gap-2">
                                {{-- Ganti Ikon Mata dengan Tombol "Cek Dokumen" --}}
                                <button class="btn btn-sm btn-light border fw-bold text-primary btn-round px-3 shadow-none">
                                    <i class="fas fa-file-contract me-1"></i> Cek File
                                </button>
                                
                                {{-- Dropdown Status yang lebih clean --}}
                                <select class="form-select form-select-sm border border-light bg-light shadow-none fw-bold text-muted btn-round" style="width: 140px; cursor: pointer;" onchange="toggleCatatan(this, 'catatan-doc-{{$key}}')">
                                    <option value="pending" selected>🟡 Pending</option>
                                    <option value="approve">🟢 Disetujui</option>
                                    <option value="reject">🔴 Revisi</option>
                                </select>
                            </div>
                        </div>

                        {{-- Area Catatan Revisi (Muncul otomatis ke bawah jika pilih Revisi) --}}
                        <div id="catatan-doc-{{$key}}" class="mt-3 pt-3 border-top border-light" style="display: none;">
                            <label class="fw-bold text-danger mb-2" style="font-size: 11px; text-transform: uppercase;">Catatan Revisi untuk Peserta</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-danger-subtle border-danger text-danger border-end-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-exclamation-circle"></i></span>
                                <input type="text" class="form-control border-danger border-start-0 shadow-none text-danger" placeholder="Contoh: KTP blur, mohon foto ulang di tempat terang..." style="border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Penetapan Jadwal Pelatihan --}}
                <div class="bg-light p-4 rounded-4 border border-light mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-sm bg-white text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm me-2" style="width: 32px; height: 32px;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h6 class="fw-bolder text-dark mb-0">Penetapan Jadwal Pelatihan</h6>
                    </div>
                    <p class="text-muted mb-3" style="font-size: 12px;">Tentukan tanggal jika seluruh dokumen di atas telah diverifikasi dan disetujui (ACC).</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="label-modern">Mulai Pelatihan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm input-modern text-dark fw-bold shadow-none">
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern">Estimasi Selesai</label>
                            <input type="date" class="form-control form-control-sm input-modern text-dark fw-bold shadow-none">
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Footer Action --}}
            <div class="modal-footer border-0 px-4 px-md-5 py-4 bg-white" style="border-radius: 0 0 20px 20px; box-shadow: 0 -4px 15px rgba(0,0,0,0.02);">
                <button type="button" class="btn btn-white border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary fw-bold px-4 btn-round shadow-sm hover-lift" onclick="alert('Simulasi: Berkas dan jadwal pelatihan berhasil disimpan!')" data-bs-dismiss="modal">
                    <i class="fas fa-save me-1"></i> Simpan Hasil Verifikasi
                </button>
            </div>
            
        </div>
    </div>
</div>
{{-- ================= MODAL REVIEW INDIVIDU (MODERN SAAS STYLE) ================= --}}
    <div class="modal fade" id="modalReviewIndividu-{{ $pendaftar->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                
                {{-- 🔥 FORM ACTION KE CONTROLLER 🔥 --}}
                <form action="{{ route('operational.pendaftaran.verify', $pendaftar->id) }}" method="POST">
                @csrf

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
                    
                    {{-- Info Peserta (Dinamis dari Database) --}}
                    <div class="bg-primary-subtle border border-primary-subtle p-4 rounded-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <p class="text-primary fw-bold mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">NAMA PESERTA</p>
                            <h5 class="fw-bolder text-dark mb-0">{{ $pendaftar->nama_lengkap }}</h5>
                            <small class="text-primary fw-bold">{{ $pendaftar->id_pendaftaran }}</small>
                        </div>
                        <div class="text-md-end">
                            <p class="text-primary fw-bold mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">PROGRAM PELATIHAN</p>
                            <h6 class="fw-bold text-dark mb-0">{{ $pendaftar->training->nama_training ?? 'Belum dipilih' }}</h6>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <h6 class="fw-bolder text-dark mb-0">Kelengkapan Dokumen Persyaratan</h6>
                        <span class="badge bg-light text-muted border">7 Dokumen</span>
                    </div>
                    
                    {{-- List Dokumen (Modern Card List & Looping Dinamis) --}}
                    <div class="d-flex flex-column gap-3 mb-4">
                        @php
                            // Mapping nama label dengan prefix kolom di database
                            $dokMap = [
                                'ktp'     => 'Scan KTP Asli',
                                'ijazah'  => 'Scan Ijazah Terakhir',
                                'foto'    => 'Pas Foto Formal (BG Merah)',
                                'cv'      => 'Curriculum Vitae (CV)',
                                'sk'      => 'Surat Keterangan Kerja',
                                'laporan' => 'Laporan Kerja',
                                'sop'     => 'Uraian Jobdesk / SOP'
                            ];
                            $no = 1;
                        @endphp

                        @foreach($dokMap as $field => $namaDoc)
                            @php
                                // Mengambil data secara dinamis dari object $pendaftar
                                $statusField  = 'status_' . $field;
                                $catatanField = 'catatan_' . $field;
                                $fileField    = 'file_' . $field;

                                $currStatus  = $pendaftar->$statusField;
                                $currCatatan = $pendaftar->$catatanField;
                                $filePath    = $pendaftar->$fileField;
                            @endphp

                        <div class="p-3 border border-light rounded-4 bg-white shadow-sm hover-lift" style="transition: all 0.2s;">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                
                                {{-- Sisi Kiri: Nama Dokumen --}}
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-muted fw-bold d-flex align-items-center justify-content-center rounded-circle me-3 border" style="width: 28px; height: 28px; font-size: 12px;">
                                        {{ $no++ }}
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $namaDoc }}</span>
                                </div>

                                {{-- Sisi Kanan: Aksi --}}
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Tombol Cek File (Link Asli ke Storage) --}}
                                    @if($filePath)
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-sm btn-light border fw-bold text-primary btn-round px-3 shadow-none">
                                            <i class="fas fa-file-contract me-1"></i> Cek File
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-sm btn-light border fw-bold text-muted btn-round px-3 shadow-none" disabled>
                                            Kosong
                                        </button>
                                    @endif
                                    
                                    {{-- Dropdown Status Dinamis --}}
                                    <select name="{{ $statusField }}" class="form-select form-select-sm border border-light bg-light shadow-none fw-bold text-muted btn-round {{ $currStatus == 'approve' ? 'border-success text-success' : ($currStatus == 'reject' ? 'border-danger text-danger' : '') }}" style="width: 140px; cursor: pointer;" onchange="toggleCatatan(this, 'catatan-{{ $field }}-{{ $pendaftar->id }}')">
                                        <option value="pending" {{ $currStatus == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                        <option value="approve" {{ $currStatus == 'approve' ? 'selected' : '' }}>🟢 Disetujui</option>
                                        <option value="reject" {{ $currStatus == 'reject' ? 'selected' : '' }}>🔴 Revisi</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Area Catatan Revisi Dinamis --}}
                            <div id="catatan-{{ $field }}-{{ $pendaftar->id }}" class="mt-3 pt-3 border-top border-light" style="display: {{ $currStatus == 'reject' ? 'block' : 'none' }};">
                                <label class="fw-bold text-danger mb-2" style="font-size: 11px; text-transform: uppercase;">Catatan Revisi untuk Peserta</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-danger-subtle border-danger text-danger border-end-0" style="border-radius: 8px 0 0 8px;"><i class="fas fa-exclamation-circle"></i></span>
                                    <input type="text" name="{{ $catatanField }}" value="{{ $currCatatan }}" class="form-control border-danger border-start-0 shadow-none text-danger" placeholder="Contoh: KTP blur, mohon foto ulang..." style="border-radius: 0 8px 8px 0;">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Input Tanggal Pelatihan (Opsional) --}}
                    <div class="bg-light p-3 rounded-4 border border-light">
                        <label class="fw-bold text-dark mb-2" style="font-size: 12px;">Penetapan Tanggal Pelatihan (Opsional)</label>
                        <p class="text-muted mb-2" style="font-size: 11px;">Jika Anda mengisi tanggal pelatihan ini, sistem akan otomatis mendaftarkan peserta ini ke dalam kelas "Pelatihan Berjalan". Kosongkan jika belum ada jadwal pasti.</p>
                        <input type="date" name="tanggal_pelatihan" value="{{ $pendaftar->tanggal_pelatihan }}" class="form-control form-control-sm border-light shadow-none" style="border-radius: 8px;">
                    </div>
                </div>
                
                {{-- Footer Action --}}
                <div class="modal-footer border-0 px-4 px-md-5 py-4 bg-white" style="border-radius: 0 0 20px 20px; box-shadow: 0 -4px 15px rgba(0,0,0,0.02);">
                    <button type="button" class="btn btn-white border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Tutup</button>
                    {{-- 🔥 UBAH TYPE JADI SUBMIT 🔥 --}}
                    <button type="submit" class="btn btn-primary fw-bold px-4 btn-round shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Simpan Hasil Verifikasi
                    </button>
                </div>
                
                </form> {{-- END FORM --}}
            </div>
        </div>
    </div>

    {{-- ================= AKHIR MODAL REVIEW INDIVIDU ================= --}}
{{-- ================= MODAL REVIEW KOLEKTIF / PERUSAHAAN (CLEAN UI & NATIVE KAI ADMIN) ================= --}}
<div class="modal fade" id="modalReviewKolektif-{{ $pendaftar->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('operational.pendaftaran.verify', $pendaftar->id) }}" method="POST" class="modal-content card-round border-0 shadow-lg">
            @csrf
            
            {{-- Header --}}
            <div class="modal-header border-0 pb-0 pt-4 px-4 px-md-5">
                <h5 class="modal-title fw-bold text-dark mb-0">
                    <i class="fas fa-building text-secondary me-2 fs-4 align-middle"></i> 
                    Verifikasi Berkas Kolektif (Instansi)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 px-md-5 pt-4 pb-4">
                
                {{-- Info Peserta & Instansi --}}
                <div class="d-flex flex-column flex-md-row justify-content-between bg-light p-4 rounded-3 mb-4 border border-light">
                    <div class="mb-3 mb-md-0">
                        <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Nama Peserta</p>
                        <h6 class="fw-bold text-dark mb-1 fs-5">{{ $pendaftar->nama_lengkap }}</h6>
                        <span class="badge badge-primary">{{ $pendaftar->training->nama_training ?? 'Belum dipilih' }}</span>
                    </div>
                    <div class="text-md-end">
                        <p class="text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Asal Instansi</p>
                        <h6 class="fw-bold text-secondary mb-1">{{ $pendaftar->kolektif->nama_perusahaan ?? '-' }}</h6>
                        <p class="text-muted fw-medium mb-0" style="font-size: 12px;"><i class="fab fa-whatsapp text-success me-1"></i> PIC: {{ $pendaftar->kolektif->no_wa_pic ?? '-' }}</p>
                    </div>
                </div>

                {{-- BOX DOWNLOAD ZIP (Penting) --}}
                @if($pendaftar->kolektif && $pendaftar->kolektif->file_zip)
                <div class="alert alert-secondary d-flex align-items-center p-4 rounded-3 mb-4 border-0 shadow-sm">
                    <i class="fas fa-file-archive fa-2x text-secondary me-3 opacity-75"></i>
                    <div>
                        <p class="mb-1 fw-bold text-dark" style="font-size: 13px;">Penting: Dokumen Fisik Ada di File ZIP Perusahaan.</p>
                        <p class="mb-3 text-muted" style="font-size: 12px;">Silakan unduh untuk mengecek kelengkapan dokumen persyaratan milik {{ $pendaftar->nama_lengkap }}.</p>
                        <a href="{{ asset('storage/' . $pendaftar->kolektif->file_zip) }}" target="_blank" class="btn btn-secondary btn-sm btn-round fw-bold shadow-sm">
                            <i class="fas fa-download me-1"></i> Unduh ZIP
                        </a>
                    </div>
                </div>
                @else
                <div class="alert alert-warning d-flex align-items-center p-4 rounded-3 mb-4 border-0 shadow-sm">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning me-3 opacity-75"></i>
                    <div>
                        <p class="mb-1 fw-bold text-dark" style="font-size: 13px;">Belum Ada File ZIP!</p>
                        <p class="mb-0 text-muted" style="font-size: 12px;">PIC Perusahaan belum mengunggah file ZIP persyaratan.</p>
                    </div>
                </div>
                @endif

                <h6 class="fw-bold text-dark mb-3">Status Kelengkapan 7 Dokumen (Di dalam ZIP)</h6>
                
                {{-- List Dokumen (Clean Borderless Table) --}}
                <div class="table-responsive mb-4 overflow-visible">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="border-bottom">
                            <tr>
                                <th class="text-muted fw-bold pb-2" style="font-size: 12px;">DOKUMEN SYARAT</th>
                                <th class="text-muted fw-bold pb-2 text-end" width="160" style="font-size: 12px;">AKSI KELAYAKAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
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
                                    $statusField  = 'status_' . $field;
                                    $catatanField = 'catatan_' . $field;

                                    $currStatus  = $pendaftar->$statusField;
                                    $currCatatan = $pendaftar->$catatanField;
                                @endphp
                                <tr class="border-bottom">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-3 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-secondary-gradient fw-bold">{{ $no++ }}</span>
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size: 14px;">{{ $namaDoc }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end">
                                        <select name="{{ $statusField }}" class="form-select form-select-sm shadow-none fw-bold {{ $currStatus == 'approve' ? 'border-success text-success' : ($currStatus == 'reject' ? 'border-danger text-danger' : 'border-warning text-warning') }}" onchange="toggleCatatan(this, 'catatan-{{ $field }}-kol-{{ $pendaftar->id }}')">
                                            <option value="pending" {{ $currStatus == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                            <option value="approve" {{ $currStatus == 'approve' ? 'selected' : '' }}>🟢 Disetujui</option>
                                            <option value="reject" {{ $currStatus == 'reject' ? 'selected' : '' }}>🔴 Tolak/Revisi</option>
                                        </select>
                                    </td>
                                </tr>
                                {{-- Row Catatan Penolakan --}}
                                <tr id="catatan-{{ $field }}-kol-{{ $pendaftar->id }}" style="display: {{ $currStatus == 'reject' ? 'table-row' : 'none' }};">
                                    <td colspan="2" class="pt-0 pb-3 border-bottom">
                                        <div class="d-flex align-items-start mt-2 px-2">
                                            <i class="fas fa-exclamation-circle text-danger mt-1 me-2"></i>
                                            <div class="w-100">
                                                <input type="text" name="{{ $catatanField }}" class="form-control form-control-sm border-danger text-danger bg-white" placeholder="Alasan penolakan..." value="{{ $currCatatan }}">
                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Info ini akan muncul di Dashboard PIC Perusahaan.</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @php
                    $tglPelatihan = $pendaftar->pelatihanBerjalan->tanggal_pelatihan ?? null;
                    if (!$tglPelatihan && $pendaftar->tipe_pendaftaran == 'kolektif') {
                        $other = \App\Models\PendaftaranPribadi::where('kolektif_id', $pendaftar->kolektif_id)
                            ->where('master_training_id', $pendaftar->master_training_id)
                            ->whereNotNull('pelatihan_berjalan_id')
                            ->with('pelatihanBerjalan')
                            ->first();
                        if ($other && $other->pelatihanBerjalan) {
                            $tglPelatihan = $other->pelatihanBerjalan->tanggal_pelatihan;
                        }
                    }
                    $tglFormat = $tglPelatihan ? \Carbon\Carbon::parse($tglPelatihan)->format('Y-m-d') : '';
                @endphp
                {{-- Penetapan Jadwal Pelatihan (Dashed Box) --}}
                <div class="border border-2 border-dashed p-4 rounded-3 bg-white mt-2">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-calendar-alt text-secondary fs-4 me-2"></i>
                        <h6 class="fw-bold text-dark mb-0">Penetapan Jadwal Pelatihan</h6>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-muted fw-bold mb-1" style="font-size: 11px; text-transform: uppercase;">Mulai Pelatihan (Opsional)</label>
                            <input type="date" name="tanggal_pelatihan" value="{{ $tglFormat }}" class="form-control form-control-sm text-dark fw-bold">
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Footer Action --}}
            <div class="modal-footer border-0 px-4 px-md-5 py-4 bg-light" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                <button type="button" class="btn btn-border btn-round fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-secondary btn-round fw-bold px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Simpan Status
                </button>
            </div>
            
        </form>
    </div>
</div>
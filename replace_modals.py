import re

with open(r'c:\laragon\www\dashboard-mkt\resources\views\operational\monitoring-pelatihan.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# We want to replace everything from {{-- ================= MODAL UPDATE VALIDASI CHECKLIST ================= --}}
# down to just before {{-- ================= STYLES ================= --}}
start_marker = r'{{-- ================= MODAL UPDATE VALIDASI CHECKLIST ================= --}}'
end_marker = r'{{-- ================= STYLES ================= --}}'

start_idx = content.find(start_marker)
end_idx = content.find(end_marker)

modals_replacement = r'''@foreach($pelatihans as $pelatihan)
{{-- ================= MODAL UPDATE VALIDASI CHECKLIST ================= --}}
<div class="modal fade" id="modalUpdateValidasi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom pb-3 pt-4 px-4 px-md-5 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-dark mb-0">Update Validasi Checklist</h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">Klien: <strong class="text-dark">{{ $pelatihan->pendaftaranPribadis->first()->perusahaan ?? 'Pribadi' }}</strong> | Program: <strong>{{ $pelatihan->training->name ?? '-' }}</strong></p>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 px-md-5 pt-4 pb-4" style="background-color: #f8fafc;">
                    @php $checklist = json_decode($pelatihan->checklist_validasi, true) ?? []; @endphp
                    <div class="row g-4">
                        {{-- Kategori 1: Administrasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-folder-open text-warning me-2"></i> 1. Administrasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Persyaratan Peserta" {{ in_array('Persyaratan Peserta', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Persyaratan Peserta</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="E Certificate" {{ in_array('E Certificate', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">E Certificate</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Form Evaluasi" {{ in_array('Form Evaluasi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Form Evaluasi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Review Google" {{ in_array('Review Google', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Review Google</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 2: Online Support --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-laptop-house text-info me-2"></i> 2. Online Support / Fasilitas</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Materi" {{ in_array('Link Zoom Materi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Materi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Link Zoom Asesment" {{ in_array('Link Zoom Asesment', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Link Zoom / Lokasi Asesment</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Background Zoom" {{ in_array('Background Zoom', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Background Zoom / Banner</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Profil Grup WA" {{ in_array('Foto Profil Grup WA', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Profil Grup WA</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 3: Komunikasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-comments text-success me-2"></i> 3. Komunikasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Peserta" {{ in_array('Hubungi Peserta', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Peserta</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Instruktur" {{ in_array('Hubungi Instruktur', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Instruktur</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Hubungi Asesor" {{ in_array('Hubungi Asesor', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Hubungi Asesor</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Buat Grup WA" {{ in_array('Buat Grup WA', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Buat Grup WA</label></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Materi" {{ in_array('Share Link Zoom Materi', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Materi</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Link Zoom Asesment" {{ in_array('Share Link Zoom Asesment', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Lokasi/Zoom Asesment</label></div>
                                            <div class="form-check custom-checkbox mb-2"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Form Evaluasi" {{ in_array('Share Form Evaluasi', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Form Evaluasi</label></div>
                                            <div class="form-check custom-checkbox mb-0"><input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Share Sertifikat" {{ in_array('Share Sertifikat', $checklist) ? 'checked' : '' }}><label class="form-check-label text-dark small fw-medium">Share Sertifikat</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kategori 4: Dokumentasi --}}
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm h-100" style="border-radius: 16px;">
                                <div class="card-header bg-white border-bottom py-3" style="border-radius: 16px 16px 0 0;">
                                    <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-camera text-danger me-2"></i> 4. Dokumentasi</h6>
                                </div>
                                <div class="card-body px-4 py-3">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Kompeten" {{ in_array('Foto Kompeten', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Kompeten</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto K3" {{ in_array('Foto K3', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto K3</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Formal" {{ in_array('Foto Formal', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Formal</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Foto Materi" {{ in_array('Foto Materi', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Foto Materi</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="checkbox" name="checklist_validasi[]" value="Record Zoom" {{ in_array('Record Zoom', $checklist) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark small fw-medium">Record Zoom / Daftar Hadir</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top px-4 px-md-5 py-3 bg-white" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-white border fw-bold px-4 btn-round hover-lift text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 btn-round shadow-sm hover-lift">
                        <i class="fas fa-save me-1"></i> Simpan Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD LAPORAN --}}
<div class="modal fade" id="modalUploadLaporan-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 18px; border-radius: 10px;">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div><h5 class="modal-title fw-bolder text-dark mb-0">Upload Laporan</h5></div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Laporan Internal <span class="text-danger">*</span></label>
                    <input type="file" name="file_laporan_internal" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Laporan Instansi Kemnaker/BNSP</label>
                    <input type="file" name="file_laporan_kemnaker" class="form-control input-modern shadow-none" accept=".pdf,.doc,.docx,.zip,.rar">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-info text-white fw-bold btn-round w-100 shadow-sm">Upload File</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPDATE EVALUASI --}}
<div class="modal fade" id="modalUpdateEvaluasi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-comment-dots text-warning me-2"></i> Catatan Evaluasi</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Evaluasi Pelaksanaan</label>
                <textarea name="evaluasi" class="form-control input-modern shadow-none" rows="4" placeholder="Masukkan catatan evaluasi pelaksanaan kelas ini...">{{ $pelatihan->evaluasi }}</textarea>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-warning text-dark fw-bold btn-round w-100 shadow-sm">Simpan Evaluasi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPDATE STATUS SERTIFIKAT --}}
<div class="modal fade" id="modalUpdateStatusSertif-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-award text-success me-2"></i> Update Status Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Status Saat Ini</label>
                    <select name="status_sertifikat" class="form-select input-modern shadow-none">
                        <option value="OGP" {{ $pelatihan->status_sertifikat == 'OGP' ? 'selected' : '' }}>⚙️ On Going Process (OGP)</option>
                        <option value="Delay" {{ $pelatihan->status_sertifikat == 'Delay' ? 'selected' : '' }}>⚠️ Delay / Terhambat</option>
                        <option value="Terbit" {{ $pelatihan->status_sertifikat == 'Terbit' ? 'selected' : '' }}>✅ Terbit / Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Estimasi Terbit</label>
                    <input type="date" name="estimasi_terbit" value="{{ $pelatihan->estimasi_terbit }}" class="form-control input-modern shadow-none">
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="label-modern text-success">Tanggal Terima Real</label>
                        <input type="date" name="tgl_terima_lembaga" value="{{ $pelatihan->tgl_terima_lembaga }}" class="form-control input-modern shadow-none">
                    </div>
                    <div class="col-6">
                        <label class="label-modern text-primary">Tanggal Kirim Klien</label>
                        <input type="date" name="tgl_kirim_klien" value="{{ $pelatihan->tgl_kirim_klien }}" class="form-control input-modern shadow-none">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Status</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPLOAD SCAN SERTIFIKAT --}}
<div class="modal fade" id="modalUploadScanSertif-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-pdf text-info me-2"></i> Upload Scan Sertifikat</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <label class="label-modern">Pilih File (PDF/Zip)</label>
                <input type="file" name="file_scan_sertifikat" class="form-control input-modern shadow-none" accept=".pdf,.zip,.rar" required>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-info text-white fw-bold btn-round w-100 shadow-sm">Upload Scan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL INPUT RESI PENGIRIMAN --}}
<div class="modal fade" id="modalUpdateResi-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-truck-loading text-primary me-2"></i> Input Resi & Pengiriman</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-3">
                    <label class="label-modern">Kurir / Ekspedisi</label>
                    <select name="ekspedisi" class="form-select input-modern shadow-none">
                        <option value="JNE" {{ $pelatihan->ekspedisi == 'JNE' ? 'selected' : '' }}>JNE</option>
                        <option value="J&T" {{ $pelatihan->ekspedisi == 'J&T' ? 'selected' : '' }}>J&T</option>
                        <option value="SiCepat" {{ $pelatihan->ekspedisi == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                        <option value="Pos Indonesia" {{ $pelatihan->ekspedisi == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                        <option value="Kurir Internal" {{ $pelatihan->ekspedisi == 'Kurir Internal' ? 'selected' : '' }}>Kurir Internal ARSA</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label-modern">Nomor Resi / Pelacakan</label>
                    <input type="text" name="resi_pengiriman" value="{{ $pelatihan->resi_pengiriman }}" class="form-control input-modern shadow-none fw-bold">
                </div>
                <div class="mb-0">
                    <label class="label-modern">Upload Foto Resi Fisik (Opsional)</label>
                    <input type="file" name="foto_resi" class="form-control input-modern shadow-none" accept="image/*">
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-primary text-white fw-bold btn-round w-100 shadow-sm">Simpan Resi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UPLOAD TANDA TERIMA --}}
<div class="modal fade" id="modalUploadTandaTerima-{{ $pelatihan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('monitoring.pelatihan.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-bottom pb-3 pt-4 px-4 bg-light" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bolder text-dark"><i class="fas fa-file-signature text-success me-2"></i> Upload Tanda Terima</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-4 pb-4">
                <div class="mb-0">
                    <label class="label-modern">Upload Foto / Scan TTD</label>
                    <input type="file" name="foto_tanda_terima" class="form-control input-modern shadow-none" accept="image/*,.pdf" required>
                </div>
            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 20px 20px;">
                <button type="submit" class="btn btn-success text-white fw-bold btn-round w-100 shadow-sm">Simpan Tanda Terima</button>
            </div>
        </form>
    </div>
</div>
@endforeach

'''

new_content = content[:start_idx] + modals_replacement + content[end_idx:]

with open(r'c:\laragon\www\dashboard-mkt\resources\views\operational\monitoring-pelatihan.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)

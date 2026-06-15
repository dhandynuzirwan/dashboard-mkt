import re

with open(r'c:\laragon\www\dashboard-mkt\resources\views\operational\monitoring-pelatihan.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace Tab 2 body
tab2_body = r'''                                <tbody>
                                    @forelse($pelatihans as $pelatihan)
                                        @php
                                            $klien = $pelatihan->pendaftaranPribadis->first()->perusahaan ?? 'Pribadi';
                                            $checklist = json_decode($pelatihan->checklist_validasi, true) ?? [];
                                            $progress = count($checklist);
                                            $percent = $progress > 0 ? round(($progress / 21) * 100) : 0;
                                            $percentColor = $percent == 100 ? 'primary' : 'warning';
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">{{ $klien }}</div>
                                                <div class="text-muted fw-bold mt-1" style="font-size: 12px;">{{ $pelatihan->training->name ?? '-' }}</div>
                                                <span class="badge badge-soft-primary border mt-2">{{ $pelatihan->training->sertifikasi ?? 'Lainnya' }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="text-dark fw-bold" style="font-size: 11px;">Progress Checklist</span>
                                                    <span class="text-{{ $percentColor }} fw-bolder" style="font-size: 11px;">{{ $percent }}% ({{ $progress }}/21)</span>
                                                </div>
                                                <div class="progress bg-light border mb-2 shadow-none" style="height: 8px; border-radius: 10px;">
                                                    <div class="progress-bar bg-{{ $percentColor }} {{ $percent == 100 ? 'rounded-pill' : '' }}" style="width: {{ $percent }}%"></div>
                                                </div>
                                                <div class="d-flex gap-2 mt-2">
                                                    <button class="btn btn-sm btn-white border btn-round fw-bold text-dark flex-grow-1 shadow-sm hover-lift" data-bs-toggle="modal" data-bs-target="#modalUpdateValidasi-{{ $pelatihan->id }}" style="font-size: 11px;">
                                                        <i class="fas fa-check-square me-1"></i> Update Checklist
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">
                                                    @if($pelatihan->file_laporan_internal)
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ asset($pelatihan->file_laporan_internal) }}" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1" style="color: #0ea5e9;">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Internal
                                                        </a>
                                                        <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    @else
                                                    <button class="btn btn-sm btn-white text-primary text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bfdbfe;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Internal
                                                    </button>
                                                    @endif

                                                    @if($pelatihan->file_laporan_kemnaker)
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ asset($pelatihan->file_laporan_kemnaker) }}" target="_blank" class="btn btn-sm btn-light border text-start fw-bold hover-lift flex-grow-1 text-success">
                                                            <i class="fas fa-check-circle me-1"></i> Lap. Instansi
                                                        </a>
                                                        <button class="btn btn-sm btn-white border text-muted hover-lift px-2" title="Ganti File" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}"><i class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                    @else
                                                    <button class="btn btn-sm btn-white text-success text-start fw-bold hover-lift w-100" style="border: 1.5px dashed #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalUploadLaporan-{{ $pelatihan->id }}">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Lap. Instansi
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($pelatihan->evaluasi)
                                                <div class="bg-gray-50 border p-3 rounded-4 position-relative">
                                                    <p class="mb-0 text-dark small" style="white-space: normal; line-height: 1.6;">
                                                        <i class="fas fa-comment-dots text-muted me-1"></i> {{ Str::limit($pelatihan->evaluasi, 100) }}
                                                    </p>
                                                    <button class="btn btn-sm btn-link text-muted position-absolute top-0 end-0 mt-1 me-1 p-1" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-{{ $pelatihan->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                </div>
                                                @else
                                                <div class="bg-light border border-dashed p-3 rounded-4 text-center">
                                                    <p class="mb-2 text-muted small fw-bold">Belum ada evaluasi pelaksanaan.</p>
                                                    <button class="btn btn-sm btn-white border btn-round shadow-sm hover-lift text-dark fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalUpdateEvaluasi-{{ $pelatihan->id }}">
                                                        <i class="fas fa-pen me-1"></i> Tulis Evaluasi
                                                    </button>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>'''

# Replace Tab 3 body
tab3_body = r'''                                <tbody>
                                    @forelse($pelatihans as $pelatihan)
                                        @php
                                            $klien = $pelatihan->pendaftaranPribadis->first()->perusahaan ?? 'Pribadi';
                                            $picInfo = $pelatihan->pic_klien ?? 'Belum ditentukan';
                                            
                                            $badgeSertif = 'secondary';
                                            $iconSertif = 'hourglass-half';
                                            if($pelatihan->status_sertifikat == 'Terbit') { $badgeSertif = 'success'; $iconSertif = 'check-circle'; }
                                            elseif($pelatihan->status_sertifikat == 'Delay') { $badgeSertif = 'warning'; $iconSertif = 'exclamation-triangle'; }
                                            elseif($pelatihan->status_sertifikat == 'OGP') { $badgeSertif = 'primary'; $iconSertif = 'cog fa-spin'; }
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bolder text-dark" style="font-size: 14px;">{{ $klien }}</div>
                                                <div class="text-muted fw-bold mt-1" style="font-size: 12px;">{{ $pelatihan->training->name ?? '-' }}</div>
                                                <div class="text-primary small fw-bold mt-1"><i class="fas fa-user-tie me-1"></i> {{ $picInfo }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-soft-{{ $badgeSertif }} border border-{{ $badgeSertif }} text-{{ $badgeSertif == 'warning' ? 'dark' : $badgeSertif }} px-4 py-2 rounded-pill shadow-sm" style="font-size: 11px;">
                                                    <i class="fas fa-{{ $iconSertif }} me-1"></i> {{ $pelatihan->status_sertifikat ?? 'OGP' }}
                                                </span>
                                                <button class="btn btn-sm btn-white border btn-round text-muted d-block mx-auto mt-2 hover-lift px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUpdateStatusSertif-{{ $pelatihan->id }}">Ubah Status</button>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2" style="font-size: 11px;">
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Estimasi Terbit:</span>
                                                        <span class="fw-bold text-dark">{{ $pelatihan->estimasi_terbit ? \Carbon\Carbon::parse($pelatihan->estimasi_terbit)->format('d M Y') : '-' }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-1">
                                                        <span class="text-muted">Terima Dr Lembaga:</span>
                                                        @if($pelatihan->tgl_terima_lembaga)
                                                            <span class="fw-bold text-success">{{ \Carbon\Carbon::parse($pelatihan->tgl_terima_lembaga)->format('d M Y') }}</span>
                                                        @else
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Kirim Ke Klien:</span>
                                                        @if($pelatihan->tgl_kirim_klien)
                                                            <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($pelatihan->tgl_kirim_klien)->format('d M Y') }}</span>
                                                        @else
                                                            <span class="badge bg-light text-muted border" style="font-size: 9px;">Menunggu</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($pelatihan->file_scan_sertifikat)
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ asset($pelatihan->file_scan_sertifikat) }}" target="_blank" class="btn btn-sm btn-light border text-info fw-bold btn-round shadow-sm hover-lift w-100">
                                                        <i class="fas fa-file-pdf me-1"></i> Lihat Scan
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-{{ $pelatihan->id }}">Ganti File</button>
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-info fw-bold btn-round shadow-sm hover-lift w-100" style="border: 1.5px dashed #7dd3fc;" data-bs-toggle="modal" data-bs-target="#modalUploadScanSertif-{{ $pelatihan->id }}">
                                                    <i class="fas fa-cloud-upload-alt me-1"></i> Upload Scan
                                                </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if($pelatihan->resi_pengiriman)
                                                <div class="bg-gray-50 border p-2 rounded-3 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <span class="badge badge-soft-danger border border-danger mb-1 fw-bold">{{ $pelatihan->ekspedisi ?? 'EKSPEDISI' }}</span>
                                                            <span class="fw-bolder text-dark d-block" style="letter-spacing: 1px; font-size: 13px;">{{ $pelatihan->resi_pengiriman }}</span>
                                                        </div>
                                                        <button class="btn btn-sm btn-white border text-muted px-2 py-1 hover-lift" title="Edit Resi" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-{{ $pelatihan->id }}"><i class="fas fa-pen"></i></button>
                                                    </div>
                                                    @if($pelatihan->foto_resi)
                                                    <a href="{{ asset($pelatihan->foto_resi) }}" target="_blank" class="badge bg-white text-primary border border-primary text-decoration-none shadow-sm px-2 py-1 w-100 text-center hover-lift">
                                                        <i class="fas fa-camera me-1"></i> Foto Resi Fisik
                                                    </a>
                                                    @endif
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-primary fw-bold rounded-3 shadow-sm hover-lift w-100 py-3" style="border: 1.5px dashed #93c5fd;" data-bs-toggle="modal" data-bs-target="#modalUpdateResi-{{ $pelatihan->id }}">
                                                    <i class="fas fa-truck-loading me-1"></i> Input Resi
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($pelatihan->foto_tanda_terima)
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ asset($pelatihan->foto_tanda_terima) }}" target="_blank" class="btn btn-sm btn-success text-white btn-round shadow-sm hover-lift w-100 fw-bold">
                                                        <i class="fas fa-image me-1"></i> TTD
                                                    </a>
                                                    <button class="btn btn-sm btn-white border text-muted btn-round hover-lift w-100" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-{{ $pelatihan->id }}">Ganti Foto</button>
                                                </div>
                                                @else
                                                <button class="btn btn-sm btn-white text-success fw-bold btn-round shadow-sm hover-lift w-100 py-2" style="border: 1.5px dashed #86efac;" data-bs-toggle="modal" data-bs-target="#modalUploadTandaTerima-{{ $pelatihan->id }}">
                                                    <i class="fas fa-upload me-1"></i> Upload Bukti
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pelatihan berjalan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>'''

content = re.sub(r'<th width="350">Evaluasi Pelaksanaan</th>\s*</tr>\s*</thead>\s*<tbody>.*?</tbody>', 
                 lambda m: '<th width="350">Evaluasi Pelaksanaan</th>\n                                    </tr>\n                                </thead>\n' + tab2_body, 
                 content, flags=re.DOTALL)

content = re.sub(r'<th class="text-center pe-4" width="180">Tanda Terima</th>\s*</tr>\s*</thead>\s*<tbody>.*?</tbody>', 
                 lambda m: '<th class="text-center pe-4" width="180">Tanda Terima</th>\n                                    </tr>\n                                </thead>\n' + tab3_body, 
                 content, flags=re.DOTALL)

with open(r'c:\laragon\www\dashboard-mkt\resources\views\operational\monitoring-pelatihan.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

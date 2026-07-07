<div class="table-responsive">
    <table class="table table-hover table-borderless align-middle border-start border-end border-bottom rounded-3 overflow-hidden shadow-sm" style="font-size: 13px;">
        <thead class="bg-light text-secondary" style="border-bottom: 2px solid #e9ecef;">
            <tr>
                <th class="ps-4 py-3" width="25%">INFO PROSPEK</th>
                <th width="35%">DETAIL PELATIHAN</th>
                <th width="25%">NILAI PENAWARAN</th>
                <th class="text-center py-3" width="15%">STATUS</th>
            </tr>
        </thead>
        @php
            // 1. FILTER CERDAS: Hanya ambil data yang harga_penawarannya sudah diisi dan lebih dari 0
            $filteredDetails = $details->filter(function($d) {
                return !empty($d->harga_penawaran) && $d->harga_penawaran > 0;
            }); 
            
            // 2. Hitung Grand Total otomatis
            $grandTotal = $filteredDetails->sum(function($d) {
                return $d->harga_penawaran * ($d->jumlah_peserta ?? 1);
            });
        @endphp
        <tbody>
            {{-- Loop data yang sudah difilter (Hanya yang punya harga) --}}
            @forelse($filteredDetails as $d)
                <tr class="border-bottom">
                    
                    {{-- Kolom 1: Perusahaan & Tanggal --}}
                    <td class="ps-4 py-3">
                        <div class="fw-bold text-dark" style="font-size: 14px;">{{ $d->prospek->perusahaan ?? 'N/A' }}</div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i> 
                            {{ $d->prospek && $d->prospek->tanggal_prospek ? \Carbon\Carbon::parse($d->prospek->tanggal_prospek)->format('d M Y') : 'Tanggal tidak tersedia' }}
                        </small>
                    </td>

                    {{-- Kolom 2: Judul Permintaan, Skema, Sertifikasi, Tanggal Pelaksanaan --}}
                    <td class="py-3">
                        <div class="fw-bold text-primary mb-1">{{ $d->judul_permintaan ?? 'Tanpa Judul' }}</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            @if($d->sertifikasi)
                                <span class="badge bg-info text-white shadow-sm" style="font-size: 10px;">{{ strtoupper($d->sertifikasi) }}</span>
                            @endif
                            <span class="text-muted fw-medium text-truncate" style="max-width: 250px; font-size: 11px;">
                                <i class="fas fa-tags me-1"></i> {{ $d->skema ?? 'Tanpa Skema' }}
                            </span>
                        </div>
                        <div class="mt-1">
                            <span class="text-muted" style="font-size: 11px;"><i class="fas fa-calendar-check me-1"></i> Tgl Pelaksanaan: <span class="text-dark">{{ $d->tanggal_pelaksanaan ? \Carbon\Carbon::parse($d->tanggal_pelaksanaan)->format('d M Y') : '-' }}</span></span>
                        </div>
                    </td>

                    {{-- Kolom 3: Harga, Peserta, Vendor & Total --}}
                    <td class="py-3">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Harga/Pax:</span>
                                <span class="fw-medium text-dark">Rp {{ number_format($d->harga_penawaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Harga Vendor:</span>
                                <span class="fw-medium text-danger">Rp {{ number_format($d->harga_vendor ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Peserta:</span>
                                <span class="fw-medium text-dark"><i class="fas fa-users me-1 text-muted"></i> {{ $d->jumlah_peserta ?? 1 }} Org</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-1 mt-1">
                                <span class="fw-bold text-dark">Total Penawaran:</span>
                                <span class="fw-bold text-success" style="font-size: 14px;">Rp {{ number_format($d->harga_penawaran * ($d->jumlah_peserta ?? 1), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Kolom 4: Status Penawaran --}}
                    <td class="text-center py-3">
                        @php
                            $status_labels = [
                                'under_review' => ['label' => 'Under Review', 'class' => 'bg-info text-white'],
                                'hold'         => ['label' => 'Hold', 'class' => 'bg-warning text-dark'],
                                'kalah_harga'  => ['label' => 'Kalah Harga', 'class' => 'bg-danger'],
                                'cancel'       => ['label' => 'Cancel', 'class' => 'bg-danger'],
                                'deal'         => ['label' => 'Deal', 'class' => 'bg-success'],
                            ];
                            
                            $statusKey = strtolower($d->status_penawaran ?? '');
                            $current_status = $status_labels[$statusKey] ?? [
                                'label' => empty($d->status_penawaran) ? 'BELUM ADA STATUS' : ucwords(str_replace('_', ' ', $d->status_penawaran)), 
                                'class' => 'bg-secondary'
                            ];
                        @endphp

                        <span class="badge {{ $current_status['class'] }} px-3 py-2 shadow-sm" style="border-radius: 6px; letter-spacing: 0.5px;">
                            {{ $current_status['label'] }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted bg-light">
                        <i class="fas fa-file-invoice-dollar fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                        <p class="mb-0 fw-medium">Tidak ada data yang sudah diisi nominal penawarannya.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
        
        {{-- 🔥 BARIS GRAND TOTAL 🔥 --}}
        @if($filteredDetails->count() > 0)
        <tfoot class="bg-light" style="border-top: 2px solid #e2e8f0;">
            <tr>
                <td colspan="2" class="text-end py-3 pe-4 fw-bolder text-dark" style="font-size: 13px;">
                    TOTAL NILAI PENAWARAN:
                </td>
                <td colspan="2" class="py-3 text-start">
                    <span class="fw-bolder text-success px-3 py-2 bg-success-subtle rounded-3 border border-success-subtle shadow-sm" style="font-size: 16px;">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </span>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
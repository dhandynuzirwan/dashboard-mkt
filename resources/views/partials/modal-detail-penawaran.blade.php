<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th>Tanggal</th>
                <th>Perusahaan</th>
                <th>Sertifikasi</th>
                <th>Skema</th>
                <th>Harga Penawaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $d)
                <tr>
                    <td>{{ $d->created_at->format('d/m/Y') }}</td>
                    <td>{{ $d->prospek->perusahaan ?? 'N/A' }}</td>
                    <td>{{ $d->sertifikasi }}</td>
                    <td>{{ $d->skema }}</td>
                    <td class="text-end">Rp {{ number_format($d->harga_penawaran, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $statusClass = match (strtolower($d->status_penawaran)) {
                                'under_review' => 'badge-info',
                                'deal' => 'badge-success',
                                'hold' => 'badge-warning',
                                'kalah_harga' => 'badge-danger',
                                default => 'badge-secondary',
                            };
                        @endphp

                        <span class="badge {{ $statusClass }}">
                            {{ $d->status_penawaran }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data penawaran dalam periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

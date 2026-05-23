@forelse ($prospeks as $index => $p)
    <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_prospek)->format('d M Y') }}</td>
        <td class="fw-bold text-dark">{{ $p->perusahaan }}</td>
        <td>
            <div class="fw-medium">{{ $p->pic }}</div>
            <small class="text-muted" style="font-size: 11px;">{{ $p->jabatan ?? '-' }}</small>
        </td>
        <td class="text-center">
            {{-- Sesuaikan route ini dengan yang Anda miliki --}}
            <a href="{{ route('form-cta', $p->id) }}" class="btn btn-sm btn-primary btn-round shadow-sm hover-lift px-3">
                Lihat CTA
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <i class="fas fa-folder-open fs-2 mb-2 opacity-50 d-block"></i>
            Tidak ada data prospek yang ditemukan pada kategori ini.
        </td>
    </tr>
@endforelse
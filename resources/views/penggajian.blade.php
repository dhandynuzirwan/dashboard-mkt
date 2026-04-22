@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4 justify-content-between">
            <div>
                <h3 class="fw-bold mb-1">Penggajian & Aturan Potongan</h3>
                <h6 class="op-7 mb-2">Manajemen Data Gaji Karyawan & Master Potongan Izin</h6>
            </div>
            <div class="mt-3 mt-md-0">
                <div class="badge badge-info px-3 py-2 mt-1" style="font-size: 12px;">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= TABEL DATA GAJI KARYAWAN ================= --}}
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                <div class="card-title fw-bold m-0">
                    <!--<i class="fas fa-wallet text-success me-2"></i>-->
                     Data Gaji & Tunjangan Karyawan</div>
                <a href="{{ route('form-penggajian') }}" class="btn btn-success btn-sm btn-round ms-auto shadow-sm">
                    <i class="fa fa-plus me-1"></i> Tambah Data
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4">KARYAWAN (MARKETING)</th>
                                <th>TARGET KINERJA</th>
                                <th>KOMPONEN PENDAPATAN</th>
                                <th>KOMPONEN BPJS</th>
                                <th class="text-center pe-4" width="160">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggajians as $index => $item)
                                <tr class="border-bottom">
                                    {{-- Kolom 1: Nama Karyawan --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-primary-gradient fw-bold">{{ substr($item->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark" style="font-size: 15px;">{{ $item->user->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Target (Call & Rupiah) --}}
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Target Call:</span>
                                            <span class="fw-bold text-dark">{{ $item->target_call }} Call/Hari</span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Target (Rp):</span>
                                            <span class="fw-bold text-primary">Rp {{ number_format($item->target, 0, ',', '.') }}/Bulan</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Pendapatan (Gapok & Tunjangan) --}}
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Gaji Pokok:</span>
                                            <span class="fw-bold text-dark">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Tunjangan:</span>
                                            <span class="fw-bold text-success">Rp {{ number_format($item->tunjangan, 0, ',', '.') }}</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 4: BPJS (Tunjangan & Iuran) --}}
                                    <td>
                                        <div class="d-flex justify-content-between mb-1" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Tunjangan BPJS:</span>
                                            <span class="fw-bold text-success">+ Rp {{ number_format($item->tunjangan_bpjs, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 12px; max-width: 200px;">
                                            <span class="text-muted">Iuran (Potongan):</span>
                                            <span class="fw-bold text-danger">- Rp {{ number_format($item->iuran_bpjs, 0, ',', '.') }}</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 5: Action (Tombol Standar) --}}
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('penggajian.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data gaji ini?')">
                                                    <i class="fa fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($penggajians->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data gaji karyawan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= TABEL ATURAN POTONGAN IZIN ================= --}}
        <div class="card card-round mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                <div class="card-title fw-bold m-0">
                    <!--<i class="fas fa-clipboard-list text-secondary me-2"></i>-->
                     Aturan Potongan Gaji per Jenis Izin</div>
                <button class="btn btn-secondary btn-sm btn-round ms-auto shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                    <i class="fa fa-plus me-1"></i> Tambah Aturan
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4" width="60">NO</th>
                                <th>JENIS IZIN (Sesuai Fingerspot)</th>
                                <th>NOMINAL POTONGAN</th>
                                <th class="text-center pe-4" width="160">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis_izins as $idx => $izin)
                                <tr class="border-bottom">
                                    <td class="ps-4 fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <span class="fw-bold text-dark fs-6">{{ $izin->nama_izin }}</span>
                                    </td>
                                    <td>
                                        <div style="background-color: #f8d7da; color: #721c24; font-weight: bold; display: inline-block; padding: 2px 10px; border-radius: 4px; border: 1px solid #f5c6cb;">
                                            - Rp {{ number_format($izin->potongan, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Tombol Edit Standar --}}
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditIzin{{ $izin->id }}">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </button>
                                            {{-- Tombol Delete Standar --}}
                                            <form action="{{ route('jenis-izin.destroy', $izin->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus aturan potongan ini?')">
                                                    <i class="fa fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT IZIN --}}
                                <div class="modal fade" id="modalEditIzin{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('jenis-izin.update', $izin->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content card-round border-0 shadow-lg">
                                                <div class="modal-header bg-light border-0 py-3 px-4">
                                                    <h5 class="modal-title fw-bold m-0"><i class="fas fa-edit text-warning me-2"></i> Edit Aturan Potongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="form-group p-0 mb-3">
                                                        <label class="fw-bold mb-1">Nama Jenis Izin</label>
                                                        <input type="text" name="nama_izin" class="form-control border-gray-200" value="{{ $izin->nama_izin }}" required>
                                                    </div>
                                                    <div class="form-group p-0">
                                                        <label class="fw-bold mb-1">Besar Potongan (Rp)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">Rp</span>
                                                            <input type="number" name="potongan" class="form-control border-gray-200 text-danger fw-bold" value="{{ (int)$izin->potongan }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light py-3 px-4">
                                                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning px-4 shadow-sm">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            @if($jenis_izins->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada master aturan potongan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= MODAL TAMBAH IZIN BARU ================= --}}
<div class="modal fade" id="modalTambahIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('jenis-izin.store') }}" method="POST">
            @csrf
            <div class="modal-content card-round border-0 shadow-lg">
                <div class="modal-header bg-light border-0 py-3 px-4">
                    <h5 class="modal-title fw-bold m-0"><i class="fas fa-plus-circle text-secondary me-2"></i> Tambah Aturan Izin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm small p-3 mb-4">
                        <i class="fas fa-info-circle me-1"></i> Pastikan nama izin <b>sama persis</b> dengan penamaan di CSV hasil export mesin Fingerspot.
                    </div>
                    <div class="form-group p-0 mb-3">
                        <label class="fw-bold mb-1">Nama Jenis Izin</label>
                        <input type="text" name="nama_izin" class="form-control border-gray-200" placeholder="Contoh: Sakit Tanpa Surat Dokter" required>
                    </div>
                    <div class="form-group p-0">
                        <label class="fw-bold mb-1">Besar Potongan (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" name="potongan" class="form-control border-gray-200 text-danger fw-bold" placeholder="100000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-secondary px-4 shadow-sm">Simpan Aturan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
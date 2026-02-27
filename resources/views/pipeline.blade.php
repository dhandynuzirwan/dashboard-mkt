@extends('layouts.app') 

@section('content')
<div class="container">
    <div class="page-inner">
        {{-- Header Section --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-3">
            <div>
                <h3 class="fw-bold mb-1">Pipeline Marketing</h3>
                <h6 class="op-7 mb-2">Laporan Terintegrasi & Pipeline Prospek</h6>
                <div class="badge badge-info">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>
        <div class="card p-2 mb-3 shadow-none border" style="background: #f9fbfd;">
            <form action="{{ route('prospek.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <div class="form-group p-0 m-0">
                    <input type="date" name="start_date" class="form-control form-control-sm"
                        value="{{ request('start_date') }}" title="Tanggal Mulai">
                </div>
                <div class="form-group p-0 m-0">
                    <input type="date" name="end_date" class="form-control form-control-sm"
                        value="{{ request('end_date') }}" title="Tanggal Akhir">
                </div>
                <div class="form-group p-0 m-0">
                    <select name="marketing_id" class="form-select form-select-sm">
                        <option value="">Semua Marketing</option>
                        @foreach ($marketings as $m)
                            <option value="{{ $m->id }}"
                                {{ request('marketing_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group p-0 m-0">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status Penawaran</option>
                        {{-- Value harus lowercase & snake_case sesuai database --}}
                        <option value="under_review"
                            {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review
                        </option>
                        <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold
                        </option>
                        <option value="kalah_harga"
                            {{ request('status') == 'kalah_harga' ? 'selected' : '' }}>Kalah Harga</option>
                        <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal
                        </option>
                    </select>
                </div>
                <div class="form-group p-0 m-0">
                    <select name="cta_status" class="form-select form-select-sm" style="">
                        <option value="">Semua Tahap</option>
                        <option value="pending" {{ request('cta_status') == 'pending' ? 'selected' : '' }}>
                            🚩 Belum di-CTA</option>
                        <option value="done" {{ request('cta_status') == 'done' ? 'selected' : '' }}>✅
                            Sudah di-CTA</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm btn-round">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('prospek.index') }}" class="btn btn-border btn-round btn-sm">Reset</a>
            </form>
        </div>

        {{-- Stats Cards - Margin Bottom dikecilkan (mb-2) --}}
        <div class="row mb-2">
            {{-- Total Prospek --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Prospek</p>
                                    <h4 class="card-title">{{ number_format($stats['total_prospek']) }}</h4>
                                    <p class="text-muted small mb-0">Database masuk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Penawaran --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Penawaran</p>
                                    <h4 class="card-title">{{ number_format($stats['total_cta']) }}</h4>
                                    <p class="text-info small mb-0">
                                        @if ($stats['total_prospek'] > 0)
                                            {{ round(($stats['total_cta'] / $stats['total_prospek']) * 100, 1) }}% Rate CTA
                                        @else
                                            0% Rate CTA
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nilai Pipeline --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Nilai Pipeline</p>
                                    <h4 class="card-title" style="font-size: 1.1rem;">Rp {{ number_format($stats['total_nilai'], 0, ',', '.') }}</h4>
                                    <p class="text-success small mb-0">Potensi Omzet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Deal --}}
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round card-animate mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Project Deal</p>
                                    <h4 class="card-title">{{ number_format($stats['total_deal']) }}</h4>
                                    <p class="text-secondary small mb-0">
                                        @if ($stats['total_cta'] > 0)
                                            {{ round(($stats['total_deal'] / $stats['total_cta']) * 100, 1) }}% Closing Rate
                                        @else
                                            0% Closing
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel 1: Tabel Pipeline (Struktur Utuh) --}}
        <div class="card mb-4">
            <div class="card-header">
                <div class="card-title">Tabel Pipeline</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID PROSPEK</th>
                                <th>Marketing</th>
                                <th>STATUS CTA</th>
                                <th>DATE</th>
                                <th>PERUSAHAAN</th>
                                <th>NO TELP</th>
                                <th>EMAIL</th>
                                <th>JABATAN</th>
                                <th>NAMA</th>
                                <th>WA PIC</th>
                                <th>WA BARU</th>
                                <th>ALAMAT PERUSAHAAN</th>
                                <th>SOURCE</th>
                                <th>UPDATE FU</th>
                                <th>STATUS AKHIR DATA</th>
                                <th>CATATAN</th>
                                <th>KETERANGAN CTA</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospeks as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->marketing?->name }}</td>
                                    <td>
                                        @if (!$data->cta)
                                            <span class="badge badge-warning">Waiting CTA</span>
                                        @else
                                            <span class="badge badge-success">On Progress</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->tanggal_prospek }}</td>
                                    <td>{{ $data->perusahaan }}</td>
                                    <td>{{ $data->telp }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->jabatan }}</td>
                                    <td>{{ $data->nama_pic }}</td>
                                    <td>{{ $data->wa_pic }}</td>
                                    <td>{{ $data->wa_baru }}</td>
                                    <td>{{ $data->lokasi }}</td>
                                    <td>{{ $data->sumber }}</td>
                                    <td>{{ $data->update_terakhir }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>{{ $data->deskripsi }}</td>
                                    <td>{{ $data->catatan }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                            @if ($data->cta && in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                <a href="{{ route('cta.edit', $data->cta->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endif
                                            @if (!$data->cta)
                                                <a href="{{ route('form-cta', $data->id) }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-plus"></i> CTA
                                                </a>
                                            @else
                                                <button class="btn btn-outline-success btn-sm" disabled style="cursor: default;">
                                                    <i class="fas fa-check"></i> Done
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="demo mt-3 d-flex justify-content-center">
                    {{ $prospeks->links('partials.pagination') }}
                </div>
            </div>
        </div>

        {{-- Tabel 2: Data CTA Marketing (Struktur Utuh) --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data CTA Marketing</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID PROSPEK</th>
                                <th>MARKETING</th>
                                <th>DATE</th>
                                <th>PERUSAHAAN</th>
                                <th>PERMINTAAN JUDUL</th>
                                <th>JUMLAH PESERTA</th>
                                <th>SERTIFIKASI</th>
                                <th>SKEMA</th>
                                <th>HARGA PENAWARAN</th>
                                <th>HARGA VENDOR</th>
                                <th>PROPOSAL PENAWARAN</th>
                                <th>STATUS PENAWARAN</th>
                                <th>KETERANGAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospeks as $data)
                                @if ($data->cta)
                                    <tr>
                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->marketing?->name }}</td>
                                        <td>{{ $data->tanggal_prospek }}</td>
                                        <td>{{ $data->perusahaan }}</td>
                                        <td>{{ $data->cta->judul_permintaan }}</td>
                                        <td>{{ $data->cta->jumlah_peserta }}</td>
                                        <td><span class="badge badge-info">{{ strtoupper($data->cta->sertifikasi) }}</span></td>
                                        <td>{{ $data->cta->skema }}</td>
                                        <td>Rp {{ number_format($data->cta->harga_penawaran, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($data->cta->harga_vendor, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($data->cta->proposal_link)
                                                <a href="{{ $data->cta->proposal_link }}" target="_blank" class="btn btn-link btn-sm">
                                                    <i class="fas fa-external-link-alt"></i> Lihat Link
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $status_labels = [
                                                    'under_review' => ['label' => 'Under Review', 'class' => 'badge-info'],
                                                    'hold' => ['label' => 'Hold', 'class' => 'badge-warning'],
                                                    'kalah_harga' => ['label' => 'Kalah Harga', 'class' => 'badge-danger'],
                                                    'deal' => ['label' => 'Deal', 'class' => 'badge-success'],
                                                ];
                                                $current_status = $status_labels[$data->cta->status_penawaran] ?? ['label' => 'N/A', 'class' => 'badge-secondary'];
                                            @endphp
                                            <span class="badge {{ $current_status['class'] }}">
                                                {{ $current_status['label'] }}
                                            </span>
                                        </td>
                                        <td>{{ $data->cta?->keterangan ?? 'Tidak Ada' }}</td>
                                        <td>
                                            @if (auth()->id() === $data->marketing_id)
                                                <a href="{{ route('cta.edit', $data->cta->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-lock"></i> Locked
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="demo mt-3 d-flex justify-content-center">
                    {{ $ctaProspeks->links('partials.pagination') }}
                </div>
            </div>
        </div>
    </div> {{-- Penutup Page-inner --}}
</div> {{-- Penutup Container --}}

<style>
    .card-animate {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
    }
    .card-animate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .card-category {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
        };
        document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
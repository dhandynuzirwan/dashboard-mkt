@extends('layouts.app')

@section('content')

            <div class="container">
                <div class="page-inner">

                    {{-- FILTER SECTION --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('dashboard.progress') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label>Dari Tanggal</label>
                                        <input type="date" name="start_date" value="{{ $start }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" name="end_date" value="{{ $end }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Marketing</label>
                                        <select name="marketing_id" class="form-control">
                                            <option value="">Semua Marketing</option>
                                            @foreach($all_marketing as $m)
                                                <option value="{{ $m->id }}" {{ request('marketing_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i></button>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <small id="live-date" class="d-block text-muted"></small>
                                        <small id="live-clock" class="fw-bold text-primary"></small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- TABEL PROGRESS MARKETING --}}
                    <div class="card shadow-sm">
                        <div class="card-header"><div class="card-title">Tabel Progress Marketing</div></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Marketing</th>
                                            <th>Target</th>
                                            <th>Pencapaian</th>
                                            <th>Ach Target</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($marketings as $m)
                                        <tr>
                                            <td class="fw-bold">{{ $m->name }}</td>
                                            <td>{{ $m->target_total }}</td>
                                            <td>{{ $m->pencapaian }}</td>
                                            <td style="width: 300px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 10px; width: 100%;">
                                                        <div class="progress-bar {{ $m->ach_persen < 50 ? 'bg-danger' : ($m->ach_persen < 80 ? 'bg-warning' : 'bg-success') }}" 
                                                            style="width: {{ $m->ach_persen }}%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">{{ number_format($m->ach_persen, 2) }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- TABEL UPDATE PENAWARAN --}}
                    <div class="card shadow-sm mt-4">
                        <div class="card-header"><div class="card-title">Tabel Update Penawaran</div></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Marketing</th>
                                            <th>Masuk Penawaran</th>
                                            <th>Deal</th>
                                            <th>Hold</th>
                                            <th>Kalah Harga</th>
                                            <th>Total FU</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($marketings as $m)
                                        <tr>
                                            <td>{{ $m->name }}</td>
                                            <td><span class="badge badge-info">{{ $m->review }}</span></td>
                                            <td><span class="badge badge-success">{{ $m->deal }}</span></td>
                                            <td><span class="badge badge-warning">{{ $m->hold }}</span></td>
                                            <td><span class="badge badge-danger">{{ $m->kalah }}</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary btn-round btn-detail" data-id="{{ $m->id }}">
                                                    {{ $m->total_penawaran }} Detail
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                    
                    {{-- MODAL DETAIL --}}
                    <div class="modal fade" id="modalDetail" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Detail Penawaran & FU</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" id="detailBody">
                                    </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card border shadow-sm mt-4">
                        <div class="card-header">
                            <div class="card-title">Tabel Update FU</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Belum Ada Keterangan</th>
                                            <th>No Respon</th>
                                            <th>Belum Ada Kebutuhan</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th scope="row">1</th>
                                            <td>17</td>
                                            <td>62</td>
                                            <td>6</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">2</th>
                                            <td>9</td>
                                            <td>79</td>
                                            <td>5</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">3</th>
                                            <td>16</td>
                                            <td>84</td>
                                            <td>15</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">4</th>
                                            <td>24</td>
                                            <td>74</td>
                                            <td>1</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">5</th>
                                            <td>25</td>
                                            <td>23</td>
                                            <td>9</td>
                                        </tr>

                                        <!-- TOTAL -->
                                        <tr class="fw-bold table-primary">
                                            <th>TOTAL</th>
                                            <td>91</td>
                                            <td>322</td>
                                            <td>36</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card border shadow-sm mt-4">
                        <div class="card-header">
                            <div class="card-title">Tabel Status Akhir Data</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Marketing</th>
                                            <th>Perpanjangan Sertifikat</th>
                                            <th>Data Tidak Valid & Tidak Terhubung</th>
                                            <th>Dapat Email</th>
                                            <th>Dapat No WA HRD</th>
                                            <th>Request Compro</th>
                                            <th>Manja</th>
                                            <th>Manja Ulang</th>
                                            <th>Request Permintaan Pelatihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $t_perpanjangan = 0; $t_invalid = 0; $t_email = 0; $t_wa = 0;
                                            $t_compro = 0; $t_manja = 0; $t_manja_ulang = 0; $t_pelatihan = 0;
                                        @endphp

                                        @foreach($marketings as $m)
                                        <tr>
                                            <td class="text-start fw-bold">{{ $m->name }}</td>
                                            <td>{{ $m->count_perpanjangan ?? 0 }}</td>
                                            <td>{{ $m->count_invalid ?? 0 }}</td>
                                            <td>{{ $m->count_email ?? 0 }}</td>
                                            <td>{{ $m->count_wa ?? 0 }}</td>
                                            <td>{{ $m->count_compro ?? 0 }}</td>
                                            <td>{{ $m->count_manja ?? 0 }}</td>
                                            <td>{{ $m->count_manja_ulang ?? 0 }}</td>
                                            <td>{{ $m->count_pelatihan ?? 0 }}</td>
                                        </tr>
                                        @php
                                            $t_perpanjangan += $m->count_perpanjangan;
                                            $t_invalid      += $m->count_invalid;
                                            $t_email        += $m->count_email;
                                            $t_wa           += $m->count_wa;
                                            $t_compro       += $m->count_compro;
                                            $t_manja        += $m->count_manja;
                                            $t_manja_ulang  += $m->count_manja_ulang;
                                            $t_pelatihan    += $m->count_pelatihan;
                                        @endphp
                                        @endforeach

                                        <tr class="fw-bold table-primary">
                                            <td>TOTAL</td>
                                            <td>{{ $t_perpanjangan }}</td>
                                            <td>{{ $t_invalid }}</td>
                                            <td>{{ $t_email }}</td>
                                            <td>{{ $t_wa }}</td>
                                            <td>{{ $t_compro }}</td>
                                            <td>{{ $t_manja }}</td>
                                            <td>{{ $t_manja_ulang }}</td>
                                            <td>{{ $t_pelatihan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border shadow-sm">
                                <div class="card-header">
                                    <div class="card-title">Grafik Ach Target Marketing</div>
                                </div>
                                <div class="card-body">
                                    <div style="max-width: 500px; margin: auto;">
                                        <canvas id="achTargetChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border shadow-sm">
                            <div class="card-header">
                                <div class="card-title">Produktivitas</div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                <canvas id="multipleLineChart"></canvas>
                                </div>
                            </div>
                            </div>
                        </div>   
                    </div>                                     
                </div>

        {{-- ================= SCRIPT ================= --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Logika AJAX untuk Popup Detail
            document.querySelectorAll('.btn-detail').forEach(button => {
                button.addEventListener('click', function() {
                    const mId = this.getAttribute('data-id');
                    $('#modalDetail').modal('show');
                    document.getElementById('detailBody').innerHTML = '<p class="text-center">Memuat data...</p>';
                    
                    // Ganti URL ini sesuai route detail Anda
                    fetch(`/marketing-detail/${mId}?start={{ $start }}&end={{ $end }}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('detailBody').innerHTML = html;
                        });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // 1. LIVE CLOCK (Tetap sama)
                function updateClock() {
                    const now = new Date();
                    document.getElementById("live-date").innerHTML = now.toLocaleDateString('id-ID');
                    document.getElementById("live-clock").innerHTML = now.toLocaleTimeString('id-ID');
                }
                setInterval(updateClock, 1000);
                updateClock();

                // 2. PIE CHART - KONTRIBUSI REVENUE
                const ctxPie = document.getElementById('achTargetChart');
                if (ctxPie) {
                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: @json($pieLabels),
                            datasets: [{
                                data: @json($pieData),
                                backgroundColor: ['#0d6efd', '#0dcaf0', '#ffc107', '#198754', '#dc3545', '#6610f2'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            let value = context.raw || 0;
                                            return label + ': Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // 3. MULTIPLE LINE CHART - TREN PRODUKTIVITAS
                const ctxLine = document.getElementById("multipleLineChart").getContext("2d");
                if (ctxLine) {
                    new Chart(ctxLine, {
                        type: "line",
                        data: {
                            labels: @json($lineLabels),
                            datasets: @json($lineDatasets)
                        },
                        options: {
                            scales: {
                                y: {
                                    ticks: {
                                        // Mengubah 10.000.000 menjadi 10jt agar tidak kepanjangan
                                        callback: function(value) {
                                            return 'Rp ' + (value / 1000000) + 'jt';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endsection
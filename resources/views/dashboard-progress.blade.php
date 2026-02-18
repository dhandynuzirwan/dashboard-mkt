@extends('layouts.app')

@section('content')
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main-panel">
            @include('layouts.header')

            <div class="container">
                <div class="page-inner">

                    {{-- ================= HEADER + FILTER + CLOCK ================= --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-end">

                                <div class="col-md-3">
                                    <label>Dari Tanggal</label>
                                    <input type="date" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100">
                                        Filter
                                    </button>
                                </div>

                                {{-- CLOCK KECIL SEBARIS --}}
                                <div class="col-md-4 text-end">
                                    <small id="live-date" class="d-block text-muted"></small>
                                    <small id="live-clock" class="fw-bold text-primary"></small>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ================= STAT CARDS (STYLE CHART MINI) ================= --}}
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="card-title">Tabel Progress Marketing</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Marketing</th>
                                            <th>Target</th>
                                            <th>Pencapaian</th>
                                            <th>Ach Target</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th scope="row">1</th>
                                            <td>INTAN 1</td>
                                            <td>600</td>
                                            <td>139</td>
                                            <td style="width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 6px; width: 100%;">
                                                        <div class="progress-bar bg-primary" style="width: 23.17%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">23,17%</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">2</th>
                                            <td>INTAN 2</td>
                                            <td>600</td>
                                            <td>156</td>
                                            <td style="width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 6px; width: 100%;">
                                                        <div class="progress-bar bg-info" style="width: 26%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">26,00%</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">3</th>
                                            <td>INTAN 3</td>
                                            <td>600</td>
                                            <td>151</td>
                                            <td style="width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 6px; width: 100%;">
                                                        <div class="progress-bar bg-warning" style="width: 25.17%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">25,17%</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">4</th>
                                            <td>INTAN 4</td>
                                            <td>600</td>
                                            <td>163</td>
                                            <td style="width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 6px; width: 100%;">
                                                        <div class="progress-bar bg-success" style="width: 27.17%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">27,17%</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">5</th>
                                            <td>INTAN 5</td>
                                            <td>600</td>
                                            <td>158</td>
                                            <td style="width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-1" style="height: 6px; width: 100%;">
                                                        <div class="progress-bar bg-danger" style="width: 26.33%"></div>
                                                    </div>
                                                    <span class="ms-2 fw-bold">26,33%</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- TOTAL -->
                                        <tr class="fw-bold table-primary">
                                            <th colspan="2">TOTAL</th>
                                            <td>3000</td>
                                            <td>767</td>
                                            <td>25,57%</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border shadow-sm mt-4">
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
                    </div>
                    <div class="card border shadow-sm mt-4">
                        <div class="card-header">
                            <div class="card-title">Tabel Status Akhir Data</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
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

                                        <tr>
                                            <th scope="row">1</th>
                                            <td>0</td>
                                            <td>41</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>23</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>2</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">2</th>
                                            <td>0</td>
                                            <td>20</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>9</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>2</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">3</th>
                                            <td>0</td>
                                            <td>34</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>9</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">4</th>
                                            <td>0</td>
                                            <td>20</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>58</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>3</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">5</th>
                                            <td>0</td>
                                            <td>11</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>70</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>

                                        <!-- TOTAL -->
                                        <tr class="fw-bold table-primary">
                                            <th>TOTAL</th>
                                            <td>0</td>
                                            <td>126</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>169</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>8</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card border shadow-sm mt-4">
                        <div class="card-header">
                            <div class="card-title">Tabel Update Penawaran</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Masuk Penawaran</th>
                                            <th>Under Review</th>
                                            <th>Deal</th>
                                            <th>Hold</th>
                                            <th>Kalah Harga</th>
                                            <th>Terlambat FU</th>
                                            <th>Total FU</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th scope="row">1</th>
                                            <td>4</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>139</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">2</th>
                                            <td>22</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>156</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">3</th>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>151</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">4</th>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>163</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">5</th>
                                            <td>35</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>158</td>
                                        </tr>

                                        <!-- TOTAL -->
                                        <tr class="fw-bold table-primary">
                                            <th>TOTAL</th>
                                            <td>67</td>
                                            <td>25</td>
                                            <td>13</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>767</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card border shadow-sm mt-4">
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
            </div>
        </div>

        {{-- ================= SCRIPT ================= --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // LIVE CLOCK
                function updateClock() {
                    const now = new Date();
                    document.getElementById("live-date").innerHTML =
                        now.toLocaleDateString('id-ID');
                    document.getElementById("live-clock").innerHTML =
                        now.toLocaleTimeString('id-ID');
                }
                setInterval(updateClock, 1000);
                updateClock();


                // PIE CHART ACH TARGET
                const ctx = document.getElementById('achTargetChart');

                if (ctx) {
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['INTAN 1', 'INTAN 2', 'INTAN 3', 'INTAN 4', 'INTAN 5'],
                            datasets: [{
                                data: [23.17, 26.00, 25.17, 27.17, 26.33],
                                backgroundColor: [
                                    '#0d6efd',
                                    '#0dcaf0',
                                    '#ffc107',
                                    '#198754',
                                    '#dc3545'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.raw + '%';
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

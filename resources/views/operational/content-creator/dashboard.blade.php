@extends('layouts.app')

@section('content')
<!-- Include Google Fonts for Premium Typography -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Include Chart.js via CDN to ensure latest features -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Premium Modern Aesthetics */
    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: #f3f6fb;
    }
    
    .cc-dashboard {
        font-family: 'Outfit', sans-serif !important;
    }

    /* Gradients and Shadows */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: white;
    }

    .kpi-card {
        border-radius: 20px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }

    .kpi-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 100px; height: 100px;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        transform: translate(20%, -20%);
    }

    .kpi-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    }

    .kpi-icon {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        backdrop-filter: blur(5px);
    }

    .kpi-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 10px 0;
        letter-spacing: -1px;
    }

    .kpi-label {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
    }

    /* Custom Progress Bar */
    .custom-progress {
        height: 8px;
        border-radius: 4px;
        background: rgba(255,255,255,0.3);
        margin-top: 15px;
        overflow: hidden;
    }

    .custom-progress-bar {
        height: 100%;
        border-radius: 4px;
        background: #fff;
        transition: width 1s ease-in-out;
    }

    /* Table Styling */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    
    .modern-table th {
        border: none;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 16px;
    }
    
    .modern-table td {
        background: #fff;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px;
        vertical-align: middle;
    }
    
    .modern-table td:first-child {
        border-left: 1px solid #f1f5f9;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    
    .modern-table td:last-child {
        border-right: 1px solid #f1f5f9;
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-track { background: #dcfce7; color: #166534; }
    .badge-late { background: #fee2e2; color: #991b1b; }
    .badge-done { background: #e0e7ff; color: #3730a3; }

    /* Tabs Styling */
    .modern-tabs {
        border-bottom: 2px solid rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    
    .modern-tabs .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 1rem;
        padding: 12px 24px;
        position: relative;
        background: transparent;
        transition: all 0.3s ease;
    }
    
    .modern-tabs .nav-link:hover {
        color: #3b82f6;
    }
    
    .modern-tabs .nav-link.active {
        color: #3b82f6;
        background: transparent;
    }
    
    .modern-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: #3b82f6;
        border-radius: 3px 3px 0 0;
    }

    /* Animation */
    .fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container cc-dashboard">
    <div class="page-inner">
        <!-- Header -->
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-up">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px; font-size: 2rem;">Content Creator</h3>
                <h6 class="text-muted fw-normal" style="font-size: 1.1rem;">Pantau performa, KPI, dan efisiensi tim kreatif.</h6>
            </div>
        </div>

        <!-- Section Atas: Executive Summary / KPI Cards -->
        <div class="row">
            <!-- Total Output -->
            <div class="col-sm-6 col-md-3 mb-4 fade-up delay-1">
                <div class="kpi-card gradient-blue">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="kpi-label">Output Konten</div>
                        <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
                    </div>
                    <div class="kpi-value">45<span style="font-size: 1rem; font-weight: 400; opacity: 0.8"> / 50</span></div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar" style="width: 90%;"></div>
                    </div>
                    <div class="mt-2 text-white" style="font-size: 0.85rem; opacity: 0.9;">90% dari target bulanan</div>
                </div>
            </div>

            <!-- Overall KPI Score -->
            <div class="col-sm-6 col-md-3 mb-4 fade-up delay-1">
                <div class="kpi-card gradient-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="kpi-label">Skor KPI</div>
                        <div class="kpi-icon"><i class="fas fa-trophy"></i></div>
                    </div>
                    <div class="kpi-value">92%</div>
                    <div class="mt-2 text-white" style="font-size: 0.85rem; opacity: 0.9;"><i class="fas fa-arrow-up me-1"></i> +5% dari bulan lalu</div>
                </div>
            </div>

            <!-- On Time Delivery -->
            <div class="col-sm-6 col-md-3 mb-4 fade-up delay-2">
                <div class="kpi-card gradient-orange">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="kpi-label">On-Time Rate</div>
                        <div class="kpi-icon"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="kpi-value">88%</div>
                    <div class="mt-2 text-white" style="font-size: 0.85rem; opacity: 0.9;">40 dari 45 selesai tepat waktu</div>
                </div>
            </div>

            <!-- Engagement Rate -->
            <div class="col-sm-6 col-md-3 mb-4 fade-up delay-2">
                <div class="kpi-card gradient-purple">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="kpi-label">Avg. Engagement</div>
                        <div class="kpi-icon"><i class="fas fa-heart"></i></div>
                    </div>
                    <div class="kpi-value">4.2%</div>
                    <div class="mt-2 text-white" style="font-size: 0.85rem; opacity: 0.9;">Tinggi di atas rata-rata industri (2%)</div>
                </div>
            </div>
        </div>

        <!-- Section Tengah: Performa Visual & Engagement -->
        <div class="row">
            <!-- Line Chart: Tren Engagement -->
            <div class="col-md-8 mb-4 fade-up delay-3">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4">Tren Engagement Rate (Mingguan)</h5>
                    <div style="height: 300px;">
                        <canvas id="erChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart: Distribusi Format -->
            <div class="col-md-4 mb-4 fade-up delay-3">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4">Distribusi Format</h5>
                    <div style="height: 250px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="formatChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-0">Reels & Carousel mendominasi performa bulan ini.</p>
                    </div>
                </div>
            </div>

            <!-- Bar Chart: Top 5 Visual Content -->
            <div class="col-md-12 mb-4 fade-up delay-3">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4">Top 5 Visual Content (Berdasarkan Saves & Shares)</h5>
                    <div style="height: 350px;">
                        <canvas id="topContentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section Bawah: Efisiensi & Detail Proyek -->
        <div class="row">
            <div class="col-md-12 fade-up delay-3">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Daftar Proyek Berjalan & Log Aset</h5>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light px-3 py-2 rounded-3">
                                <span class="text-muted small">Rata-rata Revisi:</span>
                                <span class="fw-bold text-dark ms-2" style="font-size: 1.1rem;">1.2x</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table modern-table w-100">
                            <thead>
                                <tr>
                                    <th>ID Konten</th>
                                    <th>Judul Konten</th>
                                    <th>Platform</th>
                                    <th>Format</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Revisi</th>
                                    <th>Link Aset</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dummy Data 1 -->
                                <tr>
                                    <td class="fw-bold text-primary">#CNT-010</td>
                                    <td class="fw-bold text-dark">Promo Agustus Merdeka</td>
                                    <td><i class="fab fa-instagram text-danger me-2"></i> Instagram</td>
                                    <td>Carousel</td>
                                    <td>08 Agu 2026</td>
                                    <td><span class="badge-modern badge-track">On Track</span></td>
                                    <td class="text-center">0</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-link"></i> GDrive</a></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info rounded-pill text-white fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fas fa-eye"></i> Detail</button>
                                    </td>
                                </tr>
                                <!-- Dummy Data 2 -->
                                <tr>
                                    <td class="fw-bold text-primary">#CNT-011</td>
                                    <td class="fw-bold text-dark">Tips K3 di Lapangan</td>
                                    <td><i class="fab fa-tiktok text-dark me-2"></i> TikTok</td>
                                    <td>Video Pendek</td>
                                    <td>10 Agu 2026</td>
                                    <td><span class="badge-modern badge-track">On Track</span></td>
                                    <td class="text-center">1</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-link"></i> GDrive</a></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info rounded-pill text-white fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fas fa-eye"></i> Detail</button>
                                    </td>
                                </tr>
                                <!-- Dummy Data 3 -->
                                <tr>
                                    <td class="fw-bold text-primary">#CNT-012</td>
                                    <td class="fw-bold text-dark">Webinar Leadership Seri 3</td>
                                    <td><i class="fab fa-linkedin text-info me-2"></i> LinkedIn</td>
                                    <td>Single Image</td>
                                    <td>05 Agu 2026</td>
                                    <td><span class="badge-modern badge-done">Completed</span></td>
                                    <td class="text-center">2</td>
                                    <td><a href="#" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-link"></i> GDrive</a></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info rounded-pill text-white fw-bold" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fas fa-eye"></i> Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL DETAIL & INPUT (Metrik & Evaluasi) -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden; font-family: 'Outfit', sans-serif; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 25px 30px; border-bottom: none;">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-primary d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px; font-size: 20px; border-radius: 12px;">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bolder text-white mb-0" id="detailModalLabel">Detail & Input Performa</h5>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">ID Konten: <strong class="text-white">#CNT-010</strong></p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 px-md-5 pt-4 pb-4" style="background-color: #f8fafc; overflow-y: auto; max-height: calc(100vh - 120px);">
                
                <!-- Section 1: Metrik Performa -->
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-chart-line me-2"></i> Input Data Metrik Performa Media Sosial</h6>
                    <div class="bg-white p-3 rounded" style="border: 1px solid #e2e8f0;">
                        <p class="text-muted small mb-3">Catat insight dari platform media sosial untuk setiap konten yang telah dipublikasikan (H+7 tayang).</p>
                        
                        @if(auth()->check() && auth()->user()->role == 'graphic')
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold small">ID Konten</label>
                                        <input type="text" class="form-control" value="#CNT-010" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold small">Tanggal Tayang</label>
                                        <input type="date" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold small">Impressions</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold small">Reach</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold small">Likes</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold small">Comments</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold small">Saves</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold small">Shares</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold text-primary small">Engagement Rate (%)</label>
                                        <input type="number" step="0.01" class="form-control bg-light" placeholder="0.00" readonly title="Dihitung Otomatis">
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-primary btn-round px-4">Simpan Metrik</button>
                                </div>
                            </form>
                        @else
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-white text-center shadow-sm">
                                        <p class="text-muted small mb-1">Tanggal Tayang</p>
                                        <h6 class="fw-bold mb-0">15 Agu 2026</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-white text-center shadow-sm">
                                        <p class="text-muted small mb-1">Engagement Rate</p>
                                        <h5 class="fw-bold text-primary mb-0">4.50%</h5>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-eye text-info mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">1,250</h5>
                                        <span class="text-muted small">Impressions</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-users text-primary mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">980</h5>
                                        <span class="text-muted small">Reach</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-heart text-danger mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">450</h5>
                                        <span class="text-muted small">Likes</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-comment text-warning mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">32</h5>
                                        <span class="text-muted small">Comments</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-bookmark text-success mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">110</h5>
                                        <span class="text-muted small">Saves</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 border rounded bg-light text-center shadow-sm">
                                        <i class="fas fa-share text-secondary mb-2 fs-4"></i>
                                        <h5 class="fw-bold mb-0">45</h5>
                                        <span class="text-muted small">Shares</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Section 2: Evaluasi Internal -->
                <div>
                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-clipboard-check me-2"></i> Evaluasi Internal & Kualitatif (Manajemen)</h6>
                    <div class="bg-white p-3 rounded" style="border: 1px solid #e2e8f0;">
                        <p class="text-muted small mb-3">Formulir evaluasi akhir yang diisi oleh Manager / Creative Lead.</p>

                        @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'hrd']))
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold small">Kesesuaian Brand Guideline</label>
                                        <select class="form-select">
                                            <option value="5">5 - Sangat Sesuai</option>
                                            <option value="4">4 - Sesuai</option>
                                            <option value="3">3 - Cukup Sesuai</option>
                                            <option value="2">2 - Kurang Sesuai</option>
                                            <option value="1">1 - Tidak Sesuai</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold small">Jumlah Template Baru</label>
                                        <input type="number" class="form-control" placeholder="0">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold small">Status Laporan Riset Konten</label>
                                        <select class="form-select">
                                            <option>Selesai</option>
                                            <option>Pending</option>
                                            <option>Tidak Berlaku</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-success btn-round px-4">Simpan Evaluasi</button>
                                </div>
                            </form>
                        @else
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light d-flex align-items-center shadow-sm">
                                        <div class="bg-white p-2 rounded text-center me-3" style="min-width: 45px;">
                                            <i class="fas fa-star text-warning fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Kesesuaian Brand</p>
                                            <h6 class="fw-bold mb-0">5 - Sangat Sesuai</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light d-flex align-items-center shadow-sm">
                                        <div class="bg-white p-2 rounded text-center me-3" style="min-width: 45px;">
                                            <i class="fas fa-copy text-info fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Template Baru</p>
                                            <h6 class="fw-bold mb-0">2 Template</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="p-3 border rounded bg-light d-flex align-items-center shadow-sm">
                                        <div class="bg-white p-2 rounded text-center me-3" style="min-width: 45px;">
                                            <i class="fas fa-file-alt text-success fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Laporan Riset Konten</p>
                                            <span class="badge bg-success mt-1 px-3 py-2 rounded-pill">Selesai</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="modal-footer border-top bg-light py-3 px-4" style="border-radius: 0 0 24px 24px;">
                <button type="button" class="btn btn-light border btn-round fw-bold text-dark px-4 shadow-none" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Line Chart - Engagement Rate Trend
        const ctxER = document.getElementById('erChart').getContext('2d');
        
        // Gradient for line chart
        let gradient = ctxER.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctxER, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Engagement Rate (%)',
                    data: [3.2, 3.8, 4.5, 4.2],
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { family: 'Outfit', size: 13 },
                        bodyFont: { family: 'Outfit', size: 14, weight: 'bold' },
                        displayColors: false
                    }
                },
                scales: {
                    x: { 
                        grid: { display: false },
                        ticks: { font: { family: 'Outfit' } }
                    },
                    y: { 
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: { font: { family: 'Outfit' } },
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart - Format Distribution
        const ctxFormat = document.getElementById('formatChart').getContext('2d');
        new Chart(ctxFormat, {
            type: 'doughnut',
            data: {
                labels: ['Carousel', 'Video/Reels', 'Single Image'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: ['#3b82f6', '#8b5cf6', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Outfit', size: 12 },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        bodyFont: { family: 'Outfit' },
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid py-2 tv-monitor-mode bg-light" id="monitor-container" style="min-height: 100vh; min-width: 1600px; overflow-x: hidden;">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-1 fade-in px-2" id="monitor-header">
        <div>
            <div class="d-inline-flex align-items-center bg-primary-subtle text-primary px-3 py-1 rounded-pill mb-1 shadow-sm border border-primary border-opacity-10">
                <i class="fas fa-satellite-dish fs-6 me-2 pulse-anim"></i>
                <span class="fw-bold fs-6" style="letter-spacing: 1.5px;">LIVE TRACKING SYSTEM</span>
            </div>
            <h2 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="font-size: 2rem; letter-spacing: -1px;">
                MONITORING MARKETING <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow border-0" id="update-badge">
                <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;"></div>
                <span class="fw-bold text-dark fs-5">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            
            <!-- DARK MODE BUTTON -->
            <button onclick="toggleDarkMode()" class="btn btn-outline-dark btn-round shadow-lg px-3 py-2 fw-bold hover-lift fs-5" id="btn-dark-mode">
                <i class="fas fa-moon me-2"></i> Dark Mode
            </button>
            
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-lg px-3 py-2 fw-bold hover-lift fs-5">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    {{-- STAT CARDS (Atas) --}}
    <div class="row g-2 mb-2 fade-in px-2" id="stat-cards-container">
        <div class="col-12 text-center py-2">
            <div class="spinner-border text-primary mb-2" style="width: 2rem; height: 2rem;" role="status"></div>
            <h5 class="text-muted fw-bold">Sinkronisasi Server Data...</h5>
        </div>
    </div>

    {{-- LIST MARKETING (CSS Grid untuk gap identik) --}}
    <div class="fade-in px-2" id="marketing-cards-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px;">
        <!-- Injected by JS -->
    </div>
</div>

<style>
    /* TV Monitor Mode - Ultra Wide */
    .tv-monitor-mode { padding: 0.5rem 1rem !important; }
    
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }

    .wide-marketing-card { border-radius: 12px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }
    .stat-card-modern { border-radius: 12px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }

    /* RANK BADGES MODERN */
    .rank-badge-wide {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 900;
        color: white;
        flex-shrink: 0;
    }
    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #F59E0B); box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4); }
    .rank-2-badge { background: linear-gradient(135deg, #E2E8F0, #94A3B8); box-shadow: 0 5px 15px rgba(148, 163, 184, 0.4); }
    .rank-3-badge { background: linear-gradient(135deg, #FDBA74, #D97706); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.4); }
    .rank-other-badge { background: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0; }

    .dashed-divider { border-left: 1px dashed #E2E8F0; }

    .bg-secondary-subtle { background-color: #f1f5f9 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }

    /* 🔥 SUPER FULLSCREEN OVERRIDES 🔥 */
    body.fullscreen-active .wrapper,
    body.fullscreen-active .main-panel,
    body.fullscreen-active .container,
    body.fullscreen-active .page-inner,
    body.fullscreen-active #monitor-container {
        margin-top: 0 !important;
        padding-top: 0 !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        left: 0 !important;
    }

    body.fullscreen-active #monitor-container {
        padding: 0.5rem 1rem !important;
    }

    /* 🔥 DARK MODE THEME 🔥 */
    body.dark-mode, body.dark-mode #monitor-container { background-color: #121212 !important; color: #e0e0e0; }
    body.dark-mode .card, 
    body.dark-mode .bg-white, 
    body.dark-mode .bg-light,
    body.dark-mode #update-badge { background-color: #1e1e1e !important; border-color: #333 !important; }
    body.dark-mode .text-dark { color: #ffffff !important; }
    body.dark-mode .text-muted { color: #a0a0a0 !important; }
    body.dark-mode .dashed-divider { border-left-color: #444 !important; }
    
    body.dark-mode .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.15) !important; color: #6ea8fe !important; border-color: rgba(13, 110, 253, 0.3) !important; }
    body.dark-mode .bg-success-subtle { background-color: rgba(25, 135, 84, 0.15) !important; color: #75b798 !important; border-color: rgba(25, 135, 84, 0.3) !important; }
    body.dark-mode .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; border-color: rgba(108, 117, 125, 0.3) !important; }
    body.dark-mode .bg-info-subtle { background-color: rgba(13, 202, 240, 0.15) !important; color: #6edff6 !important; border-color: rgba(13, 202, 240, 0.3) !important; }
    
    body.dark-mode .btn-outline-dark { color: #fff; border-color: #fff; }
    body.dark-mode .btn-outline-dark:hover { background-color: #fff; color: #000; }
    
    body.dark-mode .text-primary { color: #6ea8fe !important; }
    body.dark-mode .text-success { color: #75b798 !important; }
    body.dark-mode .text-info { color: #6edff6 !important; }
</style>

<script>
    // Dark mode toggle functionality
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const btn = document.getElementById('btn-dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            btn.innerHTML = '<i class="fas fa-sun me-2"></i> Light Mode';
            btn.classList.replace('btn-outline-dark', 'btn-outline-light');
            localStorage.setItem('monitor-theme', 'dark');
        } else {
            btn.innerHTML = '<i class="fas fa-moon me-2"></i> Dark Mode';
            btn.classList.replace('btn-outline-light', 'btn-outline-dark');
            localStorage.setItem('monitor-theme', 'light');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Init dark mode from local storage
        if(localStorage.getItem('monitor-theme') === 'dark') {
            document.body.classList.add('dark-mode');
            const btn = document.getElementById('btn-dark-mode');
            if(btn) {
                btn.innerHTML = '<i class="fas fa-sun me-2"></i> Light Mode';
                btn.classList.replace('btn-outline-dark', 'btn-outline-light');
            }
        }

        const formatRp = (angka) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(angka);
        };

        const fetchMonitorData = async () => {
            try {
                const response = await fetch("{{ route('api.monitor.data') }}");
                const result = await response.json();
                
                if (result.status === 'success') {
                    if(result.bulan_tahun) {
                        document.getElementById('monitor-month').innerText = result.bulan_tahun;
                    }
                    renderStatCardsAndGrid(result.data);
                    document.getElementById('last-update').innerText = result.waktu;
                }
            } catch (error) {
                console.error("Gagal mengambil data Live Monitor", error);
            }
        };

        const renderStatCardsAndGrid = (data) => {
            const statContainer = document.getElementById('stat-cards-container');
            const marketingContainer = document.getElementById('marketing-cards-container');
            
            let grandTarget = 0, grandPenawaran = 0, grandDeal = 0, grandKpiTotal = 0;

            if(data.length === 0) {
                statContainer.innerHTML = `<div class="col-12 text-center text-muted fs-4 py-4 fw-bold">Belum ada data marketing</div>`;
                marketingContainer.innerHTML = '';
                return;
            }

            let cardsHtml = '';

            data.forEach((item, index) => {
                let valTarget = Number(item.target) || 0;
                let valPenawaran = Number(item.total_penawaran) || 0;
                let valDeal = Number(item.total_deal) || 0;
                let valKpi = Number(item.total_kpi) || 0;

                grandTarget += valTarget;
                grandPenawaran += valPenawaran;
                grandDeal += valDeal;
                grandKpiTotal += valKpi;

                let rankNumber = index + 1;
                let badgeClass = 'rank-other-badge';
                let rankIcon = rankNumber;
                
                if (rankNumber === 1) { badgeClass = 'rank-1-badge'; rankIcon = '<i class="fas fa-crown"></i>'; }
                else if (rankNumber === 2) { badgeClass = 'rank-2-badge'; rankIcon = '<i class="fas fa-medal"></i>'; }
                else if (rankNumber === 3) { badgeClass = 'rank-3-badge'; rankIcon = '<i class="fas fa-medal"></i>'; }

                let achColor = item.prosentase >= 100 ? 'text-success' : (item.prosentase >= 80 ? 'text-primary' : 'text-dark');
                let barColor = 'bg-success'; 

                // 🔥 LOGIKA WARNA KPI 🔥
                let kpiColor = valKpi < 70 ? 'text-danger' : 'text-info';
                let kpiBg = valKpi < 70 ? 'bg-danger-subtle border-danger' : 'bg-info-subtle border-info';

                // 🔥 LOGIKA WARNA DEAL OMSET 🔥
                let dealColor = 'text-success'; // Hijau jika >= 60jt
                if (valDeal < 30000000) {
                    dealColor = 'text-danger'; // Merah jika < 30jt
                } else if (valDeal < 60000000) {
                    dealColor = 'text-warning'; // Kuning jika < 60jt
                }

                cardsHtml += `
                    <div style="min-width: 0;">
                        <div class="card h-100 wide-marketing-card shadow-sm hover-lift p-2 m-0">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                
                                <div class="d-flex align-items-center ps-1" style="width: 35%;">
                                    <div class="rank-badge-wide ${badgeClass} me-3">${rankIcon}</div>
                                    <div style="min-width: 0;">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h4 class="fw-black text-dark mb-0 text-truncate text-uppercase" style="font-size: 1.25rem; letter-spacing: -0.5px;" title="${item.nama_lengkap}">${item.nama_lengkap}</h4>
                                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-0" style="font-size: 0.7rem;"><i class="fas fa-id-badge me-1"></i> ${item.nama}</span>
                                        </div>
                                        <!-- KPI DIBESARKAN & DI-HIGHLIGHT -->
                                        <div class="mt-2">
                                            <span class="badge ${kpiBg} ${kpiColor} border border-opacity-50 px-2 py-1 shadow-sm fw-black" style="font-size: 1.15rem; letter-spacing: 0.5px;">KPI: ${item.total_kpi}%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end px-2 dashed-divider" style="width: 28%;">
                                    <div class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.7rem; letter-spacing: 0.5px;">Penawaran</div>
                                    <div class="fw-black text-primary text-truncate" style="font-size: 1.5rem; letter-spacing: -0.5px;">${formatRp(valPenawaran)}</div>
                                </div>

                                <div class="text-end px-2 dashed-divider position-relative" style="width: 37%;">
                                    <div class="d-flex justify-content-end align-items-center mb-0 gap-1">
                                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Deal Omset</span>
                                        <span class="badge bg-success-subtle ${achColor} px-1 py-0 border border-success border-opacity-25 fw-black" style="font-size: 0.65rem;">Ach: ${item.prosentase}%</span>
                                    </div>
                                    <!-- WARNA DEAL OMSET DINAMIS -->
                                    <div class="fw-black ${dealColor} text-truncate" style="font-size: 1.8rem; letter-spacing: -1px;">${formatRp(valDeal)}</div>
                                    
                                    <div class="progress mt-1" style="background-color: #e9ecef; height: 6px; border-radius: 6px;">
                                        <div class="progress-bar ${barColor}" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 6px;"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                `;
            });

            let avgKpi = data.length > 0 ? (grandKpiTotal / data.length) : 0;
            let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

            statContainer.innerHTML = `
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-1 p-xl-2 d-flex align-items-center">
                            <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px; min-width: 45px;">
                                <i class="fas fa-bullseye" style="font-size: 1.3rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.75rem;">Target Keseluruhan</p>
                                <h4 class="fw-black text-dark mb-0 text-truncate" style="font-size: 1.4rem; letter-spacing: -1px;">${formatRp(grandTarget)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-1 p-xl-2 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px; min-width: 45px;">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 1.3rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.75rem;">Total Penawaran</p>
                                <h4 class="fw-black text-primary mb-0 text-truncate" style="font-size: 1.4rem; letter-spacing: -1px;">${formatRp(grandPenawaran)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-1 p-xl-2 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px; min-width: 45px;">
                                <i class="fas fa-handshake" style="font-size: 1.3rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <div class="d-flex align-items-center gap-1 mb-0">
                                    <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.75rem;">Deal Omset</p>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-1 py-0 rounded-pill fw-bold" style="font-size: 0.65rem;">Ach: ${grandAch.toFixed(1)}%</span>
                                </div>
                                <h4 class="fw-black text-success mb-0 text-truncate" style="font-size: 1.4rem; letter-spacing: -1px;">${formatRp(grandDeal)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-1 p-xl-2 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px; min-width: 45px;">
                                <i class="fas fa-chart-line" style="font-size: 1.3rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.75rem;">Rata-Rata KPI Tim</p>
                                <h4 class="fw-black text-info mb-0 text-truncate" style="font-size: 1.5rem; letter-spacing: -1px;">${avgKpi.toFixed(2)}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            marketingContainer.innerHTML = cardsHtml;
        };

        fetchMonitorData();
        setInterval(fetchMonitorData, 10000);
    });

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.error(`Gagal mengaktifkan Fullscreen: ${err.message}`);
            });
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }

    document.addEventListener('fullscreenchange', function() {
        const sidebar = document.querySelector('.sidebar');
        const navbar = document.querySelector('.main-header'); 

        if (document.fullscreenElement) {
            document.body.classList.add('fullscreen-active');
            if (sidebar) sidebar.style.display = 'none';
            if (navbar) navbar.style.display = 'none';
        } else {
            document.body.classList.remove('fullscreen-active');
            if (sidebar) sidebar.style.display = '';
            if (navbar) navbar.style.display = '';
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container-fluid py-2 tv-monitor-mode bg-light" id="monitor-container" style="min-height: 100vh; min-width: 1600px; overflow-x: hidden;">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-2 fade-in px-2">
        <div>
            <div class="d-inline-flex align-items-center bg-primary-subtle text-primary px-3 py-1 rounded-pill mb-1 shadow-sm border border-primary border-opacity-10">
                <i class="fas fa-satellite-dish fs-6 me-2 pulse-anim"></i>
                <span class="fw-bold fs-6" style="letter-spacing: 1.5px;">LIVE TRACKING SYSTEM</span>
            </div>
            <h2 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="font-size: 2.4rem; letter-spacing: -1px;">
                MONITORING MARKETING <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow border-0">
                <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;"></div>
                <span class="fw-bold text-dark fs-5">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-lg px-3 py-2 fw-bold hover-lift fs-5">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    {{-- STAT CARDS (Atas) --}}
    <div class="row g-2 mb-2 fade-in px-2" id="stat-cards-container">
        <div class="col-12 text-center py-3">
            <div class="spinner-border text-primary mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
            <h4 class="text-muted fw-bold">Sinkronisasi Server Data...</h4>
        </div>
    </div>

    {{-- LIST MARKETING (2 Kolom Lebar) --}}
    <div class="row g-2 fade-in px-2" id="marketing-cards-container">
        <!-- Injected by JS -->
    </div>
</div>

<style>
    /* TV Monitor Mode - Ultra Wide */
    .tv-monitor-mode { padding: 1rem 1.5rem !important; }
    
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }

    .wide-marketing-card { border-radius: 16px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }
    .stat-card-modern { border-radius: 16px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }

    /* RANK BADGES MODERN */
    .rank-badge-wide {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 900;
        color: white;
        flex-shrink: 0;
    }
    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #F59E0B); box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4); }
    .rank-2-badge { background: linear-gradient(135deg, #E2E8F0, #94A3B8); box-shadow: 0 5px 15px rgba(148, 163, 184, 0.4); }
    .rank-3-badge { background: linear-gradient(135deg, #FDBA74, #D97706); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.4); }
    .rank-other-badge { background: #F1F5F9; color: #64748B; border: 2px solid #E2E8F0; }

    .dashed-divider { border-left: 2px dashed #E2E8F0; }

    .bg-secondary-subtle { background-color: #f1f5f9 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
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

                // 🔥 IDE TERBAIK: 2 KOLOM RAKSASA (col-6) 🔥
                cardsHtml += `
                    <div class="col-6">
                        <div class="card h-100 wide-marketing-card shadow-sm hover-lift p-2">
                            <div class="d-flex align-items-center justify-content-between h-100">
                                
                                <!-- KIRI: Rank & Nama (Lebih Ringkas tanpa Foto) -->
                                <div class="d-flex align-items-center ps-1" style="width: 33%;">
                                    <div class="rank-badge-wide ${badgeClass} me-2">${rankIcon}</div>
                                    <div style="min-width: 0;">
                                        <h4 class="fw-black text-dark mb-0 text-truncate text-uppercase" style="font-size: 1.5rem; letter-spacing: -0.5px;" title="${item.nama_lengkap}">${item.nama_lengkap}</h4>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-1" style="font-size: 0.75rem;"><i class="fas fa-id-badge me-1"></i> ${item.nama}</span>
                                            <span class="text-info fw-black" style="font-size: 0.85rem;">KPI: ${item.total_kpi}%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- TENGAH: PENAWARAN (Angka Raksasa) -->
                                <div class="text-end px-3 dashed-divider" style="width: 30%;">
                                    <div class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Penawaran</div>
                                    <div class="fw-black text-primary text-truncate" style="font-size: 1.8rem; letter-spacing: -0.5px;">${formatRp(valPenawaran)}</div>
                                </div>

                                <!-- KANAN: DEAL (Angka Paling Raksasa) -->
                                <div class="text-end px-3 dashed-divider position-relative" style="width: 37%;">
                                    <div class="d-flex justify-content-end align-items-center mb-0 gap-2">
                                        <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Deal Omset</span>
                                        <span class="badge bg-success-subtle ${achColor} px-2 py-1 border border-success border-opacity-25 fw-black" style="font-size: 0.75rem;">Ach: ${item.prosentase}%</span>
                                    </div>
                                    <div class="fw-black text-success text-truncate" style="font-size: 2.2rem; letter-spacing: -1px;">${formatRp(valDeal)}</div>
                                    
                                    <!-- Progress bar numpang di bawah Deal biar compact -->
                                    <div class="progress mt-1" style="background-color: #e9ecef; height: 8px; border-radius: 8px;">
                                        <div class="progress-bar ${barColor}" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 8px;"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                `;
            });

            let avgKpi = data.length > 0 ? (grandKpiTotal / data.length) : 0;
            let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

            // Stat Cards (Tetap 4 Kolom)
            statContainer.innerHTML = `
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                            <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                                <i class="fas fa-bullseye" style="font-size: 1.6rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.85rem;">Target Keseluruhan</p>
                                <h4 class="fw-black text-dark mb-0 text-truncate" style="font-size: 1.7rem; letter-spacing: -1px;">${formatRp(grandTarget)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 1.6rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.85rem;">Total Penawaran</p>
                                <h4 class="fw-black text-primary mb-0 text-truncate" style="font-size: 1.7rem; letter-spacing: -1px;">${formatRp(grandPenawaran)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                                <i class="fas fa-handshake" style="font-size: 1.6rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <div class="d-flex align-items-center gap-2 mb-0">
                                    <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.85rem;">Deal Omset</p>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-0 rounded-pill fw-bold" style="font-size: 0.75rem;">Ach: ${grandAch.toFixed(1)}%</span>
                                </div>
                                <h4 class="fw-black text-success mb-0 text-truncate" style="font-size: 1.7rem; letter-spacing: -1px;">${formatRp(grandDeal)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                                <i class="fas fa-chart-line" style="font-size: 1.6rem;"></i>
                            </div>
                            <div style="min-width: 0;">
                                <p class="text-muted text-uppercase fw-bold mb-0 text-truncate" style="font-size: 0.85rem;">Rata-Rata KPI Tim</p>
                                <h4 class="fw-black text-info mb-0 text-truncate" style="font-size: 1.9rem; letter-spacing: -1px;">${avgKpi.toFixed(2)}%</h4>
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
        const mainPanel = document.querySelector('.main-panel');
        const navbar = document.querySelector('.main-header'); 
        const pageInner = document.querySelector('.page-inner');
        const mainContainer = document.querySelector('.main-panel > .container');

        if (document.fullscreenElement) {
            if (sidebar) sidebar.style.display = 'none';
            if (navbar) navbar.style.display = 'none';
            
            if (mainPanel) {
                mainPanel.style.width = '100%';
                mainPanel.style.left = '0';
                mainPanel.style.paddingTop = '0';
                mainPanel.style.paddingBottom = '0'; 
            }
            
            if (pageInner) {
                pageInner.classList.remove('mt-4');
                pageInner.style.padding = '0';
                pageInner.style.margin = '0';
            }
            
            if (mainContainer) {
                mainContainer.style.padding = '0';
                mainContainer.style.maxWidth = '100%';
            }
            
            const container = document.getElementById('monitor-container');
            if (container) {
                container.classList.remove('py-2');
                container.classList.add('py-0');
            }
        } else {
            if (sidebar) sidebar.style.display = '';
            if (navbar) navbar.style.display = '';
            
            if (mainPanel) {
                mainPanel.style.width = '';
                mainPanel.style.left = '';
                mainPanel.style.paddingTop = '';
                mainPanel.style.paddingBottom = '';
            }
            
            const container = document.getElementById('monitor-container');
            if (container) {
                container.classList.remove('py-0');
                container.classList.add('py-2');
            }
            
            if (pageInner) {
                pageInner.classList.add('mt-4');
                pageInner.style.padding = '';
                pageInner.style.margin = '';
            }
            
            if (mainContainer) {
                mainContainer.style.padding = '';
                mainContainer.style.maxWidth = '';
            }
        }
    });
</script>
@endsection
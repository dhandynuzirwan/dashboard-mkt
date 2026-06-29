@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 tv-monitor-mode bg-light" id="monitor-container" style="min-height: 100vh;">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5 fade-in px-2">
        <div>
            <div class="d-inline-flex align-items-center bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-3 shadow-sm border border-primary border-opacity-10">
                <i class="fas fa-satellite-dish fs-3 me-2 pulse-anim"></i>
                <span class="fw-bold fs-4" style="letter-spacing: 2px;">LIVE TRACKING SYSTEM</span>
            </div>
            <h1 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="font-size: 3.5rem; letter-spacing: -1.5px; text-shadow: 2px 2px 4px rgba(0,0,0,0.05);">
                MONITORING MARKETING <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h1>
        </div>
        <div class="d-flex gap-4 align-items-center">
            <div class="d-flex align-items-center bg-white px-5 py-3 rounded-pill shadow border-0">
                <div class="spinner-grow text-success me-3" role="status" style="width: 1.8rem; height: 1.8rem;"></div>
                <span class="fw-bold text-dark" style="font-size: 1.8rem;">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-lg px-5 py-3 fw-bold hover-lift" style="font-size: 1.8rem;">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    <div class="row g-4 mb-5 fade-in px-2" id="stat-cards-container">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary mb-3" style="width: 5rem; height: 5rem;" role="status"></div>
            <h2 class="text-muted fw-bold">Sinkronisasi Server Data...</h2>
        </div>
    </div>

    <div class="row g-4 fade-in px-2" id="marketing-cards-container">
        </div>
</div>

<style>
    /* TV Monitor Mode - Optimization for 40% Zoom */
    .tv-monitor-mode {
        padding-left: 3rem !important;
        padding-right: 3rem !important;
    }
    
    /* ANIMATIONS & EFFECTS */
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    
    .hover-lift { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-12px); box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important; }

    /* CARD MODERN STYLING */
    .marketing-card {
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .stat-card-modern {
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }

    /* RANK BADGES */
    .rank-badge {
        position: absolute;
        top: 25px;
        right: 25px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 900;
        color: white;
        z-index: 10;
    }
    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #F59E0B); border: 5px solid #fff; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.4); }
    .rank-2-badge { background: linear-gradient(135deg, #E2E8F0, #94A3B8); border: 5px solid #fff; box-shadow: 0 10px 20px rgba(148, 163, 184, 0.4); }
    .rank-3-badge { background: linear-gradient(135deg, #FDBA74, #D97706); border: 5px solid #fff; box-shadow: 0 10px 20px rgba(217, 119, 6, 0.4); }
    .rank-other-badge { background: #F1F5F9; color: #64748B; border: 5px solid #fff; }

    /* AVATAR GLOW */
    .avatar-gold { border: 8px solid #F59E0B; box-shadow: 0 0 35px rgba(245, 158, 11, 0.5); }
    .avatar-silver { border: 8px solid #CBD5E1; box-shadow: 0 0 30px rgba(148, 163, 184, 0.5); }
    .avatar-bronze { border: 8px solid #D97706; box-shadow: 0 0 30px rgba(217, 119, 6, 0.5); }
    .avatar-standard { border: 8px solid #F8FAFC; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }

    /* UTILITIES */
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
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
                statContainer.innerHTML = `<div class="col-12 text-center text-muted fs-1 py-5 fw-bold">Belum ada data marketing</div>`;
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

                // Rank Determination
                let rankNumber = index + 1;
                let badgeClass = 'rank-other-badge';
                let avatarClass = 'avatar-standard';
                let rankIcon = rankNumber;
                
                if (rankNumber === 1) { badgeClass = 'rank-1-badge'; avatarClass = 'avatar-gold'; rankIcon = '<i class="fas fa-crown"></i>'; }
                else if (rankNumber === 2) { badgeClass = 'rank-2-badge'; avatarClass = 'avatar-silver'; rankIcon = '<i class="fas fa-medal"></i>'; }
                else if (rankNumber === 3) { badgeClass = 'rank-3-badge'; avatarClass = 'avatar-bronze'; rankIcon = '<i class="fas fa-medal"></i>'; }

                let barColor = item.prosentase >= 80 ? 'bg-success' : (item.prosentase >= 50 ? 'bg-warning' : 'bg-danger');
                let achColor = item.prosentase >= 100 ? 'text-success' : (item.prosentase >= 80 ? 'text-primary' : 'text-dark');
                
                // Avatar size increased for 40% zoom
                let avatarHtml = `<div class="rounded-circle mx-auto ${avatarClass} bg-primary text-white d-flex align-items-center justify-content-center fw-black" style="width: 170px; height: 170px; font-size: 5rem; letter-spacing: -2px;">${item.nama.charAt(0).toUpperCase()}</div>`;
                if (item.foto) {
                    avatarHtml = `<img src="${item.foto}" class="rounded-circle mx-auto ${avatarClass}" style="width: 170px; height: 170px; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}';">`;
                }

                cardsHtml += `
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
                        <div class="card h-100 marketing-card shadow hover-lift position-relative">
                            <div class="${badgeClass} rank-badge shadow">${rankIcon}</div>
                            
                            <div class="card-body text-center p-4 p-xl-5 d-flex flex-column">
                                <div class="mb-4 pt-3 position-relative">
                                    ${avatarHtml}
                                </div>
                                
                                <div class="mb-4">
                                    <h2 class="fw-black text-dark mb-2 text-truncate px-2" style="font-size: 2.3rem; letter-spacing: -1px;" title="${item.nama_lengkap}">${item.nama_lengkap}</h2>
                                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-4 py-2 rounded-pill fw-bolder" style="font-size: 1.2rem;">
                                        <i class="fas fa-id-badge me-1"></i> ${item.nama}
                                    </span>
                                </div>
                                
                                <div class="bg-light rounded-4 p-4 mb-4 border border-light">
                                    <div class="mb-3 pb-3 border-bottom border-secondary border-opacity-10">
                                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1.1rem; letter-spacing: 1px;">Target Omset</div>
                                        <div class="fw-black text-secondary" style="font-size: 1.8rem;">${formatRp(valTarget)}</div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6 border-end border-secondary border-opacity-10">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1rem; letter-spacing: 1px;">Penawaran</div>
                                            <div class="fw-bolder text-primary" style="font-size: 1.3rem;">${formatRp(valPenawaran)}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1rem; letter-spacing: 1px;">Deal</div>
                                            <div class="fw-black text-success" style="font-size: 1.4rem;">${formatRp(valDeal)}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-end mb-3">
                                        <span class="fs-4 fw-bold text-muted">Achievement</span>
                                        <span class="fw-black ${achColor}" style="font-size: 2.8rem; line-height: 1;">${item.prosentase}%</span>
                                    </div>
                                    <div class="progress mb-4 bg-secondary bg-opacity-10" style="height: 24px; border-radius: 30px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                        <div class="progress-bar ${barColor} progress-fill fw-bold fs-5" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 30px;"></div>
                                    </div>
                                    
                                    <div class="pt-4 border-top border-secondary border-opacity-10">
                                        <div class="fw-bold text-muted text-uppercase mb-1" style="font-size: 1.2rem; letter-spacing: 1.5px;">Total Nilai KPI</div>
                                        <div class="fw-black text-info" style="font-size: 3.5rem; line-height: 1; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">${item.total_kpi}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            let avgKpi = data.length > 0 ? (grandKpiTotal / data.length) : 0;
            let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

            // 🔥 STAT CARDS KAIADMIN STYLE 🔥
            statContainer.innerHTML = `
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow h-100 hover-lift border-0">
                        <div class="card-body p-4 p-xl-5 d-flex align-items-center">
                            <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 110px; height: 110px; min-width: 110px;">
                                <i class="fas fa-bullseye" style="font-size: 3.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-2" style="font-size: 1.3rem; letter-spacing: 1px;">Target Keseluruhan</p>
                                <h3 class="fw-black text-dark mb-0" style="font-size: 2.8rem; letter-spacing: -1px;">${formatRp(grandTarget)}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow h-100 hover-lift border-0">
                        <div class="card-body p-4 p-xl-5 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 110px; height: 110px; min-width: 110px;">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 3.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-2" style="font-size: 1.3rem; letter-spacing: 1px;">Total Penawaran</p>
                                <h3 class="fw-black text-primary mb-0" style="font-size: 2.8rem; letter-spacing: -1px;">${formatRp(grandPenawaran)}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow h-100 hover-lift border-0">
                        <div class="card-body p-4 p-xl-5 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 110px; height: 110px; min-width: 110px;">
                                <i class="fas fa-handshake" style="font-size: 3.5rem;"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <p class="text-muted text-uppercase fw-bold mb-0" style="font-size: 1.3rem; letter-spacing: 1px;">Deal Omset</p>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-3 py-1 fs-4 rounded-pill fw-bold">Ach: ${grandAch.toFixed(1)}%</span>
                                </div>
                                <h3 class="fw-black text-success mb-0" style="font-size: 2.8rem; letter-spacing: -1px;">${formatRp(grandDeal)}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow h-100 hover-lift border-0">
                        <div class="card-body p-4 p-xl-5 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 110px; height: 110px; min-width: 110px;">
                                <i class="fas fa-chart-line" style="font-size: 3.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-2" style="font-size: 1.3rem; letter-spacing: 1px;">Rata-Rata KPI Tim</p>
                                <h3 class="fw-black text-info mb-0" style="font-size: 3.5rem; letter-spacing: -1px;">${avgKpi.toFixed(2)}%</h3>
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

        if (document.fullscreenElement) {
            if (sidebar) sidebar.style.display = 'none';
            if (navbar) navbar.style.display = 'none';
            
            if (mainPanel) {
                mainPanel.style.width = '100%';
                mainPanel.style.left = '0';
                mainPanel.style.paddingTop = '20px';
                mainPanel.style.paddingBottom = '30px'; 
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
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 tv-monitor-mode bg-light" id="monitor-container" style="min-height: 100vh;">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in px-2">
        <div>
            <div class="d-inline-flex align-items-center bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2 shadow-sm border border-primary border-opacity-10">
                <i class="fas fa-satellite-dish fs-4 me-2 pulse-anim"></i>
                <span class="fw-bold fs-5" style="letter-spacing: 1px;">LIVE TRACKING SYSTEM</span>
            </div>
            <h1 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="font-size: 2.5rem; letter-spacing: -1px; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">
                MONITORING MARKETING <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h1>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-4 py-2 rounded-pill shadow border-0">
                <div class="spinner-grow text-success me-2" role="status" style="width: 1.2rem; height: 1.2rem;"></div>
                <span class="fw-bold text-dark" style="font-size: 1.2rem;">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-lg px-4 py-2 fw-bold hover-lift" style="font-size: 1.2rem;">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4 fade-in px-2" id="stat-cards-container">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary mb-3" style="width: 4rem; height: 4rem;" role="status"></div>
            <h2 class="text-muted fw-bold">Sinkronisasi Server Data...</h2>
        </div>
    </div>

    <div class="row g-3 fade-in px-2" id="marketing-cards-container">
        </div>
</div>

<style>
    /* TV Monitor Mode */
    .tv-monitor-mode {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }
    
    /* ANIMATIONS & EFFECTS */
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    
    .hover-lift { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }

    /* CARD MODERN STYLING */
    .marketing-card {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .stat-card-modern {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }

    /* RANK BADGES */
    .rank-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 900;
        color: white;
        z-index: 10;
    }
    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #F59E0B); border: 4px solid #fff; box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3); }
    .rank-2-badge { background: linear-gradient(135deg, #E2E8F0, #94A3B8); border: 4px solid #fff; box-shadow: 0 5px 15px rgba(148, 163, 184, 0.3); }
    .rank-3-badge { background: linear-gradient(135deg, #FDBA74, #D97706); border: 4px solid #fff; box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3); }
    .rank-other-badge { background: #F1F5F9; color: #64748B; border: 4px solid #fff; }

    /* AVATAR GLOW */
    .avatar-gold { border: 6px solid #F59E0B; box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); }
    .avatar-silver { border: 6px solid #CBD5E1; box-shadow: 0 0 20px rgba(148, 163, 184, 0.4); }
    .avatar-bronze { border: 6px solid #D97706; box-shadow: 0 0 20px rgba(217, 119, 6, 0.4); }
    .avatar-standard { border: 6px solid #F8FAFC; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

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
                statContainer.innerHTML = `<div class="col-12 text-center text-muted fs-3 py-5 fw-bold">Belum ada data marketing</div>`;
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

                let barColor = 'bg-success'; 
                let achColor = item.prosentase >= 100 ? 'text-success' : (item.prosentase >= 80 ? 'text-primary' : 'text-dark');
                
                let avatarHtml = `<div class="rounded-circle mx-auto ${avatarClass} bg-primary text-white d-flex align-items-center justify-content-center fw-black" style="width: 110px; height: 110px; font-size: 3.5rem; letter-spacing: -2px;">${item.nama.charAt(0).toUpperCase()}</div>`;
                if (item.foto) {
                    avatarHtml = `<img src="${item.foto}" class="rounded-circle mx-auto ${avatarClass}" style="width: 110px; height: 110px; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}';">`;
                }

                cardsHtml += `
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
                        <div class="card h-100 marketing-card shadow-sm hover-lift position-relative">
                            <div class="${badgeClass} rank-badge shadow-sm">${rankIcon}</div>
                            
                            <div class="card-body text-center p-3 p-xl-4 d-flex flex-column">
                                <div class="mb-3 pt-2 position-relative">
                                    ${avatarHtml}
                                </div>
                                
                                <div class="mb-3">
                                    <h2 class="fw-black text-dark mb-2 text-truncate px-2" style="font-size: 2.2rem; letter-spacing: -1px; line-height: 1.1;" title="${item.nama_lengkap}">${item.nama_lengkap}</h2>
                                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill fw-bolder" style="font-size: 0.9rem;">
                                        <i class="fas fa-id-badge me-1"></i> ${item.nama}
                                    </span>
                                </div>
                                
                                <div class="bg-light rounded-4 p-3 mb-3 border border-light">
                                    <div class="mb-2 pb-2 border-bottom border-secondary border-opacity-10">
                                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Target Omset</div>
                                        <div class="fw-bold text-secondary" style="font-size: 1.1rem;">${formatRp(valTarget)}</div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6 border-end border-secondary border-opacity-10">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.9rem; letter-spacing: 0.5px;">Penawaran</div>
                                            <div class="fw-black text-primary" style="font-size: 1.4rem; letter-spacing: -0.5px;">${formatRp(valPenawaran)}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.9rem; letter-spacing: 0.5px;">Deal</div>
                                            <div class="fw-black text-success" style="font-size: 1.5rem; letter-spacing: -0.5px;">${formatRp(valDeal)}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-end mb-2">
                                        <span class="fs-6 fw-bold text-muted">Achievement</span>
                                        <span class="fw-black ${achColor}" style="font-size: 2rem; line-height: 1;">${item.prosentase}%</span>
                                    </div>
                                    <div class="progress mb-3" style="background-color: #e9ecef; height: 16px; border-radius: 20px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                        <div class="progress-bar ${barColor} progress-fill fw-bold" style="font-size: 0.8rem; width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 20px;"></div>
                                    </div>
                                    
                                    <div class="pt-3 border-top border-secondary border-opacity-10">
                                        <div class="fw-bold text-muted text-uppercase mb-1" style="font-size: 0.9rem; letter-spacing: 1px;">Total Nilai KPI</div>
                                        <div class="fw-black text-info" style="font-size: 2.2rem; line-height: 1; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">${item.total_kpi}%</div>
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
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                            <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; min-width: 70px;">
                                <i class="fas fa-bullseye" style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1rem; letter-spacing: 1px;">Target Keseluruhan</p>
                                <h3 class="fw-black text-dark mb-0" style="font-size: 2rem; letter-spacing: -1px;">${formatRp(grandTarget)}</h3>
                                <p class="text-muted fw-bold mt-1 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i> Beban target agregat tim</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; min-width: 70px;">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1rem; letter-spacing: 1px;">Total Penawaran</p>
                                <h3 class="fw-black text-primary mb-0" style="font-size: 2rem; letter-spacing: -1px;">${formatRp(grandPenawaran)}</h3>
                                <p class="text-primary fw-bold mt-1 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i> Potensi nilai pipeline</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; min-width: 70px;">
                                <i class="fas fa-handshake" style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <p class="text-muted text-uppercase fw-bold mb-0" style="font-size: 1rem; letter-spacing: 1px;">Deal Omset</p>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-1 fs-6 rounded-pill fw-bold">Ach: ${grandAch.toFixed(1)}%</span>
                                </div>
                                <h3 class="fw-black text-success mb-0" style="font-size: 2rem; letter-spacing: -1px;">${formatRp(grandDeal)}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-2">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 p-xl-4 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; min-width: 70px;">
                                <i class="fas fa-chart-line" style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 1rem; letter-spacing: 1px;">Rata-Rata KPI Tim</p>
                                <h3 class="fw-black text-info mb-0" style="font-size: 2.5rem; letter-spacing: -1px;">${avgKpi.toFixed(2)}%</h3>
                                <p class="text-info fw-bold mt-1 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i> Kesehatan performa gabungan</p>
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
                mainPanel.style.paddingTop = '10px';
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
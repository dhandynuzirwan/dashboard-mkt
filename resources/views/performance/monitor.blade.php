@extends('layouts.app')

@section('content')
<div class="container-fluid py-3 tv-monitor-mode bg-light" id="monitor-container" style="min-height: 100vh;">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 fade-in px-2">
        <div>
            <div class="d-inline-flex align-items-center bg-primary-subtle text-primary px-3 py-1 rounded-pill mb-1 shadow-sm border border-primary border-opacity-10">
                <i class="fas fa-satellite-dish fs-6 me-2 pulse-anim"></i>
                <span class="fw-bold fs-6" style="letter-spacing: 1px;">LIVE TRACKING SYSTEM</span>
            </div>
            <h2 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="letter-spacing: -0.5px;">
                MONITORING MARKETING <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow border-0">
                <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;"></div>
                <span class="fw-bold text-dark fs-6">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-lg px-3 py-2 fw-bold hover-lift">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    <div class="row g-3 mb-3 fade-in px-2" id="stat-cards-container">
        <div class="col-12 text-center py-4">
            <div class="spinner-border text-primary mb-2" role="status"></div>
            <h4 class="text-muted fw-bold">Sinkronisasi Server Data...</h4>
        </div>
    </div>

    <div class="row g-2 fade-in px-2" id="marketing-cards-container">
        </div>
</div>

<style>
    /* TV Monitor Mode - Normal Sizing for Hardware Zoom */
    .tv-monitor-mode {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    .pulse-anim { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
    
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }

    .marketing-card { border-radius: 16px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }
    .stat-card-modern { border-radius: 16px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }

    .rank-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 900;
        color: white;
        z-index: 10;
    }
    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #F59E0B); border: 2px solid #fff; box-shadow: 0 3px 10px rgba(245, 158, 11, 0.3); }
    .rank-2-badge { background: linear-gradient(135deg, #E2E8F0, #94A3B8); border: 2px solid #fff; box-shadow: 0 3px 10px rgba(148, 163, 184, 0.3); }
    .rank-3-badge { background: linear-gradient(135deg, #FDBA74, #D97706); border: 2px solid #fff; box-shadow: 0 3px 10px rgba(217, 119, 6, 0.3); }
    .rank-other-badge { background: #F1F5F9; color: #64748B; border: 2px solid #fff; }

    .avatar-gold { border: 4px solid #F59E0B; box-shadow: 0 0 15px rgba(245, 158, 11, 0.4); }
    .avatar-silver { border: 4px solid #CBD5E1; box-shadow: 0 0 15px rgba(148, 163, 184, 0.4); }
    .avatar-bronze { border: 4px solid #D97706; box-shadow: 0 0 15px rgba(217, 119, 6, 0.4); }
    .avatar-standard { border: 4px solid #F8FAFC; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

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
                let avatarClass = 'avatar-standard';
                let rankIcon = rankNumber;
                
                if (rankNumber === 1) { badgeClass = 'rank-1-badge'; avatarClass = 'avatar-gold'; rankIcon = '<i class="fas fa-crown"></i>'; }
                else if (rankNumber === 2) { badgeClass = 'rank-2-badge'; avatarClass = 'avatar-silver'; rankIcon = '<i class="fas fa-medal"></i>'; }
                else if (rankNumber === 3) { badgeClass = 'rank-3-badge'; avatarClass = 'avatar-bronze'; rankIcon = '<i class="fas fa-medal"></i>'; }

                let barColor = 'bg-success'; 
                let achColor = item.prosentase >= 100 ? 'text-success' : (item.prosentase >= 80 ? 'text-primary' : 'text-dark');
                
                let avatarHtml = `<div class="rounded-circle mx-auto ${avatarClass} bg-primary text-white d-flex align-items-center justify-content-center fw-black" style="width: 75px; height: 75px; font-size: 2rem;">${item.nama.charAt(0).toUpperCase()}</div>`;
                if (item.foto) {
                    avatarHtml = `<img src="${item.foto}" class="rounded-circle mx-auto ${avatarClass}" style="width: 75px; height: 75px; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}';">`;
                }

                // 🔥 PAKSA 6 KOLOM dengan "col-2" murni. Jangan pakai col-md-4 yang bikin pecah jadi 3 baris 🔥
                cardsHtml += `
                    <div class="col-2">
                        <div class="card h-100 marketing-card shadow-sm hover-lift position-relative">
                            <div class="${badgeClass} rank-badge shadow-sm">${rankIcon}</div>
                            
                            <div class="card-body text-center p-2 d-flex flex-column">
                                <div class="mb-2 pt-1 position-relative">
                                    ${avatarHtml}
                                </div>
                                
                                <div class="mb-2">
                                    <h5 class="fw-black text-dark mb-1 text-truncate px-1" title="${item.nama_lengkap}">${item.nama_lengkap}</h5>
                                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill fw-bolder" style="font-size: 0.75rem;">
                                        <i class="fas fa-id-badge me-1"></i> ${item.nama}
                                    </span>
                                </div>
                                
                                <div class="bg-light rounded-3 p-2 mb-2 border border-light">
                                    <div class="mb-1 pb-1 border-bottom border-secondary border-opacity-10">
                                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Target Omset</div>
                                        <div class="fw-bold text-secondary" style="font-size: 0.85rem;">${formatRp(valTarget)}</div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-6 border-end border-secondary border-opacity-10">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Penawaran</div>
                                            <div class="fw-black text-primary" style="font-size: 0.9rem; letter-spacing: -0.5px;">${formatRp(valPenawaran)}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Deal</div>
                                            <div class="fw-black text-success" style="font-size: 1rem; letter-spacing: -0.5px;">${formatRp(valDeal)}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-end mb-1">
                                        <span class="fw-bold text-muted" style="font-size: 0.75rem;">Achievement</span>
                                        <span class="fw-black ${achColor}" style="font-size: 1.1rem; line-height: 1;">${item.prosentase}%</span>
                                    </div>
                                    <div class="progress mb-2" style="background-color: #e9ecef; height: 10px; border-radius: 10px;">
                                        <div class="progress-bar ${barColor} progress-fill fw-bold" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 10px;"></div>
                                    </div>
                                    
                                    <div class="pt-2 border-top border-secondary border-opacity-10">
                                        <div class="fw-bold text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Total KPI</div>
                                        <div class="fw-black text-info" style="font-size: 1.4rem; line-height: 1;">${item.total_kpi}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            let avgKpi = data.length > 0 ? (grandKpiTotal / data.length) : 0;
            let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

            // 🔥 PAKSA 4 KOLOM dengan "col-3" murni. 🔥
            statContainer.innerHTML = `
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="fas fa-bullseye" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Target Keseluruhan</p>
                                <h4 class="fw-black text-dark mb-0">${formatRp(grandTarget)}</h4>
                                <p class="text-muted fw-bold mt-1 mb-0" style="font-size: 0.7rem;"><i class="fas fa-info-circle me-1"></i> Beban agregat tim</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="fas fa-file-invoice-dollar" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Total Penawaran</p>
                                <h4 class="fw-black text-primary mb-0">${formatRp(grandPenawaran)}</h4>
                                <p class="text-primary fw-bold mt-1 mb-0" style="font-size: 0.7rem;"><i class="fas fa-info-circle me-1"></i> Potensi pipeline</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="fas fa-handshake" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <p class="text-muted text-uppercase fw-bold mb-0" style="font-size: 0.8rem;">Deal Omset</p>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-1 rounded-pill fw-bold" style="font-size: 0.7rem;">Ach: ${grandAch.toFixed(1)}%</span>
                                </div>
                                <h4 class="fw-black text-success mb-0">${formatRp(grandDeal)}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-circle bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="fas fa-chart-line" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Rata-Rata KPI Tim</p>
                                <h4 class="fw-black text-info mb-0">${avgKpi.toFixed(2)}%</h4>
                                <p class="text-info fw-bold mt-1 mb-0" style="font-size: 0.7rem;"><i class="fas fa-info-circle me-1"></i> Kesehatan performa</p>
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
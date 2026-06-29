@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 tv-monitor-mode" id="monitor-container">
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="fw-black text-dark mb-0 text-uppercase" id="monitor-title" style="font-size: 3rem; letter-spacing: -1px;">
                <i class="fas fa-tv text-primary me-2"></i> MONITORING MARKETING - <span id="monitor-month">MEMUAT...</span>
            </h1>
            <p class="text-muted mb-0 fs-3">Live Performance Tracking Marketing & Sales</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-4 py-3 rounded-pill shadow-sm border">
                <div class="spinner-grow text-success me-3" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                <span class="fw-bold text-dark fs-4">Live Updates: <span id="last-update" class="text-primary">Memuat...</span></span>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-sm px-4 py-3 fs-4">
                <i class="fas fa-expand me-2"></i> Fullscreen
            </button>
        </div>
    </div>

    <!-- STAT CARDS KESELURUHAN -->
    <div class="row mb-5 fade-in" id="stat-cards-container">
        <!-- Injected by JS -->
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
            <h3 class="mt-3 text-muted">Menghubungkan ke server data...</h3>
        </div>
    </div>

    <!-- 12 CARD MARKETING -->
    <div class="row g-4 fade-in" id="marketing-cards-container">
        <!-- Injected by JS -->
    </div>
</div>

<style>
    /* TV Monitor Mode - Make things larger to accommodate 40% zoom */
    .tv-monitor-mode {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }
    
    .tv-monitor-mode .card {
        border-radius: 24px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .tv-monitor-mode .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* Rank Badges */
    .rank-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 900;
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 10;
    }

    .rank-1-badge { background: linear-gradient(135deg, #FFD700, #FDB931); border: 4px solid #fff; }
    .rank-2-badge { background: linear-gradient(135deg, #C0C0C0, #8A9EA0); border: 4px solid #fff; }
    .rank-3-badge { background: linear-gradient(135deg, #CD7F32, #A0522D); border: 4px solid #fff; }
    .rank-other-badge { background: #e2e8f0; color: #64748b; border: 4px solid #fff; }

    /* Avatar Borders */
    .avatar-gold { border: 6px solid #FFD700; box-shadow: 0 0 25px rgba(255, 215, 0, 0.6); }
    .avatar-silver { border: 6px solid #C0C0C0; box-shadow: 0 0 20px rgba(192, 192, 192, 0.6); }
    .avatar-bronze { border: 6px solid #CD7F32; box-shadow: 0 0 20px rgba(205, 127, 50, 0.6); }
    .avatar-standard { border: 6px solid #f1f5f9; }

    /* Stat Cards top */
    .stat-card-top {
        border-radius: 20px;
        background: white;
        border-bottom: 8px solid #e2e8f0;
    }
    .stat-card-target { border-bottom-color: #64748b; }
    .stat-card-penawaran { border-bottom-color: #3b82f6; }
    .stat-card-deal { border-bottom-color: #22c55e; }
    .stat-card-kpi { border-bottom-color: #0ea5e9; }
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
                    // Update Title Month/Year
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
            
            let grandTarget = 0;
            let grandPenawaran = 0;
            let grandDeal = 0;
            let grandKpiTotal = 0;

            if(data.length === 0) {
                statContainer.innerHTML = `<div class="col-12 text-center text-muted fs-3 py-5">Belum ada data marketing</div>`;
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
                
                if (rankNumber === 1) { badgeClass = 'rank-1-badge'; avatarClass = 'avatar-gold'; rankIcon = '<i class="fas fa-crown"></i> 1'; }
                else if (rankNumber === 2) { badgeClass = 'rank-2-badge'; avatarClass = 'avatar-silver'; rankIcon = '<i class="fas fa-medal"></i> 2'; }
                else if (rankNumber === 3) { badgeClass = 'rank-3-badge'; avatarClass = 'avatar-bronze'; rankIcon = '<i class="fas fa-medal"></i> 3'; }

                let barColor = item.prosentase >= 80 ? 'bg-success' : (item.prosentase >= 50 ? 'bg-warning' : 'bg-danger');
                let achColor = item.prosentase >= 100 ? 'text-success' : (item.prosentase >= 80 ? 'text-primary' : 'text-dark');
                
                // Avatar fallback
                let avatarHtml = `<div class="rounded-circle mx-auto ${avatarClass} shadow-sm bg-primary text-white d-flex align-items-center justify-content-center fw-black" style="width: 140px; height: 140px; font-size: 4rem;">${item.nama.charAt(0).toUpperCase()}</div>`;
                if (item.foto) {
                    avatarHtml = `<img src="${item.foto}" class="rounded-circle mx-auto ${avatarClass} shadow-sm" style="width: 140px; height: 140px; object-fit: cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}';">`;
                }

                // 6 Columns (col-xl-2)
                cardsHtml += `
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card h-100 shadow-lg border-0 bg-white position-relative">
                            <div class="${badgeClass} rank-badge">${rankIcon}</div>
                            
                            <div class="card-body text-center p-4 pt-5">
                                <div class="mb-4 position-relative">
                                    ${avatarHtml}
                                </div>
                                
                                <h3 class="fw-black text-dark mb-1" style="font-size: 1.6rem; letter-spacing: -0.5px;">${item.nama_lengkap}</h3>
                                <p class="text-muted fs-5 mb-4 fw-bold"><i class="fas fa-id-badge me-1"></i> ${item.nama}</p>
                                
                                <div class="bg-light rounded-4 p-3 mb-4">
                                    <div class="mb-3">
                                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.9rem; letter-spacing: 1px;">Target</div>
                                        <div class="fs-4 fw-black text-secondary">${formatRp(valTarget)}</div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6 border-end">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Penawaran</div>
                                            <div class="fs-6 fw-bold text-primary">${formatRp(valPenawaran)}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Deal</div>
                                            <div class="fs-6 fw-black text-success">${formatRp(valDeal)}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-end mb-2">
                                    <span class="fs-5 fw-bold text-muted">Pencapaian</span>
                                    <span class="fw-black ${achColor}" style="font-size: 2rem; line-height: 1;">${item.prosentase}%</span>
                                </div>
                                <div class="progress mb-4 bg-light shadow-inner" style="height: 16px; border-radius: 20px;">
                                    <div class="progress-bar ${barColor} progress-fill" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%; border-radius: 20px;"></div>
                                </div>
                                
                                <div class="mt-auto pt-3 border-top">
                                    <div class="fw-bold text-muted text-uppercase mb-1" style="font-size: 0.9rem; letter-spacing: 1px;">Total KPI</div>
                                    <div class="fw-black text-info" style="font-size: 2.5rem; line-height: 1;">${item.total_kpi}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            // Calculate Overall KPI Average
            let avgKpi = data.length > 0 ? (grandKpiTotal / data.length) : 0;
            let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

            // Render Stat Cards
            statContainer.innerHTML = `
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card-top stat-card-target shadow-sm h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted fw-bold text-uppercase mb-2 fs-5" style="letter-spacing: 1px;">Total Target Keseluruhan</p>
                                <h2 class="fw-black text-dark mb-0" style="font-size: 2.2rem;">${formatRp(grandTarget)}</h2>
                            </div>
                            <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-bullseye fs-1 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card-top stat-card-penawaran shadow-sm h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-primary fw-bold text-uppercase mb-2 fs-5" style="letter-spacing: 1px;">Total Penawaran</p>
                                <h2 class="fw-black text-primary mb-0" style="font-size: 2.2rem;">${formatRp(grandPenawaran)}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-file-invoice-dollar fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card-top stat-card-deal shadow-sm h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-success fw-bold text-uppercase mb-2 fs-5" style="letter-spacing: 1px;">Total Deal Omset</p>
                                <h2 class="fw-black text-success mb-0" style="font-size: 2.2rem;">${formatRp(grandDeal)}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-handshake fs-1 text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="fs-5 fw-bold text-muted">Ach: <span class="text-success fw-black">${grandAch.toFixed(1)}%</span></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card-top stat-card-kpi shadow-sm h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-info fw-bold text-uppercase mb-2 fs-5" style="letter-spacing: 1px;">Rata-Rata Total KPI</p>
                                <h2 class="fw-black text-info mb-0" style="font-size: 2.5rem;">${avgKpi.toFixed(2)}%</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fas fa-chart-line fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            marketingContainer.innerHTML = cardsHtml;
        };

        // Initial Load
        fetchMonitorData();

        // Auto Reload every 10 seconds
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
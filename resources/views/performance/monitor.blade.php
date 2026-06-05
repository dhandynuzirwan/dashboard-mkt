@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 kai-art-monitor" id="monitor-container">
    {{-- Elemen Latar Belakang Estetik --}}
    <div class="ambient-light light-1"></div>
    <div class="ambient-light light-2"></div>

    {{-- HEADER TRACKING --}}
    <div class="d-flex justify-content-between align-items-center mb-5 fade-in position-relative z-index-2">
        <div>
            <h2 class="fw-bolder text-white mb-0 text-glow">
                <i class="fas fa-tv text-info me-2 pulse-icon"></i> Live Monitor Center
            </h2>
            <p class="text-info opacity-75 mb-0" style="letter-spacing: 1px;">MARKETING & SALES PERFORMANCE TRACKING</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="glass-pill px-4 py-2 d-flex align-items-center">
                <div class="spinner-grow spinner-grow-sm text-neon-green me-2" role="status" style="width: 14px; height: 14px; box-shadow: 0 0 10px #00ff88;"></div>
                <span class="fw-bold text-white" style="font-size: 13px; letter-spacing: 0.5px;">SYNC: <span id="last-update" class="text-neon-green">Memuat...</span></span>
            </div>
            {{-- Tombol Fullscreen TV --}}
            <button onclick="toggleFullScreen()" class="btn btn-glass btn-round">
                <i class="fas fa-expand me-1"></i> Fullscreen
            </button>
        </div>
    </div>

    {{-- PODIUM LEADERBOARD --}}
    <div id="podium-container" class="d-flex justify-content-center align-items-end mb-5 fade-in gap-4 position-relative z-index-2" style="min-height: 250px;">
        {{-- Diisi oleh Javascript --}}
    </div>

    {{-- MAIN TABLE DATA --}}
    <div class="card art-card border-0 fade-in position-relative z-index-2">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless align-middle text-center mb-0 art-table" style="min-width: 1000px;">
                    <thead class="glass-header text-info" style="font-size: 13px; letter-spacing: 1.5px;">
                        <tr>
                            <th class="text-center py-4" width="5%">RANK</th>
                            <th class="text-start ps-4 py-4">MARKETING OFFICER</th>
                            <th class="py-4">TARGET OMSET</th>
                            <th class="py-4">PENAWARAN</th>
                            <th class="text-neon-green py-4"><i class="fas fa-check-circle me-1"></i> TOTAL DEAL</th>
                            <th class="py-4" width="20%">ACHIEVEMENT</th>
                            <th class="py-4">KPI SCORE</th>
                        </tr>
                    </thead>
                    <tbody id="monitor-table-body" style="font-size: 16px; font-weight: 500;">
                        <tr>
                            <td colspan="8" class="py-5 text-center">
                                <div class="spinner-border text-info mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                                <h5 class="text-white opacity-50 fw-light">Menghubungkan ke secure server...</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* =========================================================================
       1. OVERRIDE STRICT UNTUK KAIADMIN
       ========================================================================= */
    .kai-art-monitor {
        font-family: 'Public Sans', 'Segoe UI', sans-serif !important;
        background-color: #070913 !important;
        background-image: 
            radial-gradient(at 0% 0%, rgba(13, 22, 59, 1) 0, transparent 50%), 
            radial-gradient(at 100% 100%, rgba(8, 43, 40, 1) 0, transparent 50%) !important;
        min-height: 100vh;
        position: relative;
        padding: 24px;
        overflow-x: hidden;
    }

    /* 🔥 ATURAN KHUSUS KETIKA MODE FULLSCREEN AKTIF 🔥 */
    .kai-art-monitor:fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 40px !important; /* Memberi ruang di mode fullscreen */
        overflow-y: auto !important; /* Agar bisa discroll jika data panjang */
    }
    .kai-art-monitor:-webkit-full-screen { /* Untuk Chrome/Safari */
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 40px !important;
        overflow-y: auto !important;
    }

    .kai-art-monitor .text-white { color: #ffffff !important; }
    .kai-art-monitor .text-info { color: #00e5ff !important; }
    
    /* =========================================================================
       2. MEMPERBAIKI HEADER TABEL YANG PUTIH
       ========================================================================= */
    .kai-art-monitor .art-table, 
    .kai-art-monitor .art-table tbody, 
    .kai-art-monitor .art-table tr, 
    .kai-art-monitor .art-table td {
        background: transparent !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
    }
    
    /* Memaksa Header (TH) bebas dari warna bawaan KaiAdmin */
    .kai-art-monitor .art-table thead,
    .kai-art-monitor .art-table thead tr,
    .kai-art-monitor .art-table thead th,
    .kai-art-monitor .glass-header {
        background-color: rgba(0, 0, 0, 0.4) !important;
        color: #00e5ff !important;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
        border-top: none !important;
    }

    .kai-art-monitor .art-table td { padding-top: 20px; padding-bottom: 20px; }
    .kai-art-monitor .art-table tr:hover td { background: rgba(255, 255, 255, 0.03) !important; }

    /* =========================================================================
       3. EFEK VISUAL (GLASSMORPHISM & AMBIENT)
       ========================================================================= */
    .kai-art-monitor .ambient-light {
        position: absolute;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.35;
        z-index: 1;
        animation: floatArt 8s infinite ease-in-out alternate;
        pointer-events: none;
    }
    .kai-art-monitor .light-1 { width: 350px; height: 350px; background: rgba(0, 229, 255, 0.2); top: -50px; left: -50px; }
    .kai-art-monitor .light-2 { width: 450px; height: 450px; background: rgba(0, 255, 136, 0.15); bottom: -100px; right: -100px; animation-delay: -4s; }

    .kai-art-monitor .art-card {
        background: rgba(255, 255, 255, 0.03) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
        overflow: hidden;
    }
    
    .kai-art-monitor .glass-pill {
        background: rgba(255, 255, 255, 0.04) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 50px;
    }

    .kai-art-monitor .btn-glass {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }
    .kai-art-monitor .btn-glass:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #00e5ff !important;
        border-color: #00e5ff !important;
        box-shadow: 0 0 15px rgba(0, 229, 255, 0.4);
    }

    /* =========================================================================
       4. PROGRESS BAR & NEON UTILITIES
       ========================================================================= */
    .kai-art-monitor .progress-bar-custom {
        height: 8px;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.1) !important;
        margin-top: 8px;
        overflow: hidden;
    }
    .kai-art-monitor .progress-fill { height: 100%; border-radius: 10px; transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1); }
    .kai-art-monitor .fill-success { background: #00ff88 !important; box-shadow: 0 0 10px #00ff88; }
    .kai-art-monitor .fill-warning { background: #ffd700 !important; box-shadow: 0 0 10px #ffd700; }
    .kai-art-monitor .fill-danger { background: #ff4757 !important; box-shadow: 0 0 10px #ff4757; }

    .kai-art-monitor .text-glow { text-shadow: 0 0 15px rgba(255, 255, 255, 0.4); }
    .kai-art-monitor .text-neon-green { color: #00ff88 !important; text-shadow: 0 0 10px rgba(0, 255, 136, 0.4); }
    .kai-art-monitor .text-neon-blue { color: #00e5ff !important; }
    .kai-art-monitor .z-index-2 { z-index: 2; }
    
    .kai-art-monitor .fade-in { animation: fadeInUpArt 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
    .kai-art-monitor .pulse-icon { animation: pulseArt 2s infinite; }
    @keyframes fadeInUpArt { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes floatArt { 0% { transform: translate(0, 0); } 100% { transform: translate(25px, 25px); } }
    @keyframes pulseArt { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }

    /* =========================================================================
       5. PODIUM SYSTEM
       ========================================================================= */
    .kai-art-monitor .podium-box { text-align: center; position: relative; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .kai-art-monitor .podium-box:hover { transform: translateY(-10px) scale(1.03); }
    
    .kai-art-monitor .podium-img {
        width: 100px; height: 100px; object-fit: cover; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; font-weight: bold; color: #fff;
    }
    
    .kai-art-monitor .podium-1 { transform: translateY(-25px); z-index: 3; }
    .kai-art-monitor .podium-1 .podium-img { border: 5px solid #ffd700 !important; box-shadow: 0 0 25px rgba(255, 215, 0, 0.4); width: 135px; height: 135px; }
    .kai-art-monitor .podium-1 .podium-rank { background: linear-gradient(135deg, #FFD700, #B8860B); color: #000 !important; }
    
    .kai-art-monitor .podium-2 .podium-img { border: 4px solid #c0c0c0 !important; box-shadow: 0 0 15px rgba(192, 192, 192, 0.2); }
    .kai-art-monitor .podium-2 .podium-rank { background: linear-gradient(135deg, #E0E0E0, #808080); color: #000 !important; }
    
    .kai-art-monitor .podium-3 .podium-img { border: 4px solid #cd7f32 !important; box-shadow: 0 0 15px rgba(205, 127, 50, 0.2); }
    .kai-art-monitor .podium-3 .podium-rank { background: linear-gradient(135deg, #CD7F32, #8B4513); color: #fff !important; }

    .kai-art-monitor .podium-rank {
        position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%);
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 900; font-size: 15px; border: 3px solid #070913 !important;
    }
    .kai-art-monitor .podium-1 .podium-rank { bottom: -15px; width: 42px; height: 42px; font-size: 18px; }
    
    .kai-art-monitor .crown-icon {
        position: absolute; top: -30px; left: 50%; transform: translateX(-50%);
        font-size: 2.2rem; color: #ffd700; filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.6));
    }
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
                    renderTable(result.data);
                    renderPodium(result.data);
                    document.getElementById('last-update').innerText = result.waktu;
                }
            } catch (error) {
                console.error("Gagal mengambil data Live Monitor", error);
            }
        };

        const renderTable = (data) => {
            const tbody = document.getElementById('monitor-table-body');
            let html = '';
            let grandTarget = 0, grandPenawaran = 0, grandDeal = 0;

            if(data.length === 0) {
                html = `<tr><td colspan="7" class="text-center py-5 text-white opacity-50">Belum ada data marketing hari ini.</td></tr>`;
            } else {
                data.forEach((item, index) => {
                    let valTarget = Number(item.target) || 0;
                    let valPenawaran = Number(item.total_penawaran) || 0;
                    let valDeal = Number(item.total_deal) || 0;

                    grandTarget += valTarget;
                    grandPenawaran += valPenawaran;
                    grandDeal += valDeal;

                    let rankBadge = `<div class="mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff;">${index + 1}</div>`;
                    if (index === 0) rankBadge = `<i class="fas fa-trophy fs-4" style="color: #ffd700; filter: drop-shadow(0 0 4px rgba(255,215,0,0.4));"></i>`;
                    else if (index === 1) rankBadge = `<i class="fas fa-medal fs-4" style="color: #c0c0c0;"></i>`;
                    else if (index === 2) rankBadge = `<i class="fas fa-medal fs-4" style="color: #cd7f32;"></i>`;

                    let fillClass = item.prosentase >= 80 ? 'fill-success' : (item.prosentase >= 50 ? 'fill-warning' : 'fill-danger');
                    let textAchClass = item.prosentase >= 100 ? 'text-neon-green text-glow' : 'text-white';

                    html += `
                        <tr>
                            <td>${rankBadge}</td>
                            <td class="text-start ps-4">
                                <div class="fw-bolder text-white mb-1" style="font-size: 15px;">${item.nama_lengkap}</div>
                                <span class="badge" style="background: rgba(0, 229, 255, 0.1); color: #00e5ff; border: 1px solid rgba(0,229,255,0.2); font-size: 10px;">
                                    <i class="fas fa-user-tie me-1"></i> ${item.nama}
                                </span>
                            </td>
                            <td class="text-white opacity-75 fw-light">${formatRp(valTarget)}</td>
                            <td class="text-neon-blue">${formatRp(valPenawaran)}</td>
                            <td class="text-neon-green fw-bold fs-5">${formatRp(valDeal)}</td>
                            <td>
                                <div class="d-flex justify-content-between mb-1" style="font-size: 12px;">
                                    <span class="opacity-50">Ach.</span>
                                    <span class="fw-bolder ${textAchClass}">${item.prosentase}%</span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill ${fillClass}" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%;"></div>
                                </div>
                            </td>
                            <td>
                                <div class="glass-pill d-inline-block px-3 py-1 text-neon-blue fw-bold" style="font-size: 13px;">
                                    ${item.total_kpi}%
                                </div>
                            </td>
                        </tr>
                    `;
                });

                let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

                html += `
                    <tr style="background: rgba(0,0,0,0.5) !important;">
                        <td colspan="2" class="text-end pe-4 fw-bolder text-white fs-6 py-4">TOTAL KESELURUHAN</td>
                        <td class="fw-bold text-white opacity-75 fs-6 py-4">${formatRp(grandTarget)}</td>
                        <td class="fw-bold text-neon-blue fs-6 py-4">${formatRp(grandPenawaran)}</td>
                        <td class="fw-bolder text-neon-green fs-5 py-4 text-glow">${formatRp(grandDeal)}</td>
                        <td class="fw-bolder text-white fs-5 py-4">${grandAch.toFixed(1)}%</td>
                        <td class="py-4">-</td>
                    </tr>
                `;
            }
            tbody.innerHTML = html;
        };

        const renderPodium = (data) => {
            const podiumContainer = document.getElementById('podium-container');
            if (data.length < 3) {
                podiumContainer.style.display = 'none';
                return;
            } else {
                podiumContainer.style.display = 'flex';
            }

            const getAvatarHtml = (item) => {
                if (item.foto) {
                    return `<img src="${item.foto}" alt="${item.nama}" class="podium-img" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}&background=0D1126&color=00e5ff';">`;
                } else {
                    return `<div class="podium-img" style="background: rgba(0, 229, 255, 0.1); border: 1px solid rgba(0, 229, 255, 0.3); color: #00e5ff;">${item.nama.charAt(0).toUpperCase()}</div>`;
                }
            };

            let html = `
                <div class="px-2 fade-in">
                    <div class="podium-box podium-2">
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[1])}
                            <div class="podium-rank">2</div>
                        </div>
                        <div class="mt-4 fw-bolder text-white" style="font-size: 15px;">${data[1].nama}</div>
                        <div class="fw-bold mt-1" style="color: #c0c0c0; font-size: 13px;">${data[1].prosentase}%</div>
                    </div>
                </div>

                <div class="px-3 fade-in">
                    <div class="podium-box podium-1">
                        <i class="fas fa-crown crown-icon"></i>
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[0])}
                            <div class="podium-rank">1</div>
                        </div>
                        <div class="mt-4 fw-bolder text-white text-glow" style="font-size: 18px;">${data[0].nama}</div>
                        <div class="fw-bolder mt-1" style="color: #ffd700; font-size: 15px;">${data[0].prosentase}%</div>
                    </div>
                </div>

                <div class="px-2 fade-in">
                    <div class="podium-box podium-3">
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[2])}
                            <div class="podium-rank">3</div>
                        </div>
                        <div class="mt-4 fw-bolder text-white" style="font-size: 15px;">${data[2].nama}</div>
                        <div class="fw-bold mt-1" style="color: #cd7f32; font-size: 13px;">${data[2].prosentase}%</div>
                    </div>
                </div>
            `;

            podiumContainer.innerHTML = html;
        };

        fetchMonitorData();
        setInterval(fetchMonitorData, 10000); 
    });

    // =========================================================================
    // 🔥 PERBAIKAN LOGIKA FULLSCREEN NATIVE 🔥
    // Kita menembak ID 'monitor-container', BUKAN seluruh document body.
    // =========================================================================
    function toggleFullScreen() {
        const monitorContainer = document.getElementById('monitor-container');
        
        if (!document.fullscreenElement) {
            // Memaksa elemen div ini menjadi layar penuh (akan otomatis menutupi sidebar KaiAdmin)
            if (monitorContainer.requestFullscreen) {
                monitorContainer.requestFullscreen().catch(err => {
                    console.error(`Gagal: ${err.message}`);
                });
            } else if (monitorContainer.webkitRequestFullscreen) { /* Safari */
                monitorContainer.webkitRequestFullscreen();
            } else if (monitorContainer.msRequestFullscreen) { /* IE11 */
                monitorContainer.msRequestFullscreen();
            }
        } else {
            // Keluar dari Fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        }
    }
</script>
@endsection
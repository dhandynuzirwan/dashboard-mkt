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
                OPERASIONAL PELATIHAN <span class="text-primary">•</span> <span id="monitor-month">MEMUAT...</span>
            </h2>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow border-0" id="update-badge">
                <div class="spinner-grow text-success me-2" role="status" style="width: 1rem; height: 1rem;"></div>
                <span class="fw-bold text-dark fs-5">Update: <span id="last-update" class="text-success">Memuat...</span></span>
            </div>
            <!-- KEMBALI BUTTON -->
            <a href="{{ route('monitoring.pelatihan') }}" class="btn btn-outline-danger btn-round shadow-lg px-3 py-2 fw-bold hover-lift fs-5" id="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            
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
    <div class="fade-in px-2" id="stat-cards-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 14px;">
        <div style="grid-column: span 4;" class="text-center py-2">
            <div class="spinner-border text-primary mb-2" style="width: 2rem; height: 2rem;" role="status"></div>
            <h5 class="text-muted fw-bold">Sinkronisasi Server Data...</h5>
        </div>
    </div>

    {{-- LIST PELATIHAN (CSS Grid untuk gap identik) --}}
    <div class="fade-in px-2" id="training-cards-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
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

    .wide-training-card { border-radius: 12px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }
    .stat-card-modern { border-radius: 12px; background: #ffffff; border: 1px solid rgba(0,0,0,0.03); }

    .dashed-divider { border-left: 1px dashed #E2E8F0; }

    .bg-secondary-subtle { background-color: #f1f5f9 !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .bg-success-subtle { background-color: #d1fae5 !important; }
    .bg-info-subtle { background-color: #e0f2fe !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .bg-danger-subtle { background-color: #fee2e2 !important; }

    /* 🔥 CLEAN TV LAYOUT 🔥 */
    .sidebar { display: none !important; }
    .main-header { display: none !important; }
    .main-panel { width: 100% !important; margin: 0 !important; }

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
    body.dark-mode .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.15) !important; color: #ffda6a !important; border-color: rgba(255, 193, 7, 0.3) !important; }
    body.dark-mode .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.15) !important; color: #ea868f !important; border-color: rgba(220, 53, 69, 0.3) !important; }
    
    body.dark-mode .btn-outline-dark { color: #fff; border-color: #fff; }
    body.dark-mode .btn-outline-dark:hover { background-color: #fff; color: #000; }
    
    body.dark-mode .text-primary { color: #6ea8fe !important; }
    body.dark-mode .text-success { color: #75b798 !important; }
    body.dark-mode .text-info { color: #6edff6 !important; }
    body.dark-mode .text-warning { color: #ffda6a !important; }
    body.dark-mode .text-danger { color: #ea868f !important; }
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
        
        // Hide sidebar automatically
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) sidebar.style.display = 'none';

        // Initial load
        loadMonitorData();

        // Auto refresh every 10 seconds
        setInterval(loadMonitorData, 10000);
    });

    function loadMonitorData() {
        fetch('{{ route('api.monitoring.pelatihan.tv-data') }}')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                document.getElementById('last-update').innerText = res.waktu;
                document.getElementById('monitor-month').innerText = 'REALTIME';
                renderTVCards(res.data);
            }
        })
        .catch(error => {
            console.error('Error fetching monitor data:', error);
            document.getElementById('last-update').innerText = "Koneksi Terputus!";
            document.getElementById('last-update').classList.replace('text-success', 'text-danger');
        });
    }

    function renderTVCards(data) {
        const statContainer = document.getElementById('stat-cards-container');
        const trainingContainer = document.getElementById('training-cards-container');
        
        let totalKelas = data.length;
        let totalRunning = 0;
        let totalPersiapan = 0;
        let totalValidasiChecked = 0;
        let totalValidasiItems = 0;

        if(data.length === 0) {
            statContainer.innerHTML = `<div class="col-12 text-center text-muted fs-4 py-4 fw-bold">Belum ada kelas berjalan</div>`;
            trainingContainer.innerHTML = '';
            return;
        }

        let cardsHtml = '';

        data.forEach((item, index) => {
            if (item.status_kelas === 'running') { totalRunning++; }
            if (item.status_kelas === 'persiapan') { totalPersiapan++; }
            
            totalValidasiChecked += item.progress_count;
            totalValidasiItems += 21; // Assumption

            let statusColor = item.status_kelas === 'running' ? 'bg-success' : 'bg-warning text-dark';
            let statusText = item.status_kelas === 'running' ? 'RUNNING' : 'PERSIAPAN';

            let progressColor = 'bg-primary';
            if(item.progress_persen === 100) progressColor = 'bg-success';

            cardsHtml += `
                <div style="min-width: 0;">
                    <div class="card h-100 wide-training-card shadow-sm hover-lift p-3 m-0 position-relative border-0" style="border-left: 5px solid ${item.status_kelas === 'running' ? '#198754' : '#ffc107'} !important;">
                        
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge ${statusColor} px-3 py-2 fw-black shadow-sm" style="font-size: 0.8rem; letter-spacing: 1px;">
                                ${statusText}
                            </span>
                        </div>

                        <div class="d-flex flex-column h-100 pt-2">
                            <!-- TITLE & CERTIFICATION -->
                            <div class="mb-3 pe-5">
                                <h4 class="fw-black text-dark mb-1 text-uppercase" style="font-size: 1.15rem; letter-spacing: -0.5px; line-height: 1.3;">
                                    ${item.judul}
                                </h4>
                                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-1 mt-1" style="font-size: 0.75rem;">
                                    <i class="fas fa-certificate me-1"></i> ${item.sertifikasi}
                                </span>
                            </div>
                            
                            <!-- SCHEDULE & LOCATION -->
                            <div class="row g-2 mt-auto mb-3">
                                <div class="col-6">
                                    <div class="bg-secondary-subtle p-2 rounded-3 h-100">
                                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Jadwal Pelaksanaan</div>
                                        <div class="fw-black text-dark text-truncate mt-1" style="font-size: 1.05rem;">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i> ${item.tanggal_pelatihan}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-secondary-subtle p-2 rounded-3 h-100">
                                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Lokasi / Tempat</div>
                                        <div class="fw-black text-dark text-truncate mt-1" style="font-size: 0.85rem;" title="${item.lokasi}">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i> ${item.lokasi}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PIC HIGHLIGHT -->
                            <div class="bg-warning-subtle border border-warning border-opacity-25 rounded-3 p-3 mb-3 d-flex align-items-center justify-content-between shadow-sm">
                                <div>
                                    <div class="text-warning-dark text-uppercase fw-bolder mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                                        PIC OPERASIONAL
                                    </div>
                                    <div class="fw-black text-dark text-uppercase" style="font-size: 1.5rem; letter-spacing: -0.5px;">
                                        <i class="fas fa-user-shield text-warning me-1"></i> ${item.pic_operasional}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Instruktur</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;" title="${item.instruktur}">${item.instruktur}</div>
                                </div>
                            </div>

                            <!-- PROGRESS BAR VALIDASI -->
                            <div class="mt-auto pt-2 border-top border-secondary border-opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-dark fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Progress Validasi</span>
                                    <span class="text-primary fw-bolder" style="font-size: 0.75rem;">${item.progress_persen}%</span>
                                </div>
                                <div class="progress shadow-sm" style="background-color: #e2e8f0; height: 10px; border-radius: 10px;">
                                    <div class="progress-bar ${progressColor} progress-bar-striped progress-bar-animated" style="width: ${item.progress_persen}%; border-radius: 10px;"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            `;
        });

        let grandValidasiAch = totalValidasiItems > 0 ? Math.round((totalValidasiChecked / totalValidasiItems) * 100) : 0;

        statContainer.innerHTML = `
            <div style="min-width: 0;">
                <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                    <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                        <div class="icon-circle bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                            <i class="fas fa-layer-group" style="font-size: 1.6rem;"></i>
                        </div>
                        <div style="min-width: 0;">
                            <p class="text-muted text-uppercase fw-bold mb-1 text-truncate" style="font-size: 0.85rem;">Total Kelas Aktif</p>
                            <h4 class="fw-black text-dark mb-0 text-truncate" style="font-size: 1.6rem; letter-spacing: -1px;">${totalKelas} KELAS</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div style="min-width: 0;">
                <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                    <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                        <div class="icon-circle bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                            <i class="fas fa-play" style="font-size: 1.6rem;"></i>
                        </div>
                        <div style="min-width: 0;">
                            <p class="text-muted text-uppercase fw-bold mb-1 text-truncate" style="font-size: 0.85rem;">Sedang Running</p>
                            <h4 class="fw-black text-success mb-0 text-truncate" style="font-size: 1.6rem; letter-spacing: -1px;">${totalRunning} KELAS</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div style="min-width: 0;">
                <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                    <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                        <div class="icon-circle bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                            <i class="fas fa-hourglass-half" style="font-size: 1.6rem;"></i>
                        </div>
                        <div style="min-width: 0;">
                            <p class="text-muted text-uppercase fw-bold mb-1 text-truncate" style="font-size: 0.85rem;">Tahap Persiapan</p>
                            <h4 class="fw-black text-warning mb-0 text-truncate" style="font-size: 1.6rem; letter-spacing: -1px;">${totalPersiapan} KELAS</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div style="min-width: 0;">
                <div class="card stat-card-modern shadow-sm h-100 hover-lift border-0">
                    <div class="card-body p-2 p-xl-3 d-flex align-items-center">
                        <div class="icon-circle bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; min-width: 55px;">
                            <i class="fas fa-check-double" style="font-size: 1.6rem;"></i>
                        </div>
                        <div style="min-width: 0;">
                            <p class="text-muted text-uppercase fw-bold mb-1 text-truncate" style="font-size: 0.85rem;">Progress Validasi</p>
                            <h4 class="fw-black text-primary mb-0 text-truncate" style="font-size: 1.6rem; letter-spacing: -1px;">${grandValidasiAch}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        `;

        trainingContainer.innerHTML = cardsHtml;
    }

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch((err) => {
                alert(`Error attempting to enable fullscreen mode: ${err.message} (${err.name})`);
            });
            document.body.classList.add('fullscreen-active');
        } else {
            document.exitFullscreen();
            document.body.classList.remove('fullscreen-active');
        }
    }
</script>
@endsection
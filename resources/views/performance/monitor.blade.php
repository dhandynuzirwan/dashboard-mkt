@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" id="monitor-container">
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h2 class="fw-bolder text-dark mb-0"><i class="fas fa-tv text-primary me-2"></i> On Display Monitor</h2>
            <p class="text-muted mb-0">Live Performance Tracking Marketing & Sales</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm border">
                <div class="spinner-grow spinner-grow-sm text-success me-2" role="status" style="width: 12px; height: 12px;"></div>
                <span class="fw-bold text-dark" style="font-size: 12px;">Live Updates: <span id="last-update">Memuat...</span></span>
            </div>
            {{-- Tombol Fullscreen untuk layar TV --}}
            <button onclick="toggleFullScreen()" class="btn btn-dark btn-round shadow-sm">
                <i class="fas fa-expand me-1"></i> Fullscreen
            </button>
        </div>
    </div>

    {{-- <div id="podium-container" class="d-flex justify-content-center align-items-end mb-4 fade-in gap-3" style="min-height: 200px;">
        </div> --}}

    <div class="card card-modern border-0 shadow-lg fade-in" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table">
                <table class="table table-hover align-middle text-center mb-0" style="min-width: 1000px;">
                    <thead class="bg-light text-primary" style="font-size: 14px;">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-start ps-4">Marketing</th>
                            <th>Target Omset (Rp)</th>
                            <th>Penawaran (Rp)</th>
                            <th class="text-success">Deal (Rp)</th> {{-- 🔥 Warna hijau --}}
                            
                            <th>Achievement</th>
                            <th>Total KPI</th>
                        </tr>
                    </thead>
                    {{-- ID ini penting untuk disuntik data oleh JavaScript --}}
                    <tbody id="monitor-table-body" class="bg-white" style="font-size: 16px; font-weight: 600;">
                        <tr>
                            <td colspan="8" class="py-5 text-center text-muted">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <br>Menghubungkan ke server data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .card-modern { box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
    /* Agar tampilan TV maksimal, baris dibuat agak besar */
    #monitor-table-body td { padding-top: 18px; padding-bottom: 18px; border-bottom: 1px solid #f1f5f9; }
    .fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Progress bar minimalis untuk kolom persentase */
    .progress-bar-custom {
        height: 6px;
        border-radius: 10px;
        background-color: #e2e8f0;
        margin-top: 6px;
        overflow: hidden;
    }
    .progress-fill { height: 100%; border-radius: 10px; transition: width 1s ease-in-out; }

    /* 🔥 CSS KHUSUS PODIUM LEADERBOARD 🔥 */
    .podium-box {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        position: relative;
    }
    .podium-box:hover {
        transform: translateY(-5px);
    }
    .podium-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        color: #fff;
    }
    /* Peringkat 1 (Emas) - Lebih besar dan naik sedikit */
    .podium-1 { transform: translateY(-20px); z-index: 3; }
    .podium-1 .podium-img { width: 130px; height: 130px; border: 6px solid #fbbf24; box-shadow: 0 0 20px rgba(251, 191, 36, 0.5); }
    .podium-1 .podium-rank { background-color: #fbbf24; color: #fff; }
    
    /* Peringkat 2 (Perak) */
    .podium-2 { z-index: 2; }
    .podium-2 .podium-img { border: 5px solid #94a3b8; box-shadow: 0 0 15px rgba(148, 163, 184, 0.4); }
    .podium-2 .podium-rank { background-color: #94a3b8; color: #fff; }
    
    /* Peringkat 3 (Perunggu) */
    .podium-3 { z-index: 1; }
    .podium-3 .podium-img { border: 5px solid #b45309; box-shadow: 0 0 15px rgba(180, 83, 9, 0.4); }
    .podium-3 .podium-rank { background-color: #b45309; color: #fff; }

    .podium-rank {
        position: absolute;
        bottom: -16px; /* 🔥 Ubah ke minus agar turun ke tepi bawah foto */
        left: 50%;
        transform: translateX(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 14px;
        border: 3px solid #fff;
    }
    .podium-1 .podium-rank { 
        bottom: -20px; /* 🔥 Turunkan juga untuk peringkat 1 */
        width: 40px; 
        height: 40px; 
        font-size: 18px; 
    }
</style>
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Fungsi untuk format Rupiah
        const formatRp = (angka) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(angka);
        };

        // Fungsi utama mengambil data dari API internal (Controller)
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

        // Fungsi merender HTML ke dalam tabel tanpa me-refresh halaman
        const renderTable = (data) => {
            const tbody = document.getElementById('monitor-table-body');
            let html = '';

            // Variabel Penampung untuk Total Keseluruhan
            let grandTarget = 0;
            let grandPenawaran = 0;
            let grandDeal = 0;

            if(data.length === 0) {
                html = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data marketing</td></tr>`;
            } else {
                data.forEach((item, index) => {
                    // 🔥 PERBAIKAN FATAL: Paksa jadi Angka (Number) agar ditambahkan, bukan disambung teksnya!
                    let valTarget = Number(item.target) || 0;
                    let valPenawaran = Number(item.total_penawaran) || 0;
                    let valDeal = Number(item.total_deal) || 0;

                    // Hitung Grand Total
                    grandTarget += valTarget;
                    grandPenawaran += valPenawaran;
                    grandDeal += valDeal;

                    // Penentuan warna rank 1, 2, 3
                    let rankBadge = `<span class="badge bg-primary rounded-circle" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">${index + 1}</span>`;
                    if (index === 0) rankBadge = `<i class="fas fa-medal fs-4 text-warning" title="Peringkat 1"></i>`;
                    else if (index === 1) rankBadge = `<i class="fas fa-medal fs-4 text-primary" style="color: #94a3b8 !important;" title="Peringkat 2"></i>`;
                    else if (index === 2) rankBadge = `<i class="fas fa-medal fs-4" style="color: #b45309 !important;" title="Peringkat 3"></i>`;

                    // Penentuan warna progress bar
                    let barColor = item.prosentase >= 80 ? 'bg-success' : (item.prosentase >= 50 ? 'bg-warning' : 'bg-danger');

                    html += `
                        <tr class="fade-in">
                            <td class="text-center">${rankBadge}</td>
                            
                            <td class="text-start ps-4">
                                <div class="fw-bolder text-dark mb-1" style="font-size: 14px;">${item.nama_lengkap}</div>
                                <span class="badge bg-primary px-2 py-1 shadow-sm" style="font-size: 10px;">
                                    <i class="fas fa-id-badge me-1 opacity-75"></i> ${item.nama}
                                </span>
                            </td>
                            
                            {{-- Gunakan variabel yang sudah diubah jadi angka murni --}}
                            <td class="text-muted fw-medium">${formatRp(valTarget)}</td>
                            <td class="text-primary fw-bold">${formatRp(valPenawaran)}</td>
                            <td class="text-success fw-black fs-5">${formatRp(valDeal)}</td>
                            
                            
                            <td>
                                <div class="fw-bolder mb-1 ${item.prosentase >= 100 ? 'text-success' : 'text-dark'}">${item.prosentase}%</div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill ${barColor}" style="width: ${item.prosentase > 100 ? 100 : item.prosentase}%;"></div>
                                </div>
                            </td>
                            <td class="pe-4"><span class="badge bg-info text-white px-3 py-2 fs-6 rounded-pill shadow-sm">${item.total_kpi}%</span></td>
                        </tr>
                    `;
                });

                // Kalkulasi Persentase Grand Total
                let grandAch = grandTarget > 0 ? (grandDeal / grandTarget) * 100 : 0;

                // Baris Grand Total di Paling Bawah
                html += `
                    <tr class="bg-light border-top border-3" style="border-color: #dee2e6 !important;">
                        <td colspan="2" class="text-end pe-4 fw-black text-dark fs-5 py-3">TOTAL KESELURUHAN</td>
                        <td class="fw-bold text-muted fs-5 py-3">${formatRp(grandTarget)}</td>
                        <td class="fw-bold text-primary fs-5 py-3">${formatRp(grandPenawaran)}</td>
                        <td class="fw-black text-success fs-4 py-3">${formatRp(grandDeal)}</td>
                        
                        <td class="fw-black text-dark fs-5 py-3">${grandAch.toFixed(1)}%</td>
                        <td class="py-3 pe-4">-</td>
                    </tr>
                `;
            }
            tbody.innerHTML = html;
        };

        // 🔥 FUNGSI BARU: Render Podium Top 3 🔥
        const renderPodium = (data) => {
            const podiumContainer = document.getElementById('podium-container');
            
            // Jika data kurang dari 3, sembunyikan fitur podium agar tidak aneh
            if (data.length < 3) {
                podiumContainer.innerHTML = '';
                return;
            }

            // Fungsi untuk membuat elemen gambar atau inisial
            const getAvatarHtml = (item) => {
                // 🔥 Debug: cek di Console Browser (F12) apa isi URL-nya
                console.log("URL Foto:", item.foto); 
                
                if (item.foto) {
                    return `<img src="${item.foto}" alt="${item.nama}" class="podium-img shadow-sm" 
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${item.nama}';">`;
                } else {
                    return `<div class="podium-img shadow-sm bg-primary" style="display:flex; align-items:center; justify-content:center;">${item.nama.charAt(0).toUpperCase()}</div>`;
                }
            };

            // Struktur HTML Podium: Rank 2 (Kiri), Rank 1 (Tengah), Rank 3 (Kanan)
            // Struktur HTML Podium: Dempet tanpa sistem grid
            // Struktur HTML Podium: Dempet tanpa sistem grid
            let html = `
                <div class="px-2">
                    <div class="podium-box podium-2">
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[1])}
                            <div class="podium-rank shadow">2</div>
                        </div>
                        {{-- 🔥 Ganti mt-2 jadi mt-4 agar namanya turun --}}
                        <div class="mt-4 fw-bolder text-dark" style="font-size: 15px;">${data[1].nama}</div>
                        <div class="text-secondary fw-bold" style="font-size: 12px;">${data[1].prosentase}%</div>
                    </div>
                </div>

                <div class="px-3">
                    <div class="podium-box podium-1">
                        <i class="fas fa-crown text-warning fs-1 position-absolute" style="top: -25px; left: 50%; transform: translateX(-50%); text-shadow: 0 4px 6px rgba(0,0,0,0.1);"></i>
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[0])}
                            <div class="podium-rank shadow">1</div>
                        </div>
                        {{-- 🔥 Ganti mt-2 jadi mt-4 agar namanya turun --}}
                        <div class="mt-4 fw-bolder text-dark fs-5">${data[0].nama}</div>
                        <div class="text-warning-dark fw-bolder" style="color: #d97706; font-size: 14px;">${data[0].prosentase}%</div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="podium-box podium-3">
                        <div class="position-relative d-inline-block">
                            ${getAvatarHtml(data[2])}
                            <div class="podium-rank shadow">3</div>
                        </div>
                        {{-- 🔥 Ganti mt-2 jadi mt-4 agar namanya turun --}}
                        <div class="mt-4 fw-bolder text-dark" style="font-size: 15px;">${data[2].nama}</div>
                        <div class="text-secondary fw-bold" style="font-size: 12px;" style="color: #b45309 !important;">${data[2].prosentase}%</div>
                    </div>
                </div>
            `;

            podiumContainer.innerHTML = html;
        };

        // Panggil fungsi pertama kali saat halaman dibuka
        fetchMonitorData();

        // 🔥 RAHASIA REALTIME TANPA REFRESH: Polling setiap 10 detik (10000 ms) 🔥
        // Ubah angka 10000 jika ingin lebih cepat/lambat
        setInterval(fetchMonitorData, 10000);
    });

    // =========================================================================
    // FITUR FULLSCREEN SMART TV + AUTO HIDE SIDEBAR & TOPBAR
    // =========================================================================
    function toggleFullScreen() {
        // Kita tembak fullscreen ke seluruh body dokumen agar kontrol penuh ada di kita
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

    // Elemen detektor otomatis ketika browser masuk/keluar dari mode Fullscreen
    document.addEventListener('fullscreenchange', function() {
        const sidebar = document.querySelector('.sidebar');
        const mainPanel = document.querySelector('.main-panel');
        const navbar = document.querySelector('.main-header'); // Sesuaikan class topbar/navbar jika ada

        if (document.fullscreenElement) {
            // 🔥 SAAT MASUK FULLSCREEN: Sembunyikan elemen navigasi
            if (sidebar) sidebar.style.display = 'none';
            if (navbar) navbar.style.display = 'none';
            
            // Buat panel utama memenuhi layar penuh tanpa sisa margin sidebar
            if (mainPanel) {
                mainPanel.style.width = '100%';
                mainPanel.style.left = '0';
                mainPanel.style.paddingTop = '20px'; // Beri sedikit space atas agar rapi
            }
        } else {
            // 🌟 SAAT KELUAR FULLSCREEN: Kembalikan seperti semula
            if (sidebar) sidebar.style.display = '';
            if (navbar) navbar.style.display = '';
            
            if (mainPanel) {
                mainPanel.style.width = '';
                mainPanel.style.left = '';
                mainPanel.style.paddingTop = '';
            }
        }
    });
</script>
@endsection
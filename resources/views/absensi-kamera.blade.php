@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        
        {{-- ================= HEADER SECTION ================= --}}
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between fade-in">
            <div>
                <h3 class="fw-bolder mb-1 text-dark" style="letter-spacing: -0.5px;">Absensi Online</h3>
                <h6 class="text-muted mb-2 fw-normal">Sistem presensi digital menggunakan verifikasi wajah.</h6>
                
                {{-- Jam Realtime --}}
                <div class="d-inline-flex align-items-center rounded-pill px-3 py-1 mt-1 fw-bold border bg-white" style="color: #3b82f6; font-size: 13px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <i class="fas fa-clock me-2"></i> <span id="realtime-clock">Memuat waktu...</span>
                </div>
            </div>
        </div>

        {{-- ================= ALERT NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-modern-success alert-dismissible fade show mb-4 fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <div class="icon-sm bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="width: 32px; height: 32px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark">Berhasil!</span> <span class="text-dark opacity-75">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= MAIN CAMERA CARD ================= --}}
        <div class="d-flex justify-content-center fade-in">
            <div class="card card-modern border-0 shadow-lg p-4 p-md-5 w-100" style="max-width: 500px; border-radius: 24px;">
                
                <div class="text-center mb-4">
                    <div class="icon-modern bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center rounded-4" style="width: 65px; height: 65px; font-size: 28px;">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-1">Verifikasi Wajah</h4>
                    <p class="text-muted small mb-0">Posisikan wajah Anda di dalam bingkai dengan pencahayaan yang cukup.</p>
                </div>

                <form action="{{ route('pegawai.absensi.store') }}" method="POST" id="formAbsensi">
                    @csrf
                    <input type="hidden" name="foto_selfie" id="foto_selfie" required>
                    
                    {{-- Pilihan Tipe Absen (Masuk / Pulang) --}}
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="btn-group shadow-sm" role="group" aria-label="Tipe Absen">
                            <input type="radio" class="btn-check" name="tipe_absen" id="absen_masuk" value="in" {{ !$sudahAbsen ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary px-4 fw-bold {{ !$sudahAbsen ? 'active' : '' }}" for="absen_masuk">
                                <i class="fas fa-sign-in-alt me-1"></i> Masuk
                            </label>

                            <input type="radio" class="btn-check" name="tipe_absen" id="absen_pulang" value="out" {{ $sudahAbsen ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning px-4 fw-bold {{ $sudahAbsen ? 'active' : '' }}" for="absen_pulang" style="color: #b45309;">
                                <i class="fas fa-sign-out-alt me-1"></i> Pulang
                            </label>
                        </div>
                    </div>
                    
                    {{-- Area Kamera --}}
                    <div class="position-relative bg-dark overflow-hidden shadow-sm mb-4 mx-auto" style="width: 100%; aspect-ratio: 1/1; max-width: 320px; border-radius: 50%; border: 6px solid #eef2f7;">
                        {{-- Loading State --}}
                        <div class="position-absolute top-50 start-50 translate-middle text-white text-center w-100" id="kamera-loading">
                            <i class="fas fa-spinner fa-spin fs-2 mb-2"></i>
                            <p class="small m-0">Menyiapkan Kamera...</p>
                        </div>
                        
                        {{-- Video Stream --}}
                        <video id="kamera-preview" class="w-100 h-100" style="object-fit: cover; transform: scaleX(-1);" autoplay playsinline></video>
                    </div>

                    {{-- Canvas Hidden --}}
                    <canvas id="kamera-canvas" width="400" height="400" style="display: none;"></canvas>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" id="btn-jepret" class="btn btn-primary btn-round fw-bold shadow-sm py-3 hover-lift fs-6">
                            <i class="fas fa-camera me-2"></i> Ambil Foto Absen
                        </button>
                        
                        <div id="action-submit" style="display: none;">
                            <div class="alert alert-modern-warning py-2 px-3 text-center mb-3 border-0 small fw-bold">
                                Foto terekam! Pastikan wajah terlihat jelas sebelum dikirim.
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btn-ulangi" class="btn btn-light border btn-round fw-bold shadow-sm py-3 hover-lift text-muted w-50">
                                    <i class="fas fa-sync-alt me-1"></i> Ulangi
                                </button>
                                <button type="submit" id="btn-submit" class="btn btn-success btn-round fw-bold shadow-sm py-3 hover-lift w-50 text-white">
                                    <i class="fas fa-paper-plane me-1"></i> Kirim Absen
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- ================= STYLES ================= --}}
<style>
    .card-modern { background: #ffffff; border: 1px solid #eef2f7; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s ease; }
    .btn-round { border-radius: 50px; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .bg-primary-subtle { background-color: #eff6ff !important; }
    .alert-modern-success { background-color: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 12px; padding: 16px; }
    .alert-modern-warning { background-color: #fffbeb; color: #b45309; border-radius: 8px; }
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    
    /* Styling Custom Toggle Button Absen */
    .btn-check:checked + .btn-outline-primary { background-color: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-check:checked + .btn-outline-warning { background-color: #f59e0b; color: white !important; border-color: #f59e0b; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

{{-- ================= SCRIPTS ================= --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. SCRIPT JAM REALTIME ---
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('realtime-clock').innerText = now.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // --- 2. SCRIPT KAMERA ---
        const video = document.getElementById('kamera-preview');
        const canvas = document.getElementById('kamera-canvas');
        const btnJepret = document.getElementById('btn-jepret');
        const actionSubmit = document.getElementById('action-submit');
        const btnUlangi = document.getElementById('btn-ulangi');
        const inputFoto = document.getElementById('foto_selfie');
        const loading = document.getElementById('kamera-loading');
        let streamAccess = null;

        // Fungsi menyalakan Kamera (Prioritas Kamera Depan HP jika ada)
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
                .then(function(stream) {
                    streamAccess = stream;
                    loading.style.display = 'none';
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    loading.innerHTML = '<i class="fas fa-video-slash text-danger fs-2 mb-2"></i><p class="small text-danger m-0 px-3">Kamera diblokir atau tidak ditemukan. Mohon izinkan akses kamera di browser Anda.</p>';
                });
        }
        startCamera();

        // Saat tombol jepret diklik
        btnJepret.addEventListener('click', function() {
            const context = canvas.getContext('2d');
            
            // Mirror efek gambar agar sesuai dengan tampilan video yang di-mirror
            context.translate(canvas.width, 0);
            context.scale(-1, 1);
            
            // Gambar frame video ke canvas dengan rasio 1:1 (Kamera di-masking bulat)
            // Karena video asli rasio 4:3 atau 16:9, kita ambil tengahnya
            const size = Math.min(video.videoWidth, video.videoHeight);
            const xOffset = (video.videoWidth - size) / 2;
            const yOffset = (video.videoHeight - size) / 2;
            
            context.drawImage(video, xOffset, yOffset, size, size, 0, 0, canvas.width, canvas.height);
            
            // Konversi ke format Base64 JPEG agar size lebih ringan dari PNG
            const dataUri = canvas.toDataURL('image/jpeg', 0.8);
            inputFoto.value = dataUri;

            // Pause video agar wajah membeku seolah difoto
            video.pause();

            // Ganti tombol jepret dengan tombol submit & ulangi
            btnJepret.style.display = 'none';
            actionSubmit.style.display = 'block';
        });

        // Saat tombol ulangi diklik
        btnUlangi.addEventListener('click', function() {
            inputFoto.value = ''; // Kosongkan input
            video.play(); // Play kembali video
            
            // Kembalikan tombol seperti semula
            actionSubmit.style.display = 'none';
            btnJepret.style.display = 'block';
        });
    });
</script>
@endsection
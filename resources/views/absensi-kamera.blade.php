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
                    {{-- Ikon Face ID Apple Style --}}
                    <div class="icon-modern bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center rounded-4" style="width: 65px; height: 65px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                            <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                            <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                            <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <path d="M9 9h.01"></path>
                            <path d="M15 9h.01"></path>
                        </svg>
                    </div>
                    <h4 class="fw-bolder text-dark mb-1">Verifikasi Wajah</h4>
                    <p class="text-muted small mb-0">Posisikan wajah Anda di dalam bingkai dengan pencahayaan yang cukup.</p>
                </div>

                <form action="{{ route('pegawai.absensi.store') }}" method="POST" id="formAbsensi">
                    @csrf
                    <input type="hidden" name="foto_selfie" id="foto_selfie" required>
                    
                    {{-- Pilihan Tipe Absen (Masuk = Hijau / Pulang = Merah) --}}
                    <div class="mb-4 d-flex justify-content-center gap-3">
                        {{-- Tambahkan 'checked' di sini agar selalu default Masuk --}}
                        <input type="radio" class="btn-check btn-absen-custom" name="tipe_absen" id="absen_masuk" value="in" checked>
                        <label class="btn btn-outline-success rounded-4 px-4 py-2 fw-bold d-flex flex-column align-items-center shadow-sm" for="absen_masuk" style="min-width: 130px;">
                            <i class="fas fa-sign-in-alt fs-4 mb-1"></i>
                            <span>MASUK</span>
                        </label>

                        {{-- Hapus kondisi pada Pulang agar tidak bentrok --}}
                        <input type="radio" class="btn-check btn-absen-custom" name="tipe_absen" id="absen_pulang" value="out">
                        <label class="btn btn-outline-danger rounded-4 px-4 py-2 fw-bold d-flex flex-column align-items-center shadow-sm" for="absen_pulang" style="min-width: 130px;">
                            <i class="fas fa-sign-out-alt fs-4 mb-1"></i>
                            <span>PULANG</span>
                        </label>
                    </div>
                    
                    {{-- Area Kamera --}}
                    <div class="position-relative bg-dark overflow-hidden shadow-sm mb-3 mx-auto" style="width: 100%; aspect-ratio: 1/1; max-width: 320px; border-radius: 50%; border: 6px solid #eef2f7;">
                        {{-- Loading State --}}
                        <div class="position-absolute top-50 start-50 translate-middle text-white text-center w-100" id="kamera-loading">
                            <i class="fas fa-spinner fa-spin fs-2 mb-2"></i>
                            <p class="small m-0">Menyiapkan Kamera...</p>
                        </div>
                        
                        {{-- Video Stream --}}
                        <video id="kamera-preview" class="w-100 h-100" style="object-fit: cover; transform: scaleX(-1);" autoplay playsinline></video>
                    </div>

                    {{-- Panduan / Keterangan K3 & Mandi --}}
                    <div class="alert alert-light border rounded-4 text-start mb-4 shadow-sm" style="background-color: #f8fafc;">
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;"><i class="fas fa-clipboard-list text-primary me-2"></i>Persyaratan Foto:</h6>
                        <ul class="mb-0 text-muted ps-3" style="font-size: 13px; line-height: 1.6;">
                            <li>Pastikan <strong>baju yang dikenakan</strong> rapi dan sesuai standar.</li>
                            <li><strong>Ekspresi muka</strong> harus terlihat jelas menghadap kamera.</li>
                            <li>Pake <strong>gaya K3</strong> harusnya tau kan ya gaya K3 kek mana 👌.</li>
                            <li><strong>Jangan lupa mandi!</strong> Biar wajah terlihat segar dan cakep.</li>
                            <li class="text-danger fw-bold">Penting: Jangan lupa absen untuk keluar/out nya juga nanti!</li>
                        </ul>
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
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-round fw-bold shadow-sm py-3 hover-lift w-50 text-white">
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
    
    /* Styling Custom Toggle Button Absen (Hijau & Merah) */
    .btn-check.btn-absen-custom:checked + label[for="absen_masuk"] { 
        background-color: #22c55e !important; 
        color: white !important; 
        border-color: #22c55e !important; 
    }
    .btn-check.btn-absen-custom:checked + label[for="absen_pulang"] { 
        background-color: #ef4444 !important; 
        color: white !important; 
        border-color: #ef4444 !important; 
    }
    label[for="absen_masuk"] { color: #22c55e; border-color: #22c55e; border-width: 2px; }
    label[for="absen_pulang"] { color: #ef4444; border-color: #ef4444; border-width: 2px; }
    
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
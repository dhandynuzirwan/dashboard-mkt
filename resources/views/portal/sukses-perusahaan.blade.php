<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kolektif Berhasil - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi Pop-up Halus */
        .card-enter { animation: scaleUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes scaleUp {
            0% { opacity: 0; transform: scale(0.95) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        
        /* Animasi Ikon Centang */
        .check-anim { animation: checkPop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards; opacity: 0; transform: scale(0.5); }
        @keyframes checkPop {
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex items-center justify-center min-h-screen px-4 py-8">

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 md:p-10 max-w-md w-full text-center relative overflow-hidden card-enter z-10">
        
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-blue-50 to-white -z-10"></div>

        <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative check-anim">
            <div class="absolute inset-0 rounded-full border-4 border-blue-200/50 animate-pulse"></div>
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Pendaftaran Kolektif Berhasil!</h1>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed">Terima kasih, data perusahaan dan berkas <strong class="text-gray-700">15 Peserta</strong> Anda telah tersimpan dengan aman di sistem Arsa Training.</p>

        <div class="text-left mb-6">
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1 mb-2 block">ID Registrasi Perusahaan</label>
            <div class="flex items-center bg-gray-50 border-2 border-gray-100 rounded-2xl p-2 pl-5 focus-within:border-blue-500 transition-colors group">
                <span id="reg-id" class="font-mono font-bold text-lg md:text-xl text-gray-800 tracking-widest flex-1">CORP-2026-042</span>
                
                <button onclick="copyCode()" id="btn-copy" class="bg-white border border-gray-200 text-gray-600 p-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 active:scale-90 transition-all flex items-center justify-center tooltip-trigger relative">
                    <svg id="icon-copy" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <svg id="icon-check" class="w-5 h-5 hidden text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
            <p class="text-[11px] text-gray-400 mt-2 ml-1">*Simpan ID ini. Gunakan ID ini untuk melacak status verifikasi seluruh peserta sekaligus.</p>
        </div>

        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-left mb-8 flex items-start">
            <svg class="w-5 h-5 text-amber-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-xs text-amber-800 leading-relaxed font-medium">Tim operasional kami akan segera memvalidasi kelengkapan berkas perusahaan dan seluruh peserta. Estimasi proses maksimal 2x24 jam kerja.</p>
        </div>

        <div class="space-y-3">
            <a href="{{ url('portal/cek-status-perusahaan') }}" class="block w-full bg-gray-900 text-white font-bold text-base py-4 rounded-xl shadow-lg shadow-gray-900/30 hover:bg-black active:scale-95 transition-all">
                Pantau Status Kolektif
            </a>
            <a href="{{ url('portal') }}" class="block w-full text-gray-500 text-sm font-bold py-3 hover:text-blue-600 transition-colors">
                Kembali ke Beranda Utama
            </a>
        </div>

    </div>

    <script>
        function copyCode() {
            // Ambil teks ID
            const idText = document.getElementById('reg-id').innerText;
            
            // Salin ke clipboard menggunakan API modern
            navigator.clipboard.writeText(idText).then(() => {
                // Manipulasi visual tombol
                const btnCopy = document.getElementById('btn-copy');
                const iconCopy = document.getElementById('icon-copy');
                const iconCheck = document.getElementById('icon-check');

                // Ubah gaya tombol menjadi sukses (biru)
                btnCopy.classList.replace('bg-white', 'bg-blue-50');
                btnCopy.classList.replace('border-gray-200', 'border-blue-300');
                
                // Ganti ikon copy menjadi centang
                iconCopy.classList.add('hidden');
                iconCheck.classList.remove('hidden');

                // Kembalikan ke semula setelah 2 detik
                setTimeout(() => {
                    btnCopy.classList.replace('bg-blue-50', 'bg-white');
                    btnCopy.classList.replace('border-blue-300', 'border-gray-200');
                    iconCheck.classList.add('hidden');
                    iconCopy.classList.remove('hidden');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
                alert('Gagal menyalin. Silakan blok dan copy secara manual.');
            });
        }
    </script>
</body>
</html>
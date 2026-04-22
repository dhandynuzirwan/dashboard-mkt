<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - Arsa Training</title>
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
        
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-emerald-50 to-white -z-10"></div>

        <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative check-anim">
            <div class="absolute inset-0 rounded-full border-4 border-emerald-200/50 animate-pulse"></div>
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">Pendaftaran Berhasil!</h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">Terima kasih, data dan berkas persyaratan Anda telah tersimpan dengan aman di sistem Arsa Training.</p>

        <div class="text-left mb-6">
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1 mb-2 block">ID Pendaftaran Anda</label>
            <div class="flex items-center bg-gray-50 border-2 border-gray-100 rounded-2xl p-2 pl-5 focus-within:border-emerald-500 transition-colors group">
                <span id="reg-id" class="font-mono font-bold text-lg md:text-xl text-gray-800 tracking-widest flex-1">PLT-2026-089</span>
                
                <button onclick="copyCode()" id="btn-copy" class="bg-white border border-gray-200 text-gray-600 p-3 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 active:scale-90 transition-all flex items-center justify-center tooltip-trigger relative">
                    <svg id="icon-copy" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <svg id="icon-check" class="w-5 h-5 hidden text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
            <p class="text-[11px] text-gray-400 mt-2 ml-1">*Simpan ID ini. Anda akan membutuhkannya untuk mengecek status verifikasi berkas nanti.</p>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-left mb-8 flex items-start">
            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-xs text-blue-800 leading-relaxed font-medium">Tim kami sedang melakukan validasi dokumen. Proses ini memakan waktu maksimal 1x24 jam kerja. Silakan pantau status Anda secara berkala.</p>
        </div>

        <div class="space-y-3">
            <a href="{{ url('portal/cek-status') }}" class="block w-full bg-blue-600 text-white font-bold text-base py-4 rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all">
                Pantau Status Sekarang
            </a>
            <a href="{{ url('portal') }}" class="block w-full text-gray-500 text-sm font-bold py-3 hover:text-gray-800 transition-colors">
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

                // Ubah gaya tombol menjadi sukses (hijau)
                btnCopy.classList.replace('bg-white', 'bg-emerald-50');
                btnCopy.classList.replace('border-gray-200', 'border-emerald-300');
                
                // Ganti ikon copy menjadi centang
                iconCopy.classList.add('hidden');
                iconCheck.classList.remove('hidden');

                // Kembalikan ke semula setelah 2 detik
                setTimeout(() => {
                    btnCopy.classList.replace('bg-emerald-50', 'bg-white');
                    btnCopy.classList.replace('border-emerald-300', 'border-gray-200');
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
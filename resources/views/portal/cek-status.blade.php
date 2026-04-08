<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Status Pribadi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-focus-ring:focus-within { box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        input[type="file"] { display: none; }
        
        /* Animasi Transisi Halus */
        .fade-in { animation: fadeIn 0.4s ease-in-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 sticky top-0 z-30 border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-5 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ url('portal') }}" class="mr-4 p-2 bg-gray-50 rounded-full text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 leading-tight">Pantau Berkas</h1>
                    <p class="text-xs text-blue-600 font-medium">Jalur Individu</p>
                </div>
            </div>
        </div>
    </nav>

    <main class="px-5 py-8 max-w-3xl mx-auto min-h-screen">

        <div id="search-section" class="fade-in block">
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Cari Data Anda</h2>
                <p class="text-sm text-gray-500">Masukkan ID Pendaftaran atau Data Diri Anda.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                
                <div class="space-y-4 mb-8">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Gunakan ID Pendaftaran</label>
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <input type="text" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: PLT-2026-001">
                    </div>
                </div>

                <div class="relative flex items-center justify-center mb-8">
                    <span class="absolute w-full h-px bg-gray-200"></span>
                    <span class="relative bg-white px-4 text-xs font-bold text-gray-400 uppercase tracking-widest">ATAU</span>
                </div>

                <div class="space-y-5 mb-8">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Gunakan Data Diri</label>
                    
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <input type="text" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Nama Lengkap">
                    </div>
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <input type="date" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors text-gray-700">
                    </div>
                </div>

                <button id="btn-search" onclick="simulasikanPencarian()" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all">
                    Cari Status Berkas
                </button>
            </div>
        </div>

        <div id="result-section" class="hidden">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-6 flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Halo, Dhandy Nuzirwan</h2>
                    <p class="text-sm text-gray-500 mt-1">ID: <span class="font-bold text-gray-700">PLT-2026-089</span></p>
                    <p class="text-sm text-gray-500">Program: Web Development Bootcamp</p>
                </div>
                <button onclick="resetPencarian()" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-2 rounded-lg hover:bg-blue-100 active:scale-95 transition">
                    Cari Lain
                </button>
            </div>

            <div class="bg-red-50 border border-red-200 p-5 rounded-2xl mb-6 flex items-start">
                <div class="bg-red-100 p-2 rounded-full mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">Perhatian: Ada Berkas yang Perlu Direvisi</h3>
                    <p class="text-xs text-red-600 mt-1 leading-relaxed">Silakan periksa catatan dari Admin pada daftar berkas di bawah ini dan unggah ulang berkas yang sesuai.</p>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-4 ml-1">Status Dokumen</h3>

            <div class="space-y-4">
                
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Scan KTP Asli</p>
                            <p class="text-xs text-gray-400 mt-0.5">Selesai diverifikasi</p>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Diterima</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between opacity-80">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Pas Foto</p>
                            <p class="text-xs text-gray-400 mt-0.5">Menunggu antrean admin</p>
                        </div>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-2 border-red-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Scan Ijazah Terakhir</p>
                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] font-bold mt-1 inline-block">Wajib Revisi</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 p-3 rounded-xl border border-red-100 mb-4">
                        <p class="text-xs font-bold text-red-800 mb-1">Catatan Admin:</p>
                        <p class="text-xs text-red-600 italic">"Resolusi terlalu rendah dan blur, pastikan tulisan nama di ijazah terbaca jelas."</p>
                    </div>

                    <div id="upload-area-ijazah">
                        <label class="flex items-center justify-center w-full p-3 border border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-colors">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <span class="text-sm text-gray-500 font-medium">Pilih file perbaikan...</span>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="prosesRevisi(this, 'ijazah')" />
                        </label>
                    </div>

                    <div id="action-area-ijazah" class="hidden flex items-center justify-between bg-blue-50 p-3 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-700 font-medium truncate mr-3 flex-1" id="nama-file-ijazah">namafile.jpg</p>
                        <button onclick="kirimRevisi('ijazah')" class="bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-blue-700 active:scale-95 transition flex-shrink-0">
                            Kirim Ulang
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <script>
        // Simulasi fungsi pencarian dari form ke hasil
        function simulasikanPencarian() {
            const btn = document.getElementById('btn-search');
            const searchSection = document.getElementById('search-section');
            const resultSection = document.getElementById('result-section');

            // Efek Loading
            btn.innerHTML = 'Mencari Data...';
            btn.classList.replace('bg-blue-600', 'bg-blue-400');
            btn.disabled = true;

            setTimeout(() => {
                searchSection.classList.replace('block', 'hidden');
                
                resultSection.classList.remove('hidden');
                resultSection.classList.add('fade-in');

                // Reset Button
                btn.innerHTML = 'Cari Status Berkas';
                btn.classList.replace('bg-blue-400', 'bg-blue-600');
                btn.disabled = false;
            }, 800);
        }

        // Fungsi kembali ke form pencarian
        function resetPencarian() {
            document.getElementById('result-section').classList.add('hidden');
            document.getElementById('search-section').classList.replace('hidden', 'block');
        }

        // Fungsi saat file perbaikan dipilih
        function prosesRevisi(input, docType) {
            if (input.files && input.files.length > 0) {
                document.getElementById('upload-area-' + docType).classList.add('hidden');
                
                const actionArea = document.getElementById('action-area-' + docType);
                actionArea.classList.remove('hidden');
                actionArea.classList.add('flex'); // Pastikan flexnya nyala
                
                document.getElementById('nama-file-' + docType).innerText = input.files[0].name;
            }
        }

        // Fungsi saat tombol Kirim Ulang diklik
        function kirimRevisi(docType) {
            alert('Simulasi: Berkas perbaikan berhasil diunggah! Status akan kembali menjadi Menunggu (Pending).');
            // Dalam implementasi nyata, ini akan merefresh data via AJAX atau reload halaman
        }
    </script>
</body>
</html>
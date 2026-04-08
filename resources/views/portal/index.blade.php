<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Peserta - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Mencegah scroll pada body saat modal terbuka di mobile */
        body.modal-open { overflow: hidden; }
        
        /* Animasi Bottom Sheet / Modal */
        .sheet-enter { transform: translateY(100%); opacity: 0; }
        .sheet-enter-active { transform: translateY(0); opacity: 1; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sheet-exit { transform: translateY(0); opacity: 1; }
        .sheet-exit-active { transform: translateY(100%); opacity: 0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Backdrop Fade */
        .backdrop-enter { opacity: 0; }
        .backdrop-enter-active { opacity: 1; transition: opacity 0.3s ease-out; }
        .backdrop-exit { opacity: 1; }
        .backdrop-exit-active { opacity: 0; transition: opacity 0.3s ease-in; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased selection:bg-blue-200">

    <nav class="bg-white shadow-sm py-4 sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-5 flex justify-between items-center">
            <div>
                <h1 class="text-xl md:text-2xl font-extrabold text-blue-600 tracking-tight">Arsa Training</h1>
                <p class="text-xs text-gray-500 font-medium">Portal Terpadu</p>
            </div>
            <div class="bg-blue-50 p-2 rounded-full text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
            </div>
        </div>
    </nav>

    <main class="px-5 py-8 max-w-4xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Selamat Datang 👋</h2>
            <p class="text-base text-gray-500">Pilih layanan di bawah ini untuk memulai pendaftaran atau memantau status berkas Anda.</p>
        </div>

        <div class="flex flex-col md:flex-row gap-5">
            
            <button onclick="openSheet('sheet-pendaftaran')" class="w-full bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center text-left focus:outline-none active:scale-95 transition-all duration-200 group hover:border-blue-300">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex-shrink-0 flex items-center justify-center mr-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Registrasi Baru</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Isi formulir dan unggah dokumen persyaratan.</p>
                </div>
            </button>

            <button onclick="openSheet('sheet-pantau')" class="w-full bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center text-left focus:outline-none active:scale-95 transition-all duration-200 group hover:border-emerald-300">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex-shrink-0 flex items-center justify-center mr-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM9 12l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Pantau Berkas</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Cek status dan perbaiki dokumen yang ditolak.</p>
                </div>
            </button>

        </div>
    </main>

    <div id="sheet-pendaftaran" class="fixed inset-0 z-50 hidden flex items-end md:items-center justify-center">
        <div id="bd-pendaftaran" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm backdrop-enter" onclick="closeSheet('sheet-pendaftaran')"></div>
        
        <div id="content-pendaftaran" class="relative bg-white w-full max-w-lg md:rounded-3xl rounded-t-[2rem] shadow-2xl overflow-hidden sheet-enter pb-8 md:pb-0">
            
            <div class="w-full flex justify-center pt-4 pb-2 md:hidden">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <div class="flex justify-between items-center px-6 pb-4 pt-2 md:pt-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Pilih Jalur Registrasi</h3>
                <button onclick="closeSheet('sheet-pendaftaran')" class="bg-gray-100 p-2 rounded-full text-gray-500 hover:bg-red-100 hover:text-red-600 transition active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <a href="{{ url('portal/pendaftaran') }}" class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-2xl active:bg-blue-50 active:border-blue-300 transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex-shrink-0 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Pribadi / Individu</h4>
                        <p class="text-xs text-gray-500 mt-1">Daftar secara mandiri.</p>
                    </div>
                    <div class="ml-auto text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>

                <a href="{{ url('portal/pendaftaran-perusahaan') }}" class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-2xl active:bg-blue-50 active:border-blue-300 transition">
                    <div class="w-12 h-12 bg-gray-200 text-gray-600 rounded-full flex-shrink-0 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Perwakilan Instansi</h4>
                        <p class="text-xs text-gray-500 mt-1">Kolektif via Excel & ZIP.</p>
                    </div>
                    <div class="ml-auto text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div id="sheet-pantau" class="fixed inset-0 z-50 hidden flex items-end md:items-center justify-center">
        <div id="bd-pantau" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm backdrop-enter" onclick="closeSheet('sheet-pantau')"></div>
        
        <div id="content-pantau" class="relative bg-white w-full max-w-lg md:rounded-3xl rounded-t-[2rem] shadow-2xl overflow-hidden sheet-enter pb-8 md:pb-0">
            
            <div class="w-full flex justify-center pt-4 pb-2 md:hidden">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <div class="flex justify-between items-center px-6 pb-4 pt-2 md:pt-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Pilih Akses Pantau</h3>
                <button onclick="closeSheet('sheet-pantau')" class="bg-gray-100 p-2 rounded-full text-gray-500 hover:bg-red-100 hover:text-red-600 transition active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <a href="{{ url('portal/cek-status') }}" class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-2xl active:bg-emerald-50 active:border-emerald-300 transition">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex-shrink-0 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Cek Data Pribadi</h4>
                        <p class="text-xs text-gray-500 mt-1">Pakai ID atau Nama Lengkap.</p>
                    </div>
                    <div class="ml-auto text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>

                <a href="{{ url('portal/cek-status-perusahaan') }}" class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-2xl active:bg-emerald-50 active:border-emerald-300 transition">
                    <div class="w-12 h-12 bg-gray-200 text-gray-600 rounded-full flex-shrink-0 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">Dashboard Perusahaan</h4>
                        <p class="text-xs text-gray-500 mt-1">Login dengan Kode Perusahaan.</p>
                    </div>
                    <div class="ml-auto text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        function openSheet(id) {
            const sheet = document.getElementById(id);
            const content = document.getElementById('content-' + id.split('-')[1]);
            const backdrop = document.getElementById('bd-' + id.split('-')[1]);
            
            sheet.classList.remove('hidden');
            document.body.classList.add('modal-open'); // Kunci scroll background

            // Trigger reflow untuk animasi
            void content.offsetWidth;
            
            content.classList.remove('sheet-enter', 'sheet-exit-active');
            content.classList.add('sheet-enter-active');
            
            backdrop.classList.remove('backdrop-enter', 'backdrop-exit-active');
            backdrop.classList.add('backdrop-enter-active');
        }

        function closeSheet(id) {
            const sheet = document.getElementById(id);
            const content = document.getElementById('content-' + id.split('-')[1]);
            const backdrop = document.getElementById('bd-' + id.split('-')[1]);
            
            content.classList.remove('sheet-enter-active');
            content.classList.add('sheet-exit-active');
            
            backdrop.classList.remove('backdrop-enter-active');
            backdrop.classList.add('backdrop-exit-active');
            
            document.body.classList.remove('modal-open'); // Buka kunci scroll

            // Tunggu durasi transisi Tailwind (300ms) sebelum menghilangkan elemen
            setTimeout(() => {
                sheet.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>
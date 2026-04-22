<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Kolektif - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-focus-ring:focus-within { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        body.modal-open { overflow: hidden; }
        
        .fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sheet-enter { transform: translateY(100%); opacity: 0; }
        .sheet-enter-active { transform: translateY(0); opacity: 1; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sheet-exit { transform: translateY(0); opacity: 1; }
        .sheet-exit-active { transform: translateY(100%); opacity: 0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        input[type="file"] { display: none; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 sticky top-0 z-30 border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-5 flex items-center">
            <a href="{{ url('portal') }}" class="mr-4 p-2 bg-gray-50 rounded-full text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-colors active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">Dashboard Kolektif</h1>
                <p class="text-xs text-emerald-600 font-medium">Akses Khusus Penanggung Jawab Instansi</p>
            </div>
        </div>
    </nav>

    <main class="flex-grow px-5 py-8 w-full max-w-4xl mx-auto">

        <div id="login-section" class="w-full max-w-md mx-auto fade-in">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-3xl mb-5 shadow-inner transform rotate-3">
                    <svg class="w-10 h-10 transform -rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                <p class="text-sm text-gray-500 leading-relaxed">Masukkan Nama Perusahaan dan Nomor WhatsApp Penanggung Jawab untuk mengakses data karyawan.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <form onsubmit="event.preventDefault(); prosesLogin();" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nama Instansi / Perusahaan</label>
                        <div class="input-focus-ring transition-shadow rounded-xl relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                            </span>
                            <input type="text" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors text-gray-700" placeholder="Contoh: PT Arsa Jaya Prima">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">No. WhatsApp Penanggung Jawab</label>
                        <div class="input-focus-ring transition-shadow rounded-xl relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input type="tel" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors tracking-widest" placeholder="0812xxxxxx">
                        </div>
                    </div>
                    <button id="btn-login" type="submit" class="w-full bg-emerald-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center mt-4">
                        <span>Akses Dashboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div id="dashboard-section" class="hidden w-full">

            <div class="flex justify-between items-center mb-4 bg-emerald-600 p-5 rounded-3xl text-white shadow-lg shadow-emerald-600/20">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold leading-tight">PT. Arsa Jaya Prima</h2>
                        <p class="text-xs text-emerald-100 font-medium mt-0.5">Kode: CORP-8890</p>
                    </div>
                </div>
                <button onclick="prosesLogout()" class="text-xs font-bold text-emerald-600 bg-white px-4 py-2.5 rounded-xl hover:bg-emerald-50 active:scale-95 transition shadow-sm flex items-center">
                    <span class="hidden md:block mr-1">Keluar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </div>

            <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white border border-emerald-200 text-emerald-600 rounded-full flex items-center justify-center mr-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-0.5">Marketing PIC Instansi Anda</p>
                        <p class="text-sm font-bold text-gray-800">Sri Nurhayati</p>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank" class="w-full md:w-auto flex items-center justify-center text-xs font-bold text-green-700 bg-green-100 border border-green-200 px-4 py-2.5 rounded-xl hover:bg-green-200 hover:border-green-300 transition active:scale-95 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Hubungi Marketing
                </a>
            </div>
            
            <div class="bg-red-50 border border-red-200 p-5 rounded-2xl mb-6 flex items-start" id="alert-revisi">
                <div class="bg-red-100 p-2 rounded-full mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">Perhatian: Ada Berkas yang Perlu Direvisi</h3>
                    <p class="text-xs text-red-600 mt-1 leading-relaxed">Silakan periksa catatan dari Admin pada daftar berkas di bawah ini dan unggah ulang berkas yang sesuai.</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 md:gap-5 mb-8">
                <button type="button" onclick="filterData('all', this)" id="btn-all" class="w-full bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center border-b-4 border-b-blue-500 transition-opacity duration-200 focus:outline-none">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    <h3 class="text-2xl font-bold text-gray-800">12</h3>
                    <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold mt-1">Total Karyawan</p>
                </button>
                
                <button type="button" onclick="filterData('verified', this)" id="btn-verified" class="w-full bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center border-b-4 border-b-green-500 opacity-50 hover:opacity-100 transition-opacity duration-200 focus:outline-none">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h3 class="text-2xl font-bold text-gray-800">8</h3>
                    <p class="text-[10px] md:text-xs text-gray-500 uppercase font-bold mt-1">Terverifikasi</p>
                </button>

                <button type="button" onclick="filterData('revision', this)" id="btn-revision" class="w-full bg-red-50 p-4 rounded-2xl shadow-sm border border-red-100 text-center border-b-4 border-b-red-500 opacity-50 hover:opacity-100 transition-opacity duration-200 focus:outline-none">
                    <div class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                    <h3 class="text-2xl font-bold text-red-700">4</h3>
                    <p class="text-[10px] md:text-xs text-red-600 uppercase font-bold mt-1">Butuh Revisi</p>
                </button>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800 ml-1">Delegasi Karyawan</h2>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="w-full md:w-1/3">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 ml-1">Cari Nama</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                            <input type="text" id="filter-name" onkeyup="applyFilters()" class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Ketik nama karyawan...">
                        </div>
                    </div>

                    <div class="w-full md:w-1/3">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 ml-1">Program Pelatihan</label>
                        <select id="filter-program" onchange="applyFilters()" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-gray-700">
                            <option value="all">Semua Program</option>
                            <option value="Web Development & SEO">Web Development & SEO</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                            <option value="Marketing Officer">Marketing Officer</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/3 flex gap-2">
                        <div class="w-1/2">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 ml-1">Dari Tanggal</label>
                            <input type="date" class="w-full px-2 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-gray-700">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 ml-1">Sampai</label>
                            <input type="date" class="w-full px-2 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none text-gray-700">
                        </div>
                    </div>

                </div>
            </div>

            <div class="space-y-4" id="employee-list">

                <div class="emp-item bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4" data-status="verified" data-program="Web Development & SEO">
                    <div class="flex items-start md:items-center">
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg mr-4 flex-shrink-0">
                            DN
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 emp-name leading-tight">Dhandy Nuzirwan</h3>
                            <p class="text-sm text-blue-600 font-medium mt-0.5">Web Development & SEO</p>
                            <div class="flex items-center text-gray-400 text-[11px] mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Pelaksanaan: 10 Jan 2026
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end w-full md:w-auto border-t border-gray-50 md:border-t-0 pt-3 md:pt-0">
                        <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider md:mr-4">Disetujui</span>
                        <button class="text-xs font-bold text-gray-400 cursor-not-allowed hidden md:block">Lengkap</button>
                    </div>
                </div>
            
                <div class="emp-item bg-white p-5 rounded-3xl shadow-sm border-2 border-red-100 flex flex-col md:flex-row md:items-center justify-between gap-4 relative overflow-hidden" data-status="revision" data-program="UI/UX Design">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>
                    
                    <div class="flex items-start md:items-center pl-2">
                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 font-bold text-lg mr-4 flex-shrink-0">
                            LP
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 emp-name leading-tight">Leo Pratama</h3>
                            <p class="text-sm text-red-600 font-medium mt-0.5">UI/UX Design Masterclass</p>
                            <div class="flex items-center text-gray-400 text-[11px] mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Pelaksanaan: 12 Jan 2026
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end w-full md:w-auto border-t border-gray-50 md:border-t-0 pt-3 md:pt-0 pl-2">
                        <div class="flex flex-col md:items-end md:mr-4">
                            <span class="bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block w-max mb-1">Revisi Berkas</span>
                            <p class="text-[10px] text-red-500 hidden md:block">KTP blur/tidak terbaca</p>
                        </div>
                        <button onclick="openSheet('sheet-revisi-leo')" class="bg-red-50 text-red-600 border border-red-200 text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-red-600 hover:text-white active:scale-95 transition-all flex items-center shadow-sm">
                            Perbaiki <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            
                <div class="emp-item bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 opacity-80" data-status="pending" data-program="Marketing Officer">
                    <div class="flex items-start md:items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg mr-4 flex-shrink-0">
                            AS
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 emp-name leading-tight">Ahmad Subagyo</h3>
                            <p class="text-sm text-gray-600 font-medium mt-0.5">Marketing Officer</p>
                            <div class="flex items-center text-gray-400 text-[11px] mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Pelaksanaan: 15 Jan 2026
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end w-full md:w-auto border-t border-gray-50 md:border-t-0 pt-3 md:pt-0">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider md:mr-4">Menunggu</span>
                        <button class="text-xs font-bold text-gray-400 cursor-not-allowed hidden md:block">Antrean</button>
                    </div>
                </div>
            
            </div>
        </div>
    </main>

    <div id="sheet-revisi-leo" class="fixed inset-0 z-50 hidden flex items-end md:items-center justify-center">
        <div id="bd-revisi-leo" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity" onclick="closeSheet('sheet-revisi-leo')"></div>
        <div id="content-revisi-leo" class="relative bg-white w-full max-w-lg md:rounded-3xl rounded-t-[2rem] shadow-2xl overflow-hidden sheet-enter pb-6 md:pb-0">
            <div class="w-full flex justify-center pt-4 pb-2 md:hidden"><div class="w-12 h-1.5 bg-gray-300 rounded-full"></div></div>
            <div class="flex justify-between items-start px-6 pb-4 pt-2 md:pt-6 border-b border-gray-100">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Perbaiki Berkas</h3>
                    <p class="text-sm text-gray-500 mt-1">Karyawan: <span class="font-bold text-gray-800">Leo Pratama</span></p>
                </div>
                <button onclick="closeSheet('sheet-revisi-leo')" class="bg-gray-100 p-2 rounded-full text-gray-500 hover:bg-red-100 hover:text-red-600 transition active:scale-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-5">
                <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                    <div class="flex items-center mb-2">
                        <span class="bg-red-200 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider mr-2">Masalah</span>
                        <p class="text-sm font-bold text-red-900">Scan KTP Asli</p>
                    </div>
                    <p class="text-xs text-red-700 leading-relaxed">"Dokumen yang diunggah sebelumnya blur dan NIK tidak terbaca. Mohon unggah ulang dengan pencahayaan yang baik."</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Unggah File Perbaikan</label>
                    <label id="drop-area-leo" class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-6 h-6 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <p class="text-xs text-gray-500 font-medium">Tap untuk memilih file KTP baru</p>
                        </div>
                        <input type="file" accept=".jpg,.png,.pdf" onchange="previewRevisi(this)" />
                    </label>
                    <div id="file-preview-leo" class="hidden mt-3 items-center justify-between p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                        <div class="flex items-center overflow-hidden">
                            <svg class="w-5 h-5 text-emerald-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span id="nama-file-leo" class="text-xs font-bold text-emerald-800 truncate">ktp_baru.jpg</span>
                        </div>
                        <button onclick="resetUpload()" class="text-xs text-red-500 hover:text-red-700 ml-2 font-bold flex-shrink-0">Batal</button>
                    </div>
                </div>
                <button onclick="kirimRevisi()" class="w-full bg-emerald-600 text-white font-bold text-sm md:text-base py-3.5 rounded-xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center">
                    Kirim Perbaikan
                </button>
            </div>
        </div>
    </div>

    <script>
        function prosesLogin() {
            const btn = document.getElementById('btn-login');
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Otentikasi...`;
            btn.classList.replace('bg-emerald-600', 'bg-emerald-400');

            setTimeout(() => {
                document.getElementById('login-section').classList.add('hidden');
                document.getElementById('dashboard-section').classList.remove('hidden');
                document.getElementById('dashboard-section').classList.add('fade-in');

                btn.disabled = false;
                btn.innerHTML = `<span>Akses Dashboard</span><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>`;
                btn.classList.replace('bg-emerald-400', 'bg-emerald-600');
            }, 1000);
        }

        function prosesLogout() {
            document.getElementById('dashboard-section').classList.add('hidden');
            document.getElementById('dashboard-section').classList.remove('fade-in');
            document.getElementById('login-section').classList.remove('hidden');
            document.getElementById('login-section').classList.add('fade-in');
        }

        let currentStatusFilter = 'all';

        function filterData(status, btnElement) {
            currentStatusFilter = status;

            document.getElementById('btn-all').classList.add('opacity-50');
            document.getElementById('btn-verified').classList.add('opacity-50');
            document.getElementById('btn-revision').classList.add('opacity-50');

            btnElement.classList.remove('opacity-50');

            applyFilters();
        }

        function applyFilters() {
            const searchName = document.getElementById('filter-name').value.toLowerCase();
            const filterProgram = document.getElementById('filter-program').value;
            
            const items = document.querySelectorAll('.emp-item');

            items.forEach(item => {
                const name = item.querySelector('.emp-name').innerText.toLowerCase();
                const itemStatus = item.getAttribute('data-status');
                const itemProgram = item.getAttribute('data-program');

                const matchStatus = (currentStatusFilter === 'all' || itemStatus === currentStatusFilter);
                const matchName = name.includes(searchName);
                const matchProgram = (filterProgram === 'all' || itemProgram === filterProgram);

                if (matchStatus && matchName && matchProgram) {
                    item.style.display = ''; 
                } else {
                    item.style.display = 'none'; 
                }
            });
        }

        function openSheet(id) {
            const sheet = document.getElementById(id);
            const content = document.getElementById('content-' + id.split('-').slice(1).join('-'));
            const backdrop = document.getElementById('bd-' + id.split('-').slice(1).join('-'));

            sheet.classList.remove('hidden');
            document.body.classList.add('modal-open');
            void content.offsetWidth; 

            content.classList.remove('sheet-enter', 'sheet-exit-active');
            content.classList.add('sheet-enter-active');
            backdrop.style.opacity = '1';
        }

        function closeSheet(id) {
            const sheet = document.getElementById(id);
            const content = document.getElementById('content-' + id.split('-').slice(1).join('-'));
            const backdrop = document.getElementById('bd-' + id.split('-').slice(1).join('-'));

            content.classList.remove('sheet-enter-active');
            content.classList.add('sheet-exit-active');
            backdrop.style.opacity = '0';
            document.body.classList.remove('modal-open');

            setTimeout(() => {
                sheet.classList.add('hidden');
            }, 300);
        }

        function previewRevisi(input) {
            if (input.files && input.files.length > 0) {
                document.getElementById('drop-area-leo').classList.add('hidden');
                document.getElementById('file-preview-leo').classList.remove('hidden');
                document.getElementById('file-preview-leo').classList.add('flex');
                document.getElementById('nama-file-leo').innerText = input.files[0].name;
            }
        }

        function resetUpload() {
            document.getElementById('drop-area-leo').classList.remove('hidden');
            document.getElementById('file-preview-leo').classList.add('hidden');
            document.getElementById('file-preview-leo').classList.remove('flex');
        }

        function kirimRevisi() {
            alert('Simulasi: Berkas Leo Pratama berhasil diperbarui. Status akan berubah menjadi "Menunggu Verifikasi Ulang".');
            closeSheet('sheet-revisi-leo');
            resetUpload();
            document.getElementById('alert-revisi').classList.add('hidden');
        }
    </script>
</body>
</html>
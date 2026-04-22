<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Instansi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-focus-ring:focus-within {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); /* Emerald ring */
        }
        input[type="file"] {
            display: none;
        }
        /* Animasi munculnya form baru */
        .slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Animasi Bottom Sheet / Modal */
        body.modal-open { overflow: hidden; }
        .sheet-enter { transform: translateY(100%); opacity: 0; }
        .sheet-enter-active { transform: translateY(0); opacity: 1; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sheet-exit { transform: translateY(0); opacity: 1; }
        .sheet-exit-active { transform: translateY(100%); opacity: 0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 sticky top-0 z-30 border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-5 flex items-center">
            <a href="{{ url('portal') }}" class="mr-4 p-2 bg-gray-50 rounded-full text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-colors active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">Form Kolektif</h1>
                <p class="text-xs text-emerald-600 font-medium">Jalur Perwakilan Instansi</p>
            </div>
        </div>
    </nav>

    <main class="px-5 py-8 max-w-3xl mx-auto">
        
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-6 flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 mr-3 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm text-emerald-800 leading-relaxed">Jalur ini diperuntukkan bagi HRD/Penanggung Jawab yang mendaftarkan karyawannya. Silakan isi data peserta di bawah ini dan unggah 1 file ZIP berisi kumpulan berkas persyaratan.</p>
        </div>

        <form onsubmit="event.preventDefault(); submitFormCompany();" class="space-y-8">
            
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                    Data Instansi & Penanggung Jawab
                </h2>
                
                <div class="space-y-5">
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Instansi / Perusahaan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01" /></svg>
                            </span>
                            <input type="text" required class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors" placeholder="Contoh: PT. Arsa Jaya Prima">
                        </div>
                    </div>

                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Alamat Lengkap Perusahaan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </span>
                            <input type="text" required class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors" placeholder="Contoh: Jl. Sudirman No. 123, Yogyakarta">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Penanggung Jawab</label>
                            <input type="text" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors text-gray-700" placeholder="Nama Anda">
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">WhatsApp Penanggung Jawab</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">+62</span>
                                <input type="tel" required class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors" placeholder="8123456789">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="space-y-4 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-50">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Opsi Pembayaran <span class="text-red-500">*</span></label>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="tanpa_ppn" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500" checked onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Tanpa PPN</span>
                            </label>
                            
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="dengan_ppn" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500" onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Dengan PPN (11%)</span>
                            </label>
                        </div>

                        <div id="npwp-container" class="hidden input-focus-ring transition-all duration-300 ease-in-out rounded-xl mt-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor NPWP Instansi (15/16 Digit) <span class="text-red-500">*</span></label>
                            <input type="text" id="input_npwp" name="npwp" maxlength="16" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors" placeholder="Masukkan angka NPWP Instansi">
                            <p class="text-[11px] text-gray-500 mt-1.5 ml-1"><i class="fas fa-info-circle mr-1"></i>Masukkan NPWP tanpa tanda baca (- atau .)</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                        Data Peserta & Berkas
                    </h2>
                </div>

                <div id="peserta-container" class="space-y-6 mb-6">
                    <div class="peserta-card bg-gray-50 border border-gray-200 rounded-2xl p-5 relative">
                        <h3 class="text-sm font-bold text-emerald-700 mb-4 flex items-center">
                            <span class="bg-emerald-100 px-2 py-0.5 rounded mr-2 nomor-peserta">#1</span> Data Karyawan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="input-focus-ring rounded-xl">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Nama Lengkap</label>
                                <input type="text" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="Sesuai KTP">
                            </div>
                            <div class="input-focus-ring rounded-xl">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Divisi / Jabatan</label>
                                <input type="text" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: Staff IT">
                            </div>
                            <div class="input-focus-ring rounded-xl">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">No. WhatsApp</label>
                                <input type="tel" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="0812xxxx">
                            </div>
                            <div class="input-focus-ring rounded-xl">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Judul Pelatihan</label>
                                <select required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm text-gray-700">
                                    <option value="" disabled selected>Pilih Pelatihan...</option>
                                    <option value="web">Web Development</option>
                                    <option value="seo">Digital Marketing & SEO</option>
                                    <option value="uiux">UI/UX Design Masterclass</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="tambahPeserta()" class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold py-3 rounded-xl hover:bg-emerald-100 transition-colors flex items-center justify-center mb-8 border-dashed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Peserta Lainnya
                </button>

                <hr class="border-gray-200 mb-8">

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-800">Kumpulan Berkas Peserta (.ZIP/.RAR)</label>
                            <p class="text-xs text-gray-500 mt-1">Jadikan satu folder seluruh berkas kelengkapan dari para peserta di atas, lalu kompres ke ZIP.</p>
                        </div>
                        
                        <button type="button" onclick="openSheet('sheet-detail-berkas')" class="mt-3 md:mt-0 text-xs font-bold text-emerald-600 bg-emerald-100/50 px-4 py-2 rounded-lg hover:bg-emerald-100 transition flex items-center flex-shrink-0">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lihat Syarat Berkas
                        </button>
                    </div>
                    
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-emerald-300 rounded-2xl cursor-pointer bg-white hover:bg-emerald-50 hover:border-emerald-400 transition-colors group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 text-emerald-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            <p class="text-sm text-gray-500 group-hover:text-emerald-700 font-medium"><span class="font-bold">Tap untuk upload</span> file ZIP/RAR</p>
                        </div>
                        <input type="file" accept=".zip,.rar" onchange="updateFileName(this, 'zip-name')" />
                    </label>
                    <p id="zip-name" class="text-xs text-green-600 font-medium mt-2 hidden flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> File terpilih
                    </p>
                </div>
            </div>

            <button id="btn-submit-company" type="submit" class="w-full bg-emerald-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center">
                <span>Kirim Pendaftaran Instansi</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </main>

    <div id="sheet-detail-berkas" class="fixed inset-0 z-50 hidden flex items-end md:items-center justify-center">
        <div id="bd-detail-berkas" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity" onclick="closeSheet('sheet-detail-berkas')"></div>
        
        <div id="content-detail-berkas" class="relative bg-white w-full max-w-md md:rounded-3xl rounded-t-[2rem] shadow-2xl overflow-hidden sheet-enter pb-6 md:pb-0">
            
            <div class="w-full flex justify-center pt-4 pb-2 md:hidden">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
            </div>

            <div class="flex justify-between items-start px-6 pb-4 pt-2 md:pt-6 border-b border-gray-100 bg-emerald-50/50">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Syarat Kelengkapan Berkas</h3>
                    <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Harap pastikan 7 dokumen di bawah ini tersedia untuk <span class="font-bold text-emerald-600">setiap karyawan</span> sebelum dikompres ke format .ZIP.</p>
                </div>
                <button onclick="closeSheet('sheet-detail-berkas')" class="bg-white border border-gray-200 p-2 rounded-full text-gray-500 hover:bg-red-50 hover:text-red-600 transition active:scale-90 shadow-sm ml-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">1</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Scan KTP Asli</p>
                            <p class="text-[11px] text-gray-500">Format: PDF/JPG/PNG</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">2</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Scan Ijazah Terakhir</p>
                            <p class="text-[11px] text-gray-500">Format: PDF/JPG/PNG</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">3</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Pas Foto Formal</p>
                            <p class="text-[11px] text-gray-500">Background Merah. Format: JPG/PNG</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">4</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Curriculum Vitae (CV)</p>
                            <p class="text-[11px] text-gray-500">Format: PDF</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">5</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Surat Keterangan Kerja</p>
                            <p class="text-[11px] text-gray-500">Format: PDF/JPG</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">6</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Laporan Kerja</p>
                            <p class="text-[11px] text-gray-500">Format: PDF/DOCX</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5"><span class="text-xs font-bold">7</span></div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Uraian Jobdesk / SOP</p>
                            <p class="text-[11px] text-gray-500">Format: PDF/DOCX</p>
                        </div>
                    </li>
                </ul>

                <button onclick="closeSheet('sheet-detail-berkas')" type="button" class="w-full mt-6 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 active:scale-95 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // NEW: Fungsi Toggle Input NPWP
        function toggleNpwp() {
            const isDenganPpn = document.querySelector('input[name="opsi_ppn"][value="dengan_ppn"]').checked;
            const npwpContainer = document.getElementById('npwp-container');
            const inputNpwp = document.getElementById('input_npwp');

            if (isDenganPpn) {
                npwpContainer.classList.remove('hidden');
                inputNpwp.setAttribute('required', 'required');
            } else {
                npwpContainer.classList.add('hidden');
                inputNpwp.removeAttribute('required');
                inputNpwp.value = ''; // Kosongkan jika user batal pilih PPN
            }
        }

        // NEW: Validasi input NPWP agar hanya bisa diisi angka
        document.getElementById('input_npwp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        let jumlahPeserta = 1;

        function tambahPeserta() {
            jumlahPeserta++;
            const container = document.getElementById('peserta-container');
            
            const cardBaru = document.createElement('div');
            cardBaru.className = 'peserta-card bg-gray-50 border border-gray-200 rounded-2xl p-5 relative slide-down';
            
            cardBaru.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-emerald-700 flex items-center">
                        <span class="bg-emerald-100 px-2 py-0.5 rounded mr-2 nomor-peserta">#${jumlahPeserta}</span> Data Karyawan
                    </h3>
                    <button type="button" onclick="hapusPeserta(this)" class="text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-focus-ring rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Nama Lengkap</label>
                        <input type="text" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="Sesuai KTP">
                    </div>
                    <div class="input-focus-ring rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Divisi / Jabatan</label>
                        <input type="text" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="Contoh: Staff IT">
                    </div>
                    <div class="input-focus-ring rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">No. WhatsApp</label>
                        <input type="tel" required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm" placeholder="0812xxxx">
                    </div>
                    <div class="input-focus-ring rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Judul Pelatihan</label>
                        <select required class="w-full px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:border-emerald-500 outline-none text-sm text-gray-700">
                            <option value="" disabled selected>Pilih Pelatihan...</option>
                            <option value="web">Web Development</option>
                            <option value="seo">Digital Marketing & SEO</option>
                            <option value="uiux">UI/UX Design Masterclass</option>
                        </select>
                    </div>
                </div>
            `;
            
            container.appendChild(cardBaru);
            updateNomorPeserta();
        }

        function hapusPeserta(elemenTombol) {
            const kartu = elemenTombol.closest('.peserta-card');
            kartu.remove();
            jumlahPeserta--;
            updateNomorPeserta();
        }

        function updateNomorPeserta() {
            const semuaNomor = document.querySelectorAll('.nomor-peserta');
            semuahNomor.forEach((elemen, index) => {
                elemen.innerText = `#${index + 1}`;
            });
        }

        function updateFileName(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Berkas terlampir: ${input.files[0].name}`;
                textElement.classList.remove('hidden');
            } else {
                textElement.classList.add('hidden');
            }
        }

        // ================= FUNGSI BOTTOM SHEET / MODAL =================
        function openSheet(id) {
            const sheet = document.getElementById(id);
            const content = document.getElementById('content-' + id.split('-').slice(1).join('-'));
            const backdrop = document.getElementById('bd-' + id.split('-').slice(1).join('-'));

            sheet.classList.remove('hidden');
            document.body.classList.add('modal-open');
            void content.offsetWidth; // Trigger reflow animasi

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

        function submitFormCompany() {
            const btn = document.getElementById('btn-submit-company');
            
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses ${jumlahPeserta} Data Karyawan...
            `;
            btn.classList.replace('bg-emerald-600', 'bg-emerald-400');

            setTimeout(() => {
                window.location.href = "{{ url('portal/sukses') }}";
                
                btn.disabled = false;
                btn.innerHTML = `
                    <span>Kirim Pendaftaran Instansi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                `;
                btn.classList.replace('bg-emerald-400', 'bg-emerald-600');
            }, 2000);
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pribadi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-focus-ring:focus-within { box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        input[type="file"] { display: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 sticky top-0 z-30 border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-5 flex items-center">
            <a href="{{ url('portal') }}" class="mr-4 p-2 bg-gray-50 rounded-full text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">Form Pendaftaran</h1>
                <p class="text-xs text-blue-600 font-medium">Jalur Individu / Pribadi</p>
            </div>
        </div>
    </nav>

    <main class="px-5 py-8 max-w-3xl mx-auto">
        
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-6 flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm text-blue-800 leading-relaxed">Pastikan data yang Anda masukkan sesuai dengan dokumen asli. Kami akan memverifikasi berkas Anda dalam waktu 1x24 jam kerja.</p>
        </div>

        <form onsubmit="event.preventDefault(); submitForm();" class="space-y-8">
            
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                    Data Diri & Pekerjaan
                </h2>
                
                <div class="space-y-5">
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: Dhandy Nuzirwan" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors text-gray-700" required>
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">+62</span>
                                <input type="tel" class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="8123456789" required>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Perusahaan (Opsional)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                                </span>
                                <input type="text" class="w-full pl-9 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Tempat bekerja saat ini">
                            </div>
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Alamat Perusahaan (Opsional)</label>
                            <input type="text" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Kota/Kabupaten">
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="space-y-4 bg-blue-50/50 p-4 rounded-2xl border border-blue-50">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Opsi Pembayaran <span class="text-red-500">*</span></label>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="tanpa_ppn" class="w-4 h-4 text-blue-600 focus:ring-blue-500" checked onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Tanpa PPN</span>
                            </label>
                            
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="dengan_ppn" class="w-4 h-4 text-blue-600 focus:ring-blue-500" onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Dengan PPN (11%)</span>
                            </label>
                        </div>

                        <div id="npwp-container" class="hidden input-focus-ring transition-all duration-300 ease-in-out rounded-xl mt-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor NPWP (16 Digit) <span class="text-red-500">*</span></label>
                            <input type="text" id="input_npwp" name="npwp" maxlength="16" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Masukkan 16 digit angka NPWP">
                            <p class="text-[11px] text-gray-500 mt-1.5 ml-1"><i class="fas fa-info-circle mr-1"></i>Masukkan NPWP format 16 digit (NIK) tanpa tanda baca (- atau .)</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                    Dokumen Persyaratan
                </h2>

                <div class="space-y-3">
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">1. Scan KTP Asli <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileNameList(this, 'file-ktp')" />
                            </label>
                            <p id="file-ktp" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">2. Scan Ijazah <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileNameList(this, 'file-ijazah')" />
                            </label>
                            <p id="file-ijazah" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">3. Pas Foto Formal <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Background merah. Format JPG/PNG.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".jpg,.jpeg,.png" onchange="updateFileNameList(this, 'file-foto')" />
                            </label>
                            <p id="file-foto" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">4. Curriculum Vitae (CV) <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf" onchange="updateFileNameList(this, 'file-cv')" />
                            </label>
                            <p id="file-cv" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">5. Surat Keterangan Kerja <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileNameList(this, 'file-sk')" />
                            </label>
                            <p id="file-sk" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">6. Laporan Kerja <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/DOCX.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf,.docx,.doc" onchange="updateFileNameList(this, 'file-laporan')" />
                            </label>
                            <p id="file-laporan" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">7. Uraian Jobdesk / SOP <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/DOCX.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" accept=".pdf,.docx,.doc" onchange="updateFileNameList(this, 'file-sop')" />
                            </label>
                            <p id="file-sop" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                </div>
            </div>

            <button id="btn-submit" type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all flex items-center justify-center">
                <span>Kirim Pendaftaran</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </main>
    

    <script>
        
        // Fungsi Toggle Input NPWP
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

        // Validasi input NPWP agar hanya bisa diisi angka (mencegah user input huruf/simbol)
        document.getElementById('input_npwp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Fungsi Update Nama File untuk List Design
        function updateFileNameList(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = `✓ ${input.files[0].name}`;
                textElement.classList.remove('hidden');
                // Ubah border kotak upload jadi hijau menandakan sukses
                input.parentElement.classList.replace('border-gray-300', 'border-green-400');
                input.parentElement.classList.replace('bg-white', 'bg-green-50');
                input.previousElementSibling.innerText = "Ganti File"; // Ubah teks
            } else {
                textElement.classList.add('hidden');
                input.parentElement.classList.replace('border-green-400', 'border-gray-300');
                input.parentElement.classList.replace('bg-green-50', 'bg-white');
                input.previousElementSibling.innerText = "Pilih File...";
            }
        }

        // Fungsi Submit
        function submitForm() {
            const btn = document.getElementById('btn-submit');
            
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengunggah Berkas...
            `;
            btn.classList.replace('bg-blue-600', 'bg-blue-400');

            setTimeout(() => {
                window.location.href = "{{ url('portal/sukses') }}";
                
                // Reset tombol jika back button ditekan
                btn.disabled = false;
                btn.innerHTML = `
                    <span>Kirim Pendaftaran</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                `;
                btn.classList.replace('bg-blue-400', 'bg-blue-600');
            }, 1500);
        }
    </script>
</body>
</html>
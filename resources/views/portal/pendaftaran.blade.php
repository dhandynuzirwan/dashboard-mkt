<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pribadi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi transisi custom */
        .input-focus-ring:focus-within {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        
        /* Menyembunyikan input file bawaan yang jelek */
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 sticky top-0 z-30 border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-5 flex items-center">
            <a href="{{ url('portal') }}" class="mr-4 p-2 bg-gray-50 rounded-full text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
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
                    Data Pribadi
                </h2>
                
                <div class="space-y-5">
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: Dhandy Nuzirwan">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Tanggal Lahir</label>
                            <input type="date" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors text-gray-700">
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">+62</span>
                                <input type="tel" required class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="8123456789">
                            </div>
                        </div>
                    </div>

                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Program Pelatihan</label>
                        <div class="relative">
                            <select required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors appearance-none font-medium text-gray-700">
                                <option value="" disabled selected>Pilih program pelatihan...</option>
                                <option value="web">Web Development Bootcamp</option>
                                <option value="seo">Digital Marketing & SEO</option>
                                <option value="uiux">UI/UX Design Masterclass</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                    Dokumen Persyaratan
                </h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Scan KTP Asli</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p class="text-sm text-gray-500 group-hover:text-blue-600 font-medium"><span class="font-bold">Tap untuk upload</span> atau drag file</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG (Max 2MB)</p>
                            </div>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'ktp-name')" />
                        </label>
                        <p id="ktp-name" class="text-xs text-green-600 font-medium mt-2 hidden flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> File terpilih
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Scan Ijazah Terakhir</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p class="text-sm text-gray-500 group-hover:text-blue-600 font-medium"><span class="font-bold">Tap untuk upload</span> atau drag file</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG (Max 2MB)</p>
                            </div>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'ijazah-name')" />
                        </label>
                        <p id="ijazah-name" class="text-xs text-green-600 font-medium mt-2 hidden flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> File terpilih
                        </p>
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
        // Fungsi untuk memberikan feedback visual saat file dipilih
        function updateFileName(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Berkas terlampir: ${input.files[0].name}`;
                textElement.classList.remove('hidden');
            } else {
                textElement.classList.add('hidden');
            }
        }

        // Fungsi simulasi loading dan sukses submit
        function submitForm() {
            const btn = document.getElementById('btn-submit');
            
            // State Loading
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses Data...
            `;
            btn.classList.replace('bg-blue-600', 'bg-blue-400');

            // Simulasi delay server 1.5 detik
            setTimeout(() => {
                alert("Simulasi: Pendaftaran Berhasil! ID Pendaftaran Anda: PLT-2026-089\n\nNantinya, user akan diarahkan ke halaman sukses atau Dashboard Pantau.");
                
                // Reset tombol
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
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
            <p class="text-sm text-emerald-800 leading-relaxed">Jalur ini diperuntukkan bagi HRD/PIC yang mendaftarkan karyawannya. Anda cukup mengunggah 1 file Excel dan 1 file ZIP.</p>
        </div>

        <form onsubmit="event.preventDefault(); submitFormCompany();" class="space-y-8">
            
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                    Data Instansi & PIC
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Penanggung Jawab</label>
                            <input type="text" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors text-gray-700" placeholder="Nama Anda">
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">WhatsApp PIC</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">+62</span>
                                <input type="tel" required class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors" placeholder="8123456789">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                        Unggah Kolektif
                    </h2>
                    <a href="#" class="text-sm font-bold text-emerald-600 hover:underline flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Template Excel
                    </a>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">1. Data Karyawan (.XLSX)</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm text-gray-500 group-hover:text-emerald-600 font-medium"><span class="font-bold">Tap untuk upload</span> Excel Data</p>
                            </div>
                            <input type="file" accept=".xlsx,.csv" onchange="updateFileName(this, 'excel-name')" />
                        </label>
                        <p id="excel-name" class="text-xs text-green-600 font-medium mt-2 hidden flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> File terpilih
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">2. Kumpulan Berkas (.ZIP)</label>
                        <p class="text-xs text-gray-500 mb-3 -mt-1">Jadikan satu folder seluruh foto KTP/Ijazah karyawan, lalu kompres menjadi format ZIP atau RAR.</p>
                        
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                <p class="text-sm text-gray-500 group-hover:text-emerald-600 font-medium"><span class="font-bold">Tap untuk upload</span> file ZIP</p>
                            </div>
                            <input type="file" accept=".zip,.rar" onchange="updateFileName(this, 'zip-name')" />
                        </label>
                        <p id="zip-name" class="text-xs text-green-600 font-medium mt-2 hidden flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> File terpilih
                        </p>
                    </div>
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

    <script>
        function updateFileName(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = `<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Berkas terlampir: ${input.files[0].name}`;
                textElement.classList.remove('hidden');
            } else {
                textElement.classList.add('hidden');
            }
        }

        function submitFormCompany() {
            const btn = document.getElementById('btn-submit-company');
            
            // State Loading
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengunggah Data Kolektif...
            `;
            btn.classList.replace('bg-emerald-600', 'bg-emerald-400');

            // Simulasi delay server 2 detik (karena file ZIP ceritanya lebih berat)
            setTimeout(() => {
                alert("Simulasi: Pendaftaran Instansi Berhasil!\n\nKode Akses Dashboard Perusahaan Anda: CORP-8890\nKata Sandi (PIN): Menggunakan No. WhatsApp PIC.\n\nSimpan data ini untuk memantau status karyawan Anda.");
                
                // Reset tombol
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
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

        {{-- 🔥 TAMPILKAN ERROR JIKA DATA TIDAK DITEMUKAN 🔥 --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 fade-in">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline text-sm">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- KONDISI 1: FORM PENCARIAN (Tampil jika belum ada pencarian) --}}
        {{-- ========================================================= --}}
        @if(!isset($pendaftaran))
        <div id="search-section" class="fade-in block">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Cari Data Anda</h2>
                <p class="text-sm text-gray-500">Masukkan ID Pendaftaran atau Data Diri Anda.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <form action="{{ route('portal.cek-status') }}" method="GET">
                    
                    <div class="space-y-4 mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Gunakan ID Pendaftaran</label>
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <input type="text" name="id_pendaftaran" value="{{ request('id_pendaftaran') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: IND-2026-001">
                        </div>
                    </div>

                    <div class="relative flex items-center justify-center mb-8">
                        <span class="absolute w-full h-px bg-gray-200"></span>
                        <span class="relative bg-white px-4 text-xs font-bold text-gray-400 uppercase tracking-widest">ATAU</span>
                    </div>

                    <div class="space-y-5 mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Gunakan Data Diri</label>
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <input type="text" name="nama_lengkap" value="{{ request('nama_lengkap') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Nama Lengkap Sesuai KTP">
                        </div>
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <input type="date" name="tanggal_lahir" value="{{ request('tanggal_lahir') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors text-gray-700">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all">
                        Cari Status Berkas
                    </button>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- KONDISI 2: HASIL PENCARIAN (Tampil jika data ditemukan) --}}
        {{-- ========================================================= --}}
        @else
        <div id="result-section" class="fade-in block">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Halo, {{ $pendaftaran->nama_lengkap }}</h2>
                        <p class="text-sm text-gray-500 mt-1">ID: <span class="font-bold text-gray-700">{{ $pendaftaran->id_pendaftaran }}</span></p>
                        <p class="text-sm text-gray-500">Program: {{ $pendaftaran->training->nama_training ?? '-' }}</p>
                        
                        {{-- Status Pendaftaran Utama --}}
                        <div class="mt-2">
                            @if($pendaftaran->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Sedang Diverifikasi</span>
                            @elseif($pendaftaran->status == 'diterima')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Diterima</span>
                            @elseif($pendaftaran->status == 'revisi')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Butuh Revisi</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('portal.cek-status') }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-2 rounded-lg hover:bg-blue-100 active:scale-95 transition">
                        Cari Lain
                    </a>
                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-50">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl text-[11px] font-bold uppercase tracking-wider cursor-not-allowed shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Zoom Pelatihan (Terkunci)
                    </button>
                    {{-- Sisanya sama, biarkan terkunci karena belum diterima admin --}}
                </div>

                <hr class="border-gray-100 my-4">
                <div class="bg-blue-50/50 p-3.5 rounded-xl border border-blue-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white border border-blue-100 text-blue-500 rounded-full flex items-center justify-center mr-3 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Marketing PIC</p>
                            <p class="text-sm font-bold text-gray-800">Menunggu Admin</p>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-4 ml-1">Status Dokumen Persyaratan</h3>

            <div class="space-y-4 pb-8">
                
                {{-- KARENA DEFAULT PENDING, KITA BUAT LOOPING TAMPILAN KUNING SEMUA DULU --}}
                @php
                    $dokumens = [
                        '1. Scan KTP Asli', '2. Scan Ijazah', '3. Pas Foto Formal', 
                        '4. Curriculum Vitae (CV)', '5. Surat Keterangan Kerja', 
                        '6. Laporan Kerja', '7. Uraian Jobdesk / SOP'
                    ];
                @endphp

                @foreach($dokumens as $dok)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between opacity-90">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $dok }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Menunggu antrean verifikasi</p>
                        </div>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                </div>
                @endforeach

            </div>
        </div>
        @endif
    </main>

    <script>
        function simulasikanPencarian() {
            const btn = document.getElementById('btn-search');
            const searchSection = document.getElementById('search-section');
            const resultSection = document.getElementById('result-section');

            btn.innerHTML = 'Mencari Data...';
            btn.classList.replace('bg-blue-600', 'bg-blue-400');
            btn.disabled = true;

            setTimeout(() => {
                searchSection.classList.replace('block', 'hidden');
                resultSection.classList.remove('hidden');
                resultSection.classList.add('fade-in');

                btn.innerHTML = 'Cari Status Berkas';
                btn.classList.replace('bg-blue-400', 'bg-blue-600');
                btn.disabled = false;
            }, 800);
        }

        function resetPencarian() {
            document.getElementById('result-section').classList.add('hidden');
            document.getElementById('search-section').classList.replace('hidden', 'block');
            
            // Optional: Mengembalikan state ijazah jika sebelumnya disimulasikan sukses
            const actionArea = document.getElementById('action-area-ijazah');
            const uploadArea = document.getElementById('upload-area-ijazah');
            const cardIjazah = document.getElementById('card-ijazah');
            
            if(!actionArea.classList.contains('hidden')){
                 actionArea.classList.remove('flex');
                 actionArea.classList.add('hidden');
                 uploadArea.classList.remove('hidden');
            }
            
            document.getElementById('alert-revisi').classList.remove('hidden');
        }

        function prosesRevisi(input, docType) {
            if (input.files && input.files.length > 0) {
                document.getElementById('upload-area-' + docType).classList.add('hidden');
                
                const actionArea = document.getElementById('action-area-' + docType);
                actionArea.classList.remove('hidden');
                actionArea.classList.add('flex');
                
                document.getElementById('nama-file-' + docType).innerText = input.files[0].name;
            }
        }

        function kirimRevisi(docType) {
            alert('Simulasi: Berkas perbaikan berhasil diunggah! Status akan kembali menjadi Menunggu (Pending).');
            
            // UI Mockup Update setelah diklik "Kirim Ulang"
            const actionArea = document.getElementById('action-area-' + docType);
            actionArea.classList.remove('flex');
            actionArea.classList.add('hidden');
            
            const cardIjazah = document.getElementById('card-ijazah');
            cardIjazah.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">2. Scan Ijazah</p>
                            <p class="text-xs text-gray-400 mt-0.5">Menunggu verifikasi ulang</p>
                        </div>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                </div>
            `;
            cardIjazah.classList.replace('border-2', 'border');
            cardIjazah.classList.replace('border-red-200', 'border-gray-100');
            cardIjazah.classList.add('opacity-80');
            
            // Sembunyikan alert atas
            document.getElementById('alert-revisi').classList.add('hidden');
        }

        function downloadModul(btnElement, empName) {
            // 1. Cek apakah sudah pernah didownload dari localStorage
            const storageKey = 'modul_downloaded_' + empName.replace(/\s+/g, '-').toLowerCase();
            
            if (localStorage.getItem(storageKey) === 'true') {
                alert('Maaf, Anda sudah pernah mengunduh modul ini sebelumnya.');
                return;
            }

            // 2. Munculkan konfirmasi peringatan
            const konfirmasi = confirm(`PERINGATAN!\n\nSesuai SOP, Modul Materi untuk [${empName}] HANYA DAPAT DIUNDUH 1 KALI.\n\nApakah Anda yakin ingin mengunduhnya sekarang?`);
            
            if(konfirmasi) {
                // 3. Tandai sudah didownload di localStorage
                localStorage.setItem(storageKey, 'true');
                
                // 4. Simulasi download file
                // window.location.href = 'URL_FILE_MODUL_KAMU'; 
                
                // 5. Ubah tampilan tombol jadi terkunci
                btnElement.classList.replace('bg-amber-50', 'bg-gray-100');
                btnElement.classList.replace('text-amber-700', 'text-gray-400');
                btnElement.classList.replace('border-amber-200', 'border-gray-200');
                btnElement.classList.add('cursor-not-allowed', 'opacity-80');
                btnElement.classList.remove('hover:bg-amber-100', 'active:scale-95', 'group');
                
                btnElement.innerHTML = `
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Telah Diunduh
                `;
                btnElement.disabled = true;
            }
        }

        // Saat halaman dimuat, cek apakah tombol sudah harus dalam posisi terkunci
        window.onload = function() {
            const btn = document.getElementById('btn-modul-leo');
            const empName = 'Leo Pratama'; // Sesuaikan dengan nama karyawan
            const storageKey = 'modul_downloaded_' + empName.replace(/\s+/g, '-').toLowerCase();
            
            if (localStorage.getItem(storageKey) === 'true') {
                btn.classList.replace('bg-amber-50', 'bg-gray-100');
                btn.classList.replace('text-amber-700', 'text-gray-400');
                btn.disabled = true;
                btn.innerHTML = `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Telah Diunduh`;
            }
        };
    </script>
</body>
</html>
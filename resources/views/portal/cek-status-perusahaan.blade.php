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

        <div id="login-section" class="w-full max-w-md mx-auto fade-in {{ $kolektif ? 'hidden' : '' }}">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-3xl mb-5 shadow-inner transform rotate-3">
                    <svg class="w-10 h-10 transform -rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                <p class="text-sm text-gray-500 leading-relaxed">Pilih metode masuk untuk mengakses data karyawan Anda.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                
                <div class="flex bg-gray-100 p-1.5 rounded-2xl mb-6 relative">
                    <button type="button" onclick="switchLogin('id')" id="tab-login-id" class="flex-1 bg-white text-emerald-600 shadow-sm font-bold text-xs py-2.5 rounded-xl transition-all relative z-10">Via ID Registrasi</button>
                    <button type="button" onclick="switchLogin('data')" id="tab-login-data" class="flex-1 text-gray-500 font-bold text-xs py-2.5 rounded-xl hover:text-gray-700 transition-all relative z-10">Via Data Perusahaan</button>
                </div>

                <form action="{{ route('portal.cek-status-perusahaan') }}" method="GET" class="space-y-6">
                    
                    <div id="form-login-id" class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">ID Registrasi Kolektif</label>
                            <div class="input-focus-ring transition-shadow rounded-xl relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                </span>
                                <input type="text" name="id_kolektif" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-emerald-500 outline-none transition-colors text-gray-800 font-mono font-bold tracking-widest uppercase" placeholder="CORP-XXXX-XXX" value="{{ request('id_kolektif') }}" required>
                            </div>
                        </div>
                    </div>

                    <div id="form-login-data" class="space-y-6 hidden">
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
                    </div>

                    <button id="btn-login" type="submit" class="w-full bg-emerald-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center mt-4">
                        <span>Akses Dashboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div id="dashboard-section" class="w-full {{ $kolektif ? '' : 'hidden' }}">

            @if($kolektif)
                <div class="flex justify-between items-center mb-4 bg-emerald-600 p-5 rounded-3xl text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M15 7h.01M15 11h.01M15 15h.01M11 15h.01M7 15h.01"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ $kolektif->perusahaan }}</h2>
                            <p class="text-xs text-emerald-100 font-medium">ID: {{ $kolektif->id_pendaftaran }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-8">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $kolektif->pesertas->count() }}</h3>
                        <p class="text-[10px] uppercase font-bold text-gray-500">Total Karyawan</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
                        <h3 class="text-2xl font-bold text-green-600">{{ $kolektif->pesertas->whereIn('status', ['approve', 'diterima'])->count() }}</h3>
                        <p class="text-[10px] uppercase font-bold text-gray-500">Terverifikasi</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-2xl border border-red-100 text-center">
                        <h3 class="text-2xl font-bold text-red-600">{{ $kolektif->pesertas->where('status', 'revisi')->count() }}</h3>
                        <p class="text-[10px] uppercase font-bold text-red-500">Butuh Revisi</p>
                    </div>
                </div>

                <!-- Participant List -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Karyawan</h3>
                    </div>
                    <div class="space-y-3">
                        @forelse($kolektif->pesertas as $peserta)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center emp-item" data-status="{{ $peserta->status }}" data-program="{{ $peserta->training->nama_training ?? '' }}">
                            <div>
                                <h4 class="font-bold text-gray-800 emp-name">{{ $peserta->nama_lengkap }}</h4>
                                <p class="text-xs text-gray-500">{{ $peserta->training->nama_training ?? 'Belum ditentukan' }}</p>
                            </div>
                            <div>
                                @if(in_array($peserta->status, ['approve', 'diterima']))
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Terverifikasi</span>
                                @elseif($peserta->status == 'revisi')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Revisi</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 text-sm">Belum ada data karyawan.</div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </main>



    <script>
        // Logika Tab Login
        function switchLogin(method) {
            const tabId = document.getElementById('tab-login-id');
            const tabData = document.getElementById('tab-login-data');
            const formId = document.getElementById('form-login-id');
            const formData = document.getElementById('form-login-data');

            if(method === 'id') {
                tabId.classList.add('bg-white', 'text-emerald-600', 'shadow-sm');
                tabId.classList.remove('text-gray-500');
                tabData.classList.remove('bg-white', 'text-emerald-600', 'shadow-sm');
                tabData.classList.add('text-gray-500');
                
                formId.classList.remove('hidden');
                formData.classList.add('hidden');
            } else {
                tabData.classList.add('bg-white', 'text-emerald-600', 'shadow-sm');
                tabData.classList.remove('text-gray-500');
                tabId.classList.remove('bg-white', 'text-emerald-600', 'shadow-sm');
                tabId.classList.add('text-gray-500');
                
                formData.classList.remove('hidden');
                formId.classList.add('hidden');
            }
        }

        // Logika Otentikasi
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

        function downloadModul(btnElement, empName) {
            // 1. Munculkan konfirmasi peringatan
            const konfirmasi = confirm(`PERINGATAN!\n\nSesuai dengan SOP dan Hak Cipta, Modul Materi untuk Peserta HANYA DAPAT DIUNDUH 1 KALI.\n\nApakah Anda sudah siap mengunduhnya sekarang?`);
            
            if(konfirmasi) {
                // 2. Simulasi Proses Download (Nantinya ganti dengan trigger file PDF)
                // window.open('link-file-pdf.pdf', '_blank'); 
                
                // 3. Matikan Tombol (Simulasi Disable)
                btnElement.classList.replace('bg-amber-50', 'bg-gray-100');
                btnElement.classList.replace('text-amber-700', 'text-gray-400');
                btnElement.classList.replace('border-amber-200', 'border-gray-200');
                
                // Buang class interaksi hover & active
                btnElement.classList.remove('hover:bg-amber-100', 'active:scale-95');
                btnElement.classList.add('cursor-not-allowed', 'opacity-80');
                
                // Ubah text dan Icon jadi "Check"
                btnElement.innerHTML = `
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Telah Diunduh
                `;
                
                // Hilangkan atribut onclick agar tidak jalan jika dipaksa klik lagi
                btnElement.removeAttribute('onclick');
            }
        }
    </script>
</body>
</html>

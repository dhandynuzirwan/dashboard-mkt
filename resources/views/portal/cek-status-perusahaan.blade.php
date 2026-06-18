<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Kolektif - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @php
                        $marketingName = 'Menunggu Admin';
                        $marketingWa = '#';
                        if ($kolektif->cta && $kolektif->cta->prospek && $kolektif->cta->prospek->marketing) {
                            $marketingName = $kolektif->cta->prospek->marketing->name;
                            if ($kolektif->cta->prospek->marketing->no_hp) {
                                $marketingWa = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $kolektif->cta->prospek->marketing->no_hp);
                            }
                        }
                        
                    @endphp
                    <div class="bg-blue-50/50 p-3.5 rounded-xl border border-blue-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white border border-blue-100 text-blue-500 rounded-full flex items-center justify-center mr-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Marketing PIC</p>
                                <p class="text-sm font-bold text-gray-800">{{ $marketingName }}</p>
                            </div>
                        </div>
                        @if($marketingWa != '#')
                        <a href="{{ $marketingWa }}" target="_blank" class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition shadow-sm">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        @endif
                    </div>

                    </div>
                </div>


                <!-- Participant List -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Karyawan</h3>
                    </div>

                    {{-- 🔥 TAMPILKAN ALERT JIKA ADA REVISI 🔥 --}}
                    @if($kolektif->pesertas->where('status', 'revisi')->count() > 0)
                    <div class="bg-red-50 border border-red-200 p-5 rounded-2xl mb-6">
                        <div class="flex items-start mb-4">
                            <div class="bg-red-100 p-2 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-800">Perhatian: Ada Berkas Karyawan yang Perlu Direvisi</h3>
                                <p class="text-xs text-red-600 mt-1 leading-relaxed">Silakan periksa catatan revisi di daftar karyawan di bawah ini. Gabungkan semua berkas perbaikan ke dalam 1 file <b>ZIP/RAR</b> dan unggah ulang di sini.</p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-3">
                            <button type="button" onclick="document.getElementById('modal-revisi-kolektif').classList.remove('hidden')" class="w-full md:w-auto px-5 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition whitespace-nowrap shadow-sm flex items-center justify-center">
                                <i class="fas fa-upload mr-2"></i> Unggah Revisi
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-3">
                        @forelse($kolektif->pesertas as $peserta)
                        @php
                            $pb = $peserta->pelatihanBerjalan;
                        @endphp
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col mb-3 emp-item" data-status="{{ $peserta->status }}" data-program="{{ $peserta->training->nama_training ?? '' }}">
                            <div class="flex justify-between items-start mb-2">
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
                            
                            @if(in_array($peserta->status, ['approve', 'diterima', 'revisi']))
                                <div class="mt-2 pt-3 border-t border-gray-50">
                                    
                                    @if($peserta->status == 'revisi')
                                        <div class="mb-3 bg-red-50 p-3 rounded-xl border border-red-100">
                                            <p class="text-xs font-bold text-red-800 mb-2">Catatan Revisi Dokumen:</p>
                                            <ul class="text-[11px] text-red-600 space-y-1 list-disc list-inside">
                                                @php
                                                    $dokMap = [
                                                        'ktp' => 'KTP', 'ijazah' => 'Ijazah', 'foto' => 'Foto', 
                                                        'cv' => 'CV', 'sk' => 'Surat Keterangan', 'laporan' => 'Laporan', 'sop' => 'SOP'
                                                    ];
                                                @endphp
                                                @foreach($dokMap as $field => $label)
                                                    @if($peserta->{'status_'.$field} == 'reject')
                                                        <li><b>{{ $label }}:</b> {{ $peserta->{'catatan_'.$field} ?? 'Perbaiki dokumen ini' }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if($pb)
                                        <p class="text-[11px] font-bold text-gray-500 mb-2"><i class="fas fa-calendar-alt text-indigo-400 mr-1"></i> Jadwal: <span class="text-gray-700">{{ $pb->tanggal_pelatihan ? \Carbon\Carbon::parse($pb->tanggal_pelatihan)->format('d M Y') : 'Menunggu Penjadwalan' }}</span></p>
                                        <div class="flex flex-wrap gap-2">
                                            @if($pb->link_zoom_pelatihan)
                                            <a href="{{ $pb->link_zoom_pelatihan }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                                <i class="fas fa-video mr-1"></i> Zoom
                                            </a>
                                            @endif
                                            @if($pb->link_zoom_asesmen)
                                            <a href="{{ $pb->link_zoom_asesmen }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                                <i class="fas fa-video mr-1"></i> Asesmen
                                            </a>
                                            @endif
                                            @if($pb->modul)
                                                @if($peserta->is_modul_downloaded)
                                                <span class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-not-allowed shadow-none opacity-80">
                                                    <i class="fas fa-check-circle mr-1"></i> Telah Diunduh
                                                </span>
                                                @else
                                                <a href="{{ route('portal.download-modul', $peserta->id) }}" onclick="return confirm('PERINGATAN!\n\nSesuai dengan SOP dan Hak Cipta, Modul Materi untuk Peserta HANYA DAPAT DIUNDUH 1 KALI.\n\nApakah Anda yakin ingin mengunduhnya sekarang?');" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                                                    <i class="fas fa-book mr-1"></i> Modul Materi
                                                </a>
                                                @endif
                                            @endif
                                            @if($pb->rundown_pelatihan)
                                            <a href="{{ asset($pb->rundown_pelatihan) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                                <i class="fas fa-list mr-1"></i> Rundown
                                            </a>
                                            @endif
                                            @if($pb->background_zoom)
                                            <a href="{{ asset($pb->background_zoom) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                                <i class="fas fa-image mr-1"></i> BG Zoom
                                            </a>
                                            @endif
                                        </div>
                                        @if(!$pb->link_zoom_pelatihan && !$pb->link_zoom_asesmen && !$pb->modul)
                                        <p class="text-[10px] italic text-gray-400 mt-1">Tautan kelas/dokumen belum tersedia.</p>
                                        @endif
                                    @else
                                        <p class="text-[11px] font-bold text-gray-400"><i class="fas fa-clock mr-1"></i> Belum masuk ke kelas pelatihan (Menunggu Operasional)</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 text-sm">Belum ada data karyawan.</div>
                        @endforelse
                    </div>
                </div>

                {{-- MODAL UPLOAD REVISI KOLEKTIF --}}
                @if($kolektif->pesertas->where('status', 'revisi')->count() > 0)
                <div id="modal-revisi-kolektif" class="fixed inset-0 z-[100] hidden">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modal-revisi-kolektif').classList.add('hidden')"></div>
                    
                    <!-- Modal Dialog -->
                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                <!-- Modal Header -->
                                <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-red-800 flex items-center">
                                        <i class="fas fa-file-archive mr-2"></i> Unggah Berkas Revisi (ZIP/RAR)
                                    </h3>
                                    <button type="button" class="text-red-400 hover:text-red-600 transition" onclick="document.getElementById('modal-revisi-kolektif').classList.add('hidden')">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <form action="{{ route('portal.kolektif.revisi', $kolektif->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="px-6 py-6">
                                        <p class="text-sm text-gray-600 mb-4">
                                            Harap pastikan semua berkas yang diminta revisi oleh tim kami sudah dikumpulkan ke dalam 1 file <b>ZIP</b> atau <b>RAR</b>.
                                        </p>
                                        
                                        <div class="border-2 border-dashed border-red-200 rounded-xl p-6 text-center hover:bg-red-50 transition cursor-pointer" onclick="document.getElementById('file_zip_input').click()">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-red-300 mb-3"></i>
                                            <p class="text-sm font-medium text-gray-700 mb-1">Klik di sini untuk memilih file</p>
                                            <p class="text-xs text-gray-500">Maks. ukuran 10 MB (.zip, .rar)</p>
                                            
                                            <input type="file" id="file_zip_input" name="file_zip" accept=".zip,.rar" class="hidden" required onchange="document.getElementById('file-name-display').innerText = this.files[0] ? this.files[0].name : ''">
                                        </div>
                                        
                                        <div class="mt-3 text-center">
                                            <span id="file-name-display" class="text-sm font-bold text-red-600"></span>
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                                        <button type="button" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition" onclick="document.getElementById('modal-revisi-kolektif').classList.add('hidden')">Batal</button>
                                        <button type="submit" class="px-5 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition shadow-sm">
                                            <i class="fas fa-paper-plane mr-1"></i> Kirim Revisi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </main>



    <!-- SWEETALERT 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session("error") }}'
        });
        @endif
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}'
        });
        @endif

        // Simple Tab Logic
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

    </script>
</body>
</html>

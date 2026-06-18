<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Status Pribadi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                    {{-- 🔥 JIKA DISETUJUI ATAU REVISI, BUKA KUNCI TOMBOL 🔥 --}}
                    @if(in_array($pendaftaran->status, ['diterima', 'revisi']))
                        @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->link_zoom_pelatihan)
                        <a href="{{ $pendaftaran->pelatihanBerjalan->link_zoom_pelatihan }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                            <i class="fas fa-video mr-2"></i> Zoom Pelatihan
                        </a>
                        @endif
                        @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->link_zoom_asesmen)
                        <a href="{{ $pendaftaran->pelatihanBerjalan->link_zoom_asesmen }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-600 border border-purple-100 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                            <i class="fas fa-video mr-2"></i> Zoom Asesmen
                        </a>
                        @endif
                        @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->modul)
                            @if($pendaftaran->is_modul_downloaded)
                            <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl text-[11px] font-bold uppercase tracking-wider cursor-not-allowed shadow-none opacity-80">
                                <i class="fas fa-check-circle mr-2"></i> Telah Diunduh
                            </span>
                            @else
                            <a href="{{ route('portal.download-modul', $pendaftaran->id) }}" onclick="return confirm('PERINGATAN!\n\nSesuai dengan SOP dan Hak Cipta, Modul Materi untuk Peserta HANYA DAPAT DIUNDUH 1 KALI.\n\nApakah Anda yakin ingin mengunduhnya sekarang?');" class="inline-flex items-center px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                                <i class="fas fa-book mr-2"></i> Unduh Modul
                            </a>
                            @endif
                        @endif
                        @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->rundown_pelatihan)
                        <a href="{{ asset($pendaftaran->pelatihanBerjalan->rundown_pelatihan) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                            <i class="fas fa-list mr-2"></i> Rundown Acara
                        </a>
                        @endif
                        @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->background_zoom)
                        <a href="{{ asset($pendaftaran->pelatihanBerjalan->background_zoom) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-teal-50 hover:bg-teal-100 text-teal-700 border border-teal-200 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-colors active:scale-95 shadow-sm">
                            <i class="fas fa-image mr-2"></i> Background Zoom
                        </a>
                        @endif
                        @if(!$pendaftaran->pelatihanBerjalan || (!$pendaftaran->pelatihanBerjalan->link_zoom_pelatihan && !$pendaftaran->pelatihanBerjalan->link_zoom_asesmen && !$pendaftaran->pelatihanBerjalan->modul))
                        <p class="text-xs font-bold text-gray-500 mt-2">Menunggu Tautan dari Tim Operasional.</p>
                        @endif
                    @else
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl text-[11px] font-bold uppercase tracking-wider cursor-not-allowed shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Zoom Pelatihan (Terkunci)
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl text-[11px] font-bold uppercase tracking-wider cursor-not-allowed shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Modul Materi (Terkunci)
                        </button>
                    @endif
                </div>

                <hr class="border-gray-100 my-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $marketingName = 'Menunggu Admin';
                        $marketingWa = '#';
                        if ($pendaftaran->cta && $pendaftaran->cta->prospek && $pendaftaran->cta->prospek->marketing) {
                            $marketingName = $pendaftaran->cta->prospek->marketing->name;
                            if ($pendaftaran->cta->prospek->marketing->no_hp) {
                                $marketingWa = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $pendaftaran->cta->prospek->marketing->no_hp);
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

                    <div class="bg-indigo-50/50 p-3.5 rounded-xl border border-indigo-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white border border-indigo-100 text-indigo-500 rounded-full flex items-center justify-center mr-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Tanggal Pelatihan</p>
                                <p class="text-sm font-bold text-gray-800">
                                    @if($pendaftaran->pelatihanBerjalan && $pendaftaran->pelatihanBerjalan->tanggal_pelatihan)
                                        {{ \Carbon\Carbon::parse($pendaftaran->pelatihanBerjalan->tanggal_pelatihan)->format('d M Y') }}
                                    @else
                                        Menunggu Penjadwalan
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔥 TAMPILKAN ALERT JIKA ADA REVISI 🔥 --}}
            @if($pendaftaran->status == 'revisi')
            <div class="bg-red-50 border border-red-200 p-5 rounded-2xl mb-6 flex items-start" id="alert-revisi">
                <div class="bg-red-100 p-2 rounded-full mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">Perhatian: Ada Berkas yang Perlu Direvisi</h3>
                    <p class="text-xs text-red-600 mt-1 leading-relaxed">Silakan periksa catatan dari Admin pada daftar berkas di bawah ini dan unggah ulang berkas yang sesuai.</p>
                </div>
            </div>
            @endif

            <h3 class="text-lg font-bold text-gray-800 mb-4 ml-1">Status Dokumen Persyaratan</h3>

            <form action="{{ route('portal.pendaftaran.revisi', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4 pb-8">
                    
                    @php
                        $dokMap = [
                            'ktp'     => '1. Scan KTP Asli',
                            'ijazah'  => '2. Scan Ijazah Terakhir',
                            'foto'    => '3. Pas Foto Formal',
                            'cv'      => '4. Curriculum Vitae (CV)',
                            'sk'      => '5. Surat Keterangan Kerja',
                            'laporan' => '6. Laporan Kerja',
                            'sop'     => '7. Uraian Jobdesk / SOP'
                        ];
                    @endphp

                    @foreach($dokMap as $field => $namaDoc)
                        @php
                            $statusDoc  = $pendaftaran->{'status_' . $field};
                            $catatanDoc = $pendaftaran->{'catatan_' . $field};
                            $fileExist  = $pendaftaran->{'file_' . $field};
                        @endphp

                        @if(!$fileExist && in_array($field, ['sk', 'laporan', 'sop']))
                            {{-- TAMPILAN ABU-ABU (OPSIONAL & TIDAK DIUNGGAH) --}}
                            <div class="bg-white p-5 rounded-2xl border-2 border-gray-200 shadow-sm relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-400"></div>
                                <div class="flex items-center justify-between mb-4 pl-1">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $namaDoc }}</p>
                                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-bold mt-1 inline-block border border-gray-200">Opsional (Kosong)</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-100 mb-4 ml-1">
                                    <p class="text-xs font-bold text-blue-800 mb-1">Unggah Susulan:</p>
                                    <p class="text-xs text-blue-600">Anda masih dapat melengkapi dokumen opsional ini jika diinginkan.</p>
                                </div>

                                <div id="upload-area-{{ $field }}" class="ml-1">
                                    <label class="flex items-center justify-center w-full p-3 border border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <span class="text-sm text-gray-500 font-medium">Pilih file untuk diunggah...</span>
                                        <input type="file" name="file_{{ $field }}" accept=".pdf,.jpg,.jpeg,.png" onchange="prosesRevisi(this, '{{ $field }}')" />
                                    </label>
                                </div>

                                <div id="action-area-{{ $field }}" class="hidden items-center justify-between bg-blue-50 p-3 rounded-xl border border-blue-100 ml-1 mt-2">
                                    <p class="text-xs text-blue-700 font-medium truncate mr-3 flex-1" id="nama-file-{{ $field }}">namafile.jpg</p>
                                </div>
                            </div>

                        @elseif($statusDoc == 'approve')
                            {{-- TAMPILAN HIJAU (DISETUJUI) --}}
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $namaDoc }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Selesai diverifikasi</p>
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Diterima</span>
                            </div>

                        @elseif($statusDoc == 'reject')
                            {{-- TAMPILAN MERAH (REVISI) DENGAN INPUT FILE --}}
                            <div class="bg-white p-5 rounded-2xl border-2 border-red-200 shadow-sm relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                                <div class="flex items-center justify-between mb-4 pl-1">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $namaDoc }}</p>
                                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] font-bold mt-1 inline-block">Wajib Revisi</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-red-50 p-3 rounded-xl border border-red-100 mb-4 ml-1">
                                    <p class="text-xs font-bold text-red-800 mb-1">Catatan Admin:</p>
                                    <p class="text-xs text-red-600 italic">"{{ $catatanDoc ?? 'Silakan unggah ulang dokumen yang sesuai.' }}"</p>
                                </div>

                                <div id="upload-area-{{ $field }}" class="ml-1">
                                    <label class="flex items-center justify-center w-full p-3 border border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <span class="text-sm text-gray-500 font-medium">Pilih file perbaikan...</span>
                                        <input type="file" name="file_{{ $field }}" accept=".pdf,.jpg,.jpeg,.png" onchange="prosesRevisi(this, '{{ $field }}')" />
                                    </label>
                                </div>

                                <div id="action-area-{{ $field }}" class="hidden items-center justify-between bg-blue-50 p-3 rounded-xl border border-blue-100 ml-1 mt-2">
                                    <p class="text-xs text-blue-700 font-medium truncate mr-3 flex-1" id="nama-file-{{ $field }}">namafile.jpg</p>
                                </div>
                            </div>

                        @else
                            {{-- TAMPILAN KUNING (PENDING) --}}
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between opacity-90">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $namaDoc }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Menunggu verifikasi</p>
                                    </div>
                                </div>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                            </div>
                        @endif
                    @endforeach

                    {{-- Tombol Kirim Revisi / Susulan --}}
                    <button type="submit" id="btn-submit-revisi" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all mt-6 {{ $pendaftaran->status != 'revisi' ? 'hidden' : '' }}">
                        {{ $pendaftaran->status == 'revisi' ? 'Kirim Ulang Dokumen Revisi' : 'Kirim Dokumen Susulan' }}
                    </button>
                </div>
            </form>
        </div>
        @endif
    </main>

    <script>
        // Script untuk menangani tampilan nama file yang dipilih saat revisi
        function prosesRevisi(input, docType) {
            if (input.files && input.files.length > 0) {
                // Tampilkan action area dan nama file
                const actionArea = document.getElementById('action-area-' + docType);
                actionArea.classList.remove('hidden');
                actionArea.classList.add('flex');
                
                document.getElementById('nama-file-' + docType).innerText = input.files[0].name;

                // Tampilkan tombol submit jika sebelumnya disembunyikan
                const submitBtn = document.getElementById('btn-submit-revisi');
                if (submitBtn) {
                    submitBtn.classList.remove('hidden');
                }
            }
        }
    </script>
</body>
</html>
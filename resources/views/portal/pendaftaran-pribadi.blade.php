<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pribadi - Arsa Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- 🔥 TAMBAHKAN JQUERY & SELECT2 UNTUK DROPDOWN SEARCH 🔥 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .input-focus-ring:focus-within { box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        input[type="file"] { display: none; }
        
        /* Custom Select2 Tailwind Styling */
        .select2-container--default .select2-selection--single {
            height: 48px;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 10px;
        }
        .select2-container--default.select2-container--focus .select2-selection--single {
            background-color: white;
            border-color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="...">...</nav>

    <main class="px-5 py-8 max-w-3xl mx-auto">
        
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6">
                <strong class="font-bold">Ada kesalahan pengisian form!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 🔥 UBAH FORM ACTION & TAMBAH ENCTYPE 🔥 --}}
        <form action="{{ route('portal.pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="formPendaftaran" class="space-y-8">
            @csrf

            <input type="hidden" name="cta_id" value="{{ $cta_id }}">
            
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                    Data Diri & Pekerjaan
                </h2>
                
                <div class="space-y-5">
                    <div class="input-focus-ring transition-shadow rounded-xl">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                        {{-- Tambah attribut name --}}
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: Dhandy Nuzirwan">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors text-gray-700">
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 font-medium">+62</span>
                                <input type="tel" name="no_wa" value="{{ old('no_wa') }}" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="8123456789" >
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="form-label font-bold text-gray-700">Judul Pelatihan / Sertifikasi</label>
                            <select name="master_training_id" class="form-select" required>
                                @if($selected_training)
                                    <option value="{{ $selected_training->id }}" selected>{{ $selected_training->nama_training }}</option>
                                @else
                                    <option value="">-- Pilih Program Pelatihan --</option>
                                    @foreach($trainings as $t)
                                        <option value="{{ $t->id }}" {{ old('master_training_id') == $t->id ? 'selected' : '' }}>{{ $t->nama_training }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Perusahaan (Opsional)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">...</span>
                                <input type="text" name="perusahaan" value="{{ old('perusahaan') }}" class="w-full pl-9 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Tempat bekerja saat ini">
                            </div>
                        </div>

                        <div class="input-focus-ring transition-shadow rounded-xl">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Alamat Perusahaan (Opsional)</label>
                            <input type="text" name="alamat_perusahaan" value="{{ old('alamat_perusahaan') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Kota/Kabupaten">
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="space-y-4 bg-blue-50/50 p-4 rounded-2xl border border-blue-50">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Opsi Pembayaran <span class="text-red-500">*</span></label>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="tanpa_ppn" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('opsi_ppn', 'tanpa_ppn') == 'tanpa_ppn' ? 'checked' : '' }} onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Tanpa PPN</span>
                            </label>
                            
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-colors flex-1">
                                <input type="radio" name="opsi_ppn" value="dengan_ppn" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('opsi_ppn') == 'dengan_ppn' ? 'checked' : '' }} onchange="toggleNpwp()">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Dengan PPN (11%)</span>
                            </label>
                        </div>

                        <div id="npwp-container" class="hidden input-focus-ring transition-all duration-300 ease-in-out rounded-xl mt-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nomor NPWP (16 Digit) <span class="text-red-500">*</span></label>
                            <input type="text" id="input_npwp" name="npwp" value="{{ old('npwp') }}" maxlength="16" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Masukkan 16 digit angka NPWP">
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
                    {{-- Ulangi format ini untuk setiap file input. Jangan lupa tambahkan name="" dan atribut required --}}
                    
                    {{-- 1. KTP --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">1. Scan KTP Asli <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition group">
                                <span class="text-xs text-gray-500 font-medium group-hover:text-blue-600">Pilih File...</span>
                                <input type="file" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png" required onchange="updateFileNameList(this, 'file-ktp')" />
                            </label>
                            <p id="file-ktp" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    {{-- 2. Ijazah --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">2. Scan Ijazah Asli <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" required onchange="updateFileNameList(this, 'file-ijazah')" />
                            </label>
                            <p id="file-ijazah" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    {{-- 3. Foto --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">3. Pas Foto Formal <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_foto" accept=".jpg,.jpeg,.png" required onchange="updateFileNameList(this, 'file-foto')" />
                            </label>
                            <p id="file-foto" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>
                    
                    {{-- 4. CV --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">4. Curriculum Vitae (CV) <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_cv" accept=".pdf" required onchange="updateFileNameList(this, 'file-cv')" />
                            </label>
                            <p id="file-cv" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    {{-- 5. SK Kerja --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">5. Surat Keterangan Kerja <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/JPG/PNG. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_sk" accept=".pdf,.jpg,.jpeg,.png" required onchange="updateFileNameList(this, 'file-sk')" />
                            </label>
                            <p id="file-sk" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    {{-- 6. Laporan --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">6. Laporan Kerja <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/DOC/DOCX. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_laporan" accept=".pdf,.docx,.doc" required onchange="updateFileNameList(this, 'file-laporan')" />
                            </label>
                            <p id="file-laporan" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                    {{-- 7. SOP --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-sm font-bold text-gray-800">7. Uraian Jobdesk / SOP <span class="text-red-500">*</span></h3>
                            <p class="text-[11px] text-gray-500">Format PDF/DOC/DOCX. Max 2MB.</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label class="flex items-center justify-center w-full px-4 py-2 bg-white border border-dashed border-gray-300 rounded-xl cursor-pointer">
                                <span class="text-xs text-gray-500 font-medium">Pilih File...</span>
                                <input type="file" name="file_sop" accept=".pdf,.docx,.doc" required onchange="updateFileNameList(this, 'file-sop')" />
                            </label>
                            <p id="file-sop" class="text-[10px] text-green-600 font-bold mt-1.5 hidden truncate pl-1"></p>
                        </div>
                    </div>

                </div>
            </div>

            <button id="btn-submit" type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 active:scale-95 transition-all flex items-center justify-center">
                <span>Kirim Pendaftaran</span>
            </button>
        </form>
    </main>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown Pelatihan
            $('.select2').select2({
                placeholder: "Ketik untuk mencari pelatihan...",
                allowClear: true
            });
            
            // Panggil sekali saat halaman dimuat (untuk old() data)
            toggleNpwp();
        });

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
            }
        }

        document.getElementById('input_npwp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        function updateFileNameList(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = `✓ ${input.files[0].name}`;
                textElement.classList.remove('hidden');
                input.parentElement.classList.replace('border-gray-300', 'border-green-400');
                input.parentElement.classList.replace('bg-white', 'bg-green-50');
                input.previousElementSibling.innerText = "Ganti File";
            } else {
                textElement.classList.add('hidden');
                input.parentElement.classList.replace('border-green-400', 'border-gray-300');
                input.parentElement.classList.replace('bg-green-50', 'bg-white');
                input.previousElementSibling.innerText = "Pilih File...";
            }
        }

        // Efek loading saat form dikirim murni
        document.getElementById('formPendaftaran').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = `Mengunggah Berkas... Mohon Tunggu`;
            btn.classList.replace('bg-blue-600', 'bg-blue-400');
        });
    </script>
</body>
</html>
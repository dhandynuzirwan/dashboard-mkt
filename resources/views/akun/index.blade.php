<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brankas Akun | Portal Back Office</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8fafc; 
            color: #334155;
        }
        
        /* Navbar Clean White */
        .navbar-header {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            padding: 12px 0;
        }
        .navbar-brand {
            color: #0f172a !important;
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: -0.5px;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, #1e293b 0%, #f59e0b 100%);
            color: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin-top: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.15);
            position: relative;
            overflow: hidden;
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        /* Filter Tab */
        .filter-search-box {
            background: #ffffff;
            border-radius: 50px;
            padding: 6px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }
        .filter-tabs-wrapper {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn-filter-tab {
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #64748b;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.01);
            margin: 0;
        }
        .btn-filter-tab:hover { background-color: #f8fafc; transform: translateY(-2px); }
        
        #cat-all:checked + label { background-color: #1e293b; color: white !important; border-color: #1e293b; box-shadow: 0 4px 10px rgba(30,41,59,0.2); }
        #cat-website:checked + label { background-color: #eff6ff; color: #3b82f6 !important; border-color: #3b82f6; box-shadow: 0 4px 10px rgba(59,130,246,0.2); }
        #cat-sosmed:checked + label { background-color: #fef2f2; color: #ef4444 !important; border-color: #ef4444; box-shadow: 0 4px 10px rgba(239,68,68,0.2); }
        #cat-tools:checked + label { background-color: #ecfdf5; color: #10b981 !important; border-color: #10b981; box-shadow: 0 4px 10px rgba(16,185,129,0.2); }
        #cat-cloud:checked + label { background-color: #f0f9ff; color: #0ea5e9 !important; border-color: #0ea5e9; box-shadow: 0 4px 10px rgba(14,165,233,0.2); }
        #cat-other:checked + label { background-color: #f1f5f9; color: #64748b !important; border-color: #94a3b8; box-shadow: 0 4px 10px rgba(100,116,139,0.2); }

        /* Card Vault Style */
        .resource-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 24px;
            position: relative; 
        }
        .resource-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.06);
        }

        .card-actions {
            position: absolute;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 6px;
            opacity: 0.6;
            transition: all 0.2s ease;
        }
        .resource-card:hover .card-actions { opacity: 1; }
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            transition: all 0.2s;
            cursor: pointer;
        }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .action-btn.delete:hover { background: #fef2f2; color: #ef4444; border-color: #fecaca; }

        .icon-box { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
        .card-category { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .card-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0; line-height: 1.4; padding-right: 40px; }

        .input-group-vault .form-control { background-color: #f8fafc; border-color: #e2e8f0; font-family: monospace; font-size: 0.9rem; }
        .input-group-vault .btn { border-color: #e2e8f0; color: #64748b; }
        .input-group-vault .btn:hover { background-color: #e2e8f0; color: #0f172a; }

        .btn-custom { border-radius: 10px; font-weight: 600; font-size: 0.9rem; padding: 10px 0; transition: all 0.2s ease; }
        .btn-custom:hover { transform: scale(1.02); }

        @media (max-width: 767.98px) {
            .hero-banner { padding: 25px 20px; margin-top: 15px; text-align: center; }
            .hero-banner .btn-custom { width: 100%; margin-top: 15px; }
            .filter-tabs-wrapper { flex-wrap: nowrap; justify-content: flex-start; overflow-x: auto; padding-bottom: 5px; -webkit-overflow-scrolling: touch; }
            .filter-tabs-wrapper::-webkit-scrollbar { display: none; }
            .btn-filter-tab { white-space: nowrap; padding: 6px 14px; font-size: 0.8rem; }
            .resource-card { padding: 16px; }
            .card-actions { opacity: 1; }
        }
    </style>
    <nav class="navbar navbar-header navbar-expand-lg sticky-top">
        <div class="container-fluid container-xl d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center m-0" href="#">
                <div class="bg-warning text-dark rounded p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="fas fa-key fs-6"></i>
                </div>
                Brankas Akun
            </a>
            
            {{-- 🔥 Tombol Kembali ke Dashboard 🔥 --}}
            {{-- Menggunakan url('/') untuk menghindari error route not defined --}}
            <a href="{{ url('/') }}" class="btn btn-light btn-sm fw-bold border rounded-pill px-3 shadow-sm transition-all" style="color: #475569;">
                <i class="fas fa-arrow-left me-1"></i> Kembali <span class="d-none d-sm-inline">ke Dashboard</span>
            </a>
        </div>
    </nav>
</head>
<body>

    <div class="container-xl mb-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Hero Banner --}}
        <div class="hero-banner d-flex flex-column flex-md-row align-items-md-center justify-content-between position-relative">
            <div class="position-relative" style="z-index: 2;">
                <h2 class="hero-title fw-bold text-white mb-2">Vault Kredensial Perusahaan</h2>
                <p class="hero-subtitle mb-0 text-white-50">Sistem penyimpanan password aman. Hanya dapat diakses oleh pihak yang berwenang.</p>
            </div>
            <div class="position-relative w-sm-100" style="z-index: 2;">
                <button class="btn btn-light text-warning btn-custom px-4 shadow-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
                    <i class="fas fa-plus-circle me-2"></i> Daftarkan Akun
                </button>
            </div>
        </div>

        {{-- ================= FORM FILTER PENCARIAN & TAB ================= --}}
        <form action="{{ route('akun.index') }}" method="GET" class="mb-4">
            <div class="row justify-content-center mb-3">
                <div class="col-md-8 col-lg-6">
                    <div class="filter-search-box d-flex align-items-center">
                        <span class="text-muted ps-3 pe-2"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-0 shadow-none bg-transparent" 
                            placeholder="Cari nama platform atau username..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold">Cari</button>
                    </div>
                </div>
            </div>

            <div class="filter-tabs-wrapper">
                <input type="radio" class="btn-check" name="kategori" id="cat-all" value="" {{ request('kategori') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab" for="cat-all"><i class="fas fa-layer-group me-1"></i> Semua</label>

                <input type="radio" class="btn-check" name="kategori" id="cat-website" value="Website" {{ request('kategori') == 'Website' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab text-primary" for="cat-website"><i class="fas fa-globe me-1"></i> Website / Hosting</label>

                <input type="radio" class="btn-check" name="kategori" id="cat-sosmed" value="Sosial Media" {{ request('kategori') == 'Sosial Media' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab text-danger" for="cat-sosmed"><i class="fas fa-hashtag me-1"></i> Sosial Media</label>

                <input type="radio" class="btn-check" name="kategori" id="cat-tools" value="Marketing Tools" {{ request('kategori') == 'Marketing Tools' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab text-success" for="cat-tools"><i class="fas fa-bullhorn me-1"></i> Marketing Tools</label>

                <input type="radio" class="btn-check" name="kategori" id="cat-cloud" value="Email & Cloud" {{ request('kategori') == 'Email & Cloud' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab text-info" for="cat-cloud"><i class="fas fa-envelope me-1"></i> Email & Cloud</label>

                <input type="radio" class="btn-check" name="kategori" id="cat-other" value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="btn-filter-tab text-secondary" for="cat-other"><i class="fas fa-link me-1"></i> Lainnya</label>
            </div>
        </form>
        
        {{-- ================= GRID DATA AKUN ================= --}}
        <div class="row g-3 g-md-4">
            
            @forelse($akuns as $akun)
                @php
                    $iconBg = 'bg-secondary'; $textColor = 'text-secondary'; $iconClass = 'fa-key';
                    if($akun->kategori == 'Website') { $iconBg = 'bg-primary'; $textColor = 'text-primary'; $iconClass = 'fa-globe'; } 
                    elseif($akun->kategori == 'Sosial Media') { $iconBg = 'bg-danger'; $textColor = 'text-danger'; $iconClass = 'fa-hashtag'; } 
                    elseif($akun->kategori == 'Marketing Tools') { $iconBg = 'bg-success'; $textColor = 'text-success'; $iconClass = 'fa-bullhorn'; }
                    elseif($akun->kategori == 'Email & Cloud') { $iconBg = 'bg-info'; $textColor = 'text-info'; $iconClass = 'fa-envelope'; }
                @endphp

                <div class="col-sm-6 col-lg-4">
                    <div class="resource-card">
                        <div class="card-actions">
                            <form action="{{ route('akun.destroy', $akun->id) }}" method="POST" class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-btn delete btn-delete" title="Hapus Akun">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box {{ $iconBg }} bg-opacity-10 {{ $textColor }}">
                                <i class="fas {{ $iconClass }}"></i>
                            </div>
                            <div class="ms-3 pt-1">
                                <p class="card-category {{ $textColor }} opacity-75">{{ $akun->kategori }}</p>
                                <h4 class="card-title">{{ $akun->platform }}</h4>
                            </div>
                        </div>

                        <div class="input-group-vault mb-3">
                            <label class="fw-bold small text-muted mb-1" style="font-size: 0.7rem;">USERNAME / EMAIL</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ $akun->username_email }}" readonly>
                                <button class="btn btn-light" type="button" onclick="copyText('{{ $akun->username_email }}')" title="Copy Username"><i class="far fa-copy"></i></button>
                            </div>
                        </div>

                        <div class="input-group-vault mb-3">
                            <label class="fw-bold small text-muted mb-1" style="font-size: 0.7rem;">PASSWORD</label>
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control" value="{{ \Illuminate\Support\Facades\Crypt::decryptString($akun->password) }}" id="pass-{{ $akun->id }}" readonly>
                                <button class="btn btn-light" type="button" onclick="togglePass({{ $akun->id }})" title="Lihat Password"><i class="far fa-eye" id="icon-pass-{{ $akun->id }}"></i></button>
                                <button class="btn btn-light" type="button" onclick="copyPass({{ $akun->id }})" title="Copy Password"><i class="far fa-copy"></i></button>
                            </div>
                        </div>

                        @if($akun->catatan)
                            <div class="small text-muted bg-light p-2 rounded mb-3 border">
                                <i class="fas fa-info-circle me-1"></i> {{ $akun->catatan }}
                            </div>
                        @endif

                        @if($akun->url_login)
                            <a href="{{ $akun->url_login }}" target="_blank" class="btn btn-outline-dark btn-custom w-100 mt-auto" style="border-color: #e2e8f0;">
                                <i class="fas fa-external-link-alt me-2"></i> Buka Link Login
                            </a>
                        @endif
                    </div>
                </div>

            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted opacity-50 mb-3"><i class="fas fa-vault" style="font-size: 4rem;"></i></div>
                    <h5 class="fw-bold text-muted">Brankas Masih Kosong</h5>
                    <p class="text-muted">Klik tombol "Daftarkan Akun" di atas untuk mulai menyimpan password.</p>
                </div>
            @endforelse

        </div>
    </div>
    
    {{-- Modal Form Tambah Akun --}}
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('akun.store') }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header bg-light border-0 py-3 px-4" style="border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title fw-bold text-warning m-0"><i class="fas fa-key me-2"></i> Tambah Kredensial Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-warning py-2 px-3 small border-0" style="border-radius: 10px;">
                            <i class="fas fa-lock me-1"></i> Password akan di-enkripsi di database.
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">NAMA PLATFORM <span class="text-danger">*</span></label>
                            <input type="text" name="platform" class="form-control" placeholder="Contoh: Instagram Official" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">KATEGORI <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="Website">Website / Hosting</option>
                                <option value="Sosial Media">Sosial Media</option>
                                <option value="Marketing Tools">Marketing Tools</option>
                                <option value="Email & Cloud">Email & Cloud</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">URL LOGIN (Opsional)</label>
                            <input type="url" name="url_login" class="form-control" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">USERNAME / EMAIL <span class="text-danger">*</span></label>
                            <input type="text" name="username_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">PASSWORD <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" placeholder="Ketik password asli" required>
                        </div>
                        <div class="mb-0">
                            <label class="fw-bold mb-1 small text-muted">CATATAN (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="OTP ke HP Fajar, dsb..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light py-3 px-4" style="border-radius: 0 0 16px 16px;">
                        <button type="button" class="btn btn-light border btn-custom px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark btn-custom px-4 shadow-sm">Simpan ke Vault</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy Text Function dengan Toast SWAL
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, timerProgressBar: true
                });
                Toast.fire({ icon: 'success', title: 'Berhasil disalin!' });
            });
        }

        // Copy Password (ambil dari value input)
        function copyPass(id) {
            var pass = document.getElementById("pass-" + id).value;
            copyText(pass);
        }

        // Toggle Password Show/Hide
        function togglePass(id) {
            var input = document.getElementById("pass-" + id);
            var icon = document.getElementById("icon-pass-" + id);
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // Konfirmasi Hapus SweetAlert
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('.form-hapus');
                Swal.fire({
                    title: 'Hapus Akun?', text: "Data kredensial tidak bisa dikembalikan!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
</body>
</html>
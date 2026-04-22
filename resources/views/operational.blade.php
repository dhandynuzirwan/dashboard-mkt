<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Back Office</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Public Sans', sans-serif; background-color: #f8fafc; color: #334155; }
        
        .navbar-header { background-color: #ffffff; box-shadow: 0 2px 15px rgba(0,0,0,0.03); padding: 12px 0; }
        .navbar-brand { color: #0f172a !important; font-weight: 700; font-size: 1.35rem; letter-spacing: -0.5px; }

        .hero-banner {
            background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
            color: white; border-radius: 20px; padding: 40px 30px; margin-top: 30px; margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15); position: relative; overflow: hidden;
        }
        .hero-banner::after {
            content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px;
            background: rgba(255,255,255,0.05); border-radius: 50%;
        }

        /* Nav Pills Utama */
        .nav-pills .nav-link { color: #64748b; font-weight: 600; border-radius: 50px; padding: 10px 24px; margin: 0 5px; transition: all 0.3s ease; border: 1px solid transparent; }
        .nav-pills .nav-link:hover { background-color: #f1f5f9; }
        .nav-pills .nav-link.active { background-color: #3b82f6; color: white; box-shadow: 0 4px 15px rgba(59,130,246,0.3); }

        /* Filter Tab */
        .filter-search-box { background: #ffffff; border-radius: 50px; padding: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        .filter-tabs-wrapper { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; margin-bottom: 1.5rem; }
        .btn-filter-tab { border: 1px solid #e2e8f0; background-color: #ffffff; color: #64748b; border-radius: 50px; padding: 8px 20px; font-weight: 600; font-size: 0.9rem; transition: all 0.2s ease; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.01); margin: 0; }
        .btn-filter-tab:hover { background-color: #f8fafc; transform: translateY(-2px); }
        
        /* State Aktif Filter Dokumen */
        #cat-all:checked + label { background-color: #1e293b; color: white !important; border-color: #1e293b; }
        #cat-spreadsheet:checked + label { background-color: #ecfdf5; color: #10b981 !important; border-color: #10b981; }
        #cat-document:checked + label { background-color: #eff6ff; color: #3b82f6 !important; border-color: #3b82f6; }
        #cat-folder:checked + label { background-color: #fffbeb; color: #f59e0b !important; border-color: #f59e0b; }
        #cat-other:checked + label { background-color: #f1f5f9; color: #64748b !important; border-color: #94a3b8; }

        /* State Aktif Filter Kontak */
        #cat-kontak-all:checked + label { background-color: #1e293b; color: white !important; border-color: #1e293b; }
        #cat-kontak-lsp:checked + label { background-color: #ecfdf5; color: #10b981 !important; border-color: #10b981; }
        #cat-kontak-hrd:checked + label { background-color: #eff6ff; color: #3b82f6 !important; border-color: #3b82f6; }
        #cat-kontak-hotel:checked + label { background-color: #fffbeb; color: #f59e0b !important; border-color: #f59e0b; }
        #cat-kontak-vendor:checked + label { background-color: #fef2f2; color: #ef4444 !important; border-color: #ef4444; }
        #cat-kontak-pemateri:checked + label { background-color: #e0f2fe; color: #0dcaf0 !important; border-color: #0dcaf0; }

        /* Card Modern */
        .resource-card, .contact-card {
            background: #ffffff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s ease; height: 100%;
            display: flex; flex-direction: column; padding: 24px; position: relative; 
        }
        .resource-card:hover, .contact-card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0,0,0,0.06); border-color: rgba(59, 130, 246, 0.2); }

        .card-actions { position: absolute; top: 16px; right: 16px; display: flex; gap: 6px; opacity: 0; transition: all 0.2s ease; }
        .resource-card:hover .card-actions, .contact-card:hover .card-actions { opacity: 1; }
        .action-btn { width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b; transition: all 0.2s; border: none; }
        .action-btn:hover { transform: translateY(-2px); }
        .action-btn.edit:hover { background: #fffbeb; color: #f59e0b; border-color:#fde68a; }
        .action-btn.delete:hover { background: #fef2f2; color: #ef4444; border-color:#fecaca; }

        .icon-box { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
        .card-category { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .card-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0; line-height: 1.4; padding-right: 50px; }

        .contact-info { background: #f8fafc; border-radius: 10px; padding: 12px; margin-top: 15px; border: 1px solid #e2e8f0; }
        .contact-number { font-family: monospace; font-size: 1.1rem; font-weight: 600; color: #0f172a; letter-spacing: 1px; }

        .btn-custom { border-radius: 10px; font-weight: 600; font-size: 0.9rem; padding: 10px 0; transition: all 0.2s ease; margin-top: auto; }
        .btn-custom:hover { transform: scale(1.02); }

        @media (max-width: 767.98px) {
            .hero-banner { padding: 25px 20px; text-align: center; }
            .hero-banner .btn-custom { width: 100%; margin-top: 10px; }
            .nav-pills, .filter-tabs-wrapper { flex-wrap: nowrap; justify-content: flex-start; overflow-x: auto; padding-bottom: 10px; -webkit-overflow-scrolling: touch; }
            .nav-pills::-webkit-scrollbar, .filter-tabs-wrapper::-webkit-scrollbar { display: none; }
            .btn-filter-tab { white-space: nowrap; padding: 6px 14px; font-size: 0.8rem; }
            .card-actions { opacity: 1; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-header navbar-expand-lg sticky-top">
        <div class="container-fluid container-xl">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="bg-primary text-white rounded p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <i class="fas fa-layer-group fs-6"></i>
                </div>
                Portal Back Office
            </a>
            <a href="{{ url('/') }}" class="btn btn-light btn-sm fw-bold border rounded-pill px-3 shadow-sm transition-all" style="color: #475569;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

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
                <h2 class="hero-title fw-bold text-white mb-2">Resource & Dokumen Kerja</h2>
                <p class="hero-subtitle mb-0 text-white-50">Pusat akses spreadsheet, dokumen, dan direktori kontak penting operasional.</p>
            </div>
            <div class="position-relative w-sm-100 mt-3 mt-md-0 d-flex flex-column gap-2" style="z-index: 2;">
                <button class="btn btn-light text-primary btn-custom px-4 shadow-sm fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modalTambahLink">
                    <i class="fas fa-link me-2"></i> Tambah Link Baru
                </button>
                <button class="btn btn-outline-light btn-custom px-4 fw-bold w-100 border-2" data-bs-toggle="modal" data-bs-target="#modalTambahKontak">
                    <i class="fas fa-address-book me-2"></i> Tambah Kontak Baru
                </button>
            </div>
        </div>

        {{-- Tab Navigasi Utama --}}
        <ul class="nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-dokumen-tab" data-bs-toggle="pill" data-bs-target="#pills-dokumen" type="button" role="tab">
                    <i class="fas fa-folder-open me-2"></i> Dokumen & Link
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-kontak-tab" data-bs-toggle="pill" data-bs-target="#pills-kontak" type="button" role="tab">
                    <i class="fas fa-address-book me-2"></i> Kontak Penting
                </button>
            </li>
        </ul>

        {{-- Konten Tab --}}
        <div class="tab-content" id="pills-tabContent">
            
            {{-- ================= TAB 1: DOKUMEN & LINK ================= --}}
            <div class="tab-pane fade show active" id="pills-dokumen" role="tabpanel">
                
                {{-- Form Filter Pencarian Link --}}
                <form action="{{ route('operational') }}" method="GET" class="mb-4">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-8 col-lg-6">
                            <div class="filter-search-box d-flex align-items-center">
                                <span class="text-muted ps-3 pe-2"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control border-0 shadow-none bg-transparent" placeholder="Cari nama dokumen atau link..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="filter-tabs-wrapper">
                        <input type="radio" class="btn-check" name="kategori" id="cat-all" value="" {{ request('kategori') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn-filter-tab" for="cat-all"><i class="fas fa-layer-group me-1"></i> Semua</label>

                        <input type="radio" class="btn-check" name="kategori" id="cat-spreadsheet" value="spreadsheet" {{ request('kategori') == 'spreadsheet' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn-filter-tab text-success" for="cat-spreadsheet"><i class="fas fa-file-excel me-1"></i> Spreadsheet</label>

                        <input type="radio" class="btn-check" name="kategori" id="cat-document" value="document" {{ request('kategori') == 'document' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn-filter-tab text-primary" for="cat-document"><i class="fas fa-file-word me-1"></i> Document</label>

                        <input type="radio" class="btn-check" name="kategori" id="cat-folder" value="folder" {{ request('kategori') == 'folder' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn-filter-tab text-warning" for="cat-folder"><i class="fas fa-folder-open me-1"></i> Folder</label>

                        <input type="radio" class="btn-check" name="kategori" id="cat-other" value="other" {{ request('kategori') == 'other' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn-filter-tab text-secondary" for="cat-other"><i class="fas fa-link me-1"></i> Lainnya</label>
                    </div>
                </form>

                <div class="row g-3 g-md-4">
                    @forelse($resource_links as $link)
                        @php
                            $iconBg = 'bg-secondary'; $textColor = 'text-secondary'; $iconClass = 'fa-link'; $btnClass = 'btn-soft-secondary'; $kategoriTeks = 'Other Link';
                            if($link->kategori == 'spreadsheet') { $iconBg = 'bg-success'; $textColor = 'text-success'; $iconClass = 'fa-file-excel'; $btnClass = 'btn-soft-success'; $kategoriTeks = 'Spreadsheet'; } 
                            elseif($link->kategori == 'document') { $iconBg = 'bg-primary'; $textColor = 'text-primary'; $iconClass = 'fa-file-word'; $btnClass = 'btn-soft-primary'; $kategoriTeks = 'Document'; } 
                            elseif($link->kategori == 'folder') { $iconBg = 'bg-warning'; $textColor = 'text-warning'; $iconClass = 'fa-folder-open'; $btnClass = 'btn-soft-warning'; $kategoriTeks = 'Google Drive'; }
                        @endphp

                        <div class="col-sm-6 col-lg-4">
                            <div class="resource-card">
                                <div class="card-actions">
                                    <form action="{{ route('operational.destroy-link', $link->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                                <div class="d-flex align-items-start mb-3 mb-md-4">
                                    <div class="icon-box {{ $iconBg }} bg-opacity-10 {{ $textColor }}"><i class="fas {{ $iconClass }}"></i></div>
                                    <div class="ms-3 pt-1">
                                        <p class="card-category {{ $textColor }} opacity-75">{{ $kategoriTeks }}</p>
                                        <h4 class="card-title">{{ $link->nama_dokumen }}</h4>
                                    </div>
                                </div>
                                <a href="{{ $link->url_link }}" target="_blank" class="btn {{ $btnClass }} btn-custom w-100 mt-2">
                                    <i class="fas fa-external-link-alt me-2"></i> Buka {{ $link->kategori == 'folder' ? 'Folder' : 'File' }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted opacity-50 mb-3"><i class="fas fa-folder-open" style="font-size: 4rem;"></i></div>
                            <h5 class="fw-bold text-muted">Belum ada link dokumen yang ditemukan</h5>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- ================= TAB 2: KONTAK PENTING ================= --}}
            <div class="tab-pane fade" id="pills-kontak" role="tabpanel">
                
                <div class="row justify-content-center mb-3">
                    <div class="col-md-8 col-lg-6">
                        <div class="filter-search-box d-flex align-items-center">
                            <span class="text-muted ps-3 pe-2"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchKontak" class="form-control border-0 shadow-none bg-transparent" placeholder="Cari nama instansi atau PIC...">
                            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="filterKontak()">Cari</button>
                        </div>
                    </div>
                </div>

                <div class="filter-tabs-wrapper">
                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-all" value="all" checked>
                    <label class="btn-filter-tab" for="cat-kontak-all"><i class="fas fa-layer-group me-1"></i> Semua</label>

                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-pemateri" value="Pemateri / Instruktur">
                    <label class="btn-filter-tab text-info" for="cat-kontak-pemateri"><i class="fas fa-user-graduate me-1"></i> Pemateri</label>

                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-lsp" value="LSP / Asesor">
                    <label class="btn-filter-tab text-success" for="cat-kontak-lsp"><i class="fas fa-certificate me-1"></i> LSP / Asesor</label>

                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-hrd" value="HRD Klien">
                    <label class="btn-filter-tab text-primary" for="cat-kontak-hrd"><i class="fas fa-user-tie me-1"></i> HRD Klien</label>

                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-hotel" value="Hotel / Venue">
                    <label class="btn-filter-tab text-warning" for="cat-kontak-hotel"><i class="fas fa-hotel me-1"></i> Hotel</label>

                    <input type="radio" class="btn-check filter-kontak-cat" name="kategori_kontak" id="cat-kontak-vendor" value="Vendor / Suplier">
                    <label class="btn-filter-tab text-danger" for="cat-kontak-vendor"><i class="fas fa-box me-1"></i> Vendor</label>
                </div>

                <div class="row g-3 g-md-4" id="kontakList">
                    @forelse($kontaks as $kontak)
                        @php
                            $kIcon = 'fa-building'; $kBg = 'bg-secondary'; $kText = 'text-secondary';
                            if($kontak->kategori == 'LSP / Asesor') { $kIcon = 'fa-certificate'; $kBg = 'bg-success'; $kText = 'text-success'; }
                            elseif($kontak->kategori == 'HRD Klien') { $kIcon = 'fa-user-tie'; $kBg = 'bg-primary'; $kText = 'text-primary'; }
                            elseif($kontak->kategori == 'Hotel / Venue') { $kIcon = 'fa-hotel'; $kBg = 'bg-warning'; $kText = 'text-warning'; }
                            elseif($kontak->kategori == 'Vendor / Suplier') { $kIcon = 'fa-box'; $kBg = 'bg-danger'; $kText = 'text-danger'; }
                            elseif($kontak->kategori == 'Pemateri / Instruktur') { $kIcon = 'fa-user-graduate'; $kBg = 'bg-info'; $kText = 'text-info'; }
                        @endphp

                        <div class="col-sm-6 col-lg-4 kontak-item" data-kategori="{{ $kontak->kategori }}">
                            <div class="contact-card">
                                <div class="card-actions">
                                    <form action="{{ route('operational.destroy-kontak', $kontak->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kontak ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-box {{ $kBg }} bg-opacity-10 {{ $kText }} me-3">
                                        <i class="fas {{ $kIcon }}"></i>
                                    </div>
                                    <div>
                                        <p class="card-category {{ $kText }} opacity-75 m-0">{{ $kontak->kategori }}</p>
                                        <h5 class="fw-bold text-dark m-0">{{ $kontak->nama_instansi }}</h5>
                                    </div>
                                </div>

                                <div class="contact-info flex-grow-1">
                                    <small class="text-muted fw-bold d-block mb-1">Nama PIC</small>
                                    <div class="fw-bold text-dark mb-2"><i class="far fa-user-circle me-1"></i> {{ $kontak->nama_pic }}</div>
                                    <small class="text-muted fw-bold d-block mb-1">Nomor WhatsApp</small>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="contact-number">{{ $kontak->nomor_wa }}</div>
                                        <button class="btn btn-sm btn-light border rounded px-2" onclick="copyNumber('{{ $kontak->nomor_wa }}')" title="Copy Nomor">
                                            <i class="far fa-copy text-muted"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->nomor_wa) }}" target="_blank" class="btn btn-success btn-custom w-100" style="background: #25D366; border:none;">
                                        <i class="fab fa-whatsapp me-1"></i> Chat WA
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted opacity-50 mb-3"><i class="fas fa-address-book" style="font-size: 4rem;"></i></div>
                            <h5 class="fw-bold text-muted">Belum ada daftar kontak yang disimpan.</h5>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    
    {{-- MODAL TAMBAH LINK --}}
    <div class="modal fade" id="modalTambahLink" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('operational.store-link') }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header bg-light border-0 py-3 px-4">
                        <h5 class="modal-title fw-bold text-primary m-0"><i class="fas fa-link me-2"></i> Tambah Resource Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">NAMA DOKUMEN / FOLDER <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokumen" class="form-control" required placeholder="Contoh: Rekap Absensi">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">URL / LINK TAUTAN <span class="text-danger">*</span></label>
                            <input type="url" name="url_link" class="form-control" required placeholder="https://...">
                        </div>
                        <div class="mb-0">
                            <label class="fw-bold mb-1 small text-muted">KATEGORI RESOURCE <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="spreadsheet">📊 Spreadsheet (Excel/G-Sheets)</option>
                                <option value="document">📝 Dokumen (Word/G-Docs)</option>
                                <option value="folder">📁 Folder (G-Drive)</option>
                                <option value="other">🔗 Link Web Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light py-3 px-4">
                        <button type="button" class="btn btn-light border px-4 btn-custom" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 btn-custom shadow-sm">Simpan Link</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH KONTAK --}}
    <div class="modal fade" id="modalTambahKontak" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('operational.store-kontak') }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header bg-light border-0 py-3 px-4">
                        <h5 class="modal-title fw-bold text-success m-0"><i class="fas fa-address-book me-2"></i> Tambah Kontak Penting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">KATEGORI KONTAK <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select" required>
                                <option value="Pemateri / Instruktur">👨‍🏫 Pemateri / Instruktur Pelatihan</option>
                                <option value="LSP / Asesor">🏅 LSP / Lembaga Sertifikasi</option>
                                <option value="HRD Klien">💼 HRD Perusahaan Klien</option>
                                <option value="Hotel / Venue">🏨 Hotel / Venue Pelatihan</option>
                                <option value="Vendor / Suplier">📦 Vendor (Cetak, Suvenir, dll)</option>
                                <option value="Lainnya">🔗 Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">NAMA INSTANSI / HOTEL / NAMA LENGKAP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_instansi" class="form-control" required placeholder="Contoh: Pak Fulan / Hotel Grand">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-muted">NAMA PIC / JABATAN <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pic" class="form-control" required placeholder="Contoh: Pak Budi (Marketing)">
                        </div>
                        <div class="mb-0">
                            <label class="fw-bold mb-1 small text-muted">NOMOR WA <span class="text-danger">*</span></label>
                            <input type="tel" name="nomor_wa" class="form-control" required placeholder="081234567xxx">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light py-3 px-4">
                        <button type="button" class="btn btn-light border px-4 btn-custom" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 btn-custom shadow-sm">Simpan Kontak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyNumber(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Nomor disalin!', showConfirmButton: false, timer: 1500 });
            });
        }

        function filterKontak() {
            let term = document.getElementById('searchKontak').value.toLowerCase();
            let selectedCategory = document.querySelector('input[name="kategori_kontak"]:checked').value;

            document.querySelectorAll('.kontak-item').forEach(function(item) {
                let text = item.innerText.toLowerCase();
                let itemCategory = item.getAttribute('data-kategori');
                let categoryMatches = (selectedCategory === 'all') || (itemCategory === selectedCategory);
                let textMatches = text.includes(term);

                item.style.display = (textMatches && categoryMatches) ? 'block' : 'none';
            });
        }

        document.getElementById('searchKontak').addEventListener('input', filterKontak);
        document.querySelectorAll('.filter-kontak-cat').forEach(function(radio) {
            radio.addEventListener('change', filterKontak);
        });

        document.addEventListener("DOMContentLoaded", function() {
            let activeTab = localStorage.getItem('activeTabPortal');
            if (activeTab) {
                let tabTrigger = document.querySelector('#' + activeTab);
                if (tabTrigger) {
                    let tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
            document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(function(btn) {
                btn.addEventListener('shown.bs.tab', function(e) {
                    localStorage.setItem('activeTabPortal', e.target.id);
                });
            });
        });
    </script>
</body>
</html>
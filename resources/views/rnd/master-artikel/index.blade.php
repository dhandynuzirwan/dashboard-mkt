@extends('layouts.app')
@section('title', 'Master Artikel')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h4 class="page-title">Master Artikel</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('dashboard.progress') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Performance</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Master Artikel</a>
            </li>
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Artikel</h4>
                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fa fa-plus"></i> Tambah Artikel
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Judul Artikel</th>
                                    <th>Naskah</th>
                                    <th>Penginput</th>
                                    <th>Tanggal Input</th>
                                    <th>Status Publish</th>
                                    <th>Link Publikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artikels as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kategori_artikel }}</td>
                                    <td>{{ $item->judul_artikel }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#naskahModal{{ $item->id }}">
                                            Lihat Naskah
                                        </button>

                                        <!-- Modal Naskah -->
                                        <div class="modal fade" id="naskahModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Naskah Artikel: {{ $item->judul_artikel }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="white-space: pre-wrap;">{{ $item->naskah_artikel }}</div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->user->nama_lengkap ?? $item->user->name }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($item->status_publish == 'Sudah Publish')
                                            <span class="badge bg-success">Sudah Publish</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Publish</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->link_publikasi)
                                            <a href="{{ $item->link_publikasi }}" target="_blank" class="btn btn-sm btn-outline-primary">Buka Link</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('master-artikel.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('master-artikel.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Artikel</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Kategori Artikel <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="kategori_artikel" value="{{ $item->kategori_artikel }}" required placeholder="Contoh: K3, Umum, dll">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Judul Artikel <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="judul_artikel" value="{{ $item->judul_artikel }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Naskah Artikel <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="naskah_artikel" rows="8" required>{{ $item->naskah_artikel }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Status Publish <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="status_publish" required>
                                                            <option value="Belum Publish" {{ $item->status_publish == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                                                            <option value="Sudah Publish" {{ $item->status_publish == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Link Publikasi (Opsional)</label>
                                                        <input type="url" class="form-control" name="link_publikasi" value="{{ $item->link_publikasi }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('master-artikel.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kategori_artikel" value="{{ old('kategori_artikel') }}" required placeholder="Contoh: K3, Umum, dll">
                    </div>
                    <div class="mb-3">
                        <label>Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_artikel" value="{{ old('judul_artikel') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Naskah Artikel <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="naskah_artikel" rows="8" required>{{ old('naskah_artikel') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status Publish <span class="text-danger">*</span></label>
                        <select class="form-select" name="status_publish" required>
                            <option value="Belum Publish" {{ old('status_publish') == 'Belum Publish' ? 'selected' : '' }}>Belum Publish</option>
                            <option value="Sudah Publish" {{ old('status_publish') == 'Sudah Publish' ? 'selected' : '' }}>Sudah Publish</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Link Publikasi (Opsional)</label>
                        <input type="url" class="form-control" name="link_publikasi" value="{{ old('link_publikasi') }}" placeholder="https://...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable();
    });
</script>
@endsection

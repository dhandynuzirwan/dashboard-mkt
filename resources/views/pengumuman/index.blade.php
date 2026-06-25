@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4 justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Papan Pengumuman</h4>
                <p class="text-muted small">Kelola pengumuman yang akan tampil di Dashboard Karyawan.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus me-1"></i> Tambah Pengumuman
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> Gagal menyimpan data:
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Kategori</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Event</th>
                                <th>Status</th>
                                <th class="text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumuman as $item)
                                <tr>
                                    <td class="px-4 fw-bold">
                                        @if($item->kategori == 'hari_besar')
                                            <span class="badge bg-success">Hari Besar</span>
                                        @elseif($item->kategori == 'urgent')
                                            <span class="badge bg-danger">Urgent</span>
                                        @else
                                            <span class="badge bg-primary">Pencapaian</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                    <td>{{ $item->tanggal_event ? \Carbon\Carbon::parse($item->tanggal_event)->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end px-4">
                                        <button type="button" class="btn btn-sm btn-warning shadow-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm ms-1" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $item->id }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                      <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark">Edit Pengumuman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="{{ route('pengumuman.update', $item->id) }}" method="POST">
                                          @csrf
                                          @method('PUT')
                                          <div class="modal-body text-start pt-3">
                                              <div class="mb-3">
                                                  <label class="form-label fw-bold">Kategori</label>
                                                  <select name="kategori" class="form-select" required>
                                                      <option value="hari_besar" {{ $item->kategori == 'hari_besar' ? 'selected' : '' }}>Hari Besar</option>
                                                      <option value="urgent" {{ $item->kategori == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                                      <option value="pencapaian" {{ $item->kategori == 'pencapaian' ? 'selected' : '' }}>Pencapaian</option>
                                                  </select>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="form-label fw-bold">Judul</label>
                                                  <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="form-label fw-bold">Deskripsi</label>
                                                  <textarea name="deskripsi" class="form-control" rows="3" required>{{ $item->deskripsi }}</textarea>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="form-label fw-bold">Tanggal Event (Opsional)</label>
                                                  <input type="date" name="tanggal_event" class="form-control" value="{{ $item->tanggal_event ? $item->tanggal_event->format('Y-m-d') : '' }}">
                                                  <div class="form-text">Isi jika pengumuman terkait tanggal spesifik di kalender.</div>
                                              </div>
                                              <div class="form-check form-switch mb-3">
                                                  <input class="form-check-input" type="checkbox" name="is_active" id="isActive{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                                  <label class="form-check-label fw-bold" for="isActive{{ $item->id }}">Status Aktif (Tampil di Home)</label>
                                              </div>
                                          </div>
                                          <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">Simpan Perubahan</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                      <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-start pt-3">
                                        Apakah Anda yakin ingin menghapus pengumuman <strong>{{ $item->judul }}</strong>? Data yang dihapus tidak dapat dikembalikan.
                                      </div>
                                      <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger fw-bold rounded-3 px-4">Ya, Hapus</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-bullhorn fs-1 text-light mb-3 d-block"></i>
                                        Belum ada data pengumuman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> <!-- End Card Body -->
        </div> <!-- End Card -->
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-dark">Tambah Pengumuman Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pengumuman.store') }}" method="POST">
          @csrf
          <div class="modal-body text-start pt-3">
              <div class="mb-3">
                  <label class="form-label fw-bold">Kategori</label>
                  <select name="kategori" class="form-select" required>
                      <option value="hari_besar">Hari Besar</option>
                      <option value="urgent">Urgent</option>
                      <option value="pencapaian">Pencapaian</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold">Judul</label>
                  <input type="text" name="judul" class="form-control" required placeholder="Contoh: Libur Idul Adha">
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold">Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" rows="3" required placeholder="Tulis rincian pengumuman..."></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Event (Opsional)</label>
                  <input type="date" name="tanggal_event" class="form-control">
                  <div class="form-text">Isi jika pengumuman terkait tanggal spesifik di kalender.</div>
              </div>
              <div class="form-check form-switch mb-3">
                  <input class="form-check-input" type="checkbox" name="is_active" id="isActiveNew" value="1" checked>
                  <label class="form-check-label fw-bold" for="isActiveNew">Status Aktif (Tampil di Home)</label>
              </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">Simpan Pengumuman</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

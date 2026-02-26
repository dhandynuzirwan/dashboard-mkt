@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data Prospek</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('prospek.update', $prospek->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label>Marketing</label>
                                <select name="marketing_id" class="form-select">
                                    @foreach ($marketings as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $prospek->marketing_id == $m->id ? 'selected' : '' }}>
                                            {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Tanggal Prospek</label>
                                <input type="date" name="tanggal_prospek" value="{{ $prospek->tanggal_prospek }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Perusahaan</label>
                                <input type="text" name="perusahaan" value="{{ $prospek->perusahaan }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>No Telp</label>
                                <input type="text" name="telp" value="{{ $prospek->telp }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $prospek->email }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" value="{{ $prospek->jabatan }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Nama PIC</label>
                                <input type="text" name="nama_pic" value="{{ $prospek->nama_pic }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>WA PIC</label>
                                <input type="text" name="wa_pic" value="{{ $prospek->wa_pic }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>WA Baru</label>
                                <input type="text" name="wa_baru" value="{{ $prospek->wa_baru }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" value="{{ $prospek->lokasi }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Sumber</label>
                                <input type="text" name="sumber" value="{{ $prospek->sumber }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Status</label>
                                <input type="text" name="status" value="{{ $prospek->status }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Update Terakhir</label>
                                <input type="text" name="update_terakhir" value="{{ $prospek->update_terakhir }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control">{{ $prospek->deskripsi }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control">{{ $prospek->catatan }}</textarea>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">Update Prospek</button>
                            <a href="{{ route('prospek.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

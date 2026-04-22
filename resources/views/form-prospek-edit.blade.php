@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data Prospek</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                <label>No Telp Baru</label>
                                <input type="text" name="telp_baru" value="{{ $prospek->telp_baru }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $prospek->email }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Jabatan</label>
                                <select name="jabatan" class="form-select">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Perusahaan" {{ $prospek->jabatan == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                    <option value="HRD" {{ $prospek->jabatan == 'HRD' ? 'selected' : '' }}>HRD</option>
                                    <option value="Divisi Training/Diklat" {{ $prospek->jabatan == 'Divisi Training/Diklat' ? 'selected' : '' }}>Divisi Training/Diklat</option>
                                    <option value="Divisi Purchasing" {{ $prospek->jabatan == 'Divisi Purchasing' ? 'selected' : '' }}>Divisi Purchasing</option>
                                    <option value="Divisi Procurement" {{ $prospek->jabatan == 'Divisi Procurement' ? 'selected' : '' }}>Divisi Procurement</option>
                                    <option value="Humas" {{ $prospek->jabatan == 'Humas' ? 'selected' : '' }}>Humas</option>
                                    <option value="HSE" {{ $prospek->jabatan == 'HSE' ? 'selected' : '' }}>HSE</option>
                                    <option value="Divisi Lingkungan" {{ $prospek->jabatan == 'Divisi Lingkungan' ? 'selected' : '' }}>Divisi Lingkungan</option>
                                    <option value="Pimpinan/Direktur" {{ $prospek->jabatan == 'Pimpinan/Direktur' ? 'selected' : '' }}>Pimpinan/Direktur</option>
                                    <option value="Admin" {{ $prospek->jabatan == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Human Capital" {{ $prospek->jabatan == 'Human Capital' ? 'selected' : '' }}>Human Capital</option>
                                    <option value="Bagian Recruitment" {{ $prospek->jabatan == 'Bagian Recruitment' ? 'selected' : '' }}>Bagian Recruitment</option>
                                    <option value="Sekretariat" {{ $prospek->jabatan == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                                    <option value="Follow Up" {{ $prospek->jabatan == 'Follow Up' ? 'selected' : '' }}>Follow Up</option>
                                    <option value="Bagian Pengadaan" {{ $prospek->jabatan == 'Bagian Pengadaan' ? 'selected' : '' }}>Bagian Pengadaan</option>
                                    <option value="SDM" {{ $prospek->jabatan == 'SDM' ? 'selected' : '' }}>SDM</option>
                                    <option value="HRGA" {{ $prospek->jabatan == 'HRGA' ? 'selected' : '' }}>HRGA</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Nama PIC</label>
                                <input type="text" name="nama_pic" value="{{ $prospek->nama_pic }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>WA PIC</label>
                                <input type="text" name="wa_pic" value="{{ $prospek->wa_pic }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" value="{{ $prospek->lokasi }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Sumber</label>
                                <select name="sumber" class="form-select">
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="DATA BASE MARKETING" {{ $prospek->sumber == 'DATA BASE MARKETING' ? 'selected' : '' }}>DATA BASE MARKETING</option>
                                    <option value="SEARCHING GOOGLE" {{ $prospek->sumber == 'SEARCHING GOOGLE' ? 'selected' : '' }}>SEARCHING GOOGLE</option>
                                    <option value="GOOGLE MAPS" {{ $prospek->sumber == 'GOOGLE MAPS' ? 'selected' : '' }}>GOOGLE MAPS</option>
                                    <option value="ADS" {{ $prospek->sumber == 'ADS' ? 'selected' : '' }}>ADS</option>
                                    <option value="DATA RECALL DARI DATA BASE" {{ $prospek->sumber == 'DATA RECALL DARI DATA BASE' ? 'selected' : '' }}>DATA RECALL DARI DATA BASE</option>
                                    <option value="WEBSITE" {{ $prospek->sumber == 'WEBSITE' ? 'selected' : '' }}>WEBSITE</option>
                                    <option value="LINKED IN" {{ $prospek->sumber == 'LINKED IN' ? 'selected' : '' }}>LINKED IN</option>
                                    <option value="WEBSITE PERUSAHAAN" {{ $prospek->sumber == 'WEBSITE PERUSAHAAN' ? 'selected' : '' }}>WEBSITE PERUSAHAAN</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Status Akhir Data</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="DATA TIDAK VALID & TIDAK TERHUBUNG" {{ $prospek->status == 'DATA TIDAK VALID & TIDAK TERHUBUNG' ? 'selected' : '' }}>DATA TIDAK VALID & TIDAK TERHUBUNG</option>
                                    <option value="TIDAK RESPON" {{ $prospek->status == 'TIDAK RESPON' ? 'selected' : '' }}>TIDAK RESPON</option>
                                    <option value="DAPAT NO WA HRD" {{ $prospek->status == 'DAPAT NO WA HRD' ? 'selected' : '' }}>DAPAT NO WA HRD</option>
                                    <option value="KIRIM COMPRO" {{ $prospek->status == 'KIRIM COMPRO' ? 'selected' : '' }}>KIRIM COMPRO</option>
                                    <option value="MANJA" {{ $prospek->status == 'MANJA' ? 'selected' : '' }}>MANJA</option>
                                    <option value="MANJA ULANG" {{ $prospek->status == 'MANJA ULANG' ? 'selected' : '' }}>MANJA ULANG</option>
                                    <option value="REQUEST PERMINTAAN PELATIHAN" {{ $prospek->status == 'REQUEST PERMINTAAN PELATIHAN' ? 'selected' : '' }}>REQUEST PERMINTAAN PELATIHAN</option>
                                    <option value="MASUK PENAWARAN" {{ $prospek->status == 'MASUK PENAWARAN' ? 'selected' : '' }}>MASUK PENAWARAN</option>
                                    <option value="BELUM ADA KEBUTUHAN" {{ $prospek->status == 'BELUM ADA KEBUTUHAN' ? 'selected' : '' }}>BELUM ADA KEBUTUHAN</option>
                                    <option value="REQUES PERPANJANGAN SERTIFIKAT" {{ $prospek->status == 'REQUES PERPANJANGAN SERTIFIKAT' ? 'selected' : '' }}>REQUES PERPANJANGAN SERTIFIKAT</option>
                                    <option value="PENAWARAN HARDFILE" {{ $prospek->status == 'PENAWARAN HARDFILE' ? 'selected' : '' }}>PENAWARAN HARDFILE</option>
                                    <option value="TIDAK MENERIMA PENAWARAN" {{ $prospek->status == 'TIDAK MENERIMA PENAWARAN' ? 'selected' : '' }}>TIDAK MENERIMA PENAWARAN</option>
                                    <option value="DAPAT NO TELP" {{ $prospek->status == 'DAPAT NO TELP' ? 'selected' : '' }}>DAPAT NO TELP</option>
                                    <option value="SUDAH ADA VENDOR KERJASAMA" {{ $prospek->status == 'SUDAH ADA VENDOR KERJASAMA' ? 'selected' : '' }}>SUDAH ADA VENDOR KERJASAMA</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Update FU</label>
                                <select name="update_terakhir" class="form-select">
                                    <option value="">-- Pilih Update FU --</option>
                                    <option value="NO TELP PERUSAHAAN TIDAK VALID" {{ $prospek->update_terakhir == 'NO TELP PERUSAHAAN TIDAK VALID' ? 'selected' : '' }}>NO TELP PERUSAHAAN TIDAK VALID</option>
                                    <option value="TERHUBUNG OPERATOR FRONT OFFICE" {{ $prospek->update_terakhir == 'TERHUBUNG OPERATOR FRONT OFFICE' ? 'selected' : '' }}>TERHUBUNG OPERATOR FRONT OFFICE</option>
                                    <option value="TERHUBUNG HRD/HSE/DIVISITRAINING" {{ $prospek->update_terakhir == 'TERHUBUNG HRD/HSE/DIVISITRAINING' ? 'selected' : '' }}>TERHUBUNG HRD/HSE/DIVISITRAINING</option>
                                    <option value="TIDAK RESPON" {{ $prospek->update_terakhir == 'TIDAK RESPON' ? 'selected' : '' }}>TIDAK RESPON</option>
                                    <option value="PJ K3" {{ $prospek->update_terakhir == 'PJ K3' ? 'selected' : '' }}>PJ K3</option>
                                    <option value="PERUSAHAAN NON AKTIF" {{ $prospek->update_terakhir == 'PERUSAHAAN NON AKTIF' ? 'selected' : '' }}>PERUSAHAAN NON AKTIF</option>
                                    <option value="TERHUBUNG SECURITY" {{ $prospek->update_terakhir == 'TERHUBUNG SECURITY' ? 'selected' : '' }}>TERHUBUNG SECURITY</option>
                                    <option value="BELUM ADA KEBUTUHAN" {{ $prospek->update_terakhir == 'BELUM ADA KEBUTUHAN' ? 'selected' : '' }}>BELUM ADA KEBUTUHAN</option>
                                    <option value="TERHUBUNG PURCHASING" {{ $prospek->update_terakhir == 'TERHUBUNG PURCHASING' ? 'selected' : '' }}>TERHUBUNG PURCHASING</option>
                                    <option value="TERHUBUNG SDM" {{ $prospek->update_terakhir == 'TERHUBUNG SDM' ? 'selected' : '' }}>TERHUBUNG SDM</option>
                                    <option value="TERHUBUNG PRIBADI" {{ $prospek->update_terakhir == 'TERHUBUNG PRIBADI' ? 'selected' : '' }}>TERHUBUNG PRIBADI</option>
                                </select>
                            </div>

                            <!--<div class="col-md-12">-->
                            <!--    <label>Deskripsi</label>-->
                            <!--    <textarea name="deskripsi" class="form-control">{{ $prospek->deskripsi }}</textarea>-->
                            <!--</div>-->

                            <div class="col-md-12">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control">{{ $prospek->catatan }}</textarea>
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
    
                            <div class="btn-group" role="group" aria-label="Navigasi Prospek">
                                @if($previous)
                                    <a href="{{ route('prospek.edit', $previous->id) }}" class="btn btn-outline-info">
                                        &laquo; Previous
                                    </a>
                                @else
                                    <button class="btn btn-outline-info" disabled>&laquo; Previous</button>
                                @endif
                        
                                @if($next)
                                    <a href="{{ route('prospek.edit', $next->id) }}" class="btn btn-outline-info">
                                        Next &raquo;
                                    </a>
                                @else
                                    <button class="btn btn-outline-info" disabled>Next &raquo;</button>
                                @endif
                            </div>
                        
                            <div class="d-flex gap-2">
                                <a href="{{ session('url_pipeline_terakhir', route('prospek.index')) }}" class="btn btn-secondary shadow-sm">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Prospek</button>
                            </div>
                        
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

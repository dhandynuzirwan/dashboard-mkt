@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Data CTA</h3>
                        <h6 class="op-7 mb-2">Formulir Tambah CTA Baru</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Form Tambah CTA</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('cta.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="prospek_id" value="{{ $prospek->id }}">

                                        <div class="form-group">
                                            <label for="marketing">Marketing</label>
                                            <input type="text" class="form-control" value="{{ $prospek->marketing->name }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Tanggal Prospek</label>
                                            <input type="text" class="form-control" value="{{ $prospek->tanggal_prospek }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="perusahaan">Perusahaan</label>
                                            <input type="text" class="form-control" value="{{ $prospek->perusahaan }}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="judul_permintaan">Permintaan Pelatihan (Judul)</label>
                                            <input type="text" class="form-control" name="judul_permintaan" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Jumlah Peserta</label>
                                            <input type="number" class="form-control" name="jumlah_peserta" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Sertifikasi</label>
                                            <select class="form-select" name="sertifikasi" required>
                                                <option value="kemnaker">Sertifikat KEMENAKER</option>
                                                <option value="bnsp">Sertifikat BNSP</option>
                                                <option value="internal">Sertifikat Internal</option>
                                                <option value="sio">Pembuatan dan Perpanjangan SIO</option>
                                                <option value="riksa">Riksa Uji Alat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Skema Pelatihan</label>
                                            <select class="form-select" name="skema" required>
                                                <option value="Online Training">Online Training</option>
                                                <option value="Offline Training">Offline Training</option>
                                                <option value="Imhouse Training">Inhouse Training</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Harga Penawaran</label>
                                            <input type="number" class="form-control" name="harga_penawaran" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Harga Titip Vendor</label>
                                            <input type="number" class="form-control" name="harga_vendor" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Proposal Penawaran (Link)</label>
                                            <input type="text" class="form-control" name="proposal_link">
                                        </div>

                                        <div class="form-group">
                                            <label>Update Penawaran</label>
                                            <select class="form-select" name="status_penawaran" required>
                                                <option value="under_review">Under Review</option>
                                                <option value="hold">Hold</option>
                                                <option value="kalah_harga">Kalah Harga</option>
                                                <option value="deal">Deal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan Akhir</label>
                                            <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Simpan CTA</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
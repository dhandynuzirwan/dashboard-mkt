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
                                    
                                    {{-- 
                                    Marketing (default)
                                    Prospek (default)
                                    Permintaan Pelatihan
                                    Jumlah Peserta
                                    Sertifikasi (enum Sertifikat KEMENAKER, Sertifikat BNSP, Sertfikat Internal, Pembuatan dan Perpanjangan SIO, Riksa Uji Alat)
                                    Skema Pelatihan (Enum - Skema A, Skema B, Skema C)
                                    Harga Penawaran (Rp)
                                    Harga Titip Vendor (Rp)
                                    Proposal Penawaran (Judul (Link))
                                    Update Penawaran (enum Under Review, Hold, Kalah Harga, Deal)
                                    Keterangan Akhir (Text Area)
                                    --}}
                                    <div class="form-group">
                                        <label for="marketing">Marketing</label>
                                        <input type="text" class="form-control" id="marketing" name="marketing" value="John Doe" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Tanggal</label>
                                        <input type="text" class="form-control" id="date" name="date" value="2024-01-01" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="prospek">Prospek</label>
                                        <input type="text" class="form-control" id="prospek" name="prospek" value="PT. ABC" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="permintaan_pelatihan">Permintaan Pelatihan</label>
                                        <input type="text" class="form-control" id="permintaan_pelatihan" name="permintaan_pelatihan" placeholder="Masukkan Permintaan Pelatihan">
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah_peserta">Jumlah Peserta</label>
                                        <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" placeholder="Masukkan Jumlah Peserta">
                                    </div>
                                    <div class="form-group">
                                        <label for="sertifikasi">Sertifikasi</label>
                                        <select class="form-select form-control" id="sertifikasi" name="sertifikasi">
                                            <option value="">Pilih Sertifikasi</option>
                                            <option value="kemnaker">Sertifikat KEMENAKER</option>
                                            <option value="bnsp">Sertifikat BNSP</option>
                                            <option value="internal">Sertifikat Internal</option>
                                            <option value="sio">Pembuatan dan Perpanjangan SIO</option>
                                            <option value="riksa">Riksa Uji Alat</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="skema_pelatihan">Skema Pelatihan</label>
                                        <select class="form-select form-control" id="skema_pelatihan" name="skema_pelatihan">
                                            <option value="">Pilih Skema Pelatihan</option>
                                            <option value="skema_a">Skema A</option>
                                            <option value="skema_b">Skema B</option>
                                            <option value="skema_c">Skema C</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_penawaran">Harga Penawaran</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input
                                            type="number"
                                            class="form-control"
                                            id="harga_penawaran" name="harga_penawaran"
                                            aria-label="Amount (to the nearest rupiah)"
                                            />
                                            <span class="input-group-text">.00</span>
                                        </div>                                        
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="harga_titip_vendor">Harga Titip Vendor</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input
                                            type="number"
                                            class="form-control"
                                            id="harga_titip_vendor" name="harga_titip_vendor"
                                            aria-label="Amount (to the nearest rupiah)"
                                            />
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="proposal_penawaran">Proposal Penawaran</label>
                                        <input type="text" class="form-control" id="proposal_penawaran" name="proposal_penawaran" placeholder="Masukkan Link Proposal Penawaran">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_penawaran">Update Penawaran</label>
                                        <select class="form-select form-control" id="update_penawaran" name="update_penawaran">
                                            <option value="">Pilih Update Penawaran</option>
                                            <option value="under_review">Under Review</option>
                                            <option value="hold">Hold</option>
                                            <option value="kalah_harga">Kalah Harga</option>
                                            <option value="deal">Deal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan_akhir">Keterangan Akhir</label>
                                        <textarea class="form-control" id="keterangan_akhir" name="keterangan_akhir" rows="3" placeholder="Masukkan Keterangan Akhir"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
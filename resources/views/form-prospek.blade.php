@extends('layouts.app') @section('content')

<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Data Prospek</h3>
                        <h6 class="op-7 mb-2">Formulir Tambah Prospek/Pipeline Baru</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Form Tambah Prospek</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"
                                            >Marketing</label
                                        >
                                        <select
                                            class="form-select"
                                            id="exampleFormControlSelect1"
                                        >
                                            <option>Marketing 1</option>
                                            <option>Marketing 2</option>
                                            <option>Marketing 3</option>
                                            <option>Marketing 4</option>
                                            <option>Marketing 5</option>
                                        </select>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"
                                            >Tanggal Prospek</label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="exampleFormControlSelect1"
                                        />
                                    </div>
                                    {{-- 
                                    Perusahaan
                                    Telp
                                    Email
                                    Jabatan
                                    Nama HRD/PIC
                                    WA HRD/PIC
                                    Lokasi Perusahaan
                                    Sumber Prospek
                                    Update Terakhir
                                    Status Prospek
                                    Deskripsi
                                    Catatan
                                     --}}
                                    <div class="form-group">
                                        <label
                                            for="company"
                                            >Perusahaan</label
                                        >
                                        <div>
                                            <input
                                            type="text"
                                            class="form-control input-full"
                                            id="company"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="phone"
                                            >Telp</label
                                        >
                                        <div>
                                            <input
                                            type="text"
                                            class="form-control input-full"
                                            id="phone"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="email"
                                            >Email</label
                                        >
                                        <div>
                                            <input
                                            type="email"
                                            class="form-control input-full"
                                            id="email"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan"
                                            >Jabatan</label
                                        >
                                        <select
                                            class="form-select"
                                            id="jabatan"
                                        >
                                            <option>HRD</option>
                                            <option>HCP</option>
                                            <option>HSE</option>
                                            <option>Personal</option>
                                            <option>Pimpinan</option>
                                        </select>
                                    </div>   
                                    <div class="form-group">
                                        <label
                                            for="hrd-pic-name"
                                            >Nama HRD/PIC</label
                                        >
                                        <div>
                                            <input
                                            type="text"
                                            class="form-control input-full"
                                            id="hrd-pic-name"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="hrd-pic-wa"
                                            >WA HRD/PIC</label
                                        >
                                        <div>
                                            <input
                                            type="text"
                                            class="form-control input-full"
                                            id="hrd-pic-wa"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="company-location"
                                            >Lokasi Perusahaan</label
                                        >
                                        <div>
                                            <input
                                            type="text"
                                            class="form-control input-full"
                                            id="company-location"
                                            placeholder="Enter Input"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="source"
                                            >Sumber</label
                                        >
                                        <select
                                            class="form-select"
                                            id="source"
                                        >
                                            <option>Database Marketing</option>
                                            <option>Google Maps</option>
                                            <option>Searching Google</option>
                                            <option>ADS</option>
                                            <option>Data Recall dari Database</option>
                                            <option>Whatsapp Marketing</option>
                                            <option>Linkedin</option>
                                            <option>Rekomendasi Klien</option>
                                            <option>Website</option>
                                            <option>Email Marketing</option>
                                            <option>Google Only</option>
                                            <option>Website Perusahaan</option>
                                        </select>
                                    </div>   
                                    <div class="form-group">
                                        <label for="update"
                                            >Update Terakhir</label
                                        >
                                        <select
                                            class="form-select"
                                            id="update"
                                        >
                                            <option>No Telp Perusahaan Tidak Aktif</option>
                                            <option>Terhubung Operator Front Office</option>
                                            <option>Terhubung HRD/PIC</option>
                                            <option>Tidak Respon</option>
                                            <option>Terhubung Advertisier</option>
                                            <option>Terhubung Vendor</option>
                                            <option>Terhubung Purchasing</option>
                                            <option>Terhubung SDM</option>
                                            <option>Terhubung Pribadi</option>
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="status"
                                            >Status Akhir</label
                                        >
                                        <select
                                            class="form-select"
                                            id="status"
                                        >
                                            <option value="data_tidak_valid">DATA TIDAK VALID & TIDAK TERHUBUNG</option>
                                            <option value="tidak_respon">TIDAK RESPON</option>
                                            <option value="dapat_no_wa_hrd">DAPAT NO WA HRD</option>
                                            <option value="dapat_no_telp">DAPAT NO TELP</option>
                                            <option value="kirim_compro">KIRIM COMPRO</option>
                                            <option value="manja">MANJA</option>
                                            <option value="manja_ulang">MANJA ULANG</option>
                                            <option value="request_permintaan_pelatihan">REQUEST PERMINTAAN PELATIHAN</option>
                                            <option value="masuk_penawaran">MASUK PENAWARAN</option>
                                            <option value="penawaran_hardfile">PENAWARAN HARDFILE</option>
                                            <option value="belum_ada_kebutuhan">BELUM ADA KEBUTUHAN</option>
                                            <option value="reques_perpanjangan_sertifikat">REQUES PERPANJANGAN SERTIFIKAT</option>
                                            <option value="tidak_menerima_penawaran">TIDAK MENERIMA PENAWARAN</option>
                                            <option value="sudah_ada_vendor_kerjasama">SUDAH ADA VENDOR KERJASAMA</option>
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label
                                            for="description"
                                            >Deskripsi</label
                                        >
                                        <div>
                                            <textarea
                                            class="form-control input-full"
                                            id="description"
                                            rows="3"
                                            placeholder="Enter Input"
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="notes"
                                            >Catatan</label
                                        >
                                        <div>
                                            <textarea
                                            class="form-control input-full"
                                            id="notes"
                                            rows="3"
                                            placeholder="Enter Input"
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <button
                                            type="submit"
                                            class="btn btn-primary"
                                            >
                                            Submit
                                            </button>
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
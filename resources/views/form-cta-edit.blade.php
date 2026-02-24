@extends('layouts.app')

@section('content')
<div class="wrapper">
    @include('layouts.sidebar')
    <div class="main-panel">
        @include('layouts.header')

        <div class="container">
            <div class="page-inner">

                <div class="d-flex align-items-left align-items-md-center pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Edit CTA</h3>
                        <h6 class="op-7 mb-2">Update Data Penawaran</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form Edit CTA</div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('cta.update', $cta->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Judul Permintaan</label>
                                        <input type="text" name="judul_permintaan"
                                            class="form-control"
                                            value="{{ $cta->judul_permintaan }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Peserta</label>
                                        <input type="number" name="jumlah_peserta"
                                            class="form-control"
                                            value="{{ $cta->jumlah_peserta }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sertifikasi</label>
                                        <input type="text" name="sertifikasi"
                                            class="form-control"
                                            value="{{ $cta->sertifikasi }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Skema</label>
                                        <input type="text" name="skema"
                                            class="form-control"
                                            value="{{ $cta->skema }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Penawaran</label>
                                        <input type="number" name="harga_penawaran"
                                            class="form-control"
                                            value="{{ $cta->harga_penawaran }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Vendor</label>
                                        <input type="number" name="harga_vendor"
                                            class="form-control"
                                            value="{{ $cta->harga_vendor }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Proposal Link</label>
                                        <input type="url" name="proposal_link"
                                            class="form-control"
                                            value="{{ $cta->proposal_link }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Penawaran</label>
                                        <select name="status_penawaran" class="form-control" required>
                                            <option value="under_review" {{ $cta->status_penawaran == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                            <option value="hold" {{ $cta->status_penawaran == 'hold' ? 'selected' : '' }}>Hold</option>
                                            <option value="kalah_harga" {{ $cta->status_penawaran == 'kalah_harga' ? 'selected' : '' }}>Kalah Harga</option>
                                            <option value="deal" {{ $cta->status_penawaran == 'deal' ? 'selected' : '' }}>Deal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan"
                                            class="form-control"
                                            rows="3">{{ $cta->keterangan }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update
                                </button>

                                <a href="{{ route('pipeline') }}" class="btn btn-secondary">
                                    Kembali
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
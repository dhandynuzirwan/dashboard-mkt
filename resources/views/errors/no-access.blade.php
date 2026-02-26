@extends('layouts.app') {{-- Ganti dengan nama file layout utama Anda, misal: layouts.main atau layouts.admin --}}

@section('content')
        <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 80vh;">
            <div class="text-center p-5">
                <div class="mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/2543/2543571.png" 
                        alt="Police Icon" 
                        style="width: 200px; filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.1));">
                </div>

                <h1 class="display-3 fw-bold text-danger">WADUH!</h1>
                <h2 class="h4 text-dark mb-3">Area Terlarang / Restricted Area</h2>
                
                <div class="alert alert-warning d-inline-block border-0 shadow-sm px-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Maaf <span class="fw-bold">{{ auth()->user()->name }}</span>, role Anda ({{ auth()->user()->role }}) tidak diizinkan masuk ke sini.
                </div>

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-round px-4">
                        <i class="fas fa-home me-2"></i> Balik ke Dashboard
                    </a>
                </div>
            </div>
        </div>
@endsection
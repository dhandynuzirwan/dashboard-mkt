<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads_leads', function (Blueprint $table) {
            $table->id();
            
            // Semua kolom diatur menjadi nullable
            $table->string('nama_hrd')->nullable();
            $table->string('email')->nullable();
            $table->string('wa_hrd', 20)->nullable();
            $table->text('kebutuhan_program')->nullable();
            
            $table->enum('jenis_sertifikasi', [
                'upskill', 
                'kemnaker', 
                'bnsp', 
                'perpanjang_sio',
                'riksa',

            ])->nullable();
            
            $table->string('nama_perusahaan')->nullable();
            $table->string('lokasi')->nullable();
            
            $table->enum('jenis_klien', [
                'pribadi', 
                'perusahaan', 
                'pjk3'
            ])->nullable();
            
            $table->enum('channel_akuisisi', [
                'wa', 
                'email', 
                'form'
            ])->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_leads');
    }
};
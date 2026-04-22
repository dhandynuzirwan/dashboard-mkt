<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (pegawai yang login)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->date('tanggal_aktivitas');
            $table->string('nama_kegiatan');
            
            // Langsung disetting Opsional (Boleh Kosong)
            $table->integer('durasi_menit')->nullable();
            $table->text('deskripsi')->nullable();
            
            // Evidence Opsional
            $table->string('file_evidence')->nullable(); 
            $table->string('link_evidence')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
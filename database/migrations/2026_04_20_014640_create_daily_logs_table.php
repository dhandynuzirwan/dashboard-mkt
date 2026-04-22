<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            // Menghubungkan aktivitas ke user yang sedang login
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->date('tanggal_aktivitas');
            $table->string('nama_kegiatan');
            $table->integer('durasi_menit')->nullable(); ;
            $table->text('deskripsi')->nullable(); ;
            
            // Evidence opsional (bisa berupa file gambar atau link)
            $table->string('file_evidence')->nullable(); 
            $table->string('link_evidence')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_logs');
    }
};
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
        Schema::create('pengajuan_lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('nama');
            $table->string('jabatan');
            $table->string('divisi');
            
            $table->text('tugas');
            
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            
            $table->text('dukungan_fasilitas')->nullable();
            $table->text('catatan')->nullable();
            
            $table->enum('status_spv', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_hrd', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_direktur', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_akhir', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->unsignedBigInteger('spv_id')->nullable();
            $table->unsignedBigInteger('hrd_id')->nullable();
            $table->unsignedBigInteger('direktur_id')->nullable();
            
            $table->foreign('spv_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hrd_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('direktur_id')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_lemburs');
    }
};

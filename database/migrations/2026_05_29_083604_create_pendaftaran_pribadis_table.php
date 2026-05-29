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
        Schema::create('pendaftaran_pribadis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->string('no_wa');
            $table->foreignId('master_training_id')->constrained('master_trainings')->onDelete('cascade');
            $table->string('perusahaan')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->enum('opsi_ppn', ['tanpa_ppn', 'dengan_ppn'])->default('tanpa_ppn');
            $table->string('npwp', 16)->nullable();
            
            // Path dokumen
            $table->string('file_ktp');
            $table->string('file_ijazah');
            $table->string('file_foto');
            $table->string('file_cv');
            $table->string('file_sk');
            $table->string('file_laporan');
            $table->string('file_sop');
            
            $table->string('status')->default('pending'); // pending, verifikasi, diterima, tolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pribadis');
    }
};

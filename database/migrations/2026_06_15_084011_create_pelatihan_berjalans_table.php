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
        Schema::create('pelatihan_berjalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_training_id')->constrained('master_trainings')->onDelete('cascade');
            $table->date('tanggal_pelatihan');
            $table->date('tanggal_asesmen')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('instruktur')->nullable();
            $table->string('asesor')->nullable();
            $table->string('pengawas')->nullable();
            $table->string('pjk3')->nullable();
            $table->string('pic_klien')->nullable();
            $table->enum('status_kelas', ['persiapan', 'running', 'selesai', 'batal'])->default('persiapan');
            $table->text('evaluasi')->nullable();
            $table->enum('status_laporan_internal', ['belum', 'sudah'])->default('belum');
            $table->enum('status_laporan_kemnaker', ['belum', 'sudah'])->default('belum');
            $table->string('file_laporan_internal')->nullable();
            $table->string('file_laporan_kemnaker')->nullable();
            $table->string('resi_pengiriman')->nullable();
            $table->string('foto_resi')->nullable();
            $table->string('foto_tanda_terima')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_berjalans');
    }
};

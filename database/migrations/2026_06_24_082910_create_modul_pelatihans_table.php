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
        Schema::create('modul_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_modul');
            $table->enum('sertifikasi', ['KEMNAKER', 'BNSP', 'UPSKILLS']);
            $table->string('kategori');
            $table->string('pengajar');
            $table->integer('tahun');
            $table->unsignedBigInteger('ukuran_file')->default(0);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->integer('total_download')->default(0);
            $table->string('file_path');
            $table->foreignId('pengupload_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_pelatihans');
    }
};

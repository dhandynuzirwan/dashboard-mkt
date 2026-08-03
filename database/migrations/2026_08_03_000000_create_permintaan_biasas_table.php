<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permintaan_biasas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pembuat
            $table->string('judul');
            $table->string('kategori'); // Cover Proposal, Flyer/Poster, dll
            $table->date('deadline');
            $table->string('tujuan');
            $table->text('deskripsi');
            $table->string('referensi_file')->nullable();
            $table->text('catatan')->nullable(); // Untuk revisi/komentar
            $table->enum('prioritas', ['Tinggi', 'Sedang', 'Rendah']);
            $table->enum('status', ['Menunggu', 'Dalam Proses', 'Review', 'Selesai', 'Batal'])->default('Menunggu');
            $table->foreignId('pic_id')->nullable()->constrained('users')->onDelete('set null'); // Desainer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permintaan_biasas');
    }
};

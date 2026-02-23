<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ctas', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel prospeks
            $table->foreignId('prospek_id')->constrained('prospeks')->onDelete('cascade');
            
            $table->string('judul_permintaan')->nullable();
            $table->integer('jumlah_peserta')->nullable();
            $table->enum('sertifikasi', ['kemnaker', 'bnsp', 'internal', 'sio', 'riksa'])->nullable(); // Sertifikasi A, B, C, D, E
            $table->enum('skema', ['Offline Training', 'Online Training', 'Inhouse Training'])->nullable(); // Skema A, B, C
            $table->bigInteger('harga_penawaran')->nullable();
            $table->bigInteger('harga_vendor')->nullable();
            $table->string('proposal_link')->nullable();
            $table->enum('status_penawaran', ['under_review', 'hold', 'kalah_harga', 'deal'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
};

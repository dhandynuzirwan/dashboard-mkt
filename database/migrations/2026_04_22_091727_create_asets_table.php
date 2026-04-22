<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // ex: INV-001
            $table->string('nama');
            $table->string('kategori');
            $table->date('tgl_masuk');
            $table->string('lokasi');
            $table->string('pic')->nullable(); 
            $table->integer('harga')->nullable(); 
            $table->string('kondisi'); 
            $table->string('foto')->nullable(); 
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
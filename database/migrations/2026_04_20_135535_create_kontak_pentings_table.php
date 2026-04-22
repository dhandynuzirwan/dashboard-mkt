<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak_pentings', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('nama_instansi');
            $table->string('nama_pic');
            $table->string('nomor_wa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_pentings');
    }
};
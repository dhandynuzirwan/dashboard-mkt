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
        Schema::create('akun_akses', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Contoh: Instagram, TikTok, Web Hosting
            $table->string('kategori'); // Media Sosial, Web, Tools, dll
            $table->string('username_email');
            $table->text('password'); // Kita akan gunakan encryption Laravel
            $table->string('url_login')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_akses');
    }
};

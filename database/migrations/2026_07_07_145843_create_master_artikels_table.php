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
        Schema::create('master_artikels', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_artikel');
            $table->string('judul_artikel');
            $table->longText('naskah_artikel');
            $table->string('status_publish')->default('Belum Publish');
            $table->string('link_publikasi')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_artikels');
    }
};

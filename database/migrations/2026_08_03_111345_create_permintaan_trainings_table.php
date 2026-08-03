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
        Schema::create('permintaan_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_berjalan_id')->constrained('pelatihan_berjalans')->onDelete('cascade');
            $table->enum('status', ['Menunggu', 'Dalam Proses', 'Selesai'])->default('Menunggu');
            $table->string('background_zoom_file')->nullable();
            $table->string('banner_kegiatan_file')->nullable();
            $table->string('photo_profil_grup_wa_file')->nullable();
            $table->string('table_name_file')->nullable();
            $table->string('lanyard_file')->nullable();
            $table->string('sertifikat_internal_file')->nullable();
            $table->string('rekap_foto_file')->nullable();
            $table->string('rekap_video_file')->nullable();
            $table->string('lainnya_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_trainings');
    }
};

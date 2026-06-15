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
        Schema::table('riwayat_pelatihans', function (Blueprint $table) {
            $table->longText('nama_peserta')->nullable()->change();
            $table->longText('instansi_peserta')->nullable()->change();
            $table->longText('wa_peserta')->nullable()->change();
            $table->longText('marketing')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pelatihans', function (Blueprint $table) {
            $table->string('nama_peserta', 255)->nullable()->change();
            $table->string('instansi_peserta', 255)->nullable()->change();
            $table->string('wa_peserta', 255)->nullable()->change();
            $table->string('marketing', 255)->nullable()->change();
        });
    }
};

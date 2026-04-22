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
        Schema::table('daily_logs', function (Blueprint $table) {
            // Ubah tipe kolom yang sudah ada menjadi nullable
            $table->integer('durasi_menit')->nullable()->change();
            $table->text('deskripsi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_logs', function (Blueprint $table) {
            // Kembalikan ke required (tidak nullable) jika di-rollback
            $table->integer('durasi_menit')->nullable(false)->change();
            $table->text('deskripsi')->nullable(false)->change();
        });
    }
};
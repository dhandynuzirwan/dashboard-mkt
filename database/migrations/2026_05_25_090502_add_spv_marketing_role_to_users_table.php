<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan DB::statement karena mengubah ENUM bawaan Laravel (menggunakan ->change()) sering bermasalah dengan library Doctrine.
        // Sesuaikan isi ENUM di bawah ini dengan daftar role yang saat ini sudah ada di aplikasimu, ditambah 'spv_marketing'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'web_dev', 'admin', 'marketing', 'rnd', 'digitalmarketing', 'operasional', 'team_leader', 'spv_marketing') DEFAULT 'marketing'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke pilihan semula (tanpa spv_marketing) jika migrasi di-rollback
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'web_dev', 'admin', 'marketing', 'rnd', 'digitalmarketing', 'operasional', 'team_leader') DEFAULT 'marketing'");
    }
};
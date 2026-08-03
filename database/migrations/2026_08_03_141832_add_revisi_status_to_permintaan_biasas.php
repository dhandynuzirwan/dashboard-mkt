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
        DB::statement("ALTER TABLE permintaan_biasas MODIFY COLUMN status ENUM('Menunggu', 'Dalam Proses', 'Review', 'Revisi', 'Selesai', 'Batal') DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum back (might fail if rows have 'Revisi', but ok for local dev)
        DB::statement("ALTER TABLE permintaan_biasas MODIFY COLUMN status ENUM('Menunggu', 'Dalam Proses', 'Review', 'Selesai', 'Batal') DEFAULT 'Menunggu'");
    }
};

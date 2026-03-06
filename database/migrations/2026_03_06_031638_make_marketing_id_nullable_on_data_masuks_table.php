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
        Schema::table('data_masuks', function (Blueprint $table) {
            // Mengubah kolom marketing_id menjadi nullable (bisa dikosongkan)
            $table->unsignedBigInteger('marketing_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('data_masuks', function (Blueprint $table) {
            // Mengembalikan ke NOT NULL jika migrasi di-rollback (opsional)
            $table->unsignedBigInteger('marketing_id')->nullable(false)->change();
        });
    }
};

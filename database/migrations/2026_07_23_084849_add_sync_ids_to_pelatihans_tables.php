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
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->unsignedBigInteger('riwayat_pelatihan_id')->nullable()->after('id');
            // We can add index later if needed
        });

        Schema::table('riwayat_pelatihans', function (Blueprint $table) {
            $table->unsignedBigInteger('pelatihan_berjalan_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->dropColumn('riwayat_pelatihan_id');
        });

        Schema::table('riwayat_pelatihans', function (Blueprint $table) {
            $table->dropColumn('pelatihan_berjalan_id');
        });
    }
};

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
            $table->string('bukti_kompeten')->nullable()->after('status_kompeten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pelatihans', function (Blueprint $table) {
            $table->dropColumn('bukti_kompeten');
        });
    }
};

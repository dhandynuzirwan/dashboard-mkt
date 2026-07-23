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
            $table->text('komentar_superadmin')->nullable();
            $table->text('komentar_spv_marketing')->nullable();
            $table->text('komentar_team_leader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->dropColumn(['komentar_superadmin', 'komentar_spv_marketing', 'komentar_team_leader']);
        });
    }
};

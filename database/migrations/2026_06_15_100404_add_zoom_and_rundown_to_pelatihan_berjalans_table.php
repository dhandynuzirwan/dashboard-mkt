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
            $table->string('background_zoom')->nullable()->after('cv');
            $table->string('link_zoom_pelatihan')->nullable()->after('background_zoom');
            $table->string('link_zoom_asesmen')->nullable()->after('link_zoom_pelatihan');
            $table->string('rundown_pelatihan')->nullable()->after('link_zoom_asesmen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->dropColumn(['background_zoom', 'link_zoom_pelatihan', 'link_zoom_asesmen', 'rundown_pelatihan']);
        });
    }
};

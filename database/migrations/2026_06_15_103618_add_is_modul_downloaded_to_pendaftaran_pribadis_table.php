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
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            $table->boolean('is_modul_downloaded')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            $table->dropColumn('is_modul_downloaded');
        });
    }
};

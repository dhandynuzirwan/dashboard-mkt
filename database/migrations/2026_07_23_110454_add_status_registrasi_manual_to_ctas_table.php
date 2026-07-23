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
        Schema::table('ctas', function (Blueprint $table) {
            $table->string('status_registrasi_manual')->nullable()->default('belum_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ctas', function (Blueprint $table) {
            $table->dropColumn('status_registrasi_manual');
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->date('tanggal_bergabung')->nullable();
            $table->string('ktp_file')->nullable();
            $table->string('ijasah_file')->nullable();
            $table->string('pas_foto_file')->nullable();
            $table->string('kk_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_bergabung',
                'ktp_file',
                'ijasah_file',
                'pas_foto_file',
                'kk_file'
            ]);
        });
    }
};

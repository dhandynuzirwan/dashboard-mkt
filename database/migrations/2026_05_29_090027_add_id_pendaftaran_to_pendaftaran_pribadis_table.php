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
            // Tambahkan kolom id_pendaftaran setelah id
            $table->string('id_pendaftaran')->unique()->after('id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            //
        });
    }
};

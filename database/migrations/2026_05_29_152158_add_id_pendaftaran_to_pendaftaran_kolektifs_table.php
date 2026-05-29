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
        Schema::table('pendaftaran_kolektifs', function (Blueprint $table) {
            // Tambahkan kolom baru setelah 'id'
            $table->string('id_pendaftaran')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_kolektifs', function (Blueprint $table) {
            $table->dropColumn('id_pendaftaran');
        });
    }
};

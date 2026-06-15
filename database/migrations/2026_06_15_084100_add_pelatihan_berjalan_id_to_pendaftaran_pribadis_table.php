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
            $table->foreignId('pelatihan_berjalan_id')->nullable()->constrained('pelatihan_berjalans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_berjalan_id']);
            $table->dropColumn('pelatihan_berjalan_id');
        });
    }
};

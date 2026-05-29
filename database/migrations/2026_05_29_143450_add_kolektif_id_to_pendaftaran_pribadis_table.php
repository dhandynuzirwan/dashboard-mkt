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
            $table->foreignId('kolektif_id')->nullable()->after('id')->constrained('pendaftaran_kolektifs')->cascadeOnDelete();
            $table->string('tipe_pendaftaran')->default('individu')->after('kolektif_id'); // individu / kolektif
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

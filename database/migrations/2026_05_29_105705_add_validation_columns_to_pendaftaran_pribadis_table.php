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
            // Kolom status per dokumen (pending, approve, reject)
            $table->string('status_ktp')->default('pending');
            $table->string('catatan_ktp')->nullable();
            
            $table->string('status_ijazah')->default('pending');
            $table->string('catatan_ijazah')->nullable();
            
            $table->string('status_foto')->default('pending');
            $table->string('catatan_foto')->nullable();
            
            $table->string('status_cv')->default('pending');
            $table->string('catatan_cv')->nullable();
            
            $table->string('status_sk')->default('pending');
            $table->string('catatan_sk')->nullable();
            
            $table->string('status_laporan')->default('pending');
            $table->string('catatan_laporan')->nullable();
            
            $table->string('status_sop')->default('pending');
            $table->string('catatan_sop')->nullable();
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

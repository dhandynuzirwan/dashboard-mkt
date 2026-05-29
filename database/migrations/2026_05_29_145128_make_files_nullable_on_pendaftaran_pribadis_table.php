<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            // Tambahkan ->nullable()->change() agar kolom ini boleh kosong
            $table->string('file_ktp')->nullable()->change();
            $table->string('file_ijazah')->nullable()->change();
            $table->string('file_foto')->nullable()->change();
            $table->string('file_cv')->nullable()->change();
            $table->string('file_sk')->nullable()->change();
            $table->string('file_laporan')->nullable()->change();
            $table->string('file_sop')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            // Kembalikan ke NOT NULL jika di-rollback (opsional, sesuaikan nama kolommu jika beda)
            $table->string('file_ktp')->nullable(false)->change();
            $table->string('file_ijazah')->nullable(false)->change();
            $table->string('file_foto')->nullable(false)->change();
            $table->string('file_cv')->nullable(false)->change();
            $table->string('file_sk')->nullable(false)->change();
            $table->string('file_laporan')->nullable(false)->change();
            $table->string('file_sop')->nullable(false)->change();
        });
    }
};

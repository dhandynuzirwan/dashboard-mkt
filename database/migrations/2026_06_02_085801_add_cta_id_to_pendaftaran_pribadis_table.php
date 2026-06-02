<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            // Menambahkan kolom cta_id agar bisa direlasikan dengan tabel ctas (Deal Marketing)
            $table->foreignId('cta_id')->nullable()->after('id_pendaftaran')->constrained('ctas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pribadis', function (Blueprint $table) {
            $table->dropForeign(['cta_id']);
            $table->dropColumn('cta_id');
        });
    }
};

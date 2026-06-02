<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengiriman_pakets', function (Blueprint $table) {
            // Menambahkan kolom foto_resi setelah no_resi
            $table->string('foto_resi')->nullable()->after('no_resi');
        });
    }

    public function down(): void
    {
        Schema::table('pengiriman_pakets', function (Blueprint $table) {
            $table->dropColumn('foto_resi');
        });
    }
};
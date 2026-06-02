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
        Schema::table('asets', function (Blueprint $table) {
            // Menambahkan kolom jumlah dan satuan setelah kolom nama
            // $table->integer('jumlah')->default(1)->after('nama');
            $table->string('satuan')->nullable()->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('asets', function (Blueprint $table) {
            $table->dropColumn(['satuan']);
        });
    }
};

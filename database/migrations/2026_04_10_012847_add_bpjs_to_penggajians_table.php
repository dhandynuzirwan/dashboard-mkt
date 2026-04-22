<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penggajians', function (Blueprint $table) {
            $table->integer('tunjangan_bpjs')->default(0)->after('tunjangan');
            $table->integer('iuran_bpjs')->default(0)->after('tunjangan_bpjs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            //
        });
    }
};

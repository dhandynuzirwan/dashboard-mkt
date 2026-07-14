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
        Schema::table('master_instrukturs', function (Blueprint $table) {
            $table->string('wilayah_instansi')->nullable()->change();
            $table->string('rate_harga')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('no_rek')->nullable()->change();
            $table->string('link_cv')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_instrukturs', function (Blueprint $table) {
            $table->string('wilayah_instansi')->nullable(false)->change();
            $table->string('rate_harga')->nullable(false)->change();
            $table->string('bank')->nullable(false)->change();
            $table->string('no_rek')->nullable(false)->change();
            $table->string('link_cv')->nullable(false)->change();
        });
    }
};

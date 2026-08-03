<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permintaan_biasas', function (Blueprint $table) {
            $table->string('hasil_file')->nullable()->after('referensi_file');
        });
    }

    public function down()
    {
        Schema::table('permintaan_biasas', function (Blueprint $table) {
            $table->dropColumn('hasil_file');
        });
    }
};

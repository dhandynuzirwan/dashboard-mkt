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
        Schema::table('absensi_logs', function (Blueprint $table) {
            $table->string('foto_path')->nullable()->after('source');
        });
    }

    public function down()
    {
        Schema::table('absensi_logs', function (Blueprint $table) {
            $table->dropColumn('foto_path');
        });
    }
};

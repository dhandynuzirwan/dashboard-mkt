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
        Schema::table('daily_logs', function (Blueprint $table) {
            // Tambahkan kolom status setelah nama_kegiatan
            $table->string('status')->default('Not Started')->after('nama_kegiatan');
        });
    }
    
    public function down()
    {
        Schema::table('daily_logs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

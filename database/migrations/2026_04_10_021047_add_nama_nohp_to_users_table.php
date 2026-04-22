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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom nama_lengkap dan no_hp
            // (Posisi ditaruh setelah kolom 'name' atau 'email' sesuai seleramu)
            $table->string('nama_lengkap')->nullable()->after('name');
            $table->string('no_hp', 20)->nullable()->after('nama_lengkap');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'no_hp']);
        });
    }
};

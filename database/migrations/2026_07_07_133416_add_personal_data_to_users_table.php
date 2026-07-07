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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('no_hp');
            $table->date('tanggal_lahir')->nullable()->after('nik');
            $table->date('tanggal_kontrak_baru')->nullable()->after('tanggal_lahir');
            $table->date('tanggal_kontrak_berakhir')->nullable()->after('tanggal_kontrak_baru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'tanggal_lahir',
                'tanggal_kontrak_baru',
                'tanggal_kontrak_berakhir'
            ]);
        });
    }
};

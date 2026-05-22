<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengiriman_pakets', function (Blueprint $table) {
            // Menambahkan kolom marketing_id yang berelasi dengan tabel users
            $table->unsignedBigInteger('marketing_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('pengiriman_pakets', function (Blueprint $table) {
            $table->dropColumn('marketing_id');
        });
    }
};
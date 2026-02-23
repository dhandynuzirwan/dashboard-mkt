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
        Schema::dropIfExists('prospeks');
    }

    public function down()
    {
        // Kalau mau rollback, lo harus tulis ulang skema tabelnya di sini
    }
};

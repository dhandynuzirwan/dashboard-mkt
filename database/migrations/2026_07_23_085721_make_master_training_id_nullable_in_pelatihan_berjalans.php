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
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->unsignedBigInteger('master_training_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->unsignedBigInteger('master_training_id')->nullable(false)->change();
        });
    }
};

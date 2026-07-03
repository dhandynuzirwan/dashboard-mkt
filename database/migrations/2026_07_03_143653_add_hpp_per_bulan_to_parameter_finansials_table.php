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
        Schema::table('parameter_finansials', function (Blueprint $table) {
            $table->bigInteger('hpp_per_bulan')->default(0)->after('target_minimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parameter_finansials', function (Blueprint $table) {
            $table->dropColumn('hpp_per_bulan');
        });
    }
};

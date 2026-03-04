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
        Schema::table('ctas', function (Blueprint $table) {
            $table->bigInteger('total_penawaran')->nullable()->after('harga_penawaran');
            $table->bigInteger('total_vendor')->nullable()->after('harga_vendor');
        });
    }

    public function down(): void
    {
        Schema::table('ctas', function (Blueprint $table) {
            $table->dropColumn(['total_penawaran', 'total_vendor']);
        });
    }
};

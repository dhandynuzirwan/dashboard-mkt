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
    Schema::table('download_requests', function (Blueprint $table) {
        // Adjust the data type (string, integer, etc.) as needed
        $table->string('status_akhir')->nullable()->after('marketing_id');
    });
}

public function down(): void
{
    Schema::table('download_requests', function (Blueprint $table) {
        $table->dropColumn('status_akhir');
    });
}
};

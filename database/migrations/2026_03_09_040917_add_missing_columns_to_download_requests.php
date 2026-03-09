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
        // Tambahkan semua kolom yang dianggap "Unknown" oleh database
        $table->string('status_penawaran')->nullable()->after('status_akhir');
        $table->string('cta_status')->nullable()->after('status_penawaran');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('download_requests', function (Blueprint $table) {
            //
        });
    }
};

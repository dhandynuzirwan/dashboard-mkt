<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads_leads', function (Blueprint $table) {
            // Menambahkan kolom marketing_id setelah kolom id
            // Kita buat nullable karena di awal data masuk belum ada marketing yang handle
            $table->unsignedBigInteger('marketing_id')->nullable()->after('id');

            // Opsional: Jika ingin menambahkan foreign key agar data konsisten
            $table->foreign('marketing_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('ads_leads', function (Blueprint $table) {
            $table->dropForeign(['marketing_id']);
            $table->dropColumn('marketing_id');
        });
    }
};
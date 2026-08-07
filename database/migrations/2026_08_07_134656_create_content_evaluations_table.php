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
        Schema::create('content_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('content_id');
            $table->integer('skor_brand_guideline');
            $table->integer('jumlah_template_baru')->default(0);
            $table->string('laporan_riset_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_evaluations');
    }
};

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
        Schema::create('content_kpis', function (Blueprint $table) {
            $table->id();
            $table->string('periode_bulan');
            $table->integer('total_target_konten')->default(0);
            $table->integer('total_realisasi_konten')->default(0);
            $table->decimal('on_time_rate', 5, 2)->default(0);
            $table->decimal('avg_revision_rate', 5, 2)->default(0);
            $table->decimal('avg_engagement_rate', 5, 2)->default(0);
            $table->integer('total_saves_shares')->default(0);
            $table->decimal('skor_pencapaian_kpi', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_kpis');
    }
};

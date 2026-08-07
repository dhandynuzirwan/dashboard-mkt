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
        Schema::create('content_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('content_id');
            $table->date('tanggal_tayang');
            $table->integer('total_impressions')->default(0);
            $table->integer('total_reach')->default(0);
            $table->integer('total_likes')->default(0);
            $table->integer('total_comments')->default(0);
            $table->integer('total_saves')->default(0);
            $table->integer('total_shares')->default(0);
            $table->decimal('calculated_er', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_metrics');
    }
};

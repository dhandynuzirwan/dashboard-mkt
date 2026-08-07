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
        Schema::create('content_operasionals', function (Blueprint $table) {
            $table->id();
            $table->string('content_id')->unique();
            $table->date('tanggal_brief');
            $table->date('target_deadline');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_deadline', ['On Track', 'Late', 'Completed']);
            $table->string('platform');
            $table->string('format_konten');
            $table->string('judul_konten');
            $table->integer('jumlah_revisi')->default(0);
            $table->string('link_aset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_operasionals');
    }
};

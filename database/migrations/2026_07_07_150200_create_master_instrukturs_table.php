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
        Schema::create('master_instrukturs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instruktur');
            $table->string('wilayah_instansi');
            $table->string('no_telepon');
            $table->string('bidang_ahli');
            $table->bigInteger('rate_harga');
            $table->string('no_rek');
            $table->string('bank');
            $table->string('link_cv')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_instrukturs');
    }
};

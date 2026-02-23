<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('data_masuks', function (Blueprint $table) {
            $table->id();
            // Relasi ke marketing (User)
            $table->foreignId('marketing_id')->constrained('users')->onDelete('cascade');
            
            $table->string('perusahaan');
            $table->string('telp')->nullable();
            $table->string('unit_bisnis')->nullable(); // Kolom Baru
            $table->string('email')->nullable();
            $table->string('status_email')->nullable(); // Kolom Baru (contoh: Valid, Sent, Bounce)
            $table->string('wa_pic')->nullable();
            $table->string('wa_baru')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('sumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_masuks');
    }
};

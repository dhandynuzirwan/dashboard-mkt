<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('prospeks', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (untuk marketing)
            $table->foreignId('marketing_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_prospek');
            $table->string('perusahaan');
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nama_pic')->nullable();
            $table->string('wa_pic')->nullable();
            $table->string('wa_baru')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('sumber')->nullable();
            $table->string('update_terakhir')->nullable();
            $table->string('status')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('prospeks');
    }
};

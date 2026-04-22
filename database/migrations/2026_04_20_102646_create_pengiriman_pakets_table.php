<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengiriman_pakets', function (Blueprint $table) {
            $table->id();
            
            // Info Penerima
            $table->string('instansi');
            $table->string('nama_penerima');
            $table->string('no_hp');
            $table->text('alamat_pengiriman');
            
            // Detail Paket & Kurir
            $table->string('jenis_paket');
            $table->json('isi_paket')->nullable(); // Pakai JSON untuk multi-select/checkbox
            $table->string('isi_paket_lainnya')->nullable();
            $table->string('ekspedisi');
            $table->string('no_resi')->nullable();
            $table->integer('biaya_pengiriman')->default(0);
            
            // Status & Catatan
            $table->enum('status_pengiriman', ['Diproses', 'Dikirim', 'Diterima', 'Bermasalah'])->default('Diproses');
            $table->date('tanggal_kirim');
            $table->date('tanggal_diterima')->nullable();
            $table->text('catatan_teks')->nullable();
            $table->string('catatan_file')->nullable(); // Untuk path file gambar/pdf
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengiriman_pakets');
    }
};
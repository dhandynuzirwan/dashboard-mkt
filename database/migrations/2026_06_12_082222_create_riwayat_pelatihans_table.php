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
        Schema::create('riwayat_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('jenis')->nullable();
            $table->string('metode')->nullable();
            $table->string('judul_pelatihan')->nullable();
            $table->integer('jumlah_peserta')->nullable();
            $table->text('nama_peserta')->nullable();
            $table->text('instansi_peserta')->nullable();
            $table->string('wa_peserta')->nullable();
            $table->string('syarat_peserta')->nullable(); // link drive
            $table->string('ket_syarat')->nullable(); // Lengkap/Belum
            $table->string('nama_trainer')->nullable();
            $table->string('wa_trainer')->nullable();
            $table->string('cv')->nullable(); // file path
            $table->string('modul')->nullable(); // file path
            $table->string('nama_lsp')->nullable();
            $table->string('kontak_lsp')->nullable();
            $table->date('tanggal_asesmen')->nullable();
            $table->string('laporan_pic')->nullable(); // file path
            $table->string('nama_asesor')->nullable();
            $table->string('wa_asesor')->nullable();
            $table->string('marketing')->nullable(); // pilihan Arsa 1, Arsa 2 dll
            $table->string('pic')->nullable(); // isi nama / id dari users
            $table->string('status_kompeten')->nullable(); // Kompeten/Belum
            $table->string('status_sertif')->nullable(); // Sudah Terbit, Belum Terbit
            $table->string('scan_sertif')->nullable(); // file path
            $table->text('keterangan_tambahan')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('wa_penerima')->nullable();
            $table->text('isi_paket')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->date('tanggal_kirim')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status_pengiriman')->nullable(); // di proses, dikirim, diterima
            $table->date('tanggal_diterima')->nullable();
            $table->string('foto')->nullable(); // file path
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pelatihans');
    }
};

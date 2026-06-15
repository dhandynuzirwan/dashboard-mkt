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
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->json('checklist_validasi')->nullable()->after('status_kelas');
            $table->string('status_sertifikat')->default('OGP')->after('checklist_validasi'); // OGP, Delay, Terbit
            $table->date('estimasi_terbit')->nullable()->after('status_sertifikat');
            $table->date('tgl_terima_lembaga')->nullable()->after('estimasi_terbit');
            $table->date('tgl_kirim_klien')->nullable()->after('tgl_terima_lembaga');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_pelatihan');
            $table->string('wa_trainer')->nullable()->after('instruktur');
            $table->string('cv')->nullable()->after('wa_trainer');
            $table->string('modul')->nullable()->after('cv');
            $table->string('nama_lsp')->nullable()->after('asesor');
            $table->string('kontak_lsp')->nullable()->after('nama_lsp');
            $table->string('wa_asesor')->nullable()->after('kontak_lsp');
            $table->text('keterangan_tambahan')->nullable()->after('evaluasi');

            $table->string('file_scan_sertifikat')->nullable()->after('tgl_kirim_klien');
            
            // Pengiriman / Logistik
            $table->string('nama_penerima')->nullable()->after('foto_tanda_terima');
            $table->string('wa_penerima')->nullable()->after('nama_penerima');
            $table->text('isi_paket')->nullable()->after('wa_penerima');
            $table->text('alamat_pengiriman')->nullable()->after('isi_paket');
            $table->date('tanggal_kirim')->nullable()->after('alamat_pengiriman');
            $table->string('status_pengiriman')->nullable()->after('tanggal_kirim'); // di proses, dikirim, diterima
            $table->date('tanggal_diterima')->nullable()->after('status_pengiriman');
            $table->string('ekspedisi')->nullable()->after('tanggal_diterima');
            $table->text('catatan_pengiriman')->nullable()->after('ekspedisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan_berjalans', function (Blueprint $table) {
            $table->dropColumn([
                'checklist_validasi',
                'status_sertifikat',
                'estimasi_terbit',
                'tgl_terima_lembaga',
                'tgl_kirim_klien',
                'tanggal_selesai',
                'wa_trainer',
                'cv',
                'modul',
                'nama_lsp',
                'kontak_lsp',
                'wa_asesor',
                'keterangan_tambahan',
                'file_scan_sertifikat',
                'nama_penerima',
                'wa_penerima',
                'isi_paket',
                'alamat_pengiriman',
                'tanggal_kirim',
                'status_pengiriman',
                'tanggal_diterima',
                'ekspedisi',
                'catatan_pengiriman',
            ]);
        });
    }
};

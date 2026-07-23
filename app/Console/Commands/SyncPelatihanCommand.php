<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiwayatPelatihan;
use App\Models\PelatihanBerjalan;
use App\Models\MasterTraining;
use Carbon\Carbon;

class SyncPelatihanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pelatihan:sync {--month=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data awal Riwayat Pelatihan ke Pelatihan Berjalan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = $this->option('month');
        if (!$month) {
            $month = Carbon::now()->format('Y-m'); // e.g., '2026-07'
        }

        $this->info("Menyinkronkan data Riwayat Pelatihan untuk bulan: {$month}");

        $date = Carbon::createFromFormat('Y-m', $month);
        
        $riwayats = RiwayatPelatihan::whereMonth('tanggal_mulai', $date->month)
                                    ->whereYear('tanggal_mulai', $date->year)
                                    ->get();

        $count = 0;
        foreach ($riwayats as $riwayat) {
            // Cek apakah sudah sinkron
            if ($riwayat->pelatihan_berjalan_id) {
                continue;
            }

            // Cari Master Training berdasarkan judul
            $masterTraining = null;
            if ($riwayat->judul_pelatihan) {
                $masterTraining = MasterTraining::where('nama_training', $riwayat->judul_pelatihan)->first();
            }

            // Buat Pelatihan Berjalan
            $pelatihan = PelatihanBerjalan::create([
                'riwayat_pelatihan_id' => $riwayat->id,
                'master_training_id' => $masterTraining ? $masterTraining->id : null,
                'tanggal_pelatihan' => $riwayat->tanggal_mulai,
                'tanggal_selesai' => $riwayat->tanggal_selesai,
                'tanggal_asesmen' => $riwayat->tanggal_asesmen,
                'lokasi' => $riwayat->metode,
                'instruktur' => $riwayat->nama_trainer,
                'wa_trainer' => $riwayat->wa_trainer,
                'asesor' => $riwayat->nama_asesor,
                'wa_asesor' => $riwayat->wa_asesor,
                'pjk3' => $riwayat->nama_lsp,
                'kontak_lsp' => $riwayat->kontak_lsp,
                'pic_operasional' => $riwayat->pic,
                'status_sertifikat' => $riwayat->status_sertif,
                'file_scan_sertifikat' => $riwayat->scan_sertif,
                'nama_penerima' => $riwayat->nama_penerima,
                'wa_penerima' => $riwayat->wa_penerima,
                'isi_paket' => $riwayat->isi_paket,
                'alamat_pengiriman' => $riwayat->alamat_pengiriman,
                'tanggal_kirim' => $riwayat->tanggal_kirim,
                'resi_pengiriman' => $riwayat->no_resi,
                'status_pengiriman' => $riwayat->status_pengiriman,
                'tanggal_diterima' => $riwayat->tanggal_diterima,
                'foto_tanda_terima' => $riwayat->foto,
                'catatan_pengiriman' => $riwayat->catatan,
                'keterangan_tambahan' => $riwayat->keterangan_tambahan,
                'cv' => $riwayat->cv,
                'modul' => $riwayat->modul,
                'status_kelas' => 'selesai', // Asumsikan selesai jika ada di Riwayat
            ]);

            // Update ID di riwayat
            $riwayat->update(['pelatihan_berjalan_id' => $pelatihan->id]);
            $count++;
        }

        $this->info("Berhasil menyinkronkan {$count} data pelatihan berjalan.");
    }
}

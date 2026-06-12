<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatPelatihan;
use Carbon\Carbon;
use Faker\Factory as Faker;

class RiwayatPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Loop from January (1) to current month (e.g. 6 for June)
        $currentMonth = date('n');
        $year = date('Y');

        for ($month = 1; $month <= $currentMonth; $month++) {
            // Generate 1 to 3 trainings per month
            $numTrainings = rand(1, 3);
            
            for ($i = 0; $i < $numTrainings; $i++) {
                // Random start date in the given month
                $startDate = Carbon::createFromDate($year, $month, rand(1, 25));
                // End date is 1-3 days after start date
                $endDate = $startDate->copy()->addDays(rand(1, 3));
                
                $pesertaCount = rand(5, 30);
                
                RiwayatPelatihan::create([
                    'tanggal_mulai' => $startDate->format('Y-m-d'),
                    'tanggal_selesai' => $endDate->format('Y-m-d'),
                    'jenis' => $faker->randomElement(['BNSP', 'KEMNAKER', 'INHOUSE', 'PUBLIC']),
                    'metode' => $faker->randomElement(['Online Training', 'Offline Training']),
                    'judul_pelatihan' => 'Pelatihan ' . $faker->words(3, true),
                    'jumlah_peserta' => $pesertaCount,
                    'nama_peserta' => $faker->name . ', ' . $faker->name,
                    'instansi_peserta' => $faker->company,
                    'wa_peserta' => $faker->phoneNumber,
                    'syarat_peserta' => 'https://drive.google.com/drive/folders/' . $faker->lexify('????????'),
                    'ket_syarat' => $faker->randomElement(['Lengkap', 'Belum']),
                    'nama_trainer' => $faker->name,
                    'wa_trainer' => $faker->phoneNumber,
                    'nama_lsp' => 'LSP ' . strtoupper($faker->word),
                    'kontak_lsp' => $faker->phoneNumber,
                    'tanggal_asesmen' => $endDate->copy()->addDays(rand(1, 5))->format('Y-m-d'),
                    'nama_asesor' => $faker->name,
                    'wa_asesor' => $faker->phoneNumber,
                    'marketing' => $faker->randomElement(['Arsa 1', 'Arsa 2', 'Arsa 3']),
                    'pic' => $faker->name,
                    'status_kompeten' => $faker->randomElement(['Kompeten', 'Belum']),
                    'status_sertif' => $faker->randomElement(['Sudah Terbit', 'Belum Terbit']),
                    'keterangan_tambahan' => 'Seeder data generated',
                    'nama_penerima' => $faker->name,
                    'wa_penerima' => $faker->phoneNumber,
                    'isi_paket' => 'Sertifikat dan Modul',
                    'alamat_pengiriman' => $faker->address,
                    'tanggal_kirim' => $endDate->copy()->addDays(rand(10, 15))->format('Y-m-d'),
                    'status_pengiriman' => $faker->randomElement(['Diproses', 'Dikirim', 'Diterima']),
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ambil User yang sudah ada di database
        $marketingNames = ['INTAN1', 'INTAN2', 'INTAN3', 'INTAN4', 'INTAN5', 'Marketing 1'];
        $users = User::whereIn('name', $marketingNames)->get();

        if ($users->isEmpty()) {
            $this->command->error("User tidak ditemukan! Pastikan nama user di database sesuai: " . implode(', ', $marketingNames));
            return;
        }

        foreach ($users as $user) {
            // 2. ISI DATA MASUK (15 data per marketing)
            for ($i = 0; $i < 15; $i++) {
                DB::table('data_masuks')->insert([
                    'marketing_id' => $user->id,
                    'perusahaan'   => $faker->company,
                    'telp'         => $faker->phoneNumber,
                    'unit_bisnis'  => $faker->randomElement(['Safety Training', 'Consulting', 'K3 Umum', 'Fire Fighter']),
                    'email'        => $faker->companyEmail,
                    'status_email' => $faker->randomElement(['Valid', 'Sent', 'Bounce']),
                    'wa_pic'       => $faker->phoneNumber,
                    'wa_baru'      => $faker->phoneNumber,
                    'lokasi'       => $faker->city,
                    'sumber'       => $faker->randomElement(['Website', 'Instagram', 'Ads', 'LinkedIn']),
                    'created_at'   => $faker->dateTimeBetween('-2 months', 'now'),
                    'updated_at'   => now(),
                ]);
            }

            // 3. ISI PROSPEK (8 data per marketing)
            for ($i = 0; $i < 8; $i++) {
                $prospekId = DB::table('prospeks')->insertGetId([
                    'marketing_id'    => $user->id,
                    'tanggal_prospek' => $faker->dateTimeBetween('-1 month', 'now'),
                    'perusahaan'      => $faker->company,
                    'telp'            => $faker->phoneNumber,
                    'email'           => $faker->companyEmail,
                    'jabatan'         => $faker->jobTitle,
                    'nama_pic'        => $faker->name,
                    'wa_pic'          => $faker->phoneNumber,
                    'wa_baru'         => $faker->phoneNumber,
                    'lokasi'          => $faker->city,
                    'sumber'          => $faker->randomElement(['Cold Call', 'Direct Visit', 'Referral']),
                    'update_terakhir' => 'Sudah dihubungi via WhatsApp',
                    'status'          => $faker->randomElement(['Hot', 'Warm', 'Cold']),
                    'deskripsi'       => 'Minat untuk training batch depan',
                    'catatan'         => 'Minta diskon 10%',
                    'created_at'      => $faker->dateTimeBetween('-1 month', 'now'),
                    'updated_at'      => now(),
                ]);

                // 4. ISI CTA (Setiap Prospek memiliki 1 data Penawaran/CTA)
                $hargaPenawaran = $faker->numberBetween(10, 100) * 500000; // Range 5jt - 50jt
                
                DB::table('ctas')->insert([
                    'prospek_id'       => $prospekId,
                    'judul_permintaan' => 'Pelatihan ' . $faker->jobTitle,
                    'jumlah_peserta'   => $faker->numberBetween(5, 40),
                    'sertifikasi'      => $faker->randomElement(['kemnaker', 'bnsp', 'internal', 'sio', 'riksa']),
                    'skema'            => $faker->randomElement(['Offline Training', 'Online Training', 'Inhouse Training']),
                    'harga_penawaran'  => $hargaPenawaran,
                    'harga_vendor'     => $hargaPenawaran * 0.6, // Simulasi COGS 60%
                    'proposal_link'    => 'https://shorturl.at/example-link',
                    'status_penawaran' => $faker->randomElement(['under_review', 'hold', 'kalah_harga', 'deal']),
                    'keterangan'       => 'Follow up minggu depan',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        $this->command->info("Seeder berhasil dijalankan menggunakan user yang sudah ada.");
    }
}
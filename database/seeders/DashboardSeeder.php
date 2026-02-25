<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // --- 1. PEMBERSIHAN DATA LAMA (TRUNCATE) ---
        $this->command->info("Membersihkan data lama di tabel ctas, prospeks, dan data_masuks...");
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        DB::table('ctas')->truncate();
        DB::table('prospeks')->truncate();
        DB::table('data_masuks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- 2. AMBIL USER MARKETING ---
        $marketingNames = ['INTAN1', 'INTAN2', 'INTAN3', 'INTAN4', 'INTAN5', 'Marketing 1'];
        $users = User::whereIn('name', $marketingNames)->get();

        if ($users->isEmpty()) {
            $this->command->error("User marketing tidak ditemukan. Pastikan nama sesuai di database.");
            return;
        }

        // Setting waktu: Februari 2026
        $startOfMonth = Carbon::create(2026, 2, 1)->startOfMonth();
        $endOfMonth = Carbon::create(2026, 2, 25); // Menyesuaikan tanggal saat ini

        foreach ($users as $user) {
            $this->command->info("Input 550 data untuk: {$user->name}");

            // Menentukan 1 atau 2 index secara acak untuk menjadi Deal besar (Target ±100jt)
            $jumlahDeal = rand(1, 2);
            $winnerIndices = (array) array_rand(range(0, 549), $jumlahDeal);

            for ($i = 0; $i < 550; $i++) {
                $randomDate = Carbon::createFromTimestamp(rand($startOfMonth->timestamp, $endOfMonth->timestamp));

                // --- INSERT DATA MASUK ---
                DB::table('data_masuks')->insert([
                    'marketing_id' => $user->id,
                    'perusahaan'   => $faker->company,
                    'telp'         => $faker->phoneNumber,
                    'unit_bisnis'  => $faker->randomElement(['Safety Training', 'K3 Umum', 'Sertifikasi BNSP']),
                    'email'        => $faker->companyEmail,
                    'status_email' => $faker->randomElement(['Valid', 'Sent', 'Bounce']),
                    'wa_pic'       => $faker->phoneNumber,
                    'wa_baru'      => $faker->phoneNumber,
                    'lokasi'       => $faker->city,
                    'sumber'       => $faker->randomElement(['Website', 'Instagram', 'Ads', 'LinkedIn']),
                    'created_at'   => $randomDate,
                    'updated_at'   => $randomDate,
                ]);

                // --- INSERT PROSPEK ---
                $prospekId = DB::table('prospeks')->insertGetId([
                    'marketing_id'    => $user->id,
                    'tanggal_prospek' => $randomDate->format('Y-m-d'),
                    'perusahaan'      => $faker->company,
                    'telp'            => $faker->phoneNumber,
                    'email'           => $faker->companyEmail,
                    'jabatan'         => $faker->randomElement(['HRD', 'Manager K3', 'Direktur', 'Purchasing']),
                    'nama_pic'        => $faker->name,
                    'wa_pic'          => $faker->phoneNumber,
                    'wa_baru'         => $faker->phoneNumber,
                    'lokasi'          => $faker->city,
                    'sumber'          => $faker->randomElement([
                                            'DATA BASE MARKETING',
                                            'SEARCHING GOOGLE',
                                            'GOOGLE MAPS',
                                            'ADS',
                                            'DATA RECALL DARI DATA BASE',
                                            'WHATSAPP MARKETING',
                                            'LINKED IN',
                                            'REKOMENDASI KLIEN',
                                            'WEBSITE',
                                            'EMAIL MARKETING',
                                            'GOOGLE ONLY',
                                            'WEBSITE PERUSAHAAN'
                                        ]),
                    'update_terakhir' => 'Follow up status penawaran',
                    'status'          => $faker->randomElement([
                                            'NO TELP PERUSAHAAN TIDAK VALID',
                                            'TERHUBUNG OPERATOR FRONT OFFICE',
                                            'TERHUBUNG HRD/HSE/DIVISITRAINING',
                                            'TIDAK RESPON',
                                            'TERHUBUNG ADVERTISER',
                                            'TERHUBUNG VENDOR',
                                            'TERHUBUNG PURCHASING',
                                            'TERHUBUNG SDM',
                                            'TERHUBUNG PRIBADI'
                                        ]),
                    'deskripsi'       => 'Minat pelatihan sertifikasi untuk karyawan',
                    'catatan'         => 'Minta penawaran harga khusus',
                    'created_at'      => $randomDate,
                    'updated_at'      => $randomDate,
                ]);

                // --- LOGIKA HARGA & STATUS CTA ---
                if (in_array($i, $winnerIndices)) {
                    // INI DATA DEAL (Ikan Paus)
                    $statusPenawaran = 'deal';
                    // Harga dibuat agar total 1-2 deal ini mencapai kisaran 100jt
                    $hargaPenawaran = ($jumlahDeal == 1) 
                        ? rand(98, 102) * 1000000  // Deal tunggal ~100jt
                        : rand(48, 52) * 1000000;   // Dua deal masing-masing ~50jt
                    $jumlahPeserta = rand(20, 50);
                } else {
                    // DATA GAGAL / HOLD (Data sampah dengan nilai kecil)
                    $statusPenawaran = $faker->randomElement(['kalah_harga', 'hold', 'under_review']);
                    $hargaPenawaran = rand(150, 2500) * 1000; // Hanya 150rb - 2.5jt
                    $jumlahPeserta = rand(1, 5);
                }

                // INSERT CTA
                DB::table('ctas')->insert([
                    'prospek_id'       => $prospekId,
                    'judul_permintaan' => 'Penawaran ' . $faker->jobTitle,
                    'jumlah_peserta'   => $jumlahPeserta,
                    'sertifikasi'      => $faker->randomElement(['kemnaker', 'bnsp', 'internal', 'sio', 'riksa']),
                    'skema'            => $faker->randomElement(['Offline Training', 'Online Training', 'Inhouse Training']),
                    'harga_penawaran'  => $hargaPenawaran,
                    'harga_vendor'     => $hargaPenawaran * 0.7, // Margin 30%
                    'proposal_link'    => 'https://drive.google.com/sample-proposal',
                    'status_penawaran' => $statusPenawaran,
                    'keterangan'       => 'Input seeder otomatis untuk simulasi dashboard',
                    'created_at'       => $randomDate,
                    'updated_at'       => $randomDate,
                ]);
            }
        }

        $this->command->info("Selesai! Data lama dibersihkan dan 550 data baru per marketing berhasil diinput.");
    }
}
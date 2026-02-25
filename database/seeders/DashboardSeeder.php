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

        // --- 1. PEMBERSIHAN DATA LAMA ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        DB::table('ctas')->truncate();
        DB::table('prospeks')->truncate();
        DB::table('data_masuks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- 2. AMBIL USER MARKETING ---
        $marketingNames = ['INTAN1', 'INTAN2', 'INTAN3', 'INTAN4', 'INTAN5', 'Marketing 1'];
        $users = User::whereIn('name', $marketingNames)->get();

        $startOfMonth = Carbon::create(2026, 2, 1)->startOfMonth();
        $endOfMonth = Carbon::create(2026, 2, 25);

        foreach ($users as $user) {
            // --- 3. TENTUKAN PERSONA MARKETING SECARA ACAK ---
            // star, hardworker, slacker, closer
            $persona = $faker->randomElement(['star', 'hardworker', 'slacker', 'closer', 'average']);
            
            // Tentukan jumlah data masuk berdasarkan persona (Target Call)
            $totalData = match($persona) {
                'star', 'hardworker' => 550,
                'average'            => rand(350, 450),
                'slacker', 'closer'  => rand(100, 250),
            };

            // Tentukan jumlah Deal (Target Income)
            $jumlahDeal = match($persona) {
                'star'      => rand(2, 3), // Pasti tembus target
                'closer'    => 1,          // Tembus target meski data sedikit
                'average'   => rand(0, 1), // Kadang tembus, kadang tidak
                'hardworker', 'slacker' => 0, // Gagal target income
            };

            $this->command->info("Seeding {$user->name} sebagai [{$persona}] dengan {$totalData} data dan {$jumlahDeal} deal.");

            // Ambil index acak untuk dijadikan deal
            $winnerIndices = ($jumlahDeal > 0) ? (array) array_rand(range(0, $totalData - 1), $jumlahDeal) : [];

            for ($i = 0; $i < $totalData; $i++) {
                $randomDate = Carbon::createFromTimestamp(rand($startOfMonth->timestamp, $endOfMonth->timestamp));

                // INSERT DATA MASUK
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

                // INSERT PROSPEK
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
                    'sumber'          => $faker->randomElement(['DATA BASE MARKETING', 'SEARCHING GOOGLE', 'ADS', 'LINKED IN', 'WEBSITE']),
                    'update_terakhir' => 'Follow up status penawaran',                    
                    'status' => $faker->randomElement([
                                    'DATA TIDAK VALID & TIDAK TERHUBUNG',
                                    'TIDAK RESPON',
                                    'DAPAT NO WA HRD',
                                    'KIRIM COMPRO',
                                    'MANJA',
                                    'MANJA ULANG',
                                    'REQUEST PERMINTAAN PELATIHAN',
                                    'MASUK PENAWARAN',
                                    'BELUM ADA KEBUTUHAN',
                                    'REQUES PERPANJANGAN SERTIFIKAT',
                                    'PENAWARAN HARDFILE',
                                    'TIDAK MENERIMA PENAWARAN',
                                    'DAPAT NO TELP',
                                    'SUDAH ADA VENDOR KERJASAMA',
                                ]),
                    'deskripsi'       => 'Minat pelatihan sertifikasi untuk karyawan',
                    'catatan'         => 'Minta penawaran harga khusus',
                    'created_at'      => $randomDate,
                    'updated_at'      => $randomDate,
                ]);

                // --- LOGIKA HARGA & STATUS CTA ---
                if (in_array($i, $winnerIndices)) {
                    $statusPenawaran = 'deal';
                    
                    // Tentukan harga agar total revenue masuk akal sesuai persona
                    if ($persona == 'star') {
                        $hargaPenawaran = rand(40, 60) * 1000000; // Misal 2-3 kali deal jadi 120jt+
                    } else {
                        $hargaPenawaran = rand(95, 110) * 1000000; // Sekali deal langsung 100jt
                    }
                    $jumlahPeserta = rand(20, 50);
                } else {
                    $statusPenawaran = $faker->randomElement(['kalah_harga', 'hold', 'under_review']);
                    $hargaPenawaran = rand(150, 2500) * 1000;
                    $jumlahPeserta = rand(1, 5);
                }

                DB::table('ctas')->insert([
                    'prospek_id'       => $prospekId,
                    'judul_permintaan' => 'Penawaran ' . $faker->jobTitle,
                    'jumlah_peserta'   => $jumlahPeserta,
                    'sertifikasi'      => $faker->randomElement(['kemnaker', 'bnsp', 'internal', 'sio', 'riksa']),
                    'skema'            => $faker->randomElement(['Offline Training', 'Online Training', 'Inhouse Training']),
                    'harga_penawaran'  => $hargaPenawaran,
                    'harga_vendor'     => $hargaPenawaran * 0.7,
                    'proposal_link'    => 'https://drive.google.com/sample-proposal',
                    'status_penawaran' => $statusPenawaran,
                    'keterangan'       => 'Input seeder otomatis untuk simulasi dashboard',
                    'created_at'       => $randomDate,
                    'updated_at'       => $randomDate,
                ]);
            }
        }

        $this->command->info("Seeder selesai dengan variasi performa marketing!");
    }
}
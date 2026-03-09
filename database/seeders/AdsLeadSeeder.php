<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdsLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan format Indonesia

        $sertifikasi = ['upskill', 'kemnaker', 'bnsp', 'perpanjang_sio'];
        $klien = ['pribadi', 'perusahaan', 'pjk3'];
        $channel = ['wa', 'email', 'form'];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('ads_leads')->insert([
                'nama_hrd'          => $faker->name,
                'email'             => $faker->unique()->companyEmail,
                'wa_hrd'            => '08' . $faker->numerify('##########'),
                'kebutuhan_program' => 'Pelatihan untuk ' . $faker->jobTitle . ' sebanyak ' . $faker->numberBetween(5, 50) . ' orang.',
                'jenis_sertifikasi' => $faker->randomElement($sertifikasi),
                'nama_perusahaan'   => 'PT ' . $faker->company,
                'lokasi'            => $faker->city,
                'jenis_klien'       => $faker->randomElement($klien),
                'channel_akuisisi'  => $faker->randomElement($channel),
                'marketing_id'      => null, // Default null agar muncul tombol Deliver
                'created_at'        => now()->subDays(rand(0, 30)), // Tanggal acak dalam 30 hari terakhir
                'updated_at'        => now(),
            ]);
        }
    }
}
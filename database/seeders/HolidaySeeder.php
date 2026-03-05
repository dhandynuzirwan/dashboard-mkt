<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tanggal' => '2026-01-01', 'keterangan' => 'Tahun Baru 2026'],
            ['tanggal' => '2026-03-31', 'keterangan' => 'Idul Fitri Hari 1'],
            ['tanggal' => '2026-04-01', 'keterangan' => 'Idul Fitri Hari 2'],
            // Tambahkan tanggal merah lainnya di sini
        ];

        foreach ($data as $val) {
            \App\Models\Holiday::updateOrCreate(['tanggal' => $val['tanggal']], $val);
        }
    }
}

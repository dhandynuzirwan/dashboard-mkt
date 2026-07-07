<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
if ($user) {
    $user->update([
        'nik' => '32711234567890',
        'tanggal_lahir' => '1995-08-17',
        'tanggal_kontrak_baru' => '2026-01-01',
        'tanggal_kontrak_berakhir' => '2026-12-31'
    ]);
    echo "User updated: " . $user->nik . "\n";
}

$h = new App\Models\Holiday();
$h->tanggal = date('Y-m-d');
$h->keterangan = 'Hari Libur Nasional Tester';
$h->save();
echo "Holiday created\n";

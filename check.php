<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM pelatihan_berjalans');
foreach ($columns as $col) {
    if ($col->Field === 'status_sertifikat') {
        var_dump($col);
    }
}

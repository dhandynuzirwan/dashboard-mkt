<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $r = App\Models\RiwayatPelatihan::find(10); 
    if ($r) {
        $r->tanggal_mulai = '2026-07-05'; 
        $r->save(); 
        app('App\Http\Controllers\RiwayatPelatihanController')->syncToPelatihanBerjalan($r);
        echo "Success";
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

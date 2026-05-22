<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Mengubah kolom skema menjadi VARCHAR(255)
        // Nilai data lama akan otomatis menjadi teks biasa
        DB::statement("ALTER TABLE ctas MODIFY skema VARCHAR(255) NULL");
    }

    public function down()
    {
        // (Opsional) Jika di-rollback, kembalikan ke ENUM
        // Pastikan isi ENUM di bawah ini sesuai dengan pilihan lama kamu
        DB::statement("ALTER TABLE ctas MODIFY skema ENUM('Offline Training', 'Online Training', 'Inhouse Training') NULL");
    }
};
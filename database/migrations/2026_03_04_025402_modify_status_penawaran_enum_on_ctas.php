<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE ctas MODIFY status_penawaran 
        ENUM('kosong','under_review','hold','kalah_harga','deal') 
        NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE ctas MODIFY status_penawaran 
        ENUM('under_review','hold','kalah_harga','deal') 
        NULL");
    }
};

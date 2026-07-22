<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','marketing','rnd','digitalmarketing','operasional','team_leader','web_dev','spv_marketing','pic','hrd','graphic','finance','performance') DEFAULT 'marketing'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','marketing','rnd','digitalmarketing','operasional','team_leader','web_dev','spv_marketing','pic','hrd','graphic','finance') DEFAULT 'marketing'");
    }
};

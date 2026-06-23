<?php
use Illuminate\Support\Facades\DB;
DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','marketing','rnd','digitalmarketing','operasional','team_leader','web_dev','spv_marketing','pic','hrd') DEFAULT 'marketing'");
echo "Enum updated!";

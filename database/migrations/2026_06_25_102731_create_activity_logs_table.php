<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action_name'); // e.g., 'insert_modul', 'insert_data_masuk'
            $table->string('type');        // e.g., 'Marketing', 'Operasional', 'Modul'
            $table->string('color');       // e.g., 'success', 'primary', 'warning'
            $table->integer('item_count')->default(1);
            $table->string('title_template'); // The unformatted string "User menambahkan {count} modul"
            $table->string('title');          // The formatted string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

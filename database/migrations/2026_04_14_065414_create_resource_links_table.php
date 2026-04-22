<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('resource_links', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->text('url_link');
            $table->string('kategori'); // Untuk nyimpan: spreadsheet, document, folder, other
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_links');
    }
};

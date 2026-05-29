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
        Schema::create('pendaftaran_kolektifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cta_id')->nullable()->constrained('ctas')->nullOnDelete(); // Jembatan ke Prospek Deal
            $table->string('perusahaan');
            $table->text('alamat_perusahaan');
            $table->string('nama_pic');
            $table->string('wa_pic');
            $table->enum('opsi_ppn', ['tanpa_ppn', 'dengan_ppn'])->default('tanpa_ppn');
            $table->string('npwp', 20)->nullable();
            $table->string('file_zip'); // Tempat nyimpan path ZIP
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kolektifs');
    }
};

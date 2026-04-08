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
        Schema::table('ctas', function (Blueprint $table) {
            // Tambahkan kolom file_proposal setelah proposal_link
            $table->string('file_proposal')->nullable()->after('proposal_link');
        });
    }
    
    public function down()
    {
        Schema::table('ctas', function (Blueprint $table) {
            $table->dropColumn('file_proposal');
        });
    }
};

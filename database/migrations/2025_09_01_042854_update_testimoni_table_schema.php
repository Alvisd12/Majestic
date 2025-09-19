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
        Schema::table('testimoni', function (Blueprint $table) {
            // Make id_pengunjung nullable to allow testimoni without login
            $table->foreignId('id_pengunjung')->nullable()->change();
            
            // Add nama column for guest users
            $table->string('nama')->nullable()->after('id_pengunjung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->foreignId('id_pengunjung')->nullable(false)->change();
        });
    }
};

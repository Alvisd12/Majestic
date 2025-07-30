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
        // Update testimoni table - remove nama column as it will be taken from pengunjung table
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropColumn('nama');
        });

        // Update blog table - remove slug column
        Schema::table('blog', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back nama column to testimoni table
        Schema::table('testimoni', function (Blueprint $table) {
            $table->string('nama')->after('id_pengunjung');
        });

        // Add back slug column to blog table
        Schema::table('blog', function (Blueprint $table) {
            $table->string('slug')->unique()->after('judul');
        });
    }
}; 
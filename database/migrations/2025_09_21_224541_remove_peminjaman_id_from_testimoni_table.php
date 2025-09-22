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
            // Drop foreign key constraint if exists
            if (Schema::hasColumn('testimoni', 'peminjaman_id')) {
                $table->dropForeign(['peminjaman_id']);
                $table->dropColumn('peminjaman_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimoni', function (Blueprint $table) {
            $table->unsignedBigInteger('peminjaman_id')->nullable();
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
        });
    }
};

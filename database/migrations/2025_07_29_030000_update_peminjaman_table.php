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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Remove columns that are no longer needed
            $table->dropColumn(['bukti_jaminan', 'keterangan']);
            
            // Remove nama and no_handphone columns as they will be taken from pengunjung table
            $table->dropColumn(['nama', 'no_handphone']);
            
            // Remove foto_ktp column as it will be taken from pengunjung table
            $table->dropColumn('foto_ktp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('nama')->after('user_id');
            $table->string('no_handphone')->after('nama');
            $table->string('bukti_jaminan')->nullable()->after('total_harga');
            $table->string('foto_ktp')->nullable()->after('bukti_jaminan');
            $table->text('keterangan')->nullable()->after('tanggal_kembali');
        });
    }
}; 
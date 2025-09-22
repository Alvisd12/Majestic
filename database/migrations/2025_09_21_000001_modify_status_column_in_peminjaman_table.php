<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah kolom status dari enum ke string dengan panjang yang cukup
            $table->string('status', 100)->default('Menunggu Konfirmasi')->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Kembalikan ke enum jika rollback
            $table->enum('status', ['Pending', 'Confirmed', 'Belum Kembali', 'Disewa', 'Selesai', 'Cancelled'])->default('Pending')->change();
        });
    }
};

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
        // Dibiarkan sebagai string; tidak mengubah kembali ke enum untuk menghindari
        // error data truncated pada nilai status yang sudah ada.
    }
};

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
        // Kolom jenis_motor sudah ditambahkan dan diatur tipenya
        // oleh migrasi lain (enum). Di sini kita pastikan tidak
        // menambahkannya lagi agar tidak terjadi duplicate column.
        if (!Schema::hasColumn('motor', 'jenis_motor')) {
            Schema::table('motor', function (Blueprint $table) {
                $table->string('jenis_motor')->after('merk')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Biarkan kolom jenis_motor tetap ada; tidak perlu di-drop di sini
        // supaya tidak berbenturan dengan migrasi lain yang mengatur tipenya.
    }
};

<?php
// database/migrations/2024_01_01_000003_create_motor_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motor', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->string('model');
            $table->year('tahun');
            $table->string('plat_nomor')->unique();
            $table->decimal('harga_per_hari', 10, 2);
            $table->enum('status', ['Tersedia', 'Disewa', 'Maintenance'])->default('Tersedia');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motor');
    }
};
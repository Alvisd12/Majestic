<?php
// database/migrations/2024_01_01_000002_create_pengunjung_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('foto_ktp')->nullable(); // Tambahkan ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};
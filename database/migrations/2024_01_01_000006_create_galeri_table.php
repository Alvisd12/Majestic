<?php
// database/migrations/2024_01_01_000006_create_galeri_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('admin')->onDelete('cascade');
            $table->string('judul')->nullable();
            $table->string('gambar');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable(); // Tambah kolom kategori
            $table->date('tanggal_sewa')->nullable(); // Tambah kolom tanggal_sewa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
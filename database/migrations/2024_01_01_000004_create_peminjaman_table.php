<?php
// database/migrations/2024_01_01_000004_create_peminjaman_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengunjung')->onDelete('cascade');
            $table->date('tanggal_rental');
            $table->time('jam_sewa')->nullable();
            $table->string('jenis_motor');
            $table->integer('durasi_sewa');
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->string('bukti_jaminan')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Belum Kembali', 'Disewa', 'Selesai', 'Cancelled'])->default('Pending');
            $table->date('tanggal_kembali')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
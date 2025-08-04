<?php
// database/migrations/2024_01_01_000008_create_testimoni_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengunjung')->constrained('pengunjung')->onDelete('cascade');
            $table->string('nama');
            $table->text('pesan');
            $table->integer('rating')->default(5);
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};
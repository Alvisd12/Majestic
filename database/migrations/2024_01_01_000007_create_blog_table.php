<?php
// database/migrations/2024_01_01_000007_create_blog_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('admin')->onDelete('cascade');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
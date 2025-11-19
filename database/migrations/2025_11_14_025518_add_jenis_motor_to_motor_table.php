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
        Schema::table('motor', function (Blueprint $table) {
            $table->enum('jenis_motor', ['Matic', 'Manual', 'Sport', 'Bebek'])->after('merk')->default('Matic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motor', function (Blueprint $table) {
            //
        });
    }
};

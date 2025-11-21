<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMidtransFieldsToPeminjamanTable extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('keterangan');
            $table->string('payment_status')->nullable()->after('payment_method');
            $table->string('midtrans_order_id')->nullable()->after('payment_status');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'midtrans_order_id',
                'midtrans_transaction_id',
            ]);
        });
    }
}

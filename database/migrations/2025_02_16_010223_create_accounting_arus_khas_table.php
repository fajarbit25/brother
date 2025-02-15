<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_arus_khas', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id');
            $table->string('tanggal');
            $table->string('nota')->nullable();
            $table->string('costumer');
            $table->string('items');
            $table->integer('qty');
            $table->string('payment_method');
            $table->string('payment_type');
            $table->integer('amount');
            $table->string('akun_id'); //from ops item table
            $table->string('klasifikasi');
            $table->string('petty_cash');
            $table->string('saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_arus_khas');
    }
};

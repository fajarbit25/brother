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
        Schema::create('operationals', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id');
            $table->string('tipe');
            $table->string('metode');
            $table->string('jenis');
            $table->string('branch_id');
            $table->string('approved');
            $table->string('keterangan')->nullable();
            $table->string('status');
            $table->string('pesan');
            $table->string('user_id');
            $table->integer('amount');
            $table->integer('saldo');
            $table->string('bukti_transaksi');
            $table->string('nomor_nota');
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
        Schema::dropIfExists('operationals');
    }
};

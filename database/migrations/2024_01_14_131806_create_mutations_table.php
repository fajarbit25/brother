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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id('idmutasi');
            $table->string('product_id');
            $table->string('tanggal_mutasi');
            $table->string('jenis');
            $table->string('order_id');
            $table->string('reservasi_id');
            $table->string('penerima');
            $table->integer('qty');
            $table->integer('saldo_awal');
            $table->integer('saldo_akhir');
            $table->string('branch_id');
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
        Schema::dropIfExists('mutations');
    }
};

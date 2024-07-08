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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('idorder');
            $table->string('uuid');
            $table->string('tanggal_order');
            $table->string('costumer_id')->nullable();
            $table->string('total_unit')->nullable();
            $table->string('progres');
            $table->string('status');
            $table->string('invoice_id')->nullable();
            $table->string('status_invoice')->nullable();
            $table->string('tag_invoice');
            $table->string('total_price');
            $table->string('nomor_nota')->nullable();
            $table->string('nota')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('helper')->nullable();
            $table->string('jadwal')->nullable();
            $table->string('request_jam')->nullable();
            $table->string('branch_id');
            $table->string('keterangan')->nullable();
            $table->string('payment')->nullable();
            $table->string('due_date')->nullable();
            $table->string('ppn')->nullable();
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
        Schema::dropIfExists('orders');
    }
};

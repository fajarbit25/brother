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
        Schema::create('productusers', function (Blueprint $table) {
            $table->id('idpu');
            $table->string('teknisi_id');
            $table->string('reservasi_id');
            $table->string('produk_id');
            $table->integer('qty_awal');
            $table->integer('qty');
            $table->integer('retur')->nullable();
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
        Schema::dropIfExists('productusers');
    }
};

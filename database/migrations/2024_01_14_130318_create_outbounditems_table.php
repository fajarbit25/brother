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
        Schema::create('outbounditems', function (Blueprint $table) {
            $table->id('idoi');
            $table->string('reservasi_date');
            $table->string('outbound_id');
            $table->string('order_id');
            $table->string('product_id');
            $table->integer('qty');
            $table->integer('material_price');
            $table->integer('sub_total');
            $table->string('teknisi');
            $table->string('temp_status');
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
        Schema::dropIfExists('outbounditems');
    }
};

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
        Schema::create('outbounds', function (Blueprint $table) {
            $table->id('idout');
            $table->string('order_id');
            $table->string('reservasi_id');
            $table->string('reservasi_date');
            $table->string('reservasi_approved');
            $table->string('reservasi_received');
            $table->string('teknisi_id');
            $table->string('product_user_id');
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
        Schema::dropIfExists('outbounds');
    }
};

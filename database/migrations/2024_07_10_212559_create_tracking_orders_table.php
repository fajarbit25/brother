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
        Schema::create('tracking_orders', function (Blueprint $table) {
            $table->id();
            $table->string('track_id');
            $table->string('order_id');
            $table->string('item_id');
            $table->string('teknisi');
            $table->string('helper');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking_orders');
    }
};

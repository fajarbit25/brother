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
        Schema::create('orderitems', function (Blueprint $table) {
            $table->id('idoi');
            $table->string('order_id');
            $table->string('merk');
            $table->string('pk');
            $table->integer('qty');
            $table->integer('price');
            $table->string('lantai')->nullable();
            $table->string('ruangan')->nullable();
            $table->string('item_id');
            $table->string('branch_id_order');
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
        Schema::dropIfExists('orderitems');
    }
};

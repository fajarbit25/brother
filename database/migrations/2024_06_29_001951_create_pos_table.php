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
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id');
            $table->string('id_transaksi')->nullable();
            $table->string('product_id');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_price');
            $table->string('temp_status');
            $table->string('idcostumer');
            $table->string('payment_status');
            $table->string('user_id');
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
        Schema::dropIfExists('pos');
    }
};

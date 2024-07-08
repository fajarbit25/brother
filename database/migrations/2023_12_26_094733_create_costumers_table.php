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
        Schema::create('costumers', function (Blueprint $table) {
            $table->id('idcostumer');
            $table->string('costumer_kode');
            $table->string('costumer_name');
            $table->string('costumer_pic');
            $table->string('costumer_phone');
            $table->string('costumer_email')->nullable();
            $table->string('costumer_address');
            $table->string('costumer_status');
            $table->string('jumlah_order');
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
        Schema::dropIfExists('costumers');
    }
};

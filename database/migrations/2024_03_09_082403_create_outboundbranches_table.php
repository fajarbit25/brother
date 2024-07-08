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
        Schema::create('outboundbranches', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('referensi');
            $table->string('asal');
            $table->string('tujuan');
            $table->string('product_id');
            $table->string('qty');
            $table->string('tag_temp');
            $table->string('tag_approve');
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
        Schema::dropIfExists('outboundbranches');
    }
};

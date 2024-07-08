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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('periode');
            $table->integer('pokok');
            $table->integer('makan');
            $table->integer('bpjs');
            $table->integer('tunjangan');
            $table->integer('lembur');
            $table->integer('bon');
            $table->integer('kehadiran');
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
        Schema::dropIfExists('salaries');
    }
};

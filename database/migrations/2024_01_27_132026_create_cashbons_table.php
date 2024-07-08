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
        Schema::create('cashbons', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('tanggal');
            $table->string('jam');
            $table->string('status');
            $table->string('approved');
            $table->string('branch_id');
            $table->integer('amount');
            $table->string('alasan_cashbon');
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
        Schema::dropIfExists('cashbons');
    }
};

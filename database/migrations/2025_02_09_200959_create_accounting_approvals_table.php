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
        Schema::create('accounting_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('branch');
            $table->string('segment');
            $table->string('referensi_id');
            $table->string('tanggal');
            $table->enum('tipe', ['debit', 'credit']);
            $table->string('payment_method');
            $table->integer('amount');
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
        Schema::dropIfExists('accounting_approvals');
    }
};

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
        Schema::create('tools_masters', function (Blueprint $table) {
            $table->id();
            $table->string('tools_name');
            $table->string('merk');
            $table->string('nomor_seri');
            $table->integer('stock');
            $table->integer('stock_teknisi');
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
        Schema::dropIfExists('tools_masters');
    }
};

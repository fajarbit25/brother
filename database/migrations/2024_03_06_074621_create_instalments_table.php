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
        Schema::create('instalments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('jatuh_tempo')->nullable();
            $table->string('pembiayaan')->nullable();
            $table->string('jumlah');
            $table->string('lunas');
            $table->string('tag_lock');
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
        Schema::dropIfExists('instalments');
    }
};

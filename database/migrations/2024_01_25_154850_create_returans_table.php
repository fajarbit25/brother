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
        Schema::create('returans', function (Blueprint $table) {
            $table->id();
            $table->string('teknisi_id');
            $table->string('product_id');
            $table->string('tanggal');
            $table->integer('qty');
            $table->string('tag_approved');
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
        Schema::dropIfExists('returans');
    }
};

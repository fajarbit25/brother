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
        Schema::create('inbounds', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('do');
            $table->string('supplier_id');
            $table->string('tag_approved');
            $table->string('temp_status');
            $table->string('branch_id');
            $table->string('status_payment');
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
        Schema::dropIfExists('inbounds');
    }
};

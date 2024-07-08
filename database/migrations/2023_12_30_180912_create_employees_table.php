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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('idkaryawan');
            $table->string('user_id');
            $table->string('tanggal_masuk');
            $table->string('gender');
            $table->string('ktp');
            $table->string('kk');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('telpon_darurat');
            $table->string('pendidikan');
            $table->string('alamat');
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
        Schema::dropIfExists('employees');
    }
};

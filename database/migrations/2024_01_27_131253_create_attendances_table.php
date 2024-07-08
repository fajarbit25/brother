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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('jam_masuk');
            $table->string('jam_pulang')->nullable();
            $table->string('user_id');
            $table->string('branch_id');
            $table->integer('masuk');
            $table->integer('izin');
            $table->integer('alfa');
            $table->integer('lembur');
            $table->integer('off');
            $table->string('tag_absen');
            $table->string('alasan_lembur');
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
        Schema::dropIfExists('attendances');
    }
};

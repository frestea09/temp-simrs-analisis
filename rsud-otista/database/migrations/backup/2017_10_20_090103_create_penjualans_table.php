<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_resep')->unique();
            $table->integer('kamar_id')->nullable();
            $table->string('pembuat_resep');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('registrasi_id');
            $table->integer('dokter_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}

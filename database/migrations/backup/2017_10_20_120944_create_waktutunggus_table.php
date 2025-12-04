<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaktutunggusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktutunggus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id')->unsigned();
            $table->foreign('registrasi_id')->references('id')->on('registrasis')->onDelete('cascade');
            $table->integer('antrian_id')->unsigned();
            $table->foreign('antrian_id')->references('id')->on('antrians')->onDelete('cascade');
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
        Schema::dropIfExists('waktutunggus');
    }
}

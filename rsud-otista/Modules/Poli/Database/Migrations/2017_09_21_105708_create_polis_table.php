<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('politype_id')->unsigned();
            $table->foreign('politype_id')->references('id')->on('politypes')->onDelete('cascade');
            $table->enum('flag', ['Y','N']);
            $table->string('bpjs');
            $table->integer('instalasi_id')->unsigned();
            $table->foreign('instalasi_id')->references('id')->on('instalasis')->onDelete('cascade');
            $table->integer('kamar_id')->unsigned();
            $table->foreign('kamar_id')->references('id')->on('kamars')->onDelete('cascade');
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
        Schema::dropIfExists('polis');
    }
}

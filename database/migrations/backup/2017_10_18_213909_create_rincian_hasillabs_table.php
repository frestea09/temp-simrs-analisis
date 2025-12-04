<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRincianHasillabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_hasillabs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('labkategori_id')->unsigned();
            $table->foreign('labkategori_id')->references('id')->on('labkategoris')->onDelete('cascade');
            $table->integer('laboratoria_id')->unsigned();
            $table->foreign('laboratoria_id')->references('id')->on('laboratoria')->onDelete('cascade');
            $table->string('pemeriksaan');
            $table->float('hasil');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rincian_hasillabs');
    }
}

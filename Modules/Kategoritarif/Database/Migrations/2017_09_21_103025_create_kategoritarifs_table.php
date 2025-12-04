<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategoritarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoritarifs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namatarif');
            $table->integer('kategoriheader_id')->unsigned();
            $table->foreign('kategoriheader_id')->references('id')->on('kategoriheaders')->onDelete('cascade');
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
        Schema::dropIfExists('kategoritarifs');
    }
}

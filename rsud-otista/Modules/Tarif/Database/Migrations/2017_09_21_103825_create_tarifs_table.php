<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->char('jenis',2);
            $table->integer('kategoritarif_id')->unsigned();
            $table->foreign('kategoritarif_id')->references('id')->on('kategoritarifs')->onDelete('cascade');
            $table->string('keterangan');
            $table->integer('tahuntarif_id')->unsigned();
            $table->foreign('tahuntarif_id')->references('id')->on('tahuntarifs')->onDelete('cascade');
            $table->integer('total');
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
        Schema::dropIfExists('tarifs');
    }
}

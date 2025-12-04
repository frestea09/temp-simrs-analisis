<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('splits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tahuntarif_id')->unsigned();
            $table->foreign('tahuntarif_id')->references('id')->on('tahuntarifs')->onDelete('cascade');
            $table->integer('kategoriheader_id')->unsigned();
            $table->foreign('kategoriheader_id')->references('id')->on('kategoriheaders')->onDelete('cascade');
            $table->integer('tarif_id')->unsigned();
            $table->foreign('tarif_id')->references('id')->on('tarifs')->onDelete('cascade');
            $table->string('nama');
            $table->integer('nominal');
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
        Schema::dropIfExists('splits');
    }
}

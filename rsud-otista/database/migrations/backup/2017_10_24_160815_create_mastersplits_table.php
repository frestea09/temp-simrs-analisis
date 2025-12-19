<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastersplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mastersplits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tahuntarif_id')->unsigned();
            $table->foreign('tahuntarif_id')->references('id')->on('tahuntarifs')->onDelete('cascade');
            $table->integer('kategoriheader_id')->unsigned();
            $table->foreign('kategoriheader_id')->references('id')->on('kategoriheaders')->onDelete('cascade');
            $table->string('nama');
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
        Schema::dropIfExists('mastersplits');
    }
}

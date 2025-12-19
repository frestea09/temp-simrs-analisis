<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiayaregistrasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biayaregistrasis', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipe',['E','R']);
            $table->string('shift');
            $table->integer('tarif_id')->unsigned();
            $table->foreign('tarif_id')->references('id')->on('tarifs')->onDelete('cascade');
            $table->integer('tahuntarif_id')->unsigned();
            $table->foreign('tahuntarif_id')->references('id')->on('tahuntarifs')->onDelete('cascade');
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
        Schema::dropIfExists('biayaregistrasis');
    }
}

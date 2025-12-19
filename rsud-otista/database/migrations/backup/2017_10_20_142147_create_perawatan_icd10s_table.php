<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerawatanIcd10sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perawatan_icd10s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icd10_id')->unsigned();
            $table->foreign('icd10_id')->references('id')->on('icd10s')->onDelete('cascade');
            $table->integer('registrasi_id')->unsigned();
            $table->foreign('registrasi_id')->references('id')->on('registrasis')->onDelete('cascade');
            $table->integer('carabayar_id')->unsigned();
            $table->foreign('carabayar_id')->references('id')->on('carabayars')->onDelete('cascade');
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
        Schema::dropIfExists('perawatan_icd10s');
    }
}

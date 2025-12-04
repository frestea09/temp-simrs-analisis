<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoliopelaksanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foliopelaksanas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folio_id')->nullable();
            $table->integer('pegawai_id')->nullable();
            $table->string('pelaksana_tipe')->nullable();
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
        Schema::dropIfExists('foliopelaksanas');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterobatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masterobats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('kode');
            $table->integer('satuanjual_id')->unsigned();
            $table->foreign('satuanjual_id')->references('id')->on('satuanjuals')->onDelete('cascade');
            $table->integer('satuanbeli_id')->unsigned();
            $table->foreign('satuanbeli_id')->references('id')->on('satuanbelis')->onDelete('cascade');
            $table->integer('kategoriobat_id')->unsigned();
            $table->foreign('kategoriobat_id')->references('id')->on('kategoriobats')->onDelete('cascade');
            $table->integer('hargajual');
            $table->integer('hargabeli');
            $table->enum('aktif',['Y','N'])->default('Y');
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
        Schema::dropIfExists('masterobats');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_keluargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->string('namaayah')->nullable();
            $table->string('tmplahirayah', 100)->nullable();
            $table->date('tgllahirayah')->nullable();
            $table->string('nohpayah', 30)->nullable();
            $table->integer('pekerjaanayah_id')->unsigned();
            $table->string('namaibu')->nullable();
            $table->string('tmplahiribu', 100)->nullable();
            $table->date('tgllahiribu')->nullable();
            $table->string('nohpibu', 30)->nullable();
            $table->integer('pekerjaanibu_id')->unsigned();
            $table->string('namapasangan')->nullable();
            $table->date('tglnikah')->nullable();
            $table->integer('pendidikan_id')->unsigned();
            $table->integer('pekerjaanpasangan_id')->unsigned();
            $table->timestamps();

            $table->foreign('biodata_id')->references('id')->on( 'hrd_biodatas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pekerjaanayah_id')->references('id')->on('pekerjaans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pekerjaanpasangan_id')->references('id')->on( 'pekerjaans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrd_keluargas');
    }
}

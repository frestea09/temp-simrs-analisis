<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('dokter_id')->unsigned();
            $table->foreign('dokter_id')->references('id')->on('dokters')->onDelete('cascade');
            $table->integer('diskon');
            $table->integer('pasien_id')->unsigned();
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->integer('harus_dibayar');
            $table->integer('subsidi');
            $table->integer('dijamin');
            $table->integer('selisih_positif');
            $table->integer('selisih_negatif');
            $table->date('approval_tanggal');
            $table->string('user_approval');
            $table->integer('pembulatan');
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
        Schema::dropIfExists('tagihans');
    }
}

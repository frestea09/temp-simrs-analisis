<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id')->unsigned();
            $table->foreign('registrasi_id')->references('id')->on('registrasis')->onDelete('cascade');
            $table->char('status',2);
            $table->integer('poli_id')->unsigned();
            $table->foreign('poli_id')->references('id')->on('polis')->onDelete('cascade');
            $table->integer('bed_id')->unsigned();
            $table->foreign('bed_id')->references('id')->on('beds')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('histori_statuses');
    }
}

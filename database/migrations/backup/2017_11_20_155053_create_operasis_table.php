<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operasis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->integer('rawatinap_id');
            $table->integer('no_rm');
            $table->date('rencana_operasi');
            $table->text('suspect');
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
        Schema::dropIfExists('operasis');
    }
}

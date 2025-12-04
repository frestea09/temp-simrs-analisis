<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwaldoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwaldokters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('poli');
            $table->string('dokter');
            $table->string('hari');
            $table->string('jam_mulai');
            $table->string('jam_berakhir');
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
        Schema::dropIfExists('jadwaldokters');
    }
}

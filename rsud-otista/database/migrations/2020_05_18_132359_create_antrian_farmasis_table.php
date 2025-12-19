<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianFarmasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_farmasis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor');
            $table->string('suara');
            $table->char('status',1)->default(0);
            $table->char('panggil',1);
            $table->date('tanggal');
            $table->integer('loket')->default(NULL);
            $table->char('kelompok',1)->default(NULL);
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
        Schema::dropIfExists('antrian_farmasis');
    }
}

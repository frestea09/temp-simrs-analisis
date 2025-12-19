<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasilradiologisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasilradiologis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->string('dokter');
            $table->integer('kelas_id')->nullable();
            $table->integer('kamar_id')->nullable();
            $table->integer('bed_id')->nullable();
            $table->string('who_update');
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
        Schema::dropIfExists('hasilradiologis');
    }
}

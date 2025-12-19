<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGizisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gizis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->string('dokter');
            $table->integer('kelas_id')->nullable();
            $table->integer('kamar_id')->nullable();
            $table->integer('bed_id')->nullable();
            $table->string('gizi');
            $table->string('catatan');
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
        Schema::dropIfExists('gizis');
    }
}

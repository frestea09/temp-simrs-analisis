<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkutansiPenyusutanPiutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akutansi_penyusutan_piutang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tahun');
            $table->integer('penghapusan');
            $table->integer('pengurangan');
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
        Schema::dropIfExists('akutansi_penyusutan_piutang');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenyisihanPiutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akutansi_penyisihan_piutang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cara_bayar_id');
            $table->integer('tahun');
            $table->integer('saldo_piutang');
            $table->timestamps();
        });
        Schema::create('akutansi_pengurangan_piutang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('akutansi_penyisihan_piutang_id');
            $table->integer('tahun');
            $table->integer('penyisihan')->nullable();
            $table->integer('penghapusan')->nullable();
            $table->integer('penambahan')->nullable();
            $table->integer('pembayaran')->nullable();
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
        Schema::dropIfExists('akutansi_penyisihan_piutang');
        Schema::dropIfExists('akutansi_pengurangan_piutang');
    }
}

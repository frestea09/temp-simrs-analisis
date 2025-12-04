<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriHapusFaktursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_hapus_fakturs', function (Blueprint $table) {
            $table->increments('id');
            $table->json('penjualandetail');
            $table->json('penjualan');
            $table->json('folio');
            $table->string('total_faktur');
            $table->string('no_faktur');
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
        Schema::dropIfExists('histori_hapus_fakturs');
    }
}

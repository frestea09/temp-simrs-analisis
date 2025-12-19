<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembalianObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian_obats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('logistikpinjamobat_id');
            $table->integer('rspinjam_id');
            $table->string('nomorberitaacara');
            $table->date('tgl_pengembalian');
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
        Schema::dropIfExists('pengembalian_obats');
    }
}

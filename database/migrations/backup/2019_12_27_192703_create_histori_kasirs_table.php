<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriKasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_kasirs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->integer('pasien_id');
            $table->integer('id_tarif');
            $table->string('alasan');
            $table->integer('user_id');
            $table->json('folio_record', 400);
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
        Schema::dropIfExists('histori_kasirs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratInapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_inaps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->string('diagnosa');
            $table->integer('dokter_rawat');
            $table->integer('dokter_pengirim');
            $table->string('jenis_kamar');
            $table->integer('carabayar');
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
        Schema::dropIfExists('surat_inaps');
    }
}

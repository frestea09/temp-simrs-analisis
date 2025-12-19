<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriKunjunganJnzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_kunjungan_jnzs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->integer('pasien_id');
            $table->integer('poli_id');
            $table->integer('dokter_id')->nullable();
            $table->enum('pasien_asal', ['TA', 'TI', 'TG']);
            $table->string('user', 50)->nullable();
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
        Schema::dropIfExists('histori_kunjungan_jnzs');
    }
}

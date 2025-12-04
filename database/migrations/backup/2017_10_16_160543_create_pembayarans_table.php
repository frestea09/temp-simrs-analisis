<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jenis');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('total');
            $table->integer('dibayar');
            $table->enum('flag',['Y','N']);
            $table->integer('registrasi_id')->unsigned();
            $table->foreign('registrasi_id')->references('id')->on('registrasis')->onDelete('cascade');
            $table->integer('dokter_id')->unsigned();
            $table->foreign('dokter_id')->references('id')->on('dokters')->onDelete('cascade');
            $table->float('diskon_persen')->nullable();
            $table->integer('diskon_rupiah')->nullable();
            $table->string('no_kwitansi');
            $table->integer('pasien_id')->unsigned();
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->integer('service_cash')->nullable();
            $table->char('titipan',1)->nullable();
            $table->string('appv')->nullable();
            $table->integer('hrs_bayar')->nullable();
            $table->integer('subsidi')->nullable();
            $table->integer('dijamin')->nullable();
            $table->integer('selisih_positif')->nullable();
            $table->integer('selisih_negatif')->nullable();
            $table->date('tgl_apprv')->nullable();
            $table->string('user_apprv')->nullable();
            $table->char('reminder', 1)->nullable();
            $table->integer('pembulatan')->nullable();
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
        Schema::dropIfExists('pembayarans');
    }
}

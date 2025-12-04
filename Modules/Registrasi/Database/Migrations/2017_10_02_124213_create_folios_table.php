<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id')->unsigned()->nullable();
            $table->foreign('registrasi_id')->references('id')->on('registrasis')->onDelete('cascade');
            $table->string('namatarif')->nullable();
            $table->integer('total')->nullable();
            $table->integer('tarif_id')->nullable();
            $table->string('jenis')->nullable();
            $table->enum('lunas', ['Y','N'])->nullable();
            $table->integer('dibayar')->nullable();
            $table->timestamp('waktu_dibayar')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('jenis_pasien')->nullable();
            $table->string('no_kuitansi')->nullable();
            $table->integer('diskon')->nullable();
            $table->integer('pembulatan_penjualan')->nullable();
            $table->integer('total_harga')->nullable();
            $table->integer('pasien_id')->unsigned()->nullable();
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->integer('dokter_id')->unsigned()->nullable();
            $table->foreign('dokter_id')->references('id')->on('dokters')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('poli_id')->unsigned()->nullable();
            $table->foreign('poli_id')->references('id')->on('polis')->onDelete('cascade');
            $table->integer('tagihan_id')->unsigned()->nullable();
            $table->foreign('tagihan_id')->references('id')->on('tagihans')->onDelete('cascade');
            $table->integer('dijamin')->nullable();
            $table->integer('subsidi')->nullable();
            $table->integer('iur_bayar')->nullable();
            $table->integer('harus_bayar')->nullable();
            $table->integer('dijamin1')->nullable();
            $table->integer('dijamin2')->nullable();
            $table->string('pembatal')->nullable();
            $table->datetime('waktu_batal')->nullable();
            $table->enum('is_batal',['Y','N'])->nullable();
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
        Schema::dropIfExists('folios');
    }
}

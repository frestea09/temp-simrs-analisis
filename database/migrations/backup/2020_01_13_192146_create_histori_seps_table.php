<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriSepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_seps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nik')->nullable();
            $table->integer('registrasi_id')->nullable();
            $table->string('namapasien')->nullable();
            $table->string('nama_kartu')->nullable();
            $table->string('nama_ppk_perujuk')->nullable();
            $table->string('kode_ppk_perujuk')->nullable();
            $table->string('no_rm')->nullable();
            $table->string('no_bpjs')->nullable();
            $table->string('no_tlp')->nullable();
            $table->date('tgl_rujukan')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->string('ppk_rujukan')->nullable();
            $table->string('nama_perujuk')->nullable();
            $table->string('diagnosa_awal')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('asalRujukan')->nullable();
            $table->string('hak_kelas_inap')->nullable();
            $table->integer('katarak')->nullable();
            $table->date('tglSep')->nullable();
            $table->string('tipe_jkn')->nullable();
            $table->string('poli_bpjs')->nullable();
            $table->string('noSurat')->nullable();
            $table->string('kodeDPJP')->nullable();
            $table->string('laka_lantas')->nullable();
            $table->string('penjamin')->nullable();
            $table->date('tglKejadian')->nullable();
            $table->string('kll')->nullable();
            $table->string('suplesi')->nullable();
            $table->string('noSepSuplesi')->nullable();
            $table->integer('kdPropinsi')->nullable();
            $table->integer('kdKabupaten')->nullable();
            $table->integer('kdKecamatan')->nullable();
            $table->string('no_sep')->nullable();
            $table->integer('carabayar_id')->nullable();
            $table->string('catatan_bpjs')->nullable();
            $table->string('cob')->nullable();
            $table->integer('dokter_id')->nullable();
            $table->string('​kodeDPJP')->nullable();
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
        Schema::dropIfExists('histori_seps');
    }
}

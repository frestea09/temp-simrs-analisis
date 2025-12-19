<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pasien_id')->unsigned();
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->string('reg_id');
            $table->string('jenis_pasien')->nullable();
            $table->enum('status',['baru','lama'])->nullable();
            $table->string('keterangan')->nullable();
            $table->string('rujukan')->nullable();
            $table->string('status_reg')->nullable();
            $table->string('status_ugd')->nullable();
            $table->string('apotik_rawatinap')->nullable();
            $table->string('note')->nullable();
            $table->string('tipe_rawat')->nullable();
            $table->string('no_antrian')->nullable();
            $table->string('batal')->nullable();
            $table->string('status_cetak_kartu')->nullable();
            $table->string('periksa_gratis')->nullable();
            $table->string('masuk_apotik')->nullable();
            $table->string('info')->nullable();
            $table->string('obat')->nullable();
            $table->string('dokter_id')->nullable();
            $table->integer('poli_id')->unsigned()->nullable();
            $table->foreign('poli_id')->references('id')->on('polis')->onDelete('cascade');
            $table->string('kartu')->nullable();
            $table->string('program')->nullable();
            $table->string('umur')->nullable();
            $table->string('icd')->nullable();
            $table->string('bayar',10)->nullable();
            $table->string('utama')->nullable();
            $table->string('shift')->nullable();
            $table->string('tipe_layanan')->nullable();
            $table->integer('sebabsakit_id')->unsigned()->nullable();
            $table->foreign('sebabsakit_id')->references('id')->on('sebabsakits')->onDelete('cascade');
            $table->string('tingkat_kegawatan')->nullable();
            $table->integer('kelas_id')->unsigned()->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->date('keluar_inap')->nullable();
            $table->string('diagnosa_inap')->nullable();
            $table->string('no_sep')->nullable();
            $table->string('tipe_jkn')->nullable();
            $table->string('hak_kelas_inap')->nullable();
            $table->date('tgl_rujukan')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->string('ppk_rujukan')->nullable();
            $table->string('diagnosa_awal')->nullable();
            $table->date('tgl_sep')->nullable();
            $table->string('poli_bpjs')->nullable();
            $table->char('verifikasi_tindakan',1)->nullable();
            $table->string('jkn_mandiri')->nullable();
            $table->date('jkn_update')->nullable();
            $table->string('id_klinik_waktu_tunggu')->nullable();
            $table->char('operasi',1)->nullable();
            $table->char('lab',1)->nullable();
            $table->char('kondisi_akhir_pasien',2)->nullable();
            $table->integer('instalasi_id')->unsigned()->nullable();
            $table->foreign('instalasi_id')->references('id')->on('instalasis')->onDelete('cascade');
            $table->char('pulang',1)->nullable();
            $table->char('radiologi',1)->nullable();
            $table->char('jkn_bersyarat',1)->nullable();
            $table->string('tipe_paket')->nullable();
            $table->datetime('tgl_pulang')->nullable();
            $table->string('cara_keluar_inap')->nullable();
            $table->string('keadaan_keluar_inap')->nullable();
            $table->integer('perusahaan_id')->unsigned();
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans')->onDelete('cascade');
            $table->integer('user_create')->unsigned();
            $table->foreign('user_create')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('registrasis');
    }
}

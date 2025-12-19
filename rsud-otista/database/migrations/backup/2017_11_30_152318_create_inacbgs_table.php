<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInacbgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inacbgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pasien_nama');
            $table->string('pasien_kelamin');
            $table->date('pasien_tgllahir');
            $table->string('jenis_pembayaran');
            $table->string('no_kartu');
            $table->string('no_sep');
            $table->string('jenis_pasien');
            $table->string('kelas_perawatan');
            $table->integer('los');
            $table->string('cara_keluar');
            $table->string('dokter');
            $table->integer('berat');
            $table->integer('total_rs');
            $table->string('surat_rujukan')->nullable();
            $table->string('bhp')->nullable();
            $table->string('severity')->nullable();
            $table->string('adl')->nullable();
            $table->string('sp')->nullable();
            $table->string('drugs')->nullable();
            $table->string('no_rm');
            $table->string('pembayaran_id');
            for($i=1; $i <= 30; $i++)
            {
              $table->string('icd'.$i)->nullable();
            }

            for($r=1; $r <= 30; $r++)
            {
              $table->string('prosedur'.$r)->nullable;
            }
            $table->string('alamat');
            $table->string('no_hp')->nullable();
            $table->integer('poli_id')->nullable();
            $table->integer('registrasi_id');
            $table->integer('dijamin')->nullable();
            $table->string('kode')->nullable();
            $table->string('final_klaim')->nullable();
            $table->string('who_update')->nullable();
            $table->string('who_final_klaim')->nullable();
            $table->integer('topup')->nullable();
            $table->datetime('tgl_masuk')->nullable();
            $table->datetime('tgl_keluar')->nullable();
            $table->string('kirim_dc')->nullable();
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
        Schema::dropIfExists('inacbgs');
    }
}

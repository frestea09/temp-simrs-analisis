<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_rm')->unique();
            $table->string('nama');
            $table->string('tmplahir');
            $table->date('tgllahir');
            $table->enum('kelamin',['L','P']);
            $table->string('alamat');
            $table->string('kode')->nullable();
            $table->integer('province_id')->unsigned();
            // $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->integer('regency_id')->unsigned();
            // $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->integer('district_id')->unsigned();
            // $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->integer('village_id')->unsigned();
            // $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->string('nohp');
            $table->string('notlp')->nullable();
            $table->string('foto')->nullable();
            $table->string('negara')->nullable();
            $table->integer('pekerjaan_id')->unsigned();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')->onDelete('cascade');
            $table->integer('agama_id')->unsigned();
            $table->foreign('agama_id')->references('id')->on('agamas')->onDelete('cascade');
            $table->integer('perusahaan_id')->unsigned()->nullable();
            $table->foreign('perusahaan_id')->references('id')->on('perusahaans')->onDelete('cascade');
            $table->integer('pendidikan_id')->unsigned();
            $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade');
            $table->string('nama_kk')->nullable();
            $table->string('no_identitas')->nullable();
            $table->string('no_sktm')->nullable();
            $table->string('no_jkn')->nullable();
            $table->string('pj');
            $table->string('pj_pendidikan')->nullable();
            $table->string('pj_pekerjaan')->nullable();
            $table->string('pj_status');
            $table->string('no_jaminan')->nullable();
            $table->string('no_sep')->nullable();
            $table->string('jkn')->nullable();
            $table->string('nik')->nullable();
            $table->string('jkn_asal')->nullable();
            $table->string('tipe_paket')->nullable();
            $table->string('suami_istri');
            $table->string('user_create');
            $table->string('user_update');
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
        Schema::dropIfExists('pasiens');
    }
}

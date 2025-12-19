<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEchocardiogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echocardiograms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->enum('fungsi_sistolik', ['baik', 'cukup', 'menurun']);
            $table->integer('ef');
            $table->enum('dimensi_ruang_jantung', ['normal', 'la_dilatasi', 'lv_dilatasi', 'ra_dilatasi', 'rv_dilatasi', 'semua_dilatasi']);
            $table->enum('lv', ['konsentrik(+)', 'Eksentrik(+)', '(-)']);
            $table->enum('global', ['normokinetik', 'hipokinetik']);
            $table->enum('fungsi_sistolik_rv', ['baik', 'menurun']);
            $table->enum('tapse', ['>_16', '<_16']);
            $table->enum('katup_katup_jantung_mitral', ['ms_ringan', 'ms_sedang','ms_berat']);
            $table->enum('katup_katup_jantung_aorta', ['3_cuspis', '2_cuspis']);
            $table->string('katup_katup_jantung_aorta_cuspis')->nullable();
            $table->enum('katup_katup_jantung_trikuspid', ['tr_ringan', 'tr_sedang','tr_berat']);
            $table->enum('katup_katup_jantung_pulmonal', ['pr_ringan', 'pr_sedang','pr_berat']);
            $table->string('kesimpulan')->nullable();
            $table->string('catatan_dokter')->nullable();
            $table->string('jenis')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('echocardiograms');
    }
}

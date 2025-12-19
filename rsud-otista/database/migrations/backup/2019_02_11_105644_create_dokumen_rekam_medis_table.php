<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenRekamMedisTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('dokumen_rekam_medis', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('registrasi_id')->unique();
			$table->integer('pasien_id');
			$table->string('radiologi')->nullable();
			$table->string('resummedis')->nullable();
			$table->string('operasi')->nullable();
			$table->string('laboratorium')->nullable();
			$table->string('pathway')->nullable();
			$table->string('user');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('dokumen_rekam_medis');
	}
}

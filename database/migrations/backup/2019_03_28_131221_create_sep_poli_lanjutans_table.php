<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepPoliLanjutansTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sep_poli_lanjutans', function (Blueprint $table) {
			$table->increments('id');
			$table->string('kode_poli', 20);
			$table->string('nama_poli');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sep_poli_lanjutans');
	}
}

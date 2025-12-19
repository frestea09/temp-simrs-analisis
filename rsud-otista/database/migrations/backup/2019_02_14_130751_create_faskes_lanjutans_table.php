<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaskesLanjutansTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('faskes_lanjutans', function (Blueprint $table) {
			$table->increments('id');
			$table->string('kode_ppk', 10)->unique();
			$table->string('nama_ppk');
			$table->string('alamat');
			$table->string('kab_kota', 100);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('faskes_lanjutans');
	}
}

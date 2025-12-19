<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikGudangsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('logistik_gudangs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('kode', 10)->unique();
			$table->string('nama')->unique();
			$table->string('bagian');
			$table->string('kepala');
			$table->string('tipe', 10);
			$table->string('penanggungjawab');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('logistik_gudangs');
	}
}

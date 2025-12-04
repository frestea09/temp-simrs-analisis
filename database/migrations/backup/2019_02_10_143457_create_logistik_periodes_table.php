<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikPeriodesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('logistik_periodes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nama');
			$table->date('periodeAwal');
			$table->date('periodeAkhir');
			$table->date('transaksiAwal');
			$table->date('transaksiAkhir');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('logistik_periodes');
	}
}

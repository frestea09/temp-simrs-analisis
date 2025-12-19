<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikPermintaansTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('logistik_permintaans', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nomor', 10);
			$table->date('tanggal_permintaan');
			$table->integer('gudang_id');
			$table->integer('masterobat_id');
			$table->integer('jumlah_permintaan');
			$table->integer('sisa_stock');
			$table->string('keterangan');
			$table->integer('user_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('logistik_permintaans');
	}
}

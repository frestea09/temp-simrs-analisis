<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikSuppliersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('logistik_suppliers', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nama', 100);
			$table->string('alamat');
			$table->string('telepon', 15);
			$table->string('nohp', 20)->unique();
			$table->enum('status', ['1', '0'])->default('1');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('logistik_suppliers');
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiologiEkspertisesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('radiologi_ekspertises', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('registrasi_id');
			$table->string('no_dokument');
			$table->text('ekspertise');
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
		Schema::dropIfExists('radiologi_ekspertises');
	}
}

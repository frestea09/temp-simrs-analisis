<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColomn extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registrasis', function (Blueprint $table) {
				$table->integer('antrian_id')->unsigned()->after('user_create');
				$table->string('rjtl')->after('antrian_id')->nullable();
				$table->string('kepesertaan')->after('rjtl')->nullable();
				$table->string('hakkelas')->after('kepesertaan')->nullable();
				$table->string('nomorrujukan')->after('hakkelas')->nullable();
				$table->date('tglrujukan')->after('nomorrujukan')->nullable();
				$table->string('kodeasal')->after('tglrujukan')->nullable();
				$table->string('catatan')->after('kodeasal')->nullable();
				$table->char('kecelakaan')->after('catatan')->nullable();
				$table->string('jkn', 10)->after('kecelakaan')->nullable();
				$table->string('no_jkn')->after('jkn')->nullable();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('registrasis');
	}
}

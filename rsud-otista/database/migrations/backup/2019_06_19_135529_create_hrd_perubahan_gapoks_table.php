<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdPerubahanGapoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_perubahan_gapoks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->string('jenis', 10)->nullable();
            $table->string('nosk', 50)->nullable();
            $table->date('tglsk')->nullable();
            $table->date('tmt')->nullable();
            $table->integer('gajipokok')->nullable();
            $table->timestamps();

            $table->foreign('biodata_id')->references('id')->on('hrd_biodatas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrd_perubahan_gapoks');
    }
}

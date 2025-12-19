<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdPenghargaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_penghargaans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->string('namapenghargaan', 100)->nullable();
            $table->string('nosk', 50)->nullable();
            $table->date('tglsk')->nullable();
            $table->string('asalpenghargaan', 100)->nullable();
            $table->string('pemberipenghargaan', 100)->nullable();
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
        Schema::dropIfExists('hrd_penghargaans');
    }
}

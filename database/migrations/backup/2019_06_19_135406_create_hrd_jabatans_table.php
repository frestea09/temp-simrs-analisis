<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_jabatans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->string('namajabatan', 50)->nullable();
            $table->string('fungsionaltertentu', 100)->nullable();
            $table->string('unitorganisasi', 100)->nullable();
            $table->string('unitkerja', 100)->nullable();
            $table->string('eselon', 10)->nullable();
            $table->string('pangkat', 50)->nullable();
            $table->string('golongan', 10)->nullable();
            $table->date('tglsk')->nullable();
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
        Schema::dropIfExists('hrd_jabatans');
    }
}

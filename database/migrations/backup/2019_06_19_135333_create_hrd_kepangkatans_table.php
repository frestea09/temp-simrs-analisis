<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdKepangkatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_kepangkatans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->string('jenis', 30)->nullable();
            $table->string('pangkat', 50)->nullable();
            $table->string('golongan', 10)->nullable();
            $table->string('nosk', 50)->nullable();
            $table->date('tglsk')->nullable();
            $table->date('tmtpangkat')->nullable();
            $table->string('mkgtahun', 4)->nullable();
            $table->string('mkgbulan', 2)->nullable();
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
        Schema::dropIfExists('hrd_kepangkatans');
    }
}

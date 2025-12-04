<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopyResepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copy_reseps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_resep')->unique();
            $table->integer('kamar_id')->nullable();
            $table->string('pembuat_resep');
            $table->integer('user_id');
            $table->integer('registrasi_id');
            $table->integer('dokter_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copy_reseps');
    }
}

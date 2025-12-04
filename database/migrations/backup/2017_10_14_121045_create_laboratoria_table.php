<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratoria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('labkategori_id')->unsigned();
            $table->foreign('labkategori_id')->references('id')->on('labkategoris')->onDelete('cascade');
            $table->string('nama');
            $table->float('nilairujukanbawah');
            $table->float('nilairujukanatas');
            $table->string('satuan');
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
        Schema::dropIfExists('laboratoria');
    }
}

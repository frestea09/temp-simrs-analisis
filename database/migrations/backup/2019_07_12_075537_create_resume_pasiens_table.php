<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_pasiens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registrasi_id');
            $table->string('tekanandarah', 100);
            $table->string('bb', 50);
            $table->text('diagnosa');
            $table->text('tindakan');
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
        Schema::dropIfExists('resume_pasiens');
    }
}

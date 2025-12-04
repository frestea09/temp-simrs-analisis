<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdPendidikanFormalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_pendidikan_formals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biodata_id')->unsigned();
            $table->integer('pendidikan_id')->unsigned();
            $table->string('jurusan')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('status', 30)->nullable();
            $table->string('akreditasi', 10)->nullable();
            $table->string('alamatsekolah')->nullable();
            $table->date('tglsttb')->nullable();
            $table->char('tahunmasuk', 4)->nullable();
            $table->char('tahunlulus', 4)->nullable();
            $table->timestamps();

            $table->foreign('biodata_id')->references('id')->on('hrd_biodatas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pendidikan_id')->references('id')->on('pendidikans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrd_pendidikan_formals');
    }
}

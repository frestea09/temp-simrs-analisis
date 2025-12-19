<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdBiodatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_biodatas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namalengkap');
            $table->string('tmplahir', 100)->nullable();
            $table->date('tgllahir')->nullable();
            $table->enum('kelamin', ['L','P'])->nullable();
            $table->string('goldarah', 4)->nullable();
            $table->string('suku', 100)->nullable();
            $table->integer('agama_id')->unsigned();
            $table->string('warganegara')->nullable();
            $table->string('statuskawin')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('province_id', 2)->unsigned();
            $table->integer('regency_id', 4)->unsigned();
            $table->integer('district_id', 7)->unsigned();
            $table->integer('village_id', 10)->unsigned();
            $table->string('notlp', 30)->nullable();
            $table->string('nohp', 30)->nullable();
            $table->string('kdpos', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('gelar_dpn', 30)->nullable();
            $table->string('gelar_blk', 30)->nullable();
            $table->date('tmtcpns')->nullable();
            $table->string('dupeg')->nullable();
            $table->string('nokartupegawai', 30)->nullable();
            $table->string('noktp', 30)->nullable();
            $table->string('noaskes', 30)->nullable();
            $table->string('notaspen', 30)->nullable();
            $table->string('npwp', 30)->nullable();
            $table->string('nokarsu', 30)->nullable();
            $table->string('jenisfungsional')->nullable();
            $table->string('fungsional')->nullable();
            $table->string('fungsionaltertentu')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('agama_id')->references('id')->on('agamas')->onDelete('cascade')->onUpdate( 'cascade');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade')->onUpdate( 'cascade');
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade')->onUpdate( 'cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate( 'cascade');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade')->onUpdate( 'cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrd_biodatas');
    }
}

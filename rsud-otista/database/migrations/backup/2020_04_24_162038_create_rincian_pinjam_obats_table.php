<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRincianPinjamObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_pinjam_obats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('masterobat_id');
            $table->integer('logistik_batch_id');
            $table->integer('logistik_pinjam_obat_id');
            $table->integer('jumlah');
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
        Schema::dropIfExists('rincian_pinjam_obats');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopyResepDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copy_resep_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_resep');
            $table->integer('penjualan_id');
            $table->integer('masterobat_id');
            // $table->integer('logistik_batch_id');
            $table->integer('jumlah');
            $table->integer('retur_inacbg');
            $table->integer('jml_kronis');
            $table->integer('retur_kronis');
            $table->integer('hargajual');
            $table->integer('hargajual_kronis');
            $table->string('etiket');
            $table->char('cetak')->default('Y');
            $table->string('tipe_rawat');
            $table->string('informasi1');
            $table->date('expired');
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copy_resep_details');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturObatRusaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_obat_rusaks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('masterobat_id');
            $table->integer('logistik_batch_id');
            $table->integer('supplier_id');
            $table->integer('gudang_id');
            $table->integer('jumlahretur');
            $table->string('keterangan');
            $table->enum('status', ['diterima', 'ditolak',  'belum'])->default('belum');
            $table->date('tgl_diterima');
            $table->string('nama_penerima');
            $table->integer('user_gudang_pusat');
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
        Schema::dropIfExists('retur_obat_rusaks');
    }
}

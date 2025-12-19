<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogistikBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistik_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('masterobat_id');
            $table->integer('gudang_id');
            $table->integer('supplier_id');
            $table->integer('user_id');
            $table->string('nomorbatch');
            $table->string('expireddate');
            $table->integer('stok');
            $table->decimal('hargajual_umum');
            $table->decimal('hargajual_jkn');
            $table->decimal('hargajual_dinas');
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
        Schema::dropIfExists('logistik_batches');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('alamat');
            $table->string('website');
            $table->string('email');
            $table->string('logo');
            $table->enum('bayardepan', ['Y', 'N']);
            $table->enum('kasirtindakan', ['Y', 'N']);
            $table->string('antrianfooter');
            $table->char('tahuntarif', 4);
            $table->char('panjangkodepasien',1);
            $table->string('ipsep');
            $table->string('usersep');
            $table->string('ipinacbg');
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
        Schema::dropIfExists('configs');
    }
}

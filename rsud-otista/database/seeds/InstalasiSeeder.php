<?php

use Illuminate\Database\Seeder;
use Modules\Instalasi\Entities\Instalasi;

class InstalasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++)
        {
            Instalasi::create(['nama'=>'instalasi'.$i]);
        }
    }
}

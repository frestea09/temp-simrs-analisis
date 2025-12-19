<?php

use Illuminate\Database\Seeder;
use Modules\Config\Entities\Tahuntarif;

class TahuntarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = date('Y'); $i < (date('Y') + 10); $i++)
      {
        Tahuntarif::create(['tahun'=>$i]);
      }
    }
}

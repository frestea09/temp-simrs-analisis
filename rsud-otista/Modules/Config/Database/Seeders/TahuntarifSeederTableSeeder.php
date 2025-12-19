<?php

namespace Modules\Config\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Config\Entities\Tahuntarif;

class TahuntarifSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        for($i=2017; $i >=2030; $i++){
          Tahuntarif::create(['tahun'=>$i]);
        }
    }
}

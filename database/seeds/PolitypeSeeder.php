<?php

use Illuminate\Database\Seeder;
use Modules\Politype\Entities\Politype;

class PolitypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poli1 = Politype::create(['kode'=>'J', 'nama'=>'Rawat Jalan']);
        $poli2 = Politype::create(['kode'=>'I', 'nama'=>'Rawat Rawat Inap']);
        $poli3 = Politype::create(['kode'=>'G', 'nama'=>'IGD']);
    }
}

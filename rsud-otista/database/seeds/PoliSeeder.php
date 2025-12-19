<?php

use Illuminate\Database\Seeder;
use Modules\Poli\Entities\Poli;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poli1 = Poli::create(['nama'=>'Poli Anak','politype_id'=>1, 'flag'=>'N', 'bpjs'=>'ana', 	'instalasi_id'=>1, 'kamar_id'=>1]);
        $poli2 = Poli::create(['nama'=>'Poli Gigi','politype_id'=>1, 'flag'=>'N', 'bpjs'=>'ana', 	'instalasi_id'=>2, 'kamar_id'=>2]);
    }
}

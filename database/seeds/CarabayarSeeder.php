<?php

use Illuminate\Database\Seeder;
use Modules\Registrasi\Entities\Carabayar;

class CarabayarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $byr = Carabayar::create(['carabayar'=>'umum']);
        $byr1 = Carabayar::create(['carabayar'=>'jkn']);
        $byr2 = Carabayar::create(['carabayar'=>'iks']);
    }
}

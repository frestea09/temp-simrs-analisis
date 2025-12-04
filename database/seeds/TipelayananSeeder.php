<?php

use Illuminate\Database\Seeder;
use Modules\Registrasi\Entities\Tipelayanan;

class TipelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tp = Tipelayanan::create(['tipelayanan'=>'Reguler']);
        $tp1 = Tipelayanan::create(['tipelayanan'=>'Eksekutif']);
    }
}

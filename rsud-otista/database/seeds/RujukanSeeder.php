<?php

use Illuminate\Database\Seeder;
use Modules\Registrasi\Entities\Rujukan;

class RujukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r = Rujukan::create(['nama'=>'datang sendiri']);
        $r1 = Rujukan::create(['nama'=>'puskesmas']);
        $r2 = Rujukan::create(['nama'=>'dokter']);
    }
}

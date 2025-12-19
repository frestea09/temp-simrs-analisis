<?php

use Illuminate\Database\Seeder;
use Modules\Kelas\Entities\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kls = Kelas::create(['nama'=>'VVIP']);
        $kls1 = Kelas::create(['nama'=>'VIP']);
        $kls2 = Kelas::create(['nama'=>'Kelas 1']);
        $kls3 = Kelas::create(['nama'=>'Kelas 2']);
        $kls4 = Kelas::create(['nama'=>'Kelas 3']);
    }
}

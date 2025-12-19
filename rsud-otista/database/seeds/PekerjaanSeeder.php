<?php

use Illuminate\Database\Seeder;
use Modules\Pekerjaan\Entities\Pekerjaan;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Pekerjaan();
        $p->nama = 'Buruh';
        $p->save();

        $p1 = new Pekerjaan();
        $p1->nama = 'Petani';
        $p1->save();

        $p2 = new Pekerjaan();
        $p2->nama = 'Karyawan Swasta';
        $p2->save();

        $p3 = new Pekerjaan();
        $p3->nama = 'Pedagang';
        $p3->save();

        $p4 = new Pekerjaan();
        $p4->nama = 'Pengusaha';
        $p4->save();

        $p5 = new Pekerjaan();
        $p5->nama = 'PNS';
        $p5->save();

        $p6 = new Pekerjaan();
        $p6->nama = 'Nelayan';
        $p6->save();
    }
}

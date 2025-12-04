<?php

use Illuminate\Database\Seeder;
use Modules\Pendidikan\Entities\Pendidikan;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Pendidikan();
        $p->pendidikan = 'Sekolah Dasar';
        $p->save();

        $p2 = new Pendidikan();
        $p2->pendidikan = 'Sekolah Menengah Pertama';
        $p2->save();

        $p3 = new Pendidikan();
        $p3->pendidikan = 'Sekolah Menengah Atas';
        $p3->save();

        $p4 = new Pendidikan();
        $p4->pendidikan = 'Diploma 1';
        $p4->save();

        $p5 = new Pendidikan();
        $p5->pendidikan = 'Diploma 3';
        $p5->save();

        $p6 = new Pendidikan();
        $p6->pendidikan = 'Strata 1';
        $p6->save();

        $p7 = new Pendidikan();
        $p7->pendidikan = 'Strata 2';
        $p7->save();

        $p8 = new Pendidikan();
        $p8->pendidikan = 'Strata 3';
        $p8->save();
    }
}

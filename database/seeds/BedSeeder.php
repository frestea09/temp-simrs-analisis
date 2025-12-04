<?php

use Illuminate\Database\Seeder;
use Modules\Bed\Entities\Bed;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bed1 = Bed::create(['kamar_id'=>1, 'nama'=>'Bed-001', 'kode'=>'R001', 'reserved'=>'N', 'keterangan'=>'-']);
        $bed2 = Bed::create(['kamar_id'=>1, 'nama'=>'Bed-002', 'kode'=>'R002', 'reserved'=>'N', 'keterangan'=>'-']);
        $bed3 = Bed::create(['kamar_id'=>2, 'nama'=>'B2-001', 'kode'=>'R001', 'reserved'=>'N', 'keterangan'=>'-']);
        $bed4 = Bed::create(['kamar_id'=>2, 'nama'=>'B2-002', 'kode'=>'R002', 'reserved'=>'N', 'keterangan'=>'-']);
    }
}

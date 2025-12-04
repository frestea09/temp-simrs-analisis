<?php

use Illuminate\Database\Seeder;
use Modules\Kamar\Entities\Kamar;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kamar1 = Kamar::create(['nama'=>'Anggrek', 'kelas_id'=>1]);
        $kamar2 = Kamar::create(['nama'=>'Mawar', 'kelas_id'=>1]);
        $kamar3 = Kamar::create(['nama'=>'Bougenville', 'kelas_id'=>2]);
        $kamar4 = Kamar::create(['nama'=>'Rafflesia', 'kelas_id'=>2]);
        $kamar5 = Kamar::create(['nama'=>'Melati', 'kelas_id'=>3]);
        $kamar6 = Kamar::create(['nama'=>'Kenanga', 'kelas_id'=>3]);

    }
}

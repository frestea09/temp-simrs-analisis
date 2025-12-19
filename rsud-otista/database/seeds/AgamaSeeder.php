<?php

use Illuminate\Database\Seeder;
use Modules\Pasien\Entities\Agama;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $agm = new Agama();
      $agm->agama = 'Islam';
      $agm->save();

      $agm2 = new Agama();
      $agm2->agama = 'Kristen';
      $agm2->save();

      $agm3 = new Agama();
      $agm3->agama = 'Katolik';
      $agm3->save();

      $agm4 = new Agama();
      $agm4->agama = 'Hindu';
      $agm4->save();

      $agm5 = new Agama();
      $agm5->agama = 'Budha';
      $agm5->save();

      $agm6 = new Agama();
      $agm6->agama = 'Konghucu';
      $agm6->save();
    }
}

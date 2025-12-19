<?php

use Illuminate\Database\Seeder;
use Modules\Perusahaan\Entities\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('id_ID');

      $limit = 5;

      for ($i = 0; $i < $limit; $i++)
      {
        $p = new Perusahaan();
        $p->nama = $faker->company;
        $p->alamat = $faker->address;
        $p->kode = $faker->numberBetween(1,1000);
        $p->id_prk = $faker->numberBetween(1,1000);
        $p->diskon = $faker->numberBetween(20,50);
        $p->plafon = $faker->numberBetween(50,70);
        $p->save();
      }
    }
}

<?php

use Illuminate\Database\Seeder;
use Modules\Registrasi\Entities\Dokter;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create('id_ID');
      for($i = 0; $i <= 5; $i++)
      {
        $p = new Dokter();
        $p->user_id = 1;
        $p->nama = $faker->name;
        $p->poli_id = 1;
        $p->save();
      }
    }
}

<?php

use Illuminate\Database\Seeder;
use Modules\Pegawai\Entities\Pegawai;
class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');
        for($i = 0; $i <= 200; $i++)
        {
          $p = new Pegawai();
          $p->nama = $faker->name;
          $p->tgllahir = $faker->date;
          $p->tmplahir = $faker->city;
          $p->kelamin = 'L';
          $p->agama = 'Islam';
          $p->alamat = $faker->address;
          $p->user_id = 1;
          $p->save();
        }
    }
}

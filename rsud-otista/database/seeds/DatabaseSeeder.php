<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(AgamaSeeder::class);
        $this->call(PendidikanSeeder::class);
        $this->call(PerusahaanSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(PekerjaanSeeder::class);
        $this->call(TahuntarifSeeder::class);
        $this->call(InstalasiSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(RujukanSeeder::class);
        $this->call(CarabayarSeeder::class);
        $this->call(TipelayananSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(KamarSeeder::class);
        $this->call(BedSeeder::class);
        $this->call(PolitypeSeeder::class);
        $this->call(SebabsakitSeeder::class);
        $this->call(PoliSeeder::class);
        $this->call(DokterSeeder::class);
    }
}

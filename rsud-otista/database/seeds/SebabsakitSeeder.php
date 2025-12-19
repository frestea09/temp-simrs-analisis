<?php

use Illuminate\Database\Seeder;
use Modules\Sebabsakit\Entities\Sebabsakit;

class SebabsakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sebab1 = Sebabsakit::create(['nama'=>'Kecelakaan']);
        $sebab2 = Sebabsakit::create(['nama'=>'Jatuh']);
    }
}

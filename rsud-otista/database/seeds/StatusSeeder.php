<?php

use Illuminate\Database\Seeder;
use Modules\Registrasi\Entities\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = Status::create(['status'=>'baru']);
        $status1 = Status::create(['status'=>'lama']);
    }
}

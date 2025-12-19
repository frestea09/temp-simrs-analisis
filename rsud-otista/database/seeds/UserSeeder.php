<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Create Administrator role
    $administratorRole = new Role();
    $administratorRole->name = 'administrator';
    $administratorRole->display_name = 'Administrator';
    $administratorRole->save();

    //Create Admin Role
    $adminRole = new Role();
    $adminRole->name = 'admin';
    $adminRole->display_name = 'Admin';
    $adminRole->save();

    //Create staff role
    $staffRole = new Role();
    $staffRole->name = 'staff';
    $staffRole->display_name = 'Staff Administrasi';
    $staffRole->save();

    //Create Administrator User
    $administrator = new User();
    $administrator->name = 'Marsono Saputro';
    $administrator->email = 'marsonosaputro@gmail.com';
    $administrator->password = bcrypt('passwordku');
    $administrator->save();
    $administrator->attachRole($administratorRole);

    //Create Admin User
    $admin = new User();
    $admin->name = 'Admin User';
    $admin->email = 'admin@gmail.com';
    $admin->password = bcrypt('rahasia');
    $admin->save();
    $admin->attachRole($adminRole);

    //Create Staff Users
    $staff = new User();
    $staff->name = 'Staff User';
    $staff->email = 'staff@gmail.com';
    $staff->password = bcrypt('rahasia');
    $staff->save();
    $staff->attachRole($staffRole);
    }
}

<?php

use App\Staff;
use Illuminate\Database\Seeder;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::create([
            'name'      =>  'Joseph Gutierrez',
            'email'     =>  'staff@staff.com',
            'password'  =>  bcrypt('password'),
        ]);
    }
}

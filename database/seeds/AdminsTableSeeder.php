<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'      =>  'Franz Angeles',
            'email'     =>  'admin@admin.com',
            'password'  =>  bcrypt('password'),
        ]);

    }
}

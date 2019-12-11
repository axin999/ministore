<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Axin',
            'email' =>'axin@gmail.com',
            'type' => 'admin',
            'password' => Hash::make('axin4000'),
        ]);
    }
}

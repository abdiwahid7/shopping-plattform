<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Insert a single user
        DB::table('user')->insert([
            'name' => 'maria',
            'email' => 'maria@example.com',
            'password' => Hash::make('123456'),
        ]);
}

}
